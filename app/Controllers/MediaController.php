<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\Storage;
use App\Core\View;
use App\Models\Media;
use RuntimeException;

final class MediaController
{
    /**
     * Admin media library.
     */
    public function index(): string
    {
        $page =
            max(
                1,
                (int) (
                    $_GET['page']
                    ?? 1
                )
            );

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/media/index',
            [
                'title' =>
                    'کتابخانه رسانه | صدرا',

                'media' =>
                    Media::paginate(
                        $page,
                        24
                    ),

                'success' =>
                    Session::getFlash(
                        'success'
                    ),

                'error' =>
                    Session::getFlash(
                        'error'
                    ),
            ]
        );
    }


    /**
     * Upload form.
     */
    public function create(): string
    {
        return View::renderIntoLayout(
            'layouts/admin',
            'admin/media/create',
            [
                'title' =>
                    'افزودن رسانه | صدرا',

                'errors' =>
                    [],
            ]
        );
    }


    /**
     * Store one or multiple uploaded media files.
     */
    public function store(): never
    {
        Csrf::requireValid();

        $userId =
            Session::userId();

        if (
            $userId === null
        ) {
            Response::redirectRoute(
                'teacher.login'
            );
        }


        /*
         * New uploader:
         *
         *     name="media[]"
         *
         * Old uploader:
         *
         *     name="file"
         *
         * Support both.
         */
        $uploadedInput =
            $_FILES['media']
            ?? $_FILES['file']
            ?? null;


        $files =
            $this->normalizeUploadedFiles(
                $uploadedInput
            );


        if (
            $files === []
        ) {
            Session::flash(
                'error',
                'لطفاً حداقل یک فایل انتخاب کنید.'
            );

            Response::redirectRoute(
                'admin.media.create'
            );
        }


        $allowed =
            $this->allowedMimeTypes();


        $altText =
            $this->nullableString(
                $_POST['alt_text']
                ?? null
            );


        $uploadedCount =
            0;


        $failedFiles =
            [];


        foreach (
            $files
            as $file
        ) {

            /*
             * Skip files that PHP rejected before
             * they reached our storage layer.
             */
            $uploadError =
                (int) (
                    $file['error']
                    ?? UPLOAD_ERR_NO_FILE
                );


            if (
                $uploadError !== UPLOAD_ERR_OK
            ) {

                $failedFiles[] =
                    $this->fileName(
                        $file
                    );

                continue;
            }


            try {

                /*
                 * Store the physical file.
                 */
                $stored =
                    Storage::storeUploadedFile(
                        $file,
                        $allowed
                    );


                /*
                 * Register the file in the database.
                 */
                $mediaId =
                    Media::create(
                        [
                            'file_name' =>
                                $stored['file_name'],

                            'original_name' =>
                                $stored['original_name'],

                            'file_path' =>
                                $stored['file_path'],

                            'mime_type' =>
                                $stored['mime_type'],

                            'file_size' =>
                                $stored['file_size'],

                            'alt_text' =>
                                $altText,

                            'width' =>
                                $stored['width']
                                ?? null,

                            'height' =>
                                $stored['height']
                                ?? null,

                            'storage_disk' =>
                                'local',
                        ],
                        $userId
                    );


                /*
                 * Database insertion failed.
                 * Remove the already stored physical file.
                 */
                if (
                    (int) $mediaId <= 0
                ) {

                    Storage::delete(
                        (string) (
                            $stored['file_path']
                            ?? ''
                        )
                    );


                    $failedFiles[] =
                        $this->fileName(
                            $file
                        );

                    continue;
                }


                $uploadedCount++;

            } catch (
                RuntimeException $exception
            ) {

                /*
                 * Do not kill the whole upload because
                 * one file failed.
                 */
                $failedFiles[] =
                    $this->fileName(
                        $file
                    );
            }
        }


        /*
         * Nothing uploaded successfully.
         */
        if (
            $uploadedCount === 0
        ) {

            Session::flash(
                'error',
                'هیچ فایلی با موفقیت آپلود نشد.'
            );

            Response::redirectRoute(
                'admin.media.create'
            );
        }


        /*
         * Success message.
         */
        if (
            $uploadedCount === 1
        ) {

            $successMessage =
                'فایل با موفقیت آپلود شد.';

        } else {

            $successMessage =
                number_format(
                    $uploadedCount
                )
                . ' فایل با موفقیت آپلود شد.';
        }


        /*
         * Let the administrator know if
         * some files failed.
         */
        if (
            $failedFiles !== []
        ) {

            $successMessage .=
                ' برخی فایل‌ها آپلود نشدند: '
                . implode(
                    '، ',
                    $failedFiles
                )
                . '.';
        }


        Session::flash(
            'success',
            $successMessage
        );


        Response::redirectRoute(
            'admin.media.index'
        );
    }


    /**
     * Delete media.
     */
    public function delete(
        string $id
    ): never {
        Csrf::requireValid();


        $mediaId =
            $this->positiveId(
                $id
            );


        $media =
            Media::find(
                $mediaId
            );


        if (
            $media === null
        ) {
            Session::flash(
                'error',
                'فایل مورد نظر پیدا نشد.'
            );

            Response::redirectRoute(
                'admin.media.index'
            );
        }


        $deleted =
            Media::delete(
                $mediaId
            );


        if (
            !$deleted
        ) {
            Session::flash(
                'error',
                'حذف فایل انجام نشد.'
            );

            Response::redirectRoute(
                'admin.media.index'
            );
        }


        Storage::delete(
            (string) (
                $media['file_path']
                ?? ''
            )
        );


        Session::flash(
            'success',
            'فایل با موفقیت حذف شد.'
        );


        Response::redirectRoute(
            'admin.media.index'
        );
    }


    /**
     * Serve a stored media file.
     */
    public function serve(
        string $encodedPath
    ): never {
        $decoded =
            base64_decode(
                $encodedPath,
                true
            );


        if (
            $decoded === false
            || $decoded === ''
        ) {
            Response::notFound(
                'فایل پیدا نشد.'
            );
        }


        $relativePath =
            $this->normalizePath(
                $decoded
            );


        if (
            $relativePath === ''
        ) {
            Response::notFound(
                'فایل پیدا نشد.'
            );
        }


        $uploadDirectory =
            realpath(
                Storage::ensureUploadDirectory()
            );


        if (
            $uploadDirectory === false
        ) {
            Response::notFound(
                'فایل پیدا نشد.'
            );
        }


        $fullPath =
            $uploadDirectory
            . DIRECTORY_SEPARATOR
            . str_replace(
                '/',
                DIRECTORY_SEPARATOR,
                $relativePath
            );


        $realPath =
            realpath(
                $fullPath
            );


        if (
            $realPath === false
            || !is_file(
                $realPath
            )
        ) {
            Response::notFound(
                'فایل پیدا نشد.'
            );
        }


        $uploadRoot =
            rtrim(
                $uploadDirectory,
                DIRECTORY_SEPARATOR
            )
            . DIRECTORY_SEPARATOR;


        if (
            !str_starts_with(
                $realPath,
                $uploadRoot
            )
        ) {
            Response::notFound(
                'فایل پیدا نشد.'
            );
        }


        $mime =
            $this->detectMimeType(
                $realPath
            );


        $size =
            filesize(
                $realPath
            );


        if (
            $size === false
        ) {
            $size = 0;
        }


        header(
            'Content-Type: '
            . $mime
        );


        header(
            'Content-Length: '
            . $size
        );


        header(
            'X-Content-Type-Options: nosniff'
        );


        header(
            'Cache-Control: public, max-age=31536000, immutable'
        );


        readfile(
            $realPath
        );


        exit;
    }


    /**
     * Normalize PHP's $_FILES structure.
     *
     * Supports both:
     *
     * $_FILES['file']
     *
     * and:
     *
     * $_FILES['media']
     *
     * where media is a multiple-file field.
     *
     * @return array<int, array<string, mixed>>
     */
    private function normalizeUploadedFiles(
        mixed $input
    ): array {
        if (
            !is_array(
                $input
            )
        ) {
            return [];
        }


        /*
         * Single file upload.
         */
        if (
            isset(
                $input['name']
            )
            && is_string(
                $input['name']
            )
        ) {

            return [
                $input,
            ];
        }


        /*
         * Multiple file upload.
         */
        $names =
            $input['name']
            ?? [];


        if (
            !is_array(
                $names
            )
        ) {
            return [];
        }


        $types =
            $input['type']
            ?? [];


        $tmpNames =
            $input['tmp_name']
            ?? [];


        $errors =
            $input['error']
            ?? [];


        $sizes =
            $input['size']
            ?? [];


        $files =
            [];


        foreach (
            $names
            as $index =>
            $name
        ) {

            if (
                !is_string(
                    $name
                )
            ) {
                continue;
            }


            $files[] = [
                'name' =>
                    $name,

                'type' =>
                    $types[$index]
                    ?? '',

                'tmp_name' =>
                    $tmpNames[$index]
                    ?? '',

                'error' =>
                    $errors[$index]
                    ?? UPLOAD_ERR_NO_FILE,

                'size' =>
                    $sizes[$index]
                    ?? 0,
            ];
        }


        return $files;
    }


    /**
     * Safely get a file name.
     */
    private function fileName(
        array $file
    ): string {
        $name =
            $file['name']
            ?? 'فایل نامشخص';


        if (
            !is_string(
                $name
            )
            || trim(
                $name
            ) === ''
        ) {
            return 'فایل نامشخص';
        }


        return trim(
            $name
        );
    }


    /**
     * Allowed MIME types.
     *
     * @return array<int, string>
     */
    private function allowedMimeTypes(): array
    {
        $images =
            config(
                'app.uploads.allowed_images',
                []
            );


        $documents =
            config(
                'app.uploads.allowed_documents',
                []
            );


        return array_values(
            array_unique(
                array_merge(
                    is_array(
                        $images
                    )
                        ? $images
                        : [],

                    is_array(
                        $documents
                    )
                        ? $documents
                        : []
                )
            )
        );
    }


    /**
     * Detect file MIME type.
     */
    private function detectMimeType(
        string $path
    ): string {
        $finfo =
            new \finfo(
                FILEINFO_MIME_TYPE
            );


        $mime =
            $finfo->file(
                $path
            );


        return (
            is_string(
                $mime
            )
            && $mime !== ''
        )
            ? $mime
            : 'application/octet-stream';
    }


    /**
     * Normalize a media path.
     */
    private function normalizePath(
        string $path
    ): string {
        $path =
            str_replace(
                '\\',
                '/',
                trim(
                    $path
                )
            );


        $parts =
            explode(
                '/',
                $path
            );


        $safe =
            [];


        foreach (
            $parts
            as $part
        ) {

            if (
                $part === ''
                || $part === '.'
                || $part === '..'
            ) {
                continue;
            }


            $safe[] =
                $part;
        }


        return implode(
            '/',
            $safe
        );
    }


    /**
     * Nullable text input.
     */
    private function nullableString(
        mixed $value
    ): ?string {
        if (
            !is_string(
                $value
            )
        ) {
            return null;
        }


        $value =
            trim(
                $value
            );


        return $value === ''
            ? null
            : $value;
    }


    /**
     * Positive route ID.
     */
    private function positiveId(
        string $id
    ): int {
        $value =
            filter_var(
                $id,
                FILTER_VALIDATE_INT,
                [
                    'options' => [
                        'min_range' => 1,
                    ],
                ]
            );


        if (
            $value === false
        ) {
            Response::notFound(
                'شناسه فایل معتبر نیست.'
            );
        }


        return (int) $value;
    }
}
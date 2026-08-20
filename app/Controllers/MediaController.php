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
                    'آپلود رسانه | صدرا',

                'errors' => [],
            ]
        );
    }

    /**
     * Store uploaded media.
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

        $file =
            $_FILES['file']
            ?? null;

        if (
            !is_array($file)
        ) {
            Session::flash(
                'error',
                'لطفاً یک فایل انتخاب کنید.'
            );

            Response::redirectRoute(
                'admin.media.create'
            );
        }

        try {
            $allowed =
                $this->allowedMimeTypes();

            $stored =
                Storage::storeUploadedFile(
                    $file,
                    $allowed
                );

            $altText =
                $this->nullableString(
                    $_POST['alt_text']
                    ?? null
                );

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
                            $stored['width'],

                        'height' =>
                            $stored['height'],

                        'storage_disk' =>
                            'local',
                    ],
                    $userId
                );

        } catch (
            RuntimeException $exception
        ) {
            Session::flash(
                'error',
                $exception->getMessage()
            );

            Response::redirectRoute(
                'admin.media.create'
            );
        }

        /*
         * Database insertion should not silently fail
         * after the physical file has been stored.
         */
        if (
            !isset($mediaId)
            || (int) $mediaId <= 0
        ) {
            Storage::delete(
                $stored['file_path']
            );

            Session::flash(
                'error',
                'ثبت فایل در پایگاه داده انجام نشد.'
            );

            Response::redirectRoute(
                'admin.media.create'
            );
        }

        Session::flash(
            'success',
            'فایل با موفقیت آپلود شد.'
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

        if (
            !str_starts_with(
                $realPath,
                rtrim(
                    $uploadDirectory,
                    DIRECTORY_SEPARATOR
                )
                . DIRECTORY_SEPARATOR
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
                    is_array($images)
                        ? $images
                        : [],

                    is_array($documents)
                        ? $documents
                        : []
                )
            )
        );
    }

    /**
     * Detect file MIME.
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

        return is_string($mime)
            && $mime !== ''
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
                trim($path)
            );

        $parts =
            explode(
                '/',
                $path
            );

        $safe = [];

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
            !is_string($value)
        ) {
            return null;
        }

        $value =
            trim($value);

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
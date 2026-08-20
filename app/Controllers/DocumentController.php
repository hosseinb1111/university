<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\Storage;
use App\Core\View;
use App\Models\Document;
use RuntimeException;

final class DocumentController
{
    /**
     * Admin document list.
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
            'admin/documents/index',
            [
                'title' =>
                    'اسناد و فرم‌ها | صدرا',

                'documents' =>
                    Document::paginate(
                        $page,
                        20
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
     * Create document form.
     */
    public function create(): string
    {
        return View::renderIntoLayout(
            'layouts/admin',
            'admin/documents/create',
            [
                'title' =>
                    'افزودن سند | صدرا',

                'categories' =>
                    Document::categories(),

                'errors' =>
                    [],
            ]
        );
    }

    /**
     * Store document.
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

        $data =
            $this->input();

        $errors =
            $this->validate(
                $data
            );

        if (
            $errors !== []
        ) {
            Session::flash(
                'document_errors',
                $errors
            );

            Session::flash(
                'document_form',
                $data
            );

            Response::redirectRoute(
                'admin.documents.create'
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
                'admin.documents.create'
            );
        }

        try {
            $stored =
                Storage::storeUploadedFile(
                    $file,
                    $this->allowedMimeTypes()
                );

            $documentId =
                Document::create(
                    [
                        'category_id' =>
                            $data['category_id'],

                        'title' =>
                            $data['title'],

                        'description' =>
                            $data['description'],

                        'file_path' =>
                            $stored['file_path'],

                        'file_name' =>
                            $stored['original_name'],

                        'mime_type' =>
                            $stored['mime_type'],

                        'file_size' =>
                            $stored['file_size'],

                        'is_active' =>
                            $data['is_active'],

                        'published_at' =>
                            $data['published_at'],
                    ],
                    $userId
                );

        } catch (
            RuntimeException $exception
        ) {
            Session::flash(
                'document_form',
                $data
            );

            Session::flash(
                'error',
                $exception->getMessage()
            );

            Response::redirectRoute(
                'admin.documents.create'
            );
        }

        if (
            !isset(
                $documentId
            )
            || (int) $documentId <= 0
        ) {
            Storage::delete(
                $stored['file_path']
            );

            Session::flash(
                'error',
                'ثبت سند در پایگاه داده انجام نشد.'
            );

            Response::redirectRoute(
                'admin.documents.create'
            );
        }

        Session::flash(
            'success',
            'سند با موفقیت ایجاد شد.'
        );

        Response::redirectRoute(
            'admin.documents.index'
        );
    }

    /**
     * Edit document.
     */
    public function edit(
        string $id
    ): string {
        $documentId =
            $this->positiveId(
                $id
            );

        $document =
            Document::find(
                $documentId
            );

        if (
            $document === null
        ) {
            Response::notFound(
                'سند مورد نظر پیدا نشد.'
            );
        }

        $form =
            Session::getFlash(
                'document_form'
            );

        $errors =
            Session::getFlash(
                'document_errors'
            );

        if (
            is_array($form)
        ) {
            $document =
                array_merge(
                    $document,
                    $form
                );
        }

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/documents/edit',
            [
                'title' =>
                    'ویرایش سند | صدرا',

                'document' =>
                    $document,

                'categories' =>
                    Document::categories(),

                'errors' =>
                    is_array($errors)
                        ? $errors
                        : [],
            ]
        );
    }

    /**
     * Update document metadata and optionally replace file.
     */
    public function update(
        string $id
    ): never {
        Csrf::requireValid();

        $documentId =
            $this->positiveId(
                $id
            );

        $existing =
            Document::find(
                $documentId
            );

        if (
            $existing === null
        ) {
            Response::notFound(
                'سند مورد نظر پیدا نشد.'
            );
        }

        $userId =
            Session::userId();

        if (
            $userId === null
        ) {
            Response::redirectRoute(
                'teacher.login'
            );
        }

        $data =
            $this->input();

        $errors =
            $this->validate(
                $data
            );

        if (
            $errors !== []
        ) {
            Session::flash(
                'document_errors',
                $errors
            );

            Session::flash(
                'document_form',
                $data
            );

            Response::redirectRoute(
                'admin.documents.edit',
                [
                    'id' =>
                        $documentId,
                ]
            );
        }

        $newFile =
            null;

        if (
            isset(
                $_FILES['file']
            )
            && is_array(
                $_FILES['file']
            )
            && (
                (int) (
                    $_FILES['file']['error']
                    ?? UPLOAD_ERR_NO_FILE
                )
                !== UPLOAD_ERR_NO_FILE
            )
        ) {
            try {
                $newFile =
                    Storage::storeUploadedFile(
                        $_FILES['file'],
                        $this->allowedMimeTypes()
                    );
            } catch (
                RuntimeException $exception
            ) {
                Session::flash(
                    'document_form',
                    $data
                );

                Session::flash(
                    'error',
                    $exception->getMessage()
                );

                Response::redirectRoute(
                    'admin.documents.edit',
                    [
                        'id' =>
                            $documentId,
                    ]
                );
            }
        }

        $updated =
            Document::update(
                $documentId,
                $data,
                $userId
            );

        if (
            !$updated
        ) {
            if (
                is_array($newFile)
            ) {
                Storage::delete(
                    $newFile['file_path']
                );
            }

            Session::flash(
                'error',
                'ویرایش سند انجام نشد.'
            );

            Response::redirectRoute(
                'admin.documents.edit',
                [
                    'id' =>
                        $documentId,
                ]
            );
        }

        if (
            is_array($newFile)
        ) {
            $fileUpdated =
                Document::replaceFile(
                    $documentId,
                    [
                        'file_path' =>
                            $newFile['file_path'],

                        'file_name' =>
                            $newFile['original_name'],

                        'mime_type' =>
                            $newFile['mime_type'],

                        'file_size' =>
                            $newFile['file_size'],
                    ],
                    $userId
                );

            if (
                !$fileUpdated
            ) {
                Storage::delete(
                    $newFile['file_path']
                );

                Session::flash(
                    'error',
                    'اطلاعات فایل جدید ثبت نشد.'
                );

                Response::redirectRoute(
                    'admin.documents.edit',
                    [
                        'id' =>
                            $documentId,
                    ]
                );
            }

            /*
             * Delete the old physical file only after
             * the database now points to the new one.
             */
            Storage::delete(
                (string) (
                    $existing['file_path']
                    ?? ''
                )
            );
        }

        Session::flash(
            'success',
            'سند با موفقیت ویرایش شد.'
        );

        Response::redirectRoute(
            'admin.documents.index'
        );
    }

    /**
     * Delete document and file.
     */
    public function delete(
        string $id
    ): never {
        Csrf::requireValid();

        $documentId =
            $this->positiveId(
                $id
            );

        $document =
            Document::find(
                $documentId
            );

        if (
            $document === null
        ) {
            Session::flash(
                'error',
                'سند مورد نظر پیدا نشد.'
            );

            Response::redirectRoute(
                'admin.documents.index'
            );
        }

        $deleted =
            Document::delete(
                $documentId
            );

        if (
            !$deleted
        ) {
            Session::flash(
                'error',
                'حذف سند انجام نشد.'
            );

            Response::redirectRoute(
                'admin.documents.index'
            );
        }

        Storage::delete(
            (string) (
                $document['file_path']
                ?? ''
            )
        );

        Session::flash(
            'success',
            'سند با موفقیت حذف شد.'
        );

        Response::redirectRoute(
            'admin.documents.index'
        );
    }

    /**
     * Public documents.
     */
    public function publicIndex(): string
    {
        return View::renderIntoLayout(
            'layouts/app',
            'documents/index',
            [
                'title' =>
                    'اسناد و فرم‌ها | صدرا',

                'description' =>
                    'فرم‌ها، آیین‌نامه‌ها و اسناد رسمی موسسه.',

                'categories' =>
                    Document::categories(),
            ]
        );
    }

    /**
     * Public category.
     */
    public function category(
        string $category
    ): string {
        $categoryRecord =
            Document::findCategoryBySlug(
                $category
            );

        if (
            $categoryRecord === null
        ) {
            Response::notFound(
                'دسته اسناد پیدا نشد.'
            );
        }

        return View::renderIntoLayout(
            'layouts/app',
            'documents/category',
            [
                'title' =>
                    (string) $categoryRecord['name']
                    . ' | اسناد | صدرا',

                'description' =>
                    (string) (
                        $categoryRecord['description']
                        ?? ''
                    ),

                'category' =>
                    $categoryRecord,

                'documents' =>
                    Document::byCategory(
                        (int) $categoryRecord['id']
                    ),
            ]
        );
    }

    /**
     * Download / view a public document.
     */
    public function download(
        string $category,
        string $id
    ): never {
        $documentId =
            $this->positiveId(
                $id
            );

        $document =
            Document::find(
                $documentId
            );

        if (
            $document === null
            || (int) (
                $document['is_active']
                ?? 0
            ) !== 1
        ) {
            Response::notFound(
                'سند پیدا نشد.'
            );
        }

        if (
            (string) (
                $document['category_slug']
                ?? ''
            ) !== $category
        ) {
            Response::notFound(
                'سند پیدا نشد.'
            );
        }

        $publishedAt =
            $document['published_at']
            ?? null;

        if (
            $publishedAt !== null
            && strtotime(
                (string) $publishedAt
            ) > time()
        ) {
            Response::notFound(
                'سند پیدا نشد.'
            );
        }

        $relativePath =
            (string) (
                $document['file_path']
                ?? ''
            );

        $decoded =
            Storage::publicUrl(
                $relativePath
            );

        /*
         * We already have the physical relative path,
         * so decode the file safely from storage instead
         * of doing an external redirect.
         */
        $baseDirectory =
            realpath(
                Storage::ensureUploadDirectory()
            );

        if (
            $baseDirectory === false
        ) {
            Response::notFound(
                'فایل پیدا نشد.'
            );
        }

        $safePath =
            str_replace(
                '/',
                DIRECTORY_SEPARATOR,
                trim(
                    $relativePath,
                    '/\\'
                )
            );

        $fullPath =
            $baseDirectory
            . DIRECTORY_SEPARATOR
            . $safePath;

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

        $rootPrefix =
            rtrim(
                $baseDirectory,
                DIRECTORY_SEPARATOR
            )
            . DIRECTORY_SEPARATOR;

        if (
            !str_starts_with(
                $realPath,
                $rootPrefix
            )
        ) {
            Response::notFound(
                'فایل پیدا نشد.'
            );
        }

        $finfo =
            new \finfo(
                FILEINFO_MIME_TYPE
            );

        $mime =
            $finfo->file(
                $realPath
            );

        if (
            !is_string($mime)
            || $mime === ''
        ) {
            $mime =
                'application/octet-stream';
        }

        $size =
            filesize(
                $realPath
            );

        if (
            $size === false
        ) {
            $size = 0;
        }

        Document::incrementDownloadCount(
            $documentId
        );

        $filename =
            basename(
                (string) (
                    $document['file_name']
                    ?? 'document'
                )
            );

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
            'Content-Disposition: inline; filename="'
            . rawurlencode(
                $filename
            )
            . '"'
        );

        header(
            'Cache-Control: private, max-age=0, must-revalidate'
        );

        readfile(
            $realPath
        );

        exit;
    }

    /**
     * Read submitted document data.
     *
     * @return array<string, mixed>
     */
    private function input(): array
    {
        return [
            'category_id' =>
                (int) (
                    $_POST['category_id']
                    ?? 0
                ),

            'title' =>
                trim(
                    (string) (
                        $_POST['title']
                        ?? ''
                    )
                ),

            'description' =>
                $this->nullableString(
                    $_POST['description']
                    ?? null
                ),

            'is_active' =>
                isset(
                    $_POST['is_active']
                )
                    ? 1
                    : 0,

            'published_at' =>
                $this->normalizeDateTime(
                    $_POST['published_at']
                    ?? null
                ),
        ];
    }

    /**
     * Validate document metadata.
     *
     * @param array<string, mixed> $data
     *
     * @return array<string, string>
     */
    private function validate(
        array $data
    ): array {
        $errors = [];

        if (
            (int) (
                $data['category_id']
                ?? 0
            ) <= 0
        ) {
            $errors['category_id'] =
                'انتخاب دسته‌بندی الزامی است.';
        }

        $title =
            trim(
                (string) (
                    $data['title']
                    ?? ''
                )
            );

        if (
            $title === ''
        ) {
            $errors['title'] =
                'عنوان سند الزامی است.';
        } elseif (
            mb_strlen(
                $title,
                'UTF-8'
            ) > 255
        ) {
            $errors['title'] =
                'عنوان سند نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.';
        }

        $publishedAt =
            $data['published_at']
            ?? null;

        if (
            is_string(
                $publishedAt
            )
            && $publishedAt !== ''
            && strtotime(
                $publishedAt
            ) === false
        ) {
            $errors['published_at'] =
                'تاریخ انتشار معتبر نیست.';
        }

        return $errors;
    }

    /**
     * Allowed document MIME types.
     *
     * @return array<int, string>
     */
    private function allowedMimeTypes(): array
    {
        $configured =
            config(
                'app.uploads.allowed_documents',
                []
            );

        if (
            !is_array(
                $configured
            )
        ) {
            return [];
        }

        return array_values(
            array_filter(
                $configured,
                static fn (
                    mixed $value
                ): bool =>
                    is_string(
                        $value
                    )
                    && trim(
                        $value
                    ) !== ''
            )
        );
    }

    /**
     * Normalize nullable text.
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
     * Normalize datetime-local input.
     */
    private function normalizeDateTime(
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

        if (
            $value === ''
        ) {
            return null;
        }

        $timestamp =
            strtotime(
                $value
            );

        if (
            $timestamp === false
        ) {
            return $value;
        }

        return date(
            'Y-m-d H:i:s',
            $timestamp
        );
    }

    /**
     * Positive integer route ID.
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
                'شناسه سند معتبر نیست.'
            );
        }

        return (int) $value;
    }
}
<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\Storage;
use App\Core\View;
use App\Models\HomepageService;
use RuntimeException;

final class HomepageServiceController
{
    /**
     * Display the admin service list.
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

        $services =
            HomepageService::paginate(
                $page,
                20
            );

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/services/index',
            [
                'title' =>
                    'خدمات صفحه اصلی | صدرا',

                'services' =>
                    $services,

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
     * Show create form.
     */
    public function create(): string
    {
        $form =
            Session::getFlash(
                'service_form'
            );

        $formErrors =
            Session::getFlash(
                'service_errors'
            );

        $item = [
            'title' =>
                '',

            'url' =>
                '',

            'image' =>
                '',

            'sort_order' =>
                0,

            'is_active' =>
                1,
        ];

        if (
            is_array($form)
        ) {
            $item =
                array_merge(
                    $item,
                    $form
                );
        }

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/services/create',
            [
                'title' =>
                    'ایجاد خدمت | صدرا',

                'item' =>
                    $item,

                'errors' =>
                    is_array($formErrors)
                        ? $formErrors
                        : [],

                'action' =>
                    View::route(
                        'admin.services.store'
                    ),

                'submitLabel' =>
                    'ایجاد خدمت',
            ]
        );
    }

    /**
     * Store a new service.
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
                'service_form',
                $data
            );

            Session::flash(
                'service_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.services.create'
            );
        }

        try {
            $data['image'] =
                $this->uploadImage(
                    'image'
                );

            HomepageService::create(
                $data,
                $userId
            );
        } catch (
            RuntimeException $exception
        ) {
            Session::flash(
                'service_form',
                $data
            );

            Session::flash(
                'error',
                $exception->getMessage()
            );

            Response::redirectRoute(
                'admin.services.create'
            );
        }

        Session::flash(
            'success',
            'خدمت با موفقیت ایجاد شد.'
        );

        Response::redirectRoute(
            'admin.services.index'
        );
    }

    /**
     * Show edit form.
     */
    public function edit(
        string $id
    ): string {
        $serviceId =
            $this->positiveId(
                $id
            );

        $item =
            HomepageService::find(
                $serviceId
            );

        if (
            $item === null
        ) {
            Response::notFound(
                'خدمت مورد نظر پیدا نشد.'
            );
        }

        $form =
            Session::getFlash(
                'service_form'
            );

        $formErrors =
            Session::getFlash(
                'service_errors'
            );

        if (
            is_array($form)
        ) {
            $item =
                array_merge(
                    $item,
                    $form
                );
        }

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/services/edit',
            [
                'title' =>
                    'ویرایش خدمت | صدرا',

                'item' =>
                    $item,

                'errors' =>
                    is_array($formErrors)
                        ? $formErrors
                        : [],

                'action' =>
                    View::route(
                        'admin.services.update',
                        [
                            'id' =>
                                $serviceId,
                        ]
                    ),

                'submitLabel' =>
                    'ذخیره تغییرات',
            ]
        );
    }

    /**
     * Update an existing service.
     */
    public function update(
        string $id
    ): never {
        Csrf::requireValid();

        $serviceId =
            $this->positiveId(
                $id
            );

        $existing =
            HomepageService::find(
                $serviceId
            );

        if (
            $existing === null
        ) {
            Response::notFound(
                'خدمت مورد نظر پیدا نشد.'
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
                'service_form',
                $data
            );

            Session::flash(
                'service_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.services.edit',
                [
                    'id' =>
                        $serviceId,
                ]
            );
        }

        try {
            $data['image'] =
                $this->uploadImage(
                    'image',
                    $this->nullableString(
                        $existing['image']
                        ?? null
                    )
                );

            $updated =
                HomepageService::update(
                    $serviceId,
                    $data,
                    $userId
                );
        } catch (
            RuntimeException $exception
        ) {
            Session::flash(
                'service_form',
                $data
            );

            Session::flash(
                'error',
                $exception->getMessage()
            );

            Response::redirectRoute(
                'admin.services.edit',
                [
                    'id' =>
                        $serviceId,
                ]
            );
        }

        if (
            !$updated
        ) {
            Session::flash(
                'error',
                'ویرایش خدمت انجام نشد.'
            );

            Response::redirectRoute(
                'admin.services.edit',
                [
                    'id' =>
                        $serviceId,
                ]
            );
        }

        Session::flash(
            'success',
            'خدمت با موفقیت ویرایش شد.'
        );

        Response::redirectRoute(
            'admin.services.index'
        );
    }

    /**
     * Delete a service.
     */
    public function delete(
        string $id
    ): never {
        Csrf::requireValid();

        $serviceId =
            $this->positiveId(
                $id
            );

        $existing =
            HomepageService::find(
                $serviceId
            );

        if (
            $existing === null
        ) {
            Session::flash(
                'error',
                'خدمت مورد نظر پیدا نشد.'
            );

            Response::redirectRoute(
                'admin.services.index'
            );
        }

        $deleted =
            HomepageService::delete(
                $serviceId
            );

        if (
            !$deleted
        ) {
            Session::flash(
                'error',
                'حذف خدمت انجام نشد.'
            );

            Response::redirectRoute(
                'admin.services.index'
            );
        }

        Session::flash(
            'success',
            'خدمت با موفقیت حذف شد.'
        );

        Response::redirectRoute(
            'admin.services.index'
        );
    }

    /**
     * Read submitted form data.
     *
     * @return array<string, mixed>
     */
    private function input(): array
    {
        return [
            'title' =>
                trim(
                    (string) (
                        $_POST['title']
                        ?? ''
                    )
                ),

            'url' =>
                trim(
                    (string) (
                        $_POST['url']
                        ?? ''
                    )
                ),

            'sort_order' =>
                max(
                    0,
                    (int) (
                        $_POST['sort_order']
                        ?? 0
                    )
                ),

            'is_active' =>
                isset(
                    $_POST['is_active']
                )
                    ? 1
                    : 0,
        ];
    }

    /**
     * Validate service data.
     *
     * @param array<string, mixed> $data
     *
     * @return array<string, string>
     */
    private function validate(
        array $data
    ): array {
        $errors = [];

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
                'عنوان الزامی است.';
        } elseif (
            mb_strlen(
                $title,
                'UTF-8'
            ) > 255
        ) {
            $errors['title'] =
                'عنوان نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.';
        }

        $url =
            trim(
                (string) (
                    $data['url']
                    ?? ''
                )
            );

        if (
            $url === ''
        ) {
            $errors['url'] =
                'لینک الزامی است.';
        } elseif (
            mb_strlen(
                $url,
                'UTF-8'
            ) > 500
        ) {
            $errors['url'] =
                'لینک نمی‌تواند بیشتر از ۵۰۰ کاراکتر باشد.';
        } elseif (
            !$this->validUrl($url)
        ) {
            $errors['url'] =
                'لینک معتبر نیست.';
        }

        return $errors;
    }

    /**
     * Store uploaded image.
     */
    private function uploadImage(
        string $field,
        ?string $existingPath = null
    ): ?string {
        $file =
            $_FILES[$field]
            ?? null;

        if (
            !is_array($file)
            || (
                (int) (
                    $file['error']
                    ?? UPLOAD_ERR_NO_FILE
                )
            ) === UPLOAD_ERR_NO_FILE
        ) {
            return $existingPath;
        }

        $allowed =
            config(
                'app.uploads.allowed_images',
                []
            );

        $stored =
            Storage::storeUploadedFile(
                $file,
                is_array($allowed)
                    ? $allowed
                    : []
            );

        return Storage::publicUrl(
            (string) (
                $stored['file_path']
                ?? ''
            )
        );
    }

    /**
     * Validate local or HTTP(S) URL.
     */
    private function validUrl(
        string $value
    ): bool {
        $value =
            trim(
                $value
            );

        if (
            $value === ''
        ) {
            return false;
        }

        if (
            str_starts_with(
                $value,
                '/'
            )
            && !str_starts_with(
                $value,
                '//'
            )
        ) {
            return true;
        }

        $parsed =
            parse_url(
                $value
            );

        if (
            !is_array(
                $parsed
            )
        ) {
            return false;
        }

        $scheme =
            strtolower(
                (string) (
                    $parsed['scheme']
                    ?? ''
                )
            );

        $host =
            $parsed['host']
            ?? null;

        return in_array(
            $scheme,
            [
                'http',
                'https',
            ],
            true
        )
        && is_string($host)
        && $host !== '';
    }

    /**
     * Convert empty values to null.
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
     * Validate positive route ID.
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
                'شناسه خدمت معتبر نیست.'
            );
        }

        return (int) $value;
    }
}
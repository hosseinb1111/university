<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\Storage;
use App\Core\View;
use App\Models\EnglishHomepageService;
use RuntimeException;

final class EnglishHomepageServiceController
{
    /**
     * English homepage service list.
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
            'admin/english/services/index',
            [
                'title' =>
                    'English Homepage Services | صدرا',

                'services' =>
                    EnglishHomepageService::paginate(
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
     * Create service form.
     */
    public function create(): string
    {
        $form =
            Session::getFlash(
                'english_service_form'
            );

        $errors =
            Session::getFlash(
                'english_service_errors'
            );

        $service = [
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
            $service =
                array_merge(
                    $service,
                    $form
                );
        }

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/english/services/create',
            [
                'title' =>
                    'Create English Homepage Service | صدرا',

                'service' =>
                    $service,

                'errors' =>
                    is_array($errors)
                        ? $errors
                        : [],

                'action' =>
                    View::route(
                        'admin.english.services.store'
                    ),

                'submitLabel' =>
                    'Create Service',
            ]
        );
    }

    /**
     * Store service.
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
                'english_service_form',
                $data
            );

            Session::flash(
                'english_service_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.english.services.create'
            );
        }

        try {
            $data['image'] =
                $this->uploadImage(
                    'image'
                );

            EnglishHomepageService::create(
                $data,
                $userId
            );
        } catch (
            RuntimeException $exception
        ) {
            Session::flash(
                'english_service_form',
                $data
            );

            Session::flash(
                'error',
                $exception->getMessage()
            );

            Response::redirectRoute(
                'admin.english.services.create'
            );
        }

        Session::flash(
            'success',
            'English homepage service created successfully.'
        );

        Response::redirectRoute(
            'admin.english.services.index'
        );
    }

    /**
     * Edit service.
     */
    public function edit(
        string $id
    ): string {
        $serviceId =
            $this->positiveId(
                $id
            );

        $service =
            EnglishHomepageService::find(
                $serviceId
            );

        if (
            $service === null
        ) {
            Response::notFound(
                'English homepage service not found.'
            );
        }

        $form =
            Session::getFlash(
                'english_service_form'
            );

        $errors =
            Session::getFlash(
                'english_service_errors'
            );

        if (
            is_array($form)
        ) {
            $service =
                array_merge(
                    $service,
                    $form
                );
        }

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/english/services/edit',
            [
                'title' =>
                    'Edit English Homepage Service | صدرا',

                'service' =>
                    $service,

                'errors' =>
                    is_array($errors)
                        ? $errors
                        : [],

                'action' =>
                    View::route(
                        'admin.english.services.update',
                        [
                            'id' =>
                                $serviceId,
                        ]
                    ),

                'submitLabel' =>
                    'Save Changes',
            ]
        );
    }

    /**
     * Update service.
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
            EnglishHomepageService::find(
                $serviceId
            );

        if (
            $existing === null
        ) {
            Response::notFound(
                'English homepage service not found.'
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
                'english_service_form',
                $data
            );

            Session::flash(
                'english_service_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.english.services.edit',
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
                EnglishHomepageService::update(
                    $serviceId,
                    $data,
                    $userId
                );
        } catch (
            RuntimeException $exception
        ) {
            Session::flash(
                'english_service_form',
                $data
            );

            Session::flash(
                'error',
                $exception->getMessage()
            );

            Response::redirectRoute(
                'admin.english.services.edit',
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
                'English homepage service update failed.'
            );

            Response::redirectRoute(
                'admin.english.services.edit',
                [
                    'id' =>
                        $serviceId,
                ]
            );
        }

        Session::flash(
            'success',
            'English homepage service updated successfully.'
        );

        Response::redirectRoute(
            'admin.english.services.index'
        );
    }

    /**
     * Delete service.
     */
    public function delete(
        string $id
    ): never {
        Csrf::requireValid();

        $serviceId =
            $this->positiveId(
                $id
            );

        $service =
            EnglishHomepageService::find(
                $serviceId
            );

        if (
            $service === null
        ) {
            Session::flash(
                'error',
                'English homepage service not found.'
            );

            Response::redirectRoute(
                'admin.english.services.index'
            );
        }

        $deleted =
            EnglishHomepageService::delete(
                $serviceId
            );

        if (
            !$deleted
        ) {
            Session::flash(
                'error',
                'English homepage service could not be deleted.'
            );

            Response::redirectRoute(
                'admin.english.services.index'
            );
        }

        Session::flash(
            'success',
            'English homepage service deleted successfully.'
        );

        Response::redirectRoute(
            'admin.english.services.index'
        );
    }

    /**
     * Read service form.
     *
     * @return array<string, mixed>
     */
    private function input(): array
    {
        return [
            'title' =>
                $this->nullableString(
                    $_POST['title']
                    ?? null
                ),

            'url' =>
                $this->nullableString(
                    $_POST['url']
                    ?? null
                ),

            'image' =>
                $this->nullableString(
                    $_POST['image']
                    ?? null
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
     * Validate service.
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
                'Title is required.';
        } elseif (
            mb_strlen(
                $title,
                'UTF-8'
            ) > 255
        ) {
            $errors['title'] =
                'Title cannot exceed 255 characters.';
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
                'URL is required.';
        } elseif (
            !$this->validUrl(
                $url
            )
        ) {
            $errors['url'] =
                'Service URL is invalid.';
        }

        return $errors;
    }

    /**
     * Upload service image.
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
     * Validate local or absolute URL.
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
            !is_array($parsed)
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
     * Empty string to null.
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
            trim(
                $value
            );

        return $value === ''
            ? null
            : $value;
    }

    /**
     * Validate positive ID.
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
                'Invalid English service ID.'
            );
        }

        return (int) $value;
    }
}
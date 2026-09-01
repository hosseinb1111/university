<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\Storage;
use App\Core\View;
use App\Models\EnglishHomepageSlide;
use RuntimeException;

final class EnglishHomepageSlideController
{
    /**
     * English homepage slide list.
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
            'admin/english/slides/index',
            [
                'title' =>
                    'English Homepage Slides | صدرا',

                'slides' =>
                    EnglishHomepageSlide::paginate(
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
     * Create English slide form.
     */
    public function create(): string
    {
        $form =
            Session::getFlash(
                'english_slide_form'
            );

        $errors =
            Session::getFlash(
                'english_slide_errors'
            );

        $slide = [
            'title' =>
                '',

            'subtitle' =>
                '',

            'description' =>
                '',

            'button_text' =>
                '',

            'button_url' =>
                '',

            'image' =>
                '',

            'mobile_image' =>
                '',

            'sort_order' =>
                0,

            'is_active' =>
                1,
        ];

        if (
            is_array($form)
        ) {
            $slide =
                array_merge(
                    $slide,
                    $form
                );
        }

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/english/slides/create',
            [
                'title' =>
                    'Create English Homepage Slide | صدرا',

                'slide' =>
                    $slide,

                'errors' =>
                    is_array($errors)
                        ? $errors
                        : [],

                'action' =>
                    View::route(
                        'admin.english.slides.store'
                    ),

                'submitLabel' =>
                    'Create Slide',
            ]
        );
    }

    /**
     * Store English slide.
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
                'english_slide_form',
                $data
            );

            Session::flash(
                'english_slide_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.english.slides.create'
            );
        }

        try {
            $data['image'] =
                $this->uploadImage(
                    'image'
                );

            $data['mobile_image'] =
                $this->uploadImage(
                    'mobile_image'
                );

            EnglishHomepageSlide::create(
                $data,
                $userId
            );
        } catch (
            RuntimeException $exception
        ) {
            Session::flash(
                'english_slide_form',
                $data
            );

            Session::flash(
                'error',
                $exception->getMessage()
            );

            Response::redirectRoute(
                'admin.english.slides.create'
            );
        }

        Session::flash(
            'success',
            'English homepage slide created successfully.'
        );

        Response::redirectRoute(
            'admin.english.slides.index'
        );
    }

    /**
     * Edit English slide.
     */
    public function edit(
        string $id
    ): string {
        $slideId =
            $this->positiveId(
                $id
            );

        $slide =
            EnglishHomepageSlide::find(
                $slideId
            );

        if (
            $slide === null
        ) {
            Response::notFound(
                'English homepage slide not found.'
            );
        }

        $form =
            Session::getFlash(
                'english_slide_form'
            );

        $errors =
            Session::getFlash(
                'english_slide_errors'
            );

        if (
            is_array($form)
        ) {
            $slide =
                array_merge(
                    $slide,
                    $form
                );
        }

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/english/slides/edit',
            [
                'title' =>
                    'Edit English Homepage Slide | صدرا',

                'slide' =>
                    $slide,

                'errors' =>
                    is_array($errors)
                        ? $errors
                        : [],

                'action' =>
                    View::route(
                        'admin.english.slides.update',
                        [
                            'id' =>
                                $slideId,
                        ]
                    ),

                'submitLabel' =>
                    'Save Changes',
            ]
        );
    }

    /**
     * Update English slide.
     */
    public function update(
        string $id
    ): never {
        Csrf::requireValid();

        $slideId =
            $this->positiveId(
                $id
            );

        $existing =
            EnglishHomepageSlide::find(
                $slideId
            );

        if (
            $existing === null
        ) {
            Response::notFound(
                'English homepage slide not found.'
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
                'english_slide_form',
                $data
            );

            Session::flash(
                'english_slide_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.english.slides.edit',
                [
                    'id' =>
                        $slideId,
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

            $data['mobile_image'] =
                $this->uploadImage(
                    'mobile_image',
                    $this->nullableString(
                        $existing['mobile_image']
                        ?? null
                    )
                );

            $updated =
                EnglishHomepageSlide::update(
                    $slideId,
                    $data,
                    $userId
                );
        } catch (
            RuntimeException $exception
        ) {
            Session::flash(
                'english_slide_form',
                $data
            );

            Session::flash(
                'error',
                $exception->getMessage()
            );

            Response::redirectRoute(
                'admin.english.slides.edit',
                [
                    'id' =>
                        $slideId,
                ]
            );
        }

        if (
            !$updated
        ) {
            Session::flash(
                'error',
                'English homepage slide update failed.'
            );

            Response::redirectRoute(
                'admin.english.slides.edit',
                [
                    'id' =>
                        $slideId,
                ]
            );
        }

        Session::flash(
            'success',
            'English homepage slide updated successfully.'
        );

        Response::redirectRoute(
            'admin.english.slides.index'
        );
    }

    /**
     * Delete English slide.
     */
    public function delete(
        string $id
    ): never {
        Csrf::requireValid();

        $slideId =
            $this->positiveId(
                $id
            );

        $slide =
            EnglishHomepageSlide::find(
                $slideId
            );

        if (
            $slide === null
        ) {
            Session::flash(
                'error',
                'English homepage slide not found.'
            );

            Response::redirectRoute(
                'admin.english.slides.index'
            );
        }

        $deleted =
            EnglishHomepageSlide::delete(
                $slideId
            );

        if (
            !$deleted
        ) {
            Session::flash(
                'error',
                'English homepage slide could not be deleted.'
            );

            Response::redirectRoute(
                'admin.english.slides.index'
            );
        }

        Session::flash(
            'success',
            'English homepage slide deleted successfully.'
        );

        Response::redirectRoute(
            'admin.english.slides.index'
        );
    }

    /**
     * Read form input.
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

            'subtitle' =>
                $this->nullableString(
                    $_POST['subtitle']
                    ?? null
                ),

            'description' =>
                $this->nullableString(
                    $_POST['description']
                    ?? null
                ),

            'button_text' =>
                $this->nullableString(
                    $_POST['button_text']
                    ?? null
                ),

            'button_url' =>
                $this->nullableString(
                    $_POST['button_url']
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
     * Validate English slide.
     *
     * @param array<string, mixed> $data
     *
     * @return array<string, string>
     */
    private function validate(
        array $data
    ): array {
        $errors = [];

        foreach (
            [
                'title' =>
                    'Title',

                'subtitle' =>
                    'Subtitle',

                'button_text' =>
                    'Button text',
            ]
            as $field => $label
        ) {
            $value =
                $data[$field]
                ?? null;

            if (
                is_string($value)
                && mb_strlen(
                    $value,
                    'UTF-8'
                ) > 255
            ) {
                $errors[$field] =
                    $label
                    . ' cannot exceed 255 characters.';
            }
        }

        $buttonUrl =
            $data['button_url']
            ?? null;

        if (
            is_string($buttonUrl)
            && $buttonUrl !== ''
            && !$this->validUrl(
                $buttonUrl
            )
        ) {
            $errors['button_url'] =
                'Button URL is invalid.';
        }

        return $errors;
    }

    /**
     * Upload an English slide image.
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
     * Validate URL.
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
            return true;
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
                'Invalid English slide ID.'
            );
        }

        return (int) $value;
    }
}
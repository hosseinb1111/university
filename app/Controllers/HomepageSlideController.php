<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\Storage;
use App\Core\View;
use App\Models\HomepageSlide;
use RuntimeException;

final class HomepageSlideController
{
    /**
     * Display the admin slide list.
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

        $slides =
            HomepageSlide::paginate(
                $page,
                20
            );

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/slides/index',
            [
                'title' =>
                    'اسلایدر صفحه اصلی | صدرا',

                'slides' =>
                    $slides,

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
                'slide_form'
            );

        $formErrors =
            Session::getFlash(
                'slide_errors'
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

            'starts_at' =>
                '',

            'ends_at' =>
                '',
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
            'admin/slides/create',
            [
                'title' =>
                    'ایجاد اسلاید | صدرا',

                'slide' =>
                    $slide,

                'errors' =>
                    is_array($formErrors)
                        ? $formErrors
                        : [],

                /*
                 * IMPORTANT:
                 * The create form must POST to the store route,
                 * not back to /admin/slides/create.
                 */
                'action' =>
                    View::route(
                        'admin.slides.store'
                    ),

                'submitLabel' =>
                    'ایجاد اسلاید',
            ]
        );
    }

    /**
     * Store a new slide.
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
                'slide_form',
                $data
            );

            Session::flash(
                'slide_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.slides.create'
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

            HomepageSlide::create(
                $data,
                $userId
            );
        } catch (
            RuntimeException $exception
        ) {
            Session::flash(
                'slide_form',
                $data
            );

            Session::flash(
                'error',
                $exception->getMessage()
            );

            Response::redirectRoute(
                'admin.slides.create'
            );
        }

        Session::flash(
            'success',
            'اسلاید با موفقیت ایجاد شد.'
        );

        Response::redirectRoute(
            'admin.slides.index'
        );
    }

    /**
     * Show edit form.
     */
    public function edit(
        string $id
    ): string {
        $slideId =
            $this->positiveId(
                $id
            );

        $slide =
            HomepageSlide::find(
                $slideId
            );

        if (
            $slide === null
        ) {
            Response::notFound(
                'اسلاید مورد نظر پیدا نشد.'
            );
        }

        $form =
            Session::getFlash(
                'slide_form'
            );

        $formErrors =
            Session::getFlash(
                'slide_errors'
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
            'admin/slides/edit',
            [
                'title' =>
                    'ویرایش اسلاید | صدرا',

                'slide' =>
                    $slide,

                'errors' =>
                    is_array($formErrors)
                        ? $formErrors
                        : [],

                /*
                 * IMPORTANT:
                 * The edit form must POST to the update route.
                 */
                'action' =>
                    View::route(
                        'admin.slides.update',
                        [
                            'id' =>
                                $slideId,
                        ]
                    ),

                'submitLabel' =>
                    'ذخیره تغییرات',
            ]
        );
    }

    /**
     * Update an existing slide.
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
            HomepageSlide::find(
                $slideId
            );

        if (
            $existing === null
        ) {
            Response::notFound(
                'اسلاید مورد نظر پیدا نشد.'
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
                'slide_form',
                $data
            );

            Session::flash(
                'slide_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.slides.edit',
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
                HomepageSlide::update(
                    $slideId,
                    $data,
                    $userId
                );
        } catch (
            RuntimeException $exception
        ) {
            Session::flash(
                'slide_form',
                $data
            );

            Session::flash(
                'error',
                $exception->getMessage()
            );

            Response::redirectRoute(
                'admin.slides.edit',
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
                'ویرایش اسلاید انجام نشد.'
            );

            Response::redirectRoute(
                'admin.slides.edit',
                [
                    'id' =>
                        $slideId,
                ]
            );
        }

        Session::flash(
            'success',
            'اسلاید با موفقیت ویرایش شد.'
        );

        Response::redirectRoute(
            'admin.slides.index'
        );
    }

    /**
     * Delete a slide.
     */
    public function delete(
        string $id
    ): never {
        Csrf::requireValid();

        $slideId =
            $this->positiveId(
                $id
            );

        $existing =
            HomepageSlide::find(
                $slideId
            );

        if (
            $existing === null
        ) {
            Session::flash(
                'error',
                'اسلاید مورد نظر پیدا نشد.'
            );

            Response::redirectRoute(
                'admin.slides.index'
            );
        }

        $deleted =
            HomepageSlide::delete(
                $slideId
            );

        if (
            !$deleted
        ) {
            Session::flash(
                'error',
                'حذف اسلاید انجام نشد.'
            );

            Response::redirectRoute(
                'admin.slides.index'
            );
        }

        Session::flash(
            'success',
            'اسلاید با موفقیت حذف شد.'
        );

        Response::redirectRoute(
            'admin.slides.index'
        );
    }

    /**
     * Read submitted form data.
     *
     * Note: 'image' / 'mobile_image' are intentionally NOT read here.
     * They come from $_FILES and are handled by uploadImage() after
     * validation, inside store()/update().
     *
     * @return array<string, mixed>
     */
    private function input(): array
    {
        return [
            /*
             * Title is optional.
             */
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
     * Validate submitted slide.
     *
     * @param array<string, mixed> $data
     *
     * @return array<string, string>
     */
    private function validate(
        array $data
    ): array {
        $errors = [];

        /*
         * Title is optional.
         */
        $title =
            $data['title']
            ?? null;

        if (
            is_string($title)
            && mb_strlen(
                $title,
                'UTF-8'
            ) > 255
        ) {
            $errors['title'] =
                'عنوان اسلاید نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.';
        }

        $subtitle =
            $data['subtitle']
            ?? null;

        if (
            is_string($subtitle)
            && mb_strlen(
                $subtitle,
                'UTF-8'
            ) > 255
        ) {
            $errors['subtitle'] =
                'زیرعنوان نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.';
        }

        $buttonText =
            $data['button_text']
            ?? null;

        if (
            is_string($buttonText)
            && mb_strlen(
                $buttonText,
                'UTF-8'
            ) > 255
        ) {
            $errors['button_text'] =
                'متن دکمه نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.';
        }

        /*
         * Button URL is optional.
         */
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
                'لینک دکمه معتبر نیست.';
        }

        return $errors;
    }

    /**
     * Handle a single uploaded image field.
     *
     * If no file was submitted for this field, the existing stored
     * path (if any) is kept as-is. This preserves the current image
     * on edit when the admin leaves the file input empty.
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
     * Validate a local or HTTP(S) URL.
     *
     * Still used for button_url.
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

        /*
         * Internal application paths.
         */
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

        /*
         * Absolute HTTP(S) URL.
         */
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
     * Convert empty strings into null.
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
     * Validate a positive route ID.
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
                'شناسه اسلاید معتبر نیست.'
            );
        }

        return (int) $value;
    }
}
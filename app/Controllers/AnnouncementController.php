<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Announcement;

final class AnnouncementController
{
    /**
     * Admin announcement list.
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

        $result =
            Announcement::paginate(
                $page,
                20
            );

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/announcements/index',
            [
                'title' =>
                    'مدیریت اطلاعیه‌ها | صدرا',

                'announcements' =>
                    $result,

                'success' =>
                    $this->successMessage(),
            ]
        );
    }


    /**
     * Create form.
     */
    public function create(): string
    {
        /*
         * Restore the admin's previously typed Jalali input
         * after failed validation.
         */
        $form =
            Session::getFlash(
                'announcement_form'
            );

        $formErrors =
            Session::getFlash(
                'announcement_errors'
            );


        $announcement = [
            'title' =>
                '',

            'slug' =>
                '',

            'excerpt' =>
                '',

            'content' =>
                '',

            'featured_image' =>
                '',

            'status' =>
                'draft',

            'priority' =>
                0,

            'published_at' =>
                '',

            'expires_at' =>
                '',
        ];


        if (
            is_array($form)
        ) {
            $announcement =
                array_merge(
                    $announcement,
                    $form
                );
        }


        return View::renderIntoLayout(
            'layouts/admin',
            'admin/announcements/create',
            [
                'title' =>
                    'ایجاد اطلاعیه | صدرا',

                'announcement' =>
                    $announcement,

                'errors' =>
                    is_array(
                        $formErrors
                    )
                        ? $formErrors
                        : [],
            ]
        );
    }


    /**
     * Store announcement.
     */
    public function store(): never
    {
        Csrf::requireValid();


        $data =
            $this->collectInput();


        $errors =
            $this->validate(
                $data
            );


        if (
            $errors !== []
        ) {
            Session::flash(
                'announcement_form',
                $data
            );

            Session::flash(
                'announcement_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.announcements.create'
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


        /*
         * Admin input is Jalali.
         * Database remains Gregorian DATETIME.
         */
        $data['published_at'] =
            jalali_parse_datetime(
                $data['published_at']
            );

        $data['expires_at'] =
            jalali_parse_datetime(
                $data['expires_at']
            );


        Announcement::create(
            $data,
            $userId
        );


        Response::redirect(
            '/admin/announcements?success=created'
        );
    }


    /**
     * Edit form.
     */
    public function edit(
        string $id
    ): string {
        $announcement =
            Announcement::find(
                (int) $id
            );


        if (
            $announcement === null
        ) {
            Response::notFound(
                'اطلاعیه مورد نظر پیدا نشد.'
            );
        }


        $form =
            Session::getFlash(
                'announcement_form'
            );

        $formErrors =
            Session::getFlash(
                'announcement_errors'
            );


        if (
            is_array($form)
        ) {
            /*
             * Failed validation.
             * Keep original Jalali input.
             */
            $announcement =
                array_merge(
                    $announcement,
                    $form
                );

        } else {

            /*
             * Existing database values are Gregorian.
             * Convert them back to Jalali for editing.
             */
            $announcement['published_at'] =
                jalali_date(
                    $announcement['published_at']
                    ?? null,
                    'Y/m/d H:i'
                );

            $announcement['expires_at'] =
                jalali_date(
                    $announcement['expires_at']
                    ?? null,
                    'Y/m/d H:i'
                );
        }


        return View::renderIntoLayout(
            'layouts/admin',
            'admin/announcements/edit',
            [
                'title' =>
                    'ویرایش اطلاعیه | صدرا',

                'announcement' =>
                    $announcement,

                'errors' =>
                    is_array(
                        $formErrors
                    )
                        ? $formErrors
                        : [],
            ]
        );
    }


    /**
     * Update announcement.
     */
    public function update(
        string $id
    ): never {
        Csrf::requireValid();


        $announcementId =
            (int) $id;


        $announcement =
            Announcement::find(
                $announcementId
            );


        if (
            $announcement === null
        ) {
            Response::notFound(
                'اطلاعیه مورد نظر پیدا نشد.'
            );
        }


        $data =
            $this->collectInput();


        $errors =
            $this->validate(
                $data,
                $announcementId
            );


        if (
            $errors !== []
        ) {
            Session::flash(
                'announcement_form',
                $data
            );

            Session::flash(
                'announcement_errors',
                $errors
            );

            Response::redirect(
                '/admin/announcements/'
                . $announcementId
                . '/edit'
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


        $data['published_at'] =
            jalali_parse_datetime(
                $data['published_at']
            );

        $data['expires_at'] =
            jalali_parse_datetime(
                $data['expires_at']
            );


        Announcement::update(
            $announcementId,
            $data,
            $userId
        );


        Response::redirect(
            '/admin/announcements?success=updated'
        );
    }


    /**
     * Delete announcement.
     */
    public function delete(
        string $id
    ): never {
        Csrf::requireValid();


        $announcementId =
            (int) $id;


        $announcement =
            Announcement::find(
                $announcementId
            );


        if (
            $announcement === null
        ) {
            Response::notFound(
                'اطلاعیه مورد نظر پیدا نشد.'
            );
        }


        Announcement::delete(
            $announcementId
        );


        Response::redirect(
            '/admin/announcements?success=deleted'
        );
    }


    /**
     * Publish announcement.
     */
    public function publish(
        string $id
    ): never {
        Csrf::requireValid();


        $announcementId =
            (int) $id;


        $announcement =
            Announcement::find(
                $announcementId
            );


        if (
            $announcement === null
        ) {
            Response::notFound(
                'اطلاعیه مورد نظر پیدا نشد.'
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


        Announcement::publish(
            $announcementId,
            $userId
        );


        Response::redirect(
            '/admin/announcements?success=published'
        );
    }


    /**
     * Archive announcement.
     */
    public function archive(
        string $id
    ): never {
        Csrf::requireValid();


        $announcementId =
            (int) $id;


        $announcement =
            Announcement::find(
                $announcementId
            );


        if (
            $announcement === null
        ) {
            Response::notFound(
                'اطلاعیه مورد نظر پیدا نشد.'
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


        Announcement::archive(
            $announcementId,
            $userId
        );


        Response::redirect(
            '/admin/announcements?success=archived'
        );
    }


    /**
     * Public announcement listing.
     *
     * We intentionally use a larger window here than the
     * previous 50-item limit so older published announcements
     * do not silently disappear from the public page.
     *
     * NOTE:
     * Announcement::latest() still applies its published/date
     * filtering. A draft, future-dated, or expired announcement
     * will therefore still remain hidden, which is correct.
     */
    public function publicIndex(): string
    {
        $announcements =
            Announcement::latest(
                200
            );


        return View::renderIntoLayout(
            'layouts/app',
            'announcements/index',
            [
                'title' =>
                    'اطلاعیه‌ها | موسسه آموزش عالی صدرالمتالهین',

                'announcements' =>
                    is_array(
                        $announcements
                    )
                        ? $announcements
                        : [],
            ]
        );
    }


    /**
     * Public announcement details.
     */
    public function show(
        string $slug
    ): string {
        $slug =
            trim(
                $slug
            );


        if (
            $slug === ''
        ) {
            Response::notFound(
                'اطلاعیه مورد نظر پیدا نشد.'
            );
        }


        $announcement =
            Announcement::findPublishedBySlug(
                $slug
            );


        if (
            $announcement === null
        ) {
            Response::notFound(
                'اطلاعیه مورد نظر پیدا نشد.'
            );
        }


        $title =
            trim(
                (string) (
                    $announcement['title']
                    ?? ''
                )
            );


        if (
            $title === ''
        ) {
            $title =
                'اطلاعیه';
        }


        return View::renderIntoLayout(
            'layouts/app',
            'announcements/show',
            [
                'title' =>
                    $title
                    . ' | صدرا',

                'announcement' =>
                    $announcement,
            ]
        );
    }


    /**
     * Collect form input.
     *
     * @return array<string, mixed>
     */
    private function collectInput(): array
    {
        $title =
            trim(
                (string) (
                    $_POST['title']
                    ?? ''
                )
            );


        $slug =
            trim(
                (string) (
                    $_POST['slug']
                    ?? ''
                )
            );


        if (
            $slug === ''
        ) {
            $slug =
                Announcement::generateUniqueSlug(
                    $title
                );
        } else {
            $slug =
                Announcement::slugify(
                    $slug
                );
        }


        $status =
            (string) (
                $_POST['status']
                ?? 'draft'
            );


        if (
            !in_array(
                $status,
                [
                    'draft',
                    'published',
                    'archived',
                ],
                true
            )
        ) {
            $status =
                'draft';
        }


        $priority =
            (int) (
                $_POST['priority']
                ?? 0
            );


        return [
            'title' =>
                $title,

            'slug' =>
                $slug,

            'excerpt' =>
                $this->nullableString(
                    $_POST['excerpt']
                    ?? null
                ),

            'content' =>
                $this->nullableString(
                    $_POST['content']
                    ?? null
                ),

            'featured_image' =>
                $this->nullableString(
                    $_POST['featured_image']
                    ?? null
                ),

            'status' =>
                $status,

            'priority' =>
                max(
                    -1000,
                    min(
                        1000,
                        $priority
                    )
                ),

            /*
             * Raw Jalali strings.
             */
            'published_at' =>
                $this->nullableString(
                    $_POST['published_at']
                    ?? null
                ),

            'expires_at' =>
                $this->nullableString(
                    $_POST['expires_at']
                    ?? null
                ),
        ];
    }


    /**
     * Validate announcement input.
     *
     * @param array<string, mixed> $data
     *
     * @return array<string, string>
     */
    private function validate(
        array $data,
        ?int $ignoreId = null
    ): array {
        $errors = [];


        $title =
            trim(
                (string) (
                    $data['title']
                    ?? ''
                )
            );


        $slug =
            trim(
                (string) (
                    $data['slug']
                    ?? ''
                )
            );


        $content =
            trim(
                (string) (
                    $data['content']
                    ?? ''
                )
            );


        if (
            $title === ''
        ) {
            $errors['title'] =
                'عنوان اطلاعیه الزامی است.';

        } elseif (
            mb_strlen(
                $title,
                'UTF-8'
            ) > 255
        ) {
            $errors['title'] =
                'عنوان نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.';
        }


        if (
            $slug === ''
        ) {
            $errors['slug'] =
                'لطفاً یک آدرس معتبر وارد کنید.';

        } elseif (
            mb_strlen(
                $slug,
                'UTF-8'
            ) > 255
        ) {
            $errors['slug'] =
                'آدرس نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.';

        } elseif (
            Announcement::slugExists(
                $slug,
                $ignoreId
            )
        ) {
            $errors['slug'] =
                'این آدرس قبلاً استفاده شده است.';
        }


        if (
            $content === ''
        ) {
            $errors['content'] =
                'متن اطلاعیه الزامی است.';
        }


        $status =
            (string) (
                $data['status']
                ?? ''
            );


        if (
            !in_array(
                $status,
                [
                    'draft',
                    'published',
                    'archived',
                ],
                true
            )
        ) {
            $errors['status'] =
                'وضعیت انتخاب شده معتبر نیست.';
        }


        /*
         * Jalali date validation.
         */
        $publishedAt =
            $data['published_at']
            ?? null;


        if (
            !jalali_is_valid_datetime_input(
                $publishedAt
            )
        ) {
            $errors['published_at'] =
                'تاریخ انتشار معتبر نیست.';
        }


        $expiresAt =
            $data['expires_at']
            ?? null;


        if (
            !jalali_is_valid_datetime_input(
                $expiresAt
            )
        ) {
            $errors['expires_at'] =
                'تاریخ انقضا معتبر نیست.';
        }


        /*
         * Expiration must be after publication.
         */
        if (
            !isset(
                $errors['published_at']
            )
            && !isset(
                $errors['expires_at']
            )
            && is_string(
                $publishedAt
            )
            && trim(
                $publishedAt
            ) !== ''
            && is_string(
                $expiresAt
            )
            && trim(
                $expiresAt
            ) !== ''
        ) {

            $publishedGregorian =
                jalali_parse_datetime(
                    $publishedAt
                );

            $expiresGregorian =
                jalali_parse_datetime(
                    $expiresAt
                );


            if (
                $publishedGregorian !== null
                && $expiresGregorian !== null
                && $expiresGregorian <= $publishedGregorian
            ) {
                $errors['expires_at'] =
                    'تاریخ انقضا باید بعد از تاریخ انتشار باشد.';
            }
        }


        return $errors;
    }


    /**
     * Normalize nullable string.
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
     * Get operation message from URL.
     */
    private function successMessage(): ?string
    {
        $messages = [
            'created' =>
                'اطلاعیه با موفقیت ایجاد شد.',

            'updated' =>
                'اطلاعیه با موفقیت ویرایش شد.',

            'deleted' =>
                'اطلاعیه با موفقیت حذف شد.',

            'published' =>
                'اطلاعیه منتشر شد.',

            'archived' =>
                'اطلاعیه بایگانی شد.',
        ];


        $key =
            (string) (
                $_GET['success']
                ?? ''
            );


        return $messages[$key]
            ?? null;
    }
}


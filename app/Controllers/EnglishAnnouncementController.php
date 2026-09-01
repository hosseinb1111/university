<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\EnglishAnnouncement;

final class EnglishAnnouncementController
{
    /**
     * English admin announcement list.
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
            EnglishAnnouncement::paginate(
                $page,
                20
            );

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/english/announcements/index',
            [
                'title' =>
                    'اطلاعیه‌های انگلیسی | صدرا',

                'announcements' =>
                    $result,

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
     * Create English announcement form.
     */
    public function create(): string
    {
        $form =
            Session::getFlash(
                'english_announcement_form'
            );

        $errors =
            Session::getFlash(
                'english_announcement_errors'
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
            'admin/english/announcements/create',
            [
                'title' =>
                    'ایجاد اطلاعیه انگلیسی | صدرا',

                'announcement' =>
                    $announcement,

                'errors' =>
                    is_array($errors)
                        ? $errors
                        : [],
            ]
        );
    }


    /**
     * Store English announcement.
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
                'english_announcement_form',
                $data
            );

            Session::flash(
                'english_announcement_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.english.announcements.create'
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

        EnglishAnnouncement::create(
            $data,
            $userId
        );

        Session::flash(
            'success',
            'اطلاعیه انگلیسی با موفقیت ایجاد شد.'
        );

        Response::redirectRoute(
            'admin.english.announcements.index'
        );
    }


    /**
     * Edit English announcement.
     */
    public function edit(
        string $id
    ): string {
        $announcementId =
            $this->positiveId(
                $id
            );

        $announcement =
            EnglishAnnouncement::find(
                $announcementId
            );

        if (
            $announcement === null
        ) {
            Response::notFound(
                'اطلاعیه انگلیسی مورد نظر پیدا نشد.'
            );
        }

        $form =
            Session::getFlash(
                'english_announcement_form'
            );

        $errors =
            Session::getFlash(
                'english_announcement_errors'
            );

        if (
            is_array($form)
        ) {
            $announcement =
                array_merge(
                    $announcement,
                    $form
                );
        } else {
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
            'admin/english/announcements/edit',
            [
                'title' =>
                    'ویرایش اطلاعیه انگلیسی | صدرا',

                'announcement' =>
                    $announcement,

                'errors' =>
                    is_array($errors)
                        ? $errors
                        : [],
            ]
        );
    }


    /**
     * Update English announcement.
     */
    public function update(
        string $id
    ): never {
        Csrf::requireValid();

        $announcementId =
            $this->positiveId(
                $id
            );

        $existing =
            EnglishAnnouncement::find(
                $announcementId
            );

        if (
            $existing === null
        ) {
            Response::notFound(
                'اطلاعیه انگلیسی مورد نظر پیدا نشد.'
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
                $data,
                $announcementId
            );

        if (
            $errors !== []
        ) {
            Session::flash(
                'english_announcement_form',
                $data
            );

            Session::flash(
                'english_announcement_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.english.announcements.edit',
                [
                    'id' =>
                        $announcementId,
                ]
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

        EnglishAnnouncement::update(
            $announcementId,
            $data,
            $userId
        );

        Session::flash(
            'success',
            'اطلاعیه انگلیسی با موفقیت ویرایش شد.'
        );

        Response::redirectRoute(
            'admin.english.announcements.index'
        );
    }


    /**
     * Delete English announcement.
     */
    public function delete(
        string $id
    ): never {
        Csrf::requireValid();

        $announcementId =
            $this->positiveId(
                $id
            );

        $announcement =
            EnglishAnnouncement::find(
                $announcementId
            );

        if (
            $announcement === null
        ) {
            Session::flash(
                'error',
                'اطلاعیه انگلیسی مورد نظر پیدا نشد.'
            );

            Response::redirectRoute(
                'admin.english.announcements.index'
            );
        }

        EnglishAnnouncement::delete(
            $announcementId
        );

        Session::flash(
            'success',
            'اطلاعیه انگلیسی با موفقیت حذف شد.'
        );

        Response::redirectRoute(
            'admin.english.announcements.index'
        );
    }


    /**
     * Publish English announcement.
     */
    public function publish(
        string $id
    ): never {
        Csrf::requireValid();

        $announcementId =
            $this->positiveId(
                $id
            );

        $announcement =
            EnglishAnnouncement::find(
                $announcementId
            );

        if (
            $announcement === null
        ) {
            Response::notFound(
                'اطلاعیه انگلیسی مورد نظر پیدا نشد.'
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

        EnglishAnnouncement::publish(
            $announcementId,
            $userId
        );

        Session::flash(
            'success',
            'اطلاعیه انگلیسی منتشر شد.'
        );

        Response::redirectRoute(
            'admin.english.announcements.index'
        );
    }


    /**
     * Archive English announcement.
     */
    public function archive(
        string $id
    ): never {
        Csrf::requireValid();

        $announcementId =
            $this->positiveId(
                $id
            );

        $announcement =
            EnglishAnnouncement::find(
                $announcementId
            );

        if (
            $announcement === null
        ) {
            Response::notFound(
                'اطلاعیه انگلیسی مورد نظر پیدا نشد.'
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

        EnglishAnnouncement::archive(
            $announcementId,
            $userId
        );

        Session::flash(
            'success',
            'اطلاعیه انگلیسی بایگانی شد.'
        );

        Response::redirectRoute(
            'admin.english.announcements.index'
        );
    }


    /**
     * Read submitted data.
     *
     * @return array<string, mixed>
     */
    private function input(): array
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
                EnglishAnnouncement::generateUniqueSlug(
                    $title
                );
        } else {
            $slug =
                EnglishAnnouncement::slugify(
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
                        (int) (
                            $_POST['priority']
                            ?? 0
                        )
                    )
                ),

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
     * Validate English announcement.
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

        if (
            $title === ''
        ) {
            $errors['title'] =
                'English announcement title is required.';
        } elseif (
            mb_strlen(
                $title,
                'UTF-8'
            ) > 255
        ) {
            $errors['title'] =
                'Title cannot exceed 255 characters.';
        }

        $slug =
            trim(
                (string) (
                    $data['slug']
                    ?? ''
                )
            );

        if (
            $slug === ''
        ) {
            $errors['slug'] =
                'A valid slug is required.';
        } elseif (
            mb_strlen(
                $slug,
                'UTF-8'
            ) > 255
        ) {
            $errors['slug'] =
                'Slug cannot exceed 255 characters.';
        } elseif (
            EnglishAnnouncement::slugExists(
                $slug,
                $ignoreId
            )
        ) {
            $errors['slug'] =
                'This slug is already in use.';
        }

        $content =
            trim(
                (string) (
                    $data['content']
                    ?? ''
                )
            );

        if (
            $content === ''
        ) {
            $errors['content'] =
                'Announcement content is required.';
        }

        $publishedAt =
            $data['published_at']
            ?? null;

        if (
            !jalali_is_valid_datetime_input(
                $publishedAt
            )
        ) {
            $errors['published_at'] =
                'Publication date is invalid.';
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
                'Expiration date is invalid.';
        }

        if (
            !isset(
                $errors['published_at']
            )
            && !isset(
                $errors['expires_at']
            )
            && is_string($publishedAt)
            && is_string($expiresAt)
            && trim($publishedAt) !== ''
            && trim($expiresAt) !== ''
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
                    'Expiration must be after publication.';
            }
        }

        return $errors;
    }


    /**
     * Convert empty values to NULL.
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
                'شناسه اطلاعیه انگلیسی معتبر نیست.'
            );
        }

        return (int) $value;
    }
}
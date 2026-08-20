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
        $page = max(
            1,
            (int) ($_GET['page'] ?? 1)
        );

        $result = Announcement::paginate(
            $page,
            20
        );

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/announcements/index',
            [
                'title' => 'مدیریت اطلاعیه‌ها | صدرا',

                'announcements' => $result,

                'success' => $this->successMessage(),
            ]
        );
    }

    /**
     * Create form.
     */
    public function create(): string
    {
        return View::renderIntoLayout(
            'layouts/admin',
            'admin/announcements/create',
            [
                'title' => 'ایجاد اطلاعیه | صدرا',

                'announcement' => [
                    'title' => '',
                    'slug' => '',
                    'excerpt' => '',
                    'content' => '',
                    'featured_image' => '',
                    'status' => 'draft',
                    'priority' => 0,
                    'published_at' => '',
                    'expires_at' => '',
                ],

                'errors' => [],
            ]
        );
    }

    /**
     * Store announcement.
     */
    public function store(): never
    {
        Csrf::requireValid();

        $data = $this->collectInput();

        $errors = $this->validate(
            $data
        );

        if ($errors !== []) {
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

        $userId = Session::userId();

        if ($userId === null) {
            Response::redirectRoute(
                'teacher.login'
            );
        }

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
        $announcement = Announcement::find(
            (int) $id
        );

        if ($announcement === null) {
            Response::notFound(
                'اطلاعیه مورد نظر پیدا نشد.'
            );
        }

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/announcements/edit',
            [
                'title' => 'ویرایش اطلاعیه | صدرا',

                'announcement' => $announcement,

                'errors' => [],
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

        $announcementId = (int) $id;

        $announcement = Announcement::find(
            $announcementId
        );

        if ($announcement === null) {
            Response::notFound(
                'اطلاعیه مورد نظر پیدا نشد.'
            );
        }

        $data = $this->collectInput();

        $errors = $this->validate(
            $data,
            $announcementId
        );

        if ($errors !== []) {
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

        $userId = Session::userId();

        if ($userId === null) {
            Response::redirectRoute(
                'teacher.login'
            );
        }

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

        $announcementId = (int) $id;

        $announcement = Announcement::find(
            $announcementId
        );

        if ($announcement === null) {
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

        $announcementId = (int) $id;

        $announcement = Announcement::find(
            $announcementId
        );

        if ($announcement === null) {
            Response::notFound(
                'اطلاعیه مورد نظر پیدا نشد.'
            );
        }

        $userId = Session::userId();

        if ($userId === null) {
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

        $announcementId = (int) $id;

        $announcement = Announcement::find(
            $announcementId
        );

        if ($announcement === null) {
            Response::notFound(
                'اطلاعیه مورد نظر پیدا نشد.'
            );
        }

        $userId = Session::userId();

        if ($userId === null) {
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
     */
    public function publicIndex(): string
    {
        return View::renderIntoLayout(
            'layouts/app',
            'announcements/index',
            [
                'title' =>
                    'اطلاعیه‌ها | موسسه آموزش عالی صدرالمتالهین',

                'announcements' =>
                    Announcement::latest(50),
            ]
        );
    }

    /**
     * Public announcement details.
     */
    public function show(
        string $slug
    ): string {
        $announcement =
            Announcement::findPublishedBySlug(
                $slug
            );

        if ($announcement === null) {
            Response::notFound(
                'اطلاعیه مورد نظر پیدا نشد.'
            );
        }

        return View::renderIntoLayout(
            'layouts/app',
            'announcements/show',
            [
                'title' =>
                    $announcement['title']
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
        $title = trim(
            (string) (
                $_POST['title']
                ?? ''
            )
        );

        $slug = trim(
            (string) (
                $_POST['slug']
                ?? ''
            )
        );

        if ($slug === '') {
            $slug = Announcement::generateUniqueSlug(
                $title
            );
        } else {
            $slug = Announcement::slugify(
                $slug
            );
        }

        $status = (string) (
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
            $status = 'draft';
        }

        $priority = (int) (
            $_POST['priority']
            ?? 0
        );

        return [
            'title' => $title,

            'slug' => $slug,

            'excerpt' => $this->nullableString(
                $_POST['excerpt'] ?? null
            ),

            'content' => $this->nullableString(
                $_POST['content'] ?? null
            ),

            'featured_image' => $this->nullableString(
                $_POST['featured_image'] ?? null
            ),

            'status' => $status,

            'priority' => max(
                -1000,
                min(
                    1000,
                    $priority
                )
            ),

            'published_at' =>
                $this->normalizeDateTime(
                    $_POST['published_at'] ?? null
                ),

            'expires_at' =>
                $this->normalizeDateTime(
                    $_POST['expires_at'] ?? null
                ),
        ];
    }

    /**
     * Validate announcement input.
     *
     * @return array<string, string>
     */
    private function validate(
        array $data,
        ?int $ignoreId = null
    ): array {
        $errors = [];

        $title = trim(
            (string) (
                $data['title'] ?? ''
            )
        );

        $slug = trim(
            (string) (
                $data['slug'] ?? ''
            )
        );

        $content = trim(
            (string) (
                $data['content'] ?? ''
            )
        );

        if ($title === '') {
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

        if ($slug === '') {
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

        if ($content === '') {
            $errors['content'] =
                'متن اطلاعیه الزامی است.';
        }

        $status = (string) (
            $data['status'] ?? ''
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

        return $errors;
    }

    /**
     * Normalize a nullable string.
     */
    private function nullableString(
        mixed $value
    ): ?string {
        if (!is_string($value)) {
            return null;
        }

        $value = trim(
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
            !is_string($value)
            || trim($value) === ''
        ) {
            return null;
        }

        $timestamp = strtotime(
            $value
        );

        if ($timestamp === false) {
            return null;
        }

        return date(
            'Y-m-d H:i:s',
            $timestamp
        );
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

        $key = (string) (
            $_GET['success'] ?? ''
        );

        return $messages[$key] ?? null;
    }
}
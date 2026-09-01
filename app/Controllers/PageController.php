<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Page;

final class PageController
{
    /**
     * Admin page list.
     */
    public function index(): string
    {
        $page = max(
            1,
            (int) (
                $_GET['page'] ?? 1
            )
        );

        $result = Page::paginate(
            $page,
            20
        );

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/pages/index',
            [
                'title' =>
                    'مدیریت صفحات | صدرا',

                'pages' =>
                    $result,

                'success' =>
                    $this->successMessage(),

                'error' =>
                    null,
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
            'admin/pages/create',
            [
                'title' =>
                    'ایجاد صفحه | صدرا',

                'page' => [
                    'id' => null,
                    'parent_id' => null,
                    'slug' => '',
                    'title' => '',
                    'excerpt' => '',
                    'content' => '',
                    'featured_image' => '',
                    'status' => 'draft',
                    'seo_title' => '',
                    'seo_description' => '',
                    'seo_keywords' => '',
                    'published_at' => null,
                    'created_by' => null,
                    'updated_by' => null,
                ],

                'parents' =>
                    Page::parentOptions(),

                'errors' =>
                    [],

                'success' =>
                    null,

                'error' =>
                    null,
            ]
        );
    }

    /**
     * Store a new page.
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

        if ($errors !== []) {
            Session::flash(
                'page_form',
                $data
            );

            Session::flash(
                'page_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.pages.create'
            );
        }

        $userId =
            Session::userId();

        if ($userId === null) {
            Response::redirectRoute(
                'teacher.login'
            );
        }

        Page::create(
            $data,
            $userId
        );

        Response::redirect(
            '/admin/pages?success=created'
        );
    }

    /**
     * Edit form.
     */
    public function edit(
        string $id
    ): string {
        $page =
            Page::find(
                (int) $id
            );

        if ($page === null) {
            Response::notFound(
                'صفحه مورد نظر پیدا نشد.'
            );
        }

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/pages/edit',
            [
                'title' =>
                    'ویرایش صفحه | صدرا',

                'page' =>
                    $page,

                'parents' =>
                    Page::parentOptions(
                        (int) $id
                    ),

                'errors' =>
                    [],

                'success' =>
                    null,

                'error' =>
                    null,
            ]
        );
    }

    /**
     * Update a page.
     */
    public function update(
        string $id
    ): never {
        Csrf::requireValid();

        $pageId =
            (int) $id;

        if (
            Page::find($pageId) === null
        ) {
            Response::notFound(
                'صفحه مورد نظر پیدا نشد.'
            );
        }

        $data =
            $this->collectInput();

        /*
         * Prevent a page from becoming its own parent.
         */
        if (
            isset($data['parent_id'])
            && (int) $data['parent_id']
                === $pageId
        ) {
            $data['parent_id'] = null;
        }

        $errors =
            $this->validate(
                $data,
                $pageId
            );

        if ($errors !== []) {
            Session::flash(
                'page_form',
                $data
            );

            Session::flash(
                'page_errors',
                $errors
            );

            Response::redirect(
                '/admin/pages/'
                . $pageId
                . '/edit'
            );
        }

        $userId =
            Session::userId();

        if ($userId === null) {
            Response::redirectRoute(
                'teacher.login'
            );
        }

        Page::update(
            $pageId,
            $data,
            $userId
        );

        Response::redirect(
            '/admin/pages?success=updated'
        );
    }

    /**
     * Delete a page.
     */
    public function delete(
        string $id
    ): never {
        Csrf::requireValid();

        $pageId =
            (int) $id;

        if (
            Page::find($pageId) === null
        ) {
            Response::notFound(
                'صفحه مورد نظر پیدا نشد.'
            );
        }

        Page::delete(
            $pageId
        );

        Response::redirect(
            '/admin/pages?success=deleted'
        );
    }

    /**
     * Public page.
     */
    public function show(
        string $slug
    ): string {
        $page =
            Page::findPublishedBySlug(
                $slug
            );

        if ($page === null) {
            return View::renderIntoLayout(
                'layouts/app',
                'pages/not-found',
                [
                    'title' =>
                        'صفحه مورد نظر یافت نشد | صدرا',
                ]
            );
        }

        return View::renderIntoLayout(
            'layouts/app',
            'pages/show',
            [
                'title' =>
                    $page['seo_title']
                    ?: $page['title']
                    . ' | صدرا',

                'description' =>
                    $page['seo_description']
                    ?: $page['excerpt']
                    ?: '',

                'page' =>
                    $page,
            ]
        );
    }

    /**
     * Collect form data.
     *
     * The database stores published_at as Gregorian
     * MySQL DATETIME, while the admin enters a Jalali
     * date such as:
     *
     * ۱۴۰۵/۰۶/۰۵ ۱۱:۱۴
     *
     * jalali_parse_datetime() converts it to:
     *
     * 2026-08-27 11:14:00
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

        if ($slug === '') {
            $slug =
                Page::generateUniqueSlug(
                    $title
                );
        } else {
            $slug =
                Page::slugify(
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
                    'private',
                ],
                true
            )
        ) {
            $status = 'draft';
        }

        $parentId =
            null;

        if (
            isset($_POST['parent_id'])
            && $_POST['parent_id'] !== ''
        ) {
            $parentId =
                (int) $_POST['parent_id'];

            if ($parentId <= 0) {
                $parentId = null;
            }
        }

        /*
         * The admin enters a Jalali date.
         *
         * Example:
         * ۱۴۰۵/۰۶/۰۵ ۱۱:۱۴
         *
         * The helper converts it to:
         * 2026-08-27 11:14:00
         */
        $publishedAtInput =
            isset($_POST['published_at'])
                ? trim(
                    (string) $_POST['published_at']
                )
                : '';

        $publishedAt =
            jalali_parse_datetime(
                $publishedAtInput
            );

        return [
            'parent_id' =>
                $parentId,

            'slug' =>
                $slug,

            'title' =>
                $title,

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

            'seo_title' =>
                $this->nullableString(
                    $_POST['seo_title']
                    ?? null
                ),

            'seo_description' =>
                $this->nullableString(
                    $_POST['seo_description']
                    ?? null
                ),

            'seo_keywords' =>
                $this->nullableString(
                    $_POST['seo_keywords']
                    ?? null
                ),

            'published_at' =>
                $publishedAt,
        ];
    }

    /**
     * Validate page input.
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

        if ($title === '') {
            $errors['title'] =
                'عنوان صفحه الزامی است.';
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
                'آدرس صفحه الزامی است.';
        } elseif (
            mb_strlen(
                $slug,
                'UTF-8'
            ) > 255
        ) {
            $errors['slug'] =
                'آدرس صفحه نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.';
        } elseif (
            Page::slugExists(
                $slug,
                $ignoreId
            )
        ) {
            $errors['slug'] =
                'این آدرس قبلاً استفاده شده است.';
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
                    'private',
                ],
                true
            )
        ) {
            $errors['status'] =
                'وضعیت انتخاب شده معتبر نیست.';
        }

        /*
         * published_at is already normalized by collectInput().
         *
         * If the user entered something, but it could not
         * be parsed as a Jalali date, reject it.
         */
        $publishedAtInput =
            isset($_POST['published_at'])
                ? trim(
                    (string) $_POST['published_at']
                )
                : '';

        if (
            $publishedAtInput !== ''
            && !jalali_is_valid_datetime_input(
                $publishedAtInput
            )
        ) {
            $errors['published_at'] =
                'تاریخ انتشار وارد شده معتبر نیست. نمونه صحیح: ۱۴۰۵/۰۶/۰۵ ۱۱:۱۴';
        }

        return $errors;
    }

    /**
     * Nullable string helper.
     */
    private function nullableString(
        mixed $value
    ): ?string {
        if (!is_string($value)) {
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
     * Success messages.
     */
    private function successMessage(): ?string
    {
        $messages = [
            'created' =>
                'صفحه با موفقیت ایجاد شد.',

            'updated' =>
                'صفحه با موفقیت ویرایش شد.',

            'deleted' =>
                'صفحه با موفقیت حذف شد.',
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
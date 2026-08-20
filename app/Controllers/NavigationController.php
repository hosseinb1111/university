<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Navigation;
use App\Models\Page;

final class NavigationController
{
    /**
     * List navigation items.
     */
    public function index(): string
    {
        return View::renderIntoLayout(
            'layouts/admin',
            'admin/navigation/index',
            [
                'title' =>
                    'مدیریت منوی سایت | صدرا',

                'items' =>
                    Navigation::all(),

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
        return View::renderIntoLayout(
            'layouts/admin',
            'admin/navigation/create',
            [
                'title' =>
                    'افزودن آیتم منو | صدرا',

                'item' => [
                    'parent_id' => '',
                    'page_id' => '',
                    'title' => '',
                    'url' => '',
                    'target' => '_self',
                    'sort_order' => 0,
                    'is_active' => 1,
                ],

                'parents' =>
                    Navigation::parentOptions(),

                'pages' =>
                    Page::paginate(
                        1,
                        100
                    )['items'],

                'errors' => [],
            ]
        );
    }

    /**
     * Store navigation item.
     */
    public function store(): never
    {
        Csrf::requireValid();

        $data = $this->collectInput();

        $errors = $this->validate(
            $data
        );

        if (
            $errors !== []
        ) {
            Session::flash(
                'navigation_form',
                $data
            );

            Session::flash(
                'navigation_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.navigation.create'
            );
        }

        Navigation::create(
            $data
        );

        Response::redirect(
            '/admin/navigation?success=created'
        );
    }

    /**
     * Edit navigation item.
     */
    public function edit(
        string $id
    ): string {
        $item = Navigation::find(
            (int) $id
        );

        if (
            $item === null
        ) {
            Response::notFound(
                'آیتم منوی مورد نظر پیدا نشد.'
            );
        }

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/navigation/edit',
            [
                'title' =>
                    'ویرایش آیتم منو | صدرا',

                'item' =>
                    $item,

                'parents' =>
                    Navigation::parentOptions(
                        (int) $id
                    ),

                'pages' =>
                    Page::paginate(
                        1,
                        100
                    )['items'],

                'errors' => [],
            ]
        );
    }

    /**
     * Update navigation item.
     */
    public function update(
        string $id
    ): never {
        Csrf::requireValid();

        $itemId = (int) $id;

        if (
            Navigation::find(
                $itemId
            ) === null
        ) {
            Response::notFound(
                'آیتم منوی مورد نظر پیدا نشد.'
            );
        }

        $data = $this->collectInput();

        $errors = $this->validate(
            $data,
            $itemId
        );

        if (
            $errors !== []
        ) {
            Session::flash(
                'navigation_form',
                $data
            );

            Session::flash(
                'navigation_errors',
                $errors
            );

            Response::redirect(
                '/admin/navigation/'
                . $itemId
                . '/edit'
            );
        }

        Navigation::update(
            $itemId,
            $data
        );

        Response::redirect(
            '/admin/navigation?success=updated'
        );
    }

    /**
     * Delete navigation item.
     */
    public function delete(
        string $id
    ): never {
        Csrf::requireValid();

        $itemId = (int) $id;

        if (
            Navigation::find(
                $itemId
            ) === null
        ) {
            Response::notFound(
                'آیتم منوی مورد نظر پیدا نشد.'
            );
        }

        Navigation::delete(
            $itemId
        );

        Response::redirect(
            '/admin/navigation?success=deleted'
        );
    }

    /**
     * Collect form input.
     */
    private function collectInput(): array
    {
        $parentId = null;

        if (
            isset(
                $_POST['parent_id']
            )
            && $_POST['parent_id'] !== ''
        ) {
            $parentId =
                (int) $_POST['parent_id'];

            if (
                $parentId <= 0
            ) {
                $parentId = null;
            }
        }

        $pageId = null;

        if (
            isset(
                $_POST['page_id']
            )
            && $_POST['page_id'] !== ''
        ) {
            $pageId =
                (int) $_POST['page_id'];

            if (
                $pageId <= 0
            ) {
                $pageId = null;
            }
        }

        $target =
            Navigation::normalizeTarget(
                $_POST['target']
                ?? '_self'
            );

        $url = trim(
            (string) (
                $_POST['url']
                ?? ''
            )
        );

        return [
            'parent_id' =>
                $parentId,

            'page_id' =>
                $pageId,

            'title' =>
                trim(
                    (string) (
                        $_POST['title']
                        ?? ''
                    )
                ),

            'url' =>
                $url === ''
                    ? null
                    : $url,

            'target' =>
                $target,

            'sort_order' =>
                (int) (
                    $_POST['sort_order']
                    ?? 0
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
     * Validate input.
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
                'عنوان منو الزامی است.';
        }

        if (
            mb_strlen(
                $title,
                'UTF-8'
            ) > 255
        ) {
            $errors['title'] =
                'عنوان منو نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.';
        }

        $pageId =
            $data['page_id']
            ?? null;

        $url =
            trim(
                (string) (
                    $data['url']
                    ?? ''
                )
            );

        if (
            $pageId === null
            && $url === ''
        ) {
            $errors['destination'] =
                'یک صفحه یا یک آدرس برای منو انتخاب کنید.';
        }

        if (
            $pageId !== null
            && Page::find(
                (int) $pageId
            ) === null
        ) {
            $errors['page_id'] =
                'صفحه انتخاب شده وجود ندارد.';
        }

        $parentId =
            $data['parent_id']
            ?? null;

        if (
            $parentId !== null
        ) {
            if (
                Navigation::find(
                    (int) $parentId
                ) === null
            ) {
                $errors['parent_id'] =
                    'آیتم والد وجود ندارد.';
            } elseif (
                $ignoreId !== null
                && Navigation::wouldCreateCycle(
                    $ignoreId,
                    (int) $parentId
                )
            ) {
                $errors['parent_id'] =
                    'این والد باعث ایجاد ساختار حلقوی می‌شود.';
            }
        }

        return $errors;
    }

    /**
     * Operation message.
     */
    private function successMessage(): ?string
    {
        $messages = [
            'created' =>
                'آیتم منو با موفقیت ایجاد شد.',

            'updated' =>
                'آیتم منو با موفقیت ویرایش شد.',

            'deleted' =>
                'آیتم منو با موفقیت حذف شد.',
        ];

        $key = (string) (
            $_GET['success']
            ?? ''
        );

        return $messages[$key]
            ?? null;
    }
}
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
     * Navigation administration page.
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

                'error' =>
                    $this->errorMessage(),
            ]
        );
    }

    /**
     * Create navigation item form.
     */
    public function create(): string
    {
        $form =
            Session::getFlash(
                'navigation_form'
            );

        $errors =
            Session::getFlash(
                'navigation_errors'
            );

        $item = [
            'parent_id' =>
                null,

            'display_location' =>
                'main',

            'page_id' =>
                null,

            'title' =>
                '',

            'description' =>
                '',

            'url' =>
                '',

            'destination_type' =>
                'page',

            'target' =>
                '_self',

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
            'admin/navigation/create',
            [
                'title' =>
                    'افزودن آیتم منو | صدرا',

                'item' =>
                    $item,

                'parents' =>
                    Navigation::parentOptions(),

                'pages' =>
                    $this->pages(),

                'errors' =>
                    is_array($errors)
                        ? $errors
                        : [],

                'errorMessage' =>
                    $this->errorMessage(),
            ]
        );
    }

    /**
     * Store navigation item.
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
        $itemId =
            $this->positiveId(
                $id
            );

        $item =
            Navigation::find(
                $itemId
            );

        if (
            $item === null
        ) {
            Response::notFound(
                'آیتم منوی مورد نظر پیدا نشد.'
            );
        }

        $form =
            Session::getFlash(
                'navigation_form'
            );

        $errors =
            Session::getFlash(
                'navigation_errors'
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

        $item['destination_type'] =
            !empty(
                $item['page_id']
            )
                ? 'page'
                : 'url';

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
                        $itemId
                    ),

                'pages' =>
                    $this->pages(),

                'errors' =>
                    is_array($errors)
                        ? $errors
                        : [],

                'errorMessage' =>
                    $this->errorMessage(),
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

        $itemId =
            $this->positiveId(
                $id
            );

        if (
            Navigation::find(
                $itemId
            ) === null
        ) {
            Response::notFound(
                'آیتم منوی مورد نظر پیدا نشد.'
            );
        }

        $data =
            $this->collectInput();

        $errors =
            $this->validate(
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

        $updated =
            Navigation::update(
                $itemId,
                $data
            );

        if (
            !$updated
        ) {
            Session::flash(
                'error',
                'ویرایش آیتم منو انجام نشد.'
            );

            Response::redirect(
                '/admin/navigation/'
                . $itemId
                . '/edit'
            );
        }

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

        $itemId =
            $this->positiveId(
                $id
            );

        if (
            Navigation::find(
                $itemId
            ) === null
        ) {
            Session::flash(
                'error',
                'آیتم مورد نظر پیدا نشد.'
            );

            Response::redirect(
                '/admin/navigation'
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
     *
     * @return array<string, mixed>
     */
    private function collectInput(): array
    {
        $displayLocation =
            Navigation::normalizeDisplayLocation(
                $_POST['display_location']
                ?? 'main'
            );

        $destinationType =
            $_POST['destination_type']
            ?? 'page';

        $destinationType =
            $destinationType === 'url'
                ? 'url'
                : 'page';

        $parentId =
            null;

        if (
            $displayLocation === 'main'
            && isset(
                $_POST['parent_id']
            )
            && $_POST['parent_id'] !== ''
        ) {
            $parentId =
                (int) $_POST['parent_id'];

            if (
                $parentId <= 0
            ) {
                $parentId =
                    null;
            }
        }

        $pageId =
            null;

        if (
            $destinationType === 'page'
            && isset(
                $_POST['page_id']
            )
            && $_POST['page_id'] !== ''
        ) {
            $pageId =
                (int) $_POST['page_id'];

            if (
                $pageId <= 0
            ) {
                $pageId =
                    null;
            }
        }

        $url =
            trim(
                (string) (
                    $_POST['url']
                    ?? ''
                )
            );

        if (
            $destinationType !== 'url'
        ) {
            $url =
                '';
        }

        $description =
            trim(
                (string) (
                    $_POST['description']
                    ?? ''
                )
            );

        return [
            'parent_id' =>
                $parentId,

            'display_location' =>
                $displayLocation,

            'page_id' =>
                $pageId,

            'title' =>
                trim(
                    (string) (
                        $_POST['title']
                        ?? ''
                    )
                ),

            'description' =>
                $description === ''
                    ? null
                    : $description,

            'url' =>
                $url === ''
                    ? null
                    : $url,

            'destination_type' =>
                $destinationType,

            'target' =>
                Navigation::normalizeTarget(
                    $_POST['target']
                    ?? '_self'
                ),

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
     * Validate navigation item.
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

        $description =
            $data['description']
            ?? null;

        if (
            is_string($description)
            && mb_strlen(
                $description,
                'UTF-8'
            ) > 500
        ) {
            $errors['description'] =
                'توضیحات نمی‌تواند بیشتر از ۵۰۰ کاراکتر باشد.';
        }

        $displayLocation =
            Navigation::normalizeDisplayLocation(
                $data['display_location']
                ?? 'main'
            );

        $destinationType =
            ($data['destination_type']
            ?? 'page') === 'url'
                ? 'url'
                : 'page';

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
            $destinationType === 'page'
        ) {
            if (
                $pageId === null
            ) {
                $errors['destination'] =
                    'یک صفحه مقصد انتخاب کنید.';
            } elseif (
                Page::find(
                    (int) $pageId
                ) === null
            ) {
                $errors['page_id'] =
                    'صفحه انتخاب‌شده وجود ندارد.';
            }
        } else {
            if (
                $url === ''
            ) {
                $errors['destination'] =
                    'یک آدرس مستقیم وارد کنید.';
            } elseif (
                mb_strlen(
                    $url,
                    'UTF-8'
                ) > 500
            ) {
                $errors['url'] =
                    'آدرس نمی‌تواند بیشتر از ۵۰۰ کاراکتر باشد.';
            }
        }

        $parentId =
            $data['parent_id']
            ?? null;

        if (
            $displayLocation === 'quick'
        ) {
            if (
                $parentId !== null
            ) {
                $errors['parent_id'] =
                    'آیتم‌های دسترسی سریع باید در سطح اصلی باشند.';
            }
        } elseif (
            $parentId !== null
        ) {
            $parent =
                Navigation::find(
                    (int) $parentId
                );

            if (
                $parent === null
            ) {
                $errors['parent_id'] =
                    'آیتم والد وجود ندارد.';
            } elseif (
                (
                    $parent['display_location']
                    ?? 'main'
                ) !== 'main'
            ) {
                $errors['parent_id'] =
                    'آیتم انتخاب‌شده نمی‌تواند والد باشد.';
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
     * Load pages for navigation destination.
     *
     * @return array<int, array<string, mixed>>
     */
    private function pages(): array
    {
        $result =
            Page::paginate(
                1,
                100
            );

        return is_array(
            $result['items']
            ?? null
        )
            ? $result['items']
            : [];
    }

    /**
     * Success message.
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

        $key =
            (string) (
                $_GET['success']
                ?? ''
            );

        return $messages[$key]
            ?? null;
    }

    /**
     * Error flash message.
     */
    private function errorMessage(): ?string
    {
        $error =
            Session::getFlash(
                'error'
            );

        return is_string($error)
            && $error !== ''
                ? $error
                : null;
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
                'شناسه آیتم منو معتبر نیست.'
            );
        }

        return (int) $value;
    }
}
<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\ResearchCenter;
use RuntimeException;

final class ResearchCenterController
{
    /*
    |--------------------------------------------------------------------------
    | PUBLIC
    |--------------------------------------------------------------------------
    */

    /**
     * Display all active research centers.
     */
    public function publicIndex(): string
    {
        $researchCenters =
            ResearchCenter::active();

        return View::renderIntoLayout(
            'layouts/app',
            'research-centers/index',
            [
                'title' =>
                    'پژوهشکده‌ها | صدرا',

                'description' =>
                    'معرفی پژوهشکده‌ها و مراکز پژوهشی موسسه آموزش عالی صدرالمتالهین.',

                'researchCenters' =>
                    is_array($researchCenters)
                        ? $researchCenters
                        : [],
            ]
        );
    }

    /**
     * Display one active research center.
     */
    public function show(
        string $slug
    ): string {
        $slug =
            trim($slug);

        if (
            $slug === ''
        ) {
            Response::notFound(
                'پژوهشکده مورد نظر پیدا نشد.'
            );
        }

        $center =
            ResearchCenter::findActiveBySlug(
                $slug
            );

        if (
            $center === null
        ) {
            Response::notFound(
                'پژوهشکده مورد نظر پیدا نشد.'
            );
        }

        $name =
            (string) (
                $center['name']
                ?? 'پژوهشکده'
            );

        return View::renderIntoLayout(
            'layouts/app',
            'research-centers/show',
            [
                'title' =>
                    $name
                    . ' | صدرا',

                'description' =>
                    $this->publicDescription(
                        $center
                    ),

                'center' =>
                    $center,
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    /**
     * Display the admin research-center list.
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

        $researchCenters =
            ResearchCenter::paginate(
                $page,
                20
            );

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/research-centers/index',
            [
                'title' =>
                    'پژوهشکده‌ها | صدرا',

                // FIX: the view (admin/research-centers/index.php) reads
                // $centers['items'] and $centers['total'], matching the
                // shape returned by ResearchCenter::paginate(). Previously
                // this array key was 'researchCenters', which left $centers
                // undefined in the view and made the list appear empty.
                'centers' =>
                    $researchCenters,

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
                'research_center_form'
            );

        $formErrors =
            Session::getFlash(
                'research_center_errors'
            );

        $center = [
            'slug' =>
                '',

            'name' =>
                '',

            'description' =>
                '',

            'email' =>
                '',

            'phone' =>
                '',

            'address' =>
                '',

            'sort_order' =>
                0,

            'is_active' =>
                1,
        ];

        if (
            is_array($form)
        ) {
            $center =
                array_merge(
                    $center,
                    $form
                );
        }

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/research-centers/create',
            [
                'title' =>
                    'ایجاد پژوهشکده | صدرا',

                'center' =>
                    $center,

                'errors' =>
                    is_array($formErrors)
                        ? $formErrors
                        : [],
            ]
        );
    }

    /**
     * Store a research center.
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

        if (
            trim(
                (string) (
                    $data['slug']
                    ?? ''
                )
            ) === ''
        ) {
            $data['slug'] =
                ResearchCenter::generateUniqueSlug(
                    (string) $data['name']
                );
        }

        $errors =
            $this->validate(
                $data
            );

        if (
            $errors !== []
        ) {
            Session::flash(
                'research_center_form',
                $data
            );

            Session::flash(
                'research_center_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.research-centers.create'
            );
        }

        try {
            ResearchCenter::create(
                $data,
                $userId
            );
        } catch (
            RuntimeException $exception
        ) {
            Session::flash(
                'research_center_form',
                $data
            );

            Session::flash(
                'error',
                $exception->getMessage()
            );

            Response::redirectRoute(
                'admin.research-centers.create'
            );
        }

        Session::flash(
            'success',
            'پژوهشکده با موفقیت ایجاد شد.'
        );

        Response::redirectRoute(
            'admin.research-centers.index'
        );
    }

    /**
     * Show edit form.
     */
    public function edit(
        string $id
    ): string {
        $centerId =
            $this->positiveId(
                $id
            );

        $center =
            ResearchCenter::find(
                $centerId
            );

        if (
            $center === null
        ) {
            Response::notFound(
                'پژوهشکده مورد نظر پیدا نشد.'
            );
        }

        $form =
            Session::getFlash(
                'research_center_form'
            );

        $formErrors =
            Session::getFlash(
                'research_center_errors'
            );

        if (
            is_array($form)
        ) {
            $center =
                array_merge(
                    $center,
                    $form
                );
        }

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/research-centers/edit',
            [
                'title' =>
                    'ویرایش پژوهشکده | صدرا',

                'center' =>
                    $center,

                'errors' =>
                    is_array($formErrors)
                        ? $formErrors
                        : [],
            ]
        );
    }

    /**
     * Update a research center.
     */
    public function update(
        string $id
    ): never {
        Csrf::requireValid();

        $centerId =
            $this->positiveId(
                $id
            );

        $existing =
            ResearchCenter::find(
                $centerId
            );

        if (
            $existing === null
        ) {
            Response::notFound(
                'پژوهشکده مورد نظر پیدا نشد.'
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

        if (
            trim(
                (string) (
                    $data['slug']
                    ?? ''
                )
            ) === ''
        ) {
            $data['slug'] =
                (string) (
                    $existing['slug']
                    ?? ''
                );
        }

        $errors =
            $this->validate(
                $data,
                $centerId
            );

        if (
            $errors !== []
        ) {
            Session::flash(
                'research_center_form',
                $data
            );

            Session::flash(
                'research_center_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.research-centers.edit',
                [
                    'id' =>
                        $centerId,
                ]
            );
        }

        try {
            $updated =
                ResearchCenter::update(
                    $centerId,
                    $data,
                    $userId
                );
        } catch (
            RuntimeException $exception
        ) {
            Session::flash(
                'research_center_form',
                $data
            );

            Session::flash(
                'error',
                $exception->getMessage()
            );

            Response::redirectRoute(
                'admin.research-centers.edit',
                [
                    'id' =>
                        $centerId,
                ]
            );
        }

        if (
            !$updated
        ) {
            Session::flash(
                'error',
                'ویرایش پژوهشکده انجام نشد.'
            );

            Response::redirectRoute(
                'admin.research-centers.edit',
                [
                    'id' =>
                        $centerId,
                ]
            );
        }

        Session::flash(
            'success',
            'پژوهشکده با موفقیت ویرایش شد.'
        );

        Response::redirectRoute(
            'admin.research-centers.index'
        );
    }

    /**
     * Delete a research center.
     */
    public function delete(
        string $id
    ): never {
        Csrf::requireValid();

        $centerId =
            $this->positiveId(
                $id
            );

        $center =
            ResearchCenter::find(
                $centerId
            );

        if (
            $center === null
        ) {
            Session::flash(
                'error',
                'پژوهشکده مورد نظر پیدا نشد.'
            );

            Response::redirectRoute(
                'admin.research-centers.index'
            );
        }

        try {
            $deleted =
                ResearchCenter::delete(
                    $centerId
                );
        } catch (
            RuntimeException $exception
        ) {
            Session::flash(
                'error',
                $exception->getMessage()
            );

            Response::redirectRoute(
                'admin.research-centers.index'
            );
        }

        if (
            !$deleted
        ) {
            Session::flash(
                'error',
                'حذف پژوهشکده انجام نشد.'
            );

            Response::redirectRoute(
                'admin.research-centers.index'
            );
        }

        Session::flash(
            'success',
            'پژوهشکده با موفقیت حذف شد.'
        );

        Response::redirectRoute(
            'admin.research-centers.index'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | INPUT
    |--------------------------------------------------------------------------
    */

    /**
     * Read form input.
     *
     * @return array<string, mixed>
     */
    private function input(): array
    {
        return [
            'slug' =>
                trim(
                    (string) (
                        $_POST['slug']
                        ?? ''
                    )
                ),

            'name' =>
                trim(
                    (string) (
                        $_POST['name']
                        ?? ''
                    )
                ),

            'description' =>
                $this->nullableString(
                    $_POST['description']
                    ?? null
                ),

            'email' =>
                $this->nullableString(
                    $_POST['email']
                    ?? null
                ),

            'phone' =>
                $this->nullableString(
                    $_POST['phone']
                    ?? null
                ),

            'address' =>
                $this->nullableString(
                    $_POST['address']
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

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    /**
     * Validate research-center data.
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

        $name =
            trim(
                (string) (
                    $data['name']
                    ?? ''
                )
            );

        if (
            $name === ''
        ) {
            $errors['name'] =
                'نام پژوهشکده الزامی است.';
        } elseif (
            mb_strlen(
                $name,
                'UTF-8'
            ) > 255
        ) {
            $errors['name'] =
                'نام پژوهشکده نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.';
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
                'شناسه URL پژوهشکده الزامی است.';
        } elseif (
            !preg_match(
                '/^[\p{L}\p{N}][\p{L}\p{N}\-_]*$/u',
                $slug
            )
        ) {
            $errors['slug'] =
                'شناسه URL پژوهشکده معتبر نیست.';
        } elseif (
            mb_strlen(
                $slug,
                'UTF-8'
            ) > 255
        ) {
            $errors['slug'] =
                'شناسه URL نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.';
        } elseif (
            ResearchCenter::slugExists(
                $slug,
                $ignoreId
            )
        ) {
            $errors['slug'] =
                'این شناسه URL قبلاً استفاده شده است.';
        }

        $email =
            $data['email']
            ?? null;

        if (
            is_string($email)
            && $email !== ''
            && filter_var(
                $email,
                FILTER_VALIDATE_EMAIL
            ) === false
        ) {
            $errors['email'] =
                'آدرس ایمیل معتبر نیست.';
        }

        return $errors;
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Build public SEO description.
     *
     * @param array<string, mixed> $center
     */
    private function publicDescription(
        array $center
    ): string {
        $description =
            trim(
                (string) (
                    $center['description']
                    ?? ''
                )
            );

        if (
            $description === ''
        ) {
            return
                'اطلاعات '
                . (string) (
                    $center['name']
                    ?? 'پژوهشکده'
                )
                . ' در موسسه آموزش عالی صدرالمتالهین.';
        }

        return mb_strimwidth(
            $description,
            0,
            180,
            '...',
            'UTF-8'
        );
    }

    /**
     * Convert empty strings to null.
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
                'شناسه پژوهشکده معتبر نیست.'
            );
        }

        return (int) $value;
    }
}
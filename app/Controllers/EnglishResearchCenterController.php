<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\EnglishPeople;
use App\Models\EnglishResearchCenter;

final class EnglishResearchCenterController
{
    /**
     * English research-center list.
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
            'admin/english/research-centers/index',
            [
                'title' =>
                    'مراکز پژوهشی انگلیسی | صدرا',

                'researchCenters' =>
                    EnglishResearchCenter::paginate(
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
     * Create research center form.
     */
    public function create(): string
    {
        $form =
            Session::getFlash(
                'english_research_center_form'
            );

        $errors =
            Session::getFlash(
                'english_research_center_errors'
            );

        $center = [
            'slug' =>
                '',

            'name' =>
                '',

            'short_name' =>
                '',

            'description' =>
                '',

            'image' =>
                '',

            'director_person_id' =>
                null,

            'email' =>
                '',

            'phone' =>
                '',

            'address' =>
                '',

            'website' =>
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
            'admin/english/research-centers/create',
            [
                'title' =>
                    'ایجاد مرکز پژوهشی انگلیسی | صدرا',

                'researchCenter' =>
                    $center,

                'people' =>
                    EnglishPeople::active(),

                'errors' =>
                    is_array($errors)
                        ? $errors
                        : [],
            ]
        );
    }


    /**
     * Store research center.
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
                'english_research_center_form',
                $data
            );

            Session::flash(
                'english_research_center_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.english.research-centers.create'
            );
        }

        EnglishResearchCenter::create(
            $data,
            $userId
        );

        Session::flash(
            'success',
            'مرکز پژوهشی انگلیسی با موفقیت ایجاد شد.'
        );

        Response::redirectRoute(
            'admin.english.research-centers.index'
        );
    }


    /**
     * Edit research center.
     */
    public function edit(
        string $id
    ): string {
        $centerId =
            $this->positiveId(
                $id
            );

        $center =
            EnglishResearchCenter::find(
                $centerId
            );

        if (
            $center === null
        ) {
            Response::notFound(
                'مرکز پژوهشی انگلیسی مورد نظر پیدا نشد.'
            );
        }

        $form =
            Session::getFlash(
                'english_research_center_form'
            );

        $errors =
            Session::getFlash(
                'english_research_center_errors'
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
            'admin/english/research-centers/edit',
            [
                'title' =>
                    'ویرایش مرکز پژوهشی انگلیسی | صدرا',

                'researchCenter' =>
                    $center,

                'people' =>
                    EnglishPeople::active(),

                'errors' =>
                    is_array($errors)
                        ? $errors
                        : [],
            ]
        );
    }


    /**
     * Update research center.
     */
    public function update(
        string $id
    ): never {
        Csrf::requireValid();

        $centerId =
            $this->positiveId(
                $id
            );

        if (
            EnglishResearchCenter::find(
                $centerId
            ) === null
        ) {
            Response::notFound(
                'مرکز پژوهشی انگلیسی مورد نظر پیدا نشد.'
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
                $centerId
            );

        if (
            $errors !== []
        ) {
            Session::flash(
                'english_research_center_form',
                $data
            );

            Session::flash(
                'english_research_center_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.english.research-centers.edit',
                [
                    'id' =>
                        $centerId,
                ]
            );
        }

        EnglishResearchCenter::update(
            $centerId,
            $data,
            $userId
        );

        Session::flash(
            'success',
            'مرکز پژوهشی انگلیسی با موفقیت ویرایش شد.'
        );

        Response::redirectRoute(
            'admin.english.research-centers.index'
        );
    }


    /**
     * Delete research center.
     */
    public function delete(
        string $id
    ): never {
        Csrf::requireValid();

        $centerId =
            $this->positiveId(
                $id
            );

        if (
            EnglishResearchCenter::find(
                $centerId
            ) === null
        ) {
            Session::flash(
                'error',
                'مرکز پژوهشی انگلیسی مورد نظر پیدا نشد.'
            );

            Response::redirectRoute(
                'admin.english.research-centers.index'
            );
        }

        EnglishResearchCenter::delete(
            $centerId
        );

        Session::flash(
            'success',
            'مرکز پژوهشی انگلیسی با موفقیت حذف شد.'
        );

        Response::redirectRoute(
            'admin.english.research-centers.index'
        );
    }


    /**
     * Read form input.
     *
     * @return array<string, mixed>
     */
    private function input(): array
    {
        $name =
            trim(
                (string) (
                    $_POST['name']
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
                EnglishResearchCenter::generateUniqueSlug(
                    $name
                );
        } else {
            $slug =
                EnglishResearchCenter::slugify(
                    $slug
                );
        }

        return [
            'slug' =>
                $slug,

            'name' =>
                $name,

            'short_name' =>
                $this->nullableString(
                    $_POST['short_name']
                    ?? null
                ),

            'description' =>
                $this->nullableString(
                    $_POST['description']
                    ?? null
                ),

            'image' =>
                $this->nullableString(
                    $_POST['image']
                    ?? null
                ),

            'director_person_id' =>
                $this->nullableInteger(
                    $_POST['director_person_id']
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

            'website' =>
                $this->nullableString(
                    $_POST['website']
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
     * Validate research center.
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
                'English research-center name is required.';
        } elseif (
            mb_strlen(
                $name,
                'UTF-8'
            ) > 255
        ) {
            $errors['name'] =
                'Research-center name cannot exceed 255 characters.';
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
            EnglishResearchCenter::slugExists(
                $slug,
                $ignoreId
            )
        ) {
            $errors['slug'] =
                'This slug is already in use.';
        }

        $directorId =
            $data['director_person_id']
            ?? null;

        if (
            $directorId !== null
            && EnglishPeople::find(
                (int) $directorId
            ) === null
        ) {
            $errors['director_person_id'] =
                'The selected director does not exist.';
        }

        return $errors;
    }


    /**
     * Nullable string.
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
     * Nullable integer.
     */
    private function nullableInteger(
        mixed $value
    ): ?int {
        if (
            $value === null
            || $value === ''
        ) {
            return null;
        }

        $validated =
            filter_var(
                $value,
                FILTER_VALIDATE_INT
            );

        return $validated === false
            ? null
            : (int) $validated;
    }


    /**
     * Positive ID.
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
                'شناسه مرکز پژوهشی انگلیسی معتبر نیست.'
            );
        }

        return (int) $value;
    }
}
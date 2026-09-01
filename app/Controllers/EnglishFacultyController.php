<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\EnglishFaculty;

final class EnglishFacultyController
{
    /**
     * English faculty list.
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

        $faculties =
            EnglishFaculty::paginate(
                $page,
                20
            );

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/english/faculties/index',
            [
                'title' =>
                    'دانشکده‌های انگلیسی | صدرا',

                'faculties' =>
                    $faculties,

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
     * Create faculty form.
     */
    public function create(): string
    {
        $form =
            Session::getFlash(
                'english_faculty_form'
            );

        $errors =
            Session::getFlash(
                'english_faculty_errors'
            );

        $faculty = [
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

            'email' =>
                '',

            'phone' =>
                '',

            'fax' =>
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
            $faculty =
                array_merge(
                    $faculty,
                    $form
                );
        }

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/english/faculties/create',
            [
                'title' =>
                    'ایجاد دانشکده انگلیسی | صدرا',

                'faculty' =>
                    $faculty,

                'errors' =>
                    is_array($errors)
                        ? $errors
                        : [],
            ]
        );
    }


    /**
     * Store faculty.
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
                'english_faculty_form',
                $data
            );

            Session::flash(
                'english_faculty_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.english.faculties.create'
            );
        }

        EnglishFaculty::create(
            $data,
            $userId
        );

        Session::flash(
            'success',
            'دانشکده انگلیسی با موفقیت ایجاد شد.'
        );

        Response::redirectRoute(
            'admin.english.faculties.index'
        );
    }


    /**
     * Edit faculty.
     */
    public function edit(
        string $id
    ): string {
        $facultyId =
            $this->positiveId(
                $id
            );

        $faculty =
            EnglishFaculty::find(
                $facultyId
            );

        if (
            $faculty === null
        ) {
            Response::notFound(
                'دانشکده انگلیسی مورد نظر پیدا نشد.'
            );
        }

        $form =
            Session::getFlash(
                'english_faculty_form'
            );

        $errors =
            Session::getFlash(
                'english_faculty_errors'
            );

        if (
            is_array($form)
        ) {
            $faculty =
                array_merge(
                    $faculty,
                    $form
                );
        }

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/english/faculties/edit',
            [
                'title' =>
                    'ویرایش دانشکده انگلیسی | صدرا',

                'faculty' =>
                    $faculty,

                'errors' =>
                    is_array($errors)
                        ? $errors
                        : [],
            ]
        );
    }


    /**
     * Update faculty.
     */
    public function update(
        string $id
    ): never {
        Csrf::requireValid();

        $facultyId =
            $this->positiveId(
                $id
            );

        if (
            EnglishFaculty::find(
                $facultyId
            ) === null
        ) {
            Response::notFound(
                'دانشکده انگلیسی مورد نظر پیدا نشد.'
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
                $facultyId
            );

        if (
            $errors !== []
        ) {
            Session::flash(
                'english_faculty_form',
                $data
            );

            Session::flash(
                'english_faculty_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.english.faculties.edit',
                [
                    'id' =>
                        $facultyId,
                ]
            );
        }

        EnglishFaculty::update(
            $facultyId,
            $data,
            $userId
        );

        Session::flash(
            'success',
            'دانشکده انگلیسی با موفقیت ویرایش شد.'
        );

        Response::redirectRoute(
            'admin.english.faculties.index'
        );
    }


    /**
     * Delete faculty.
     */
    public function delete(
        string $id
    ): never {
        Csrf::requireValid();

        $facultyId =
            $this->positiveId(
                $id
            );

        if (
            EnglishFaculty::find(
                $facultyId
            ) === null
        ) {
            Session::flash(
                'error',
                'دانشکده انگلیسی مورد نظر پیدا نشد.'
            );

            Response::redirectRoute(
                'admin.english.faculties.index'
            );
        }

        EnglishFaculty::delete(
            $facultyId
        );

        Session::flash(
            'success',
            'دانشکده انگلیسی با موفقیت حذف شد.'
        );

        Response::redirectRoute(
            'admin.english.faculties.index'
        );
    }


    /**
     * Read form data.
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
                EnglishFaculty::generateUniqueSlug(
                    $name
                );
        } else {
            $slug =
                EnglishFaculty::slugify(
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

            'fax' =>
                $this->nullableString(
                    $_POST['fax']
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


    /**
     * Validate faculty data.
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
                'English faculty name is required.';
        } elseif (
            mb_strlen(
                $name,
                'UTF-8'
            ) > 255
        ) {
            $errors['name'] =
                'Faculty name cannot exceed 255 characters.';
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
            EnglishFaculty::slugExists(
                $slug,
                $ignoreId
            )
        ) {
            $errors['slug'] =
                'This slug is already in use.';
        }

        return $errors;
    }


    /**
     * Normalize nullable text.
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
                'شناسه دانشکده انگلیسی معتبر نیست.'
            );
        }

        return (int) $value;
    }
}
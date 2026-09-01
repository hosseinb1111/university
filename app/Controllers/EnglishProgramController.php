<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\EnglishFaculty;
use App\Models\EnglishProgram;

final class EnglishProgramController
{
    /**
     * English programs list.
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
            'admin/english/programs/index',
            [
                'title' =>
                    'رشته‌های انگلیسی | صدرا',

                'programs' =>
                    EnglishProgram::paginate(
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
     * Create form.
     */
    public function create(): string
    {
        $form =
            Session::getFlash(
                'english_program_form'
            );

        $errors =
            Session::getFlash(
                'english_program_errors'
            );

        $program = [
            'faculty_id' =>
                0,

            'slug' =>
                '',

            'name' =>
                '',

            'degree' =>
                '',

            'field' =>
                '',

            'description' =>
                '',

            'duration' =>
                '',

            'admission_info' =>
                '',

            'curriculum' =>
                '',

            'sort_order' =>
                0,

            'is_active' =>
                1,
        ];

        if (
            is_array($form)
        ) {
            $program =
                array_merge(
                    $program,
                    $form
                );
        }

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/english/programs/create',
            [
                'title' =>
                    'ایجاد رشته انگلیسی | صدرا',

                'program' =>
                    $program,

                'faculties' =>
                    EnglishFaculty::active(),

                'errors' =>
                    is_array($errors)
                        ? $errors
                        : [],
            ]
        );
    }


    /**
     * Store program.
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
                'english_program_form',
                $data
            );

            Session::flash(
                'english_program_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.english.programs.create'
            );
        }

        EnglishProgram::create(
            $data,
            $userId
        );

        Session::flash(
            'success',
            'رشته انگلیسی با موفقیت ایجاد شد.'
        );

        Response::redirectRoute(
            'admin.english.programs.index'
        );
    }


    /**
     * Edit program.
     */
    public function edit(
        string $id
    ): string {
        $programId =
            $this->positiveId(
                $id
            );

        $program =
            EnglishProgram::find(
                $programId
            );

        if (
            $program === null
        ) {
            Response::notFound(
                'رشته انگلیسی مورد نظر پیدا نشد.'
            );
        }

        $form =
            Session::getFlash(
                'english_program_form'
            );

        $errors =
            Session::getFlash(
                'english_program_errors'
            );

        if (
            is_array($form)
        ) {
            $program =
                array_merge(
                    $program,
                    $form
                );
        }

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/english/programs/edit',
            [
                'title' =>
                    'ویرایش رشته انگلیسی | صدرا',

                'program' =>
                    $program,

                'faculties' =>
                    EnglishFaculty::active(),

                'errors' =>
                    is_array($errors)
                        ? $errors
                        : [],
            ]
        );
    }


    /**
     * Update program.
     */
    public function update(
        string $id
    ): never {
        Csrf::requireValid();

        $programId =
            $this->positiveId(
                $id
            );

        if (
            EnglishProgram::find(
                $programId
            ) === null
        ) {
            Response::notFound(
                'رشته انگلیسی مورد نظر پیدا نشد.'
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
                $programId
            );

        if (
            $errors !== []
        ) {
            Session::flash(
                'english_program_form',
                $data
            );

            Session::flash(
                'english_program_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.english.programs.edit',
                [
                    'id' =>
                        $programId,
                ]
            );
        }

        EnglishProgram::update(
            $programId,
            $data,
            $userId
        );

        Session::flash(
            'success',
            'رشته انگلیسی با موفقیت ویرایش شد.'
        );

        Response::redirectRoute(
            'admin.english.programs.index'
        );
    }


    /**
     * Delete program.
     */
    public function delete(
        string $id
    ): never {
        Csrf::requireValid();

        $programId =
            $this->positiveId(
                $id
            );

        if (
            EnglishProgram::find(
                $programId
            ) === null
        ) {
            Session::flash(
                'error',
                'رشته انگلیسی مورد نظر پیدا نشد.'
            );

            Response::redirectRoute(
                'admin.english.programs.index'
            );
        }

        EnglishProgram::delete(
            $programId
        );

        Session::flash(
            'success',
            'رشته انگلیسی با موفقیت حذف شد.'
        );

        Response::redirectRoute(
            'admin.english.programs.index'
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
                EnglishProgram::generateUniqueSlug(
                    $name
                );
        } else {
            $slug =
                EnglishProgram::slugify(
                    $slug
                );
        }

        return [
            'faculty_id' =>
                (int) (
                    $_POST['faculty_id']
                    ?? 0
                ),

            'slug' =>
                $slug,

            'name' =>
                $name,

            'degree' =>
                $this->nullableString(
                    $_POST['degree']
                    ?? null
                ),

            'field' =>
                $this->nullableString(
                    $_POST['field']
                    ?? null
                ),

            'description' =>
                $this->nullableString(
                    $_POST['description']
                    ?? null
                ),

            'duration' =>
                $this->nullableString(
                    $_POST['duration']
                    ?? null
                ),

            'admission_info' =>
                $this->nullableString(
                    $_POST['admission_info']
                    ?? null
                ),

            'curriculum' =>
                $this->nullableString(
                    $_POST['curriculum']
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
     * Validate program.
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

        $facultyId =
            (int) (
                $data['faculty_id']
                ?? 0
            );

        if (
            $facultyId <= 0
        ) {
            $errors['faculty_id'] =
                'Please select an English faculty.';
        } elseif (
            EnglishFaculty::find(
                $facultyId
            ) === null
        ) {
            $errors['faculty_id'] =
                'The selected faculty does not exist.';
        }

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
                'English program name is required.';
        } elseif (
            mb_strlen(
                $name,
                'UTF-8'
            ) > 255
        ) {
            $errors['name'] =
                'Program name cannot exceed 255 characters.';
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
            EnglishProgram::slugExists(
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
                'شناسه رشته انگلیسی معتبر نیست.'
            );
        }

        return (int) $value;
    }
}
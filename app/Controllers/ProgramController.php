<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Faculty;
use App\Models\Program;
use RuntimeException;

final class ProgramController
{
    /*
    |--------------------------------------------------------------------------
    | PUBLIC PROGRAMS
    |--------------------------------------------------------------------------
    */

    /**
     * Display all active academic programs.
     */
    public function publicIndex(): string
    {
        $faculties = Faculty::active();

        $programs = Program::active();

        return View::renderIntoLayout(
            'layouts/app',
            'programs/index',
            [
                'title' =>
                    'رشته‌ها و برنامه‌های آموزشی | صدرا',

                'description' =>
                    'فهرست رشته‌ها و برنامه‌های آموزشی موسسه آموزش عالی صدرالمتالهین.',

                'faculties' =>
                    is_array($faculties)
                        ? $faculties
                        : [],

                'programs' =>
                    is_array($programs)
                        ? $programs
                        : [],
            ]
        );
    }

    /**
     * Display one public academic program.
     */
    public function show(
        string $slug
    ): string {
        $slug = trim($slug);

        if ($slug === '') {
            Response::notFound(
                'رشته مورد نظر پیدا نشد.'
            );
        }

        $program =
            Program::findPublishedBySlug(
                $slug
            );

        if ($program === null) {
            Response::notFound(
                'رشته مورد نظر پیدا نشد.'
            );
        }

        $programName =
            (string) (
                $program['name']
                ?? 'رشته آموزشی'
            );

        return View::renderIntoLayout(
            'layouts/app',
            'programs/show',
            [
                'title' =>
                    $programName
                    . ' | صدرا',

                'description' =>
                    $this->publicDescription(
                        $program
                    ),

                'program' =>
                    $program,
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN PROGRAMS
    |--------------------------------------------------------------------------
    */

    /**
     * Display the admin program list.
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

        $programs =
            Program::paginate(
                $page,
                20
            );

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/programs/index',
            [
                'title' =>
                    'رشته‌ها و برنامه‌ها | صدرا',

                'programs' =>
                    $programs,

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
                'program_form'
            );

        $formErrors =
            Session::getFlash(
                'program_errors'
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

        if (is_array($form)) {
            $program =
                array_merge(
                    $program,
                    $form
                );
        }

        $faculties =
            Faculty::active();

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/programs/create',
            [
                'title' =>
                    'ایجاد رشته | صدرا',

                'program' =>
                    $program,

                'faculties' =>
                    is_array($faculties)
                        ? $faculties
                        : [],

                'errors' =>
                    is_array($formErrors)
                        ? $formErrors
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

        if ($userId === null) {
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

        if ($errors !== []) {
            Session::flash(
                'program_form',
                $data
            );

            Session::flash(
                'program_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.programs.create'
            );
        }

        /*
         * Generate a slug automatically when the
         * administrator leaves it empty.
         */
        if (
            trim(
                (string) (
                    $data['slug']
                    ?? ''
                )
            ) === ''
        ) {
            $data['slug'] =
                Program::generateUniqueSlug(
                    (string) $data['name']
                );
        }

        /*
         * Validate once more after automatic slug generation.
         */
        $errors =
            $this->validate(
                $data
            );

        if ($errors !== []) {
            Session::flash(
                'program_form',
                $data
            );

            Session::flash(
                'program_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.programs.create'
            );
        }

        try {
            Program::create(
                $data,
                $userId
            );
        } catch (RuntimeException $exception) {
            Session::flash(
                'program_form',
                $data
            );

            Session::flash(
                'error',
                $exception->getMessage()
            );

            Response::redirectRoute(
                'admin.programs.create'
            );
        }

        Session::flash(
            'success',
            'رشته با موفقیت ایجاد شد.'
        );

        Response::redirectRoute(
            'admin.programs.index'
        );
    }

    /**
     * Show edit form.
     */
    public function edit(
        string $id
    ): string {
        $programId =
            $this->positiveId(
                $id
            );

        $program =
            Program::find(
                $programId
            );

        if ($program === null) {
            Response::notFound(
                'رشته مورد نظر پیدا نشد.'
            );
        }

        $form =
            Session::getFlash(
                'program_form'
            );

        $formErrors =
            Session::getFlash(
                'program_errors'
            );

        if (is_array($form)) {
            $program =
                array_merge(
                    $program,
                    $form
                );
        }

        $faculties =
            Faculty::active();

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/programs/edit',
            [
                'title' =>
                    'ویرایش رشته | صدرا',

                'program' =>
                    $program,

                'faculties' =>
                    is_array($faculties)
                        ? $faculties
                        : [],

                'errors' =>
                    is_array($formErrors)
                        ? $formErrors
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

        $existing =
            Program::find(
                $programId
            );

        if ($existing === null) {
            Response::notFound(
                'رشته مورد نظر پیدا نشد.'
            );
        }

        $userId =
            Session::userId();

        if ($userId === null) {
            Response::redirectRoute(
                'teacher.login'
            );
        }

        $data =
            $this->input();

        /*
         * Preserve the existing slug if the edit form
         * leaves it empty.
         */
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
                $programId
            );

        if ($errors !== []) {
            Session::flash(
                'program_form',
                $data
            );

            Session::flash(
                'program_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.programs.edit',
                [
                    'id' =>
                        $programId,
                ]
            );
        }

        try {
            $updated =
                Program::update(
                    $programId,
                    $data,
                    $userId
                );
        } catch (RuntimeException $exception) {
            Session::flash(
                'program_form',
                $data
            );

            Session::flash(
                'error',
                $exception->getMessage()
            );

            Response::redirectRoute(
                'admin.programs.edit',
                [
                    'id' =>
                        $programId,
                ]
            );
        }

        if (!$updated) {
            Session::flash(
                'error',
                'ویرایش رشته انجام نشد.'
            );

            Response::redirectRoute(
                'admin.programs.edit',
                [
                    'id' =>
                        $programId,
                ]
            );
        }

        Session::flash(
            'success',
            'رشته با موفقیت ویرایش شد.'
        );

        Response::redirectRoute(
            'admin.programs.index'
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

        $program =
            Program::find(
                $programId
            );

        if ($program === null) {
            Session::flash(
                'error',
                'رشته مورد نظر پیدا نشد.'
            );

            Response::redirectRoute(
                'admin.programs.index'
            );
        }

        try {
            $deleted =
                Program::delete(
                    $programId
                );
        } catch (RuntimeException $exception) {
            Session::flash(
                'error',
                $exception->getMessage()
            );

            Response::redirectRoute(
                'admin.programs.index'
            );
        }

        if (!$deleted) {
            Session::flash(
                'error',
                'حذف رشته انجام نشد.'
            );

            Response::redirectRoute(
                'admin.programs.index'
            );
        }

        Session::flash(
            'success',
            'رشته با موفقیت حذف شد.'
        );

        Response::redirectRoute(
            'admin.programs.index'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | INPUT
    |--------------------------------------------------------------------------
    */

    /**
     * Read submitted program data.
     *
     * @return array<string, mixed>
     */
    private function input(): array
    {
        return [
            'faculty_id' =>
                (int) (
                    $_POST['faculty_id']
                    ?? 0
                ),

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

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    /**
     * Validate a program.
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

        /*
         * Faculty.
         */
        $facultyId =
            (int) (
                $data['faculty_id']
                ?? 0
            );

        if ($facultyId <= 0) {
            $errors['faculty_id'] =
                'انتخاب دانشکده الزامی است.';
        } elseif (
            Faculty::find(
                $facultyId
            ) === null
        ) {
            $errors['faculty_id'] =
                'دانشکده انتخاب‌شده معتبر نیست.';
        }

        /*
         * Name.
         */
        $name =
            trim(
                (string) (
                    $data['name']
                    ?? ''
                )
            );

        if ($name === '') {
            $errors['name'] =
                'نام رشته الزامی است.';
        } elseif (
            mb_strlen(
                $name,
                'UTF-8'
            ) > 255
        ) {
            $errors['name'] =
                'نام رشته نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.';
        }

        /*
         * Slug.
         */
        $slug =
            trim(
                (string) (
                    $data['slug']
                    ?? ''
                )
            );

        if ($slug !== '') {

            if (
                !preg_match(
                    '/^[\p{L}\p{N}][\p{L}\p{N}\-_]*$/u',
                    $slug
                )
            ) {
                $errors['slug'] =
                    'شناسه URL رشته معتبر نیست.';
            }

            if (
                mb_strlen(
                    $slug,
                    'UTF-8'
                ) > 255
            ) {
                $errors['slug'] =
                    'شناسه URL نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.';
            }

            if (
                Program::slugExists(
                    $slug,
                    $ignoreId
                )
            ) {
                $errors['slug'] =
                    'این شناسه URL قبلاً استفاده شده است.';
            }
        }

        /*
         * Degree.
         */
        $degree =
            $data['degree']
            ?? null;

        if (
            is_string($degree)
            && mb_strlen(
                $degree,
                'UTF-8'
            ) > 100
        ) {
            $errors['degree'] =
                'مقطع تحصیلی نمی‌تواند بیشتر از ۱۰۰ کاراکتر باشد.';
        }

        /*
         * Field.
         */
        $field =
            $data['field']
            ?? null;

        if (
            is_string($field)
            && mb_strlen(
                $field,
                'UTF-8'
            ) > 255
        ) {
            $errors['field'] =
                'نام گرایش نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.';
        }

        return $errors;
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Build public description.
     *
     * @param array<string, mixed> $program
     */
    private function publicDescription(
        array $program
    ): string {
        $description =
            trim(
                (string) (
                    $program['description']
                    ?? ''
                )
            );

        if ($description === '') {
            return
                'اطلاعات رشته '
                . (string) (
                    $program['name']
                    ?? ''
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
     * Convert empty text to null.
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
     * Validate and normalize a positive integer ID.
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

        if ($value === false) {
            Response::notFound(
                'شناسه رشته معتبر نیست.'
            );
        }

        return (int) $value;
    }
}
<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Faculty;
use App\Models\People;
use App\Models\Program;
use RuntimeException;

final class FacultyController
{
    /*
    |--------------------------------------------------------------------------
    | PUBLIC
    |--------------------------------------------------------------------------
    */

    /**
     * Display all active faculties.
     */
    public function publicIndex(): string
    {
        $faculties =
            Faculty::active();

        return View::renderIntoLayout(
            'layouts/app',
            'faculties/index',
            [
                'title' =>
                    'دانشکده‌ها | صدرا',

                'description' =>
                    'معرفی دانشکده‌ها و گروه‌های آموزشی موسسه آموزش عالی صدرالمتالهین.',

                'faculties' =>
                    is_array($faculties)
                        ? $faculties
                        : [],
            ]
        );
    }

    /**
     * Display a single public faculty.
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
                'دانشکده مورد نظر پیدا نشد.'
            );
        }

        $faculty =
            Faculty::findActiveBySlug(
                $slug
            );

        if (
            $faculty === null
        ) {
            Response::notFound(
                'دانشکده مورد نظر پیدا نشد.'
            );
        }

        $facultyId =
            (int) (
                $faculty['id']
                ?? 0
            );

        $programs =
            $facultyId > 0
                ? Program::byFaculty(
                    $facultyId
                )
                : [];

        $people =
            $facultyId > 0
                ? People::byFaculty(
                    $facultyId
                )
                : [];

        $facultyName =
            (string) (
                $faculty['name']
                ?? 'دانشکده'
            );

        return View::renderIntoLayout(
            'layouts/app',
            'faculties/show',
            [
                'title' =>
                    $facultyName
                    . ' | صدرا',

                'description' =>
                    $this->publicDescription(
                        $faculty
                    ),

                'faculty' =>
                    $faculty,

                'programs' =>
                    is_array($programs)
                        ? $programs
                        : [],

                'people' =>
                    is_array($people)
                        ? $people
                        : [],
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    /**
     * Display the admin faculty list.
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
            Faculty::paginate(
                $page,
                20
            );

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/faculties/index',
            [
                'title' =>
                    'دانشکده‌ها | صدرا',

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
     * Show create form.
     */
    public function create(): string
    {
        $form =
            Session::getFlash(
                'faculty_form'
            );

        $formErrors =
            Session::getFlash(
                'faculty_errors'
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

            'dean_person_id' =>
                null,

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
            'admin/faculties/create',
            [
                'title' =>
                    'ایجاد دانشکده | صدرا',

                'faculty' =>
                    $faculty,

                'people' =>
                    People::active(),

                'errors' =>
                    is_array($formErrors)
                        ? $formErrors
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
                'faculty_form',
                $data
            );

            Session::flash(
                'faculty_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.faculties.create'
            );
        }

        if (
            trim(
                (string) (
                    $data['slug']
                    ?? ''
                )
            ) === ''
        ) {
            $data['slug'] =
                Faculty::generateUniqueSlug(
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
                'faculty_form',
                $data
            );

            Session::flash(
                'faculty_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.faculties.create'
            );
        }

        try {
            Faculty::create(
                $data,
                $userId
            );
        } catch (
            RuntimeException $exception
        ) {
            Session::flash(
                'faculty_form',
                $data
            );

            Session::flash(
                'error',
                $exception->getMessage()
            );

            Response::redirectRoute(
                'admin.faculties.create'
            );
        }

        Session::flash(
            'success',
            'دانشکده با موفقیت ایجاد شد.'
        );

        Response::redirectRoute(
            'admin.faculties.index'
        );
    }

    /**
     * Show edit form.
     */
    public function edit(
        string $id
    ): string {
        $facultyId =
            $this->positiveId(
                $id
            );

        $faculty =
            Faculty::find(
                $facultyId
            );

        if (
            $faculty === null
        ) {
            Response::notFound(
                'دانشکده مورد نظر پیدا نشد.'
            );
        }

        $form =
            Session::getFlash(
                'faculty_form'
            );

        $formErrors =
            Session::getFlash(
                'faculty_errors'
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
            'admin/faculties/edit',
            [
                'title' =>
                    'ویرایش دانشکده | صدرا',

                'faculty' =>
                    $faculty,

                'people' =>
                    People::active(),

                'errors' =>
                    is_array($formErrors)
                        ? $formErrors
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

        $existing =
            Faculty::find(
                $facultyId
            );

        if (
            $existing === null
        ) {
            Response::notFound(
                'دانشکده مورد نظر پیدا نشد.'
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
                $facultyId
            );

        if (
            $errors !== []
        ) {
            Session::flash(
                'faculty_form',
                $data
            );

            Session::flash(
                'faculty_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.faculties.edit',
                [
                    'id' =>
                        $facultyId,
                ]
            );
        }

        try {
            $updated =
                Faculty::update(
                    $facultyId,
                    $data,
                    $userId
                );
        } catch (
            RuntimeException $exception
        ) {
            Session::flash(
                'faculty_form',
                $data
            );

            Session::flash(
                'error',
                $exception->getMessage()
            );

            Response::redirectRoute(
                'admin.faculties.edit',
                [
                    'id' =>
                        $facultyId,
                ]
            );
        }

        if (
            !$updated
        ) {
            Session::flash(
                'error',
                'ویرایش دانشکده انجام نشد.'
            );

            Response::redirectRoute(
                'admin.faculties.edit',
                [
                    'id' =>
                        $facultyId,
                ]
            );
        }

        /*
         * The faculty model owns dean_person_id.
         * If a dean is assigned, keep the people record
         * independent from the faculty itself.
         */
        Session::flash(
            'success',
            'دانشکده با موفقیت ویرایش شد.'
        );

        Response::redirectRoute(
            'admin.faculties.index'
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

        $faculty =
            Faculty::find(
                $facultyId
            );

        if (
            $faculty === null
        ) {
            Session::flash(
                'error',
                'دانشکده مورد نظر پیدا نشد.'
            );

            Response::redirectRoute(
                'admin.faculties.index'
            );
        }

        /*
         * The database schema uses ON DELETE CASCADE
         * for programs belonging to a faculty.
         */
        try {
            $deleted =
                Faculty::delete(
                    $facultyId
                );
        } catch (
            RuntimeException $exception
        ) {
            Session::flash(
                'error',
                $exception->getMessage()
            );

            Response::redirectRoute(
                'admin.faculties.index'
            );
        }

        if (
            !$deleted
        ) {
            Session::flash(
                'error',
                'حذف دانشکده انجام نشد.'
            );

            Response::redirectRoute(
                'admin.faculties.index'
            );
        }

        Session::flash(
            'success',
            'دانشکده با موفقیت حذف شد.'
        );

        Response::redirectRoute(
            'admin.faculties.index'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | INPUT
    |--------------------------------------------------------------------------
    */

    /**
     * Read faculty form data.
     *
     * @return array<string, mixed>
     */
    private function input(): array
    {
        $deanPersonId =
            $_POST['dean_person_id']
            ?? null;

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

            'dean_person_id' =>
                $this->nullablePositiveId(
                    $deanPersonId
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

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

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
                'نام دانشکده الزامی است.';
        } elseif (
            mb_strlen(
                $name,
                'UTF-8'
            ) > 255
        ) {
            $errors['name'] =
                'نام دانشکده نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.';
        }

        $slug =
            trim(
                (string) (
                    $data['slug']
                    ?? ''
                )
            );

        if (
            $slug !== ''
        ) {
            if (
                !preg_match(
                    '/^[\p{L}\p{N}][\p{L}\p{N}\-_]*$/u',
                    $slug
                )
            ) {
                $errors['slug'] =
                    'شناسه URL دانشکده معتبر نیست.';
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
                Faculty::slugExists(
                    $slug,
                    $ignoreId
                )
            ) {
                $errors['slug'] =
                    'این شناسه URL قبلاً استفاده شده است.';
            }
        }

        $shortName =
            $data['short_name']
            ?? null;

        if (
            is_string($shortName)
            && mb_strlen(
                $shortName,
                'UTF-8'
            ) > 100
        ) {
            $errors['short_name'] =
                'نام کوتاه نمی‌تواند بیشتر از ۱۰۰ کاراکتر باشد.';
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

        $deanPersonId =
            $data['dean_person_id']
            ?? null;

        if (
            $deanPersonId !== null
            && People::find(
                (int) $deanPersonId
            ) === null
        ) {
            $errors['dean_person_id'] =
                'عضو انتخاب‌شده برای ریاست دانشکده معتبر نیست.';
        }

        $image =
            $data['image']
            ?? null;

        if (
            is_string($image)
            && $image !== ''
            && !$this->validUrl(
                $image
            )
        ) {
            $errors['image'] =
                'آدرس تصویر معتبر نیست.';
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
     * @param array<string, mixed> $faculty
     */
    private function publicDescription(
        array $faculty
    ): string {
        $description =
            trim(
                (string) (
                    $faculty['description']
                    ?? ''
                )
            );

        if (
            $description === ''
        ) {
            return
                'اطلاعات '
                . (string) (
                    $faculty['name']
                    ?? 'دانشکده'
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
     * Validate internal or absolute HTTP(S) URL.
     */
    private function validUrl(
        string $value
    ): bool {
        $value =
            trim($value);

        if (
            $value === ''
        ) {
            return true;
        }

        /*
         * Internal application paths.
         */
        if (
            str_starts_with(
                $value,
                '/'
            )
            && !str_starts_with(
                $value,
                '//'
            )
        ) {
            return true;
        }

        $parsed =
            parse_url(
                $value
            );

        if (
            !is_array($parsed)
        ) {
            return false;
        }

        $scheme =
            strtolower(
                (string) (
                    $parsed['scheme']
                    ?? ''
                )
            );

        $host =
            $parsed['host']
            ?? null;

        return in_array(
            $scheme,
            [
                'http',
                'https',
            ],
            true
        )
        && is_string($host)
        && $host !== '';
    }

    /**
     * Convert empty text to null.
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
            trim($value);

        return $value === ''
            ? null
            : $value;
    }

    /**
     * Convert an optional positive ID.
     */
    private function nullablePositiveId(
        mixed $value
    ): ?int {
        if (
            $value === null
            || $value === ''
        ) {
            return null;
        }

        $id =
            filter_var(
                $value,
                FILTER_VALIDATE_INT,
                [
                    'options' => [
                        'min_range' => 1,
                    ],
                ]
            );

        return $id === false
            ? null
            : (int) $id;
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
                'شناسه دانشکده معتبر نیست.'
            );
        }

        return (int) $value;
    }
}
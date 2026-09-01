<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\EnglishFaculty;
use App\Models\EnglishPeople;

final class EnglishPeopleController
{
    /**
     * English people list.
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
            'admin/english/people/index',
            [
                'title' =>
                    'افراد انگلیسی | صدرا',

                'people' =>
                    EnglishPeople::paginate(
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
     * Create person form.
     */
    public function create(): string
    {
        $form =
            Session::getFlash(
                'english_person_form'
            );

        $errors =
            Session::getFlash(
                'english_person_errors'
            );

        $person = [
            'faculty_id' =>
                null,

            'first_name' =>
                '',

            'last_name' =>
                '',

            'position' =>
                '',

            'email' =>
                '',

            'phone' =>
                '',

            'fax' =>
                '',

            'image' =>
                '',

            'biography' =>
                '',

            'office_location' =>
                '',

            'sort_order' =>
                0,

            'is_active' =>
                1,
        ];

        if (
            is_array($form)
        ) {
            $person =
                array_merge(
                    $person,
                    $form
                );
        }

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/english/people/create',
            [
                'title' =>
                    'ایجاد فرد انگلیسی | صدرا',

                'person' =>
                    $person,

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
     * Store person.
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
                'english_person_form',
                $data
            );

            Session::flash(
                'english_person_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.english.people.create'
            );
        }

        EnglishPeople::create(
            $data,
            $userId
        );

        Session::flash(
            'success',
            'فرد انگلیسی با موفقیت ایجاد شد.'
        );

        Response::redirectRoute(
            'admin.english.people.index'
        );
    }


    /**
     * Edit person.
     */
    public function edit(
        string $id
    ): string {
        $personId =
            $this->positiveId(
                $id
            );

        $person =
            EnglishPeople::find(
                $personId
            );

        if (
            $person === null
        ) {
            Response::notFound(
                'فرد انگلیسی مورد نظر پیدا نشد.'
            );
        }

        $form =
            Session::getFlash(
                'english_person_form'
            );

        $errors =
            Session::getFlash(
                'english_person_errors'
            );

        if (
            is_array($form)
        ) {
            $person =
                array_merge(
                    $person,
                    $form
                );
        }

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/english/people/edit',
            [
                'title' =>
                    'ویرایش فرد انگلیسی | صدرا',

                'person' =>
                    $person,

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
     * Update person.
     */
    public function update(
        string $id
    ): never {
        Csrf::requireValid();

        $personId =
            $this->positiveId(
                $id
            );

        if (
            EnglishPeople::find(
                $personId
            ) === null
        ) {
            Response::notFound(
                'فرد انگلیسی مورد نظر پیدا نشد.'
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
                $data
            );

        if (
            $errors !== []
        ) {
            Session::flash(
                'english_person_form',
                $data
            );

            Session::flash(
                'english_person_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.english.people.edit',
                [
                    'id' =>
                        $personId,
                ]
            );
        }

        EnglishPeople::update(
            $personId,
            $data,
            $userId
        );

        Session::flash(
            'success',
            'فرد انگلیسی با موفقیت ویرایش شد.'
        );

        Response::redirectRoute(
            'admin.english.people.index'
        );
    }


    /**
     * Delete person.
     */
    public function delete(
        string $id
    ): never {
        Csrf::requireValid();

        $personId =
            $this->positiveId(
                $id
            );

        if (
            EnglishPeople::find(
                $personId
            ) === null
        ) {
            Session::flash(
                'error',
                'فرد انگلیسی مورد نظر پیدا نشد.'
            );

            Response::redirectRoute(
                'admin.english.people.index'
            );
        }

        EnglishPeople::delete(
            $personId
        );

        Session::flash(
            'success',
            'فرد انگلیسی با موفقیت حذف شد.'
        );

        Response::redirectRoute(
            'admin.english.people.index'
        );
    }


    /**
     * Read form input.
     *
     * @return array<string, mixed>
     */
    private function input(): array
    {
        return [
            'faculty_id' =>
                $this->nullableInteger(
                    $_POST['faculty_id']
                    ?? null
                ),

            'first_name' =>
                trim(
                    (string) (
                        $_POST['first_name']
                        ?? ''
                    )
                ),

            'last_name' =>
                trim(
                    (string) (
                        $_POST['last_name']
                        ?? ''
                    )
                ),

            'position' =>
                $this->nullableString(
                    $_POST['position']
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

            'image' =>
                $this->nullableString(
                    $_POST['image']
                    ?? null
                ),

            'biography' =>
                $this->nullableString(
                    $_POST['biography']
                    ?? null
                ),

            'office_location' =>
                $this->nullableString(
                    $_POST['office_location']
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
     * Validate person.
     *
     * @param array<string, mixed> $data
     *
     * @return array<string, string>
     */
    private function validate(
        array $data
    ): array {
        $errors = [];

        $firstName =
            trim(
                (string) (
                    $data['first_name']
                    ?? ''
                )
            );

        $lastName =
            trim(
                (string) (
                    $data['last_name']
                    ?? ''
                )
            );

        if (
            $firstName === ''
        ) {
            $errors['first_name'] =
                'First name is required.';
        }

        if (
            $lastName === ''
        ) {
            $errors['last_name'] =
                'Last name is required.';
        }

        if (
            $firstName !== ''
            && mb_strlen(
                $firstName,
                'UTF-8'
            ) > 100
        ) {
            $errors['first_name'] =
                'First name cannot exceed 100 characters.';
        }

        if (
            $lastName !== ''
            && mb_strlen(
                $lastName,
                'UTF-8'
            ) > 100
        ) {
            $errors['last_name'] =
                'Last name cannot exceed 100 characters.';
        }

        $facultyId =
            $data['faculty_id']
            ?? null;

        if (
            $facultyId !== null
            && EnglishFaculty::find(
                (int) $facultyId
            ) === null
        ) {
            $errors['faculty_id'] =
                'The selected English faculty does not exist.';
        }

        $email =
            trim(
                (string) (
                    $data['email']
                    ?? ''
                )
            );

        if (
            $email !== ''
            && filter_var(
                $email,
                FILTER_VALIDATE_EMAIL
            ) === false
        ) {
            $errors['email'] =
                'Email address is invalid.';
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
                'شناسه فرد انگلیسی معتبر نیست.'
            );
        }

        return (int) $value;
    }
}
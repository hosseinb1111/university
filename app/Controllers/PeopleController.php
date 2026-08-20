<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Faculty;
use App\Models\People;

final class PeopleController
{
    /**
     * Admin people list.
     */
    public function index(): string
    {
        $page = max(
            1,
            (int) (
                $_GET['page'] ?? 1
            )
        );

        $facultyId =
            isset($_GET['faculty'])
                ? max(
                    1,
                    (int) $_GET['faculty']
                )
                : null;

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/people/index',
            [
                'title' =>
                    'اعضای هیئت علمی و کارکنان | صدرا',

                'people' =>
                    People::paginate(
                        $page,
                        20,
                        $facultyId
                    ),

                'faculties' =>
                    Faculty::active(),

                'selectedFaculty' =>
                    $facultyId,

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
            'admin/people/create',
            [
                'title' =>
                    'ایجاد شخص | صدرا',

                'person' => [
                    'user_id' => '',
                    'faculty_id' => '',
                    'first_name' => '',
                    'last_name' => '',
                    'position' => '',
                    'email' => '',
                    'phone' => '',
                    'fax' => '',
                    'image' => '',
                    'biography' => '',
                    'office_location' => '',
                    'sort_order' => 0,
                    'is_active' => 1,
                ],

                'faculties' =>
                    Faculty::active(),

                'errors' => [],
            ]
        );
    }

    /**
     * Store.
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
                'person_form',
                $data
            );

            Session::flash(
                'person_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.people.create'
            );
        }

        People::create(
            $data
        );

        Response::redirect(
            '/admin/people?success=created'
        );
    }

    /**
     * Edit.
     */
    public function edit(
        string $id
    ): string {
        $person =
            People::find(
                (int) $id
            );

        if (
            $person === null
        ) {
            Response::notFound(
                'شخص مورد نظر پیدا نشد.'
            );
        }

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/people/edit',
            [
                'title' =>
                    'ویرایش شخص | صدرا',

                'person' =>
                    $person,

                'faculties' =>
                    Faculty::active(),

                'errors' => [],
            ]
        );
    }

    /**
     * Update.
     */
    public function update(
        string $id
    ): never {
        Csrf::requireValid();

        $personId =
            (int) $id;

        if (
            People::find(
                $personId
            ) === null
        ) {
            Response::notFound(
                'شخص مورد نظر پیدا نشد.'
            );
        }

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
                'person_form',
                $data
            );

            Session::flash(
                'person_errors',
                $errors
            );

            Response::redirect(
                '/admin/people/'
                . $personId
                . '/edit'
            );
        }

        People::update(
            $personId,
            $data
        );

        Response::redirect(
            '/admin/people?success=updated'
        );
    }

    /**
     * Delete.
     */
    public function delete(
        string $id
    ): never {
        Csrf::requireValid();

        $personId =
            (int) $id;

        if (
            People::find(
                $personId
            ) === null
        ) {
            Response::notFound(
                'شخص مورد نظر پیدا نشد.'
            );
        }

        People::delete(
            $personId
        );

        Response::redirect(
            '/admin/people?success=deleted'
        );
    }

    /**
     * Public people list.
     */
    public function publicIndex(): string
    {
        return View::renderIntoLayout(
            'layouts/app',
            'people/index',
            [
                'title' =>
                    'اعضای هیئت علمی و کارکنان | صدرا',

                'people' =>
                    People::all(
                        true
                    ),
            ]
        );
    }

    /**
     * Public person profile.
     */
    public function show(
        string $id
    ): string {
        $person =
            People::findActive(
                (int) $id
            );

        if (
            $person === null
        ) {
            Response::notFound(
                'اطلاعات شخص مورد نظر پیدا نشد.'
            );
        }

        return View::renderIntoLayout(
            'layouts/app',
            'people/show',
            [
                'title' =>
                    trim(
                        $person['first_name']
                        . ' '
                        . $person['last_name']
                    )
                    . ' | صدرا',

                'person' =>
                    $person,
            ]
        );
    }

    /**
     * Collect input.
     *
     * @return array<string, mixed>
     */
    private function collectInput(): array
    {
        $facultyId = null;

        if (
            isset(
                $_POST['faculty_id']
            )
            && $_POST['faculty_id'] !== ''
        ) {
            $facultyId =
                (int) $_POST['faculty_id'];

            if (
                $facultyId <= 0
            ) {
                $facultyId = null;
            }
        }

        $userId = null;

        if (
            isset(
                $_POST['user_id']
            )
            && $_POST['user_id'] !== ''
        ) {
            $userId =
                (int) $_POST['user_id'];

            if (
                $userId <= 0
            ) {
                $userId = null;
            }
        }

        return [
            'user_id' =>
                $userId,

            'faculty_id' =>
                $facultyId,

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
                $this->nullable(
                    $_POST['position']
                    ?? null
                ),

            'email' =>
                $this->nullable(
                    $_POST['email']
                    ?? null
                ),

            'phone' =>
                $this->nullable(
                    $_POST['phone']
                    ?? null
                ),

            'fax' =>
                $this->nullable(
                    $_POST['fax']
                    ?? null
                ),

            'image' =>
                $this->nullable(
                    $_POST['image']
                    ?? null
                ),

            'biography' =>
                $this->nullable(
                    $_POST['biography']
                    ?? null
                ),

            'office_location' =>
                $this->nullable(
                    $_POST['office_location']
                    ?? null
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
     * Validate input.
     *
     * @return array<string, string>
     */
    private function validate(
        array $data
    ): array {
        $errors = [];

        if (
            trim(
                (string) (
                    $data['first_name']
                    ?? ''
                )
            ) === ''
        ) {
            $errors['first_name'] =
                'نام الزامی است.';
        }

        if (
            trim(
                (string) (
                    $data['last_name']
                    ?? ''
                )
            ) === ''
        ) {
            $errors['last_name'] =
                'نام خانوادگی الزامی است.';
        }

        if (
            !empty($data['email'])
            && filter_var(
                $data['email'],
                FILTER_VALIDATE_EMAIL
            ) === false
        ) {
            $errors['email'] =
                'ایمیل معتبر نیست.';
        }

        if (
            !empty($data['faculty_id'])
            && Faculty::find(
                (int) $data['faculty_id']
            ) === null
        ) {
            $errors['faculty_id'] =
                'دانشکده انتخاب‌شده معتبر نیست.';
        }

        return $errors;
    }

    /**
     * Nullable string.
     */
    private function nullable(
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
     * Success messages.
     */
    private function successMessage(): ?string
    {
        $messages = [
            'created' =>
                'شخص با موفقیت ایجاد شد.',

            'updated' =>
                'اطلاعات شخص با موفقیت ویرایش شد.',

            'deleted' =>
                'شخص با موفقیت حذف شد.',
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
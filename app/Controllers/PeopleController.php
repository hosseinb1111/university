<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Faculty;
use App\Models\People;
use App\Models\SiteSetting;
use RuntimeException;

final class PeopleController
{
    /**
     * Admin people list.
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

        $facultyId =
            isset(
                $_GET['faculty']
            )
                ? filter_var(
                    $_GET['faculty'],
                    FILTER_VALIDATE_INT,
                    [
                        'options' => [
                            'min_range' => 1,
                        ],
                    ]
                )
                : null;

        if (
            $facultyId === false
        ) {
            $facultyId = null;
        }

        if (
            $facultyId !== null
        ) {
            $facultyId =
                (int) $facultyId;

            $items =
                People::byFaculty(
                    $facultyId
                );

            $people = [
                'items' =>
                    $items,

                'total' =>
                    count($items),

                'page' =>
                    1,

                'perPage' =>
                    max(
                        1,
                        count($items)
                    ),

                'totalPages' =>
                    1,
            ];
        } else {
            $people =
                People::paginate(
                    $page,
                    20
                );
        }

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/people/index',
            [
                'title' =>
                    'اعضای هیئت علمی و کارکنان | صدرا',

                'people' =>
                    $people,

                'faculties' =>
                    Faculty::active(),

                'selectedFaculty' =>
                    $facultyId,

                'presidentId' =>
                    $this->presidentId(),

                'success' =>
                    $this->successMessage(),

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
        $defaultPerson = [
            'user_id' =>
                '',

            'faculty_id' =>
                '',

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

        /*
         * Restore submitted form values after validation failure.
         */
        $flashedPerson =
            Session::getFlash(
                'person_form'
            );

        $person =
            is_array($flashedPerson)
                ? array_merge(
                    $defaultPerson,
                    $flashedPerson
                )
                : $defaultPerson;

        $flashedErrors =
            Session::getFlash(
                'person_errors'
            );

        $errors =
            is_array($flashedErrors)
                ? $flashedErrors
                : [];

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/people/create',
            [
                'title' =>
                    'ایجاد شخص | صدرا',

                'person' =>
                    $person,

                'faculties' =>
                    Faculty::active(),

                'presidentId' =>
                    $this->presidentId(),

                'errors' =>
                    $errors,
            ]
        );
    }

    /**
     * Store a person.
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

            Session::flash(
                'person_is_president',
                $this->isPresidentInput()
            );

            Response::redirectRoute(
                'admin.people.create'
            );
        }

        try {
            $personId =
                People::create(
                    $data
                );
        } catch (
            RuntimeException $exception
        ) {
            Session::flash(
                'person_form',
                $data
            );

            Session::flash(
                'person_errors',
                [
                    'general' =>
                        $exception->getMessage(),
                ]
            );

            Session::flash(
                'person_is_president',
                $this->isPresidentInput()
            );

            Response::redirectRoute(
                'admin.people.create'
            );
        }

        /*
         * A newly created person can immediately become
         * the president.
         */
        if (
            $this->isPresidentInput()
        ) {
            $this->setPresidentId(
                $personId
            );
        }

        Response::redirect(
            '/admin/people?success=created'
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
            People::find(
                $personId
            );

        if (
            $person === null
        ) {
            Response::notFound(
                'شخص مورد نظر پیدا نشد.'
            );
        }

        /*
         * Restore form after failed update.
         */
        $flashedPerson =
            Session::getFlash(
                'person_form'
            );

        if (
            is_array($flashedPerson)
        ) {
            $person =
                array_merge(
                    $person,
                    $flashedPerson
                );
        }

        $flashedErrors =
            Session::getFlash(
                'person_errors'
            );

        $errors =
            is_array($flashedErrors)
                ? $flashedErrors
                : [];

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

                'presidentId' =>
                    $this->presidentId(),

                'errors' =>
                    $errors,
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

            Session::flash(
                'person_is_president',
                $this->isPresidentInput()
            );

            Response::redirect(
                '/admin/people/'
                . $personId
                . '/edit'
            );
        }

        try {
            $updated =
                People::update(
                    $personId,
                    $data
                );
        } catch (
            RuntimeException $exception
        ) {
            Session::flash(
                'person_form',
                $data
            );

            Session::flash(
                'person_errors',
                [
                    'general' =>
                        $exception->getMessage(),
                ]
            );

            Session::flash(
                'person_is_president',
                $this->isPresidentInput()
            );

            Response::redirect(
                '/admin/people/'
                . $personId
                . '/edit'
            );
        }

        if (
            !$updated
        ) {
            Session::flash(
                'person_form',
                $data
            );

            Session::flash(
                'person_errors',
                [
                    'general' =>
                        'ویرایش اطلاعات شخص انجام نشد.',
                ]
            );

            Session::flash(
                'person_is_president',
                $this->isPresidentInput()
            );

            Response::redirect(
                '/admin/people/'
                . $personId
                . '/edit'
            );
        }

        /*
         * The president designation is intentionally
         * stored separately from the people table.
         */
        if (
            $this->isPresidentInput()
        ) {
            $this->setPresidentId(
                $personId
            );
        } elseif (
            $this->presidentId() === $personId
        ) {
            $this->clearPresidentId();
        }

        Response::redirect(
            '/admin/people?success=updated'
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
            People::find(
                $personId
            ) === null
        ) {
            Response::notFound(
                'شخص مورد نظر پیدا نشد.'
            );
        }

        /*
         * If the person is currently president,
         * clear the designation before deletion.
         */
        if (
            $this->presidentId() === $personId
        ) {
            $this->clearPresidentId();
        }

        try {
            $deleted =
                People::delete(
                    $personId
                );
        } catch (
            RuntimeException $exception
        ) {
            Session::flash(
                'error',
                $exception->getMessage()
            );

            Response::redirect(
                '/admin/people'
            );
        }

        if (
            !$deleted
        ) {
            Session::flash(
                'error',
                'حذف شخص انجام نشد.'
            );

            Response::redirect(
                '/admin/people'
            );
        }

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
                    People::active(),
            ]
        );
    }

    /**
     * Public person profile.
     */
    public function show(
        string $id
    ): string {
        $personId =
            $this->positiveId(
                $id
            );

        $person =
            People::findActive(
                $personId
            );

        if (
            $person === null
        ) {
            Response::notFound(
                'اطلاعات شخص مورد نظر پیدا نشد.'
            );
        }

        $firstName =
            trim(
                (string) (
                    $person['first_name']
                    ?? ''
                )
            );

        $lastName =
            trim(
                (string) (
                    $person['last_name']
                    ?? ''
                )
            );

        $fullName =
            trim(
                $firstName
                . ' '
                . $lastName
            );

        return View::renderIntoLayout(
            'layouts/app',
            'people/show',
            [
                'title' =>
                    (
                        $fullName !== ''
                            ? $fullName
                            : 'عضو موسسه'
                    )
                    . ' | صدرا',

                'person' =>
                    $person,
            ]
        );
    }

    /**
     * Collect and normalize form input.
     *
     * @return array<string, mixed>
     */
    private function collectInput(): array
    {
        $facultyId =
            $this->nullablePositiveInt(
                $_POST['faculty_id']
                ?? null
            );

        $userId =
            $this->nullablePositiveInt(
                $_POST['user_id']
                ?? null
            );

        return [
            'user_id' =>
                $userId,

            'faculty_id' =>
                $facultyId,

            'first_name' =>
                $this->requiredString(
                    $_POST['first_name']
                    ?? ''
                ),

            'last_name' =>
                $this->requiredString(
                    $_POST['last_name']
                    ?? ''
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
     * Determine whether current form selected
     * this person as the president.
     */
    private function isPresidentInput(): bool
    {
        return isset(
            $_POST['is_president']
        )
        && (string) $_POST['is_president'] === '1';
    }

    /**
     * Get current president person ID.
     */
    private function presidentId(): ?int
    {
        $value =
            SiteSetting::get(
                'institution.president_person_id'
            );

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
     * Set current president.
     */
    private function setPresidentId(
        int $personId
    ): void {
        SiteSetting::set(
            'institution.president_person_id',
            (string) $personId
        );
    }

    /**
     * Clear current president.
     */
    private function clearPresidentId(): void
    {
        SiteSetting::set(
            'institution.president_person_id',
            ''
        );
    }

    /**
     * Validate person input.
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

        if (
            $firstName === ''
        ) {
            $errors['first_name'] =
                'نام الزامی است.';
        } elseif (
            mb_strlen(
                $firstName,
                'UTF-8'
            ) > 100
        ) {
            $errors['first_name'] =
                'نام نمی‌تواند بیشتر از ۱۰۰ کاراکتر باشد.';
        }

        $lastName =
            trim(
                (string) (
                    $data['last_name']
                    ?? ''
                )
            );

        if (
            $lastName === ''
        ) {
            $errors['last_name'] =
                'نام خانوادگی الزامی است.';
        } elseif (
            mb_strlen(
                $lastName,
                'UTF-8'
            ) > 100
        ) {
            $errors['last_name'] =
                'نام خانوادگی نمی‌تواند بیشتر از ۱۰۰ کاراکتر باشد.';
        }

        $position =
            $data['position']
            ?? null;

        if (
            is_string($position)
            && mb_strlen(
                $position,
                'UTF-8'
            ) > 255
        ) {
            $errors['position'] =
                'سمت نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.';
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
                'ایمیل معتبر نیست.';
        }

        $facultyId =
            $data['faculty_id']
            ?? null;

        if (
            $facultyId !== null
        ) {
            $faculty =
                Faculty::find(
                    (int) $facultyId
                );

            if (
                $faculty === null
            ) {
                $errors['faculty_id'] =
                    'دانشکده انتخاب‌شده معتبر نیست.';
            }
        }

        $userId =
            $data['user_id']
            ?? null;

        if (
            $userId !== null
            && (int) $userId <= 0
        ) {
            $errors['user_id'] =
                'شناسه حساب کاربری معتبر نیست.';
        }

        $image =
            $data['image']
            ?? null;

        if (
            is_string($image)
            && $image !== ''
            && !$this->validImageReference(
                $image
            )
        ) {
            $errors['image'] =
                'آدرس تصویر معتبر نیست.';
        }

        $sortOrder =
            (int) (
                $data['sort_order']
                ?? 0
            );

        if (
            $sortOrder < 0
        ) {
            $errors['sort_order'] =
                'ترتیب نمایش نمی‌تواند منفی باشد.';
        }

        return $errors;
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
                'شناسه معتبر نیست.'
            );
        }

        return (int) $value;
    }

    /**
     * Convert a nullable numeric input
     * to a positive integer or null.
     */
    private function nullablePositiveInt(
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
     * Normalize nullable text.
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
     * Normalize a required text value.
     */
    private function requiredString(
        mixed $value
    ): string {
        if (
            !is_string($value)
        ) {
            return '';
        }

        return trim($value);
    }

    /**
     * Validate image path or URL.
     */
    private function validImageReference(
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
         * Allow internal application paths.
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
<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\Faculty;
use App\Models\People;
use App\Models\User;

final class TeacherController
{
    /**
     * Teacher dashboard.
     */
    public function dashboard(): string
    {
        $userId =
            Session::userId();

        if (
            $userId === null
        ) {
            Response::redirectRoute(
                'teacher.login'
            );
        }

        $user =
            User::find(
                $userId
            );

        if (
            $user === null
        ) {
            Session::logout();

            Response::redirectRoute(
                'teacher.login'
            );
        }

        $person =
            $this->personForUser(
                $userId
            );

        return View::renderIntoLayout(
            'layouts/teacher',
            'teacher/dashboard',
            [
                'title' =>
                    'پنل اعضای هیئت علمی | صدرا',

                'user' =>
                    $user,

                'person' =>
                    $person,
            ]
        );
    }

    /**
     * Teacher profile.
     *
     * The academic profile is automatically created when
     * the account does not have a people record yet.
     */
    public function profile(): string
    {
        $userId =
            Session::userId();

        if (
            $userId === null
        ) {
            Response::redirectRoute(
                'teacher.login'
            );
        }

        $user =
            User::find(
                $userId
            );

        if (
            $user === null
        ) {
            Session::logout();

            Response::redirectRoute(
                'teacher.login'
            );
        }

        $person =
            $this->personForUser(
                $userId
            );

        $faculties =
            Faculty::active();

        return View::renderIntoLayout(
            'layouts/teacher',
            'teacher/profile',
            [
                'title' =>
                    'پروفایل | پنل صدرا',

                'user' =>
                    $user,

                'person' =>
                    $person,

                'faculties' =>
                    $faculties,

                'success' =>
                    Session::getFlash(
                        'teacher_success'
                    ),

                'profileErrors' =>
                    Session::getFlash(
                        'teacher_profile_errors'
                    ),

                'passwordErrors' =>
                    Session::getFlash(
                        'teacher_password_errors'
                    ),
            ]
        );
    }

    /**
     * Update teacher's own academic profile.
     *
     * Teachers may edit their own public-profile information,
     * including their faculty selection.
     *
     * The following fields remain controlled by administrators:
     *
     * - username
     * - role
     * - position
     * - account status
     * - display order
     *
     * The teacher may edit:
     *
     * - faculty
     * - first name
     * - last name
     * - email
     * - phone
     * - office location
     * - biography
     */
    public function updateProfile(): never
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

        $user =
            User::find(
                $userId
            );

        if (
            $user === null
        ) {
            Session::logout();

            Response::redirectRoute(
                'teacher.login'
            );
        }

        /*
         * Always resolve the profile from the authenticated
         * user ID. Never trust a submitted person ID.
         */
        $person =
            $this->personForUser(
                $userId
            );

        if (
            $person === null
        ) {
            Session::flash(
                'teacher_profile_errors',
                [
                    'general' =>
                        'پروفایل دانشگاهی حساب شما قابل ایجاد نیست. لطفاً مدیر سیستم را مطلع کنید.',
                ]
            );

            Response::redirectRoute(
                'teacher.profile'
            );
        }

        /*
         * Faculty selection.
         *
         * Empty value means:
         *     دانشکده ثبت نشده
         */
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

        $firstName =
            trim(
                (string) (
                    $_POST['first_name']
                    ?? ''
                )
            );

        $lastName =
            trim(
                (string) (
                    $_POST['last_name']
                    ?? ''
                )
            );

        $email =
            trim(
                (string) (
                    $_POST['email']
                    ?? ''
                )
            );

        $phone =
            trim(
                (string) (
                    $_POST['phone']
                    ?? ''
                )
            );

        $officeLocation =
            trim(
                (string) (
                    $_POST['office_location']
                    ?? ''
                )
            );

        $biography =
            trim(
                (string) (
                    $_POST['biography']
                    ?? ''
                )
            );

        $errors = [];

        if (
            $firstName === ''
        ) {
            $errors['first_name'] =
                'نام الزامی است.';
        }

        if (
            $lastName === ''
        ) {
            $errors['last_name'] =
                'نام خانوادگی الزامی است.';
        }

        if (
            $email !== ''
            && filter_var(
                $email,
                FILTER_VALIDATE_EMAIL
            ) === false
        ) {
            $errors['email'] =
                'ایمیل معتبر نیست.';
        }

        /*
         * Validate selected faculty.
         *
         * A null faculty is allowed and means
         * "دانشکده ثبت نشده".
         */
        if (
            $facultyId !== null
            && Faculty::find(
                $facultyId
            ) === null
        ) {
            $errors['faculty_id'] =
                'دانشکده انتخاب‌شده معتبر نیست.';
        }

        if (
            mb_strlen(
                $firstName,
                'UTF-8'
            ) > 100
        ) {
            $errors['first_name'] =
                'نام نمی‌تواند بیشتر از ۱۰۰ کاراکتر باشد.';
        }

        if (
            mb_strlen(
                $lastName,
                'UTF-8'
            ) > 100
        ) {
            $errors['last_name'] =
                'نام خانوادگی نمی‌تواند بیشتر از ۱۰۰ کاراکتر باشد.';
        }

        if (
            mb_strlen(
                $email,
                'UTF-8'
            ) > 255
        ) {
            $errors['email'] =
                'ایمیل نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.';
        }

        if (
            mb_strlen(
                $phone,
                'UTF-8'
            ) > 100
        ) {
            $errors['phone'] =
                'شماره تلفن نمی‌تواند بیشتر از ۱۰۰ کاراکتر باشد.';
        }

        if (
            mb_strlen(
                $officeLocation,
                'UTF-8'
            ) > 255
        ) {
            $errors['office_location'] =
                'محل دفتر نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.';
        }

        if (
            mb_strlen(
                $biography,
                'UTF-8'
            ) > 10000
        ) {
            $errors['biography'] =
                'متن معرفی نمی‌تواند بیشتر از ۱۰۰۰۰ کاراکتر باشد.';
        }

        if (
            $errors !== []
        ) {
            Session::flash(
                'teacher_profile_errors',
                $errors
            );

            Session::flash(
                'teacher_profile_form',
                [
                    'faculty_id' =>
                        $facultyId,

                    'first_name' =>
                        $firstName,

                    'last_name' =>
                        $lastName,

                    'email' =>
                        $email,

                    'phone' =>
                        $phone,

                    'office_location' =>
                        $officeLocation,

                    'biography' =>
                        $biography,
                ]
            );

            Response::redirectRoute(
                'teacher.profile'
            );
        }

        /*
         * Preserve administrator-controlled values.
         *
         * The teacher cannot secretly change:
         *
         * - position
         * - fax
         * - image
         * - sort order
         * - active state
         *
         * Faculty is intentionally NOT preserved here because
         * the teacher is now allowed to choose it.
         */
        People::update(
            (int) $person['id'],
            [
                'user_id' =>
                    $userId,

                'faculty_id' =>
                    $facultyId,

                'first_name' =>
                    $firstName,

                'last_name' =>
                    $lastName,

                'position' =>
                    $person['position']
                    ?? null,

                'email' =>
                    $email !== ''
                        ? $email
                        : null,

                'phone' =>
                    $phone !== ''
                        ? $phone
                        : null,

                'fax' =>
                    $person['fax']
                    ?? null,

                'image' =>
                    $person['image']
                    ?? null,

                'biography' =>
                    $biography !== ''
                        ? $biography
                        : null,

                'office_location' =>
                    $officeLocation !== ''
                        ? $officeLocation
                        : null,

                'sort_order' =>
                    (int) (
                        $person['sort_order']
                        ?? 0
                    ),

                'is_active' =>
                    (int) (
                        $person['is_active']
                        ?? 1
                    ),
            ]
        );

        /*
         * Keep the login account's basic identity synchronized.
         *
         * This means the teacher's name and email stay consistent
         * in both the account and the public academic profile.
         */
        User::update(
            $userId,
            [
                'username' =>
                    $user['username'],

                'email' =>
                    $email !== ''
                        ? $email
                        : null,

                'first_name' =>
                    $firstName,

                'last_name' =>
                    $lastName,

                'role' =>
                    $user['role'],

                'is_active' =>
                    (int) $user['is_active'],
            ]
        );

        Session::flash(
            'teacher_success',
            'پروفایل شما با موفقیت به‌روزرسانی شد.'
        );

        Response::redirectRoute(
            'teacher.profile'
        );
    }

    /**
     * Change own password.
     */
    public function changePassword(): never
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

        $user =
            User::find(
                $userId
            );

        if (
            $user === null
        ) {
            Session::logout();

            Response::redirectRoute(
                'teacher.login'
            );
        }

        $currentPassword =
            (string) (
                $_POST['current_password']
                ?? ''
            );

        $newPassword =
            (string) (
                $_POST['new_password']
                ?? ''
            );

        $confirmation =
            (string) (
                $_POST['new_password_confirmation']
                ?? ''
            );

        $minimumLength =
            (int) config(
                'app.security.minimum_password_length',
                8
            );

        $errors = [];

        if (
            $currentPassword === ''
            || !password_verify(
                $currentPassword,
                (string) $user['password']
            )
        ) {
            $errors['current_password'] =
                'رمز عبور فعلی صحیح نیست.';
        }

        if (
            mb_strlen(
                $newPassword,
                '8bit'
            ) < $minimumLength
        ) {
            $errors['new_password'] =
                'رمز عبور جدید باید حداقل '
                . $minimumLength
                . ' کاراکتر باشد.';
        }

        if (
            $newPassword !== $confirmation
        ) {
            $errors['new_password_confirmation'] =
                'تکرار رمز عبور صحیح نیست.';
        }

        if (
            $currentPassword !== ''
            && hash_equals(
                $currentPassword,
                $newPassword
            )
        ) {
            $errors['new_password'] =
                'رمز عبور جدید باید با رمز قبلی متفاوت باشد.';
        }

        if (
            $errors !== []
        ) {
            Session::flash(
                'teacher_password_errors',
                $errors
            );

            Response::redirectRoute(
                'teacher.profile'
            );
        }

        User::updatePassword(
            $userId,
            $newPassword
        );

        Session::flash(
            'teacher_success',
            'رمز عبور شما با موفقیت تغییر کرد.'
        );

        Response::redirectRoute(
            'teacher.profile'
        );
    }

    /**
     * Logout.
     */
    public function logout(): never
    {
        Csrf::requireValid();

        Session::logout();

        Response::redirectRoute(
            'teacher.login'
        );
    }

    /**
     * Get or create the faculty profile associated with the account.
     *
     * This is the important part of the teacher-profile flow.
     *
     * Existing linked profile:
     *     people.user_id = users.id
     *
     * Missing profile:
     *     create a basic people record from the user account.
     */
    private function personForUser(
        int $userId
    ): ?array {
        $person =
            People::findByUserId(
                $userId
            );

        if (
            $person !== null
        ) {
            return $person;
        }

        $user =
            User::find(
                $userId
            );

        if (
            $user === null
        ) {
            return null;
        }

        $firstName =
            trim(
                (string) (
                    $user['first_name']
                    ?? ''
                )
            );

        $lastName =
            trim(
                (string) (
                    $user['last_name']
                    ?? ''
                )
            );

        $email =
            trim(
                (string) (
                    $user['email']
                    ?? ''
                )
            );

        /*
         * Do not create a completely empty profile.
         *
         * Username is used only as a last-resort placeholder
         * for first name so the profile is immediately editable.
         */
        if (
            $firstName === ''
        ) {
            $firstName =
                trim(
                    (string) (
                        $user['username']
                        ?? ''
                    )
                );
        }

        try {
            $personId =
                People::create(
                    [
                        'user_id' =>
                            $userId,

                        'faculty_id' =>
                            null,

                        'first_name' =>
                            $firstName,

                        'last_name' =>
                            $lastName,

                        'position' =>
                            'عضو هیئت علمی',

                        'email' =>
                            $email !== ''
                                ? $email
                                : null,

                        'phone' =>
                            null,

                        'fax' =>
                            null,

                        'image' =>
                            null,

                        'biography' =>
                            null,

                        'office_location' =>
                            null,

                        'sort_order' =>
                            0,

                        'is_active' =>
                            1,
                    ],
                    $userId
                );

            if (
                $personId <= 0
            ) {
                return null;
            }

            return People::find(
                $personId
            );
        } catch (
            \Throwable $e
        ) {
            error_log(
                'Teacher academic profile creation failed: '
                . $e->getMessage()
            );

            return null;
        }
    }
}
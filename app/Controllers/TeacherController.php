<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\People;
use App\Models\User;

final class TeacherController
{
    /**
     * Teacher dashboard.
     */
    public function dashboard(): string
    {
        $userId = Session::userId();

        if ($userId === null) {
            Response::redirectRoute(
                'teacher.login'
            );
        }

        $user = User::find(
            $userId
        );

        if ($user === null) {
            Session::logout();

            Response::redirectRoute(
                'teacher.login'
            );
        }

        $person = $this->personForUser(
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
     */
    public function profile(): string
    {
        $userId = Session::userId();

        if ($userId === null) {
            Response::redirectRoute(
                'teacher.login'
            );
        }

        $user = User::find(
            $userId
        );

        if ($user === null) {
            Session::logout();

            Response::redirectRoute(
                'teacher.login'
            );
        }

        $person = $this->personForUser(
            $userId
        );

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

                'success' =>
                    Session::getFlash(
                        'teacher_success'
                    ),
            ]
        );
    }

    /**
     * Update teacher's own profile data.
     *
     * Account role and username cannot be changed here.
     */
    public function updateProfile(): never
    {
        Csrf::requireValid();

        $userId = Session::userId();

        if ($userId === null) {
            Response::redirectRoute(
                'teacher.login'
            );
        }

        $user = User::find(
            $userId
        );

        if ($user === null) {
            Session::logout();

            Response::redirectRoute(
                'teacher.login'
            );
        }

        $person = $this->personForUser(
            $userId
        );

        if ($person === null) {
            Session::flash(
                'teacher_success',
                'برای حساب شما هنوز پروفایل اعضای هیئت علمی ایجاد نشده است.'
            );

            Response::redirectRoute(
                'teacher.profile'
            );
        }

        $firstName = trim(
            (string) (
                $_POST['first_name']
                ?? ''
            )
        );

        $lastName = trim(
            (string) (
                $_POST['last_name']
                ?? ''
            )
        );

        $email = trim(
            (string) (
                $_POST['email']
                ?? ''
            )
        );

        $phone = trim(
            (string) (
                $_POST['phone']
                ?? ''
            )
        );

        $officeLocation = trim(
            (string) (
                $_POST['office_location']
                ?? ''
            )
        );

        $biography = trim(
            (string) (
                $_POST['biography']
                ?? ''
            )
        );

        $errors = [];

        if ($firstName === '') {
            $errors['first_name'] =
                'نام الزامی است.';
        }

        if ($lastName === '') {
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

        if ($errors !== []) {
            Session::flash(
                'teacher_profile_errors',
                $errors
            );

            Session::flash(
                'teacher_profile_form',
                [
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

        People::update(
            (int) $person['id'],
            [
                'user_id' =>
                    $userId,

                'faculty_id' =>
                    $person['faculty_id']
                    ?? null,

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
                    $person['sort_order']
                    ?? 0,

                'is_active' =>
                    1,
            ]
        );

        /*
         * Keep the authentication account's display name
         * synchronized with the faculty profile.
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

        if ($userId === null) {
            Response::redirectRoute(
                'teacher.login'
            );
        }

        $user =
            User::find(
                $userId
            );

        if ($user === null) {
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

        if ($errors !== []) {
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
     * Get the faculty profile associated with the account.
     */
    private function personForUser(
        int $userId
    ): ?array {
        $people =
            People::all(
                false
            );

        foreach (
            $people
            as $person
        ) {
            if (
                isset($person['user_id'])
                && (int) $person['user_id']
                    === $userId
            ) {
                return $person;
            }
        }

        return null;
    }
}
<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\User;

final class UserController
{
    /**
     * Admin user list.
     */
    public function index(): string
    {
        $page = max(
            1,
            (int) (
                $_GET['page'] ?? 1
            )
        );

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/users/index',
            [
                'title' =>
                    'مدیریت کاربران | صدرا',

                'users' =>
                    User::paginate(
                        $page,
                        20
                    ),

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
            'admin/users/create',
            [
                'title' =>
                    'ایجاد کاربر | صدرا',

                'user' => [
                    'username' => '',
                    'email' => '',
                    'first_name' => '',
                    'last_name' => '',
                    'role' => 'teacher',
                    'is_active' => 1,
                ],

                'errors' => [],
            ]
        );
    }

    /**
     * Store a new user.
     */
    public function store(): never
    {
        Csrf::requireValid();

        $data =
            $this->collectInput(
                true
            );

        $errors =
            $this->validate(
                $data,
                null,
                true
            );

        if ($errors !== []) {
            Session::flash(
                'user_form',
                $this->safeFormData(
                    $data
                )
            );

            Session::flash(
                'user_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.users.create'
            );
        }

        User::create(
            $data
        );

        Response::redirect(
            '/admin/users?success=created'
        );
    }

    /**
     * Edit form.
     */
    public function edit(
        string $id
    ): string {
        $user =
            User::find(
                (int) $id
            );

        if ($user === null) {
            Response::notFound(
                'کاربر مورد نظر پیدا نشد.'
            );
        }

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/users/edit',
            [
                'title' =>
                    'ویرایش کاربر | صدرا',

                'user' =>
                    $user,

                'errors' => [],
            ]
        );
    }

    /**
     * Update user.
     */
    public function update(
        string $id
    ): never {
        Csrf::requireValid();

        $userId =
            (int) $id;

        $existing =
            User::find(
                $userId
            );

        if ($existing === null) {
            Response::notFound(
                'کاربر مورد نظر پیدا نشد.'
            );
        }

        $currentUserId =
            Session::userId();

        $data =
            $this->collectInput(
                false
            );

        $errors =
            $this->validate(
                $data,
                $userId,
                false
            );

        /*
         * Prevent the current super admin from removing
         * their own administrative access.
         */
        if (
            $currentUserId === $userId
            && (
                $existing['role']
                ?? ''
            ) === 'super_admin'
        ) {
            if (
                $data['role']
                !== 'super_admin'
            ) {
                $errors['role'] =
                    'مدیر ارشد نمی‌تواند نقش حساب خودش را کاهش دهد.';
            }

            if (
                (int) $data['is_active'] !== 1
            ) {
                $errors['is_active'] =
                    'مدیر ارشد نمی‌تواند حساب خودش را غیرفعال کند.';
            }
        }

        /*
         * Never allow demoting the last super admin.
         */
        if (
            ($existing['role'] ?? '')
            === 'super_admin'
            && $data['role']
            !== 'super_admin'
        ) {
            if (
                self::superAdminCount()
                <= 1
            ) {
                $errors['role'] =
                    'حداقل یک مدیر ارشد باید در سیستم باقی بماند.';
            }
        }

        if ($errors !== []) {
            Session::flash(
                'user_form',
                $this->safeFormData(
                    $data
                )
            );

            Session::flash(
                'user_errors',
                $errors
            );

            Response::redirect(
                '/admin/users/'
                . $userId
                . '/edit'
            );
        }

        User::update(
            $userId,
            $data
        );

        if (
            !empty(
                $data['password']
            )
        ) {
            User::updatePassword(
                $userId,
                $data['password']
            );
        }

        /*
         * If a user disabled their own current session
         * through some future path, force logout.
         */
        if (
            $currentUserId === $userId
            && (int) $data['is_active'] !== 1
        ) {
            Session::logout();

            Response::redirectRoute(
                'teacher.login'
            );
        }

        Response::redirect(
            '/admin/users?success=updated'
        );
    }

    /**
     * Delete user.
     */
    public function delete(
        string $id
    ): never {
        Csrf::requireValid();

        $userId =
            (int) $id;

        $user =
            User::find(
                $userId
            );

        if ($user === null) {
            Response::notFound(
                'کاربر مورد نظر پیدا نشد.'
            );
        }

        $currentUserId =
            Session::userId();

        /*
         * Never delete yourself.
         */
        if (
            $currentUserId === $userId
        ) {
            Session::flash(
                'error',
                'نمی‌توانید حساب کاربری خودتان را حذف کنید.'
            );

            Response::redirect(
                '/admin/users'
            );
        }

        /*
         * Never delete the last super admin.
         */
        if (
            ($user['role'] ?? '')
            === 'super_admin'
            && self::superAdminCount()
            <= 1
        ) {
            Session::flash(
                'error',
                'آخرین مدیر ارشد سیستم قابل حذف نیست.'
            );

            Response::redirect(
                '/admin/users'
            );
        }

        User::delete(
            $userId
        );

        Response::redirect(
            '/admin/users?success=deleted'
        );
    }

    /**
     * Collect user form input.
     *
     * @return array<string, mixed>
     */
    private function collectInput(
        bool $passwordRequired
    ): array {
        $role =
            (string) (
                $_POST['role']
                ?? 'teacher'
            );

        if (
            !in_array(
                $role,
                [
                    'super_admin',
                    'admin',
                    'editor',
                    'teacher',
                ],
                true
            )
        ) {
            $role =
                'teacher';
        }

        return [
            'username' =>
                trim(
                    (string) (
                        $_POST['username']
                        ?? ''
                    )
                ),

            'email' =>
                trim(
                    (string) (
                        $_POST['email']
                        ?? ''
                    )
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

            'role' =>
                $role,

            'is_active' =>
                isset(
                    $_POST['is_active']
                )
                    ? 1
                    : 0,

            'password' =>
                (string) (
                    $_POST['password']
                    ?? ''
                ),

            'password_confirmation' =>
                (string) (
                    $_POST[
                        'password_confirmation'
                    ]
                    ?? ''
                ),
        ];
    }

    /**
     * Validate user input.
     *
     * @return array<string, string>
     */
    private function validate(
        array $data,
        ?int $ignoreId = null,
        bool $passwordRequired = false
    ): array {
        $errors = [];

        $username =
            trim(
                (string) (
                    $data['username']
                    ?? ''
                )
            );

        if (
            $username === ''
        ) {
            $errors['username'] =
                'نام کاربری الزامی است.';
        } elseif (
            !preg_match(
                '/^[A-Za-z0-9._-]{3,100}$/',
                $username
            )
        ) {
            $errors['username'] =
                'نام کاربری باید بین ۳ تا ۱۰۰ کاراکتر و شامل حروف انگلیسی، عدد، نقطه، خط تیره یا زیرخط باشد.';
        } elseif (
            User::usernameExists(
                $username,
                $ignoreId
            )
        ) {
            $errors['username'] =
                'این نام کاربری قبلاً استفاده شده است.';
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
                'ایمیل معتبر نیست.';
        }

        if (
            $email !== ''
            && User::emailExists(
                $email,
                $ignoreId
            )
        ) {
            $errors['email'] =
                'این ایمیل قبلاً استفاده شده است.';
        }

        $role =
            (string) (
                $data['role']
                ?? ''
            );

        if (
            !in_array(
                $role,
                [
                    'super_admin',
                    'admin',
                    'editor',
                    'teacher',
                ],
                true
            )
        ) {
            $errors['role'] =
                'نقش انتخاب‌شده معتبر نیست.';
        }

        $password =
            (string) (
                $data['password']
                ?? ''
            );

        $confirmation =
            (string) (
                $data['password_confirmation']
                ?? ''
            );

        $minimumLength =
            (int) config(
                'app.security.minimum_password_length',
                8
            );

        if (
            $passwordRequired
            && $password === ''
        ) {
            $errors['password'] =
                'رمز عبور الزامی است.';
        } elseif (
            $password !== ''
            && mb_strlen(
                $password,
                '8bit'
            ) < $minimumLength
        ) {
            $errors['password'] =
                'رمز عبور باید حداقل '
                . $minimumLength
                . ' کاراکتر باشد.';
        }

        if (
            $password !== ''
            && $password !== $confirmation
        ) {
            $errors['password_confirmation'] =
                'تکرار رمز عبور صحیح نیست.';
        }

        return $errors;
    }

    /**
     * Remove password values before flashing form data.
     */
    private function safeFormData(
        array $data
    ): array {
        $data['password'] = '';

        $data['password_confirmation'] = '';

        return $data;
    }

    /**
     * Count super administrators.
     */
    private static function superAdminCount(): int
    {
        $row =
            \App\Core\Database::first(
                '
                SELECT COUNT(*) AS total
                FROM users
                WHERE role = :role
                AND is_active = 1
                ',
                [
                    ':role' =>
                        'super_admin',
                ]
            );

        return (int) (
            $row['total']
            ?? 0
        );
    }

    /**
     * Flash success/error information.
     */
    private function successMessage(): ?string
    {
        $error =
            Session::getFlash(
                'error'
            );

        if (
            is_string($error)
            && $error !== ''
        ) {
            return $error;
        }

        $messages = [
            'created' =>
                'کاربر با موفقیت ایجاد شد.',

            'updated' =>
                'کاربر با موفقیت ویرایش شد.',

            'deleted' =>
                'کاربر با موفقیت حذف شد.',
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
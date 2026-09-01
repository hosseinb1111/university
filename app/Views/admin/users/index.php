<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\Session;
use App\Core\View;


$items =
    is_array(
        $users['items']
        ?? null
    )
        ? $users['items']
        : [];


$total =
    (int) (
        $users['total']
        ?? 0
    );


$pageNumber =
    max(
        1,
        (int) (
            $users['page']
            ?? 1
        )
    );


$totalPages =
    max(
        1,
        (int) (
            $users['totalPages']
            ?? 1
        )
    );


$error =
    Session::getFlash(
        'error'
    );


$roleLabels = [
    'super_admin' =>
        'مدیر ارشد',

    'admin' =>
        'مدیر',

    'editor' =>
        'ویراستار',

    'teacher' =>
        'عضو هیئت علمی',
];


$roleClasses = [
    'super_admin' =>
        'super-admin',

    'admin' =>
        'admin',

    'editor' =>
        'editor',

    'teacher' =>
        'teacher',
];

?>

<div class="admin-users">


    <!-- =========================================================
         HEADER
    ========================================================== -->

    <header class="admin-users__header">

        <div class="admin-users__header-main">

            <span class="admin-users__eyebrow">
                مدیریت دسترسی
            </span>


            <h1>
                کاربران
            </h1>


            <p>
                حساب‌های کاربری سامانه، نقش‌ها و وضعیت دسترسی کاربران را مدیریت کنید.
            </p>

        </div>


        <div class="admin-users__header-action">

            <a
                href="<?= View::route(
                    'admin.users.create'
                ) ?>"
                class="admin-users__create-button"
            >

                <span
                    class="admin-users__create-button-icon"
                    aria-hidden="true"
                >
                    +
                </span>

                ایجاد کاربر

            </a>

        </div>

    </header>


    <!-- =========================================================
         ERROR
    ========================================================== -->

    <?php if (
        is_string($error)
        && $error !== ''
    ): ?>

        <div
            class="
                admin-users__alert
                admin-users__alert--error
            "
            role="alert"
        >

            <span
                class="admin-users__alert-icon"
                aria-hidden="true"
            >
                !
            </span>


            <div>
                <?= View::escape(
                    $error
                ) ?>
            </div>

        </div>

    <?php endif; ?>


    <!-- =========================================================
         SUCCESS
    ========================================================== -->

    <?php if (
        is_string($success)
        && $success !== ''
    ): ?>

        <div
            class="
                admin-users__alert
                admin-users__alert--success
            "
            role="status"
        >

            <span
                class="admin-users__alert-icon"
                aria-hidden="true"
            >
                ✓
            </span>


            <div>
                <?= View::escape(
                    $success
                ) ?>
            </div>

        </div>

    <?php endif; ?>


    <!-- =========================================================
         PANEL
    ========================================================== -->

    <section class="admin-users__panel">


        <header class="admin-users__panel-header">

            <div class="admin-users__panel-title">

                <div
                    class="admin-users__panel-icon"
                    aria-hidden="true"
                >
                    👤
                </div>


                <div>

                    <strong>
                        فهرست کاربران
                    </strong>

                    <span>
                        حساب‌های ثبت‌شده در سامانه
                    </span>

                </div>

            </div>


            <div class="admin-users__count">

                <span>
                    مجموع
                </span>

                <strong>
                    <?= number_format(
                        $total
                    ) ?>
                </strong>

                <span>
                    کاربر
                </span>

            </div>

        </header>


        <?php if (
            $items === []
        ): ?>

            <div class="admin-users__empty">

                <div
                    class="admin-users__empty-icon"
                    aria-hidden="true"
                >
                    👤
                </div>


                <h2>
                    هنوز کاربری ایجاد نشده است.
                </h2>


                <p>
                    برای شروع، اولین حساب کاربری سامانه را ایجاد کنید.
                </p>


                <a
                    href="<?= View::route(
                        'admin.users.create'
                    ) ?>"
                    class="button button--primary"
                >
                    ایجاد اولین کاربر
                </a>

            </div>

        <?php else: ?>


            <div class="admin-users__table-wrapper">

                <table class="admin-users__table">

                    <thead>

                    <tr>

                        <th>
                            کاربر
                        </th>

                        <th>
                            ایمیل
                        </th>

                        <th>
                            نقش
                        </th>

                        <th>
                            وضعیت
                        </th>

                        <th>
                            آخرین ورود
                        </th>

                        <th>
                            عملیات
                        </th>

                    </tr>

                    </thead>


                    <tbody>

                    <?php foreach (
                        $items
                        as $account
                    ): ?>

                        <?php

                        $firstName =
                            trim(
                                (string) (
                                    $account['first_name']
                                    ?? ''
                                )
                            );


                        $lastName =
                            trim(
                                (string) (
                                    $account['last_name']
                                    ?? ''
                                )
                            );


                        $fullName =
                            trim(
                                $firstName
                                . ' '
                                . $lastName
                            );


                        $username =
                            (string) (
                                $account['username']
                                ?? ''
                            );


                        $displayName =
                            $fullName !== ''
                                ? $fullName
                                : $username;


                        $avatarLetter =
                            $displayName !== ''
                                ? mb_substr(
                                    $displayName,
                                    0,
                                    1,
                                    'UTF-8'
                                )
                                : '?';


                        $role =
                            (string) (
                                $account['role']
                                ?? 'teacher'
                            );


                        $roleLabel =
                            $roleLabels[$role]
                            ?? $role;


                        $roleClass =
                            $roleClasses[$role]
                            ?? 'teacher';


                        $isActive =
                            (int) (
                                $account['is_active']
                                ?? 0
                            ) === 1;


                        $email =
                            trim(
                                (string) (
                                    $account['email']
                                    ?? ''
                                )
                            );


                        $lastLogin =
                            trim(
                                (string) (
                                    $account['last_login_at']
                                    ?? ''
                                )
                            );

                        ?>

                        <tr>


                            <!-- USER -->

                            <td>

                                <div
                                    class="admin-users__identity"
                                >

                                    <div
                                        class="admin-users__avatar"
                                        aria-hidden="true"
                                    >
                                        <?= View::escape(
                                            $avatarLetter
                                        ) ?>
                                    </div>


                                    <div
                                        class="admin-users__identity-text"
                                    >

                                        <strong
                                            class="admin-users__identity-name"
                                        >
                                            <?= View::escape(
                                                $displayName
                                            ) ?>
                                        </strong>


                                        <span
                                            class="admin-users__identity-username"
                                            dir="ltr"
                                        >
                                            @<?= View::escape(
                                                $username
                                            ) ?>
                                        </span>

                                    </div>

                                </div>

                            </td>


                            <!-- EMAIL -->

                            <td>

                                <?php if (
                                    $email !== ''
                                ): ?>

                                    <span
                                        class="admin-users__email"
                                        dir="ltr"
                                    >
                                        <?= View::escape(
                                            $email
                                        ) ?>
                                    </span>

                                <?php else: ?>

                                    <span
                                        class="
                                            admin-users__email
                                            admin-users__email--empty
                                        "
                                    >
                                        ثبت نشده
                                    </span>

                                <?php endif; ?>

                            </td>


                            <!-- ROLE -->

                            <td>

                                <span
                                    class="
                                        admin-users__role
                                        admin-users__role--<?= View::escape(
                                            $roleClass
                                        )
                                    ?>"
                                >
                                    <?= View::escape(
                                        $roleLabel
                                    ) ?>
                                </span>

                            </td>


                            <!-- STATUS -->

                            <td>

                                <?php if (
                                    $isActive
                                ): ?>

                                    <span
                                        class="
                                            admin-users__status
                                            admin-users__status--active
                                        "
                                    >
                                        فعال
                                    </span>

                                <?php else: ?>

                                    <span
                                        class="
                                            admin-users__status
                                            admin-users__status--inactive
                                        "
                                    >
                                        غیرفعال
                                    </span>

                                <?php endif; ?>

                            </td>


                            <!-- LAST LOGIN -->

                            <td>

                                <?php if (
                                    $lastLogin !== ''
                                ): ?>

                                    <span
                                        class="admin-users__last-login"
                                        dir="ltr"
                                    >
                                        <?= View::escape(
                                            $lastLogin
                                        ) ?>
                                    </span>

                                <?php else: ?>

                                    <span
                                        class="
                                            admin-users__last-login
                                            admin-users__last-login--empty
                                        "
                                    >
                                        هنوز وارد نشده
                                    </span>

                                <?php endif; ?>

                            </td>


                            <!-- ACTIONS -->

                            <td>

                                <div
                                    class="admin-users__actions"
                                >

                                    <a
                                        href="/admin/users/<?= (int) $account['id'] ?>/edit"
                                        class="
                                            admin-users__action
                                            admin-users__action--edit
                                        "
                                    >
                                        ویرایش
                                    </a>


                                    <form
                                        method="POST"
                                        action="/admin/users/<?= (int) $account['id'] ?>/delete"
                                        onsubmit="return confirm('آیا از حذف این کاربر مطمئن هستید؟');"
                                    >

                                        <?= Csrf::field() ?>


                                        <button
                                            type="submit"
                                            class="
                                                admin-users__action
                                                admin-users__action--delete
                                            "
                                        >
                                            حذف
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>


            <!-- =====================================================
                 PAGINATION
            ====================================================== -->

            <?php if (
                $totalPages > 1
            ): ?>

                <nav
                    class="admin-users__pagination"
                    aria-label="صفحه‌بندی کاربران"
                >

                    <?php for (
                        $i = 1;
                        $i <= $totalPages;
                        $i++
                    ): ?>

                        <?php if (
                            $i === $pageNumber
                        ): ?>

                            <span
                                class="admin-users__page-current"
                                aria-current="page"
                            >
                                <?= $i ?>
                            </span>

                        <?php else: ?>

                            <a
                                href="/admin/users?page=<?= $i ?>"
                                class="admin-users__page-link"
                            >
                                <?= $i ?>
                            </a>

                        <?php endif; ?>

                    <?php endfor; ?>

                </nav>

            <?php endif; ?>

        <?php endif; ?>

    </section>

</div>
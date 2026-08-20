<?php

declare(strict_types=1);

$items =
    $users['items'] ?? [];

$total =
    (int) (
        $users['total'] ?? 0
    );

$pageNumber =
    (int) (
        $users['page'] ?? 1
    );

$totalPages =
    (int) (
        $users['totalPages'] ?? 1
    );

$error =
    \App\Core\Session::getFlash(
        'error'
    );
?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>

            <h1>
                کاربران
            </h1>

            <p>
                مدیریت حساب‌های کاربری سامانه
            </p>

        </div>

        <a
            href="<?= View::route(
                'admin.users.create'
            ) ?>"
            class="button button--primary"
        >
            + ایجاد کاربر
        </a>

    </div>


    <?php if (
        is_string($error)
        && $error !== ''
    ): ?>

        <div class="form-errors">
            <?= View::escape($error) ?>
        </div>

    <?php endif; ?>


    <?php if (
        $success !== null
    ): ?>

        <div
            style="
                margin-bottom:20px;
                padding:14px 16px;
                background:#f0fdf4;
                border:1px solid #bbf7d0;
                border-radius:12px;
                color:#166534;
            "
        >
            <?= View::escape(
                $success
            ) ?>
        </div>

    <?php endif; ?>


    <div class="admin-panel">

        <div
            style="
                margin-bottom:20px;
                color:#64748b;
                font-size:13px;
            "
        >
            مجموع:
            <?= number_format($total) ?>
            کاربر
        </div>


        <?php if (
            $items === []
        ): ?>

            <div
                style="
                    padding:50px 20px;
                    text-align:center;
                    color:#64748b;
                "
            >
                هنوز کاربری ایجاد نشده است.
            </div>

        <?php else: ?>

            <div class="announcement-table-wrapper">

                <table class="announcement-table">

                    <thead>

                    <tr>
                        <th>کاربر</th>
                        <th>ایمیل</th>
                        <th>نقش</th>
                        <th>وضعیت</th>
                        <th>آخرین ورود</th>
                        <th>عملیات</th>
                    </tr>

                    </thead>

                    <tbody>

                    <?php foreach (
                        $items
                        as $account
                    ): ?>

                        <?php
                        $fullName =
                            trim(
                                ($account['first_name'] ?? '')
                                . ' '
                                . ($account['last_name'] ?? '')
                            );
                        ?>

                        <tr>

                            <td>

                                <strong>
                                    <?= View::escape(
                                        $fullName
                                        !== ''
                                            ? $fullName
                                            : $account['username']
                                    ) ?>
                                </strong>

                                <div
                                    style="
                                        margin-top:4px;
                                        color:#94a3b8;
                                        font-size:12px;
                                    "
                                >
                                    <?= View::escape(
                                        $account['username']
                                    ) ?>
                                </div>

                            </td>


                            <td>
                                <?= View::escape(
                                    $account['email']
                                    ?? '—'
                                ) ?>
                            </td>


                            <td>

                                <?php
                                $labels = [
                                    'super_admin' =>
                                        'مدیر ارشد',

                                    'admin' =>
                                        'مدیر',

                                    'editor' =>
                                        'ویراستار',

                                    'teacher' =>
                                        'عضو هیئت علمی',
                                ];
                                ?>

                                <span
                                    class="announcement-status announcement-status--published"
                                >
                                    <?= View::escape(
                                        $labels[
                                            $account['role']
                                        ]
                                        ?? $account['role']
                                    ) ?>
                                </span>

                            </td>


                            <td>

                                <?php if (
                                    (int) (
                                        $account['is_active']
                                        ?? 0
                                    ) === 1
                                ): ?>

                                    <span
                                        class="announcement-status announcement-status--published"
                                    >
                                        فعال
                                    </span>

                                <?php else: ?>

                                    <span
                                        class="announcement-status announcement-status--draft"
                                    >
                                        غیرفعال
                                    </span>

                                <?php endif; ?>

                            </td>


                            <td>
                                <?= View::escape(
                                    $account['last_login_at']
                                    ?? '—'
                                ) ?>
                            </td>


                            <td>

                                <a
                                    href="/admin/users/<?= (int) $account['id'] ?>/edit"
                                    class="table-action"
                                >
                                    ویرایش
                                </a>


                                <form
                                    method="POST"
                                    action="/admin/users/<?= (int) $account['id'] ?>/delete"
                                    style="display:inline"
                                    onsubmit="return confirm('آیا از حذف این کاربر مطمئن هستید؟');"
                                >

                                    <?= \App\Core\Csrf::field() ?>

                                    <button
                                        type="submit"
                                        class="table-action table-action--danger"
                                    >
                                        حذف
                                    </button>

                                </form>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    </div>


    <?php if (
        $totalPages > 1
    ): ?>

        <div
            style="
                display:flex;
                justify-content:center;
                gap:8px;
                flex-wrap:wrap;
                margin-top:20px;
            "
        >

            <?php for (
                $i = 1;
                $i <= $totalPages;
                $i++
            ): ?>

                <a
                    href="/admin/users?page=<?= $i ?>"
                    class="table-action <?= $i === $pageNumber ? 'table-action--active' : '' ?>"
                >
                    <?= $i ?>
                </a>

            <?php endfor; ?>

        </div>

    <?php endif; ?>

</div>
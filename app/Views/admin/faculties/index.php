<?php

declare(strict_types=1);

$items =
    $faculties['items']
    ?? [];

$total =
    (int) (
        $faculties['total']
        ?? 0
    );
?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>
            <h1>
                دانشکده‌ها
            </h1>

            <p>
                مدیریت دانشکده‌ها و گروه‌های آموزشی
            </p>
        </div>

        <a
            href="<?= View::route(
                'admin.faculties.create'
            ) ?>"
            class="button button--primary"
        >
            + ایجاد دانشکده
        </a>

    </div>


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
            <?= number_format(
                $total
            ) ?>
            دانشکده
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
                هنوز دانشکده‌ای ایجاد نشده است.
            </div>

        <?php else: ?>

            <div class="announcement-table-wrapper">

                <table class="announcement-table">

                    <thead>
                    <tr>
                        <th>نام</th>
                        <th>نام کوتاه</th>
                        <th>رئیس</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>

                    <tbody>

                    <?php foreach (
                        $items as $faculty
                    ): ?>

                        <tr>

                            <td>
                                <strong>
                                    <?= View::escape(
                                        $faculty['name']
                                    ) ?>
                                </strong>
                            </td>

                            <td>
                                <?= View::escape(
                                    $faculty['short_name']
                                    ?? '—'
                                ) ?>
                            </td>

                            <td>
                                <?php
                                $deanName =
                                    trim(
                                        (
                                            $faculty[
                                                'dean_first_name'
                                            ] ?? ''
                                        )
                                        . ' '
                                        . (
                                            $faculty[
                                                'dean_last_name'
                                            ] ?? ''
                                        )
                                    );
                                ?>

                                <?= View::escape(
                                    $deanName ?: '—'
                                ) ?>
                            </td>

                            <td>

                                <?php if (
                                    (int) (
                                        $faculty['is_active']
                                        ?? 0
                                    ) === 1
                                ): ?>

                                    <span class="announcement-status announcement-status--published">
                                        فعال
                                    </span>

                                <?php else: ?>

                                    <span class="announcement-status announcement-status--draft">
                                        غیرفعال
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>

                                <a
                                    href="/admin/faculties/<?= (int) $faculty['id'] ?>/edit"
                                    class="table-action"
                                >
                                    ویرایش
                                </a>

                                <form
                                    method="POST"
                                    action="/admin/faculties/<?= (int) $faculty['id'] ?>/delete"
                                    style="display:inline"
                                    onsubmit="return confirm('حذف دانشکده باعث حذف رشته‌های مرتبط نیز می‌شود. ادامه می‌دهید؟');"
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

</div>
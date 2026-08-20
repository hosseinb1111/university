<?php

declare(strict_types=1);

$items = $announcements['items'] ?? [];

$total = (int) (
    $announcements['total'] ?? 0
);

$page = (int) (
    $announcements['page'] ?? 1
);

$totalPages = (int) (
    $announcements['totalPages'] ?? 1
);
?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>

            <h1>
                اطلاعیه‌ها
            </h1>

            <p>
                مدیریت اطلاعیه‌های موسسه
            </p>

        </div>

        <a
            href="<?= View::route(
                'admin.announcements.create'
            ) ?>"
            class="button button--primary"
        >
            + ایجاد اطلاعیه
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
            اطلاعیه
        </div>


        <?php if ($items === []): ?>

            <div
                style="
                    padding:50px 20px;
                    text-align:center;
                    color:#64748b;
                "
            >
                هنوز هیچ اطلاعیه‌ای ایجاد نشده است.
            </div>

        <?php else: ?>

            <div class="announcement-table-wrapper">

                <table class="announcement-table">

                    <thead>

                        <tr>
                            <th>عنوان</th>
                            <th>وضعیت</th>
                            <th>انتشار</th>
                            <th>عملیات</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php foreach (
                        $items
                        as $announcement
                    ): ?>

                        <tr>

                            <td>

                                <strong>
                                    <?= View::escape(
                                        $announcement['title']
                                    ) ?>
                                </strong>

                                <div
                                    style="
                                        margin-top:4px;
                                        color:#94a3b8;
                                        font-size:12px;
                                    "
                                >
                                    /<?= View::escape(
                                        $announcement['slug']
                                    ) ?>
                                </div>

                            </td>


                            <td>

                                <?php
                                $status =
                                    $announcement['status']
                                    ?? 'draft';
                                ?>

                                <span
                                    class="
                                        announcement-status
                                        announcement-status--<?= View::escape(
                                            $status
                                        ) ?>
                                    "
                                >
                                    <?php if (
                                        $status === 'published'
                                    ): ?>

                                        منتشر شده

                                    <?php elseif (
                                        $status === 'archived'
                                    ): ?>

                                        بایگانی شده

                                    <?php else: ?>

                                        پیش‌نویس

                                    <?php endif; ?>
                                </span>

                            </td>


                            <td>

                                <?= !empty(
                                    $announcement['published_at']
                                )
                                    ? View::escape(
                                        $announcement['published_at']
                                    )
                                    : '—'
                                ?>

                            </td>


                            <td>

                                <div
                                    style="
                                        display:flex;
                                        flex-wrap:wrap;
                                        gap:6px;
                                    "
                                >

                                    <a
                                        href="/admin/announcements/<?= (int) $announcement['id'] ?>/edit"
                                        class="table-action"
                                    >
                                        ویرایش
                                    </a>


                                    <?php if (
                                        $status !== 'published'
                                    ): ?>

                                        <form
                                            method="POST"
                                            action="/admin/announcements/<?= (int) $announcement['id'] ?>/publish"
                                        >

                                            <?= \App\Core\Csrf::field() ?>

                                            <button
                                                type="submit"
                                                class="table-action table-action--success"
                                            >
                                                انتشار
                                            </button>

                                        </form>

                                    <?php endif; ?>


                                    <?php if (
                                        $status !== 'archived'
                                    ): ?>

                                        <form
                                            method="POST"
                                            action="/admin/announcements/<?= (int) $announcement['id'] ?>/archive"
                                        >

                                            <?= \App\Core\Csrf::field() ?>

                                            <button
                                                type="submit"
                                                class="table-action"
                                            >
                                                بایگانی
                                            </button>

                                        </form>

                                    <?php endif; ?>


                                    <form
                                        method="POST"
                                        action="/admin/announcements/<?= (int) $announcement['id'] ?>/delete"
                                        onsubmit="return confirm('آیا از حذف این اطلاعیه مطمئن هستید؟');"
                                    >

                                        <?= \App\Core\Csrf::field() ?>

                                        <button
                                            type="submit"
                                            class="table-action table-action--danger"
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
                margin-top:20px;
            "
        >

            <?php for (
                $i = 1;
                $i <= $totalPages;
                $i++
            ): ?>

                <a
                    href="/admin/announcements?page=<?= $i ?>"
                    class="table-action <?= $i === $page ? 'table-action--active' : '' ?>"
                >
                    <?= $i ?>
                </a>

            <?php endfor; ?>

        </div>

    <?php endif; ?>

</div>
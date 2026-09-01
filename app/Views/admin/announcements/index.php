<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;

$items =
    is_array(
        $announcements['items']
        ?? null
    )
        ? $announcements['items']
        : [];

$total =
    (int) (
        $announcements['total']
        ?? 0
    );

$page =
    max(
        1,
        (int) (
            $announcements['page']
            ?? 1
        )
    );

$totalPages =
    max(
        1,
        (int) (
            $announcements['totalPages']
            ?? 1
        )
    );

$success =
    is_string(
        $success
        ?? null
    )
        ? $success
        : null;

$formatStatus =
    static function (
        string $status
    ): array {
        return match ($status) {
            'published' => [
                'label' => 'منتشر شده',
                'class' => 'announcement-admin-status--published',
            ],

            'archived' => [
                'label' => 'بایگانی شده',
                'class' => 'announcement-admin-status--archived',
            ],

            default => [
                'label' => 'پیش‌نویس',
                'class' => 'announcement-admin-status--draft',
            ],
        };
    };

?>

<div class="admin-page admin-announcements-page">

    <!-- =========================================================
         HEADER
    ========================================================== -->

    <div class="admin-page__header admin-announcements-header">

        <div class="admin-announcements-header__content">

            <div class="admin-announcements-header__eyebrow">
                مدیریت محتوا
            </div>

            <h1>
                اطلاعیه‌ها
            </h1>

            <p>
                اطلاعیه‌های موسسه را ایجاد، ویرایش، انتشار و مدیریت کنید.
            </p>

        </div>


        <div class="admin-announcements-header__actions">

            <a
                href="<?= View::route(
                    'admin.announcements.create'
                ) ?>"
                class="admin-button admin-button--primary"
            >
                <span class="admin-button__icon" aria-hidden="true">
                    +
                </span>

                <span>
                    ایجاد اطلاعیه
                </span>
            </a>

        </div>

    </div>


    <!-- =========================================================
         SUCCESS MESSAGE
    ========================================================== -->

    <?php if (
        $success !== null
        && $success !== ''
    ): ?>

        <div
            class="admin-announcements-alert admin-announcements-alert--success"
            role="status"
        >

            <span
                class="admin-announcements-alert__icon"
                aria-hidden="true"
            >
                ✓
            </span>

            <span>
                <?= View::escape(
                    $success
                ) ?>
            </span>

        </div>

    <?php endif; ?>


    <!-- =========================================================
         SUMMARY
    ========================================================== -->

    <div class="admin-announcements-summary">

        <div class="admin-announcements-summary__main">

            <div class="admin-announcements-summary__icon">
                📢
            </div>

            <div>

                <span>
                    مجموع اطلاعیه‌ها
                </span>

                <strong>
                    <?= number_format(
                        $total
                    ) ?>
                </strong>

            </div>

        </div>


        <?php if (
            $totalPages > 1
        ): ?>

            <div class="admin-announcements-summary__pagination">

                <span>
                    صفحه
                    <?= number_format(
                        $page
                    ) ?>
                    از
                    <?= number_format(
                        $totalPages
                    ) ?>
                </span>

            </div>

        <?php endif; ?>

    </div>


    <!-- =========================================================
         TABLE PANEL
    ========================================================== -->

    <section class="admin-panel admin-announcements-panel">

        <div class="admin-panel__header admin-announcements-panel__header">

            <div>

                <h2>
                    فهرست اطلاعیه‌ها
                </h2>

                <p>
                    تمام اطلاعیه‌های ثبت‌شده در سامانه
                </p>

            </div>

        </div>


        <?php if (
            $items === []
        ): ?>

            <!-- =================================================
                 EMPTY STATE
            ================================================== -->

            <div class="admin-announcements-empty">

                <div
                    class="admin-announcements-empty__icon"
                    aria-hidden="true"
                >
                    📢
                </div>

                <h3>
                    هنوز اطلاعیه‌ای ایجاد نشده است
                </h3>

                <p>
                    اولین اطلاعیه خود را ایجاد کنید تا در سایت نمایش داده شود.
                </p>

                <a
                    href="<?= View::route(
                        'admin.announcements.create'
                    ) ?>"
                    class="admin-button admin-button--primary"
                >
                    ایجاد اولین اطلاعیه
                </a>

            </div>

        <?php else: ?>

            <!-- =================================================
                 TABLE
            ================================================== -->

            <div class="admin-announcements-table-wrap">

                <table class="admin-announcements-table">

                    <thead>

                        <tr>

                            <th>
                                اطلاعیه
                            </th>

                            <th>
                                وضعیت
                            </th>

                            <th>
                                تاریخ انتشار
                            </th>

                            <th>
                                اولویت
                            </th>

                            <th>
                                عملیات
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php foreach (
                        $items
                        as $announcement
                    ): ?>

                        <?php

                        $id =
                            (int) (
                                $announcement['id']
                                ?? 0
                            );

                        $title =
                            trim(
                                (string) (
                                    $announcement['title']
                                    ?? ''
                                )
                            );

                        $slug =
                            trim(
                                (string) (
                                    $announcement['slug']
                                    ?? ''
                                )
                            );

                        $status =
                            (string) (
                                $announcement['status']
                                ?? 'draft'
                            );

                        $priority =
                            (int) (
                                $announcement['priority']
                                ?? 0
                            );

                        $publishedAt =
                            $announcement['published_at']
                            ?? null;

                        $statusMeta =
                            $formatStatus(
                                $status
                            );

                        ?>

                        <tr>

                            <!-- =================================================
                                 Announcement
                            ================================================== -->

                            <td>

                                <div class="admin-announcement-item">

                                    <div
                                        class="admin-announcement-item__icon"
                                        aria-hidden="true"
                                    >
                                        📢
                                    </div>

                                    <div
                                        class="admin-announcement-item__content"
                                    >

                                        <strong>
                                            <?= View::escape(
                                                $title
                                            ) ?>
                                        </strong>

                                        <?php if (
                                            $slug !== ''
                                        ): ?>

                                            <span>
                                                /<?= View::escape(
                                                    $slug
                                                ) ?>
                                            </span>

                                        <?php endif; ?>

                                    </div>

                                </div>

                            </td>


                            <!-- =================================================
                                 Status
                            ================================================== -->

                            <td>

                                <span
                                    class="admin-announcement-status <?= View::escape(
                                        $statusMeta['class']
                                    ) ?>"
                                >

                                    <span
                                        class="admin-announcement-status__dot"
                                        aria-hidden="true"
                                    ></span>

                                    <?= View::escape(
                                        $statusMeta['label']
                                    ) ?>

                                </span>

                            </td>


                            <!-- =================================================
                                 Published date
                            ================================================== -->

                            <td>

                                <div class="admin-announcement-date">

                                    <?php if (
                                        !empty(
                                            $publishedAt
                                        )
                                    ): ?>

                                        <span>
                                            <?= View::escape(
                                                jalali_date_fa(
                                                    $publishedAt,
                                                    'j F Y'
                                                )
                                            ) ?>
                                        </span>

                                        <small>
                                            <?= View::escape(
                                                jalali_date_fa(
                                                    $publishedAt,
                                                    'H:i'
                                                )
                                            ) ?>
                                        </small>

                                    <?php else: ?>

                                        <span
                                            class="admin-announcement-date--empty"
                                        >
                                            بدون زمان
                                        </span>

                                    <?php endif; ?>

                                </div>

                            </td>


                            <!-- =================================================
                                 Priority
                            ================================================== -->

                            <td>

                                <span
                                    class="
                                        admin-announcement-priority
                                        <?php
                                        if (
                                            $priority > 0
                                        ) {
                                            echo ' admin-announcement-priority--positive';
                                        } elseif (
                                            $priority < 0
                                        ) {
                                            echo ' admin-announcement-priority--negative';
                                        }
                                        ?>
                                    "
                                >

                                    <?= $priority > 0
                                        ? '+'
                                        : '' ?><?= number_format(
                                            $priority
                                        ) ?>

                                </span>

                            </td>


                            <!-- =================================================
                                 Actions
                            ================================================== -->

                            <td>

                                <div
                                    class="admin-announcement-actions"
                                >

                                    <a
                                        href="/admin/announcements/<?= $id ?>/edit"
                                        class="admin-announcement-action"
                                    >
                                        ویرایش
                                    </a>


                                    <?php if (
                                        $status !== 'published'
                                    ): ?>

                                        <form
                                            method="POST"
                                            action="/admin/announcements/<?= $id ?>/publish"
                                        >

                                            <?= Csrf::field() ?>

                                            <button
                                                type="submit"
                                                class="
                                                    admin-announcement-action
                                                    admin-announcement-action--success
                                                "
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
                                            action="/admin/announcements/<?= $id ?>/archive"
                                        >

                                            <?= Csrf::field() ?>

                                            <button
                                                type="submit"
                                                class="admin-announcement-action"
                                            >
                                                بایگانی
                                            </button>

                                        </form>

                                    <?php endif; ?>


                                    <form
                                        method="POST"
                                        action="/admin/announcements/<?= $id ?>/delete"
                                        onsubmit="return confirm('آیا از حذف این اطلاعیه مطمئن هستید؟');"
                                    >

                                        <?= Csrf::field() ?>

                                        <button
                                            type="submit"
                                            class="
                                                admin-announcement-action
                                                admin-announcement-action--danger
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

        <?php endif; ?>

    </section>


    <!-- =========================================================
         PAGINATION
    ========================================================== -->

    <?php if (
        $totalPages > 1
    ): ?>

        <nav
            class="admin-announcements-pagination"
            aria-label="صفحه‌بندی اطلاعیه‌ها"
        >

            <?php if (
                $page > 1
            ): ?>

                <a
                    href="/admin/announcements?page=<?= $page - 1 ?>"
                    class="admin-announcements-pagination__arrow"
                >
                    ←
                </a>

            <?php endif; ?>


            <div class="admin-announcements-pagination__pages">

                <?php

                $startPage =
                    max(
                        1,
                        $page - 2
                    );

                $endPage =
                    min(
                        $totalPages,
                        $page + 2
                    );

                ?>


                <?php if (
                    $startPage > 1
                ): ?>

                    <a
                        href="/admin/announcements?page=1"
                        class="admin-announcements-pagination__page"
                    >
                        ۱
                    </a>

                    <?php if (
                        $startPage > 2
                    ): ?>

                        <span
                            class="admin-announcements-pagination__ellipsis"
                        >
                            …
                        </span>

                    <?php endif; ?>

                <?php endif; ?>


                <?php for (
                    $i = $startPage;
                    $i <= $endPage;
                    $i++
                ): ?>

                    <a
                        href="/admin/announcements?page=<?= $i ?>"
                        class="
                            admin-announcements-pagination__page
                            <?= $i === $page
                                ? 'admin-announcements-pagination__page--active'
                                : ''
                            ?>
                        "
                    >
                        <?= number_format(
                            $i
                        ) ?>
                    </a>

                <?php endfor; ?>


                <?php if (
                    $endPage < $totalPages
                ): ?>

                    <?php if (
                        $endPage < $totalPages - 1
                    ): ?>

                        <span
                            class="admin-announcements-pagination__ellipsis"
                        >
                            …
                        </span>

                    <?php endif; ?>

                    <a
                        href="/admin/announcements?page=<?= $totalPages ?>"
                        class="admin-announcements-pagination__page"
                    >
                        <?= number_format(
                            $totalPages
                        ) ?>
                    </a>

                <?php endif; ?>

            </div>


            <?php if (
                $page < $totalPages
            ): ?>

                <a
                    href="/admin/announcements?page=<?= $page + 1 ?>"
                    class="admin-announcements-pagination__arrow"
                >
                    →
                </a>

            <?php endif; ?>

        </nav>

    <?php endif; ?>

</div>
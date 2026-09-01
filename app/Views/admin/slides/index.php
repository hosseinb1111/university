<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;

$items =
    is_array($slides['items'] ?? null)
        ? $slides['items']
        : [];

$total =
    (int) (
        $slides['total']
        ?? 0
    );

$currentPage =
    max(
        1,
        (int) (
            $slides['page']
            ?? 1
        )
    );

$totalPages =
    max(
        1,
        (int) (
            $slides['totalPages']
            ?? 1
        )
    );
?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>

            <span
                class="admin-page__eyebrow"
            >
                صفحه اصلی
            </span>

            <h1>
                اسلایدر صفحه اصلی
            </h1>

            <p>
                تصاویر، متن‌ها، لینک‌ها و زمان‌بندی اسلایدهای صفحه اصلی را مدیریت کنید.
            </p>

        </div>


        <a
            href="<?= View::url(
                '/admin/slides/create'
            ) ?>"
            class="button button--primary"
        >
            ایجاد اسلاید
        </a>

    </div>


    <?php if (
        $success
        ?? false
    ): ?>

        <div
            class="admin-alert admin-alert--success"
            role="status"
        >
            <?= View::escape(
                (string) $success
            ) ?>
        </div>

    <?php endif; ?>


    <?php if (
        $error
        ?? false
    ): ?>

        <div
            class="admin-alert admin-alert--error"
            role="alert"
        >
            <?= View::escape(
                (string) $error
            ) ?>
        </div>

    <?php endif; ?>


    <div class="admin-panel">

        <div class="admin-panel__header">

            <div>

                <strong>
                    اسلایدها
                </strong>

                <span>
                    <?= number_format(
                        $total
                    ) ?>

                    مورد
                </span>

            </div>

        </div>


        <?php if (
            $items === []
        ): ?>

            <div class="admin-empty">

                <div class="admin-empty__icon">
                    🖼
                </div>

                <h2>
                    هنوز اسلایدی ایجاد نشده است.
                </h2>

                <p>
                    اولین اسلاید صفحه اصلی را ایجاد کنید.
                </p>

                <a
                    href="<?= View::url(
                        '/admin/slides/create'
                    ) ?>"
                    class="button button--primary"
                >
                    ایجاد اولین اسلاید
                </a>

            </div>

        <?php else: ?>

            <div class="admin-table-wrapper">

                <table class="admin-table">

                    <thead>

                    <tr>

                        <th>
                            تصویر
                        </th>

                        <th>
                            عنوان
                        </th>

                        <th>
                            ترتیب
                        </th>

                        <th>
                            وضعیت
                        </th>

                        <th>
                            زمان‌بندی
                        </th>

                        <th>
                            عملیات
                        </th>

                    </tr>

                    </thead>


                    <tbody>

                    <?php foreach (
                        $items
                        as $slide
                    ): ?>

                        <?php
                        $id =
                            (int) (
                                $slide['id']
                                ?? 0
                            );

                        $image =
                            trim(
                                (string) (
                                    $slide['image']
                                    ?? ''
                                )
                            );

                        $title =
                            (string) (
                                $slide['title']
                                ?? ''
                            );

                        $active =
                            (int) (
                                $slide['is_active']
                                ?? 0
                            ) === 1;

                        $hasSchedule =
                            !empty(
                                $slide['starts_at']
                            )
                            || !empty(
                                $slide['ends_at']
                            );
                        ?>

                        <tr>

                            <td>

                                <?php if (
                                    $image !== ''
                                ): ?>

                                    <img
                                        src="<?= View::escape(
                                            $image
                                        ) ?>"
                                        alt=""
                                        class="admin-slide-thumbnail"
                                        loading="lazy"
                                    >

                                <?php else: ?>

                                    <div
                                        class="admin-slide-thumbnail admin-slide-thumbnail--empty"
                                        aria-hidden="true"
                                    >
                                        🖼
                                    </div>

                                <?php endif; ?>

                            </td>


                            <td>

    <?php if (
        $title !== ''
    ): ?>

        <strong>
            <?= View::escape(
                $title
            ) ?>
        </strong>

    <?php else: ?>

        <span class="admin-table__muted">
            بدون عنوان
        </span>

    <?php endif; ?>


    <?php if (
        !empty(
            $slide['subtitle']
        )
    ): ?>

        <span class="admin-table__muted">
            <?= View::escape(
                $slide['subtitle']
            ) ?>
        </span>

    <?php endif; ?>

</td>

                            <td>
                                <?= number_format(
                                    (int) (
                                        $slide['sort_order']
                                        ?? 0
                                    )
                                ) ?>
                            </td>


                            <td>

                                <?php if (
                                    $active
                                ): ?>

                                    <span class="admin-status admin-status--success">
                                        فعال
                                    </span>

                                <?php else: ?>

                                    <span class="admin-status admin-status--muted">
                                        غیرفعال
                                    </span>

                                <?php endif; ?>

                            </td>


                            <td>

                                <?php if (
                                    $hasSchedule
                                ): ?>

                                    <span class="admin-table__muted">
                                        زمان‌بندی شده
                                    </span>

                                <?php else: ?>

                                    <span>
                                        بدون زمان‌بندی
                                    </span>

                                <?php endif; ?>

                            </td>


                            <td>

                                <div class="admin-table__actions">

                                    <a
                                        href="<?= View::url(
                                            '/admin/slides/'
                                            . $id
                                            . '/edit'
                                        ) ?>"
                                        class="button button--secondary button--small"
                                    >
                                        ویرایش
                                    </a>


                                    <form
                                        method="POST"
                                        action="<?= View::url(
                                            '/admin/slides/'
                                            . $id
                                            . '/delete'
                                        ) ?>"
                                        onsubmit="return confirm('آیا از حذف این اسلاید مطمئن هستید؟');"
                                    >

                                        <?= Csrf::field() ?>

                                        <button
                                            type="submit"
                                            class="button button--danger button--small"
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


            <?php if (
                $totalPages > 1
            ): ?>

                <nav
                    class="admin-pagination"
                    aria-label="صفحه‌بندی اسلایدها"
                >

                    <?php if (
                        $currentPage > 1
                    ): ?>

                        <a
                            href="?page=<?= $currentPage - 1 ?>"
                        >
                            قبلی
                        </a>

                    <?php endif; ?>


                    <span>
                        صفحه
                        <?= $currentPage ?>
                        از
                        <?= $totalPages ?>
                    </span>


                    <?php if (
                        $currentPage < $totalPages
                    ): ?>

                        <a
                            href="?page=<?= $currentPage + 1 ?>"
                        >
                            بعدی
                        </a>

                    <?php endif; ?>

                </nav>

            <?php endif; ?>

        <?php endif; ?>

    </div>

</div>
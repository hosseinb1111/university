<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;

$items =
    is_array($centers['items'] ?? null)
        ? $centers['items']
        : [];

$total =
    (int) (
        $centers['total']
        ?? 0
    );

$page =
    max(
        1,
        (int) (
            $centers['page']
            ?? 1
        )
    );

$totalPages =
    max(
        1,
        (int) (
            $centers['totalPages']
            ?? 1
        )
    );

$success =
    is_string($success ?? null)
        ? $success
        : null;

$error =
    is_string($error ?? null)
        ? $error
        : null;
?>

<div class="research-admin">

    <!-- =========================================================
         HEADER
    ========================================================== -->

    <header class="research-admin__header">

        <div class="research-admin__header-main">

            <span class="research-admin__eyebrow">
                پژوهش و نوآوری
            </span>

            <div class="research-admin__title-row">

                <div
                    class="research-admin__title-icon"
                    aria-hidden="true"
                >
                    🔬
                </div>

                <div>

                    <h1 class="research-admin__title">
                        پژوهشکده‌ها
                    </h1>

                    <p class="research-admin__description">
                        مراکز و پژوهشکده‌های موسسه را مدیریت و اطلاعات آن‌ها را به‌روزرسانی کنید.
                    </p>

                </div>

            </div>

        </div>


        <div class="research-admin__header-actions">

            <a
                href="<?= View::route(
                    'admin.research-centers.create'
                ) ?>"
                class="
                    research-admin__button
                    research-admin__button--primary
                "
            >
                <span aria-hidden="true">+</span>
                ایجاد پژوهشکده
            </a>

        </div>

    </header>


    <!-- =========================================================
         ALERTS
    ========================================================== -->

    <?php if (
        $success !== null
        && $success !== ''
    ): ?>

        <div
            class="
                research-admin__alert
                research-admin__alert--success
            "
            role="status"
        >

            <div
                class="research-admin__alert-icon"
                aria-hidden="true"
            >
                ✓
            </div>

            <div>

                <strong>
                    انجام شد
                </strong>

                <p>
                    <?= View::escape(
                        $success
                    ) ?>
                </p>

            </div>

        </div>

    <?php endif; ?>


    <?php if (
        $error !== null
        && $error !== ''
    ): ?>

        <div
            class="
                research-admin__alert
                research-admin__alert--error
            "
            role="alert"
        >

            <div
                class="research-admin__alert-icon"
                aria-hidden="true"
            >
                !
            </div>

            <div>

                <strong>
                    خطا
                </strong>

                <p>
                    <?= View::escape(
                        $error
                    ) ?>
                </p>

            </div>

        </div>

    <?php endif; ?>


    <!-- =========================================================
         STATS
    ========================================================== -->

    <section class="research-admin__stats">

        <div class="research-admin__stat">

            <div
                class="research-admin__stat-icon"
                aria-hidden="true"
            >
                🔬
            </div>

            <div>

                <span>
                    مجموع پژوهشکده‌ها
                </span>

                <strong>
                    <?= number_format(
                        $total
                    ) ?>
                </strong>

            </div>

        </div>


        <div class="research-admin__stat">

            <div
                class="research-admin__stat-icon"
                aria-hidden="true"
            >
                📊
            </div>

            <div>

                <span>
                    ترتیب نمایش
                </span>

                <strong>
                    بر اساس اولویت
                </strong>

            </div>

        </div>


        <div class="research-admin__stat">

            <div
                class="research-admin__stat-icon"
                aria-hidden="true"
            >
                🌐
            </div>

            <div>

                <span>
                    بخش عمومی
                </span>

                <strong>
                    پژوهش و نوآوری
                </strong>

            </div>

        </div>

    </section>


    <!-- =========================================================
         LIST PANEL
    ========================================================== -->

    <section class="research-admin__panel">

        <div class="research-admin__panel-header">

            <div>

                <span class="research-admin__panel-eyebrow">
                    فهرست پژوهشکده‌ها
                </span>

                <h2>
                    مراکز پژوهشی
                </h2>

                <p>
                    پژوهشکده‌های ثبت‌شده را مشاهده، ویرایش یا حذف کنید.
                </p>

            </div>


            <div class="research-admin__panel-count">

                <strong>
                    <?= number_format(
                        $total
                    ) ?>
                </strong>

                <span>
                    مورد
                </span>

            </div>

        </div>


        <?php if (
            $items === []
        ): ?>

            <div class="research-admin__empty">

                <div
                    class="research-admin__empty-icon"
                    aria-hidden="true"
                >
                    🔬
                </div>

                <h3>
                    هنوز پژوهشکده‌ای ثبت نشده است
                </h3>

                <p>
                    اولین مرکز پژوهشی را اضافه کنید تا در سایت نمایش داده شود.
                </p>

                <a
                    href="<?= View::route(
                        'admin.research-centers.create'
                    ) ?>"
                    class="
                        research-admin__button
                        research-admin__button--primary
                    "
                >
                    ایجاد اولین پژوهشکده
                </a>

            </div>

        <?php else: ?>

            <div class="research-admin__table-wrap">

                <table class="research-admin__table">

                    <thead>

                        <tr>

                            <th>
                                پژوهشکده
                            </th>

                            <th>
                                اطلاعات تماس
                            </th>

                            <th>
                                وضعیت
                            </th>

                            <th>
                                ترتیب
                            </th>

                            <th>
                                عملیات
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php foreach (
                            $items
                            as $center
                        ): ?>

                            <?php

                            $centerId =
                                (int) (
                                    $center['id']
                                    ?? 0
                                );

                            $name =
                                trim(
                                    (string) (
                                        $center['name']
                                        ?? ''
                                    )
                                );

                            $slug =
                                trim(
                                    (string) (
                                        $center['slug']
                                        ?? ''
                                    )
                                );

                            $email =
                                trim(
                                    (string) (
                                        $center['email']
                                        ?? ''
                                    )
                                );

                            $phone =
                                trim(
                                    (string) (
                                        $center['phone']
                                        ?? ''
                                    )
                                );

                            $sortOrder =
                                (int) (
                                    $center['sort_order']
                                    ?? 0
                                );

                            $isActive =
                                (int) (
                                    $center['is_active']
                                    ?? 0
                                ) === 1;

                            ?>

                            <tr>

                                <!-- NAME -->

                                <td>

                                    <div class="research-admin__center-cell">

                                        <div
                                            class="research-admin__center-icon"
                                            aria-hidden="true"
                                        >
                                            🔬
                                        </div>

                                        <div class="research-admin__center-info">

                                            <strong>
                                                <?= View::escape(
                                                    $name
                                                ) ?>
                                            </strong>

                                            <?php if (
                                                $slug !== ''
                                            ): ?>

                                                <span dir="ltr">
                                                    /<?= View::escape(
                                                        $slug
                                                    ) ?>
                                                </span>

                                            <?php endif; ?>

                                        </div>

                                    </div>

                                </td>


                                <!-- CONTACT -->

                                <td>

                                    <div class="research-admin__contact">

                                        <?php if (
                                            $email !== ''
                                        ): ?>

                                            <a
                                                href="mailto:<?= View::escape(
                                                    $email
                                                ) ?>"
                                                title="ایمیل"
                                            >
                                                ✉
                                            </a>

                                        <?php endif; ?>


                                        <?php if (
                                            $phone !== ''
                                        ): ?>

                                            <?php
                                            $phoneHref =
                                                preg_replace(
                                                    '/[^0-9+]/',
                                                    '',
                                                    $phone
                                                ) ?? '';
                                            ?>

                                            <a
                                                href="tel:<?= View::escape(
                                                    $phoneHref
                                                ) ?>"
                                                title="تماس"
                                            >
                                                ☎
                                            </a>

                                        <?php endif; ?>


                                        <?php if (
                                            $email === ''
                                            && $phone === ''
                                        ): ?>

                                            <span class="research-admin__muted">
                                                اطلاعات تماس ثبت نشده
                                            </span>

                                        <?php endif; ?>

                                    </div>

                                </td>


                                <!-- STATUS -->

                                <td>

                                    <?php if (
                                        $isActive
                                    ): ?>

                                        <span
                                            class="
                                                research-admin__status
                                                research-admin__status--active
                                            "
                                        >

                                            <span
                                                class="research-admin__status-dot"
                                                aria-hidden="true"
                                            ></span>

                                            فعال

                                        </span>

                                    <?php else: ?>

                                        <span
                                            class="
                                                research-admin__status
                                                research-admin__status--inactive
                                            "
                                        >

                                            <span
                                                class="research-admin__status-dot"
                                                aria-hidden="true"
                                            ></span>

                                            غیرفعال

                                        </span>

                                    <?php endif; ?>

                                </td>


                                <!-- ORDER -->

                                <td>

                                    <span
                                        class="research-admin__order"
                                    >
                                        <?= number_format(
                                            $sortOrder
                                        ) ?>
                                    </span>

                                </td>


                                <!-- ACTIONS -->

                                <td>

                                    <div class="research-admin__actions">

                                        <a
                                            href="<?= View::url(
                                                '/admin/research-centers/'
                                                . $centerId
                                                . '/edit'
                                            ) ?>"
                                            class="
                                                research-admin__action
                                                research-admin__action--edit
                                            "
                                        >
                                            ویرایش
                                        </a>


                                        <?php if (
                                            $isActive
                                            && $slug !== ''
                                        ): ?>

                                            <a
                                                href="<?= View::url(
                                                    '/research-centers/'
                                                    . rawurlencode(
                                                        $slug
                                                    )
                                                ) ?>"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="
                                                    research-admin__action
                                                    research-admin__action--view
                                                "
                                            >
                                                مشاهده
                                                <span aria-hidden="true">
                                                    ↗
                                                </span>
                                            </a>

                                        <?php endif; ?>


                                        <form
                                            method="POST"
                                            action="<?= View::url(
                                                '/admin/research-centers/'
                                                . $centerId
                                                . '/delete'
                                            ) ?>"
                                            onsubmit="return confirm('آیا از حذف این پژوهشکده مطمئن هستید؟');"
                                        >

                                            <?= Csrf::field() ?>

                                            <button
                                                type="submit"
                                                class="
                                                    research-admin__action
                                                    research-admin__action--danger
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
            class="research-admin__pagination"
            aria-label="صفحه‌بندی"
        >

            <?php if (
                $page > 1
            ): ?>

                <a
                    href="<?= View::url(
                        '/admin/research-centers?page='
                        . (
                            $page - 1
                        )
                    ) ?>"
                    class="research-admin__page"
                >
                    قبلی
                </a>

            <?php endif; ?>


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


            <?php for (
                $i = $startPage;
                $i <= $endPage;
                $i++
            ): ?>

                <a
                    href="<?= View::url(
                        '/admin/research-centers?page='
                        . $i
                    ) ?>"
                    class="
                        research-admin__page
                        <?= $i === $page
                            ? 'research-admin__page--active'
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
                $page < $totalPages
            ): ?>

                <a
                    href="<?= View::url(
                        '/admin/research-centers?page='
                        . (
                            $page + 1
                        )
                    ) ?>"
                    class="research-admin__page"
                >
                    بعدی
                </a>

            <?php endif; ?>

        </nav>

    <?php endif; ?>

</div>
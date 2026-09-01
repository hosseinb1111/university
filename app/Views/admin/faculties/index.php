<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;

$items =
    is_array($faculties['items'] ?? null)
        ? $faculties['items']
        : [];

$total =
    (int) (
        $faculties['total']
        ?? 0
    );

$page =
    max(
        1,
        (int) (
            $faculties['page']
            ?? 1
        )
    );

$totalPages =
    max(
        1,
        (int) (
            $faculties['totalPages']
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

<div class="faculty-admin">

    <header class="faculty-admin__header">

        <div class="faculty-admin__header-main">

            <span class="faculty-admin__eyebrow">
                آموزش و پژوهش
            </span>

            <div class="faculty-admin__title-row">

                <div
                    class="faculty-admin__title-icon"
                    aria-hidden="true"
                >
                    🎓
                </div>

                <div>

                    <h1 class="faculty-admin__title">
                        دانشکده‌ها
                    </h1>

                    <p class="faculty-admin__description">
                        مدیریت دانشکده‌ها، اطلاعات تماس و وضعیت انتشار آن‌ها.
                    </p>

                </div>

            </div>

        </div>


        <div class="faculty-admin__header-actions">

            <a
                href="<?= View::route(
                    'admin.faculties.create'
                ) ?>"
                class="faculty-admin__button faculty-admin__button--primary"
            >
                <span aria-hidden="true">
                    +
                </span>

                ایجاد دانشکده
            </a>

        </div>

    </header>


    <?php if (
        $success !== null
        && $success !== ''
    ): ?>

        <div
            class="faculty-admin__alert faculty-admin__alert--success"
            role="status"
        >

            <div
                class="faculty-admin__alert-icon"
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
            class="faculty-admin__alert faculty-admin__alert--error"
            role="alert"
        >

            <div
                class="faculty-admin__alert-icon"
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


    <section class="faculty-admin__stats">

        <div class="faculty-admin__stat">

            <div class="faculty-admin__stat-icon">
                🎓
            </div>

            <div>

                <span>
                    مجموع دانشکده‌ها
                </span>

                <strong>
                    <?= number_format(
                        $total
                    ) ?>
                </strong>

            </div>

        </div>


        <div class="faculty-admin__stat">

            <div class="faculty-admin__stat-icon">
                🌐
            </div>

            <div>

                <span>
                    صفحه عمومی
                </span>

                <strong>
                    فعال
                </strong>

            </div>

        </div>


        <div class="faculty-admin__stat">

            <div class="faculty-admin__stat-icon">
                📚
            </div>

            <div>

                <span>
                    مدیریت
                </span>

                <strong>
                    <?= $total > 0
                        ? 'در حال استفاده'
                        : 'آماده ایجاد'
                    ?>
                </strong>

            </div>

        </div>

    </section>


    <section class="faculty-admin__panel">

        <div class="faculty-admin__panel-header">

            <div>

                <span class="faculty-admin__panel-eyebrow">
                    فهرست
                </span>

                <h2>
                    دانشکده‌های موسسه
                </h2>

                <p>
                    اطلاعات دانشکده‌ها را از این بخش مشاهده و مدیریت کنید.
                </p>

            </div>

            <div class="faculty-admin__panel-count">

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

            <div class="faculty-admin__empty">

                <div
                    class="faculty-admin__empty-icon"
                    aria-hidden="true"
                >
                    🎓
                </div>

                <h3>
                    هنوز دانشکده‌ای ثبت نشده است
                </h3>

                <p>
                    اولین دانشکده را ایجاد کنید تا اطلاعات آن
                    در سایت قابل نمایش و مدیریت باشد.
                </p>

                <a
                    href="<?= View::route(
                        'admin.faculties.create'
                    ) ?>"
                    class="faculty-admin__button faculty-admin__button--primary"
                >
                    ایجاد اولین دانشکده
                </a>

            </div>

        <?php else: ?>

            <div class="faculty-admin__table-wrap">

                <table class="faculty-admin__table">

                    <thead>

                        <tr>

                            <th>
                                دانشکده
                            </th>

                            <th>
                                نام کوتاه
                            </th>

                            <th>
                                وضعیت
                            </th>

                            <th>
                                عملیات
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php foreach (
                            $items
                            as $faculty
                        ): ?>

                            <?php

                            $facultyId =
                                (int) (
                                    $faculty['id']
                                    ?? 0
                                );

                            $facultyName =
                                trim(
                                    (string) (
                                        $faculty['name']
                                        ?? ''
                                    )
                                );

                            $shortName =
                                trim(
                                    (string) (
                                        $faculty['short_name']
                                        ?? ''
                                    )
                                );

                            $isActive =
                                (int) (
                                    $faculty['is_active']
                                    ?? 0
                                ) === 1;

                            $slug =
                                trim(
                                    (string) (
                                        $faculty['slug']
                                        ?? ''
                                    )
                                );

                            ?>

                            <tr>

                                <td>

                                    <div class="faculty-admin__faculty-cell">

                                        <div
                                            class="faculty-admin__faculty-icon"
                                            aria-hidden="true"
                                        >
                                            🎓
                                        </div>

                                        <div
                                            class="faculty-admin__faculty-info"
                                        >

                                            <strong>
                                                <?= View::escape(
                                                    $facultyName
                                                ) ?>
                                            </strong>

                                            <?php if (
                                                $slug !== ''
                                            ): ?>

                                                <span dir="ltr">
                                                    /faculties/
                                                    <?= View::escape(
                                                        $slug
                                                    ) ?>
                                                </span>

                                            <?php endif; ?>

                                        </div>

                                    </div>

                                </td>


                                <td>

                                    <?php if (
                                        $shortName !== ''
                                    ): ?>

                                        <span class="faculty-admin__short-name">
                                            <?= View::escape(
                                                $shortName
                                            ) ?>
                                        </span>

                                    <?php else: ?>

                                        <span class="faculty-admin__muted">
                                            —
                                        </span>

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <?php if (
                                        $isActive
                                    ): ?>

                                        <span class="faculty-admin__status faculty-admin__status--active">

                                            <span
                                                class="faculty-admin__status-dot"
                                                aria-hidden="true"
                                            ></span>

                                            فعال

                                        </span>

                                    <?php else: ?>

                                        <span class="faculty-admin__status faculty-admin__status--inactive">

                                            <span
                                                class="faculty-admin__status-dot"
                                                aria-hidden="true"
                                            ></span>

                                            غیرفعال

                                        </span>

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <div class="faculty-admin__actions">

                                        <a
                                            href="<?= View::url(
                                                '/admin/faculties/'
                                                . $facultyId
                                                . '/edit'
                                            ) ?>"
                                            class="faculty-admin__action faculty-admin__action--edit"
                                        >
                                            ویرایش
                                        </a>


                                        <?php if (
                                            $slug !== ''
                                        ): ?>

                                            <a
                                                href="<?= View::url(
                                                    '/faculties/'
                                                    . $slug
                                                ) ?>"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="faculty-admin__action faculty-admin__action--view"
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
                                                '/admin/faculties/'
                                                . $facultyId
                                                . '/delete'
                                            ) ?>"
                                            onsubmit="return confirm('حذف این دانشکده باعث حذف رشته‌های مرتبط نیز می‌شود. آیا مطمئن هستید؟');"
                                        >

                                            <?= Csrf::field() ?>

                                            <button
                                                type="submit"
                                                class="faculty-admin__action faculty-admin__action--danger"
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


    <?php if (
        $totalPages > 1
    ): ?>

        <nav
            class="faculty-admin__pagination"
            aria-label="صفحه‌بندی"
        >

            <?php if (
                $page > 1
            ): ?>

                <a
                    href="<?= View::url(
                        '/admin/faculties?page='
                        . (
                            $page - 1
                        )
                    ) ?>"
                    class="faculty-admin__page"
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
                        '/admin/faculties?page='
                        . $i
                    ) ?>"
                    class="
                        faculty-admin__page
                        <?= $i === $page
                            ? 'faculty-admin__page--active'
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
                        '/admin/faculties?page='
                        . (
                            $page + 1
                        )
                    ) ?>"
                    class="faculty-admin__page"
                >
                    بعدی
                </a>

            <?php endif; ?>

        </nav>

    <?php endif; ?>

</div>
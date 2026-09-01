<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;

$items =
    is_array($programs['items'] ?? null)
        ? $programs['items']
        : [];

$total =
    (int) (
        $programs['total']
        ?? 0
    );

$page =
    max(
        1,
        (int) (
            $programs['page']
            ?? 1
        )
    );

$totalPages =
    max(
        1,
        (int) (
            $programs['totalPages']
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

<div class="program-admin">

    <!-- =========================================================
         HEADER
    ========================================================== -->

    <header class="program-admin__header">

        <div class="program-admin__header-main">

            <span class="program-admin__eyebrow">
                آموزش و پژوهش
            </span>

            <div class="program-admin__title-row">

                <div
                    class="program-admin__title-icon"
                    aria-hidden="true"
                >
                    📚
                </div>

                <div>

                    <h1 class="program-admin__title">
                        رشته‌ها و برنامه‌های آموزشی
                    </h1>

                    <p class="program-admin__description">
                        مدیریت رشته‌ها، مقاطع، گرایش‌ها و اطلاعات
                        آموزشی دانشکده‌ها.
                    </p>

                </div>

            </div>

        </div>


        <div class="program-admin__header-actions">

            <a
                href="<?= View::route(
                    'admin.programs.create'
                ) ?>"
                class="program-admin__button program-admin__button--primary"
            >
                <span aria-hidden="true">
                    +
                </span>

                ایجاد برنامه
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
            class="program-admin__alert program-admin__alert--success"
            role="status"
        >

            <div
                class="program-admin__alert-icon"
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
            class="program-admin__alert program-admin__alert--error"
            role="alert"
        >

            <div
                class="program-admin__alert-icon"
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

    <section class="program-admin__stats">

        <div class="program-admin__stat">

            <div
                class="program-admin__stat-icon"
                aria-hidden="true"
            >
                📚
            </div>

            <div>

                <span>
                    مجموع برنامه‌ها
                </span>

                <strong>
                    <?= number_format(
                        $total
                    ) ?>
                </strong>

            </div>

        </div>


        <div class="program-admin__stat">

            <div
                class="program-admin__stat-icon"
                aria-hidden="true"
            >
                🎓
            </div>

            <div>

                <span>
                    بخش آموزشی
                </span>

                <strong>
                    فعال
                </strong>

            </div>

        </div>


        <div class="program-admin__stat">

            <div
                class="program-admin__stat-icon"
                aria-hidden="true"
            >
                🌐
            </div>

            <div>

                <span>
                    نمایش عمومی
                </span>

                <strong>
                    <?= $total > 0
                        ? 'آماده انتشار'
                        : 'آماده ایجاد'
                    ?>
                </strong>

            </div>

        </div>

    </section>


    <!-- =========================================================
         MAIN PANEL
    ========================================================== -->

    <section class="program-admin__panel">

        <div class="program-admin__panel-header">

            <div>

                <span class="program-admin__panel-eyebrow">
                    فهرست
                </span>

                <h2>
                    برنامه‌های آموزشی
                </h2>

                <p>
                    رشته‌ها را مشاهده، ویرایش یا حذف کنید.
                </p>

            </div>

            <div class="program-admin__panel-count">

                <strong>
                    <?= number_format(
                        $total
                    ) ?>
                </strong>

                <span>
                    برنامه
                </span>

            </div>

        </div>


        <?php if (
            $items === []
        ): ?>

            <div class="program-admin__empty">

                <div
                    class="program-admin__empty-icon"
                    aria-hidden="true"
                >
                    📚
                </div>

                <h3>
                    هنوز برنامه‌ای ثبت نشده است
                </h3>

                <p>
                    اولین رشته یا برنامه آموزشی را ایجاد کنید.
                </p>

                <a
                    href="<?= View::route(
                        'admin.programs.create'
                    ) ?>"
                    class="program-admin__button program-admin__button--primary"
                >
                    ایجاد اولین برنامه
                </a>

            </div>

        <?php else: ?>

            <div class="program-admin__table-wrap">

                <table class="program-admin__table">

                    <thead>

                        <tr>

                            <th>
                                برنامه
                            </th>

                            <th>
                                دانشکده
                            </th>

                            <th>
                                مقطع
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
                            as $program
                        ): ?>

                            <?php

                            $programId =
                                (int) (
                                    $program['id']
                                    ?? 0
                                );

                            $programName =
                                trim(
                                    (string) (
                                        $program['name']
                                        ?? ''
                                    )
                                );

                            $facultyName =
                                trim(
                                    (string) (
                                        $program['faculty_name']
                                        ?? ''
                                    )
                                );

                            $degree =
                                trim(
                                    (string) (
                                        $program['degree']
                                        ?? ''
                                    )
                                );

                            $field =
                                trim(
                                    (string) (
                                        $program['field']
                                        ?? ''
                                    )
                                );

                            $slug =
                                trim(
                                    (string) (
                                        $program['slug']
                                        ?? ''
                                    )
                                );

                            $isActive =
                                (int) (
                                    $program['is_active']
                                    ?? 0
                                ) === 1;

                            ?>

                            <tr>

                                <td>

                                    <div class="program-admin__program-cell">

                                        <div
                                            class="program-admin__program-icon"
                                            aria-hidden="true"
                                        >
                                            📚
                                        </div>

                                        <div class="program-admin__program-info">

                                            <strong>
                                                <?= View::escape(
                                                    $programName
                                                ) ?>
                                            </strong>

                                            <?php if (
                                                $field !== ''
                                            ): ?>

                                                <span>
                                                    <?= View::escape(
                                                        $field
                                                    ) ?>
                                                </span>

                                            <?php elseif (
                                                $slug !== ''
                                            ): ?>

                                                <span dir="ltr">
                                                    /programs/<?= View::escape(
                                                        $slug
                                                    ) ?>
                                                </span>

                                            <?php endif; ?>

                                        </div>

                                    </div>

                                </td>


                                <td>

                                    <?php if (
                                        $facultyName !== ''
                                    ): ?>

                                        <span class="program-admin__faculty">
                                            <?= View::escape(
                                                $facultyName
                                            ) ?>
                                        </span>

                                    <?php else: ?>

                                        <span class="program-admin__muted">
                                            —
                                        </span>

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <?php if (
                                        $degree !== ''
                                    ): ?>

                                        <span class="program-admin__degree">
                                            <?= View::escape(
                                                $degree
                                            ) ?>
                                        </span>

                                    <?php else: ?>

                                        <span class="program-admin__muted">
                                            تعیین نشده
                                        </span>

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <?php if (
                                        $isActive
                                    ): ?>

                                        <span class="program-admin__status program-admin__status--active">

                                            <span
                                                class="program-admin__status-dot"
                                                aria-hidden="true"
                                            ></span>

                                            فعال

                                        </span>

                                    <?php else: ?>

                                        <span class="program-admin__status program-admin__status--inactive">

                                            <span
                                                class="program-admin__status-dot"
                                                aria-hidden="true"
                                            ></span>

                                            غیرفعال

                                        </span>

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <div class="program-admin__actions">

                                        <a
                                            href="<?= View::url(
                                                '/admin/programs/'
                                                . $programId
                                                . '/edit'
                                            ) ?>"
                                            class="program-admin__action program-admin__action--edit"
                                        >
                                            ویرایش
                                        </a>


                                        <?php if (
                                            $slug !== ''
                                        ): ?>

                                            <a
                                                href="<?= View::url(
                                                    '/programs/'
                                                    . $slug
                                                ) ?>"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="program-admin__action program-admin__action--view"
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
                                                '/admin/programs/'
                                                . $programId
                                                . '/delete'
                                            ) ?>"
                                            onsubmit="return confirm('آیا از حذف این برنامه مطمئن هستید؟');"
                                        >

                                            <?= Csrf::field() ?>

                                            <button
                                                type="submit"
                                                class="program-admin__action program-admin__action--danger"
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
            class="program-admin__pagination"
            aria-label="صفحه‌بندی"
        >

            <?php if (
                $page > 1
            ): ?>

                <a
                    href="<?= View::url(
                        '/admin/programs?page='
                        . (
                            $page - 1
                        )
                    ) ?>"
                    class="program-admin__page"
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
                        '/admin/programs?page='
                        . $i
                    ) ?>"
                    class="
                        program-admin__page
                        <?= $i === $page
                            ? 'program-admin__page--active'
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
                        '/admin/programs?page='
                        . (
                            $page + 1
                        )
                    ) ?>"
                    class="program-admin__page"
                >
                    بعدی
                </a>

            <?php endif; ?>

        </nav>

    <?php endif; ?>

</div>
<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;

$items =
    is_array($people['items'] ?? null)
        ? $people['items']
        : [];

$total =
    (int) (
        $people['total']
        ?? 0
    );

$page =
    max(
        1,
        (int) (
            $people['page']
            ?? 1
        )
    );

$totalPages =
    max(
        1,
        (int) (
            $people['totalPages']
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

<div class="people-admin">

    <!-- =========================================================
         HEADER
    ========================================================== -->

    <header class="people-admin__header">

        <div class="people-admin__header-main">

            <span class="people-admin__eyebrow">
                اعضای موسسه
            </span>

            <div class="people-admin__title-row">

                <div
                    class="people-admin__title-icon"
                    aria-hidden="true"
                >
                    👥
                </div>

                <div>

                    <h1 class="people-admin__title">
                        اعضای هیئت علمی و کارکنان
                    </h1>

                    <p class="people-admin__description">
                        اطلاعات اساتید، مدیران و کارکنان موسسه را مدیریت کنید.
                    </p>

                </div>

            </div>

        </div>


        <div class="people-admin__header-actions">

            <a
                href="<?= View::route(
                    'admin.people.create'
                ) ?>"
                class="people-admin__button people-admin__button--primary"
            >

                <span aria-hidden="true">
                    +
                </span>

                افزودن شخص

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
            class="people-admin__alert people-admin__alert--success"
            role="status"
        >

            <div
                class="people-admin__alert-icon"
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
            class="people-admin__alert people-admin__alert--error"
            role="alert"
        >

            <div
                class="people-admin__alert-icon"
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

    <section class="people-admin__stats">

        <div class="people-admin__stat">

            <div
                class="people-admin__stat-icon"
                aria-hidden="true"
            >
                👥
            </div>

            <div>

                <span>
                    مجموع اعضا
                </span>

                <strong>
                    <?= number_format(
                        $total
                    ) ?>
                </strong>

            </div>

        </div>


        <div class="people-admin__stat">

            <div
                class="people-admin__stat-icon"
                aria-hidden="true"
            >
                🎓
            </div>

            <div>

                <span>
                    بخش آموزشی
                </span>

                <strong>
                    هیئت علمی
                </strong>

            </div>

        </div>


        <div class="people-admin__stat">

            <div
                class="people-admin__stat-icon"
                aria-hidden="true"
            >
                🌐
            </div>

            <div>

                <span>
                    وضعیت
                </span>

                <strong>
                    مدیریت آنلاین
                </strong>

            </div>

        </div>

    </section>


    <!-- =========================================================
         MAIN PANEL
    ========================================================== -->

    <section class="people-admin__panel">

        <div class="people-admin__panel-header">

            <div>

                <span class="people-admin__panel-eyebrow">
                    فهرست اعضا
                </span>

                <h2>
                    اساتید و کارکنان
                </h2>

                <p>
                    اطلاعات اعضای موسسه را مشاهده و مدیریت کنید.
                </p>

            </div>


            <div class="people-admin__panel-count">

                <strong>
                    <?= number_format(
                        $total
                    ) ?>
                </strong>

                <span>
                    نفر
                </span>

            </div>

        </div>


        <?php if (
            $items === []
        ): ?>

            <div class="people-admin__empty">

                <div
                    class="people-admin__empty-icon"
                    aria-hidden="true"
                >
                    👥
                </div>

                <h3>
                    هنوز شخصی ثبت نشده است
                </h3>

                <p>
                    اولین عضو هیئت علمی یا کارمند را اضافه کنید.
                </p>

                <a
                    href="<?= View::route(
                        'admin.people.create'
                    ) ?>"
                    class="people-admin__button people-admin__button--primary"
                >
                    افزودن اولین شخص
                </a>

            </div>

        <?php else: ?>

            <div class="people-admin__table-wrap">

                <table class="people-admin__table">

                    <thead>

                        <tr>

                            <th>
                                شخص
                            </th>

                            <th>
                                سمت
                            </th>

                            <th>
                                دانشکده
                            </th>

                            <th>
                                ارتباط
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
                            as $person
                        ): ?>

                            <?php

                            $personId =
                                (int) (
                                    $person['id']
                                    ?? 0
                                );

                            $firstName =
                                trim(
                                    (string) (
                                        $person['first_name']
                                        ?? ''
                                    )
                                );

                            $lastName =
                                trim(
                                    (string) (
                                        $person['last_name']
                                        ?? ''
                                    )
                                );

                            $fullName =
                                trim(
                                    $firstName
                                    . ' '
                                    . $lastName
                                );

                            if (
                                $fullName === ''
                            ) {
                                $fullName =
                                    'بدون نام';
                            }

                            $position =
                                trim(
                                    (string) (
                                        $person['position']
                                        ?? ''
                                    )
                                );

                            $facultyName =
                                trim(
                                    (string) (
                                        $person['faculty_name']
                                        ?? ''
                                    )
                                );

                            $email =
                                trim(
                                    (string) (
                                        $person['email']
                                        ?? ''
                                    )
                                );

                            $phone =
                                trim(
                                    (string) (
                                        $person['phone']
                                        ?? ''
                                    )
                                );

                            $isActive =
                                (int) (
                                    $person['is_active']
                                    ?? 0
                                ) === 1;

                            ?>

                            <tr>

                                <!-- PERSON -->

                                <td>

                                    <div class="people-admin__person-cell">

                                        <div
                                            class="people-admin__avatar"
                                            aria-hidden="true"
                                        >
                                            <?= View::escape(
                                                mb_strtoupper(
                                                    mb_substr(
                                                        $fullName,
                                                        0,
                                                        1,
                                                        'UTF-8'
                                                    ),
                                                    'UTF-8'
                                                )
                                            ) ?>
                                        </div>


                                        <div class="people-admin__person-info">

                                            <strong>
                                                <?= View::escape(
                                                    $fullName
                                                ) ?>
                                            </strong>

                                            <?php if (
                                                $email !== ''
                                            ): ?>

                                                <span dir="ltr">
                                                    <?= View::escape(
                                                        $email
                                                    ) ?>
                                                </span>

                                            <?php endif; ?>

                                        </div>

                                    </div>

                                </td>


                                <!-- POSITION -->

                                <td>

                                    <?php if (
                                        $position !== ''
                                    ): ?>

                                        <span class="people-admin__position">
                                            <?= View::escape(
                                                $position
                                            ) ?>
                                        </span>

                                    <?php else: ?>

                                        <span class="people-admin__muted">
                                            تعیین نشده
                                        </span>

                                    <?php endif; ?>

                                </td>


                                <!-- FACULTY -->

                                <td>

                                    <?php if (
                                        $facultyName !== ''
                                    ): ?>

                                        <span class="people-admin__faculty">
                                            <?= View::escape(
                                                $facultyName
                                            ) ?>
                                        </span>

                                    <?php else: ?>

                                        <span class="people-admin__muted">
                                            بدون دانشکده
                                        </span>

                                    <?php endif; ?>

                                </td>


                                <!-- CONTACT -->

                                <td>

                                    <div class="people-admin__contact">

                                        <?php if (
                                            $email !== ''
                                        ): ?>

                                            <a
                                                href="mailto:<?= View::escape(
                                                    $email
                                                ) ?>"
                                                title="ارسال ایمیل"
                                            >
                                                ✉
                                            </a>

                                        <?php endif; ?>


                                        <?php if (
                                            $phone !== ''
                                        ): ?>

                                            <a
                                                href="tel:<?= View::escape(
                                                    preg_replace(
                                                        '/[^0-9+]/',
                                                        '',
                                                        $phone
                                                    ) ?? ''
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

                                            <span class="people-admin__muted">
                                                —
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
                                                people-admin__status
                                                people-admin__status--active
                                            "
                                        >

                                            <span
                                                class="people-admin__status-dot"
                                                aria-hidden="true"
                                            ></span>

                                            فعال

                                        </span>

                                    <?php else: ?>

                                        <span
                                            class="
                                                people-admin__status
                                                people-admin__status--inactive
                                            "
                                        >

                                            <span
                                                class="people-admin__status-dot"
                                                aria-hidden="true"
                                            ></span>

                                            غیرفعال

                                        </span>

                                    <?php endif; ?>

                                </td>


                                <!-- ACTIONS -->

                                <td>

                                    <div class="people-admin__actions">

                                        <a
                                            href="<?= View::url(
                                                '/admin/people/'
                                                . $personId
                                                . '/edit'
                                            ) ?>"
                                            class="
                                                people-admin__action
                                                people-admin__action--edit
                                            "
                                        >
                                            ویرایش
                                        </a>


                                        <a
                                            href="<?= View::url(
                                                '/people/'
                                                . $personId
                                            ) ?>"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="
                                                people-admin__action
                                                people-admin__action--view
                                            "
                                        >
                                            مشاهده
                                            <span aria-hidden="true">
                                                ↗
                                            </span>
                                        </a>


                                        <form
                                            method="POST"
                                            action="<?= View::url(
                                                '/admin/people/'
                                                . $personId
                                                . '/delete'
                                            ) ?>"
                                            onsubmit="return confirm('آیا از حذف این شخص مطمئن هستید؟');"
                                        >

                                            <?= Csrf::field() ?>

                                            <button
                                                type="submit"
                                                class="
                                                    people-admin__action
                                                    people-admin__action--danger
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
            class="people-admin__pagination"
            aria-label="صفحه‌بندی"
        >

            <?php if (
                $page > 1
            ): ?>

                <a
                    href="<?= View::url(
                        '/admin/people?page='
                        . (
                            $page - 1
                        )
                    ) ?>"
                    class="people-admin__page"
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
                        '/admin/people?page='
                        . $i
                    ) ?>"
                    class="
                        people-admin__page
                        <?= $i === $page
                            ? 'people-admin__page--active'
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
                        '/admin/people?page='
                        . (
                            $page + 1
                        )
                    ) ?>"
                    class="people-admin__page"
                >
                    بعدی
                </a>

            <?php endif; ?>

        </nav>

    <?php endif; ?>

</div>
<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


/*
|--------------------------------------------------------------------------
| Normalize data
|--------------------------------------------------------------------------
*/

$announcements =
    is_array($announcements ?? null)
        ? $announcements
        : [];

$items =
    is_array($announcements['items'] ?? null)
        ? $announcements['items']
        : [];

$total =
    (int) (
        $announcements['total']
        ?? count($items)
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
    is_string($success ?? null)
        ? trim($success)
        : '';

$error =
    is_string($error ?? null)
        ? trim($error)
        : '';


/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

$formatDate =
    static function (
        mixed $value,
        string $format = 'Y/m/d H:i'
    ): string {
        if (
            !is_string($value)
            || trim($value) === ''
        ) {
            return '';
        }

        if (
            function_exists(
                'jalali_date'
            )
        ) {
            $jalali =
                jalali_date(
                    $value,
                    $format
                );

            if (
                is_string($jalali)
                && trim($jalali) !== ''
            ) {
                return $jalali;
            }
        }

        $timestamp =
            strtotime(
                $value
            );

        if (
            $timestamp === false
        ) {
            return '';
        }

        return date(
            $format,
            $timestamp
        );
    };


$shorten =
    static function (
        mixed $value,
        int $width
    ): string {
        if (
            !is_string($value)
            || trim($value) === ''
        ) {
            return '';
        }

        return mb_strimwidth(
            trim($value),
            0,
            $width,
            '...',
            'UTF-8'
        );
    };


$statusLabel =
    static function (
        mixed $status
    ): string {
        return match (
            (string) $status
        ) {
            'published' =>
                'منتشر شده',

            'archived' =>
                'بایگانی شده',

            default =>
                'پیش‌نویس',
        };
    };


$statusClass =
    static function (
        mixed $status
    ): string {
        return match (
            (string) $status
        ) {
            'published' =>
                'english-announcement-admin-status--published',

            'archived' =>
                'english-announcement-admin-status--archived',

            default =>
                'english-announcement-admin-status--draft',
        };
    };

?>

<div class="admin-page">

    <div class="english-announcement-admin">


        <!-- =========================================================
             HEADER
        ========================================================== -->

        <header class="english-announcement-admin__header">

            <div class="english-announcement-admin__header-main">

                <a
                    href="<?= View::url(
                        '/admin/english'
                    ) ?>"
                    class="english-announcement-admin__back"
                >
                    <span aria-hidden="true">
                        →
                    </span>

                    بازگشت به مدیریت سایت انگلیسی
                </a>


                <div class="english-announcement-admin__title-row">

                    <div
                        class="english-announcement-admin__title-icon"
                        aria-hidden="true"
                    >
                        📢
                    </div>


                    <div>

                        <span class="english-announcement-admin__eyebrow">
                            ENGLISH WEBSITE
                        </span>


                        <h1>
                            اطلاعیه‌های انگلیسی
                        </h1>


                        <p>
                            اطلاعیه‌های نسخه انگلیسی سایت را ایجاد،
                            ویرایش، منتشر و مدیریت کنید.
                        </p>

                    </div>

                </div>

            </div>


            <div class="english-announcement-admin__header-actions">

                <a
                    href="<?= View::url(
                        '/admin/english/announcements/create'
                    ) ?>"
                    class="
                        english-announcement-admin__button
                        english-announcement-admin__button--primary
                    "
                >
                    <span aria-hidden="true">
                        +
                    </span>

                    ایجاد اطلاعیه
                </a>


                <a
                    href="<?= View::url(
                        '/english/announcements'
                    ) ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="
                        english-announcement-admin__button
                        english-announcement-admin__button--secondary
                    "
                >
                    مشاهده سایت
                    <span aria-hidden="true">
                        ↗
                    </span>
                </a>

            </div>

        </header>


        <!-- =========================================================
             MESSAGES
        ========================================================== -->

        <?php if (
            $success !== ''
        ): ?>

            <div
                class="
                    english-announcement-admin__message
                    english-announcement-admin__message--success
                "
                role="status"
            >

                <span
                    class="english-announcement-admin__message-icon"
                    aria-hidden="true"
                >
                    ✓
                </span>

                <div>

                    <strong>
                        عملیات با موفقیت انجام شد
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
            $error !== ''
        ): ?>

            <div
                class="
                    english-announcement-admin__message
                    english-announcement-admin__message--error
                "
                role="alert"
            >

                <span
                    class="english-announcement-admin__message-icon"
                    aria-hidden="true"
                >
                    !
                </span>

                <div>

                    <strong>
                        عملیات انجام نشد
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
             SUMMARY
        ========================================================== -->

        <section class="english-announcement-admin__summary">

            <div
                class="english-announcement-admin__summary-card"
            >

                <span>
                    تعداد کل
                </span>

                <strong>
                    <?= number_format(
                        $total
                    ) ?>
                </strong>

                <small>
                    اطلاعیه انگلیسی
                </small>

            </div>


            <?php
            $publishedCount = 0;

            $draftCount = 0;

            $archivedCount = 0;

            foreach (
                $items as $item
            ) {
                $itemStatus =
                    (string) (
                        $item['status']
                        ?? 'draft'
                    );

                if (
                    $itemStatus === 'published'
                ) {
                    $publishedCount++;
                } elseif (
                    $itemStatus === 'archived'
                ) {
                    $archivedCount++;
                } else {
                    $draftCount++;
                }
            }
            ?>


            <div
                class="english-announcement-admin__summary-card"
            >

                <span>
                    منتشر شده در صفحه
                </span>

                <strong>
                    <?= number_format(
                        $publishedCount
                    ) ?>
                </strong>

                <small>
                    از رکوردهای این صفحه
                </small>

            </div>


            <div
                class="english-announcement-admin__summary-card"
            >

                <span>
                    پیش‌نویس
                </span>

                <strong>
                    <?= number_format(
                        $draftCount
                    ) ?>
                </strong>

                <small>
                    هنوز منتشر نشده
                </small>

            </div>


            <div
                class="english-announcement-admin__summary-card"
            >

                <span>
                    بایگانی شده
                </span>

                <strong>
                    <?= number_format(
                        $archivedCount
                    ) ?>
                </strong>

                <small>
                    در این صفحه
                </small>

            </div>

        </section>


        <!-- =========================================================
             LIST PANEL
        ========================================================== -->

        <section class="english-announcement-admin__panel">


            <div class="english-announcement-admin__panel-header">

                <div>

                    <span>
                        ANNOUNCEMENTS
                    </span>


                    <h2>
                        فهرست اطلاعیه‌ها
                    </h2>


                    <p>
                        جدیدترین اطلاعیه‌های انگلیسی را مدیریت کنید.
                    </p>

                </div>


                <div class="english-announcement-admin__panel-count">

                    <?= number_format(
                        $total
                    ) ?>

                    رکورد

                </div>

            </div>


            <?php if (
                $items === []
            ): ?>


                <!-- =================================================
                     EMPTY STATE
                ================================================== -->

                <div class="english-announcement-admin__empty">

                    <div
                        class="english-announcement-admin__empty-icon"
                        aria-hidden="true"
                    >
                        📢
                    </div>


                    <span>
                        ENGLISH ANNOUNCEMENTS
                    </span>


                    <h2>
                        هنوز اطلاعیه‌ای ایجاد نشده است.
                    </h2>


                    <p>
                        اولین اطلاعیه نسخه انگلیسی سایت را ایجاد کنید.
                    </p>


                    <a
                        href="<?= View::url(
                            '/admin/english/announcements/create'
                        ) ?>"
                        class="
                            english-announcement-admin__button
                            english-announcement-admin__button--primary
                        "
                    >
                        ایجاد اولین اطلاعیه
                    </a>

                </div>


            <?php else: ?>


                <!-- =================================================
                     TABLE
                ================================================== -->

                <div
                    class="
                        english-announcement-admin__table-wrap
                    "
                >

                    <table
                        class="
                            english-announcement-admin__table
                        "
                    >

                        <thead>

                            <tr>

                                <th>
                                    اطلاعیه
                                </th>

                                <th>
                                    وضعیت
                                </th>

                                <th>
                                    اولویت
                                </th>

                                <th>
                                    انتشار
                                </th>

                                <th>
                                    ایجادکننده
                                </th>

                                <th>
                                    عملیات
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php foreach (
                                $items as $index => $announcement
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

                                $excerpt =
                                    $shorten(
                                        $announcement['excerpt']
                                        ?? '',
                                        145
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
                                    $formatDate(
                                        $announcement['published_at']
                                        ?? null
                                    );

                                $expiresAt =
                                    $formatDate(
                                        $announcement['expires_at']
                                        ?? null
                                    );

                                $createdAt =
                                    $formatDate(
                                        $announcement['created_at']
                                        ?? null,
                                        'Y/m/d'
                                    );

                                $creatorName =
                                    trim(
                                        (
                                            (string) (
                                                $announcement[
                                                    'created_by_first_name'
                                                ]
                                                ?? ''
                                            )
                                        )
                                        . ' '
                                        . (
                                            (string) (
                                                $announcement[
                                                    'created_by_last_name'
                                                ]
                                                ?? ''
                                            )
                                        )
                                    );

                                if (
                                    $creatorName === ''
                                ) {
                                    $creatorName =
                                        trim(
                                            (string) (
                                                $announcement[
                                                    'created_by_username'
                                                ]
                                                ?? ''
                                            )
                                        );
                                }

                                if (
                                    $creatorName === ''
                                ) {
                                    $creatorName =
                                        '—';
                                }

                                $isPublished =
                                    $status === 'published';

                                $isArchived =
                                    $status === 'archived';
                                ?>


                                <tr>

                                    <td>

                                        <div
                                            class="
                                                english-announcement-admin__announcement
                                            "
                                        >

                                            <div
                                                class="
                                                    english-announcement-admin__announcement-number
                                                "
                                            >
                                                <?= str_pad(
                                                    (string) (
                                                        $index + 1
                                                    ),
                                                    2,
                                                    '0',
                                                    STR_PAD_LEFT
                                                ) ?>
                                            </div>


                                            <div
                                                class="
                                                    english-announcement-admin__announcement-content
                                                "
                                            >

                                                <strong>

                                                    <?= View::escape(
                                                        $title !== ''
                                                            ? $title
                                                            : 'بدون عنوان'
                                                    ) ?>

                                                </strong>


                                                <?php if (
                                                    $slug !== ''
                                                ): ?>

                                                    <span
                                                        dir="ltr"
                                                        class="
                                                            english-announcement-admin__slug
                                                        "
                                                    >
                                                        /
                                                        <?= View::escape(
                                                            $slug
                                                        ) ?>
                                                    </span>

                                                <?php endif; ?>


                                                <?php if (
                                                    $excerpt !== ''
                                                ): ?>

                                                    <p>
                                                        <?= View::escape(
                                                            $excerpt
                                                        ) ?>
                                                    </p>

                                                <?php endif; ?>

                                            </div>

                                        </div>

                                    </td>


                                    <td>

                                        <span
                                            class="
                                                english-announcement-admin-status
                                                <?= View::escape(
                                                    $statusClass(
                                                        $status
                                                    )
                                                ) ?>
                                            "
                                        >
                                            <?= View::escape(
                                                $statusLabel(
                                                    $status
                                                )
                                            ) ?>
                                        </span>

                                    </td>


                                    <td>

                                        <span
                                            class="
                                                english-announcement-admin__priority
                                                <?= $priority > 0
                                                    ? 'english-announcement-admin__priority--high'
                                                    : ''
                                                ?>
                                            "
                                        >
                                            <?= $priority ?>
                                        </span>

                                    </td>


                                    <td>

                                        <div
                                            class="
                                                english-announcement-admin__date
                                            "
                                        >

                                            <?php if (
                                                $publishedAt !== ''
                                            ): ?>

                                                <strong>
                                                    <?= View::escape(
                                                        $publishedAt
                                                    ) ?>
                                                </strong>

                                            <?php elseif (
                                                $status === 'draft'
                                            ): ?>

                                                <span>
                                                    منتشر نشده
                                                </span>

                                            <?php else: ?>

                                                <span>
                                                    —
                                                </span>

                                            <?php endif; ?>


                                            <?php if (
                                                $expiresAt !== ''
                                            ): ?>

                                                <small>
                                                    انقضا:
                                                    <?= View::escape(
                                                        $expiresAt
                                                    ) ?>
                                                </small>

                                            <?php endif; ?>

                                        </div>

                                    </td>


                                    <td>

                                        <div
                                            class="
                                                english-announcement-admin__creator
                                            "
                                        >

                                            <strong>
                                                <?= View::escape(
                                                    $creatorName
                                                ) ?>
                                            </strong>


                                            <?php if (
                                                $createdAt !== ''
                                            ): ?>

                                                <small>
                                                    <?= View::escape(
                                                        $createdAt
                                                    ) ?>
                                                </small>

                                            <?php endif; ?>

                                        </div>

                                    </td>


                                    <td>

                                        <div
                                            class="
                                                english-announcement-admin__actions
                                            "
                                        >

                                            <a
                                                href="<?= View::route(
                                                    'admin.english.announcements.edit',
                                                    [
                                                        'id' =>
                                                            $id,
                                                    ]
                                                ) ?>"
                                                class="
                                                    english-announcement-admin__action
                                                    english-announcement-admin__action--edit
                                                "
                                            >
                                                ویرایش
                                            </a>


                                            <?php if (
                                                !$isPublished
                                                && !$isArchived
                                            ): ?>

                                                <form
                                                    method="POST"
                                                    action="<?= View::route(
                                                        'admin.english.announcements.publish',
                                                        [
                                                            'id' =>
                                                                $id,
                                                        ]
                                                    ) ?>"
                                                    onsubmit="return confirm('آیا از انتشار این اطلاعیه مطمئن هستید؟');"
                                                >

                                                    <?= Csrf::field() ?>

                                                    <button
                                                        type="submit"
                                                        class="
                                                            english-announcement-admin__action
                                                            english-announcement-admin__action--publish
                                                        "
                                                    >
                                                        انتشار
                                                    </button>

                                                </form>

                                            <?php endif; ?>


                                            <?php if (
                                                $isPublished
                                            ): ?>

                                                <form
                                                    method="POST"
                                                    action="<?= View::route(
                                                        'admin.english.announcements.archive',
                                                        [
                                                            'id' =>
                                                                $id,
                                                        ]
                                                    ) ?>"
                                                    onsubmit="return confirm('آیا از بایگانی این اطلاعیه مطمئن هستید؟');"
                                                >

                                                    <?= Csrf::field() ?>

                                                    <button
                                                        type="submit"
                                                        class="
                                                            english-announcement-admin__action
                                                            english-announcement-admin__action--archive
                                                        "
                                                    >
                                                        بایگانی
                                                    </button>

                                                </form>

                                            <?php endif; ?>


                                            <?php if (
                                                $slug !== ''
                                            ): ?>

                                                <a
                                                    href="<?= View::url(
                                                        '/english/announcements/'
                                                        . rawurlencode(
                                                            $slug
                                                        )
                                                    ) ?>"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="
                                                        english-announcement-admin__action
                                                        english-announcement-admin__action--view
                                                    "
                                                >
                                                    مشاهده
                                                </a>

                                            <?php endif; ?>


                                            <form
                                                method="POST"
                                                action="<?= View::route(
                                                    'admin.english.announcements.delete',
                                                    [
                                                        'id' =>
                                                            $id,
                                                    ]
                                                ) ?>"
                                                onsubmit="return confirm('آیا از حذف این اطلاعیه مطمئن هستید؟ این عملیات قابل بازگشت نیست.');"
                                            >

                                                <?= Csrf::field() ?>

                                                <button
                                                    type="submit"
                                                    class="
                                                        english-announcement-admin__action
                                                        english-announcement-admin__action--delete
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


                <!-- =================================================
                     PAGINATION
                ================================================== -->

                <?php if (
                    $totalPages > 1
                ): ?>

                    <nav
                        class="
                            english-announcement-admin__pagination
                        "
                        aria-label="صفحه‌بندی اطلاعیه‌ها"
                    >

                        <?php if (
                            $page > 1
                        ): ?>

                            <a
                                href="<?= View::url(
                                    '/admin/english/announcements?page='
                                    . (
                                        $page - 1
                                    )
                                ) ?>"
                            >
                                ← قبلی
                            </a>

                        <?php else: ?>

                            <span
                                class="
                                    english-announcement-admin__pagination-disabled
                                "
                            >
                                ← قبلی
                            </span>

                        <?php endif; ?>


                        <span>
                            صفحه
                            <?= $page ?>
                            از
                            <?= $totalPages ?>
                        </span>


                        <?php if (
                            $page < $totalPages
                        ): ?>

                            <a
                                href="<?= View::url(
                                    '/admin/english/announcements?page='
                                    . (
                                        $page + 1
                                    )
                                ) ?>"
                            >
                                بعدی →
                            </a>

                        <?php else: ?>

                            <span
                                class="
                                    english-announcement-admin__pagination-disabled
                                "
                            >
                                بعدی →
                            </span>

                        <?php endif; ?>

                    </nav>

                <?php endif; ?>

            <?php endif; ?>

        </section>


    </div>

</div>
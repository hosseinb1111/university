<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


/*
|--------------------------------------------------------------------------
| Normalize page data
|--------------------------------------------------------------------------
*/

$items =
    is_array(
        $pages['items']
        ?? null
    )
        ? $pages['items']
        : [];


$total =
    (int) (
        $pages['total']
        ?? 0
    );


$pageNumber =
    max(
        1,
        (int) (
            $pages['page']
            ?? 1
        )
    );


$totalPages =
    max(
        1,
        (int) (
            $pages['totalPages']
            ?? 1
        )
    );


$success =
    is_string(
        $success ?? null
    )
        ? $success
        : null;


$error =
    is_string(
        $error ?? null
    )
        ? $error
        : null;


/*
|--------------------------------------------------------------------------
| Date formatter
|--------------------------------------------------------------------------
|
| Database dates should normally arrive as:
|
|     2026-08-18 21:40:00
|
| However, some queries may return UNIX timestamps:
|
|     1787076840
|
| jalali_date_fa() intentionally accepts strings / DateTimeInterface /
| null, not integers.
|
| Therefore this view normalizes integer timestamps into DateTimeImmutable
| before sending them to the Jalali helper.
|
*/

$formatDate =
    static function (
        mixed $date
    ): string {

        if (
            $date === null
            || $date === ''
        ) {
            return '—';
        }


        /*
         * UNIX timestamp.
         */
        if (
            is_int($date)
            || (
                is_string($date)
                && preg_match(
                    '/^-?\d+$/',
                    trim($date)
                )
            )
        ) {

            $timestamp =
                (int) $date;


            try {

                $dateObject =
                    new DateTimeImmutable(
                        '@' . $timestamp
                    );


                /*
                 * Convert from UTC timestamp to the application's
                 * configured timezone.
                 */
                $dateObject =
                    $dateObject->setTimezone(
                        new DateTimeZone(
                            date_default_timezone_get()
                        )
                    );


                $formatted =
                    jalali_date_fa(
                        $dateObject,
                        'Y/m/d H:i'
                    );


                return $formatted !== ''
                    ? $formatted
                    : '—';

            } catch (
                Throwable
            ) {

                return '—';

            }

        }


        /*
         * Normal Gregorian DB string.
         */
        if (
            is_string($date)
        ) {

            $date =
                trim($date);


            if (
                $date === ''
            ) {
                return '—';
            }


            $formatted =
                jalali_date_fa(
                    $date,
                    'Y/m/d H:i'
                );


            return $formatted !== ''
                ? $formatted
                : '—';
        }


        /*
         * DateTimeInterface.
         */
        if (
            $date instanceof DateTimeInterface
        ) {

            $formatted =
                jalali_date_fa(
                    $date,
                    'Y/m/d H:i'
                );


            return $formatted !== ''
                ? $formatted
                : '—';
        }


        return '—';
    };

?>

<div class="admin-pages">

    <header class="admin-pages__header">

        <div class="admin-pages__header-main">

            <span class="admin-pages__eyebrow">
                مدیریت محتوا
            </span>

            <h1>
                صفحات سایت
            </h1>

            <p>
                صفحات، محتوای اصلی، ساختار والد و وضعیت انتشار سایت را از اینجا مدیریت کنید.
            </p>

        </div>


        <div class="admin-pages__header-actions">

            <a
                href="<?= View::route(
                    'admin.pages.create'
                ) ?>"
                class="
                    admin-pages__button
                    admin-pages__button--primary
                "
            >

                <span aria-hidden="true">
                    +
                </span>

                ایجاد صفحه

            </a>

        </div>

    </header>


    <?php if (
        $success !== null
        && $success !== ''
    ): ?>

        <div
            class="
                admin-pages__alert
                admin-pages__alert--success
            "
            role="status"
        >

            <strong>
                موفق
            </strong>

            <span>
                <?= View::escape(
                    $success
                ) ?>
            </span>

        </div>

    <?php endif; ?>


    <?php if (
        $error !== null
        && $error !== ''
    ): ?>

        <div
            class="
                admin-pages__alert
                admin-pages__alert--error
            "
            role="alert"
        >

            <strong>
                خطا
            </strong>

            <span>
                <?= View::escape(
                    $error
                ) ?>
            </span>

        </div>

    <?php endif; ?>


    <section class="admin-pages__panel">

        <header class="admin-pages__panel-header">

            <div class="admin-pages__panel-heading">

                <div
                    class="admin-pages__panel-icon"
                    aria-hidden="true"
                >
                    📄
                </div>

                <div>

                    <strong>
                        کتابخانه صفحات
                    </strong>

                    <span>
                        <?= number_format(
                            $total
                        ) ?>
                        صفحه ثبت شده
                    </span>

                </div>

            </div>

        </header>


        <?php if (
            $items === []
        ): ?>

            <div class="admin-pages__empty">

                <div
                    class="admin-pages__empty-icon"
                    aria-hidden="true"
                >
                    📄
                </div>

                <h2>
                    هنوز صفحه‌ای ایجاد نشده است.
                </h2>

                <p>
                    اولین صفحه سایت را ایجاد کنید و عنوان، محتوا، وضعیت انتشار و تنظیمات SEO آن را مدیریت کنید.
                </p>

                <a
                    href="<?= View::route(
                        'admin.pages.create'
                    ) ?>"
                    class="
                        admin-pages__button
                        admin-pages__button--primary
                    "
                >
                    ایجاد اولین صفحه
                </a>

            </div>

        <?php else: ?>

            <div class="admin-pages__table-wrapper">

                <table class="admin-pages__table">

                    <thead>

                    <tr>

                        <th>
                            صفحه
                        </th>

                        <th>
                            والد
                        </th>

                        <th>
                            وضعیت
                        </th>

                        <th>
                            تاریخ انتشار
                        </th>

                        <th>
                            آخرین بروزرسانی
                        </th>

                        <th>
                            آدرس
                        </th>

                        <th>
                            عملیات
                        </th>

                    </tr>

                    </thead>


                    <tbody>

                    <?php foreach (
                        $items
                        as $page
                    ): ?>

                        <?php

                        $id =
                            (int) (
                                $page['id']
                                ?? 0
                            );


                        $title =
                            trim(
                                (string) (
                                    $page['title']
                                    ?? ''
                                )
                            );


                        if (
                            $title === ''
                        ) {

                            $title =
                                'صفحه بدون عنوان';

                        }


                        $slug =
                            trim(
                                (string) (
                                    $page['slug']
                                    ?? ''
                                )
                            );


                        $parentTitle =
                            trim(
                                (string) (
                                    $page['parent_title']
                                    ?? ''
                                )
                            );


                        $status =
                            (string) (
                                $page['status']
                                ?? 'draft'
                            );


                        $publishedAt =
                            $formatDate(
                                $page['published_at']
                                ?? null
                            );


                        $updatedAt =
                            $formatDate(
                                $page['updated_at']
                                ?? null
                            );

                        ?>

                        <tr>


                            <!-- Page -->

                            <td>

                                <div class="admin-pages__title">

                                    <div class="admin-pages__title-main">

                                        <div
                                            class="admin-pages__title-icon"
                                            aria-hidden="true"
                                        >
                                            📄
                                        </div>

                                        <div class="admin-pages__title-text">

                                            <strong>
                                                <?= View::escape(
                                                    $title
                                                ) ?>
                                            </strong>

                                            <span>
                                                شناسه:
                                                #<?= $id ?>
                                            </span>


                                            <?php if (
                                                !empty(
                                                    $page['creator_first_name']
                                                    ?? ''
                                                )
                                                ||
                                                !empty(
                                                    $page['creator_last_name']
                                                    ?? ''
                                                )
                                            ): ?>

                                                <span>
                                                    ایجادکننده:

                                                    <?= View::escape(
                                                        trim(
                                                            (string) (
                                                                ($page['creator_first_name'] ?? '')
                                                                . ' '
                                                                . ($page['creator_last_name'] ?? '')
                                                            )
                                                        )
                                                    ) ?>

                                                </span>

                                            <?php elseif (
                                                !empty(
                                                    $page['creator_username']
                                                    ?? ''
                                                )
                                            ): ?>

                                                <span>

                                                    ایجادکننده:

                                                    <?= View::escape(
                                                        (string) (
                                                            $page['creator_username']
                                                        )
                                                    ) ?>

                                                </span>

                                            <?php endif; ?>

                                        </div>

                                    </div>

                                </div>

                            </td>


                            <!-- Parent -->

                            <td>

                                <?php if (
                                    $parentTitle === ''
                                ): ?>

                                    <span
                                        class="
                                            admin-pages__parent
                                            admin-pages__parent--root
                                        "
                                    >
                                        بدون والد
                                    </span>

                                <?php else: ?>

                                    <span
                                        class="admin-pages__parent"
                                    >
                                        <?= View::escape(
                                            $parentTitle
                                        ) ?>
                                    </span>

                                <?php endif; ?>

                            </td>


                            <!-- Status -->

                            <td>

                                <?php if (
                                    $status === 'published'
                                ): ?>

                                    <span
                                        class="
                                            admin-pages__status
                                            admin-pages__status--published
                                        "
                                    >
                                        منتشر شده
                                    </span>

                                <?php elseif (
                                    $status === 'private'
                                ): ?>

                                    <span
                                        class="
                                            admin-pages__status
                                            admin-pages__status--private
                                        "
                                    >
                                        خصوصی
                                    </span>

                                <?php else: ?>

                                    <span
                                        class="
                                            admin-pages__status
                                            admin-pages__status--draft
                                        "
                                    >
                                        پیش‌نویس
                                    </span>

                                <?php endif; ?>

                            </td>


                            <!-- Published At -->

                            <td>

                                <?php if (
                                    !empty(
                                        $page['published_at']
                                        ?? null
                                    )
                                ): ?>

                                    <span
                                        class="admin-pages__date"
                                    >
                                        <?= View::escape(
                                            $publishedAt
                                        ) ?>
                                    </span>

                                <?php else: ?>

                                    <span
                                        class="
                                            admin-pages__date
                                            admin-pages__date--empty
                                        "
                                    >
                                        بدون تاریخ انتشار
                                    </span>

                                <?php endif; ?>

                            </td>


                            <!-- Updated At -->

                            <td>

                                <span
                                    class="admin-pages__date"
                                >
                                    <?= View::escape(
                                        $updatedAt
                                    ) ?>
                                </span>

                            </td>


                            <!-- Slug -->

                            <td>

                                <span
                                    class="admin-pages__slug"
                                >
                                    /pages/<?= View::escape(
                                        $slug
                                    ) ?>
                                </span>

                            </td>


                            <!-- Actions -->

                            <td>

                                <div class="admin-pages__actions">


                                    <?php if (
                                        $status === 'published'
                                        && $slug !== ''
                                    ): ?>

                                        <a
                                            href="<?= View::url(
                                                '/pages/'
                                                . rawurlencode(
                                                    $slug
                                                )
                                            ) ?>"
                                            class="
                                                admin-pages__action
                                                admin-pages__action--view
                                            "
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >
                                            مشاهده
                                        </a>

                                    <?php endif; ?>


                                    <a
                                        href="<?= View::url(
                                            '/admin/pages/'
                                            . $id
                                            . '/edit'
                                        ) ?>"
                                        class="
                                            admin-pages__action
                                            admin-pages__action--edit
                                        "
                                    >
                                        ویرایش
                                    </a>


                                    <form
                                        method="POST"
                                        action="<?= View::url(
                                            '/admin/pages/'
                                            . $id
                                            . '/delete'
                                        ) ?>"
                                        onsubmit="return confirm('آیا از حذف این صفحه مطمئن هستید؟');"
                                    >

                                        <?= Csrf::field() ?>

                                        <button
                                            type="submit"
                                            class="
                                                admin-pages__action
                                                admin-pages__action--delete
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


            <?php if (
                $totalPages > 1
            ): ?>

                <nav
                    class="admin-pages__pagination"
                    aria-label="صفحه‌بندی صفحات"
                >

                    <?php if (
                        $pageNumber > 1
                    ): ?>

                        <a
                            href="?page=<?= $pageNumber - 1 ?>"
                        >
                            قبلی
                        </a>

                    <?php endif; ?>


                    <span>
                        صفحه
                        <?= $pageNumber ?>
                        از
                        <?= $totalPages ?>
                    </span>


                    <?php if (
                        $pageNumber < $totalPages
                    ): ?>

                        <a
                            href="?page=<?= $pageNumber + 1 ?>"
                        >
                            بعدی
                        </a>

                    <?php endif; ?>

                </nav>

            <?php endif; ?>

        <?php endif; ?>

    </section>

</div>
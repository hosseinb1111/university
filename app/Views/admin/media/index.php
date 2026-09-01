<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\Storage;
use App\Core\View;


/*
|--------------------------------------------------------------------------
| Media data
|--------------------------------------------------------------------------
*/

$items =
    is_array(
        $media['items'] ?? null
    )
        ? $media['items']
        : [];


$currentPage =
    max(
        1,
        (int) (
            $media['page']
            ?? 1
        )
    );


$totalPages =
    max(
        1,
        (int) (
            $media['totalPages']
            ?? 1
        )
    );


$total =
    (int) (
        $media['total']
        ?? 0
    );


/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

$formatFileSize =
    static function (
        mixed $bytes
    ): string {

        $bytes =
            max(
                0,
                (int) $bytes
            );


        if (
            $bytes === 0
        ) {
            return '۰ بایت';
        }


        $units = [
            'بایت',
            'کیلوبایت',
            'مگابایت',
            'گیگابایت',
        ];


        $size =
            (float) $bytes;


        $unitIndex =
            0;


        while (
            $size >= 1024
            && $unitIndex < count($units) - 1
        ) {

            $size /=
                1024;

            $unitIndex++;
        }


        if (
            $unitIndex === 0
        ) {

            $display =
                number_format(
                    $size,
                    0
                );

        } elseif (
            $size < 10
        ) {

            $display =
                number_format(
                    $size,
                    1
                );

        } else {

            $display =
                number_format(
                    $size,
                    0
                );
        }


        return
            $display
            . ' '
            . $units[$unitIndex];
    };


$formatDate =
    static function (
        mixed $date
    ): string {

        if (
            !is_string($date)
            || trim($date) === ''
        ) {
            return '—';
        }


        /*
         * The database normally stores Gregorian
         * DATETIME values. Use the existing Jalali
         * formatter when available.
         */
        if (
            function_exists(
                'jalali_date_fa'
            )
        ) {

            return
                jalali_date_fa(
                    $date,
                    'j F Y، H:i'
                );
        }


        return
            $date;
    };


$getFileType =
    static function (
        string $mime
    ): string {

        if (
            str_starts_with(
                $mime,
                'image/'
            )
        ) {
            return 'تصویر';
        }


        if (
            $mime === 'application/pdf'
        ) {
            return 'PDF';
        }


        if (
            str_starts_with(
                $mime,
                'video/'
            )
        ) {
            return 'ویدئو';
        }


        if (
            str_starts_with(
                $mime,
                'audio/'
            )
        ) {
            return 'صوت';
        }


        if (
            str_contains(
                $mime,
                'word'
            )
            || str_contains(
                $mime,
                'document'
            )
        ) {
            return 'سند';
        }


        if (
            str_contains(
                $mime,
                'excel'
            )
            || str_contains(
                $mime,
                'spreadsheet'
            )
        ) {
            return 'Excel';
        }


        return 'فایل';
    };

?>

<div class="admin-page media-library-page">

    <!-- =========================================================
         HEADER
    ========================================================== -->

    <header class="admin-page__header media-library-page__header">

        <div>

            <span class="admin-page__eyebrow">
                فایل‌ها و رسانه‌ها
            </span>


            <h1>
                کتابخانه رسانه
            </h1>


            <p>
                تصاویر و فایل‌های ذخیره‌شده سایت را
                مدیریت، مشاهده یا حذف کنید.
            </p>

        </div>


        <div class="media-library-page__header-actions">

            <span class="media-library-page__total">

                <strong>
                    <?= number_format(
                        $total
                    ) ?>
                </strong>

                فایل

            </span>


            <a
                href="<?= View::url(
                    '/admin/media/create'
                ) ?>"
                class="button button--primary"
            >
                <span aria-hidden="true">
                    +
                </span>

                آپلود رسانه

            </a>

        </div>

    </header>


    <!-- =========================================================
         ALERTS
    ========================================================== -->

    <?php if (
        is_string($success)
        && $success !== ''
    ): ?>

        <div
            class="admin-alert admin-alert--success media-library-page__alert"
            role="status"
        >

            <span
                class="media-library-page__alert-icon"
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


    <?php if (
        is_string($error)
        && $error !== ''
    ): ?>

        <div
            class="admin-alert admin-alert--error media-library-page__alert"
            role="alert"
        >

            <span
                class="media-library-page__alert-icon"
                aria-hidden="true"
            >
                !
            </span>

            <span>
                <?= View::escape(
                    $error
                ) ?>
            </span>

        </div>

    <?php endif; ?>


    <!-- =========================================================
         LIBRARY PANEL
    ========================================================== -->

    <section class="admin-panel media-library-page__panel">


        <!-- =====================================================
             PANEL HEADER
        ====================================================== -->

        <div class="admin-panel__header media-library-page__panel-header">

            <div>

                <strong>
                    رسانه‌های شما
                </strong>

                <span>
                    <?= number_format(
                        $total
                    ) ?>
                    فایل در کتابخانه
                </span>

            </div>


            <?php if (
                $total > 0
            ): ?>

                <a
                    href="<?= View::url(
                        '/admin/media/create'
                    ) ?>"
                    class="media-library-page__compact-upload"
                >
                    + افزودن فایل
                </a>

            <?php endif; ?>

        </div>


        <!-- =====================================================
             EMPTY STATE
        ====================================================== -->

        <?php if (
            $items === []
        ): ?>

            <div class="media-library-empty">

                <div
                    class="media-library-empty__icon"
                    aria-hidden="true"
                >
                    🖼
                </div>


                <span class="media-library-empty__eyebrow">
                    کتابخانه خالی
                </span>


                <h2>
                    هنوز فایلی در کتابخانه نیست
                </h2>


                <p>
                    تصاویر و فایل‌های مورد نیاز سایت
                    را با انتخاب چند فایل یا
                    Drag & Drop اضافه کنید.
                </p>


                <a
                    href="<?= View::url(
                        '/admin/media/create'
                    ) ?>"
                    class="button button--primary"
                >
                    اولین رسانه را آپلود کنید
                </a>

            </div>

        <?php else: ?>


            <!-- =================================================
                 MEDIA GRID
            ================================================== -->

            <div class="media-grid media-library-page__grid">

                <?php foreach (
                    $items
                    as $item
                ): ?>

                    <?php

                    $id =
                        (int) (
                            $item['id']
                            ?? 0
                        );


                    $mime =
                        (string) (
                            $item['mime_type']
                            ?? ''
                        );


                    $path =
                        (string) (
                            $item['file_path']
                            ?? ''
                        );


                    $url =
                        Storage::publicUrl(
                            $path
                        );


                    $isImage =
                        str_starts_with(
                            $mime,
                            'image/'
                        );


                    $fileType =
                        $getFileType(
                            $mime
                        );


                    $originalName =
                        trim(
                            (string) (
                                $item['original_name']
                                ?? 'file'
                            )
                        );


                    if (
                        $originalName === ''
                    ) {
                        $originalName =
                            'file';
                    }


                    $altText =
                        trim(
                            (string) (
                                $item['alt_text']
                                ?? ''
                            )
                        );


                    $dimensions =
                        '';


                    if (
                        $isImage
                        && !empty(
                            $item['width']
                        )
                        && !empty(
                            $item['height']
                        )
                    ) {

                        $dimensions =
                            (int) $item['width']
                            . ' × '
                            . (int) $item['height'];

                    }


                    $fileSize =
                        $formatFileSize(
                            $item['file_size']
                            ?? 0
                        );


                    $uploadedAt =
                        $formatDate(
                            $item['created_at']
                            ?? null
                        );

                    ?>


                    <article
                        class="
                            media-card
                            media-library-card
                            <?= $isImage
                                ? 'media-library-card--image'
                                : 'media-library-card--file'
                            ?>
                        "
                    >


                        <!-- =====================================
                             PREVIEW
                        ====================================== -->

                        <a
                            href="<?= View::escape(
                                $url
                            ) ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="media-card__preview"
                            aria-label="مشاهده <?= View::escape(
                                $originalName
                            ) ?>"
                        >

                            <?php if (
                                $isImage
                            ): ?>

                                <img
                                    src="<?= View::escape(
                                        $url
                                    ) ?>"
                                    alt="<?= View::escape(
                                        $altText !== ''
                                            ? $altText
                                            : $originalName
                                    ) ?>"
                                    loading="lazy"
                                >

                            <?php else: ?>

                                <div
                                    class="media-card__file"
                                    aria-hidden="true"
                                >

                                    <span>
                                        📄
                                    </span>

                                    <small>
                                        <?= View::escape(
                                            $fileType
                                        ) ?>
                                    </small>

                                </div>

                            <?php endif; ?>


                            <span class="media-card__type-badge">

                                <?= View::escape(
                                    $fileType
                                ) ?>

                            </span>

                        </a>


                        <!-- =====================================
                             BODY
                        ====================================== -->

                        <div class="media-card__body">


                            <div class="media-card__title-row">

                                <strong
                                    title="<?= View::escape(
                                        $originalName
                                    ) ?>"
                                >
                                    <?= View::escape(
                                        $originalName
                                    ) ?>
                                </strong>

                            </div>


                            <!-- Metadata -->

                            <div class="media-card__meta">

                                <?php if (
                                    $dimensions !== ''
                                ): ?>

                                    <span>
                                        <?= View::escape(
                                            $dimensions
                                        ) ?>
                                    </span>

                                    <span
                                        aria-hidden="true"
                                    >
                                        •
                                    </span>

                                <?php endif; ?>


                                <span>
                                    <?= View::escape(
                                        $fileSize
                                    ) ?>
                                </span>

                            </div>


                            <div class="media-card__date">

                                <?= View::escape(
                                    $uploadedAt
                                ) ?>

                            </div>


                            <!-- Actions -->

                            <div class="media-card__actions">

                                <a
                                    href="<?= View::escape(
                                        $url
                                    ) ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="
                                        button
                                        button--secondary
                                        button--small
                                    "
                                >
                                    مشاهده
                                </a>


                                <form
                                    method="POST"
                                    action="<?= View::url(
                                        '/admin/media/'
                                        . $id
                                        . '/delete'
                                    ) ?>"
                                    onsubmit="return confirm('آیا از حذف این فایل مطمئن هستید؟');"
                                >

                                    <?= Csrf::field() ?>


                                    <button
                                        type="submit"
                                        class="
                                            button
                                            button--danger
                                            button--small
                                        "
                                    >
                                        حذف
                                    </button>

                                </form>

                            </div>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>


            <!-- =================================================
                 PAGINATION
            ================================================== -->

            <?php if (
                $totalPages > 1
            ): ?>

                <nav
                    class="admin-pagination media-library-page__pagination"
                    aria-label="صفحه‌بندی رسانه"
                >

                    <?php if (
                        $currentPage > 1
                    ): ?>

                        <a
                            href="?page=<?= $currentPage - 1 ?>"
                            class="admin-pagination__link"
                        >
                            <span aria-hidden="true">
                                →
                            </span>

                            قبلی
                        </a>

                    <?php endif; ?>


                    <span
                        class="admin-pagination__current"
                    >
                        صفحه
                        <?= number_format(
                            $currentPage
                        ) ?>
                        از
                        <?= number_format(
                            $totalPages
                        ) ?>
                    </span>


                    <?php if (
                        $currentPage < $totalPages
                    ): ?>

                        <a
                            href="?page=<?= $currentPage + 1 ?>"
                            class="admin-pagination__link"
                        >
                            بعدی

                            <span aria-hidden="true">
                                ←
                            </span>
                        </a>

                    <?php endif; ?>

                </nav>

            <?php endif; ?>

        <?php endif; ?>

    </section>

</div>
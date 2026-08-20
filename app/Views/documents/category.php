<?php

declare(strict_types=1);

use App\Core\View;

/**
 * =========================================================
 * Sadra University
 * Public Document Category
 * =========================================================
 *
 * Expected variables:
 *
 * @var array<string, mixed> $category
 * @var array<int, array<string, mixed>> $documents
 *
 * =========================================================
 */


/*
|--------------------------------------------------------------------------
| Normalize input
|--------------------------------------------------------------------------
*/

$category =
    is_array($category ?? null)
        ? $category
        : [];

$documents =
    is_array($documents ?? null)
        ? $documents
        : [];


/*
|--------------------------------------------------------------------------
| Category information
|--------------------------------------------------------------------------
*/

$categorySlug =
    trim(
        (string) (
            $category['slug']
            ?? ''
        )
    );

$categoryName =
    trim(
        (string) (
            $category['name']
            ?? 'اسناد'
        )
    );

$categoryDescription =
    trim(
        (string) (
            $category['description']
            ?? ''
        )
    );


/*
|--------------------------------------------------------------------------
| File size formatter
|--------------------------------------------------------------------------
*/

$formatFileSize = static function (
    int $bytes
): string {
    if ($bytes <= 0) {
        return 'نامشخص';
    }

    $units = [
        'B',
        'KB',
        'MB',
        'GB',
    ];

    $size =
        (float) $bytes;

    $unitIndex = 0;

    while (
        $size >= 1024
        && $unitIndex < count($units) - 1
    ) {
        $size /= 1024;

        $unitIndex++;
    }

    return number_format(
        $size,
        $unitIndex === 0
            ? 0
            : 2
    )
    . ' '
    . $units[
        $unitIndex
    ];
};


/*
|--------------------------------------------------------------------------
| Document type label
|--------------------------------------------------------------------------
*/

$getFileTypeLabel = static function (
    string $mime
): string {
    $mime =
        strtolower(
            trim($mime)
        );

    return match (true) {

        $mime === 'application/pdf' =>
            'PDF',

        $mime === 'application/msword',
        $mime ===
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' =>
            'WORD',

        $mime === 'application/vnd.ms-excel',
        $mime ===
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' =>
            'EXCEL',

        $mime === 'application/vnd.ms-powerpoint',
        $mime ===
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' =>
            'POWERPOINT',

        default =>
            'FILE',
    };
};

?>

<section class="institution-page">

    <div class="container">


        <!-- =================================================
             Breadcrumb
        ================================================== -->

        <nav
            class="program-detail__breadcrumb"
            aria-label="مسیر صفحه"
        >

            <a
                href="<?= View::url(
                    '/documents'
                ) ?>"
            >
                اسناد و فرم‌ها
            </a>

            <span
                aria-hidden="true"
            >
                /
            </span>

            <span>
                <?= View::escape(
                    $categoryName
                ) ?>
            </span>

        </nav>


        <!-- =================================================
             Hero
        ================================================== -->

        <header class="institution-hero">

            <span>
                دسته اسناد
            </span>

            <h1>
                <?= View::escape(
                    $categoryName
                ) ?>
            </h1>


            <?php if (
                $categoryDescription !== ''
            ): ?>

                <p>
                    <?= View::escape(
                        $categoryDescription
                    ) ?>
                </p>

            <?php else: ?>

                <p>
                    اسناد و فایل‌های منتشرشده در این دسته‌بندی.
                </p>

            <?php endif; ?>

        </header>


        <!-- =================================================
             Documents
        ================================================== -->

        <?php if (
            $documents === []
        ): ?>

            <div
                class="institution-empty"
            >

                <strong>
                    سندی در این دسته وجود ندارد.
                </strong>

                <p>
                    در حال حاضر فایل منتشرشده‌ای برای نمایش وجود ندارد.
                </p>

            </div>

        <?php else: ?>

            <div
                class="document-list"
            >

                <?php foreach (
                    $documents
                    as $document
                ): ?>

                    <?php
                    $documentId =
                        (int) (
                            $document['id']
                            ?? 0
                        );

                    $title =
                        trim(
                            (string) (
                                $document['title']
                                ?? ''
                            )
                        );

                    if (
                        $title === ''
                    ) {
                        $title =
                            trim(
                                (string) (
                                    $document[
                                        'file_name'
                                    ]
                                    ?? 'سند'
                                )
                            );
                    }

                    if (
                        $title === ''
                    ) {
                        $title =
                            'سند';
                    }

                    $description =
                        trim(
                            (string) (
                                $document[
                                    'description'
                                ]
                                ?? ''
                            )
                        );

                    $mimeType =
                        strtolower(
                            trim(
                                (string) (
                                    $document[
                                        'mime_type'
                                    ]
                                    ?? ''
                                )
                            )
                        );

                    $fileType =
                        $getFileTypeLabel(
                            $mimeType
                        );

                    $fileSize =
                        (int) (
                            $document[
                                'file_size'
                            ]
                            ?? 0
                        );

                    $downloadCount =
                        (int) (
                            $document[
                                'download_count'
                            ]
                            ?? 0
                        );

                    $downloadUrl =
                        View::url(
                            '/documents/'
                            . rawurlencode(
                                $categorySlug
                            )
                            . '/'
                            . $documentId
                        );
                    ?>


                    <article
                        class="document-card"
                    >


                        <!-- =================================
                             File type
                        ================================== -->

                        <div
                            class="document-card__icon"
                            aria-hidden="true"
                        >
                            <?= View::escape(
                                $fileType
                            ) ?>
                        </div>


                        <!-- =================================
                             Information
                        ================================== -->

                        <div
                            class="document-card__body"
                        >

                            <h2>

                                <a
                                    href="<?= View::escape(
                                        $downloadUrl
                                    ) ?>"
                                >
                                    <?= View::escape(
                                        $title
                                    ) ?>
                                </a>

                            </h2>


                            <?php if (
                                $description !== ''
                            ): ?>

                                <p>
                                    <?= View::escape(
                                        $description
                                    ) ?>
                                </p>

                            <?php endif; ?>


                            <div
                                class="document-card__meta"
                            >


                                <?php if (
                                    $fileSize > 0
                                ): ?>

                                    <span>
                                        حجم:
                                        <?= View::escape(
                                            $formatFileSize(
                                                $fileSize
                                            )
                                        ) ?>
                                    </span>

                                <?php endif; ?>


                                <?php if (
                                    $mimeType !== ''
                                ): ?>

                                    <span>
                                        <?= View::escape(
                                            $mimeType
                                        ) ?>
                                    </span>

                                <?php endif; ?>


                                <span>
                                    <?= number_format(
                                        $downloadCount
                                    ) ?>

                                    دانلود
                                </span>

                            </div>

                        </div>


                        <!-- =================================
                             Download
                        ================================== -->

                        <a
                            href="<?= View::escape(
                                $downloadUrl
                            ) ?>"
                            class="button button--secondary"
                        >
                            مشاهده / دانلود
                        </a>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>


        <!-- =================================================
             Bottom actions
        ================================================== -->

        <div
            class="institution-section"
        >

            <div
                class="institution-action-grid"
            >

                <a
                    href="<?= View::url(
                        '/documents'
                    ) ?>"
                    class="institution-action-card"
                >

                    <strong>
                        همه اسناد
                    </strong>

                    <span>
                        بازگشت به فهرست تمام دسته‌های اسناد
                    </span>

                </a>


                <a
                    href="<?= View::url(
                        '/contact'
                    ) ?>"
                    class="institution-action-card"
                >

                    <strong>
                        نیاز به راهنمایی؟
                    </strong>

                    <span>
                        برای دریافت اطلاعات بیشتر با موسسه تماس بگیرید.
                    </span>

                </a>


                <a
                    href="<?= View::url(
                        '/announcements'
                    ) ?>"
                    class="institution-action-card"
                >

                    <strong>
                        اطلاعیه‌ها
                    </strong>

                    <span>
                        آخرین اطلاعیه‌های رسمی موسسه را مشاهده کنید.
                    </span>

                </a>

            </div>

        </div>

    </div>

</section>
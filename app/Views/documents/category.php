<?php

declare(strict_types=1);

use App\Core\View;

/**
 * =========================================================
 * Sadra University
 * Public Document Category
 * =========================================================
 */

$category =
    is_array($category ?? null)
        ? $category
        : [];

$documents =
    is_array($documents ?? null)
        ? $documents
        : [];


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
| File size
|--------------------------------------------------------------------------
*/

$formatFileSize =
    static function (
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

        $unitIndex =
            0;

        while (
            $size >= 1024
            && $unitIndex < count($units) - 1
        ) {
            $size /= 1024;

            $unitIndex++;
        }

        $decimals =
            $unitIndex === 0
                ? 0
                : (
                    $size >= 10
                        ? 1
                        : 2
                );

        return number_format(
            $size,
            $decimals,
            '.',
            ','
        )
        . ' '
        . $units[$unitIndex];
    };


/*
|--------------------------------------------------------------------------
| File metadata
|--------------------------------------------------------------------------
*/

$getFileMeta =
    static function (
        string $mime,
        string $filename
    ): array {

        $mime =
            strtolower(
                trim($mime)
            );

        $extension =
            strtolower(
                (string) pathinfo(
                    $filename,
                    PATHINFO_EXTENSION
                )
            );


        if (
            $mime === 'application/pdf'
            || $extension === 'pdf'
        ) {
            return [
                'label' => 'PDF',
                'class' => 'pdf',
                'description' => 'سند PDF',
            ];
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
            || in_array(
                $extension,
                [
                    'doc',
                    'docx',
                ],
                true
            )
        ) {
            return [
                'label' => '',
                'class' => 'word',
                'description' => 'سند متنی',
            ];
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
            || in_array(
                $extension,
                [
                    'xls',
                    'xlsx',
                    'csv',
                ],
                true
            )
        ) {
            return [
                'label' => 'XLS',
                'class' => 'excel',
                'description' => 'فایل جدولی',
            ];
        }


        if (
            str_contains(
                $mime,
                'powerpoint'
            )
            || str_contains(
                $mime,
                'presentation'
            )
            || in_array(
                $extension,
                [
                    'ppt',
                    'pptx',
                ],
                true
            )
        ) {
            return [
                'label' => 'PPT',
                'class' => 'powerpoint',
                'description' => 'ارائه',
            ];
        }


        if (
            str_contains(
                $mime,
                'image'
            )
            || in_array(
                $extension,
                [
                    'jpg',
                    'jpeg',
                    'png',
                    'webp',
                    'gif',
                ],
                true
            )
        ) {
            return [
                'label' => 'IMG',
                'class' => 'image',
                'description' => 'تصویر',
            ];
        }


        return [
            'label' =>
                $extension !== ''
                    ? strtoupper(
                        substr(
                            $extension,
                            0,
                            4
                        )
                    )
                    : 'FILE',

            'class' => 'file',

            'description' => 'فایل',
        ];
    };

?>

<section class="institution-page documents-category">

    <div class="container">

        <!-- =====================================================
             BREADCRUMB
        ====================================================== -->

        <nav
            class="documents-category__breadcrumb"
            aria-label="مسیر صفحه"
        >

            <a
                href="<?= View::escape(
                    View::url(
                        '/documents'
                    )
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


        <!-- =====================================================
             HERO
        ====================================================== -->

        <header
            class="institution-hero documents-category__hero"
        >

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
                    اسناد و فایل‌های رسمی منتشرشده در این دسته‌بندی.
                </p>

            <?php endif; ?>

        </header>


        <!-- =====================================================
             DOCUMENTS
        ====================================================== -->

        <?php if (
            $documents === []
        ): ?>

            <div
                class="
                    institution-empty
                    documents-category__empty
                "
            >

                <div
                    class="documents-empty-icon"
                    aria-hidden="true"
                >
                    📄
                </div>

                <strong>
                    سندی در این دسته وجود ندارد.
                </strong>

                <p>
                    در حال حاضر فایل منتشرشده‌ای برای نمایش وجود ندارد.
                </p>

                <a
                    href="<?= View::escape(
                        View::url(
                            '/documents'
                        )
                    ) ?>"
                    class="button button--secondary"
                >
                    بازگشت به همه اسناد
                </a>

            </div>

        <?php else: ?>

            <div
                class="documents-category__toolbar"
            >

                <div>

                    <span>
                        کتابخانه اسناد
                    </span>

                    <strong>
                        <?= number_format(
                            count(
                                $documents
                            )
                        ) ?>

                        سند
                    </strong>

                </div>


                <a
                    href="<?= View::escape(
                        View::url(
                            '/documents'
                        )
                    ) ?>"
                    class="documents-category__back"
                >
                    ← همه دسته‌ها
                </a>

            </div>


            <div class="document-list">

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


                    if (
                        $documentId <= 0
                    ) {
                        continue;
                    }


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
                                    $document['file_name']
                                    ?? ''
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
                                $document['description']
                                ?? ''
                            )
                        );


                    $fileName =
                        trim(
                            (string) (
                                $document['file_name']
                                ?? ''
                            )
                        );


                    $mimeType =
                        strtolower(
                            trim(
                                (string) (
                                    $document['mime_type']
                                    ?? ''
                                )
                            )
                        );


                    $fileSize =
                        (int) (
                            $document['file_size']
                            ?? 0
                        );


                    $downloadCount =
                        (int) (
                            $document['download_count']
                            ?? 0
                        );


                    $fileMeta =
                        $getFileMeta(
                            $mimeType,
                            $fileName
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

                        <!-- =====================================
                             FILE
                        ====================================== -->

                        <div
                            class="
                                document-card__file
                                document-card__file--<?= View::escape(
                                    $fileMeta['class']
                                ) ?>
                            "
                            aria-hidden="true"
                        >

                            <div
                                class="document-card__file-icon"
                            >

                                <?php if (
                                    $fileMeta['label'] !== ''
                                ): ?>

                                    <span>
                                        <?= View::escape(
                                            $fileMeta['label']
                                        ) ?>
                                    </span>

                                <?php endif; ?>

                            </div>

                        </div>


                        <!-- =====================================
                             CONTENT
                        ====================================== -->

                        <div
                            class="document-card__body"
                        >

                            <div
                                class="document-card__type"
                            >
                                <?= View::escape(
                                    $fileMeta['description']
                                ) ?>
                            </div>


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

                                        حجم

                                        <strong>
                                            <?= View::escape(
                                                $formatFileSize(
                                                    $fileSize
                                                )
                                            ) ?>
                                        </strong>

                                    </span>

                                <?php endif; ?>


                                <span>

                                    دانلود

                                    <strong>
                                        <?= number_format(
                                            $downloadCount
                                        ) ?>
                                    </strong>

                                </span>

                                <?php if (
                                    $fileName !== ''
                                ): ?>

                                    <span
                                        class="document-card__filename"
                                    >
                                        <?= View::escape(
                                            $fileName
                                        ) ?>
                                    </span>

                                <?php endif; ?>

                            </div>

                        </div>


                        <!-- =====================================
                             ACTION
                        ====================================== -->

                        <div
                            class="document-card__action"
                        >

                            <a
                                href="<?= View::escape(
                                    $downloadUrl
                                ) ?>"
                                class="document-card__download"
                            >

                                <span>
                                    مشاهده و دانلود
                                </span>

                                <span
                                    class="document-card__arrow"
                                    aria-hidden="true"
                                >
                                    →
                                </span>

                            </a>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>


        <!-- =====================================================
             BOTTOM ACTIONS
        ====================================================== -->

        <section class="institution-section documents-category__actions">

            <div class="institution-action-grid">

                <a
                    href="<?= View::escape(
                        View::url(
                            '/documents'
                        )
                    ) ?>"
                    class="institution-action-card"
                >

                    <strong>
                        همه اسناد
                    </strong>

                    <span>
                        بازگشت به فهرست تمام دسته‌های اسناد.
                    </span>

                </a>


                <a
                    href="<?= View::escape(
                        View::url(
                            '/contact'
                        )
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
                    href="<?= View::escape(
                        View::url(
                            '/announcements'
                        )
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

        </section>

    </div>

</section>
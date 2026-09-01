<?php

declare(strict_types=1);

use App\Core\View;

/**
 * =========================================================
 * Sadra University
 * Public Documents Index
 * =========================================================
 */

$categories =
    is_array($categories ?? null)
        ? $categories
        : [];

?>

<section class="institution-page documents-index">

    <div class="container">

        <!-- =====================================================
             HERO
        ====================================================== -->

        <header class="institution-hero documents-index__hero">

            <span>
                منابع و اسناد
            </span>

            <h1>
                اسناد و فرم‌ها
            </h1>

            <p>
                فرم‌ها، آیین‌نامه‌ها، دستورالعمل‌ها و اسناد رسمی
                موسسه آموزش عالی صدرالمتالهین را از این بخش مشاهده کنید.
            </p>

        </header>


        <!-- =====================================================
             CATEGORY LIST
        ====================================================== -->

        <?php if ($categories === []): ?>

            <div class="institution-empty documents-index__empty">

                <div
                    class="documents-index__empty-icon"
                    aria-hidden="true"
                >
                    📄
                </div>

                <strong>
                    دسته‌بندی سندی وجود ندارد.
                </strong>

                <p>
                    در حال حاضر اسنادی برای نمایش آماده نشده‌اند.
                </p>

            </div>

        <?php else: ?>

            <div class="documents-category-grid">

                <?php foreach (
                    $categories
                    as $category
                ): ?>

                    <?php

                    $slug =
                        trim(
                            (string) (
                                $category['slug']
                                ?? ''
                            )
                        );

                    $name =
                        trim(
                            (string) (
                                $category['name']
                                ?? 'اسناد'
                            )
                        );

                    $description =
                        trim(
                            (string) (
                                $category['description']
                                ?? ''
                            )
                        );

                    $documentCount =
                        isset(
                            $category['document_count']
                        )
                            ? (int) $category['document_count']
                            : null;

                    if ($slug === '') {
                        continue;
                    }

                    ?>

                    <a
                        href="<?= View::escape(
                            View::url(
                                '/documents/'
                                . rawurlencode(
                                    $slug
                                )
                            )
                        ) ?>"
                        class="documents-category-card"
                    >

                        <?php if (
                            $documentCount !== null
                        ): ?>

                            <div
                                class="documents-category-card__top"
                            >

                                <span
                                    class="documents-category-card__count"
                                >
                                    <?= number_format(
                                        $documentCount
                                    ) ?>

                                    سند
                                </span>

                            </div>

                        <?php endif; ?>


                        <div
                            class="documents-category-card__body"
                        >

                            <span
                                class="documents-category-card__eyebrow"
                            >
                                دسته اسناد
                            </span>

                            <h2>
                                <?= View::escape(
                                    $name
                                ) ?>
                            </h2>


                            <?php if (
                                $description !== ''
                            ): ?>

                                <p>
                                    <?= View::escape(
                                        $description
                                    ) ?>
                                </p>

                            <?php else: ?>

                                <p>
                                    فایل‌ها و اسناد این بخش را مشاهده کنید.
                                </p>

                            <?php endif; ?>

                        </div>


                        <div
                            class="documents-category-card__footer"
                        >

                            <span>
                                مشاهده اسناد
                            </span>

                            <span
                                class="documents-category-card__arrow"
                                aria-hidden="true"
                            >
                                ←
                            </span>

                        </div>

                    </a>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>


        <!-- =====================================================
             BOTTOM ACTIONS
        ====================================================== -->

        <section class="institution-section documents-index__actions">

            <div class="institution-action-grid">

                <a
                    href="<?= View::escape(
                        View::url(
                            '/contact'
                        )
                    ) ?>"
                    class="institution-action-card"
                >

                    <strong>
                        نیاز به راهنمایی دارید؟
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
                        آخرین اطلاعیه‌ها و اخبار رسمی موسسه.
                    </span>

                </a>

            </div>

        </section>

    </div>

</section>
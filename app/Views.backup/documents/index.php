<?php

declare(strict_types=1);

use App\Core\View;

$categories =
    is_array($categories ?? null)
        ? $categories
        : [];
?>

<section class="institution-page">

    <div class="container">

        <header class="institution-hero">

            <span>
                منابع و اسناد
            </span>

            <h1>
                اسناد و فرم‌ها
            </h1>

            <p>
                فرم‌ها، آیین‌نامه‌ها، دستورالعمل‌ها و
                اسناد رسمی موسسه آموزش عالی صدرالمتالهین.
            </p>

        </header>


        <?php if ($categories === []): ?>

            <div class="institution-empty">

                <strong>
                    دسته‌بندی سندی وجود ندارد.
                </strong>

                <p>
                    اسناد در حال حاضر برای نمایش آماده نشده‌اند.
                </p>

            </div>

        <?php else: ?>

            <div class="institution-content-grid">

                <?php foreach (
                    $categories
                    as $category
                ): ?>

                    <a
                        href="<?= View::url(
                            '/documents/'
                            . rawurlencode(
                                (string) $category['slug']
                            )
                        ) ?>"
                        class="institution-card"
                    >

                        <span
                            class="institution-card__eyebrow"
                        >
                            اسناد
                        </span>

                        <h2>
                            <?= View::escape(
                                (string) $category['name']
                            ) ?>
                        </h2>


                        <?php if (
                            !empty(
                                $category['description']
                            )
                        ): ?>

                            <p>
                                <?= View::escape(
                                    (string) $category['description']
                                ) ?>
                            </p>

                        <?php endif; ?>


                        <span
                            class="institution-card__link"
                        >
                            مشاهده اسناد →
                        </span>

                    </a>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>


        <section class="institution-section">

            <div class="institution-action-grid">

                <a
                    href="<?= View::url(
                        '/contact'
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
                    href="<?= View::url(
                        '/announcements'
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
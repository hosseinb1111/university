<?php

declare(strict_types=1);

use App\Core\View;

$center =
    is_array($center ?? null)
        ? $center
        : [];
?>

<section class="institution-page">

    <div class="container">

        <nav
            class="program-detail__breadcrumb"
            aria-label="مسیر صفحه"
        >

            <a
                href="<?= View::url(
                    '/research-centers'
                ) ?>"
            >
                پژوهشکده‌ها
            </a>

            <span aria-hidden="true">
                /
            </span>

            <span>
                <?= View::escape(
                    (string) (
                        $center['name']
                        ?? 'پژوهشکده'
                    )
                ) ?>
            </span>

        </nav>


        <header class="institution-hero">

            <span>
                پژوهش
            </span>

            <h1>
                <?= View::escape(
                    (string) (
                        $center['name']
                        ?? 'پژوهشکده'
                    )
                ) ?>
            </h1>

        </header>


        <div class="institution-content-grid">

            <?php if (
                !empty($center['description'])
            ): ?>

                <article class="institution-card">

                    <span class="institution-card__eyebrow">
                        معرفی
                    </span>

                    <h2>
                        درباره پژوهشکده
                    </h2>

                    <div class="institution-rich-text">

                        <?= nl2br(
                            View::escape(
                                (string) $center['description']
                            )
                        ) ?>

                    </div>

                </article>

            <?php endif; ?>


            <article class="institution-card">

                <span class="institution-card__eyebrow">
                    اطلاعات تماس
                </span>

                <h2>
                    ارتباط
                </h2>


                <?php if (
                    !empty($center['email'])
                ): ?>

                    <p>
                        ایمیل:
                        <a
                            href="mailto:<?= View::escape(
                                (string) $center['email']
                            ) ?>"
                        >
                            <?= View::escape(
                                (string) $center['email']
                            ) ?>
                        </a>
                    </p>

                <?php endif; ?>


                <?php if (
                    !empty($center['phone'])
                ): ?>

                    <?php
                    $phone =
                        preg_replace(
                            '/[^0-9+]/',
                            '',
                            (string) $center['phone']
                        );
                    ?>

                    <p>
                        تلفن:
                        <a
                            href="tel:<?= View::escape(
                                is_string($phone)
                                    ? $phone
                                    : ''
                            ) ?>"
                        >
                            <?= View::escape(
                                (string) $center['phone']
                            ) ?>
                        </a>
                    </p>

                <?php endif; ?>

            </article>

        </div>


        <div class="institution-section">

            <a
                href="<?= View::url(
                    '/research-centers'
                ) ?>"
                class="button button--secondary"
            >
                بازگشت به پژوهشکده‌ها
            </a>

        </div>

    </div>

</section>
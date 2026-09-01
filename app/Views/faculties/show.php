<?php

declare(strict_types=1);

use App\Core\View;

$faculty =
    is_array($faculty ?? null)
        ? $faculty
        : [];

$programs =
    is_array($programs ?? null)
        ? $programs
        : [];

$people =
    is_array($people ?? null)
        ? $people
        : [];

$facultyName =
    (string) (
        $faculty['name']
        ?? 'دانشکده'
    );

$facultySlug =
    (string) (
        $faculty['slug']
        ?? ''
    );
?>

<section class="institution-page">

    <div class="container">

        <nav
            class="program-detail__breadcrumb"
            aria-label="مسیر صفحه"
        >

            <a
                href="<?= View::url('/faculties') ?>"
            >
                دانشکده‌ها
            </a>

            <span aria-hidden="true">
                /
            </span>

            <span>
                <?= View::escape($facultyName) ?>
            </span>

        </nav>


        <header class="institution-hero">

            <span>
                دانشکده
            </span>

            <h1>
                <?= View::escape(
                    $facultyName
                ) ?>
            </h1>


            <?php if (
                !empty($faculty['short_name'])
            ): ?>

                <p>
                    <?= View::escape(
                        (string) $faculty['short_name']
                    ) ?>
                </p>

            <?php endif; ?>

        </header>


        <?php if (
            !empty($faculty['description'])
        ): ?>

            <article class="institution-card">

                <h2>
                    معرفی
                </h2>

                <div class="institution-rich-text">

                    <?= nl2br(
                        View::escape(
                            (string) $faculty['description']
                        )
                    ) ?>

                </div>

            </article>

        <?php endif; ?>


        <section class="institution-section">

            <div class="institution-section__heading">

                <div>

                    <span>
                        آموزش
                    </span>

                    <h2>
                        رشته‌های این دانشکده
                    </h2>

                </div>


                <a
                    href="<?= View::url(
                        '/programs'
                    ) ?>"
                    class="button button--secondary"
                >
                    همه رشته‌ها
                </a>

            </div>


            <?php if ($programs === []): ?>

                <div class="institution-empty">
                    رشته‌ای برای نمایش وجود ندارد.
                </div>

            <?php else: ?>

                <div class="program-grid">

                    <?php foreach ($programs as $program): ?>

                        <a
                            href="<?= View::url(
                                '/programs/'
                                . rawurlencode(
                                    (string) $program['slug']
                                )
                            ) ?>"
                            class="program-card"
                        >

                            <h3>
                                <?= View::escape(
                                    (string) $program['name']
                                ) ?>
                            </h3>


                            <?php if (
                                !empty($program['degree'])
                            ): ?>

                                <div>

                                    <span>
                                        <?= View::escape(
                                            (string) $program['degree']
                                        ) ?>
                                    </span>

                                </div>

                            <?php endif; ?>


                            <?php if (
                                !empty($program['field'])
                            ): ?>

                                <p>
                                    <?= View::escape(
                                        (string) $program['field']
                                    ) ?>
                                </p>

                            <?php endif; ?>


                            <span class="program-card__arrow">
                                مشاهده
                            </span>

                        </a>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </section>


        <section class="institution-section">

            <div class="institution-section__heading">

                <div>

                    <span>
                        اعضا
                    </span>

                    <h2>
                        اعضای این دانشکده
                    </h2>

                </div>

            </div>


            <?php if ($people === []): ?>

                <div class="institution-empty">
                    عضوی برای نمایش وجود ندارد.
                </div>

            <?php else: ?>

                <div class="people-grid">

                    <?php foreach ($people as $person): ?>

                        <?php
                        $personId =
                            (int) (
                                $person['id']
                                ?? 0
                            );

                        $name =
                            trim(
                                (string) (
                                    $person['first_name']
                                    ?? ''
                                )
                                . ' '
                                . (string) (
                                    $person['last_name']
                                    ?? ''
                                )
                            );
                        ?>

                        <a
                            href="<?= View::url(
                                '/people/'
                                . $personId
                            ) ?>"
                            class="person-card"
                        >

                            <div class="person-card__image">

                                <?php if (
                                    !empty($person['image'])
                                ): ?>

                                    <img
    src="<?= View::url(
        '/'
        . ltrim(
            (string) $person['image'],
            '/'
        )
    ) ?>"
    alt="<?= View::escape(
        $name
    ) ?>"
    loading="lazy"
>
                                <?php else: ?>

                                    <span>
                                        <?= View::escape(
                                            mb_substr(
                                                $name ?: 'ع',
                                                0,
                                                1,
                                                'UTF-8'
                                            )
                                        ) ?>
                                    </span>

                                <?php endif; ?>

                            </div>


                            <div class="person-card__body">

                                <strong>
                                    <?= View::escape(
                                        $name ?: 'عضو موسسه'
                                    ) ?>
                                </strong>


                                <?php if (
                                    !empty($person['position'])
                                ): ?>

                                    <span>
                                        <?= View::escape(
                                            (string) $person['position']
                                        ) ?>
                                    </span>

                                <?php endif; ?>

                            </div>

                        </a>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </section>


        <div class="institution-section">

            <a
                href="<?= View::url(
                    '/faculties'
                ) ?>"
                class="button button--secondary"
            >
                بازگشت به دانشکده‌ها
            </a>

        </div>

    </div>

</section>
<?php

declare(strict_types=1);

use App\Core\View;

$faculties =
    is_array($faculties ?? null)
        ? $faculties
        : [];
?>

<section class="institution-page">

    <div class="container">

        <header class="institution-hero">

            <span>
                آموزش
            </span>

            <h1>
                دانشکده‌ها
            </h1>

            <p>
                معرفی دانشکده‌ها و گروه‌های آموزشی موسسه.
            </p>

        </header>


        <?php if ($faculties === []): ?>

            <div class="institution-empty">

                <strong>
                    دانشکده‌ای برای نمایش وجود ندارد.
                </strong>

                <p>
                    اطلاعات دانشکده‌ها هنوز ثبت نشده است.
                </p>

            </div>

        <?php else: ?>

            <div class="faculty-grid">

                <?php foreach ($faculties as $faculty): ?>

                    <article class="faculty-card">

                        <a
                            href="<?= View::url(
                                '/faculties/'
                                . rawurlencode(
                                    (string) $faculty['slug']
                                )
                            ) ?>"
                            class="faculty-card__image"
                        >

                            <?php if (
                                !empty($faculty['image'])
                            ): ?>

                                <img
                                    src="<?= View::escape(
                                        (string) $faculty['image']
                                    ) ?>"
                                    alt="<?= View::escape(
                                        (string) $faculty['name']
                                    ) ?>"
                                    loading="lazy"
                                >

                            <?php else: ?>

                                <span aria-hidden="true">
                                    🎓
                                </span>

                            <?php endif; ?>

                        </a>


                        <div class="faculty-card__body">

                            <h2>

                                <a
                                    href="<?= View::url(
                                        '/faculties/'
                                        . rawurlencode(
                                            (string) $faculty['slug']
                                        )
                                    ) ?>"
                                >
                                    <?= View::escape(
                                        (string) $faculty['name']
                                    ) ?>
                                </a>

                            </h2>


                            <?php if (
                                !empty($faculty['short_name'])
                            ): ?>

                                <span>
                                    <?= View::escape(
                                        (string) $faculty['short_name']
                                    ) ?>
                                </span>

                            <?php endif; ?>


                            <?php if (
                                !empty($faculty['description'])
                            ): ?>

                                <p>
                                    <?= View::escape(
                                        mb_strimwidth(
                                            (string) $faculty['description'],
                                            0,
                                            180,
                                            '...',
                                            'UTF-8'
                                        )
                                    ) ?>
                                </p>

                            <?php endif; ?>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>
<?php

declare(strict_types=1);

use App\Core\View;

$researchCenters =
    is_array($researchCenters ?? null)
        ? $researchCenters
        : [];
?>

<section class="institution-page">

    <div class="container">

        <header class="institution-hero">

            <span>
                پژوهش
            </span>

            <h1>
                پژوهشکده‌ها
            </h1>

            <p>
                معرفی پژوهشکده‌ها و مراکز پژوهشی موسسه.
            </p>

        </header>


        <?php if ($researchCenters === []): ?>

            <div class="institution-empty">

                <strong>
                    پژوهشکده‌ای برای نمایش وجود ندارد.
                </strong>

                <p>
                    اطلاعات مراکز پژوهشی هنوز ثبت نشده است.
                </p>

            </div>

        <?php else: ?>

            <div class="research-center-grid">

                <?php foreach (
                    $researchCenters as $center
                ): ?>

                    <a
                        href="<?= View::url(
                            '/research-centers/'
                            . rawurlencode(
                                (string) $center['slug']
                            )
                        ) ?>"
                        class="research-center-card"
                    >

                        <div class="research-center-card__icon">
                            🔬
                        </div>


                        <div>

                            <h2>
                                <?= View::escape(
                                    (string) $center['name']
                                ) ?>
                            </h2>


                            <?php if (
                                !empty($center['description'])
                            ): ?>

                                <p>
                                    <?= View::escape(
                                        mb_strimwidth(
                                            (string) $center['description'],
                                            0,
                                            220,
                                            '...',
                                            'UTF-8'
                                        )
                                    ) ?>
                                </p>

                            <?php endif; ?>


                            <span>
                                مشاهده پژوهشکده
                            </span>

                        </div>

                    </a>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>
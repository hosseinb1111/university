<?php

declare(strict_types=1);
?>

<section class="english-page">

    <div class="english-container">

        <div class="english-page__hero">

            <span>
                Research
            </span>

            <h1>
                Research Centers
            </h1>

            <p>
                Research centers and scientific activities at Sadra Institute.
            </p>

        </div>


        <?php if (
            empty($researchCenters)
        ): ?>

            <div class="english-empty">
                Research center information is not currently available.
            </div>

        <?php else: ?>

            <div class="english-card-grid">

                <?php foreach (
                    $researchCenters
                    as $center
                ): ?>

                    <article class="english-card">

                        <h2>
                            <?= View::escape(
                                $center['name']
                            ) ?>
                        </h2>


                        <?php if (
                            !empty(
                                $center['short_name']
                            )
                        ): ?>

                            <p>
                                <?= View::escape(
                                    $center['short_name']
                                ) ?>
                            </p>

                        <?php endif; ?>


                        <?php if (
                            !empty(
                                $center['description']
                            )
                        ): ?>

                            <p>
                                <?= View::escape(
                                    mb_strimwidth(
                                        $center[
                                            'description'
                                        ],
                                        0,
                                        240,
                                        '...',
                                        'UTF-8'
                                    )
                                ) ?>
                            </p>

                        <?php endif; ?>


                        <a
                            href="<?= View::url(
                                '/research-centers/'
                                . rawurlencode(
                                    $center['slug']
                                )
                            ) ?>"
                            class="english-button english-button--secondary"
                        >
                            View Center
                        </a>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>
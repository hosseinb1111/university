<?php

declare(strict_types=1);
?>

<section class="english-page">

    <div class="english-container">

        <div class="english-page__hero">

            <span>
                Academics
            </span>

            <h1>
                Faculties
            </h1>

            <p>
                Explore the academic faculties and educational structure of Sadra Institute.
            </p>

        </div>


        <?php if (
            empty($faculties)
        ): ?>

            <div class="english-empty">
                Faculty information is not currently available.
            </div>

        <?php else: ?>

            <div class="english-card-grid">

                <?php foreach (
                    $faculties
                    as $faculty
                ): ?>

                    <article class="english-card">

                        <h2>
                            <?= View::escape(
                                $faculty['name']
                            ) ?>
                        </h2>


                        <?php if (
                            !empty(
                                $faculty['short_name']
                            )
                        ): ?>

                            <p>
                                <?= View::escape(
                                    $faculty['short_name']
                                ) ?>
                            </p>

                        <?php endif; ?>


                        <?php if (
                            !empty(
                                $faculty['description']
                            )
                        ): ?>

                            <p>
                                <?= View::escape(
                                    mb_strimwidth(
                                        $faculty[
                                            'description'
                                        ],
                                        0,
                                        220,
                                        '...',
                                        'UTF-8'
                                    )
                                ) ?>
                            </p>

                        <?php endif; ?>


                        <a
                            href="<?= View::url(
                                '/faculties/'
                                . rawurlencode(
                                    $faculty['slug']
                                )
                            ) ?>"
                            class="english-button english-button--secondary"
                        >
                            View Faculty
                        </a>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>
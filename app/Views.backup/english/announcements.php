<?php
declare(strict_types=1);

use App\Core\View;
?>

<section class="english-page">

    <div class="english-container">

        <div class="english-page__hero">

            <span>
                News
            </span>

            <h1>
                Announcements
            </h1>

            <p>
                The latest official announcements from Sadra Institute.
            </p>

        </div>


        <?php if (
            empty($announcements)
        ): ?>

            <div class="english-empty">
                No announcements are currently available.
            </div>

        <?php else: ?>

            <div class="english-list">

                <?php foreach (
                    $announcements
                    as $announcement
                ): ?>

                    <article class="english-list__item">

                        <span>
                            <?php if (
                                !empty(
                                    $announcement[
                                        'published_at'
                                    ]
                                )
                            ): ?>

                                <?= View::escape(
                                    date(
                                        'Y-m-d',
                                        strtotime(
                                            $announcement[
                                                'published_at'
                                            ]
                                        )
                                    )
                                ) ?>

                            <?php endif; ?>
                        </span>


                        <h2>
                            <?= View::escape(
                                $announcement['title']
                            ) ?>
                        </h2>


                        <?php if (
                            !empty(
                                $announcement['excerpt']
                            )
                        ): ?>

                            <p>
                                <?= View::escape(
                                    $announcement['excerpt']
                                ) ?>
                            </p>

                        <?php endif; ?>


                        <a
                            href="<?= View::url(
                                '/announcements/'
                                . rawurlencode(
                                    $announcement['slug']
                                )
                            ) ?>"
                        >
                            Read announcement
                        </a>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>

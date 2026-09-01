<?php
declare(strict_types=1);

use App\Core\View;
?>

<section class="english-hero">

    <div class="english-container">

        <div class="english-hero__content">

            <span class="english-eyebrow">
                Sadra Institute of Higher Education
            </span>

            <h1>
                Education, Research and Academic Development
            </h1>

            <p>
                Welcome to the official English website of Sadra Institute of Higher Education in Tehran.
            </p>

            <div class="english-actions">

                <a
                    href="<?= View::url(
                        '/english/faculties'
                    ) ?>"
                    class="english-button english-button--primary"
                >
                    Explore Faculties
                </a>

                <a
                    href="<?= View::url(
                        '/english/about'
                    ) ?>"
                    class="english-button english-button--secondary"
                >
                    About the Institute
                </a>

            </div>

        </div>

    </div>

</section>


<section class="english-section">

    <div class="english-container">

        <div class="english-section__heading">

            <div>
                <span>
                    Latest
                </span>

                <h2>
                    Announcements
                </h2>
            </div>

            <a
                href="<?= View::url(
                    '/english/announcements'
                ) ?>"
            >
                View all
            </a>

        </div>


        <?php if (
            empty($announcements)
        ): ?>

            <div class="english-empty">
                No announcements are currently available.
            </div>

        <?php else: ?>

            <div class="english-card-grid">

                <?php foreach (
                    $announcements
                    as $announcement
                ): ?>

                    <article class="english-card">

                        <span class="english-card__meta">
                            <?php if (
                                !empty(
                                    $announcement['published_at']
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

                            <?php else: ?>

                                Latest

                            <?php endif; ?>
                        </span>

                        <h3>
                            <?= View::escape(
                                $announcement['title']
                            ) ?>
                        </h3>

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

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>


<section class="english-section english-section--muted">

    <div class="english-container">

        <div class="english-section__heading">

            <div>
                <span>
                    Academics
                </span>

                <h2>
                    Faculties
                </h2>
            </div>

            <a
                href="<?= View::url(
                    '/english/faculties'
                ) ?>"
            >
                View all
            </a>

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

                    <a
                        href="<?= View::url(
                            '/faculties/'
                            . rawurlencode(
                                $faculty['slug']
                            )
                        ) ?>"
                        class="english-card english-card--link"
                    >

                        <h3>
                            <?= View::escape(
                                $faculty['name']
                            ) ?>
                        </h3>

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

                    </a>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>


<section class="english-section">

    <div class="english-container">

        <div class="english-section__heading">

            <div>
                <span>
                    Research
                </span>

                <h2>
                    Research Centers
                </h2>
            </div>

            <a
                href="<?= View::url(
                    '/english/research'
                ) ?>"
            >
                View all
            </a>

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

                    <a
                        href="<?= View::url(
                            '/research-centers/'
                            . rawurlencode(
                                $center['slug']
                            )
                        ) ?>"
                        class="english-card english-card--link"
                    >

                        <h3>
                            <?= View::escape(
                                $center['name']
                            ) ?>
                        </h3>

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

                    </a>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>

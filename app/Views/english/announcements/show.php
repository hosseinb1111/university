<?php

declare(strict_types=1);

use App\Core\View;


/*
|--------------------------------------------------------------------------
| Normalize announcement
|--------------------------------------------------------------------------
*/

$announcement =
    is_array(
        $announcement ?? null
    )
        ? $announcement
        : [];


/*
|--------------------------------------------------------------------------
| Values
|--------------------------------------------------------------------------
*/

$title =
    trim(
        (string) (
            $announcement['title']
            ?? 'Announcement'
        )
    );


if (
    $title === ''
) {
    $title =
        'Announcement';
}


$excerpt =
    trim(
        (string) (
            $announcement['excerpt']
            ?? ''
        )
    );


$content =
    trim(
        (string) (
            $announcement['content']
            ?? ''
        )
    );


$publishedAt =
    trim(
        (string) (
            $announcement['published_at']
            ?? ''
        )
    );


$image =
    trim(
        (string) (
            $announcement['image']
            ?? ''
        )
    );


$formatDate =
    static function (
        string $value
    ): string {
        if (
            $value === ''
        ) {
            return '';
        }

        $timestamp =
            strtotime(
                $value
            );

        if (
            $timestamp === false
        ) {
            return '';
        }

        return date(
            'F d, Y',
            $timestamp
        );
    };


$formattedDate =
    $formatDate(
        $publishedAt
    );

?>

<section class="english-announcement-page">


    <!-- =====================================================
         ARTICLE HERO
    ====================================================== -->

    <header class="english-announcement-hero">

        <div class="english-container">

            <a
                href="<?= View::url(
                    '/english/announcements'
                ) ?>"
                class="english-announcement-back"
            >
                <span>
                    ←
                </span>

                Back to announcements
            </a>


            <div class="english-announcement-hero__meta">

                <span>
                    OFFICIAL ANNOUNCEMENT
                </span>


                <?php if (
                    $formattedDate !== ''
                ): ?>

                    <time
                        datetime="<?= View::escape(
                            $publishedAt
                        ) ?>"
                    >
                        <?= View::escape(
                            $formattedDate
                        ) ?>
                    </time>

                <?php endif; ?>

            </div>


            <h1>
                <?= View::escape(
                    $title
                ) ?>
            </h1>


            <?php if (
                $excerpt !== ''
            ): ?>

                <p>
                    <?= View::escape(
                        $excerpt
                    ) ?>
                </p>

            <?php endif; ?>

        </div>

    </header>


    <!-- =====================================================
         ARTICLE
    ====================================================== -->

    <main class="english-announcement-content">

        <div class="english-container">

            <div class="english-announcement-layout">


                <!-- =================================================
                     Main article
                ================================================== -->

                <article
                    class="english-announcement-article"
                >

                    <?php if (
                        $image !== ''
                    ): ?>

                        <figure
                            class="english-announcement-image"
                        >

                            <img
                                src="<?= View::escape(
                                    $image
                                ) ?>"
                                alt="<?= View::escape(
                                    $title
                                ) ?>"
                            >

                        </figure>

                    <?php endif; ?>


                    <?php if (
                        $content !== ''
                    ): ?>

                        <div
                            class="
                                english-announcement-article__body
                            "
                        >

                            <?= nl2br(
                                View::escape(
                                    $content
                                )
                            ) ?>

                        </div>

                    <?php elseif (
                        $excerpt !== ''
                    ): ?>

                        <div
                            class="
                                english-announcement-article__body
                            "
                        >

                            <?= nl2br(
                                View::escape(
                                    $excerpt
                                )
                            ) ?>

                        </div>

                    <?php else: ?>

                        <div
                            class="
                                english-announcement-article__empty
                            "
                        >
                            No additional information is available
                            for this announcement.
                        </div>

                    <?php endif; ?>

                </article>


                <!-- =================================================
                     Sidebar
                ================================================== -->

                <aside
                    class="english-announcement-sidebar"
                >

                    <div
                        class="
                            english-announcement-sidebar__card
                        "
                    >

                        <span>
                            ANNOUNCEMENT
                        </span>

                        <strong>
                            <?= View::escape(
                                $title
                            ) ?>
                        </strong>


                        <?php if (
                            $formattedDate !== ''
                        ): ?>

                            <div
                                class="
                                    english-announcement-sidebar__date
                                "
                            >

                                <small>
                                    Published
                                </small>

                                <time>
                                    <?= View::escape(
                                        $formattedDate
                                    ) ?>
                                </time>

                            </div>

                        <?php endif; ?>

                    </div>


                    <a
                        href="<?= View::url(
                            '/english/announcements'
                        ) ?>"
                        class="
                            english-button
                            english-button--secondary
                        "
                    >
                        ← All announcements
                    </a>

                </aside>

            </div>

        </div>

    </main>


    <!-- =====================================================
         FOOTER CTA
    ====================================================== -->

    <section class="english-announcement-cta">

        <div class="english-container">

            <div
                class="english-announcement-cta__inner"
            >

                <div>

                    <span>
                        STAY INFORMED
                    </span>

                    <h2>
                        Keep up with Sadra.
                    </h2>

                    <p>
                        Browse the latest announcements and
                        institutional updates.
                    </p>

                </div>


                <a
                    href="<?= View::url(
                        '/english/announcements'
                    ) ?>"
                    class="english-button english-button--primary"
                >
                    View all announcements
                </a>

            </div>

        </div>

    </section>

</section>
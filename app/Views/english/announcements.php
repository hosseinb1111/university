<?php

declare(strict_types=1);

use App\Core\View;


/*
|--------------------------------------------------------------------------
| Normalize data
|--------------------------------------------------------------------------
*/

$announcements =
    is_array($announcements ?? null)
        ? $announcements
        : [];


/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

$shorten =
    static function (
        mixed $value,
        int $width
    ): string {
        if (
            !is_string($value)
            || trim($value) === ''
        ) {
            return '';
        }

        return mb_strimwidth(
            trim($value),
            0,
            $width,
            '...',
            'UTF-8'
        );
    };


$formatDate =
    static function (
        mixed $value
    ): array {
        if (
            !is_string($value)
            || trim($value) === ''
        ) {
            return [
                'day' => '',
                'month' => '',
                'year' => '',
                'full' => '',
            ];
        }

        $timestamp =
            strtotime(
                $value
            );

        if (
            $timestamp === false
        ) {
            return [
                'day' => '',
                'month' => '',
                'year' => '',
                'full' => '',
            ];
        }

        return [
            'day' =>
                date(
                    'd',
                    $timestamp
                ),

            'month' =>
                date(
                    'M',
                    $timestamp
                ),

            'year' =>
                date(
                    'Y',
                    $timestamp
                ),

            'full' =>
                date(
                    'F d, Y',
                    $timestamp
                ),
        ];
    };

?>


<section class="english-announcements-page">


    <!-- =====================================================
         HERO
    ====================================================== -->

    <header class="english-announcements-hero">

        <div class="english-container">

            <div class="english-announcements-hero__content">

                <span>
                    NEWS & UPDATES
                </span>

                <h1>
                    Announcements
                </h1>

                <p>
                    Official news, notices, updates, and
                    institutional announcements from Sadra
                    Institute of Higher Education.
                </p>

            </div>


            <?php if (
                $announcements !== []
            ): ?>

                <div
                    class="english-announcements-hero__count"
                    aria-label="Number of announcements"
                >

                    <strong>
                        <?= count(
                            $announcements
                        ) ?>
                    </strong>

                    <span>
                        <?= count(
                            $announcements
                        ) === 1
                            ? 'Announcement'
                            : 'Announcements'
                        ?>
                    </span>

                </div>

            <?php endif; ?>

        </div>

    </header>


    <!-- =====================================================
         ANNOUNCEMENTS
    ====================================================== -->

    <section class="english-announcements-section">

        <div class="english-container">


            <?php if (
                $announcements === []
            ): ?>

                <div
                    class="
                        english-empty
                        english-announcements-empty
                    "
                >

                    <div
                        class="english-announcements-empty__icon"
                        aria-hidden="true"
                    >
                        —
                    </div>

                    <h2>
                        No announcements are currently available.
                    </h2>

                    <p>
                        Please check back later for the latest
                        news and institutional updates.
                    </p>

                </div>

            <?php else: ?>

                <?php
                $featuredAnnouncement =
                    $announcements[0]
                    ?? null;

                $remainingAnnouncements =
                    array_slice(
                        $announcements,
                        1
                    );
                ?>


                <!-- =================================================
                     Featured announcement
                ================================================== -->

                <?php if (
                    is_array(
                        $featuredAnnouncement
                    )
                ): ?>

                    <?php
                    $featuredSlug =
                        trim(
                            (string) (
                                $featuredAnnouncement[
                                    'slug'
                                ]
                                ?? ''
                            )
                        );

                    $featuredTitle =
                        trim(
                            (string) (
                                $featuredAnnouncement[
                                    'title'
                                ]
                                ?? ''
                            )
                        );

                    $featuredExcerpt =
                        $shorten(
                            $featuredAnnouncement[
                                'excerpt'
                            ]
                            ?? '',
                            340
                        );

                    $featuredDate =
                        $formatDate(
                            $featuredAnnouncement[
                                'published_at'
                            ]
                            ?? null
                        );
                    ?>


                    <?php if (
                        $featuredTitle !== ''
                    ): ?>

                        <article
                            class="english-announcement-featured"
                        >

                            <div
                                class="english-announcement-featured__content"
                            >

                                <span
                                    class="english-announcement-featured__label"
                                >
                                    FEATURED ANNOUNCEMENT
                                </span>


                                <?php if (
                                    $featuredDate['full'] !== ''
                                ): ?>

                                    <time
                                        datetime="<?= View::escape(
                                            (string) (
                                                $featuredAnnouncement[
                                                    'published_at'
                                                ]
                                                ?? ''
                                            )
                                        ) ?>"
                                    >
                                        <?= View::escape(
                                            $featuredDate['full']
                                        ) ?>
                                    </time>

                                <?php endif; ?>


                                <h2>
                                    <?= View::escape(
                                        $featuredTitle
                                    ) ?>
                                </h2>


                                <?php if (
                                    $featuredExcerpt !== ''
                                ): ?>

                                    <p>
                                        <?= View::escape(
                                            $featuredExcerpt
                                        ) ?>
                                    </p>

                                <?php endif; ?>


                                <?php if (
                                    $featuredSlug !== ''
                                ): ?>

                                    <a
                                        href="<?= View::url(
                                            '/english/announcements/'
                                            . rawurlencode(
                                                $featuredSlug
                                            )
                                        ) ?>"
                                        class="english-button english-button--primary"
                                    >
                                        Read announcement
                                    </a>

                                <?php endif; ?>

                            </div>


                            <div
                                class="
                                    english-announcement-featured__date
                                "
                                aria-hidden="true"
                            >

                                <?php if (
                                    $featuredDate['day'] !== ''
                                ): ?>

                                    <strong>
                                        <?= View::escape(
                                            $featuredDate['day']
                                        ) ?>
                                    </strong>

                                    <span>
                                        <?= View::escape(
                                            strtoupper(
                                                $featuredDate['month']
                                            )
                                        ) ?>
                                    </span>

                                    <small>
                                        <?= View::escape(
                                            $featuredDate['year']
                                        ) ?>
                                    </small>

                                <?php else: ?>

                                    <strong>
                                        —
                                    </strong>

                                <?php endif; ?>

                            </div>

                        </article>

                    <?php endif; ?>

                <?php endif; ?>


                <!-- =================================================
                     Remaining announcements
                ================================================== -->

                <?php if (
                    $remainingAnnouncements !== []
                ): ?>

                    <div
                        class="
                            english-announcements-heading
                        "
                    >

                        <div>

                            <span>
                                LATEST
                            </span>

                            <h2>
                                More announcements
                            </h2>

                        </div>

                    </div>


                    <div class="english-announcements-grid">

                        <?php foreach (
                            $remainingAnnouncements
                            as $index => $announcement
                        ): ?>

                            <?php
                            if (
                                !is_array(
                                    $announcement
                                )
                            ) {
                                continue;
                            }

                            $slug =
                                trim(
                                    (string) (
                                        $announcement['slug']
                                        ?? ''
                                    )
                                );

                            $title =
                                trim(
                                    (string) (
                                        $announcement['title']
                                        ?? ''
                                    )
                                );

                            $excerpt =
                                $shorten(
                                    $announcement['excerpt']
                                    ?? '',
                                    170
                                );

                            $date =
                                $formatDate(
                                    $announcement[
                                        'published_at'
                                    ]
                                    ?? null
                                );
                            ?>


                            <?php if (
                                $title === ''
                            ): ?>

                                <?php continue; ?>

                            <?php endif; ?>


                            <article
                                class="english-announcement-card"
                            >

                                <div
                                    class="english-announcement-card__top"
                                >

                                    <div
                                        class="english-announcement-card__date"
                                    >

                                        <?php if (
                                            $date['day'] !== ''
                                        ): ?>

                                            <strong>
                                                <?= View::escape(
                                                    $date['day']
                                                ) ?>
                                            </strong>

                                            <span>
                                                <?= View::escape(
                                                    strtoupper(
                                                        $date['month']
                                                    )
                                                ) ?>
                                            </span>

                                        <?php else: ?>

                                            <strong>
                                                —
                                            </strong>

                                        <?php endif; ?>

                                    </div>


                                    <span
                                        class="english-announcement-card__index"
                                    >
                                        <?= str_pad(
                                            (string) (
                                                $index + 2
                                            ),
                                            2,
                                            '0',
                                            STR_PAD_LEFT
                                        ) ?>
                                    </span>

                                </div>


                                <div
                                    class="english-announcement-card__body"
                                >

                                    <?php if (
                                        $date['full'] !== ''
                                    ): ?>

                                        <time>
                                            <?= View::escape(
                                                $date['full']
                                            ) ?>
                                        </time>

                                    <?php endif; ?>


                                    <h3>
                                        <?= View::escape(
                                            $title
                                        ) ?>
                                    </h3>


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


                                <?php if (
                                    $slug !== ''
                                ): ?>

                                    <a
                                        href="<?= View::url(
                                            '/english/announcements/'
                                            . rawurlencode(
                                                $slug
                                            )
                                        ) ?>"
                                        class="
                                            english-announcement-card__link
                                        "
                                    >

                                        <span>
                                            Read announcement
                                        </span>

                                        <strong>
                                            →
                                        </strong>

                                    </a>

                                <?php endif; ?>

                            </article>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>

            <?php endif; ?>

        </div>

    </section>


    <!-- =====================================================
         INFORMATION CTA
    ====================================================== -->

    <section class="english-announcements-cta">

        <div class="english-container">

            <div
                class="
                    english-announcements-cta__inner
                "
            >

                <div>

                    <span>
                        STAY INFORMED
                    </span>

                    <h2>
                        Keep up with Sadra.
                    </h2>

                    <p>
                        Stay informed about institutional news,
                        academic updates, and important notices.
                    </p>

                </div>


                <a
                    href="<?= View::url(
                        '/english/contact'
                    ) ?>"
                    class="english-button english-button--primary"
                >
                    Contact the Institute
                </a>

            </div>

        </div>

    </section>

</section>
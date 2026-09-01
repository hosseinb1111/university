<?php

declare(strict_types=1);

use App\Core\View;


/*
|--------------------------------------------------------------------------
| Announcements
|--------------------------------------------------------------------------
*/

$announcements =
    is_array(
        $announcements ?? null
    )
        ? $announcements
        : [];


/*
|--------------------------------------------------------------------------
| Format date
|--------------------------------------------------------------------------
*/

$formatDate =
    static function (
        mixed $value
    ): string {

        if (
            !is_string($value)
            || trim($value) === ''
        ) {
            return '';
        }


        if (
            function_exists(
                'jalali_date'
            )
        ) {

            $jalali =
                jalali_date(
                    $value,
                    'Y/m/d'
                );


            if (
                is_string($jalali)
                && trim($jalali) !== ''
            ) {
                return $jalali;
            }
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
            'Y/m/d',
            $timestamp
        );
    };


/*
|--------------------------------------------------------------------------
| Total announcements
|--------------------------------------------------------------------------
*/

$announcementCount =
    count(
        $announcements
    );

?>

<section class="announcements-page">

    <div class="container">


        <!-- =========================================================
             HERO
        ========================================================== -->

        <header
            class="announcements-page__hero"
        >

            <span
                class="announcements-page__eyebrow"
            >
                اطلاعیه‌ها
            </span>


            <h1>
                آخرین اطلاعیه‌ها
            </h1>


            <p>
                آخرین اخبار، اطلاعیه‌ها و اطلاعات رسمی
                موسسه آموزش عالی صدرالمتالهین را در این بخش دنبال کنید.
            </p>

        </header>


        <!-- =========================================================
             TOOLBAR
        ========================================================== -->

        <div
            class="announcements-page__toolbar"
        >

            <div
                class="announcements-page__count"
            >

                <?php if (
                    $announcementCount > 0
                ): ?>

                    <strong>
                        <?= number_format(
                            $announcementCount,
                            0,
                            '٫',
                            '٬'
                        ) ?>
                    </strong>

                    اطلاعیه قابل نمایش

                <?php else: ?>

                    اطلاعیه‌ای برای نمایش وجود ندارد.

                <?php endif; ?>

            </div>


            <a
                href="<?= View::url(
                    '/'
                ) ?>"
                class="button button--secondary"
            >
                بازگشت به صفحه اصلی
            </a>

        </div>


        <!-- =========================================================
             EMPTY STATE
        ========================================================== -->

        <?php if (
            $announcements === []
        ): ?>

            <div
                class="announcement-empty"
            >

                <div
                    class="announcement-empty__icon"
                    aria-hidden="true"
                >
                    📢
                </div>


                <h2>
                    اطلاعیه‌ای وجود ندارد
                </h2>


                <p>
                    در حال حاضر اطلاعیه‌ای برای نمایش وجود ندارد.
                </p>


                <a
                    href="<?= View::url(
                        '/'
                    ) ?>"
                    class="button button--secondary"
                >
                    بازگشت به صفحه اصلی
                </a>

            </div>


        <?php else: ?>


            <!-- =====================================================
                 ANNOUNCEMENT GRID
            ====================================================== -->

            <div
                class="announcement-grid"
            >

                <?php foreach (
                    $announcements as $announcement
                ): ?>

                    <?php

                    /*
                     * Basic values.
                     */

                    $id =
                        (int) (
                            $announcement['id']
                            ?? 0
                        );


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


                    $featuredImage =
                        trim(
                            (string) (
                                $announcement['featured_image']
                                ?? ''
                            )
                        );


                    $publishedAt =
                        $announcement['published_at']
                        ?? null;


                    $expiresAt =
                        $announcement['expires_at']
                        ?? null;


                    /*
                     * Detail URL.
                     */

                    $detailUrl =
                        $slug !== ''
                            ? View::url(
                                '/announcements/'
                                . rawurlencode(
                                    $slug
                                )
                            )
                            : null;


                    /*
                     * Published timestamp.
                     */

                    $publishedTimestamp =
                        false;


                    if (
                        is_string(
                            $publishedAt
                        )
                        && trim(
                            $publishedAt
                        ) !== ''
                    ) {

                        $publishedTimestamp =
                            strtotime(
                                $publishedAt
                            );
                    }


                    /*
                     * Expiry timestamp.
                     */

                    $expiresTimestamp =
                        false;


                    if (
                        is_string(
                            $expiresAt
                        )
                        && trim(
                            $expiresAt
                        ) !== ''
                    ) {

                        $expiresTimestamp =
                            strtotime(
                                $expiresAt
                            );
                    }


                    /*
                     * Build a useful summary.
                     *
                     * Prefer excerpt. If no excerpt exists,
                     * use the announcement content as a plain-text
                     * fallback, trimmed to a reasonable length.
                     */

                    $summary =
                        $excerpt;


                    if (
                        $summary === ''
                        && $content !== ''
                    ) {

                        $summary =
                            trim(
                                strip_tags(
                                    $content
                                )
                            );
                    }


                    if (
                        $summary !== ''
                    ) {

                        $summary =
                            mb_strimwidth(
                                $summary,
                                0,
                                260,
                                '...',
                                'UTF-8'
                            );
                    }

                    ?>


                    <article
                        class="announcement-card"
                        data-announcement-id="<?= $id ?>"
                    >


                        <!-- =========================================
                             IMAGE
                        ========================================== -->

                        <?php if (
                            $featuredImage !== ''
                        ): ?>

                            <?php if (
                                $detailUrl !== null
                            ): ?>

                                <a
                                    href="<?= View::escape(
                                        $detailUrl
                                    ) ?>"
                                    class="announcement-card__image"
                                    aria-label="<?= View::escape(
                                        $title
                                    ) ?>"
                                >

                                    <img
                                        src="<?= View::escape(
                                            $featuredImage
                                        ) ?>"
                                        alt="<?= View::escape(
                                            $title
                                        ) ?>"
                                        loading="lazy"
                                    >

                                </a>

                            <?php else: ?>

                                <div
                                    class="announcement-card__image"
                                >

                                    <img
                                        src="<?= View::escape(
                                            $featuredImage
                                        ) ?>"
                                        alt="<?= View::escape(
                                            $title
                                        ) ?>"
                                        loading="lazy"
                                    >

                                </div>

                            <?php endif; ?>

                        <?php endif; ?>


                        <!-- =========================================
                             BODY
                        ========================================== -->

                        <div
                            class="announcement-card__body"
                        >


                            <!-- =====================================
                                 DATE
                            ====================================== -->

                            <?php if (
                                $publishedTimestamp !== false
                            ): ?>

                                <div
                                    class="announcement-card__meta"
                                >

                                    <time
                                        class="announcement-card__date"
                                        datetime="<?= View::escape(
                                            (string) $publishedAt
                                        ) ?>"
                                    >
                                        <?= View::escape(
                                            $formatDate(
                                                $publishedAt
                                            )
                                        ) ?>
                                    </time>

                                </div>

                            <?php endif; ?>


                            <!-- =====================================
                                 TITLE
                            ====================================== -->

                            <h2
                                class="announcement-card__title"
                            >

                                <?php if (
                                    $detailUrl !== null
                                ): ?>

                                    <a
                                        href="<?= View::escape(
                                            $detailUrl
                                        ) ?>"
                                    >
                                        <?= View::escape(
                                            $title
                                        ) ?>
                                    </a>

                                <?php else: ?>

                                    <?= View::escape(
                                        $title
                                    ) ?>

                                <?php endif; ?>

                            </h2>


                            <!-- =====================================
                                 SUMMARY
                            ====================================== -->

                            <?php if (
                                $summary !== ''
                            ): ?>

                                <p
                                    class="announcement-card__excerpt"
                                >
                                    <?= View::escape(
                                        $summary
                                    ) ?>
                                </p>

                            <?php endif; ?>


                            <!-- =====================================
                                 COUNTDOWN
                            ====================================== -->

                            <?php if (
                                $expiresTimestamp !== false
                            ): ?>

                                <div
                                    class="announcement-card__countdown"
                                    data-countdown
                                    data-countdown-target="<?= (int) (
                                        $expiresTimestamp * 1000
                                    ) ?>"
                                >

                                    <span
                                        class="announcement-card__countdown-label"
                                    >
                                        زمان باقی‌مانده تا پایان نمایش
                                    </span>


                                    <strong
                                        class="announcement-card__countdown-value"
                                        data-countdown-value
                                    >
                                        در حال محاسبه...
                                    </strong>

                                </div>

                            <?php endif; ?>


                            <!-- =====================================
                                 FOOTER
                            ====================================== -->

                            <?php if (
                                $detailUrl !== null
                            ): ?>

                                <div
                                    class="announcement-card__footer"
                                >

                                    <a
                                        href="<?= View::escape(
                                            $detailUrl
                                        ) ?>"
                                        class="announcement-card__link"
                                    >

                                        <span>
                                            ادامه مطلب
                                        </span>


                                        <span
                                            class="announcement-card__arrow"
                                            aria-hidden="true"
                                        >
                                            ←
                                        </span>

                                    </a>

                                </div>

                            <?php endif; ?>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>
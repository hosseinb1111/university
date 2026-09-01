<?php

declare(strict_types=1);

use App\Core\View;

$announcement =
    is_array(
        $announcement ?? null
    )
        ? $announcement
        : [];


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
                    'Y/m/d H:i'
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
            'Y/m/d H:i',
            $timestamp
        );
    };


/*
|--------------------------------------------------------------------------
| Expiration timestamp
|--------------------------------------------------------------------------
*/

$expiresTimestamp =
    false;


if (
    is_string($expiresAt)
    && trim($expiresAt) !== ''
) {

    $expiresTimestamp =
        strtotime(
            $expiresAt
        );
}

?>

<section class="announcement-detail">

    <div class="announcement-detail__container">


        <!-- =========================================================
             BACK LINK
        ========================================================== -->

        <a
            href="<?= View::url(
                '/announcements'
            ) ?>"
            class="announcement-detail__back"
        >

            <span
                aria-hidden="true"
            >
                →
            </span>

            <span>
                بازگشت به اطلاعیه‌ها
            </span>

        </a>


        <!-- =========================================================
             ARTICLE
        ========================================================== -->

        <article
            class="announcement-detail__article"
        >


            <!-- =====================================================
                 FEATURED IMAGE
            ====================================================== -->

            <?php if (
                $featuredImage !== ''
            ): ?>

                <img
                    src="<?= View::escape(
                        $featuredImage
                    ) ?>"
                    alt="<?= View::escape(
                        $title
                    ) ?>"
                    class="announcement-detail__image"
                >

            <?php endif; ?>


            <!-- =====================================================
                 HEADER
            ====================================================== -->

            <header
                class="announcement-detail__header"
            >

                <?php if (
                    $publishedAt !== null
                    && trim(
                        (string) $publishedAt
                    ) !== ''
                ): ?>

                    <div
                        class="announcement-detail__meta"
                    >

                        <time
                            class="announcement-detail__date"
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


                <h1
                    class="announcement-detail__title"
                >
                    <?= View::escape(
                        $title
                    ) ?>
                </h1>


                <?php if (
                    $excerpt !== ''
                ): ?>

                    <p
                        class="announcement-detail__excerpt"
                    >
                        <?= View::escape(
                            $excerpt
                        ) ?>
                    </p>

                <?php endif; ?>

            </header>


            <!-- =====================================================
                 EXPIRATION COUNTDOWN
            ====================================================== -->

            <?php if (
                $expiresTimestamp !== false
            ): ?>

                <div
                    class="announcement-detail__countdown"
                    data-countdown
                    data-countdown-target="<?= (int) (
                        $expiresTimestamp * 1000
                    ) ?>"
                >

                    <span
                        class="announcement-detail__countdown-label"
                    >
                        زمان باقی‌مانده تا پایان نمایش
                    </span>


                    <strong
                        class="announcement-detail__countdown-value"
                        data-countdown-value
                    >
                        در حال محاسبه...
                    </strong>

                </div>

            <?php endif; ?>


            <!-- =====================================================
                 CONTENT
            ====================================================== -->

            <div
                class="announcement-detail__content"
            >

                <?php

                /*
                 * Keep announcement content as plain text.
                 *
                 * Newlines become line breaks visually,
                 * while HTML entered by an administrator
                 * remains escaped.
                 */

                $safeContent =
                    View::escape(
                        $content
                    );

                ?>

                <?= nl2br(
                    $safeContent
                ) ?>

            </div>

        </article>


        <!-- =========================================================
             BOTTOM NAVIGATION
        ========================================================== -->

        <div
            class="announcement-detail__bottom"
        >

            <a
                href="<?= View::url(
                    '/announcements'
                ) ?>"
                class="button button--secondary"
            >
                ← همه اطلاعیه‌ها
            </a>


            <a
                href="<?= View::url(
                    '/'
                ) ?>"
                class="button button--primary"
            >
                صفحه اصلی
            </a>

        </div>

    </div>

</section>
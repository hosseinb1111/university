<?php

declare(strict_types=1);

use App\Core\View;


/*
|--------------------------------------------------------------------------
| Published date
|--------------------------------------------------------------------------
|
| Database stores Gregorian DATETIME.
| Public page displays Jalali/Persian date.
|
| Do NOT use strtotime() here.
| Pass the original database value directly to jalali_date_fa().
|
*/

$publishedAt =
    '';

if (
    !empty(
        $page['published_at']
        ?? null
    )
) {
    $publishedAt =
        jalali_date_fa(
            (string) $page['published_at'],
            'Y/m/d H:i'
        );
}

?>

<section class="public-page">

    <div class="container">

        <article class="public-page__article">


            <?php if (
                !empty(
                    $page['parent_title']
                    ?? ''
                )
            ): ?>

                <div
                    style="
                        margin-bottom:10px;
                        color:#94a3b8;
                        font-size:13px;
                    "
                >

                    <?= View::escape(
                        $page['parent_title']
                    ) ?>

                </div>

            <?php endif; ?>


            <h1>

                <?= View::escape(
                    $page['title']
                    ?? ''
                ) ?>

            </h1>


            <?php if (
                $publishedAt !== ''
            ): ?>

                <div
                    class="public-page__meta"
                    aria-label="تاریخ انتشار"
                >

                    <span
                        class="public-page__meta-label"
                    >
                        تاریخ انتشار:
                    </span>

                    <time
                        class="public-page__date"
                        datetime="<?= View::escape(
                            (string) (
                                $page['published_at']
                                ?? ''
                            )
                        ) ?>"
                    >
                        <?= View::escape(
                            $publishedAt
                        ) ?>
                    </time>

                </div>

            <?php endif; ?>


            <?php if (
                !empty(
                    $page['featured_image']
                    ?? ''
                )
            ): ?>

                <img
                    src="<?= View::escape(
                        $page['featured_image']
                    ) ?>"
                    alt="<?= View::escape(
                        $page['title']
                        ?? ''
                    ) ?>"
                    class="public-page__image"
                >

            <?php endif; ?>


            <?php if (
                !empty(
                    $page['excerpt']
                    ?? ''
                )
            ): ?>

                <p
                    class="public-page__excerpt"
                >

                    <?= View::escape(
                        $page['excerpt']
                    ) ?>

                </p>

            <?php endif; ?>


            <div class="public-page__content">

                <?= nl2br(
                    View::escape(
                        $page['content']
                        ?? ''
                    )
                ) ?>

            </div>


        </article>

    </div>

</section>
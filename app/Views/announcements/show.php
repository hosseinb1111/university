<?php

declare(strict_types=1);
?>

<section class="public-announcement">

    <div class="container">

        <article class="public-announcement__article">

            <div class="public-announcement__meta">

                <?php if (
                    !empty(
                        $announcement['published_at']
                    )
                ): ?>

                    <?= View::escape(
                        $announcement['published_at']
                    ) ?>

                <?php endif; ?>

            </div>


            <h1>
                <?= View::escape(
                    $announcement['title']
                ) ?>
            </h1>


            <?php if (
                !empty(
                    $announcement['featured_image']
                )
            ): ?>

                <img
                    src="<?= View::escape(
                        $announcement['featured_image']
                    ) ?>"
                    alt="<?= View::escape(
                        $announcement['title']
                    ) ?>"
                    class="public-announcement__image"
                >

            <?php endif; ?>


            <?php if (
                !empty(
                    $announcement['excerpt']
                )
            ): ?>

                <p
                    class="public-announcement__excerpt"
                >
                    <?= View::escape(
                        $announcement['excerpt']
                    ) ?>
                </p>

            <?php endif; ?>


            <div class="public-announcement__content">

                <?php
                /*
                 * For now this remains escaped plain text.
                 *
                 * Once we add a controlled rich-text editor,
                 * HTML sanitization will be implemented before
                 * allowing formatted HTML.
                 */
                ?>

                <?= nl2br(
                    View::escape(
                        $announcement['content']
                    )
                ) ?>

            </div>


            <div
                style="
                    margin-top:40px;
                "
            >

                <a
                    href="<?= View::route(
                        'announcements.index'
                    ) ?>"
                    class="button button--secondary"
                >
                    بازگشت به اطلاعیه‌ها
                </a>

            </div>

        </article>

    </div>

</section>
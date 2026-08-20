<?php

declare(strict_types=1);
?>

<section class="public-page">

    <div class="container">

        <article class="public-page__article">

            <?php if (
                !empty(
                    $page['parent_title']
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
                ) ?>
            </h1>


            <?php if (
                !empty(
                    $page['featured_image']
                )
            ): ?>

                <img
                    src="<?= View::escape(
                        $page['featured_image']
                    ) ?>"
                    alt="<?= View::escape(
                        $page['title']
                    ) ?>"
                    class="public-page__image"
                >

            <?php endif; ?>


            <?php if (
                !empty(
                    $page['excerpt']
                )
            ): ?>

                <p class="public-page__excerpt">
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
<?php

declare(strict_types=1);

?>

<section class="public-page announcements-page">

    <div class="container">

        <div class="public-page__article">

            <header class="section-heading">

                <span class="section-heading__eyebrow">
                    اطلاعیه‌ها
                </span>

                <h1 class="section-heading__title">
                    آخرین اطلاعیه‌های موسسه
                </h1>

            </header>


            <?php if (empty($announcements)): ?>

                <div class="empty-state">

                    <h2>
                        اطلاعیه‌ای وجود ندارد
                    </h2>

                    <p>
                        در حال حاضر اطلاعیه‌ای برای نمایش ثبت نشده است.
                    </p>

                </div>


            <?php else: ?>


                <div class="announcement-grid">


                    <?php foreach ($announcements as $announcement): ?>


                        <article class="announcement-card">


                            <h2 class="announcement-card__title">


                                <a href="/announcements/<?= htmlspecialchars(
                                    (string) $announcement['slug'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>">


                                    <?= htmlspecialchars(
                                        (string) $announcement['title'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>


                                </a>


                            </h2>



                            <?php if (!empty($announcement['excerpt'])): ?>

                                <p class="announcement-card__excerpt">

                                    <?= htmlspecialchars(
                                        (string) $announcement['excerpt'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>

                                </p>

                            <?php endif; ?>



                            <?php if (!empty($announcement['published_at'])): ?>

                                <time class="announcement-card__date">

                                    <?= htmlspecialchars(
                                        (string) $announcement['published_at'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>

                                </time>

                            <?php endif; ?>


                        </article>


                    <?php endforeach; ?>


                </div>


            <?php endif; ?>


        </div>


    </div>


</section>
<?php

declare(strict_types=1);

$facultyCount =
    count(
        is_array($faculties)
            ? $faculties
            : []
    );

$programCount =
    count(
        is_array($programs)
            ? $programs
            : []
    );

$researchCount =
    count(
        is_array($researchCenters)
            ? $researchCenters
            : []
    );
?>

<section class="institution-page">

    <div class="container">

        <header class="institution-hero">

            <span>
                آموزش و پژوهش
            </span>

            <h1>
                آموزشی و پژوهشی
            </h1>

            <p>
                ساختار آموزشی، دانشکده‌ها، رشته‌ها و بخش‌های پژوهشی موسسه.
            </p>

        </header>


        <div class="institution-stat-grid">

            <div class="institution-stat">

                <strong>
                    <?= number_format(
                        $facultyCount
                    ) ?>
                </strong>

                <span>
                    دانشکده / گروه
                </span>

            </div>


            <div class="institution-stat">

                <strong>
                    <?= number_format(
                        $programCount
                    ) ?>
                </strong>

                <span>
                    برنامه آموزشی
                </span>

            </div>


            <div class="institution-stat">

                <strong>
                    <?= number_format(
                        $researchCount
                    ) ?>
                </strong>

                <span>
                    پژوهشکده
                </span>

            </div>

        </div>


        <section class="institution-section">

            <div class="institution-section__heading">

                <div>

                    <span>
                        آموزش
                    </span>

                    <h2>
                        بخش‌های آموزشی
                    </h2>

                </div>

            </div>


            <div class="institution-content-grid">

                <article class="institution-card">

                    <span class="institution-card__eyebrow">
                        دانشکده‌ها
                    </span>

                    <h2>
                        دانشکده‌ها
                    </h2>

                    <p>
                        مشاهده دانشکده‌ها و ساختار آموزشی هر بخش.
                    </p>

                    <a
                        href="<?= View::url(
                            '/faculties'
                        ) ?>"
                        class="button button--secondary"
                    >
                        مشاهده دانشکده‌ها
                    </a>

                </article>


                <article class="institution-card">

                    <span class="institution-card__eyebrow">
                        رشته‌ها
                    </span>

                    <h2>
                        برنامه‌های آموزشی
                    </h2>

                    <p>
                        مشاهده رشته‌ها، مقاطع و اطلاعات برنامه‌های آموزشی.
                    </p>

                    <a
                        href="<?= View::url(
                            '/programs'
                        ) ?>"
                        class="button button--secondary"
                    >
                        مشاهده رشته‌ها
                    </a>

                </article>

            </div>

        </section>


        <section class="institution-section">

            <div class="institution-section__heading">

                <div>

                    <span>
                        پژوهش
                    </span>

                    <h2>
                        فعالیت‌های پژوهشی
                    </h2>

                </div>


                <a
                    href="<?= View::url(
                        '/research-centers'
                    ) ?>"
                    class="button button--secondary"
                >
                    همه پژوهشکده‌ها
                </a>

            </div>


            <?php if (
                empty($researchCenters)
            ): ?>

                <div class="institution-empty">

                    اطلاعات پژوهشکده‌ها هنوز ثبت نشده است.

                </div>

            <?php else: ?>

                <div class="institution-content-grid">

                    <?php foreach (
                        array_slice(
                            $researchCenters,
                            0,
                            4
                        )
                        as $center
                    ): ?>

                        <article class="institution-card">

                            <h2>
                                <?= View::escape(
                                    $center['name']
                                ) ?>
                            </h2>


                            <?php if (
                                !empty(
                                    $center['description']
                                )
                            ): ?>

                                <p>
                                    <?= View::escape(
                                        mb_strimwidth(
                                            $center[
                                                'description'
                                            ],
                                            0,
                                            180,
                                            '...',
                                            'UTF-8'
                                        )
                                    ) ?>
                                </p>

                            <?php endif; ?>


                            <a
                                href="<?= View::url(
                                    '/research-centers/'
                                    . rawurlencode(
                                        $center['slug']
                                    )
                                ) ?>"
                                class="button button--secondary"
                            >
                                مشاهده
                            </a>

                        </article>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </section>


        <section class="institution-section">

            <div class="institution-action-grid">

                <a
                    href="<?= View::url(
                        '/documents'
                    ) ?>"
                    class="institution-action-card"
                >

                    <strong>
                        اسناد آموزشی
                    </strong>

                    <span>
                        فرم‌ها، آیین‌نامه‌ها و تقویم آموزشی
                    </span>

                </a>


                <a
                    href="<?= View::url(
                        '/people'
                    ) ?>"
                    class="institution-action-card"
                >

                    <strong>
                        اعضای هیئت علمی
                    </strong>

                    <span>
                        مشاهده اعضای علمی و مدیریتی
                    </span>

                </a>

            </div>

        </section>

    </div>

</section>
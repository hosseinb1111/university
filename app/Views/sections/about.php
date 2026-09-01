<?php

declare(strict_types=1);

use App\Core\View;

$section =
    is_array(
        $section ?? null
    )
        ? $section
        : [];


$eyebrow =
    (string) (
        $section['eyebrow']
        ?? 'معرفی موسسه'
    );

$title =
    (string) (
        $section['title']
        ?? 'موسسه آموزش عالی صدرالمتالهین'
    );

$intro =
    (string) (
        $section['intro']
        ?? ''
    );


$cardEyebrow =
    (string) (
        $section['card_eyebrow']
        ?? 'درباره ما'
    );

$cardTitle =
    (string) (
        $section['card_title']
        ?? 'معرفی موسسه'
    );

$cardText1 =
    (string) (
        $section['card_text_1']
        ?? ''
    );

$cardText2 =
    (string) (
        $section['card_text_2']
        ?? ''
    );


$goalsEyebrow =
    (string) (
        $section['goals_eyebrow']
        ?? 'اهداف'
    );

$goalsTitle =
    (string) (
        $section['goals_title']
        ?? 'اهداف و رویکرد'
    );

$goalsText =
    (string) (
        $section['goals_text']
        ?? ''
    );


$structureEyebrow =
    (string) (
        $section['structure_eyebrow']
        ?? 'ساختار'
    );

$structureTitle =
    (string) (
        $section['structure_title']
        ?? 'ساختار دانشگاهی'
    );

$structureText =
    (string) (
        $section['structure_text']
        ?? ''
    );


$moreEyebrow =
    (string) (
        $section['more_eyebrow']
        ?? 'اطلاعات بیشتر'
    );

$moreTitle =
    (string) (
        $section['more_title']
        ?? 'مسیرهای دسترسی'
    );

?>

<section class="institution-page">

    <div class="container">

        <header class="institution-hero">

            <span>
                <?= View::escape(
                    $eyebrow
                ) ?>
            </span>

            <h1>
                <?= View::escape(
                    $title
                ) ?>
            </h1>

            <p>
                <?= View::escape(
                    $intro
                ) ?>
            </p>

        </header>


        <div class="institution-content-grid">

            <article class="institution-card">

                <span class="institution-card__eyebrow">
                    <?= View::escape(
                        $cardEyebrow
                    ) ?>
                </span>

                <h2>
                    <?= View::escape(
                        $cardTitle
                    ) ?>
                </h2>

                <?php if (
                    $cardText1 !== ''
                ): ?>

                    <p>
                        <?= View::escape(
                            $cardText1
                        ) ?>
                    </p>

                <?php endif; ?>


                <?php if (
                    $cardText2 !== ''
                ): ?>

                    <p>
                        <?= View::escape(
                            $cardText2
                        ) ?>
                    </p>

                <?php endif; ?>

            </article>


            <article class="institution-card">

                <span class="institution-card__eyebrow">
                    <?= View::escape(
                        $goalsEyebrow
                    ) ?>
                </span>

                <h2>
                    <?= View::escape(
                        $goalsTitle
                    ) ?>
                </h2>

                <p>
                    <?= View::escape(
                        $goalsText
                    ) ?>
                </p>

            </article>


            <article class="institution-card">

                <span class="institution-card__eyebrow">
                    <?= View::escape(
                        $structureEyebrow
                    ) ?>
                </span>

                <h2>
                    <?= View::escape(
                        $structureTitle
                    ) ?>
                </h2>

                <p>
                    <?= View::escape(
                        $structureText
                    ) ?>
                </p>

            </article>


            <article class="institution-card">

                <span class="institution-card__eyebrow">
                    <?= View::escape(
                        $moreEyebrow
                    ) ?>
                </span>

                <h2>
                    <?= View::escape(
                        $moreTitle
                    ) ?>
                </h2>

                <div class="institution-link-list">

                    <a
                        href="<?= View::url(
                            '/faculties'
                        ) ?>"
                    >
                        دانشکده‌ها
                    </a>

                    <a
                        href="<?= View::url(
                            '/programs'
                        ) ?>"
                    >
                        رشته‌ها و برنامه‌های آموزشی
                    </a>

                    <a
                        href="<?= View::url(
                            '/research-centers'
                        ) ?>"
                    >
                        پژوهشکده‌ها
                    </a>

                    <a
                        href="<?= View::url(
                            '/people'
                        ) ?>"
                    >
                        اعضای هیئت علمی
                    </a>

                </div>

            </article>

        </div>


        <section class="institution-section">

            <div class="institution-section__heading">

                <div>

                    <span>
                        <?= View::escape(
                            $moreEyebrow
                        ) ?>
                    </span>

                    <h2>
                        <?= View::escape(
                            $moreTitle
                        ) ?>
                    </h2>

                </div>

            </div>


            <div class="institution-action-grid">

                <a
                    href="<?= View::url(
                        '/announcements'
                    ) ?>"
                    class="institution-action-card"
                >

                    <strong>
                        اطلاعیه‌ها
                    </strong>

                    <span>
                        آخرین اخبار و اطلاعیه‌های رسمی
                    </span>

                </a>


                <a
                    href="<?= View::url(
                        '/documents'
                    ) ?>"
                    class="institution-action-card"
                >

                    <strong>
                        اسناد و فرم‌ها
                    </strong>

                    <span>
                        فرم‌ها، آیین‌نامه‌ها و دستورالعمل‌ها
                    </span>

                </a>


                <a
                    href="<?= View::url(
                        '/contact'
                    ) ?>"
                    class="institution-action-card"
                >

                    <strong>
                        تماس با ما
                    </strong>

                    <span>
                        اطلاعات تماس و راه‌های ارتباطی
                    </span>

                </a>

            </div>

        </section>

    </div>

</section>
<?php

declare(strict_types=1);

use App\Core\View;

$query =
    trim(
        (string) (
            $query
            ?? ''
        )
    );

$results =
    is_array(
        $results ?? null
    )
        ? $results
        : [];

$total =
    (int) (
        $total
        ?? 0
    );

$pages =
    is_array(
        $results['pages'] ?? null
    )
        ? $results['pages']
        : [];

$announcements =
    is_array(
        $results['announcements'] ?? null
    )
        ? $results['announcements']
        : [];

$programs =
    is_array(
        $results['programs'] ?? null
    )
        ? $results['programs']
        : [];

$faculties =
    is_array(
        $results['faculties'] ?? null
    )
        ? $results['faculties']
        : [];

$people =
    is_array(
        $results['people'] ?? null
    )
        ? $results['people']
        : [];

$researchCenters =
    is_array(
        $results['researchCenters'] ?? null
    )
        ? $results['researchCenters']
        : [];

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

$excerpt = static function (
    mixed $value,
    int $length = 180
): string {
    $text =
        trim(
            strip_tags(
                (string) $value
            )
        );

    if (
        $text === ''
    ) {
        return '';
    }

    return mb_strimwidth(
        $text,
        0,
        $length,
        '...',
        'UTF-8'
    );
};

$personName = static function (
    array $person
): string {
    $name =
        trim(
            (string) (
                $person['first_name']
                ?? ''
            )
            . ' '
            . (string) (
                $person['last_name']
                ?? ''
            )
        );

    return $name !== ''
        ? $name
        : 'عضو موسسه';
};

?>

<section class="search-page">

    <div class="container">

        <header class="search-page__hero">

            <span class="search-page__eyebrow">
                جستجو
            </span>

            <h1>
                جستجو در سایت
            </h1>

            <p>
                صفحات، اطلاعیه‌ها، رشته‌ها، دانشکده‌ها،
                اعضای موسسه و پژوهشکده‌ها را جستجو کنید.
            </p>

        </header>


        <!-- =================================================
             Search form
        ================================================== -->

        <form
            method="GET"
            action="<?= View::url(
                '/search'
            ) ?>"
            class="search-form"
            role="search"
        >

            <label
                for="search-query"
                class="search-form__label"
            >
                عبارت جستجو
            </label>


            <div class="search-form__row">

                <input
                    id="search-query"
                    name="q"
                    type="search"
                    value="<?= View::escape(
                        $query
                    ) ?>"
                    maxlength="255"
                    placeholder="مثلاً رشته کامپیوتر، اطلاعیه، دانشکده..."
                    autocomplete="off"
                >


                <button
                    type="submit"
                    class="button button--primary"
                >
                    جستجو
                </button>

            </div>

        </form>


        <!-- =================================================
             Empty initial state
        ================================================== -->

        <?php if (
            $query === ''
        ): ?>

            <div class="search-empty">

                <div
                    class="search-empty__icon"
                    aria-hidden="true"
                >
                    🔎
                </div>

                <h2>
                    عبارت مورد نظر خود را جستجو کنید.
                </h2>

                <p>
                    یک عبارت وارد کنید تا نتایج مرتبط
                    در بخش‌های مختلف سایت نمایش داده شود.
                </p>

            </div>


        <?php elseif (
            $total === 0
        ): ?>


            <!-- =================================================
                 No results
            ================================================== -->

            <div class="search-empty">

                <div
                    class="search-empty__icon"
                    aria-hidden="true"
                >
                    🔍
                </div>

                <h2>
                    نتیجه‌ای پیدا نشد.
                </h2>

                <p>
                    برای
                    «<?= View::escape(
                        $query
                    ) ?>»
                    نتیجه‌ای در سایت پیدا نشد.
                </p>

                <span>
                    عبارت دیگری را امتحان کنید.
                </span>

            </div>


        <?php else: ?>


            <!-- =================================================
                 Result summary
            ================================================== -->

            <div class="search-results__summary">

                <strong>
                    <?= number_format(
                        $total
                    ) ?>
                    نتیجه
                </strong>

                <span>
                    برای
                    «<?= View::escape(
                        $query
                    ) ?>»
                </span>

            </div>


            <!-- =================================================
                 Pages
            ================================================== -->

            <?php if (
                $pages !== []
            ): ?>

                <section class="search-results__section">

                    <div class="search-results__heading">

                        <div>

                            <span>
                                محتوا
                            </span>

                            <h2>
                                صفحات سایت
                            </h2>

                        </div>

                    </div>


                    <div class="search-results__list">

                        <?php foreach (
                            $pages
                            as $page
                        ): ?>

                            <?php
                            $pageSlug =
                                trim(
                                    (string) (
                                        $page['slug']
                                        ?? ''
                                    )
                                );

                            $pageTitle =
                                trim(
                                    (string) (
                                        $page['title']
                                        ?? 'صفحه'
                                    )
                                );
                            ?>

                            <?php if (
                                $pageSlug === ''
                            ): ?>

                                <article
                                    class="search-result-card"
                                >

                            <?php else: ?>

                                <a
                                    href="<?= View::url(
                                        '/pages/'
                                        . rawurlencode(
                                            $pageSlug
                                        )
                                    ) ?>"
                                    class="search-result-card"
                                >

                            <?php endif; ?>

                                <div
                                    class="search-result-card__type"
                                >
                                    صفحه
                                </div>

                                <div
                                    class="search-result-card__body"
                                >

                                    <h3>
                                        <?= View::escape(
                                            $pageTitle
                                        ) ?>
                                    </h3>

                                    <?php
                                    $pageExcerpt =
                                        $excerpt(
                                            $page['excerpt']
                                            ?? $page['content']
                                            ?? ''
                                        );
                                    ?>

                                    <?php if (
                                        $pageExcerpt !== ''
                                    ): ?>

                                        <p>
                                            <?= View::escape(
                                                $pageExcerpt
                                            ) ?>
                                        </p>

                                    <?php endif; ?>

                                </div>

                            <?php if (
                                $pageSlug === ''
                            ): ?>

                                </article>

                            <?php else: ?>

                                </a>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    </div>

                </section>

            <?php endif; ?>


            <!-- =================================================
                 Announcements
            ================================================== -->

            <?php if (
                $announcements !== []
            ): ?>

                <section class="search-results__section">

                    <div class="search-results__heading">

                        <div>

                            <span>
                                اخبار
                            </span>

                            <h2>
                                اطلاعیه‌ها
                            </h2>

                        </div>

                    </div>


                    <div class="search-results__list">

                        <?php foreach (
                            $announcements
                            as $announcement
                        ): ?>

                            <?php
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
                                        ?? 'اطلاعیه'
                                    )
                                );
                            ?>

                            <a
                                href="<?= View::url(
                                    '/announcements/'
                                    . rawurlencode(
                                        $slug
                                    )
                                ) ?>"
                                class="search-result-card"
                            >

                                <div
                                    class="search-result-card__type"
                                >
                                    اطلاعیه
                                </div>

                                <div
                                    class="search-result-card__body"
                                >

                                    <h3>
                                        <?= View::escape(
                                            $title
                                        ) ?>
                                    </h3>

                                    <?php
                                    $announcementExcerpt =
                                        $excerpt(
                                            $announcement['excerpt']
                                            ?? $announcement['content']
                                            ?? ''
                                        );
                                    ?>

                                    <?php if (
                                        $announcementExcerpt !== ''
                                    ): ?>

                                        <p>
                                            <?= View::escape(
                                                $announcementExcerpt
                                            ) ?>
                                        </p>

                                    <?php endif; ?>

                                </div>

                            </a>

                        <?php endforeach; ?>

                    </div>

                </section>

            <?php endif; ?>


            <!-- =================================================
                 Programs
            ================================================== -->

            <?php if (
                $programs !== []
            ): ?>

                <section class="search-results__section">

                    <div class="search-results__heading">

                        <div>

                            <span>
                                آموزش
                            </span>

                            <h2>
                                رشته‌ها و برنامه‌ها
                            </h2>

                        </div>

                    </div>


                    <div class="search-results__list">

                        <?php foreach (
                            $programs
                            as $program
                        ): ?>

                            <?php
                            $slug =
                                trim(
                                    (string) (
                                        $program['slug']
                                        ?? ''
                                    )
                                );

                            $name =
                                trim(
                                    (string) (
                                        $program['name']
                                        ?? 'رشته آموزشی'
                                    )
                                );

                            $faculty =
                                trim(
                                    (string) (
                                        $program['faculty_name']
                                        ?? ''
                                    )
                                );

                            $degree =
                                trim(
                                    (string) (
                                        $program['degree']
                                        ?? ''
                                    )
                                );
                            ?>

                            <a
                                href="<?= View::url(
                                    '/programs/'
                                    . rawurlencode(
                                        $slug
                                    )
                                ) ?>"
                                class="search-result-card"
                            >

                                <div
                                    class="search-result-card__type"
                                >
                                    رشته
                                </div>

                                <div
                                    class="search-result-card__body"
                                >

                                    <h3>
                                        <?= View::escape(
                                            $name
                                        ) ?>
                                    </h3>


                                    <?php if (
                                        $faculty !== ''
                                        || $degree !== ''
                                    ): ?>

                                        <p>

                                            <?php if (
                                                $faculty !== ''
                                            ): ?>

                                                <?= View::escape(
                                                    $faculty
                                                ) ?>

                                            <?php endif; ?>


                                            <?php if (
                                                $faculty !== ''
                                                && $degree !== ''
                                            ): ?>

                                                —
                                            <?php endif; ?>


                                            <?php if (
                                                $degree !== ''
                                            ): ?>

                                                <?= View::escape(
                                                    $degree
                                                ) ?>

                                            <?php endif; ?>

                                        </p>

                                    <?php endif; ?>

                                </div>

                            </a>

                        <?php endforeach; ?>

                    </div>

                </section>

            <?php endif; ?>


            <!-- =================================================
                 Faculties
            ================================================== -->

            <?php if (
                $faculties !== []
            ): ?>

                <section class="search-results__section">

                    <div class="search-results__heading">

                        <div>

                            <span>
                                آموزش
                            </span>

                            <h2>
                                دانشکده‌ها
                            </h2>

                        </div>

                    </div>


                    <div class="search-results__list">

                        <?php foreach (
                            $faculties
                            as $faculty
                        ): ?>

                            <?php
                            $slug =
                                trim(
                                    (string) (
                                        $faculty['slug']
                                        ?? ''
                                    )
                                );

                            $name =
                                trim(
                                    (string) (
                                        $faculty['name']
                                        ?? 'دانشکده'
                                    )
                                );

                            $description =
                                $excerpt(
                                    $faculty['description']
                                    ?? ''
                                );
                            ?>

                            <a
                                href="<?= View::url(
                                    '/faculties/'
                                    . rawurlencode(
                                        $slug
                                    )
                                ) ?>"
                                class="search-result-card"
                            >

                                <div
                                    class="search-result-card__type"
                                >
                                    دانشکده
                                </div>

                                <div
                                    class="search-result-card__body"
                                >

                                    <h3>
                                        <?= View::escape(
                                            $name
                                        ) ?>
                                    </h3>


                                    <?php if (
                                        $description !== ''
                                    ): ?>

                                        <p>
                                            <?= View::escape(
                                                $description
                                            ) ?>
                                        </p>

                                    <?php endif; ?>

                                </div>

                            </a>

                        <?php endforeach; ?>

                    </div>

                </section>

            <?php endif; ?>


            <!-- =================================================
                 People
            ================================================== -->

            <?php if (
                $people !== []
            ): ?>

                <section class="search-results__section">

                    <div class="search-results__heading">

                        <div>

                            <span>
                                اعضای موسسه
                            </span>

                            <h2>
                                اعضای هیئت علمی و کارکنان
                            </h2>

                        </div>

                    </div>


                    <div class="search-results__list">

                        <?php foreach (
                            $people
                            as $person
                        ): ?>

                            <?php
                            $personId =
                                (int) (
                                    $person['id']
                                    ?? 0
                                );

                            $name =
                                $personName(
                                    $person
                                );

                            $position =
                                trim(
                                    (string) (
                                        $person['position']
                                        ?? ''
                                    )
                                );

                            $faculty =
                                trim(
                                    (string) (
                                        $person['faculty_name']
                                        ?? ''
                                    )
                                );
                            ?>

                            <a
                                href="<?= View::url(
                                    '/people/'
                                    . $personId
                                ) ?>"
                                class="search-result-card"
                            >

                                <div
                                    class="search-result-card__type"
                                >
                                    عضو
                                </div>

                                <div
                                    class="search-result-card__body"
                                >

                                    <h3>
                                        <?= View::escape(
                                            $name
                                        ) ?>
                                    </h3>


                                    <?php if (
                                        $position !== ''
                                        || $faculty !== ''
                                    ): ?>

                                        <p>

                                            <?php if (
                                                $position !== ''
                                            ): ?>

                                                <?= View::escape(
                                                    $position
                                                ) ?>

                                            <?php endif; ?>


                                            <?php if (
                                                $position !== ''
                                                && $faculty !== ''
                                            ): ?>

                                                —
                                            <?php endif; ?>


                                            <?php if (
                                                $faculty !== ''
                                            ): ?>

                                                <?= View::escape(
                                                    $faculty
                                                ) ?>

                                            <?php endif; ?>

                                        </p>

                                    <?php endif; ?>

                                </div>

                            </a>

                        <?php endforeach; ?>

                    </div>

                </section>

            <?php endif; ?>


            <!-- =================================================
                 Research Centers
            ================================================== -->

            <?php if (
                $researchCenters !== []
            ): ?>

                <section class="search-results__section">

                    <div class="search-results__heading">

                        <div>

                            <span>
                                پژوهش
                            </span>

                            <h2>
                                پژوهشکده‌ها
                            </h2>

                        </div>

                    </div>


                    <div class="search-results__list">

                        <?php foreach (
                            $researchCenters
                            as $center
                        ): ?>

                            <?php
                            $slug =
                                trim(
                                    (string) (
                                        $center['slug']
                                        ?? ''
                                    )
                                );

                            $name =
                                trim(
                                    (string) (
                                        $center['name']
                                        ?? 'پژوهشکده'
                                    )
                                );

                            $description =
                                $excerpt(
                                    $center['description']
                                    ?? ''
                                );
                            ?>

                            <a
                                href="<?= View::url(
                                    '/research-centers/'
                                    . rawurlencode(
                                        $slug
                                    )
                                ) ?>"
                                class="search-result-card"
                            >

                                <div
                                    class="search-result-card__type"
                                >
                                    پژوهش
                                </div>

                                <div
                                    class="search-result-card__body"
                                >

                                    <h3>
                                        <?= View::escape(
                                            $name
                                        ) ?>
                                    </h3>


                                    <?php if (
                                        $description !== ''
                                    ): ?>

                                        <p>
                                            <?= View::escape(
                                                $description
                                            ) ?>
                                        </p>

                                    <?php endif; ?>

                                </div>

                            </a>

                        <?php endforeach; ?>

                    </div>

                </section>

            <?php endif; ?>


        <?php endif; ?>

    </div>

</section>
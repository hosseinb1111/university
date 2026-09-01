<?php

declare(strict_types=1);

use App\Core\View;

/**
 * =========================================================
 * Sadra University
 * Public Homepage
 * =========================================================
 *
 * Expected variables:
 *
 * @var array<int, array<string, mixed>> $slides
 * @var array<int, array<string, mixed>> $quickLinks
 * @var array<int, array<string, mixed>> $announcements
 * @var array<int, array<string, mixed>> $faculties
 * @var array<int, array<string, mixed>> $researchCenters
 * @var array<int, array<string, mixed>> $documents
 *
 * =========================================================
 */
/**
 * =========================================================
 * Sadra University
 * Public Homepage
 * =========================================================
 *
 * Expected variables:
 *
 * @var array<int, array<string, mixed>> $slides
 * @var array<int, array<string, mixed>> $quickLinks
 * @var array<int, array<string, mixed>> $announcements
 * @var array<int, array<string, mixed>> $faculties
 * @var array<int, array<string, mixed>> $researchCenters
 * @var array<int, array<string, mixed>> $documents
 *
 * =========================================================
 */

$slides =
    is_array($slides ?? null)
        ? $slides
        : [];

$quickLinks =
    is_array($quickLinks ?? null)
        ? $quickLinks
        : [];

$announcements =
    is_array($announcements ?? null)
        ? $announcements
        : [];

$faculties =
    is_array($faculties ?? null)
        ? $faculties
        : [];

$researchCenters =
    is_array($researchCenters ?? null)
        ? $researchCenters
        : [];

$documents =
    is_array($documents ?? null)
        ? $documents
        : [];


/*
|--------------------------------------------------------------------------
| Safe helper functions
|--------------------------------------------------------------------------
*/

/**
 * Determine whether a URL is external.
 */
$isExternalUrl = static function (
    string $url
): bool {
    return str_starts_with(
        $url,
        'http://'
    )
    || str_starts_with(
        $url,
        'https://'
    );
};


/**
 * Format announcement date.
 */
$formatAnnouncementDate = static function (
    mixed $value
): string {
    if (
        !is_string($value)
        || trim($value) === ''
    ) {
        return 'جدید';
    }

    $timestamp =
        strtotime($value);

    if (
        $timestamp === false
    ) {
        return 'جدید';
    }

    return date(
        'Y/m/d',
        $timestamp
    );
};


/**
 * Safely trim Persian/UTF-8 text.
 */
$shortenText = static function (
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
        $value,
        0,
        $width,
        '...',
        'UTF-8'
    );
};

?>

<!-- =======================================================
     HOMEPAGE HERO / SLIDER
======================================================== -->

<?php if (
    count($slides) > 0
): ?>

    <section
        class="home-slider"
        data-home-slider
        aria-label="اسلایدهای صفحه اصلی"
    >

        <div class="home-slider__viewport">

            <?php foreach (
                $slides
                as $index => $slide
            ): ?>

                <?php
                $isFirstSlide =
                    $index === 0;

                $slideTitle =
                    trim(
                        (string) (
                            $slide['title']
                            ?? ''
                        )
                    );

                $slideSubtitle =
                    trim(
                        (string) (
                            $slide['subtitle']
                            ?? ''
                        )
                    );

                $slideDescription =
                    trim(
                        (string) (
                            $slide['description']
                            ?? ''
                        )
                    );

                $slideImage =
                    trim(
                        (string) (
                            $slide['image']
                            ?? ''
                        )
                    );

                $slideMobileImage =
                    trim(
                        (string) (
                            $slide['mobile_image']
                            ?? ''
                        )
                    );

                $slideButtonText =
                    trim(
                        (string) (
                            $slide['button_text']
                            ?? ''
                        )
                    );

                $slideButtonUrl =
                    trim(
                        (string) (
                            $slide['button_url']
                            ?? ''
                        )
                    );
                ?>

                <article
                    class="home-slide <?= $isFirstSlide
                        ? 'home-slide--active'
                        : ''
                    ?>"
                    data-home-slide
                    aria-hidden="<?= $isFirstSlide
                        ? 'false'
                        : 'true'
                    ?>"
                >

                    <?php if (
                        $slideImage !== ''
                    ): ?>

                        <picture>

                            <?php if (
                                $slideMobileImage !== ''
                            ): ?>

                                <source
                                    media="(max-width: 700px)"
                                    srcset="<?= View::escape(
                                        $slideMobileImage
                                    ) ?>"
                                >

                            <?php endif; ?>


                            <img
                                src="<?= View::escape(
                                    $slideImage
                                ) ?>"
                                alt="<?= View::escape(
                                    $slideTitle
                                ) ?>"
                                class="home-slide__image"
                                <?= $isFirstSlide
                                    ? ''
                                    : 'loading="lazy"'
                                ?>
                            >

                        </picture>

                    <?php endif; ?>


                    <div
                        class="home-slide__overlay"
                        aria-hidden="true"
                    ></div>


                    <div
                        class="container home-slide__inner"
                    >

                        <div class="home-slide__content">


                            <?php if (
                                $slideSubtitle !== ''
                            ): ?>

                                <span
                                    class="home-slide__subtitle"
                                >
                                    <?= View::escape(
                                        $slideSubtitle
                                    ) ?>
                                </span>

                            <?php endif; ?>


                            <?php if (
                                $slideTitle !== ''
                            ): ?>

                                <h1>
                                    <?= View::escape(
                                        $slideTitle
                                    ) ?>
                                </h1>

                            <?php endif; ?>


                            <?php if (
                                $slideDescription !== ''
                            ): ?>

                                <p>
                                    <?= View::escape(
                                        $slideDescription
                                    ) ?>
                                </p>

                            <?php endif; ?>


                            <?php if (
                                $slideButtonText !== ''
                                && $slideButtonUrl !== ''
                            ): ?>

                                <a
                                    href="<?= View::escape(
                                        $slideButtonUrl
                                    ) ?>"
                                    class="button button--primary"
                                    <?php if (
                                        $isExternalUrl(
                                            $slideButtonUrl
                                        )
                                    ): ?>
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    <?php endif; ?>
                                >
                                    <?= View::escape(
                                        $slideButtonText
                                    ) ?>
                                </a>

                            <?php endif; ?>

                        </div>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>


        <?php if (
            count($slides) > 1
        ): ?>

            <button
                type="button"
                class="home-slider__button home-slider__button--prev"
                data-home-slider-prev
                aria-label="اسلاید قبلی"
            >
                <span aria-hidden="true">
                    ‹
                </span>
            </button>


            <button
                type="button"
                class="home-slider__button home-slider__button--next"
                data-home-slider-next
                aria-label="اسلاید بعدی"
            >
                <span aria-hidden="true">
                    ›
                </span>
            </button>


            <div
                class="home-slider__dots"
                role="tablist"
                aria-label="انتخاب اسلاید"
            >

                <?php foreach (
                    $slides
                    as $index => $slide
                ): ?>

                    <button
                        type="button"
                        class="home-slider__dot <?= $index === 0
                            ? 'home-slider__dot--active'
                            : ''
                        ?>"
                        data-home-slider-dot="<?= $index ?>"
                        aria-label="اسلاید <?= $index + 1 ?>"
                        aria-selected="<?= $index === 0
                            ? 'true'
                            : 'false'
                        ?>"
                        role="tab"
                    ></button>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </section>

<?php else: ?>

    <!-- ===================================================
         HERO FALLBACK
    ==================================================== -->

    <section class="home-hero">

        <div class="container">

            <div class="home-hero__content">

                <span class="home-hero__eyebrow">
                    موسسه آموزش عالی صدرالمتالهین
                </span>


                <h1>
                    صدرا
                </h1>


                <p>
                    محیطی برای آموزش، پژوهش، رشد علمی و پرورش نیروی متخصص.
                </p>


                <div class="home-hero__actions">

                    <a
                        href="<?= View::url(
                            '/faculties'
                        ) ?>"
                        class="button button--primary"
                    >
                        مشاهده دانشکده‌ها
                    </a>


                    <a
                        href="<?= View::url(
                            '/announcements'
                        ) ?>"
                        class="button button--secondary"
                    >
                        آخرین اطلاعیه‌ها
                    </a>

                </div>

            </div>

        </div>

    </section>

<?php endif; ?>


<!-- =======================================================
     QUICK LINKS
======================================================== -->

<section
    class="home-section home-quick-links"
>

    <div class="container">

        <div class="home-section__heading">

            <div>

                <span>
                    دسترسی سریع
                </span>

                <h2>
                    سامانه‌ها و خدمات
                </h2>

            </div>

        </div>


        <?php if (
            $quickLinks === []
        ): ?>

            <div class="home-empty">
                خدماتی برای نمایش وجود ندارد.
            </div>

        <?php else: ?>

            <div class="home-quick-grid">

                <?php foreach (
                    $quickLinks
                    as $link
                ): ?>

                    <?php
                    $linkUrl =
                        trim(
                            (string) (
                                $link['url']
                                ?? '#'
                            )
                        );

                    $linkTitle =
                        trim(
                            (string) (
                                $link['title']
                                ?? ''
                            )
                        );

                    $linkDescription =
                        trim(
                            (string) (
                                $link['description']
                                ?? ''
                            )
                        );

                    $external =
                        $isExternalUrl(
                            $linkUrl
                        );
                    ?>

                    <a
                        href="<?= View::escape(
                            $linkUrl
                        ) ?>"
                        class="home-quick-card"
                        <?php if (
                            $external
                        ): ?>
                            target="_blank"
                            rel="noopener noreferrer"
                        <?php endif; ?>
                    >

                        <strong>
                            <?= View::escape(
                                $linkTitle
                            ) ?>
                        </strong>


                        <?php if (
                            $linkDescription !== ''
                        ): ?>

                            <span>
                                <?= View::escape(
                                    $linkDescription
                                ) ?>
                            </span>

                        <?php endif; ?>

                    </a>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>


<!-- =======================================================
     ANNOUNCEMENTS
======================================================== -->

<section class="home-section">

    <div class="container">

        <div class="home-section__heading">

            <div>

                <span>
                    اطلاعیه‌ها
                </span>

                <h2>
                    آخرین اطلاعیه‌ها
                </h2>

            </div>


            <a
                href="<?= View::url(
                    '/announcements'
                ) ?>"
                class="home-section__link"
            >
                مشاهده همه
            </a>

        </div>


        <?php if (
            $announcements === []
        ): ?>

            <div class="home-empty">
                اطلاعیه‌ای برای نمایش وجود ندارد.
            </div>

        <?php else: ?>

            <div
                class="home-announcement-grid"
            >

                <?php foreach (
                    $announcements
                    as $announcement
                ): ?>

                    <?php
                    $announcementSlug =
                        trim(
                            (string) (
                                $announcement['slug']
                                ?? ''
                            )
                        );

                    $announcementTitle =
                        trim(
                            (string) (
                                $announcement['title']
                                ?? ''
                            )
                        );

                    $announcementExcerpt =
                        trim(
                            (string) (
                                $announcement['excerpt']
                                ?? ''
                            )
                        );
                    ?>

                    <article
                        class="home-announcement-card"
                    >

                        <div
                            class="home-announcement-card__date"
                        >
                            <?= View::escape(
                                $formatAnnouncementDate(
                                    $announcement[
                                        'published_at'
                                    ]
                                    ?? null
                                )
                            ) ?>
                        </div>


                        <h3>

                            <?php if (
                                $announcementSlug !== ''
                            ): ?>

                                <a
                                    href="<?= View::url(
                                        '/announcements/'
                                        . rawurlencode(
                                            $announcementSlug
                                        )
                                    ) ?>"
                                >
                                    <?= View::escape(
                                        $announcementTitle
                                    ) ?>
                                </a>

                            <?php else: ?>

                                <?= View::escape(
                                    $announcementTitle
                                ) ?>

                            <?php endif; ?>

                        </h3>


                        <?php if (
                            $announcementExcerpt !== ''
                        ): ?>

                            <p>
                                <?= View::escape(
                                    $announcementExcerpt
                                ) ?>
                            </p>

                        <?php endif; ?>


                        <?php if (
                            $announcementSlug !== ''
                        ): ?>

                            <a
                                href="<?= View::url(
                                    '/announcements/'
                                    . rawurlencode(
                                        $announcementSlug
                                    )
                                ) ?>"
                                class="home-card-link"
                            >
                                ادامه مطلب
                            </a>

                        <?php endif; ?>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>


<!-- =======================================================
     FACULTIES
======================================================== -->

<section
    class="home-section home-section--muted"
>

    <div class="container">

        <div class="home-section__heading">

            <div>

                <span>
                    آموزش
                </span>

                <h2>
                    دانشکده‌ها
                </h2>

            </div>


            <a
                href="<?= View::url(
                    '/faculties'
                ) ?>"
                class="home-section__link"
            >
                همه دانشکده‌ها
            </a>

        </div>


        <?php if (
            $faculties === []
        ): ?>

            <div class="home-empty">
                اطلاعات دانشکده‌ها هنوز ثبت نشده است.
            </div>

        <?php else: ?>

            <div class="home-faculty-grid">

                <?php foreach (
                    $faculties
                    as $faculty
                ): ?>

                    <?php
                    $facultySlug =
                        trim(
                            (string) (
                                $faculty['slug']
                                ?? ''
                            )
                        );

                    $facultyName =
                        trim(
                            (string) (
                                $faculty['name']
                                ?? ''
                            )
                        );

                    $facultyImage =
                        trim(
                            (string) (
                                $faculty['image']
                                ?? ''
                            )
                        );

                    $facultyShortName =
                        trim(
                            (string) (
                                $faculty['short_name']
                                ?? ''
                            )
                        );
                    ?>

                    <article
                        class="home-faculty-card"
                    >

                        <?php if (
                            $facultyImage !== ''
                        ): ?>

                            <img
                                src="<?= View::escape(
                                    $facultyImage
                                ) ?>"
                                alt="<?= View::escape(
                                    $facultyName
                                ) ?>"
                                loading="lazy"
                            >

                        <?php else: ?>

                            <div
                                class="home-faculty-card__placeholder"
                                aria-hidden="true"
                            >
                                <?= View::escape(
                                    mb_substr(
                                        $facultyName,
                                        0,
                                        1,
                                        'UTF-8'
                                    )
                                ) ?>
                            </div>

                        <?php endif; ?>


                        <div>

                            <h3>
                                <?= View::escape(
                                    $facultyName
                                ) ?>
                            </h3>


                            <?php if (
                                $facultyShortName !== ''
                            ): ?>

                                <span>
                                    <?= View::escape(
                                        $facultyShortName
                                    ) ?>
                                </span>

                            <?php endif; ?>

                        </div>


                        <?php if (
                            $facultySlug !== ''
                        ): ?>

                            <a
                                href="<?= View::url(
                                    '/faculties/'
                                    . rawurlencode(
                                        $facultySlug
                                    )
                                ) ?>"
                                class="home-card-link"
                            >
                                مشاهده
                            </a>

                        <?php endif; ?>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>


<!-- =======================================================
     RESEARCH
======================================================== -->

<section class="home-section">

    <div class="container">

        <div class="home-section__heading">

            <div>

                <span>
                    پژوهش
                </span>

                <h2>
                    پژوهشکده‌ها
                </h2>

            </div>


            <a
                href="<?= View::url(
                    '/research-centers'
                ) ?>"
                class="home-section__link"
            >
                مشاهده همه
            </a>

        </div>


        <?php if (
            $researchCenters === []
        ): ?>

            <div class="home-empty">
                اطلاعات پژوهشکده‌ها هنوز ثبت نشده است.
            </div>

        <?php else: ?>

            <div class="home-research-grid">

                <?php foreach (
                    $researchCenters
                    as $center
                ): ?>

                    <?php
                    $centerSlug =
                        trim(
                            (string) (
                                $center['slug']
                                ?? ''
                            )
                        );

                    $centerName =
                        trim(
                            (string) (
                                $center['name']
                                ?? ''
                            )
                        );

                    $centerDescription =
                        $shortenText(
                            $center['description']
                            ?? '',
                            180
                        );
                    ?>

                    <article
                        class="home-research-card"
                    >

                        <h3>
                            <?= View::escape(
                                $centerName
                            ) ?>
                        </h3>


                        <?php if (
                            $centerDescription !== ''
                        ): ?>

                            <p>
                                <?= View::escape(
                                    $centerDescription
                                ) ?>
                            </p>

                        <?php endif; ?>


                        <?php if (
                            $centerSlug !== ''
                        ): ?>

                            <a
                                href="<?= View::url(
                                    '/research-centers/'
                                    . rawurlencode(
                                        $centerSlug
                                    )
                                ) ?>"
                                class="home-card-link"
                            >
                                مشاهده پژوهشکده
                            </a>

                        <?php endif; ?>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>


<!-- =======================================================
     DOCUMENTS
======================================================== -->

<section
    class="home-section home-section--muted"
>

    <div class="container">

        <div class="home-section__heading">

            <div>

                <span>
                    منابع
                </span>

                <h2>
                    آخرین اسناد و فرم‌ها
                </h2>

            </div>


            <a
                href="<?= View::url(
                    '/documents'
                ) ?>"
                class="home-section__link"
            >
                مشاهده همه
            </a>

        </div>


        <?php if (
            $documents === []
        ): ?>

            <div class="home-empty">
                سندی برای نمایش وجود ندارد.
            </div>

        <?php else: ?>

            <div class="home-document-list">

                <?php foreach (
                    $documents
                    as $document
                ): ?>

                    <?php
                    $documentCategory =
                        trim(
                            (string) (
                                $document[
                                    'category_slug'
                                ]
                                ?? ''
                            )
                        );

                    $documentTitle =
                        trim(
                            (string) (
                                $document['title']
                                ?? ''
                            )
                        );

                    $documentCategoryName =
                        trim(
                            (string) (
                                $document[
                                    'category_name'
                                ]
                                ?? ''
                            )
                        );

                    $documentId =
                        (int) (
                            $document['id']
                            ?? 0
                        );
                    ?>

                    <?php if (
                        $documentId > 0
                        && $documentCategory !== ''
                    ): ?>

                        <a
                            href="<?= View::url(
                                '/documents/'
                                . rawurlencode(
                                    $documentCategory
                                )
                                . '/'
                                . $documentId
                            ) ?>"
                            class="home-document-item"
                        >

                            <div>

                                <strong>
                                    <?= View::escape(
                                        $documentTitle
                                    ) ?>
                                </strong>


                                <?php if (
                                    $documentCategoryName
                                    !== ''
                                ): ?>

                                    <span>
                                        <?= View::escape(
                                            $documentCategoryName
                                        ) ?>
                                    </span>

                                <?php endif; ?>

                            </div>


                            <span>
                                دانلود
                            </span>

                        </a>

                    <?php endif; ?>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>


<!-- =======================================================
     INSTITUTION SERVICES
======================================================== -->

<section class="home-section">

    <div class="container">

        <div class="home-section__heading">

            <div>

                <span>
                    موسسه
                </span>

                <h2>
                    بخش‌های اصلی
                </h2>

            </div>

        </div>


        <div class="home-quick-grid">
        <a
    href="<?= View::url(
        '/programs'
    ) ?>"
    class="home-quick-card"
>

    <strong>
        رشته‌ها و برنامه‌های آموزشی
    </strong>

    <span>
        مشاهده رشته‌ها، مقاطع و برنامه‌های تحصیلی
    </span>

</a>
            <a
                href="<?= View::url(
                    '/about'
                ) ?>"
                class="home-quick-card"
            >

                <strong>
                    درباره موسسه
                </strong>

                <span>
                    معرفی، اهداف و اطلاعات عمومی موسسه
                </span>

            </a>


            <a
                href="<?= View::url(
                    '/presidency'
                ) ?>"
                class="home-quick-card"
            >

                <strong>
                    ریاست
                </strong>

                <span>
                    اطلاعات ریاست و دفتر ریاست موسسه
                </span>

            </a>


            <a
                href="<?= View::url(
                    '/student-affairs'
                ) ?>"
                class="home-quick-card"
            >

                <strong>
                    دانشجویی و فرهنگی
                </strong>

                <span>
                    خدمات و اطلاعات دانشجویی
                </span>

            </a>


            <a
                href="<?= View::url(
                    '/support'
                ) ?>"
                class="home-quick-card"
            >

                <strong>
                    پشتیبانی و عمرانی
                </strong>

                <span>
                    خدمات اداری، پشتیبانی و زیرساختی
                </span>

            </a>

        </div>

    </div>

</section>


<!-- =======================================================
     CONTACT
======================================================== -->

<section class="home-contact">

    <div class="container">

        <div class="home-contact__inner">

            <div>

                <span>
                    ارتباط با موسسه
                </span>


                <h2>
                    با ما در ارتباط باشید
                </h2>


                <p>
                    برای دریافت اطلاعات بیشتر می‌توانید با موسسه تماس بگیرید.
                </p>

            </div>


            <a
                href="<?= View::url(
                    '/contact'
                ) ?>"
                class="button button--primary"
            >
                تماس با ما
            </a>

        </div>

    </div>

</section>
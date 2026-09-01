<?php

declare(strict_types=1);

use App\Core\View;
use App\Models\SiteSetting;


/*
|--------------------------------------------------------------------------
| Normalize homepage data
|--------------------------------------------------------------------------
*/

$slides =
    is_array($slides ?? null)
        ? $slides
        : [];

$sliderSettings =
    is_array($sliderSettings ?? null)
        ? $sliderSettings
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
| Slider settings
|--------------------------------------------------------------------------
*/

$sliderAutoplay =
    !empty(
        $sliderSettings['autoplay']
        ?? true
    );

$sliderInterval =
    (int) (
        $sliderSettings['interval']
        ?? 5000
    );

$sliderInterval =
    max(
        2000,
        min(
            30000,
            $sliderInterval
        )
    );

$sliderShowArrows =
    !empty(
        $sliderSettings['show_arrows']
        ?? true
    );

$sliderShowDots =
    !empty(
        $sliderSettings['show_dots']
        ?? true
    );


$sliderBackgroundMode =
    trim(
        (string) (
            $sliderSettings['background_mode']
            ?? 'blur'
        )
    );

if (
    !in_array(
        $sliderBackgroundMode,
        [
            'blur',
            'dominant',
            'solid',
            'gradient',
            'none',
        ],
        true
    )
) {
    $sliderBackgroundMode =
        'blur';
}


$sliderBackgroundColor =
    strtoupper(
        trim(
            (string) (
                $sliderSettings['background_color']
                ?? '#111827'
            )
        )
    );

if (
    preg_match(
        '/^#[0-9A-F]{6}$/i',
        $sliderBackgroundColor
    ) !== 1
) {
    $sliderBackgroundColor =
        '#111827';
}


$sliderGradient =
    trim(
        (string) (
            $sliderSettings['gradient']
            ?? 'dark'
        )
    );

if (
    !in_array(
        $sliderGradient,
        [
            'dark',
            'ocean',
            'purple',
            'sunset',
            'light',
        ],
        true
    )
) {
    $sliderGradient =
        'dark';
}


$sliderImageFit =
    trim(
        (string) (
            $sliderSettings['image_fit']
            ?? 'contain'
        )
    );

if (
    !in_array(
        $sliderImageFit,
        [
            'contain',
            'cover',
            'fill',
        ],
        true
    )
) {
    $sliderImageFit =
        'contain';
}


$sliderImagePosition =
    trim(
        (string) (
            $sliderSettings['image_position']
            ?? 'center center'
        )
    );

if (
    !in_array(
        $sliderImagePosition,
        [
            'center center',
            'center top',
            'center bottom',
            'left center',
            'right center',
            'left top',
            'right top',
            'left bottom',
            'right bottom',
        ],
        true
    )
) {
    $sliderImagePosition =
        'center center';
}


/*
|--------------------------------------------------------------------------
| Slider gradient presets
|--------------------------------------------------------------------------
*/

$sliderGradientCss = match (
    $sliderGradient
) {
    'ocean' =>
        'linear-gradient(135deg, #0f172a, #0369a1)',

    'purple' =>
        'linear-gradient(135deg, #1e1b4b, #7e22ce)',

    'sunset' =>
        'linear-gradient(135deg, #7c2d12, #db2777)',

    'light' =>
        'linear-gradient(135deg, #e5e7eb, #f8fafc)',

    default =>
        'linear-gradient(135deg, #0f172a, #1e293b)',
};


/*
|--------------------------------------------------------------------------
| Initial slider background
|--------------------------------------------------------------------------
*/

$sliderInitialBackground =
    match (
        $sliderBackgroundMode
    ) {
        'solid' =>
            $sliderBackgroundColor,

        'gradient' =>
            $sliderGradientCss,

        'none' =>
            'transparent',

        default =>
            '#111827',
    };


/*
|--------------------------------------------------------------------------
| Homepage quick links settings
|--------------------------------------------------------------------------
*/

$quickLinksEyebrow =
    (string) SiteSetting::get(
        'homepage.quick_links.eyebrow',
        'دسترسی سریع'
    );

$quickLinksTitle =
    (string) SiteSetting::get(
        'homepage.quick_links.title',
        'سامانه‌ها و خدمات'
    );

$quickLinksDescription =
    (string) SiteSetting::get(
        'homepage.quick_links.description',
        'دسترسی سریع به سامانه‌ها و خدمات مهم موسسه'
    );


/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

$isExternalUrl = static function (
    string $url
): bool {
    $url =
        trim(
            $url
        );

    return str_starts_with(
        $url,
        'http://'
    )
    || str_starts_with(
        $url,
        'https://'
    );
};


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
        strtotime(
            $value
        );

    if (
        $timestamp === false
    ) {
        return 'جدید';
    }

    $formatted =
        jalali_date_fa(
            $value,
            'Y/m/d'
        );

    return $formatted !== ''
        ? $formatted
        : 'جدید';
};


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
        trim($value),
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
    $slides !== []
): ?>

    <section
        class="home-slider"
        data-home-slider

        data-slider-autoplay="<?= $sliderAutoplay
            ? 'true'
            : 'false'
        ?>"

        data-slider-interval="<?= $sliderInterval ?>"

        data-slider-arrows="<?= $sliderShowArrows
            ? 'true'
            : 'false'
        ?>"

        data-slider-dots="<?= $sliderShowDots
            ? 'true'
            : 'false'
        ?>"

        data-slider-background-mode="<?= View::escape(
            $sliderBackgroundMode
        ) ?>"

        data-slider-background-color="<?= View::escape(
            $sliderBackgroundColor
        ) ?>"

        data-slider-gradient="<?= View::escape(
            $sliderGradient
        ) ?>"

        data-slider-image-fit="<?= View::escape(
            $sliderImageFit
        ) ?>"

        data-slider-image-position="<?= View::escape(
            $sliderImagePosition
        ) ?>"

        aria-label="اسلایدهای صفحه اصلی"

        style="
            background: <?= View::escape(
                $sliderInitialBackground
            ) ?>;
        "
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

                            <img
                                src="<?= View::escape(
                                    $slideImage
                                ) ?>"

                                alt=""

                                aria-hidden="true"

                                class="home-slide__backdrop"
                            >


                            <?php if (
                                $slideMobileImage !== ''
                            ): ?>

                                <source
                                    media="(max-width: 650px)"
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
                                    $slideTitle !== ''
                                        ? $slideTitle
                                        : 'اسلاید صفحه اصلی'
                                ) ?>"

                                class="home-slide__image"

                                style="
                                    object-fit: <?= View::escape(
                                        $sliderImageFit
                                    ) ?>;

                                    object-position: <?= View::escape(
                                        $sliderImagePosition
                                    ) ?>;
                                "

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

            <?php if (
                $sliderShowArrows
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

            <?php endif; ?>


            <?php if (
                $sliderShowDots
            ): ?>

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

        <?php endif; ?>

    </section>

<?php else: ?>

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
     QUICK LINKS / SERVICES
======================================================== -->

<?php if (
    $quickLinks !== []
): ?>

    <section
        class="home-section home-quick-links"
    >

        <div class="container">

            <div class="home-section__heading">

                <div>

                    <?php if (
                        $quickLinksEyebrow !== ''
                    ): ?>

                        <span>
                            <?= View::escape(
                                $quickLinksEyebrow
                            ) ?>
                        </span>

                    <?php endif; ?>


                    <?php if (
                        $quickLinksTitle !== ''
                    ): ?>

                        <h2>
                            <?= View::escape(
                                $quickLinksTitle
                            ) ?>
                        </h2>

                    <?php endif; ?>


                    <?php if (
                        $quickLinksDescription !== ''
                    ): ?>

                        <p>
                            <?= View::escape(
                                $quickLinksDescription
                            ) ?>
                        </p>

                    <?php endif; ?>

                </div>

            </div>


            <div class="home-quick-grid">

                <?php foreach (
                    $quickLinks
                    as $service
                ): ?>

                    <?php

                    $serviceTitle =
                        trim(
                            (string) (
                                $service['title']
                                ?? ''
                            )
                        );

                    $serviceUrl =
                        trim(
                            (string) (
                                $service['url']
                                ?? ''
                            )
                        );

                    $serviceImage =
                        trim(
                            (string) (
                                $service['image']
                                ?? ''
                            )
                        );

                    $external =
                        $isExternalUrl(
                            $serviceUrl
                        );

                    ?>

                    <?php if (
                        $serviceTitle !== ''
                        && $serviceUrl !== ''
                    ): ?>

                        <a
                            href="<?= View::escape(
                                $serviceUrl
                            ) ?>"

                            class="home-quick-card"

                            <?php if (
                                $external
                            ): ?>

                                target="_blank"

                                rel="noopener noreferrer"

                            <?php endif; ?>
                        >

                            <?php if (
                                $serviceImage !== ''
                            ): ?>

                                <img
                                    src="<?= View::escape(
                                        $serviceImage
                                    ) ?>"

                                    alt=""

                                    loading="lazy"
                                >

                            <?php endif; ?>


                            <strong>
                                <?= View::escape(
                                    $serviceTitle
                                ) ?>
                            </strong>

                        </a>

                    <?php endif; ?>

                <?php endforeach; ?>

            </div>

        </div>

    </section>

<?php endif; ?>


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

            <div class="home-announcement-grid">

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
                                ?? 'دانشکده'
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

                    $facultyDescription =
                        $shortenText(
                            $faculty['description']
                            ?? '',
                            150
                        );

                    /*
                    |--------------------------------------------------------------------------
                    | Faculty card destination
                    |--------------------------------------------------------------------------
                    |
                    | The entire card is now the link (see below), so this is
                    | computed once and reused both for the wrapping <a> and,
                    | when missing, to fall back to a plain, non-clickable
                    | <div> instead of a link pointing nowhere.
                    |
                    */

                    $facultyUrl =
                        $facultySlug !== ''
                            ? View::url(
                                '/faculties/'
                                . rawurlencode(
                                    $facultySlug
                                )
                            )
                            : '';

                    $facultyCardTag =
                        $facultyUrl !== ''
                            ? 'a'
                            : 'div';

                    ?>

                    <<?= $facultyCardTag ?>

                        <?php if (
                            $facultyUrl !== ''
                        ): ?>

                            href="<?= View::escape(
                                $facultyUrl
                            ) ?>"

                        <?php endif; ?>

                        class="home-faculty-card<?= $facultyUrl === ''
                            ? ' home-faculty-card--static'
                            : ''
                        ?>"
                    >

                        <div
                            class="home-faculty-card__media"
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

                                    <span>
                                        <?= View::escape(
                                            mb_substr(
                                                $facultyName,
                                                0,
                                                1,
                                                'UTF-8'
                                            )
                                        ) ?>
                                    </span>

                                </div>

                            <?php endif; ?>


                            <div
                                class="home-faculty-card__media-overlay"
                                aria-hidden="true"
                            ></div>

                        </div>


                        <div
                            class="home-faculty-card__content"
                        >

                            <div
                                class="home-faculty-card__heading"
                            >

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
                                $facultyDescription !== ''
                            ): ?>

                                <p
                                    class="home-faculty-card__description"
                                >
                                    <?= View::escape(
                                        $facultyDescription
                                    ) ?>
                                </p>

                            <?php else: ?>

                                <p
                                    class="home-faculty-card__description"
                                >
                                    اطلاعات و برنامه‌های آموزشی این دانشکده را مشاهده کنید.
                                </p>

                            <?php endif; ?>


                            <?php if (
                                $facultyUrl !== ''
                            ): ?>

                                <!--
                                | This is plain text, not a nested link — the
                                | whole card above is already the <a>. A link
                                | inside a link is invalid HTML and would make
                                | screen readers announce "دانشکده" twice for
                                | the same destination.
                                -->

                                <span
                                    class="home-faculty-card__cta"
                                >

                                    مشاهده دانشکده

                                    <svg
                                        class="home-faculty-card__cta-icon"
                                        width="15"
                                        height="15"
                                        viewBox="0 0 20 20"
                                        aria-hidden="true"
                                    >

                                        <path
                                            d="M12.5 5 7 10l5.5 5"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.7"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />

                                    </svg>

                                </span>

                            <?php endif; ?>

                        </div>

                    </<?= $facultyCardTag ?>>

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
                                ?? 'پژوهشکده'
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

                <span
                    class="home-documents__eyebrow"
                >
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

            <div class="home-document-grid">

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

                        <?php

                        $documentUrl =
                            View::url(
                                '/documents/'
                                . rawurlencode(
                                    $documentCategory
                                )
                                . '/'
                                . $documentId
                            );

                        ?>


                        <article
                            class="home-document-card"
                        >

                            <div
                                class="home-document-card__body"
                            >

                                <?php if (
                                    $documentCategoryName !== ''
                                ): ?>

                                    <span
                                        class="home-document-card__category"
                                    >
                                        <?= View::escape(
                                            $documentCategoryName
                                        ) ?>
                                    </span>

                                <?php endif; ?>


                                <h3
                                    class="home-document-card__title"
                                >

                                    <a
                                        href="<?= View::escape(
                                            $documentUrl
                                        ) ?>"
                                    >
                                        <?= View::escape(
                                            $documentTitle
                                        ) ?>
                                    </a>

                                </h3>

                            </div>


                            <div
                                class="home-document-card__footer"
                            >

                                <?php if (
                                    $documentCategoryName !== ''
                                ): ?>

                                    <span
                                        class="home-document-card__type"
                                    >
                                        <?= View::escape(
                                            $documentCategoryName
                                        ) ?>
                                    </span>

                                <?php endif; ?>


                                <a
                                    href="<?= View::escape(
                                        $documentUrl
                                    ) ?>"

                                    class="home-document-card__link"
                                >

                                    <span>
                                        مشاهده سند
                                    </span>

                                    <span
                                        class="home-document-card__arrow"
                                        aria-hidden="true"
                                    >
                                        ←
                                    </span>

                                </a>

                            </div>

                        </article>

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
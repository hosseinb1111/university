<?php

declare(strict_types=1);

use App\Core\Session;
use App\Core\View;
use App\Models\SiteSetting;


/*
|--------------------------------------------------------------------------
| Page metadata
|--------------------------------------------------------------------------
*/

$title =
    $title
    ?? config(
        'app.seo.default_title',
        'موسسه آموزش عالی صدرالمتالهین'
    );

$description =
    $description
    ?? config(
        'app.seo.default_description',
        ''
    );


/*
|--------------------------------------------------------------------------
| Site information
|--------------------------------------------------------------------------
*/

$siteName =
    config(
        'app.name',
        'موسسه آموزش عالی صدرالمتالهین'
    );

$siteShortName =
    config(
        'app.short_name',
        'صدرا'
    );


/*
|--------------------------------------------------------------------------
| Contact information
|--------------------------------------------------------------------------
|
| Contact data is managed through SiteSetting so the footer stays
| synchronized with the editable contact settings used by the
| public contact page.
|
*/

$contactEmail =
    (string) SiteSetting::get(
        'contact.email',
        'info@sadra.ac.ir'
    );

$contactPhone =
    (string) SiteSetting::get(
        'contact.phone',
        ''
    );

$contactFax =
    (string) SiteSetting::get(
        'contact.fax',
        ''
    );

$contactAddress =
    (string) SiteSetting::get(
        'contact.address',
        'استان تهران، تهران، منطقه ۲۲، بزرگراه شهید خرازی، خروجی بلوار کاشان جنوب، میدان موج، بلوار علامه قزوینی، نبش، Iran'
    );


/*
|--------------------------------------------------------------------------
| Application URL
|--------------------------------------------------------------------------
*/

$baseUrl =
    rtrim(
        (string) config(
            'app.url',
            ''
        ),
        '/'
    );


/*
|--------------------------------------------------------------------------
| Current request path
|--------------------------------------------------------------------------
*/

$currentPath =
    parse_url(
        $_SERVER['REQUEST_URI'] ?? '/',
        PHP_URL_PATH
    );


if (
    !is_string($currentPath)
    || $currentPath === ''
) {
    $currentPath = '/';
}


/*
|--------------------------------------------------------------------------
| Persian homepage
|--------------------------------------------------------------------------
*/

$isPersianHomepage =
    $currentPath === '/';


/*
|--------------------------------------------------------------------------
| Canonical URL
|--------------------------------------------------------------------------
*/

$canonicalUrl =
    isset($canonical)
    && is_string($canonical)
    && $canonical !== ''
        ? $canonical
        : $baseUrl . $currentPath;


/*
|--------------------------------------------------------------------------
| English alternate URL
|--------------------------------------------------------------------------
*/

$englishPath =
    match (
        $currentPath
    ) {
        '/' =>
            '/english',

        '/about' =>
            '/english/about',

        '/presidency' =>
            '/english/presidency',

        '/education' =>
            '/english/faculties',

        '/student-affairs' =>
            '/english/about',

        '/support' =>
            '/english/contact',

        '/faculties' =>
            '/english/faculties',

        '/programs' =>
            '/english/programs',

        '/research-centers' =>
            '/english/research',

        '/announcements' =>
            '/english/announcements',

        '/contact' =>
            '/english/contact',

        '/search' =>
            '/english',

        '/documents',
        '/documents/' =>
            '/english',

        default =>
            '/english',
    };


$englishUrl =
    $baseUrl
    . $englishPath;


/*
|--------------------------------------------------------------------------
| Authentication state
|--------------------------------------------------------------------------
*/

$isAuthenticated =
    Session::authenticated();


/*
|--------------------------------------------------------------------------
| Flash messages
|--------------------------------------------------------------------------
*/

$errorMessage =
    Session::getFlash(
        'error'
    );

$successMessage =
    Session::getFlash(
        'success'
    );


/*
|--------------------------------------------------------------------------
| Active navigation helper
|--------------------------------------------------------------------------
*/

$navActive =
    static function (
        string $path
    ) use (
        $currentPath
    ): string {

        if (
            $path === '/'
        ) {
            return $currentPath === '/'
                ? 'site-nav__link--active'
                : '';
        }


        return str_starts_with(
            $currentPath,
            $path
        )
            ? 'site-nav__link--active'
            : '';
    };


/*
|--------------------------------------------------------------------------
| Phone href
|--------------------------------------------------------------------------
*/

$phoneHref =
    preg_replace(
        '/[^0-9+]/',
        '',
        $contactPhone
    );


if (
    !is_string($phoneHref)
) {
    $phoneHref = '';
}


/*
|--------------------------------------------------------------------------
| Public assets
|--------------------------------------------------------------------------
|
| View::asset() already generates an automatic cache-busting version
| based on the file modification time.
|
*/

$appCss =
    View::asset(
        'css/app.css'
    );

$announcementsCss =
    View::asset(
        'css/announcements.css'
    );

$homeCss =
    View::asset(
        'css/home.css'
    );

$teacherCss =
    View::asset(
        'css/teacher.css'
    );

$institutionCss =
    View::asset(
        'css/institution.css'
    );

$documentsCss =
    View::asset(
        'css/documents.css'
    );

$searchCss =
    View::asset(
        'css/search.css'
    );

$appJs =
    View::asset(
        'js/app.js'
    );


/*
|--------------------------------------------------------------------------
| Shared theme logos
|--------------------------------------------------------------------------
|
| The public Persian and English pages use the same pair of logo assets.
|
| The existing theme system remains untouched.
|
*/

$logoLight =
    View::asset(
        'images/logo-light.png'
    );


$logoDark =
    View::asset(
        'images/logo-dark.png'
    );

?>

<!DOCTYPE html>

<html
    lang="fa"
    dir="rtl"
    data-theme="light"
>

<head>

    <meta charset="UTF-8">


    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >


    <meta
        name="description"
        content="<?= View::escape(
            $description
        ) ?>"
    >


    <meta
        name="robots"
        content="<?= View::escape(
            config(
                'app.seo.robots',
                'index,follow'
            )
        ) ?>"
    >


    <link
        rel="canonical"
        href="<?= View::escape(
            $canonicalUrl
        ) ?>"
    >


    <link
        rel="alternate"
        hreflang="fa"
        href="<?= View::escape(
            $canonicalUrl
        ) ?>"
    >


    <link
        rel="alternate"
        hreflang="en"
        href="<?= View::escape(
            $englishUrl
        ) ?>"
    >


    <link
        rel="alternate"
        hreflang="x-default"
        href="<?= View::escape(
            $canonicalUrl
        ) ?>"
    >


    <meta
        property="og:type"
        content="website"
    >


    <meta
        property="og:title"
        content="<?= View::escape(
            $title
        ) ?>"
    >


    <meta
        property="og:description"
        content="<?= View::escape(
            $description
        ) ?>"
    >


    <meta
        property="og:url"
        content="<?= View::escape(
            $canonicalUrl
        ) ?>"
    >


    <meta
        property="og:site_name"
        content="<?= View::escape(
            $siteName
        ) ?>"
    >


    <meta
        property="og:locale"
        content="fa_IR"
    >


    <meta
        property="og:locale:alternate"
        content="en_US"
    >


    <meta
        name="twitter:card"
        content="<?= View::escape(
            config(
                'app.seo.twitter_card',
                'summary'
            )
        ) ?>"
    >


    <meta
        name="twitter:title"
        content="<?= View::escape(
            $title
        ) ?>"
    >


    <meta
        name="twitter:description"
        content="<?= View::escape(
            $description
        ) ?>"
    >


    <meta
        name="theme-color"
        content="#f8fafc"
        id="theme-color-meta"
    >


    <meta
        name="application-name"
        content="<?= View::escape(
            $siteShortName
        ) ?>"
    >


    <title>
        <?= View::escape(
            $title
        ) ?>
    </title>


    <!-- =========================================================
         THEME INITIALIZATION
    ========================================================== -->

    <script>
    (function () {

        try {

            const savedTheme =
                localStorage.getItem(
                    'sadra-theme'
                );


            const prefersDark =
                window.matchMedia(
                    '(prefers-color-scheme: dark)'
                ).matches;


            const theme =
                savedTheme === 'dark'
                    || savedTheme === 'light'
                    ? savedTheme
                    : prefersDark
                        ? 'dark'
                        : 'light';


            document.documentElement.dataset.theme =
                theme;

        } catch (
            error
        ) {

            document.documentElement.dataset.theme =
                'light';

        }

    })();
    </script>


    <!-- =========================================================
         THEME LOGO INITIALIZATION
    ========================================================== -->

    <script>
    (function () {

        try {

            const root =
                document.documentElement;


            document.addEventListener(
                'DOMContentLoaded',
                function () {

                    const logos =
                        document.querySelectorAll(
                            '[data-theme-logo]'
                        );


                    const updateLogos =
                        function () {

                            const currentTheme =
                                root.dataset.theme === 'dark'
                                    ? 'dark'
                                    : 'light';


                            logos.forEach(
                                function (
                                    logo
                                ) {

                                    const lightLogo =
                                        logo.getAttribute(
                                            'data-theme-logo-light'
                                        );


                                    const darkLogo =
                                        logo.getAttribute(
                                            'data-theme-logo-dark'
                                        );


                                    const nextLogo =
                                        currentTheme === 'dark'
                                            ? darkLogo
                                            : lightLogo;


                                    if (
                                        !nextLogo
                                    ) {

                                        return;

                                    }


                                    if (
                                        logo.getAttribute(
                                            'src'
                                        ) !== nextLogo
                                    ) {

                                        logo.setAttribute(
                                            'src',
                                            nextLogo
                                        );

                                    }

                                }
                            );

                        };


                    updateLogos();


                    const observer =
                        new MutationObserver(
                            function () {

                                updateLogos();

                            }
                        );


                    observer.observe(
                        root,
                        {
                            attributes: true,
                            attributeFilter: [
                                'data-theme'
                            ],
                        }
                    );

                }
            );

        } catch (
            error
        ) {

            /*
             * Logo switching must never interfere with
             * the rest of the application.
             */

        }

    })();
    </script>


    <!-- =========================================================
         PERSIAN HOMEPAGE FIRST-LOAD LOADER
    ========================================================== -->

    <?php if (
        $isPersianHomepage
    ): ?>

        <style>

            /*
            |--------------------------------------------------------------------------
            | Loader variables
            |--------------------------------------------------------------------------
            */

            :root {

                --sadra-loader-gold-1:
                    #f6cd76;

                --sadra-loader-gold-2:
                    #d9a53d;

                --sadra-loader-gold-3:
                    #8a5f14;

                --sadra-loader-navy:
                    #0c1f47;

            }


            /*
            |--------------------------------------------------------------------------
            | Loader
            |--------------------------------------------------------------------------
            */

            #sadra-page-loader {

                position:
                    fixed;

                inset:
                    0;

                z-index:
                    99999;

                display:
                    flex;

                align-items:
                    center;

                justify-content:
                    center;

                flex-direction:
                    column;

                background:
                    radial-gradient(
                        circle at 50% 42%,
                        #ffffff 0%,
                        #f8f2e4 62%,
                        #efe0bf 100%
                    );

                opacity:
                    1;

                visibility:
                    visible;

                pointer-events:
                    auto;

                transition:
                    opacity
                    .7s
                    ease,

                    visibility
                    .7s
                    ease,

                    background
                    .4s
                    ease;

            }


            /*
            |--------------------------------------------------------------------------
            | Dark loader
            |--------------------------------------------------------------------------
            */

            html[data-theme="dark"]
            #sadra-page-loader {

                background:
                    radial-gradient(
                        circle at 50% 42%,
                        #14161c 0%,
                        #0a0b10 62%,
                        #000000 100%
                    );

            }


            /*
            |--------------------------------------------------------------------------
            | Hide state
            |--------------------------------------------------------------------------
            */

            #sadra-page-loader.sadra-loader--hide {

                opacity:
                    0;

                visibility:
                    hidden;

                pointer-events:
                    none;

            }


            /*
            |--------------------------------------------------------------------------
            | Stage
            |--------------------------------------------------------------------------
            */

            .sadra-loader__stage {

                position:
                    relative;

                width:
                    min(
                        70vw,
                        320px
                    );

                height:
                    min(
                        73vw,
                        336px
                    );

                display:
                    flex;

                align-items:
                    center;

                justify-content:
                    center;

            }


            /*
            |--------------------------------------------------------------------------
            | Mark
            |--------------------------------------------------------------------------
            */

            .sadra-loader__mark {

                position:
                    relative;

                width:
                    88%;

                height:
                    88%;

                z-index:
                    1;

            }


            .sadra-loader__mark svg {

                display:
                    block;

                width:
                    100%;

                height:
                    100%;

                overflow:
                    visible;

            }


            /*
            |--------------------------------------------------------------------------
            | Paths
            |--------------------------------------------------------------------------
            */

            #sadra-loader-navy,
            #sadra-loader-gold {

                fill-opacity:
                    0;

                stroke-linecap:
                    round;

                stroke-linejoin:
                    round;

                stroke-width:
                    34;

                stroke-opacity:
                    1;

                stroke-dashoffset:
                    var(
                        --sadra-loader-path-length,
                        0
                    );

                transition:
                    stroke-dashoffset
                    var(
                        --sadra-loader-duration,
                        1.5s
                    )
                    linear
                    var(
                        --sadra-loader-delay,
                        0s
                    ),

                    fill-opacity
                    .7s
                    ease
                    var(
                        --sadra-loader-fill-delay,
                        1.6s
                    ),

                    stroke-opacity
                    .6s
                    ease
                    var(
                        --sadra-loader-fill-delay,
                        1.6s
                    );

            }


            /*
            |--------------------------------------------------------------------------
            | Navy
            |--------------------------------------------------------------------------
            */

            #sadra-loader-navy {

                stroke:
                    #0c1f47;

                --sadra-loader-duration:
                    1.5s;

                --sadra-loader-delay:
                    0s;

                --sadra-loader-fill-delay:
                    1.55s;

            }


            /*
            |--------------------------------------------------------------------------
            | Gold path
            |--------------------------------------------------------------------------
            */

            #sadra-loader-gold {

                stroke:
                    #131316;

                --sadra-loader-duration:
                    1.65s;

                --sadra-loader-delay:
                    .28s;

                --sadra-loader-fill-delay:
                    1.95s;

            }


            html[data-theme="dark"]
            #sadra-loader-gold {

                stroke:
                    #f6cd76;

            }


            html[data-theme="light"]
            #sadra-loader-gold {

                stroke:
                    #131316;

            }


            /*
            |--------------------------------------------------------------------------
            | Animation states
            |--------------------------------------------------------------------------
            */

            #sadra-loader-navy.sadra-loader--setup,
            #sadra-loader-gold.sadra-loader--setup {

                transition:
                    none !important;

            }


            #sadra-loader-navy.sadra-loader--drawn,
            #sadra-loader-gold.sadra-loader--drawn {

                stroke-dashoffset:
                    0;

            }


            #sadra-loader-navy.sadra-loader--filled,
            #sadra-loader-gold.sadra-loader--filled {

                fill-opacity:
                    1;

                stroke-opacity:
                    0;

            }


            /*
            |--------------------------------------------------------------------------
            | Shimmer
            |--------------------------------------------------------------------------
            |
            | A single soft shine that sweeps across the gold linework once
            | the fill has settled, stencilled through the mark's own mask
            | so it only ever shows inside the logo shape.
            |
            */

            #sadra-loader-shimmer {

                opacity:
                    0;

            }


            #sadra-loader-shimmer.sadra-loader--play {

                animation:
                    sadra-loader-sweep
                    1.4s
                    ease-in-out
                    .1s
                    1,

                    sadra-loader-shimmer-fade
                    1.4s
                    ease-in-out
                    .1s
                    1;

            }


            @keyframes sadra-loader-sweep {

                0% {

                    transform:
                        translate(
                            -500px,
                            420px
                        )
                        rotate(
                            28deg
                        );

                }

                100% {

                    transform:
                        translate(
                            950px,
                            -420px
                        )
                        rotate(
                            28deg
                        );

                }

            }


            @keyframes sadra-loader-shimmer-fade {

                0%,
                100% {

                    opacity:
                        0;

                }

                45%,
                55% {

                    opacity:
                        .5;

                }

            }


            /*
            |--------------------------------------------------------------------------
            | Label
            |--------------------------------------------------------------------------
            */

            .sadra-loader__label {

                margin-top:
                    22px;

                color:
                    #0c1f47;

                letter-spacing:
                    .35em;

                font-size:
                    11px;

                font-weight:
                    700;

                text-transform:
                    uppercase;

                opacity:
                    0;

                animation:
                    sadra-loader-fade-in
                    .6s
                    ease
                    .3s
                    forwards;

            }


            html[data-theme="dark"]
            .sadra-loader__label {

                color:
                    #f6cd76;

            }


            /*
            |--------------------------------------------------------------------------
            | Progress bar
            |--------------------------------------------------------------------------
            */

            .sadra-loader__bar {

                width:
                    120px;

                height:
                    2px;

                margin-top:
                    14px;

                overflow:
                    hidden;

                background:
                    rgba(
                        12,
                        31,
                        71,
                        .14
                    );

                border-radius:
                    2px;

                opacity:
                    0;

                animation:
                    sadra-loader-fade-in
                    .6s
                    ease
                    .3s
                    forwards;

            }


            html[data-theme="dark"]
            .sadra-loader__bar {

                background:
                    rgba(
                        246,
                        205,
                        118,
                        .18
                    );

            }


            .sadra-loader__bar::after {

                content:
                    "";

                display:
                    block;

                width:
                    40%;

                height:
                    100%;

                background:
                    linear-gradient(
                        90deg,
                        #d9a53d,
                        #f6cd76
                    );

                animation:
                    sadra-loader-bar-sweep
                    1.2s
                    ease-in-out
                    infinite;

            }


            /*
            |--------------------------------------------------------------------------
            | Keyframes
            |--------------------------------------------------------------------------
            */

            @keyframes sadra-loader-fade-in {

                to {

                    opacity:
                        1;

                }

            }


            @keyframes sadra-loader-bar-sweep {

                0% {

                    transform:
                        translateX(
                            -120%
                        );

                }

                100% {

                    transform:
                        translateX(
                            340%
                        );

                }

            }


            /*
            |--------------------------------------------------------------------------
            | Small screens
            |--------------------------------------------------------------------------
            */

            @media (max-width: 500px) {

                .sadra-loader__stage {

                    width:
                        min(
                            82vw,
                            280px
                        );

                    height:
                        min(
                            85vw,
                            300px
                        );

                }


                .sadra-loader__label {

                    font-size:
                        10px;

                }

            }


            /*
            |--------------------------------------------------------------------------
            | Reduced motion
            |--------------------------------------------------------------------------
            */

            @media (prefers-reduced-motion: reduce) {

                #sadra-loader-navy,
                #sadra-loader-gold {

                    transition:
                        none !important;

                    fill-opacity:
                        1;

                    stroke-opacity:
                        0;

                    stroke-dashoffset:
                        0 !important;

                }


                #sadra-loader-shimmer {

                    animation:
                        none !important;

                    opacity:
                        0;

                }


                .sadra-loader__label {

                    animation:
                        none !important;

                    opacity:
                        1;

                }


                .sadra-loader__bar {

                    animation:
                        none !important;

                    opacity:
                        1;

                }


                .sadra-loader__bar::after {

                    animation:
                        none !important;

                    width:
                        60%;

                }

            }

        </style>

    <?php endif; ?>


    <!-- =========================================================
         GLOBAL PUBLIC CSS
    ========================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::escape(
            $appCss
        ) ?>"
    >


    <!-- =========================================================
         ANNOUNCEMENTS
    ========================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::escape(
            $announcementsCss
        ) ?>"
    >


    <!-- =========================================================
         HOMEPAGE
    ========================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::escape(
            $homeCss
        ) ?>"
    >


    <!-- =========================================================
         TEACHER
    ========================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::escape(
            $teacherCss
        ) ?>"
    >


    <!-- =========================================================
         INSTITUTIONAL / ACADEMIC PAGES
    ========================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::escape(
            $institutionCss
        ) ?>"
    >


    <!-- =========================================================
         PUBLIC DOCUMENTS
    ========================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::escape(
            $documentsCss
        ) ?>"
    >


    <!-- =========================================================
         SEARCH
    ========================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::escape(
            $searchCss
        ) ?>"
    >

</head>


<body>


<?php if (
    $isPersianHomepage
): ?>

    <!-- =========================================================
         PERSIAN HOMEPAGE LOADER
    ========================================================== -->

    <div
        id="sadra-page-loader"
        aria-label="در حال بارگذاری"
        role="status"
    >

        <div class="sadra-loader__stage">

            <div class="sadra-loader__mark">

                <svg
                    viewBox="0 0 992 1040"
                    aria-hidden="true"
                    focusable="false"
                >

                    <defs>

                        <linearGradient
                            id="sadra-loader-gold-gradient"
                            x1="0%"
                            y1="0%"
                            x2="100%"
                            y2="100%"
                        >

                            <stop
                                offset="0%"
                                stop-color="#f6cd76"
                            />

                            <stop
                                offset="55%"
                                stop-color="#d9a53d"
                            />

                            <stop
                                offset="100%"
                                stop-color="#8a5f14"
                            />

                        </linearGradient>


                        <mask
                            id="sadra-loader-gold-mask"
                            maskUnits="userSpaceOnUse"
                            x="0"
                            y="0"
                            width="992"
                            height="1040"
                        >

                            <g
                                transform="translate(0.000000,1040.000000) scale(0.100000,-0.100000)"
                            >

                                <path
                                    d="M4924 8858 c-49 -51 -288 -295 -532 -543 l-443 -450 -757 -5 -757 -5
-3 -657 c-1 -469 1 -658 9 -658 6 0 54 35 108 78 53 42 132 100 174 127 l77
50 0 140 c0 77 3 231 7 343 l6 202 226 -2 226 -3 -4 -229 -3 -228 38 5 c22 2
83 16 138 30 54 14 122 29 152 33 l54 6 2 192 3 191 225 5 225 5 235 240 c508
520 685 695 700 695 20 0 230 -210 230 -230 0 -8 -18 -23 -40 -33 -59 -27
-467 -469 -634 -687 -93 -121 -182 -254 -235 -352 -24 -43 -46 -80 -51 -83 -4
-2 -43 3 -86 12 -117 24 -457 24 -579 0 -419 -83 -676 -193 -980 -420 -344
-256 -567 -512 -727 -832 -190 -380 -267 -882 -202 -1320 69 -470 230 -846
507 -1190 93 -115 300 -312 414 -393 327 -233 634 -364 1023 -433 79 -15 458
-19 540 -7 l45 6 20 -41 c29 -60 90 -90 164 -82 29 4 71 13 93 21 70 25 67 39
61 -223 -5 -235 -4 -239 19 -282 12 -25 40 -59 61 -75 34 -27 48 -31 117 -34
271 -13 610 201 817 516 30 45 60 82 67 82 7 0 25 -13 41 -30 65 -68 164 -80
251 -31 59 34 136 115 196 206 23 36 45 65 48 65 3 0 30 -7 60 -15 71 -19 207
-19 289 0 270 64 598 354 848 749 144 228 276 542 321 764 l18 93 145 147
c632 642 859 878 859 893 0 10 -249 265 -560 575 l-560 558 0 773 0 773 -742
0 -743 0 -549 545 c-302 300 -556 545 -566 545 -9 0 -57 -42 -106 -92z m376
-1417 l0 -560 -118 -95 c-251 -201 -387 -386 -442 -600 -35 -139 -23 -330 28
-462 11 -27 75 -161 143 -299 69 -137 141 -300 161 -360 84 -249 120 -512 100
-732 -35 -388 -156 -673 -373 -879 -71 -66 -189 -154 -209 -154 -10 0 -11 35
-6 168 11 263 33 543 42 551 5 5 32 14 59 20 242 59 338 309 251 653 -46 183
-126 344 -349 713 -77 127 -162 275 -188 330 -109 227 -142 460 -104 717 60
394 222 709 590 1138 133 156 382 410 401 410 12 0 14 -80 14 -559z"
                                    fill="#ffffff"
                                />

                            </g>

                        </mask>


                        <linearGradient
                            id="sadra-loader-shimmer-gradient"
                            x1="0"
                            y1="0"
                            x2="0"
                            y2="1"
                        >

                            <stop
                                offset="0%"
                                stop-color="#fffdf6"
                                stop-opacity="0"
                            />

                            <stop
                                offset="45%"
                                stop-color="#fffdf6"
                                stop-opacity="0"
                            />

                            <stop
                                offset="50%"
                                stop-color="#fffdf6"
                                stop-opacity="1"
                            />

                            <stop
                                offset="55%"
                                stop-color="#fffdf6"
                                stop-opacity="0"
                            />

                            <stop
                                offset="100%"
                                stop-color="#fffdf6"
                                stop-opacity="0"
                            />

                        </linearGradient>

                    </defs>


                    <g>

                        <g
                            transform="translate(0.000000,1040.000000) scale(0.100000,-0.100000)"
                        >

                            <path
                                id="sadra-loader-navy"
                                d="M4885 8251 c-97 -97 -329 -336 -477 -492 -15 -16 -34 -29 -43 -29 -8
0 -15 -5 -15 -10 0 -17 -55 -76 -198 -211 l-62 -59 -179 0 c-200 0 -237 -7
-246 -49 -3 -16 -5 -96 -3 -179 l3 -151 175 6 c116 4 212 1 285 -7 181 -22
172 -24 207 40 80 144 216 337 357 505 91 108 374 416 460 500 38 37 61 68 61
81 0 14 -26 50 -67 93 -53 55 -76 73 -103 77 -34 5 -39 1 -155 -115z M5155
7868 c-505 -516 -752 -909 -837 -1331 -33 -164 -32 -433 1 -562 37 -141 105
-280 271 -555 218 -362 311 -551 362 -739 31 -113 31 -321 -1 -410 -24 -68
-64 -133 -102 -165 -33 -27 -115 -67 -167 -80 -44 -10 -47 -14 -54 -51 -7 -40
-38 -545 -38 -617 0 -25 5 -38 14 -38 7 0 43 22 79 50 187 141 328 335 393
539 75 235 104 469 84 686 -28 299 -96 510 -281 870 -132 257 -161 343 -167
505 -4 106 -1 139 17 210 55 221 205 424 459 623 l102 80 0 543 c0 509 -1 544
-17 544 -10 0 -63 -46 -118 -102z M5533 7843 l-23 -4 0 -240 c0 -184 3 -248
14 -273 12 -28 269 -292 310 -318 6 -4 224 -8 484 -8 l472 0 10 -24 c5 -13 10
-245 12 -514 l3 -491 544 -538 c299 -296 553 -542 564 -548 18 -8 35 6 144
119 99 104 123 134 123 157 0 22 -5 29 -20 29 -13 0 -22 9 -26 25 -3 14 -10
25 -15 25 -5 0 -9 7 -9 15 0 8 -8 15 -18 15 -10 0 -31 18 -48 40 -16 22 -35
40 -41 40 -7 0 -13 7 -13 16 0 12 -53 74 -64 74 -1 0 -235 224 -248 238 -113
121 -387 392 -396 392 -7 0 -12 6 -12 14 0 8 -8 22 -17 32 -17 16 -18 64 -21
663 l-3 646 -27 13 c-20 9 -165 12 -616 12 -559 0 -593 1 -621 19 -16 10 -112
100 -212 200 -100 99 -188 180 -195 180 -7 -1 -23 -4 -35 -6z M2859 7443 c-25
-4 -26 -6 -32 -101 -4 -53 -7 -202 -7 -329 0 -200 -2 -233 -15 -233 -8 0 -15
-7 -15 -15 0 -15 26 -21 32 -7 11 25 393 199 476 217 46 10 42 35 -5 32 l-38
-2 -3 216 -2 216 -38 7 c-39 6 -309 6 -353 -1z M3540 7055 c0 -8 7 -15 15 -15
8 0 15 7 15 15 0 8 -7 15 -15 15 -8 0 -15 -7 -15 -15z M3870 6977 c0 -9 30
-17 98 -25 130 -16 161 -16 169 4 10 27 -17 34 -144 34 -95 0 -123 -3 -123
-13z M3338 6878 c-70 -15 -60 -33 25 -46 172 -28 248 -44 350 -72 59 -17 113
-28 120 -24 43 26 117 88 117 99 0 9 -42 16 -147 24 -82 7 -166 14 -188 16
-103 11 -234 13 -277 3z M4115 6783 c-11 -3 -33 -15 -50 -27 -16 -12 -47 -30
-67 -41 -21 -11 -38 -25 -38 -33 0 -15 149 -85 167 -78 7 3 13 14 13 24 0 10
9 45 20 77 11 32 20 64 20 72 0 13 -26 15 -65 6z M2958 6747 c-10 -8 -18 -18
-18 -24 0 -10 71 -43 135 -62 52 -16 74 -26 235 -105 74 -37 141 -66 148 -66
22 0 202 130 202 146 0 8 -6 14 -12 14 -7 0 -35 9 -63 19 -47 18 -110 32 -295
65 -122 22 -312 29 -332 13z M2733 6735 c-3 -9 -3 -18 0 -22 10 -10 37 6 37
22 0 20 -29 20 -37 0z M2670 6685 c0 -8 7 -15 15 -15 8 0 15 7 15 15 0 8 -7
15 -15 15 -8 0 -15 -7 -15 -15z M5380 6654 c0 -17 -6 -24 -19 -24 -12 0 -21
-9 -25 -24 -3 -14 -15 -28 -26 -31 -11 -3 -20 -10 -20 -15 0 -5 -20 -19 -45
-30 -25 -11 -45 -25 -45 -30 0 -6 -6 -10 -14 -10 -8 0 -23 -13 -33 -30 -9 -16
-21 -30 -25 -30 -4 0 -8 -9 -8 -20 0 -11 -6 -20 -14 -20 -8 0 -16 -12 -18 -27
-2 -21 -10 -29 -35 -37 -27 -7 -33 -14 -33 -37 0 -16 -4 -29 -10 -29 -5 0 -10
-11 -10 -23 0 -13 -8 -33 -18 -45 -10 -12 -25 -46 -32 -77 -7 -30 -17 -55 -22
-55 -21 0 -2 -206 24 -245 3 -6 9 -27 13 -48 4 -20 11 -37 16 -37 5 0 9 -7 9
-15 0 -19 62 -159 72 -163 4 -2 8 -11 8 -21 0 -9 9 -27 20 -39 11 -12 20 -26
20 -33 0 -6 19 -52 43 -103 24 -50 52 -115 62 -143 11 -29 23 -53 27 -53 4 0
8 -10 8 -23 0 -13 9 -42 20 -65 11 -22 20 -52 20 -64 0 -13 9 -41 20 -63 11
-22 20 -59 20 -85 0 -25 5 -57 12 -71 11 -23 15 -24 109 -24 92 0 100 -2 140
-30 73 -51 90 -99 97 -267 9 -250 5 -368 -15 -368 -7 0 -13 -7 -13 -15 0 -10
11 -15 35 -15 20 0 35 5 35 11 0 9 20 10 66 6 137 -13 214 -97 214 -234 l0
-43 40 0 c22 0 40 3 40 8 0 17 86 105 126 128 47 28 110 35 181 21 41 -8 42
-8 63 30 12 21 31 53 43 70 12 18 55 83 96 145 213 324 452 525 699 588 23 6
42 15 42 19 0 16 -25 56 -55 86 -17 17 -45 47 -63 68 -18 20 -37 37 -41 37 -5
0 -19 16 -31 35 -12 19 -26 35 -32 35 -13 0 -58 47 -58 61 0 5 -5 9 -11 9 -10
0 -139 129 -139 139 0 4 -11 14 -24 24 -20 15 -120 112 -151 147 -5 6 -42 41
-81 78 -39 37 -78 79 -88 95 -10 15 -25 27 -32 27 -8 0 -14 4 -14 8 0 5 -25
35 -55 67 l-55 58 0 316 c0 351 -5 416 -29 428 -9 4 -162 9 -341 11 l-325 3
-77 37 c-43 20 -78 41 -78 47 -1 25 -47 43 -113 43 -64 0 -67 -2 -67 -24z
M2630 6655 c0 -8 7 -15 15 -15 8 0 15 7 15 15 0 8 -7 15 -15 15 -8 0 -15 -7
-15 -15z M2590 6625 c0 -8 7 -15 15 -15 8 0 15 7 15 15 0 8 -7 15 -15 15 -8 0
-15 -7 -15 -15z M2756 6619 c-14 -11 -26 -27 -26 -36 0 -8 29 -53 65 -99 36
-46 65 -89 65 -94 0 -6 3 -10 8 -10 4 0 40 -43 81 -95 67 -86 102 -113 113
-87 4 11 163 122 174 122 21 1 86 70 82 86 -4 22 -148 98 -343 179 -35 15
-169 54 -186 55 -4 0 -18 -9 -33 -21z M2550 6595 c0 -8 7 -15 15 -15 8 0 15 7
15 15 0 8 -7 15 -15 15 -8 0 -15 -7 -15 -15z M3773 6557 c-15 -13 -53 -39 -83
-57 -74 -47 -90 -61 -90 -82 0 -11 42 -46 118 -97 64 -44 151 -104 192 -135
41 -31 84 -56 94 -56 11 0 34 11 52 25 28 21 33 32 33 63 -1 20 2 85 6 143 l8
106 -74 36 c-101 49 -175 77 -204 77 -13 0 -36 -10 -52 -23z M2540 6459 c-25
-21 -25 -23 -24 -173 1 -201 33 -456 56 -456 19 0 298 231 298 246 0 23 -18
54 -66 111 -24 28 -44 55 -44 61 0 5 -9 17 -19 26 -18 16 -94 121 -131 182
-18 29 -37 30 -70 3z M2361 6273 c-68 -185 -141 -713 -98 -713 6 0 52 37 100
83 l89 82 -21 121 c-16 93 -21 164 -21 303 0 147 -3 181 -14 181 -7 0 -23 -26
-35 -57z M3405 6299 c-22 -12 -62 -38 -90 -58 -53 -40 -122 -87 -167 -115 -16
-9 -28 -24 -28 -34 0 -22 287 -352 306 -352 8 0 109 63 224 140 187 125 239
169 198 170 -7 0 -39 25 -71 55 -31 30 -63 55 -69 55 -6 0 -18 7 -27 15 -28
27 -94 75 -102 75 -5 0 -17 8 -27 18 -24 23 -77 52 -94 52 -7 0 -31 -9 -53
-21z M2181 6096 c-12 -18 -21 -43 -21 -55 0 -11 -4 -21 -10 -21 -5 0 -10 -8
-10 -18 0 -11 -16 -63 -36 -117 -20 -54 -43 -123 -51 -154 -8 -31 -21 -81 -29
-111 -13 -50 -54 -285 -54 -310 0 -24 30 -6 87 53 l61 62 6 120 c6 136 32 292
71 440 15 55 29 110 32 123 8 35 -22 27 -46 -12z M2889 5938 c-24 -17 -53 -40
-64 -51 -11 -10 -31 -26 -45 -35 -91 -60 -180 -139 -180 -161 0 -20 36 -150
61 -216 10 -27 33 -90 50 -138 18 -49 38 -91 45 -94 7 -2 75 44 151 104 76 59
182 141 236 181 104 78 113 95 74 134 -12 13 -52 61 -88 108 -37 47 -77 96
-89 110 -12 14 -34 40 -47 58 -32 40 -49 40 -104 0z M3965 5899 c-16 -5 -43
-20 -60 -35 -16 -14 -43 -33 -60 -41 -16 -9 -33 -20 -36 -25 -3 -5 -19 -17
-36 -26 -43 -25 -86 -51 -156 -98 -90 -58 -88 -66 34 -199 56 -60 171 -190
257 -287 85 -98 162 -178 171 -178 17 0 274 189 321 235 23 23 23 27 11 62
-19 57 -40 101 -51 108 -6 3 -10 17 -10 31 0 13 -3 24 -8 24 -4 0 -15 18 -25
40 -9 22 -24 40 -32 40 -9 0 -15 9 -15 25 0 14 -3 25 -7 25 -11 0 -33 50 -33
72 0 10 -9 23 -20 30 -11 7 -20 21 -20 30 0 10 -6 18 -12 18 -7 1 -24 15 -38
32 -42 53 -121 128 -133 127 -7 0 -25 -5 -42 -10z M1921 5651 c-17 -43 -42
-112 -55 -153 -27 -78 -76 -308 -76 -352 0 -35 22 -34 53 3 19 23 25 45 30
105 9 105 42 263 78 369 33 101 34 107 15 107 -9 0 -27 -31 -45 -79z M2343
5488 l-103 -92 0 -63 c0 -173 54 -493 83 -493 12 0 281 251 285 266 2 6 -16
67 -38 135 -23 68 -46 147 -52 174 -6 28 -14 55 -18 60 -4 6 -11 31 -14 58 -5
35 -12 47 -24 47 -9 0 -63 -41 -119 -92z M3315 5478 c-11 -6 -27 -19 -35 -28
-8 -8 -49 -40 -90 -70 -41 -29 -77 -56 -80 -59 -3 -3 -52 -42 -110 -85 -58
-43 -110 -84 -115 -90 -6 -6 -19 -16 -30 -22 -46 -26 -44 -36 43 -208 83 -165
185 -337 268 -453 32 -45 51 -63 67 -63 13 0 116 70 248 168 124 92 265 195
313 230 48 35 90 70 93 78 3 9 -9 29 -33 52 -38 36 -51 51 -102 117 -30 37
-118 140 -154 178 -16 16 -28 32 -28 37 0 4 -7 14 -17 21 -9 8 -54 58 -100
112 -46 53 -92 97 -101 97 -9 0 -26 -6 -37 -12z M2020 5178 l-72 -73 6 -135
c11 -227 43 -430 68 -430 7 0 47 37 90 83 68 72 78 87 78 119 0 20 -5 49 -11
64 -12 34 -45 249 -54 362 -5 55 -11 82 -20 82 -6 0 -45 -33 -85 -72z M4474
5031 c-12 -5 -33 -21 -47 -35 -14 -14 -32 -26 -40 -26 -7 0 -20 -11 -27 -25
-7 -14 -19 -25 -26 -25 -7 0 -19 -6 -26 -12 -7 -7 -31 -23 -53 -35 -22 -12
-41 -28 -43 -35 -1 -7 53 -88 122 -180 68 -92 162 -226 208 -298 93 -145 96
-147 178 -107 44 22 44 22 63 107 16 74 17 96 8 171 -6 48 -18 100 -26 115 -8
16 -15 46 -15 67 0 25 -5 37 -14 37 -7 0 -16 14 -19 30 -4 18 -13 30 -22 30
-10 0 -15 10 -15 29 0 39 -9 61 -25 61 -14 0 -35 50 -35 81 0 11 -6 19 -14 19
-8 0 -22 7 -30 16 -19 19 -74 27 -102 15z M1790 4945 c-23 -25 -24 -32 -23
-163 0 -130 8 -213 34 -364 14 -80 28 -86 77 -35 37 38 40 67 17 162 -18 71
-45 297 -45 373 0 44 -3 52 -18 52 -10 0 -29 -11 -42 -25z M2627 4922 c-15
-10 -81 -69 -147 -132 -104 -98 -120 -117 -120 -145 0 -108 264 -685 314 -685
7 0 79 51 158 113 233 181 226 173 188 217 -11 13 -20 27 -20 31 0 4 -6 14
-13 21 -6 7 -23 34 -36 61 -13 26 -28 47 -33 47 -4 0 -8 9 -8 20 0 11 -4 20
-9 20 -5 0 -11 8 -14 18 -6 18 -38 73 -48 82 -3 3 -16 30 -28 60 -13 30 -41
91 -61 135 -21 44 -45 97 -54 118 -17 42 -29 45 -69 19z M3978 4667 c-7 -8
-24 -20 -38 -27 -14 -7 -33 -24 -43 -37 -10 -12 -24 -23 -31 -23 -7 0 -23 -8
-35 -17 -49 -40 -69 -56 -136 -103 -38 -27 -75 -53 -80 -57 -6 -4 -34 -24 -63
-43 -28 -19 -52 -38 -52 -41 0 -4 -13 -12 -30 -19 -16 -7 -30 -16 -30 -21 0
-4 -12 -14 -27 -21 -51 -24 -43 -56 35 -139 125 -134 490 -449 520 -449 15 0
78 46 267 194 156 122 165 130 165 145 0 6 7 11 16 11 16 0 44 56 44 89 0 11
-7 26 -15 35 -8 8 -15 19 -15 24 0 6 -7 12 -15 16 -8 3 -15 14 -15 25 0 11 -6
26 -12 33 -7 8 -17 21 -23 30 -12 19 -101 143 -115 161 -44 54 -60 76 -60 82
0 7 -36 51 -114 138 -27 30 -75 37 -98 14z M7280 4603 c-197 -67 -412 -269
-597 -563 -22 -36 -85 -140 -139 -232 -116 -196 -124 -202 -167 -109 -15 32
-33 63 -40 70 -20 16 -76 2 -93 -23 -22 -35 -51 -128 -63 -203 -28 -181 -108
-378 -187 -463 -40 -43 -52 -50 -85 -50 -84 0 -110 71 -117 320 -3 128 1 219
14 338 16 151 16 164 1 179 -13 13 -21 14 -40 6 -19 -9 -28 -28 -45 -90 -91
-333 -108 -383 -179 -533 -109 -227 -292 -445 -483 -575 -85 -58 -271 -155
-297 -155 -27 0 -33 -56 -33 -330 0 -277 0 -279 22 -294 12 -9 41 -16 64 -16
52 0 182 33 249 64 141 64 312 213 408 355 55 82 130 229 157 306 20 59 44 70
61 28 71 -171 121 -243 171 -243 61 0 176 129 258 290 25 48 26 48 149 6 121
-42 249 -30 396 38 207 96 432 323 623 630 192 307 296 586 324 865 13 134 -1
255 -33 293 -11 11 -19 25 -19 29 0 5 -19 22 -42 39 -39 28 -46 30 -132 29
-50 0 -98 -3 -106 -6z m-47 -774 c80 -12 127 -32 127 -53 0 -16 -159 -166
-175 -166 -5 0 -23 -12 -40 -28 -48 -44 -193 -137 -290 -185 -132 -67 -237
-99 -292 -91 -88 13 -94 50 -24 155 120 183 329 328 526 364 90 17 84 17 168
4z M7084 3732 c-6 -4 -14 -26 -18 -49 -8 -54 6 -56 66 -10 60 46 62 67 6 67
-24 0 -48 -4 -54 -8z M7003 3615 c-3 -9 -3 -18 0 -22 10 -10 37 6 37 22 0 20
-29 20 -37 0z M6910 3545 c0 -8 7 -15 15 -15 8 0 15 7 15 15 0 8 -7 15 -15 15
-8 0 -15 -7 -15 -15z M6642 3460 c-34 -46 -30 -64 14 -57 20 3 38 8 40 10 8 8
-10 77 -20 77 -7 0 -22 -13 -34 -30z M5427 4538 c-8 -13 -22 -57 -32 -98 -71
-307 -170 -563 -292 -752 -155 -242 -310 -386 -541 -502 -81 -41 -77 -32 -92
-191 -34 -369 -41 -466 -34 -476 18 -30 204 36 322 114 109 72 264 231 345
353 226 341 358 851 369 1429 3 124 1 140 -14 143 -9 2 -23 -7 -31 -20z M2142
4456 c-64 -66 -82 -91 -82 -114 0 -31 27 -121 41 -136 5 -6 9 -18 9 -28 0 -36
112 -290 182 -410 26 -46 45 -68 58 -68 10 0 53 28 96 63 42 34 86 70 98 79
l21 17 -20 38 c-11 21 -22 40 -25 43 -6 6 -31 51 -67 120 -15 30 -31 57 -35
58 -5 2 -8 7 -8 12 0 4 -16 43 -37 86 -20 44 -50 120 -68 169 -42 120 -58 155
-71 155 -6 0 -47 -38 -92 -84z M1897 4222 c-20 -21 -37 -46 -37 -55 0 -50 85
-273 160 -422 71 -140 106 -195 125 -195 21 0 95 50 95 64 0 9 -66 149 -184
386 -12 25 -38 93 -57 152 -24 76 -39 108 -49 108 -9 0 -33 -17 -53 -38z
M3130 4060 c0 -5 -12 -16 -27 -24 -16 -8 -41 -27 -58 -44 -27 -26 -82 -67
-207 -154 -26 -18 -47 -40 -48 -49 0 -22 164 -202 266 -291 171 -147 305 -243
328 -235 22 9 208 134 299 201 65 48 78 62 73 80 -3 11 -6 24 -6 28 0 4 -10
10 -22 14 -28 8 -144 100 -249 197 -17 15 -32 27 -33 27 -7 0 -206 204 -206
211 0 11 -76 48 -97 49 -7 0 -13 -4 -13 -10z M4341 3735 c-25 -14 -49 -31 -53
-39 -4 -7 -19 -17 -33 -20 -14 -4 -25 -11 -25 -16 0 -6 -4 -10 -10 -10 -5 0
-18 -8 -29 -17 -29 -28 -64 -53 -73 -53 -17 0 -7 -27 20 -51 48 -45 180 -129
200 -129 16 0 21 11 31 63 7 34 19 87 27 118 18 70 19 179 2 179 -7 -1 -33
-12 -57 -25z M2639 3680 c-15 -4 -36 -16 -47 -26 -56 -54 -80 -72 -109 -88
-18 -9 -33 -23 -33 -30 0 -52 300 -357 474 -481 l69 -49 41 23 c23 13 78 49
124 79 77 52 102 82 67 82 -8 0 -25 10 -38 23 -49 45 -87 77 -93 77 -3 0 -11
6 -18 13 -8 6 -48 44 -91 82 -42 39 -96 90 -119 114 -102 110 -123 132 -147
161 -28 31 -37 34 -80 20z M2320 3437 c-26 -12 -59 -46 -60 -60 -2 -50 282
-332 446 -444 31 -21 62 -42 70 -48 16 -11 104 32 104 51 0 12 -42 50 -124
114 -85 66 -238 220 -344 348 -45 55 -52 58 -92 39z M3860 3398 c-19 -11 -43
-29 -53 -39 -21 -22 -118 -87 -157 -105 -37 -17 -110 -77 -110 -90 0 -32 428
-213 504 -214 16 0 82 34 96 50 3 3 32 25 65 49 33 25 63 49 67 55 14 19 9 66
-6 66 -8 0 -24 16 -36 35 -12 19 -28 35 -36 35 -8 0 -14 7 -14 15 0 8 -7 15
-15 15 -8 0 -15 5 -15 10 0 6 -7 10 -15 10 -8 0 -15 4 -15 8 0 5 -18 18 -40
31 -22 12 -40 26 -40 31 0 5 -11 12 -25 16 -14 3 -25 9 -25 13 0 12 -48 31
-73 30 -12 0 -38 -10 -57 -21z M3330 3054 c-8 -9 -46 -36 -85 -61 -70 -46 -85
-59 -85 -78 0 -35 416 -205 503 -205 32 0 114 40 186 92 31 22 23 68 -12 68
-26 0 -77 21 -77 33 0 4 -15 7 -34 7 -19 0 -36 3 -38 8 -1 4 -30 18 -63 31
-33 14 -66 31 -73 38 -7 7 -22 13 -32 13 -10 0 -31 11 -47 23 -15 13 -41 27
-58 30 -16 4 -39 9 -50 11 -11 3 -27 -2 -35 -10z M2988 2823 c-50 -31 -35 -50
87 -111 164 -81 375 -144 415 -122 32 17 24 33 -28 56 -103 47 -120 54 -127
54 -20 0 -207 94 -240 120 -23 19 -80 20 -107 3z M4065 2783 c-11 -3 -26 -10
-34 -16 -15 -13 -37 -26 -98 -57 -48 -24 -55 -45 -20 -56 22 -8 284 -11 291
-3 2 2 2 24 -1 49 -5 42 -9 47 -52 68 -47 23 -51 23 -86 15z M3687 2564 c-4
-4 -7 -15 -7 -24 0 -21 54 -30 186 -30 77 0 94 3 94 15 0 8 -6 15 -12 16 -7 0
-47 5 -88 10 -144 19 -165 21 -173 13z"
                                fill="#0c1f47"
                            />


                            <path
                                id="sadra-loader-gold"
                                d="M4924 8858 c-49 -51 -288 -295 -532 -543 l-443 -450 -757 -5 -757 -5
-3 -657 c-1 -469 1 -658 9 -658 6 0 54 35 108 78 53 42 132 100 174 127 l77
50 0 140 c0 77 3 231 7 343 l6 202 226 -2 226 -3 -4 -229 -3 -228 38 5 c22 2
83 16 138 30 54 14 122 29 152 33 l54 6 2 192 3 191 225 5 225 5 235 240 c508
520 685 695 700 695 20 0 230 -210 230 -230 0 -8 -18 -23 -40 -33 -59 -27
-467 -469 -634 -687 -93 -121 -182 -254 -235 -352 -24 -43 -46 -80 -51 -83 -4
-2 -43 3 -86 12 -117 24 -457 24 -579 0 -419 -83 -676 -193 -980 -420 -344
-256 -567 -512 -727 -832 -190 -380 -267 -882 -202 -1320 69 -470 230 -846
507 -1190 93 -115 300 -312 414 -393 327 -233 634 -364 1023 -433 79 -15 458
-19 540 -7 l45 6 20 -41 c29 -60 90 -90 164 -82 29 4 71 13 93 21 70 25 67 39
61 -223 -5 -235 -4 -239 19 -282 12 -25 40 -59 61 -75 34 -27 48 -31 117 -34
271 -13 610 201 817 516 30 45 60 82 67 82 7 0 25 -13 41 -30 65 -68 164 -80
251 -31 59 34 136 115 196 206 23 36 45 65 48 65 3 0 30 -7 60 -15 71 -19 207
-19 289 0 270 64 598 354 848 749 144 228 276 542 321 764 l18 93 145 147
c632 642 859 878 859 893 0 10 -249 265 -560 575 l-560 558 0 773 0 773 -742
0 -743 0 -549 545 c-302 300 -556 545 -566 545 -9 0 -57 -42 -106 -92z m376
-1417 l0 -560 -118 -95 c-251 -201 -387 -386 -442 -600 -35 -139 -23 -330 28
-462 11 -27 75 -161 143 -299 69 -137 141 -300 161 -360 84 -249 120 -512 100
-732 -35 -388 -156 -673 -373 -879 -71 -66 -189 -154 -209 -154 -10 0 -11 35
-6 168 11 263 33 543 42 551 5 5 32 14 59 20 242 59 338 309 251 653 -46 183
-126 344 -349 713 -77 127 -162 275 -188 330 -109 227 -142 460 -104 717 60
394 222 709 590 1138 133 156 382 410 401 410 12 0 14 -80 14 -559z m449 274
l233 -235 639 0 639 0 0 -668 0 -669 485 -482 c267 -265 485 -487 485 -492 0
-17 -283 -310 -296 -307 -7 2 -138 127 -291 278 -154 151 -405 398 -558 549
l-280 274 -5 506 -5 506 -482 5 c-265 3 -484 7 -487 10 -3 3 -79 79 -170 169
l-166 163 0 314 c0 255 3 314 13 314 8 0 118 -106 246 -235z m-1601 -721 c32
-9 27 -29 -12 -53 -29 -18 -40 -20 -87 -11 -101 17 -248 30 -348 30 -80 0
-101 3 -101 14 0 11 20 16 78 21 42 3 84 8 92 10 21 6 350 -4 378 -11z m-418
-103 c154 -14 260 -32 260 -45 0 -6 -17 -22 -37 -36 -21 -14 -58 -40 -82 -59
-43 -32 -47 -33 -86 -23 -194 56 -358 89 -532 107 -43 5 -63 11 -63 20 0 38
300 57 540 36z m466 -84 c3 -2 -7 -44 -21 -92 -14 -48 -25 -96 -25 -106 0 -26
-29 -24 -93 4 -29 13 -67 30 -84 38 -18 8 -33 21 -33 29 1 8 40 43 88 77 77
55 91 62 125 59 21 -3 41 -6 43 -9z m-1031 -42 c183 -12 536 -90 535 -119 -1
-15 -224 -166 -245 -166 -9 0 -62 24 -118 54 -112 59 -206 100 -337 145 -47
16 -86 35 -88 43 -5 24 68 58 113 53 22 -2 85 -7 140 -10z m2375 -56 c43 -39
95 -83 115 -97 l38 -27 363 2 364 2 0 -392 0 -392 490 -490 c270 -269 490
-495 490 -501 0 -7 -25 -15 -56 -19 -211 -26 -443 -194 -651 -470 -70 -93
-235 -347 -246 -378 -3 -9 -11 -9 -39 1 -47 17 -121 15 -166 -4 -89 -37 -148
-132 -187 -302 -59 -252 -78 -312 -101 -312 -22 0 -18 119 12 361 24 201 25
214 9 255 -20 54 -82 111 -130 120 -51 9 -120 -2 -166 -28 -21 -12 -41 -19
-44 -16 -3 2 0 52 6 109 6 57 12 197 13 310 l1 207 -31 38 c-54 68 -165 90
-247 49 -42 -21 -45 -20 -52 23 -36 227 -102 418 -255 732 -142 293 -156 328
-172 442 -27 193 45 384 212 562 62 66 326 286 343 286 5 0 44 -32 87 -71z
m-2585 -97 c129 -48 399 -183 402 -202 3 -15 -303 -230 -326 -230 -20 0 -321
387 -321 414 0 8 17 27 38 41 45 31 64 29 207 -23z m982 -46 c43 -18 102 -45
132 -60 l54 -28 -7 -75 c-3 -42 -6 -110 -6 -152 l-1 -76 -47 -32 c-27 -18 -52
-33 -56 -33 -4 0 -69 44 -144 98 -76 53 -172 120 -215 147 -44 29 -77 57 -77
67 0 23 227 177 262 178 14 0 62 -15 105 -34z m-1318 -98 c11 -18 76 -109 145
-203 69 -93 126 -177 126 -185 0 -19 -291 -253 -319 -258 -16 -3 -20 7 -29 60
-27 156 -36 254 -36 404 l-1 161 30 26 c40 35 59 34 84 -5z m-199 -299 c0
-132 6 -217 21 -316 20 -132 20 -137 2 -153 -111 -102 -193 -170 -203 -170
-24 0 10 333 56 540 47 208 75 280 111 280 10 0 13 -36 13 -181z m1166 100
c172 -118 304 -219 303 -232 0 -13 -447 -312 -466 -312 -6 0 -50 45 -98 100
-48 55 -99 114 -114 130 -79 90 -113 137 -108 149 3 7 70 58 149 113 190 133
191 133 204 133 6 0 64 -37 130 -81z m-1326 -92 c0 -8 -11 -46 -25 -87 -52
-154 -92 -368 -102 -552 l-6 -117 -71 -70 c-38 -39 -76 -71 -83 -71 -18 0 -16
38 7 177 25 146 70 316 115 436 19 51 35 107 35 125 0 24 14 52 52 103 48 65
78 86 78 56z m854 -361 c80 -99 146 -186 146 -195 0 -9 -64 -64 -147 -126 -81
-61 -194 -147 -250 -192 -57 -46 -106 -83 -111 -83 -17 0 -150 384 -159 460
-6 52 -26 31 211 214 77 59 145 106 151 104 7 -2 78 -84 159 -182z m1001 30
c85 -79 102 -99 145 -185 27 -53 85 -154 129 -226 45 -71 81 -135 81 -142 0
-14 -385 -306 -399 -302 -5 2 -44 45 -86 94 -106 124 -186 214 -279 315 -149
162 -188 210 -183 224 9 23 457 318 477 314 10 -2 62 -43 115 -92z m-2045 75
c0 -6 -15 -44 -34 -85 -66 -145 -134 -403 -155 -587 -8 -75 -12 -84 -47 -120
-39 -40 -64 -50 -64 -25 0 30 32 197 56 296 46 185 196 530 231 530 7 0 13 -4
13 -9z m446 -446 c18 -71 49 -177 69 -234 19 -58 35 -115 35 -127 0 -13 -14
-34 -32 -49 -17 -15 -83 -75 -145 -133 -63 -59 -120 -108 -127 -110 -26 -6
-73 256 -83 453 l-6 130 114 103 c63 56 120 101 128 99 9 -1 26 -49 47 -132z
m900 -12 c27 -32 125 -146 218 -253 93 -107 194 -223 224 -258 30 -34 52 -68
49 -75 -3 -7 -81 -68 -173 -135 -93 -66 -241 -175 -329 -241 -88 -66 -167
-120 -176 -121 -8 0 -24 12 -36 28 -42 57 -162 240 -200 307 -72 123 -183 353
-183 377 1 25 1 25 339 281 108 81 201 147 207 147 6 0 33 -26 60 -57z m-1282
-265 c11 -128 35 -295 57 -380 10 -42 19 -84 19 -94 0 -20 -177 -204 -196
-204 -25 0 -60 227 -70 448 l-7 143 84 85 c46 46 89 84 95 84 8 0 14 -30 18
-82z m2513 -195 c128 -248 180 -424 170 -578 -8 -134 -50 -188 -164 -211 -27
-5 -32 -1 -68 58 -71 116 -171 262 -279 406 -58 78 -106 150 -106 160 0 12 43
52 118 110 64 49 144 113 177 141 33 27 65 50 70 50 6 1 43 -61 82 -136z
m-2779 -151 c6 -87 23 -218 37 -291 l26 -134 -47 -48 c-72 -73 -77 -69 -98 62
-23 141 -35 279 -36 394 l0 89 42 43 c23 24 47 43 53 43 7 0 15 -56 23 -158z
m828 91 c81 -200 189 -406 300 -576 35 -54 64 -105 64 -115 -1 -22 -361 -302
-389 -302 -22 0 -64 65 -139 216 -90 179 -199 479 -186 512 8 23 306 302 322
302 7 0 20 -17 28 -37z m1466 -359 c138 -178 280 -375 309 -430 22 -39 22 -41
5 -85 -15 -39 -35 -60 -138 -140 -257 -199 -353 -269 -371 -269 -50 0 -617
520 -617 565 1 15 91 85 338 262 185 133 343 242 349 242 7 1 63 -65 125 -145z
m3342 23 c113 -63 149 -210 111 -457 -28 -187 -84 -356 -185 -565 -171 -349
-416 -654 -654 -813 -185 -122 -410 -155 -558 -81 -57 29 -71 25 -96 -27 -55
-113 -156 -240 -214 -270 -78 -41 -145 20 -208 189 -12 31 -27 57 -34 57 -7 0
-18 -17 -24 -38 -19 -62 -98 -217 -152 -297 -166 -246 -422 -415 -653 -432
-124 -9 -117 -30 -117 339 0 240 3 308 13 308 28 0 258 122 339 180 119 85
272 245 353 369 117 179 189 353 266 646 40 152 57 185 99 185 43 0 45 -19 25
-239 -28 -322 -12 -535 45 -596 36 -38 67 -32 119 23 83 86 142 222 181 419
39 196 66 262 114 284 47 22 73 5 108 -71 18 -38 38 -70 43 -70 6 0 51 69 100
153 236 405 393 602 589 736 138 96 292 122 390 68z m-5244 -37 c0 -6 21 -68
46 -138 55 -152 142 -337 219 -467 31 -52 55 -99 53 -104 -5 -16 -218 -181
-233 -181 -14 0 -63 75 -113 175 -76 152 -192 458 -192 505 0 12 41 62 96 120
88 91 124 117 124 90z m3228 -60 c7 -138 -37 -574 -78 -775 -127 -618 -434
-1059 -837 -1205 -94 -34 -141 -38 -150 -14 -6 15 4 146 33 434 22 226 10 201
120 256 398 202 660 604 813 1253 22 90 43 124 75 119 18 -3 21 -11 24 -68z
m-3489 -312 c41 -129 124 -316 201 -458 33 -60 60 -115 60 -122 0 -18 -94 -88
-118 -88 -34 0 -190 305 -255 500 -53 159 -54 148 6 212 28 32 57 57 62 57 6
1 26 -45 44 -101z m1303 -214 c123 -126 274 -259 421 -368 42 -32 77 -64 77
-71 0 -18 -398 -295 -422 -295 -26 0 -227 150 -350 262 -114 104 -258 264
-258 288 0 14 383 310 401 310 5 0 64 -57 131 -126z m1144 -161 c-2 -16 -10
-130 -17 -255 -11 -207 -14 -228 -30 -228 -24 0 -319 209 -319 226 0 7 72 67
159 134 88 67 165 128 171 136 21 25 42 17 36 -13z m-1726 -130 c57 -80 318
-335 433 -422 59 -46 107 -88 107 -96 0 -15 -241 -175 -265 -175 -32 0 -219
153 -355 289 -119 119 -202 225 -198 251 3 21 211 198 234 199 6 1 26 -20 44
-46z m-310 -265 c70 -96 258 -285 380 -383 60 -49 110 -96 110 -104 0 -19 -97
-84 -114 -78 -36 14 -236 176 -330 266 -111 108 -226 243 -226 264 1 13 109
96 125 96 6 0 30 -27 55 -61z m1699 -86 c97 -65 184 -123 194 -128 14 -8 16
-18 11 -58 -7 -48 -9 -50 -112 -126 -154 -115 -131 -110 -274 -60 -164 57
-418 178 -418 199 1 15 392 291 413 291 5 0 89 -53 186 -118z m-598 -306 c124
-65 321 -148 379 -161 57 -12 35 -41 -87 -116 -62 -38 -122 -69 -133 -69 -80
0 -555 203 -548 234 3 16 233 174 254 175 7 1 67 -28 135 -63z m774 -118 c-4
-24 -9 -44 -10 -46 -7 -8 -75 12 -75 22 0 14 61 65 78 66 11 0 12 -10 7 -42z
m-1105 -126 c74 -38 190 -88 258 -112 67 -23 122 -48 122 -54 0 -6 -23 -24
-51 -39 l-50 -29 -87 27 c-188 58 -444 175 -449 206 -3 16 72 67 102 68 11 1
81 -30 155 -67z m1009 2 l83 -19 -6 -44 c-3 -24 -6 -59 -6 -77 l0 -34 -82 0
c-77 0 -210 12 -300 26 -21 3 -38 11 -38 17 0 20 222 159 245 154 11 -3 58
-13 104 -23z m-329 -219 c58 -9 169 -18 248 -22 126 -5 142 -8 142 -23 0 -10
-8 -21 -17 -24 -36 -14 -341 -19 -458 -7 -140 14 -165 19 -165 35 0 19 92 66
120 61 14 -3 72 -12 130 -20z M7024 3806 c-181 -44 -418 -228 -500 -388 -28
-56 -29 -62 -8 -82 50 -51 276 28 495 172 167 110 329 243 329 269 0 36 -207
55 -316 29z m216 -48 c-1 -26 -215 -187 -348 -262 -148 -84 -322 -146 -322
-116 0 16 50 87 104 147 95 105 253 203 370 228 81 18 196 19 196 3z M6951
3670 c-134 -64 -290 -200 -228 -200 38 0 317 189 317 215 0 22 -17 19 -89 -15z"
                                fill="url(#sadra-loader-gold-gradient)"
                            />

                        </g>


                        <g
                            mask="url(#sadra-loader-gold-mask)"
                        >

                            <rect
                                id="sadra-loader-shimmer"
                                x="-300"
                                y="-300"
                                width="260"
                                height="1800"
                                fill="url(#sadra-loader-shimmer-gradient)"
                            />

                        </g>

                    </g>

                </svg>

            </div>

        </div>


        <div class="sadra-loader__label">
            Sadra University
        </div>


        <div class="sadra-loader__bar"></div>

    </div>

<?php endif; ?>


<!-- =========================================================
     SITE HEADER
========================================================== -->

<header class="site-header">

    <div class="container site-header__inner">


        <!-- =====================================================
             BRAND
        ====================================================== -->

        <a
            href="<?= View::url(
                '/'
            ) ?>"
            class="brand"
            aria-label="<?= View::escape(
                $siteName
            ) ?>"
        >

            <img
                src="<?= View::escape(
                    $logoLight
                ) ?>"
                alt="<?= View::escape(
                    $siteName
                ) ?>"
                class="brand__logo"
                data-theme-logo
                data-theme-logo-light="<?= View::escape(
                    $logoLight
                ) ?>"
                data-theme-logo-dark="<?= View::escape(
                    $logoDark
                ) ?>"
            >


            <span class="brand__text">

                <span class="brand__title">
                    <?= View::escape(
                        $siteName
                    ) ?>
                </span>


                <span class="brand__short">
                    <?= View::escape(
                        $siteShortName
                    ) ?>
                </span>

            </span>

        </a>


        <!-- =====================================================
             HEADER ACTIONS
        ====================================================== -->

        <div class="site-header__actions">


            <!-- =================================================
                 THEME TOGGLE
            ================================================== -->

            <button
                type="button"
                class="theme-toggle"
                id="theme-toggle"
                data-theme-toggle
                aria-label="فعال کردن حالت تاریک"
                aria-pressed="false"
                title="فعال کردن حالت تاریک"
            >

                <svg
                    class="theme-toggle__icon theme-toggle__icon--moon"
                    viewBox="0 0 24 24"
                    width="18"
                    height="18"
                    fill="none"
                    aria-hidden="true"
                >

                    <path
                        d="M20.4 15.2A8.7 8.7 0 0 1 8.8 3.6a8.7 8.7 0 1 0 11.6 11.6Z"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />

                </svg>


                <svg
                    class="theme-toggle__icon theme-toggle__icon--sun"
                    viewBox="0 0 24 24"
                    width="18"
                    height="18"
                    fill="none"
                    aria-hidden="true"
                >

                    <circle
                        cx="12"
                        cy="12"
                        r="4"
                        stroke="currentColor"
                        stroke-width="1.8"
                    />


                    <path
                        d="M12 2v2.2M12 19.8V22M4.93 4.93l1.56 1.56M17.51 17.51l1.56 1.56M2 12h2.2M19.8 12H22M4.93 19.07l1.56-1.56M17.51 6.49l1.56-1.56"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                    />

                </svg>

            </button>


            <!-- =================================================
                 MOBILE MENU BUTTON
            ================================================== -->

            <button
                type="button"
                class="site-nav-toggle"
                id="site-nav-toggle"
                aria-label="باز کردن منوی سایت"
                aria-expanded="false"
                aria-controls="site-main-navigation"
            >

                <span></span>

                <span></span>

                <span></span>

            </button>

        </div>


        <!-- =====================================================
             MOBILE BACKDROP
        ====================================================== -->

        <button
            type="button"
            class="site-nav-backdrop"
            id="site-nav-backdrop"
            aria-label="بستن منوی سایت"
            tabindex="-1"
        ></button>


        <!-- =====================================================
             MAIN NAVIGATION
        ====================================================== -->

        <nav
            class="site-nav"
            id="site-main-navigation"
            aria-label="منوی اصلی"
        >

            <div class="site-nav__mobile-header">

                <strong>
                    منوی سایت
                </strong>


                <button
                    type="button"
                    class="site-nav__mobile-close"
                    id="site-nav-close"
                    aria-label="بستن منو"
                >
                    ×
                </button>

            </div>


            <a
                href="<?= View::url(
                    '/'
                ) ?>"
                class="site-nav__link <?= $navActive(
                    '/'
                ) ?>"
            >
                صفحه اصلی
            </a>


            <a
                href="<?= View::url(
                    '/about'
                ) ?>"
                class="site-nav__link <?= $navActive(
                    '/about'
                ) ?>"
            >
                درباره موسسه
            </a>


            <a
                href="<?= View::url(
                    '/presidency'
                ) ?>"
                class="site-nav__link <?= $navActive(
                    '/presidency'
                ) ?>"
            >
                ریاست
            </a>


            <a
                href="<?= View::url(
                    '/education'
                ) ?>"
                class="site-nav__link <?= $navActive(
                    '/education'
                ) ?>"
            >
                آموزشی و پژوهشی
            </a>


            <a
                href="<?= View::url(
                    '/student-affairs'
                ) ?>"
                class="site-nav__link <?= $navActive(
                    '/student-affairs'
                ) ?>"
            >
                دانشجویی و فرهنگی
            </a>


            <a
                href="<?= View::url(
                    '/support'
                ) ?>"
                class="site-nav__link <?= $navActive(
                    '/support'
                ) ?>"
            >
                پشتیبانی و عمرانی
            </a>


            <a
                href="<?= View::url(
                    '/faculties'
                ) ?>"
                class="site-nav__link <?= $navActive(
                    '/faculties'
                ) ?>"
            >
                دانشکده‌ها
            </a>


            <a
                href="<?= View::url(
                    '/programs'
                ) ?>"
                class="site-nav__link <?= $navActive(
                    '/programs'
                ) ?>"
            >
                رشته‌ها
            </a>


            <a
                href="<?= View::url(
                    '/research-centers'
                ) ?>"
                class="site-nav__link <?= $navActive(
                    '/research-centers'
                ) ?>"
            >
                پژوهشکده‌ها
            </a>


            <a
                href="<?= View::url(
                    '/people'
                ) ?>"
                class="site-nav__link <?= $navActive(
                    '/people'
                ) ?>"
            >
                اعضای هیئت علمی
            </a>


            <a
                href="<?= View::url(
                    '/documents'
                ) ?>"
                class="site-nav__link <?= $navActive(
                    '/documents'
                ) ?>"
            >
                اسناد و فرم‌ها
            </a>


            <a
                href="<?= View::url(
                    '/announcements'
                ) ?>"
                class="site-nav__link <?= $navActive(
                    '/announcements'
                ) ?>"
            >
                اطلاعیه‌ها
            </a>


            <a
                href="<?= View::url(
                    '/search'
                ) ?>"
                class="site-nav__link <?= $navActive(
                    '/search'
                ) ?>"
            >
                جستجو
            </a>


            <a
                href="<?= View::url(
                    '/contact'
                ) ?>"
                class="site-nav__link <?= $navActive(
                    '/contact'
                ) ?>"
            >
                تماس با ما
            </a>


            <?php if (
                $isAuthenticated
            ): ?>

                <a
                    href="<?= View::url(
                        '/teacher/dashboard'
                    ) ?>"
                    class="site-nav__link <?= $navActive(
                        '/teacher'
                    ) ?>"
                >
                    پنل کاربری
                </a>

            <?php else: ?>

                <a
                    href="<?= View::url(
                        '/teacher/login'
                    ) ?>"
                    class="site-nav__link <?= $navActive(
                        '/teacher/login'
                    ) ?>"
                >
                    ورود
                </a>

            <?php endif; ?>


            <a
                href="<?= View::url(
                    '/english'
                ) ?>"
                class="site-nav__language"
                lang="en"
            >
                English
            </a>

        </nav>

    </div>

</header>


<!-- =========================================================
     FLASH MESSAGES
========================================================== -->

<?php if (
    is_string($errorMessage)
    && $errorMessage !== ''
): ?>

    <div class="container">

        <div
            class="site-alert site-alert--error"
            role="alert"
        >

            <?= View::escape(
                $errorMessage
            ) ?>

        </div>

    </div>

<?php endif; ?>


<?php if (
    is_string($successMessage)
    && $successMessage !== ''
): ?>

    <div class="container">

        <div
            class="site-alert site-alert--success"
            role="status"
        >

            <?= View::escape(
                $successMessage
            ) ?>

        </div>

    </div>

<?php endif; ?>


<!-- =========================================================
     MAIN CONTENT
========================================================== -->

<main>

    <?= $content ?>

</main>


<!-- =========================================================
     FOOTER
========================================================== -->

<footer class="site-footer">

    <div class="container">

        <div class="site-footer__grid">


            <div class="site-footer__column">

                <h2 class="site-footer__title">
                    <?= View::escape(
                        $siteName
                    ) ?>
                </h2>


                <p>
                    موسسه آموزش عالی صدرالمتالهین
                    (صدرا)، تهران
                </p>

            </div>


            <div class="site-footer__column">

                <h2 class="site-footer__title">
                    دسترسی سریع
                </h2>


                <a
                    href="<?= View::url(
                        '/about'
                    ) ?>"
                >
                    درباره موسسه
                </a>


                <a
                    href="<?= View::url(
                        '/presidency'
                    ) ?>"
                >
                    ریاست
                </a>


                <a
                    href="<?= View::url(
                        '/education'
                    ) ?>"
                >
                    آموزشی و پژوهشی
                </a>


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
                        '/search'
                    ) ?>"
                >
                    جستجو
                </a>

            </div>


            <div class="site-footer__column">

                <h2 class="site-footer__title">
                    خدمات
                </h2>


                <a
                    href="<?= View::url(
                        '/student-affairs'
                    ) ?>"
                >
                    امور دانشجویی و فرهنگی
                </a>


                <a
                    href="<?= View::url(
                        '/support'
                    ) ?>"
                >
                    پشتیبانی و عمرانی
                </a>


                <a
                    href="<?= View::url(
                        '/documents'
                    ) ?>"
                >
                    اسناد و فرم‌ها
                </a>


                <a
                    href="<?= View::url(
                        '/people'
                    ) ?>"
                >
                    اعضای هیئت علمی
                </a>


                <a
                    href="<?= View::url(
                        '/announcements'
                    ) ?>"
                >
                    اطلاعیه‌ها
                </a>


                <a
                    href="<?= View::url(
                        '/teacher/login'
                    ) ?>"
                >
                    سامانه اعضای هیئت علمی
                </a>


                <a
                    href="<?= View::url(
                        '/english'
                    ) ?>"
                    lang="en"
                >
                    English
                </a>

            </div>


            <div class="site-footer__column">

                <h2 class="site-footer__title">
                    ارتباط با ما
                </h2>


                <?php if (
                    $contactEmail !== ''
                ): ?>

                    <a
                        href="mailto:<?= View::escape(
                            $contactEmail
                        ) ?>"
                    >
                        <?= View::escape(
                            $contactEmail
                        ) ?>
                    </a>

                <?php endif; ?>


                <?php if (
                    $phoneHref !== ''
                ): ?>

                    <a
                        href="tel:<?= View::escape(
                            $phoneHref
                        ) ?>"
                    >
                        <?= View::escape(
                            $contactPhone
                        ) ?>
                    </a>

                <?php endif; ?>


                <?php if (
                    $contactFax !== ''
                ): ?>

                    <span>
                        فکس:
                        <?= View::escape(
                            $contactFax
                        ) ?>
                    </span>

                <?php endif; ?>


                <a
                    href="<?= View::url(
                        '/contact'
                    ) ?>"
                >
                    صفحه تماس با ما
                </a>

            </div>

        </div>


        <div class="site-footer__bottom">

            <p class="site-footer__copyright">
                تمامی حقوق این سایت متعلق به
                موسسه آموزش عالی صدرالمتالهین است.
            </p>


            <p class="site-footer__address">
                <?= View::escape(
                    $contactAddress
                ) ?>
            </p>

        </div>

    </div>

</footer>


<!-- =========================================================
     PUBLIC JAVASCRIPT
========================================================== -->

<script
    src="<?= View::escape(
        $appJs
    ) ?>"
    defer
></script>


<?php if (
    $isPersianHomepage
): ?>

    <!-- =========================================================
         PERSIAN HOMEPAGE LOADER JAVASCRIPT
    ========================================================== -->

    <script>
    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const loader =
                document.getElementById(
                    'sadra-page-loader'
                );


            if (
                !loader
            ) {

                return;

            }


            const navy =
                document.getElementById(
                    'sadra-loader-navy'
                );


            const gold =
                document.getElementById(
                    'sadra-loader-gold'
                );


            const shimmer =
                document.getElementById(
                    'sadra-loader-shimmer'
                );


            /*
            |--------------------------------------------------------------------------
            | Fail open
            |--------------------------------------------------------------------------
            |
            | If anything about the SVG is broken, the homepage must still
            | remain usable.
            |
            */

            if (
                !navy
                || !gold
                || !shimmer
            ) {

                loader.classList.add(
                    'sadra-loader--hide'
                );

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Prepare paths
            |--------------------------------------------------------------------------
            */

            [
                navy,
                gold
            ].forEach(
                function (
                    element
                ) {

                    element.classList.remove(
                        'sadra-loader--drawn',
                        'sadra-loader--filled'
                    );


                    element.classList.add(
                        'sadra-loader--setup'
                    );


                    const pathLength =
                        element.getTotalLength();


                    element.style.strokeDasharray =
                        pathLength;


                    element.style.setProperty(
                        '--sadra-loader-path-length',
                        pathLength
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Reset shimmer
            |--------------------------------------------------------------------------
            */

            shimmer.classList.remove(
                'sadra-loader--play'
            );


            /*
            |--------------------------------------------------------------------------
            | Commit the reset state
            |--------------------------------------------------------------------------
            |
            | Forces a reflow so the untransitioned reset above is fully
            | applied before transitions are re-enabled and the real
            | draw-in animation starts.
            |
            */

            void navy.getBoundingClientRect();


            navy.classList.remove(
                'sadra-loader--setup'
            );


            gold.classList.remove(
                'sadra-loader--setup'
            );


            /*
            |--------------------------------------------------------------------------
            | Start logo drawing
            |--------------------------------------------------------------------------
            */

            requestAnimationFrame(
                function () {

                    requestAnimationFrame(
                        function () {

                            navy.classList.add(
                                'sadra-loader--drawn',
                                'sadra-loader--filled'
                            );


                            gold.classList.add(
                                'sadra-loader--drawn',
                                'sadra-loader--filled'
                            );

                        }
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Trigger the shimmer
            |--------------------------------------------------------------------------
            |
            | Fires once the gold fill has settled: 0.28s delay + 1.65s
            | draw + 0.6s into the fill transition.
            |
            */

            const ANIMATION_SETTLE_MS =
                2650;


            window.setTimeout(
                function () {

                    shimmer.classList.add(
                        'sadra-loader--play'
                    );

                },
                ANIMATION_SETTLE_MS
            );


            /*
            |--------------------------------------------------------------------------
            | Reveal the site immediately
            |--------------------------------------------------------------------------
            |
            | This script only runs once the HTML above it has been
            | parsed, so there is nothing left to wait for. Waiting for
            | window.load instead would hold the loader on screen until
            | every image, font, and slider photo has fully downloaded —
            | far slower than how the site felt before the loader existed.
            | The logo animation keeps playing as a purely decorative
            | overlay; it no longer blocks anything.
            |
            */

            loader.classList.add(
                'sadra-loader--hide'
            );

        }
    );
    </script>

<?php endif; ?>


</body>

</html>
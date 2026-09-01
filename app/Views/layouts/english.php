<?php

declare(strict_types=1);

use App\Core\Session;
use App\Core\View;

/**
 * =========================================================
 * Sadra University
 * English Public Application Layout
 * =========================================================
 *
 * English public-facing layout.
 *
 * Variables expected:
 *
 * @var string $content
 * @var string|null $title
 * @var string|null $description
 * @var string|null $canonical
 *
 * =========================================================
 */


/*
|--------------------------------------------------------------------------
| Page metadata
|--------------------------------------------------------------------------
*/

$title =
    is_string($title ?? null)
    && trim($title) !== ''
        ? $title
        : 'Sadra Institute of Higher Education';


$description =
    is_string($description ?? null)
    && trim($description) !== ''
        ? $description
        : 'Official website of Sadra Institute of Higher Education, Tehran, Iran.';


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
        $_SERVER['REQUEST_URI'] ?? '/english',
        PHP_URL_PATH
    );


if (
    !is_string($currentPath)
    || trim($currentPath) === ''
) {

    $currentPath =
        '/english';

}


/*
|--------------------------------------------------------------------------
| Canonical URL
|--------------------------------------------------------------------------
*/

$canonicalUrl =
    isset($canonical)
    && is_string($canonical)
    && trim($canonical) !== ''
        ? $canonical
        : $baseUrl . $currentPath;


/*
|--------------------------------------------------------------------------
| Persian alternate URL
|--------------------------------------------------------------------------
*/

$persianPath =
    match (true) {

        $currentPath === '/english' =>
            '/',


        $currentPath === '/english/about' =>
            '/about',


        $currentPath === '/english/presidency' =>
            '/presidency',


        $currentPath === '/english/faculties' =>
            '/faculties',


        str_starts_with(
            $currentPath,
            '/english/faculties/'
        ) =>
            '/faculties/'
            . ltrim(
                substr(
                    $currentPath,
                    strlen('/english/faculties/')
                ),
                '/'
            ),


        $currentPath === '/english/programs' =>
            '/programs',


        str_starts_with(
            $currentPath,
            '/english/programs/'
        ) =>
            '/programs/'
            . ltrim(
                substr(
                    $currentPath,
                    strlen('/english/programs/')
                ),
                '/'
            ),


        $currentPath === '/english/research' =>
            '/research-centers',


        str_starts_with(
            $currentPath,
            '/english/research/'
        ) =>
            '/research-centers/'
            . ltrim(
                substr(
                    $currentPath,
                    strlen('/english/research/')
                ),
                '/'
            ),


        $currentPath === '/english/announcements' =>
            '/announcements',


        str_starts_with(
            $currentPath,
            '/english/announcements/'
        ) =>
            '/announcements/'
            . ltrim(
                substr(
                    $currentPath,
                    strlen('/english/announcements/')
                ),
                '/'
            ),


        $currentPath === '/english/contact' =>
            '/contact',


        default =>
            '/',
    };


$persianUrl =
    $baseUrl
    . $persianPath;


/*
|--------------------------------------------------------------------------
| Active navigation helper
|--------------------------------------------------------------------------
*/

$active =
    static function (
        string $path
    ) use (
        $currentPath
    ): string {

        if (
            $path === '/english'
        ) {

            return $currentPath === '/english'
                ? 'english-nav__link--active'
                : '';

        }


        return str_starts_with(
            $currentPath,
            $path
        )
            ? 'english-nav__link--active'
            : '';

    };


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
| Contact information
|--------------------------------------------------------------------------
*/

$contactEmail =
    (string) config(
        'app.contact.email',
        'info@sadra.ac.ir'
    );


$contactPhone =
    (string) config(
        'app.contact.phone',
        ''
    );


$contactAddress =
    (string) config(
        'app.contact.address',
        'Tehran, Iran'
    );


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

    $phoneHref =
        '';

}


/*
|--------------------------------------------------------------------------
| Shared theme logos
|--------------------------------------------------------------------------
|
| The English and Persian public applications use the same logo files.
|
| JavaScript reads these values from data-theme-logo-light and
| data-theme-logo-dark and switches the displayed logo according
| to html[data-theme].
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


/*
|--------------------------------------------------------------------------
| Favicon
|--------------------------------------------------------------------------
|
| The favicon is completely separate from the theme logos.
|
| It is a single static favicon.ico and does NOT change with theme.
|
*/

$faviconUrl =
    View::asset(
        'favicon.ico'
    );

?>


<!DOCTYPE html>

<html
    lang="en"
    dir="ltr"
>

<head>


    <meta charset="UTF-8">


    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >


    <!-- ===================================================
         SEO
    ==================================================== -->

    <meta
        name="description"
        content="<?= View::escape(
            $description
        ) ?>"
    >


    <meta
        name="robots"
        content="<?= View::escape(
            (string) config(
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


    <!-- ===================================================
         Language alternates
    ==================================================== -->

    <link
        rel="alternate"
        hreflang="en"
        href="<?= View::escape(
            $canonicalUrl
        ) ?>"
    >


    <link
        rel="alternate"
        hreflang="fa"
        href="<?= View::escape(
            $persianUrl
        ) ?>"
    >


    <link
        rel="alternate"
        hreflang="x-default"
        href="<?= View::escape(
            $persianUrl
        ) ?>"
    >


    <!-- ===================================================
         Open Graph
    ==================================================== -->

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
        content="Sadra Institute of Higher Education"
    >


    <meta
        property="og:locale"
        content="en_US"
    >


    <meta
        property="og:locale:alternate"
        content="fa_IR"
    >


    <!-- ===================================================
         Twitter
    ==================================================== -->

    <meta
        name="twitter:card"
        content="<?= View::escape(
            (string) config(
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


    <!-- ===================================================
         General
    ==================================================== -->

    <meta
        name="theme-color"
        content="#ffffff"
        id="theme-color-meta"
    >


    <meta
        name="application-name"
        content="Sadra Institute"
    >


    <!-- ===================================================
         FAVICON
    ==================================================== -->

    <link
        rel="icon"
        type="image/x-icon"
        href="<?= View::escape(
            $faviconUrl
        ) ?>"
    >


    <link
        rel="shortcut icon"
        type="image/x-icon"
        href="<?= View::escape(
            $faviconUrl
        ) ?>"
    >


    <!-- ===================================================
         APPLE TOUCH ICON
    ==================================================== -->

    <link
        rel="apple-touch-icon"
        href="<?= View::escape(
            $logoLight
        ) ?>"
    >


    <title>
        <?= View::escape(
            $title
        ) ?>
    </title>


    <!-- ===================================================
         Prevent light-theme flash
    ==================================================== -->

    <script>
        (function () {

            try {

                var savedTheme =
                    localStorage.getItem(
                        'sadra-theme'
                    );


                var systemDark =
                    window.matchMedia
                    && window.matchMedia(
                        '(prefers-color-scheme: dark)'
                    ).matches;


                var theme =
                    savedTheme === 'dark'
                    || savedTheme === 'light'
                        ? savedTheme
                        : (
                            systemDark
                                ? 'dark'
                                : 'light'
                        );


                document.documentElement.setAttribute(
                    'data-theme',
                    theme
                );


                var themeColorMeta =
                    document.getElementById(
                        'theme-color-meta'
                    );


                if (
                    themeColorMeta
                ) {

                    themeColorMeta.setAttribute(
                        'content',
                        theme === 'dark'
                            ? '#101317'
                            : '#ffffff'
                    );

                }

            } catch (
                error
            ) {

                document.documentElement.setAttribute(
                    'data-theme',
                    'light'
                );

            }

        })();
    </script>


    <!-- ===================================================
         English stylesheet
    ==================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::asset(
            'css/english/main.css'
        ) ?>?v=3"
    >

</head>


<body>


<!-- =======================================================
     HEADER
======================================================== -->

<header class="english-header">

    <div
        class="
            english-container
            english-header__inner
        "
    >


        <!-- =================================================
             BRAND
        ================================================== -->

        <a
            href="<?= View::url(
                '/english'
            ) ?>"

            class="english-brand"

            aria-label="Sadra Institute of Higher Education"
        >

            <span
                class="english-brand__logo"
            >

                <img
                    src="<?= View::escape(
                        $logoLight
                    ) ?>"

                    alt="Sadra Institute of Higher Education"

                    width="44"

                    height="44"

                    loading="eager"

                    data-theme-logo

                    data-theme-logo-light="<?= View::escape(
                        $logoLight
                    ) ?>"

                    data-theme-logo-dark="<?= View::escape(
                        $logoDark
                    ) ?>"
                >

            </span>


            <span
                class="english-brand__text"
            >

                <strong>
                    Sadra Institute
                </strong>


                <small>
                    Institute of Higher Education
                </small>

            </span>

        </a>


        <!-- =================================================
             DESKTOP NAVIGATION
        ================================================== -->

        <nav
            class="english-nav"

            id="english-navigation"

            aria-label="Primary navigation"
        >


            <!-- Home -->

            <a
                href="<?= View::url(
                    '/english'
                ) ?>"

                class="
                    english-nav__link
                    <?= $active(
                        '/english'
                    ) ?>
                "
            >
                Home
            </a>


            <!-- About -->

            <a
                href="<?= View::url(
                    '/english/about'
                ) ?>"

                class="
                    english-nav__link
                    <?= $active(
                        '/english/about'
                    ) ?>
                "
            >
                About
            </a>


            <!-- Presidency -->

            <a
                href="<?= View::url(
                    '/english/presidency'
                ) ?>"

                class="
                    english-nav__link
                    <?= $active(
                        '/english/presidency'
                    ) ?>
                "
            >
                Presidency
            </a>


            <!-- Faculties -->

            <a
                href="<?= View::url(
                    '/english/faculties'
                ) ?>"

                class="
                    english-nav__link
                    <?= $active(
                        '/english/faculties'
                    ) ?>
                "
            >
                Faculties
            </a>


            <!-- Programs -->

            <a
                href="<?= View::url(
                    '/english/programs'
                ) ?>"

                class="
                    english-nav__link
                    <?= $active(
                        '/english/programs'
                    ) ?>
                "
            >
                Programs
            </a>


            <!-- Research -->

            <a
                href="<?= View::url(
                    '/english/research'
                ) ?>"

                class="
                    english-nav__link
                    <?= $active(
                        '/english/research'
                    ) ?>
                "
            >
                Research
            </a>


            <!-- Announcements -->

            <a
                href="<?= View::url(
                    '/english/announcements'
                ) ?>"

                class="
                    english-nav__link
                    <?= $active(
                        '/english/announcements'
                    ) ?>
                "
            >
                Announcements
            </a>


            <!-- Contact -->

            <a
                href="<?= View::url(
                    '/english/contact'
                ) ?>"

                class="
                    english-nav__link
                    <?= $active(
                        '/english/contact'
                    ) ?>
                "
            >
                Contact
            </a>


            <!-- =================================================
                 LANGUAGE
            ================================================== -->

            <a
                href="<?= View::escape(
                    $persianUrl
                ) ?>"

                class="english-nav__language"

                lang="fa"

                aria-label="Switch to Persian"
            >
                فارسی
            </a>

        </nav>


        <!-- =================================================
             HEADER ACTIONS
        ================================================== -->

        <div
            class="english-header__actions"
        >


            <!-- =================================================
                 THEME TOGGLE
            ================================================== -->

            <button
                type="button"

                class="english-theme-toggle"

                data-theme-toggle

                aria-pressed="false"

                aria-label="Switch to dark mode"

                title="Dark mode"
            >

                <span
                    class="english-theme-toggle__icon"

                    data-theme-icon

                    aria-hidden="true"
                >
                    ☾
                </span>

            </button>


            <!-- =================================================
                 MOBILE MENU
            ================================================== -->

            <button
                type="button"

                class="english-menu-toggle"

                id="english-menu-toggle"

                aria-label="Open navigation"

                aria-expanded="false"

                aria-controls="english-navigation"
            >

                <span></span>

                <span></span>

                <span></span>

            </button>

        </div>

    </div>

</header>


<!-- =======================================================
     ALERTS
======================================================== -->

<?php if (
    is_string($errorMessage)
    && trim($errorMessage) !== ''
): ?>

    <div
        class="english-container"
    >

        <div
            class="
                english-alert
                english-alert--error
            "

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
    && trim($successMessage) !== ''
): ?>

    <div
        class="english-container"
    >

        <div
            class="
                english-alert
                english-alert--success
            "

            role="status"
        >

            <?= View::escape(
                $successMessage
            ) ?>

        </div>

    </div>

<?php endif; ?>


<!-- =======================================================
     MAIN CONTENT
======================================================== -->

<main>

    <?= $content ?? '' ?>

</main>


<!-- =======================================================
     FOOTER
======================================================== -->

<footer class="english-footer">

    <div class="english-container">

        <div class="english-footer__grid">


            <!-- =================================================
                 Institution
            ================================================== -->

            <div>

                <h2>
                    Sadra Institute
                </h2>


                <p>
                    Sadra Institute of Higher Education,
                    Tehran, Iran.
                </p>

            </div>


            <!-- =================================================
                 Quick Links
            ================================================== -->

            <div>

                <h2>
                    Quick Links
                </h2>


                <a
                    href="<?= View::url(
                        '/english'
                    ) ?>"
                >
                    Home
                </a>


                <a
                    href="<?= View::url(
                        '/english/about'
                    ) ?>"
                >
                    About
                </a>


                <a
                    href="<?= View::url(
                        '/english/presidency'
                    ) ?>"
                >
                    Presidency
                </a>


                <a
                    href="<?= View::url(
                        '/english/faculties'
                    ) ?>"
                >
                    Faculties
                </a>


                <a
                    href="<?= View::url(
                        '/english/programs'
                    ) ?>"
                >
                    Programs
                </a>


                <a
                    href="<?= View::url(
                        '/english/research'
                    ) ?>"
                >
                    Research
                </a>


                <a
                    href="<?= View::url(
                        '/english/announcements'
                    ) ?>"
                >
                    Announcements
                </a>


                <a
                    href="<?= View::url(
                        '/english/contact'
                    ) ?>"
                >
                    Contact
                </a>

            </div>


            <!-- =================================================
                 Contact
            ================================================== -->

            <div>

                <h2>
                    Contact
                </h2>


                <?php if (
                    trim($contactEmail) !== ''
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


                <a
                    href="<?= View::url(
                        '/english/contact'
                    ) ?>"
                >
                    Contact page
                </a>

            </div>

        </div>


        <!-- =================================================
             Footer bottom
        ================================================== -->

        <div
            class="english-footer__bottom"
        >

            <span>
                © <?= date('Y') ?>
                Sadra Institute of Higher Education
            </span>


            <span>
                <?= View::escape(
                    $contactAddress
                ) ?>
            </span>

        </div>

    </div>

</footer>


<!-- =======================================================
     ENGLISH JAVASCRIPT
======================================================== -->

<script
    src="<?= View::asset(
        'js/english.js'
    ) ?>?v=3"
    defer
></script>


</body>

</html>
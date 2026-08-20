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
    $title
    ?? 'Sadra Institute of Higher Education';

$description =
    $description
    ?? 'Official website of Sadra Institute of Higher Education, Tehran, Iran.';


/*
|--------------------------------------------------------------------------
| Application URL
|--------------------------------------------------------------------------
*/

$baseUrl = rtrim(
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

$currentPath = parse_url(
    $_SERVER['REQUEST_URI'] ?? '/english',
    PHP_URL_PATH
);

if (
    !is_string($currentPath)
    || $currentPath === ''
) {
    $currentPath = '/english';
}


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
| Persian alternate URL
|--------------------------------------------------------------------------
*/

$persianPath = match ($currentPath) {
    '/english' =>
        '/',

    '/english/about' =>
        '/about',

    '/english/presidency' =>
        '/presidency',

    '/english/faculties' =>
        '/faculties',

    '/english/research' =>
        '/research-centers',

    '/english/announcements' =>
        '/announcements',

    '/english/contact' =>
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

$active = static function (
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

$contactEmail = config(
    'app.contact.email',
    'info@sadra.ac.ir'
);

$contactPhone = config(
    'app.contact.phone',
    ''
);

$contactAddress = config(
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
    $phoneHref = '';
}

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
         Primary SEO
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


    <!-- ===================================================
         General metadata
    ==================================================== -->

    <meta
        name="theme-color"
        content="#ffffff"
    >


    <meta
        name="application-name"
        content="Sadra Institute"
    >


    <title>
        <?= View::escape(
            $title
        ) ?>
    </title>


    <!-- ===================================================
         Styles
    ==================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::asset(
            'css/english.css'
        ) ?>"
    >

</head>


<body>


<!-- =======================================================
     HEADER
======================================================== -->

<header class="english-header">

    <div class="english-container english-header__inner">


        <!-- Brand -->

        <a
            href="<?= View::url(
                '/english'
            ) ?>"
            class="english-brand"
            aria-label="Sadra Institute of Higher Education"
        >

            <span class="english-brand__logo">
                S
            </span>


            <span>

                <strong>
                    Sadra Institute
                </strong>

                <small>
                    of Higher Education
                </small>

            </span>

        </a>


        <!-- Mobile menu -->

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


        <!-- Navigation -->

        <nav
            class="english-nav"
            id="english-navigation"
            aria-label="Primary navigation"
        >

            <a
                href="<?= View::url(
                    '/english'
                ) ?>"
                class="english-nav__link <?= $active(
                    '/english'
                ) ?>"
            >
                Home
            </a>


            <a
                href="<?= View::url(
                    '/english/about'
                ) ?>"
                class="english-nav__link <?= $active(
                    '/english/about'
                ) ?>"
            >
                About
            </a>


            <a
                href="<?= View::url(
                    '/english/presidency'
                ) ?>"
                class="english-nav__link <?= $active(
                    '/english/presidency'
                ) ?>"
            >
                Presidency
            </a>


            <a
                href="<?= View::url(
                    '/english/faculties'
                ) ?>"
                class="english-nav__link <?= $active(
                    '/english/faculties'
                ) ?>"
            >
                Faculties
            </a>


            <a
                href="<?= View::url(
                    '/english/research'
                ) ?>"
                class="english-nav__link <?= $active(
                    '/english/research'
                ) ?>"
            >
                Research
            </a>


            <a
                href="<?= View::url(
                    '/english/announcements'
                ) ?>"
                class="english-nav__link <?= $active(
                    '/english/announcements'
                ) ?>"
            >
                Announcements
            </a>


            <a
                href="<?= View::url(
                    '/english/contact'
                ) ?>"
                class="english-nav__link <?= $active(
                    '/english/contact'
                ) ?>"
            >
                Contact
            </a>


            <a
                href="<?= View::url(
                    '/'
                ) ?>"
                class="english-nav__language"
                lang="fa"
            >
                فارسی
            </a>

        </nav>

    </div>

</header>


<!-- =======================================================
     ALERTS
======================================================== -->

<?php if (
    is_string($errorMessage)
    && $errorMessage !== ''
): ?>

    <div class="english-container">

        <div
            class="english-alert english-alert--error"
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

    <div class="english-container">

        <div
            class="english-alert english-alert--success"
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

    <?= $content ?>

</main>


<!-- =======================================================
     FOOTER
======================================================== -->

<footer class="english-footer">

    <div class="english-container">

        <div class="english-footer__grid">


            <!-- Institution -->

            <div>

                <h2>
                    Sadra Institute
                </h2>

                <p>
                    Sadra Institute of Higher Education,
                    Tehran, Iran.
                </p>

            </div>


            <!-- Quick links -->

            <div>

                <h2>
                    Quick Links
                </h2>


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

            </div>


            <!-- Contact -->

            <div>

                <h2>
                    Contact
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

<a
    href="<?= View::url(
        '/english/faculties'
    ) ?>"
    class="english-nav__link <?= $active(
        '/english/faculties'
    ) ?>"
>
    Programs
</a>
                <a
                    href="<?= View::url(
                        '/english/contact'
                    ) ?>"
                >
                    Contact page
                </a>

            </div>

        </div>


        <!-- Footer bottom -->

        <div class="english-footer__bottom">

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
     JAVASCRIPT
======================================================== -->

<script
    src="<?= View::asset(
        'js/english.js'
    ) ?>"
    defer
></script>


</body>

</html>
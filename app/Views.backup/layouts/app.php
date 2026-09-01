<?php

declare(strict_types=1);

use App\Core\Session;
use App\Core\View;

/**
 * =========================================================
 * Sadra University
 * Persian Public Application Layout
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

$title = $title
    ?? config(
        'app.seo.default_title',
        'موسسه آموزش عالی صدرالمتالهین'
    );

$description = $description
    ?? config(
        'app.seo.default_description',
        ''
    );


/*
|--------------------------------------------------------------------------
| Site information
|--------------------------------------------------------------------------
*/

$siteName = config(
    'app.name',
    'موسسه آموزش عالی صدرالمتالهین'
);

$siteShortName = config(
    'app.short_name',
    'صدرا'
);

$contactEmail = config(
    'app.contact.email',
    'info@sadra.ac.ir'
);

$contactPhone = config(
    'app.contact.phone',
    ''
);

$contactFax = config(
    'app.contact.fax',
    ''
);

$contactAddress = config(
    'app.contact.address',
    'تهران، ایران'
);


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

$englishPath = match ($currentPath) {
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
        '/english/faculties',

    '/research-centers' =>
        '/english/research',

    '/announcements' =>
        '/english/announcements',

    '/contact' =>
        '/english/contact',

    '/search' =>
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

$navActive = static function (
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
| External services
|--------------------------------------------------------------------------
*/

$webmailUrl = config(
    'app.external_services.webmail',
    '#'
);

$universitySystemUrl = config(
    'app.external_services.university_system',
    '#'
);


/*
|--------------------------------------------------------------------------
| Phone href
|--------------------------------------------------------------------------
*/

$phoneHref = preg_replace(
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
    lang="fa"
    dir="rtl"
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
        content="<?= View::escape(
            $siteShortName
        ) ?>"
    >


    <title>
        <?= View::escape(
            $title
        ) ?>
    </title>


    <!-- ===================================================
         Stylesheets
    ==================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::asset(
            'css/app.css'
        ) ?>"
    >


    <link
        rel="stylesheet"
        href="<?= View::asset(
            'css/announcements.css'
        ) ?>"
    >


    <link
        rel="stylesheet"
        href="<?= View::asset(
            'css/home.css'
        ) ?>"
    >


    <link
        rel="stylesheet"
        href="<?= View::asset(
            'css/teacher.css'
        ) ?>"
    >


    <link
        rel="stylesheet"
        href="<?= View::asset(
            'css/institution.css'
        ) ?>"
    >


    <link
        rel="stylesheet"
        href="<?= View::asset(
            'css/search.css'
        ) ?>"
    >

</head>


<body>


<!-- =======================================================
     HEADER
======================================================== -->

<header class="site-header">

    <div class="container site-header__inner">

        <!-- Brand -->

        <a
            href="<?= View::url('/') ?>"
            class="brand"
            aria-label="<?= View::escape(
                $siteName
            ) ?>"
        >

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

        </a>


        <!-- Mobile menu -->

        <button
            type="button"
            class="site-nav-toggle"
            id="site-nav-toggle"
            aria-label="باز کردن منو"
            aria-expanded="false"
            aria-controls="site-main-navigation"
        >

            <span></span>
            <span></span>
            <span></span>

        </button>


        <!-- Main navigation -->

        <nav
            class="site-nav"
            id="site-main-navigation"
            aria-label="منوی اصلی"
        >

            <a
                href="<?= View::url('/') ?>"
                class="site-nav__link <?= $navActive('/') ?>"
            >
                صفحه اصلی
            </a>


            <a
                href="<?= View::url('/about') ?>"
                class="site-nav__link <?= $navActive('/about') ?>"
            >
                درباره موسسه
            </a>


            <a
                href="<?= View::url('/presidency') ?>"
                class="site-nav__link <?= $navActive('/presidency') ?>"
            >
                ریاست
            </a>


            <a
                href="<?= View::url('/education') ?>"
                class="site-nav__link <?= $navActive('/education') ?>"
            >
                آموزشی و پژوهشی
            </a>


            <a
                href="<?= View::url('/student-affairs') ?>"
                class="site-nav__link <?= $navActive('/student-affairs') ?>"
            >
                دانشجویی و فرهنگی
            </a>


            <a
                href="<?= View::url('/support') ?>"
                class="site-nav__link <?= $navActive('/support') ?>"
            >
                پشتیبانی و عمرانی
            </a>


            <a
                href="<?= View::url('/faculties') ?>"
                class="site-nav__link <?= $navActive('/faculties') ?>"
            >
                دانشکده‌ها
            </a>


            <a
                href="<?= View::url('/programs') ?>"
                class="site-nav__link <?= $navActive('/programs') ?>"
            >
                رشته‌ها
            </a>


            <a
                href="<?= View::url('/research-centers') ?>"
                class="site-nav__link <?= $navActive('/research-centers') ?>"
            >
                پژوهشکده‌ها
            </a>


            <a
                href="<?= View::url('/people') ?>"
                class="site-nav__link <?= $navActive('/people') ?>"
            >
                اعضای هیئت علمی
            </a>


            <a
                href="<?= View::url('/documents') ?>"
                class="site-nav__link <?= $navActive('/documents') ?>"
            >
                اسناد و فرم‌ها
            </a>


            <a
                href="<?= View::url('/announcements') ?>"
                class="site-nav__link <?= $navActive('/announcements') ?>"
            >
                اطلاعیه‌ها
            </a>


            <a
                href="<?= View::url('/search') ?>"
                class="site-nav__link <?= $navActive('/search') ?>"
            >
                جستجو
            </a>


            <a
                href="<?= View::url('/contact') ?>"
                class="site-nav__link <?= $navActive('/contact') ?>"
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


<!-- =======================================================
     QUICK SERVICES
======================================================== -->

<div class="site-services">

    <div class="container site-services__inner">

        <div class="site-services__group">

            <a
                href="<?= View::escape(
                    $webmailUrl
                ) ?>"
                target="_blank"
                rel="noopener noreferrer"
            >
                پست الکترونیکی
            </a>


            <a
                href="<?= View::escape(
                    $universitySystemUrl
                ) ?>"
                target="_blank"
                rel="noopener noreferrer"
            >
                سامانه دانشگاه
            </a>


            <a
                href="<?= View::url(
                    '/documents'
                ) ?>"
            >
                فرم‌ها و آیین‌نامه‌ها
            </a>


            <a
                href="<?= View::url(
                    '/search'
                ) ?>"
            >
                جستجو
            </a>

        </div>


        <div class="site-services__language">

            <a
                href="<?= View::url(
                    '/english'
                ) ?>"
                lang="en"
            >
                English
            </a>

        </div>

    </div>

</div>


<!-- =======================================================
     FLASH MESSAGES
======================================================== -->

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


<!-- =======================================================
     MAIN CONTENT
======================================================== -->

<main>

    <?= $content ?>

</main>


<!-- =======================================================
     FOOTER
======================================================== -->

<footer class="site-footer">

    <div class="container">

        <div class="site-footer__grid">

            <!-- Institution -->

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


            <!-- Main links -->

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


            <!-- Services -->

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


            <!-- Contact -->

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


        <!-- Footer bottom -->

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


<!-- =======================================================
     JAVASCRIPT
======================================================== -->

<script
    src="<?= View::asset(
        'js/app.js'
    ) ?>"
    defer
></script>


</body>

</html>
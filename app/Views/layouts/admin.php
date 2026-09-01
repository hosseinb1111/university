<?php

declare(strict_types=1);

use App\Core\Session;
use App\Core\View;


/*
|--------------------------------------------------------------------------
| Admin layout data
|--------------------------------------------------------------------------
*/

$user =
    $user
    ?? Session::user();


$title =
    $title
    ?? 'پنل مدیریت | صدرا';


/*
|---------------------------------------------------------------------------
| Current request path
|---------------------------------------------------------------------------
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
    $currentPath =
        '/admin';
}


/*
|---------------------------------------------------------------------------
| Admin section context
|---------------------------------------------------------------------------
|
| The Persian and English administration panels share the same shell.
| English administration is still Persian-language in the control panel,
| but receives its own context flag so the sidebar/header can distinguish
| English management pages from Persian content management pages.
|
*/

$isEnglishAdmin =
    $currentPath === '/admin/english'
    || str_starts_with(
        $currentPath,
        '/admin/english/'
    );


$adminSection =
    $isEnglishAdmin
        ? 'english'
        : 'persian';


/*
|---------------------------------------------------------------------------
| CSS assets
|---------------------------------------------------------------------------
|
| admin.css
|     Global admin shell, dashboard, forms, tables and shared components.
|
| services.css
|     Homepage services / institution-specific admin styling.
|
| admin-users.css
|     User management pages.
|
| admin-announcements.css
|     Announcement management pages.
|
| admin-faculties.css
|     Faculty management pages.
|
| admin-programs.css
|     Program management pages.
|
| admin-people.css
|     People management pages.
|
| admin-research-centers.css
|     Research-center management pages.
|
| admin-documents.css
|     Document management pages.
|
| admin-navigation.css
|     Navigation management pages.
|
| admin-pages.css
|     Website page management pages.
|
| media.css
|     Media library and media upload pages.
|
| jalali-datepicker.css
|     Jalali datepicker support.
|
| admin/english.css
|     English CMS administration pages.
|
|---------------------------------------------------------------------------
*/

$adminCss =
    View::asset(
        'css/admin.css'
    );


$servicesCss =
    View::asset(
        'css/services.css'
    );


$adminUsersCss =
    View::asset(
        'css/admin-users.css'
    );


$adminAnnouncementsCss =
    View::asset(
        'css/admin-announcements.css'
    );


$adminFacultiesCss =
    View::asset(
        'css/admin-faculties.css'
    );


$adminProgramsCss =
    View::asset(
        'css/admin-programs.css'
    );


$adminPeopleCss =
    View::asset(
        'css/admin-people.css'
    );


$adminResearchCentersCss =
    View::asset(
        'css/admin-research-centers.css'
    );


$adminDocumentsCss =
    View::asset(
        'css/admin-documents.css'
    );


$adminNavigationCss =
    View::asset(
        'css/admin-navigation.css'
    );


$adminPagesCss =
    View::asset(
        'css/admin-pages.css'
    );


$mediaCss =
    View::asset(
        'css/media.css'
    );


$jalaliCss =
    View::asset(
        'css/jalali-datepicker.css'
    );


$englishAdminCss =
    View::asset(
        'css/admin/english.css'
    );


/*
|---------------------------------------------------------------------------
| JavaScript assets
|---------------------------------------------------------------------------
*/

$adminJs =
    View::asset(
        'js/admin.js'
    );


$jalaliJs =
    View::asset(
        'js/jalali-datepicker.js'
    );

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
        content="width=device-width, initial-scale=1"
    >


    <meta
        name="theme-color"
        content="#172033"
    >


    <title>
        <?= View::escape(
            $title
        ) ?>
    </title>


    <!-- =========================================================
         CORE ADMIN CSS
    ========================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::escape(
            $adminCss
        ) ?>?v=12"
    >


    <!-- =========================================================
         SERVICES CSS
    ========================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::escape(
            $servicesCss
        ) ?>?v=3"
    >


    <!-- =========================================================
         USERS CSS
    ========================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::escape(
            $adminUsersCss
        ) ?>?v=3"
    >


    <!-- =========================================================
         ANNOUNCEMENTS CSS
    ========================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::escape(
            $adminAnnouncementsCss
        ) ?>?v=7"
    >


    <!-- =========================================================
         FACULTIES CSS
    ========================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::escape(
            $adminFacultiesCss
        ) ?>?v=6"
    >


    <!-- =========================================================
         PROGRAMS CSS
    ========================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::escape(
            $adminProgramsCss
        ) ?>?v=6"
    >


    <!-- =========================================================
         PEOPLE CSS
    ========================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::escape(
            $adminPeopleCss
        ) ?>?v=5"
    >


    <!-- =========================================================
         RESEARCH CENTERS CSS
    ========================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::escape(
            $adminResearchCentersCss
        ) ?>?v=4"
    >


    <!-- =========================================================
         DOCUMENTS CSS
    ========================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::escape(
            $adminDocumentsCss
        ) ?>?v=3"
    >


    <!-- =========================================================
         NAVIGATION CSS
    ========================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::escape(
            $adminNavigationCss
        ) ?>?v=2"
    >


    <!-- =========================================================
         PAGES CSS
    ========================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::escape(
            $adminPagesCss
        ) ?>?v=2"
    >


    <!-- =========================================================
         MEDIA CSS
    ========================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::escape(
            $mediaCss
        ) ?>?v=5"
    >


    <!-- =========================================================
         JALALI DATEPICKER CSS
    ========================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::escape(
            $jalaliCss
        ) ?>?v=4"
    >


    <!-- =========================================================
         ENGLISH CMS ADMIN CSS
    ========================================================== -->

    <link
        rel="stylesheet"
        href="<?= View::escape(
            $englishAdminCss
        ) ?>?v=4"
    >

</head>


<body
    class="
        admin-body
        <?= $isEnglishAdmin
            ? 'admin-body--english'
            : 'admin-body--persian'
        ?>
    "
>


<div
    class="
        admin-layout
        <?= $isEnglishAdmin
            ? 'admin-layout--english'
            : 'admin-layout--persian'
        ?>
    "
>


    <!-- =========================================================
         SIDEBAR
    ========================================================== -->

    <aside
        class="admin-sidebar"
        id="admin-sidebar"
    >

        <?php

        echo View::render(
            'admin/partials/sidebar',
            [
                'user' =>
                    $user,

                'currentPath' =>
                    $currentPath,

                /*
                 * Shared sidebar context.
                 *
                 * Existing sidebar implementations that do not use
                 * these values remain fully compatible.
                 */
                'isEnglishAdmin' =>
                    $isEnglishAdmin,

                'adminSection' =>
                    $adminSection,
            ]
        );

        ?>

    </aside>


    <!-- =========================================================
         MAIN AREA
    ========================================================== -->

    <div class="admin-main">


        <!-- =====================================================
             HEADER
        ====================================================== -->

        <header class="admin-header">

            <?php

            echo View::render(
                'admin/partials/header',
                [
                    'user' =>
                        $user,

                    'title' =>
                        $title,

                    'currentPath' =>
                        $currentPath,

                    /*
                     * Pass the same section context to the shared
                     * admin header so it can distinguish English
                     * administration from Persian administration.
                     */
                    'isEnglishAdmin' =>
                        $isEnglishAdmin,

                    'adminSection' =>
                        $adminSection,
                ]
            );

            ?>

        </header>


        <!-- =====================================================
             CONTENT
        ====================================================== -->

        <main
            class="
                admin-content
                <?= $isEnglishAdmin
                    ? 'admin-content--english'
                    : 'admin-content--persian'
                ?>
            "
            id="admin-content"
        >

            <?= $content ?? '' ?>

        </main>

    </div>

</div>


<!-- =============================================================
     JAVASCRIPT
============================================================== -->

<script
    src="<?= View::escape(
        $adminJs
    ) ?>?v=12"
></script>


<script
    src="<?= View::escape(
        $jalaliJs
    ) ?>?v=4"
    defer
></script>


</body>

</html>
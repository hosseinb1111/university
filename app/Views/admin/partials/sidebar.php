<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


/*
|--------------------------------------------------------------------------
| Current path
|--------------------------------------------------------------------------
*/

$currentPath =
    is_string(
        $currentPath
        ?? null
    )
        ? $currentPath
        : '/admin';


/*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
*/

$role =
    (string) (
        $user['role']
        ?? ''
    );


$name =
    trim(
        (string) (
            $user['first_name']
            ?? ''
        )
        . ' '
        . (string) (
            $user['last_name']
            ?? ''
        )
    );


if (
    $name === ''
) {
    $name =
        'کاربر';
}


/*
|--------------------------------------------------------------------------
| Active navigation helper
|--------------------------------------------------------------------------
|
| Important:
|
| The dashboard routes are exact-match routes.
| Section routes may use prefix matching.
|
| This prevents:
|
| /admin/english
|
| from incorrectly remaining active on:
|
| /admin/english/home
| /admin/english/slides
| /admin/english/services
| etc.
|
*/

$adminNavActive =
    static function (
        string $currentPath,
        string $path
    ): string {

        /*
         * Dashboard pages must be exact.
         */
        if (
            $path === '/admin'
            || $path === '/admin/english'
        ) {
            return $currentPath === $path
                ? 'admin-nav__link--active'
                : '';
        }


        /*
         * Other navigation entries may represent
         * a route family.
         */
        return str_starts_with(
            $currentPath,
            $path
        )
            ? 'admin-nav__link--active'
            : '';
    };


/*
|--------------------------------------------------------------------------
| English section state
|--------------------------------------------------------------------------
*/

$englishSectionActive =
    $currentPath === '/admin/english'
    || str_starts_with(
        $currentPath,
        '/admin/english/'
    );


/*
|--------------------------------------------------------------------------
| Role label
|--------------------------------------------------------------------------
*/

$roleLabel =
    match (
        $role
    ) {
        'super_admin' =>
            'مدیر ارشد',

        'admin' =>
            'مدیر',

        'editor' =>
            'ویراستار',

        'teacher' =>
            'عضو هیئت علمی',

        default =>
            'کاربر',
    };

?>


<div class="admin-sidebar__top">

    <a
        href="<?= View::url(
            '/admin'
        ) ?>"
        class="admin-brand"
    >

        <div class="admin-brand__logo">
            ص
        </div>


        <div class="admin-brand__text">

            <strong>
                موسسه صدرا
            </strong>

            <span>
                پنل مدیریت
            </span>

        </div>

    </a>


    <button
        type="button"
        class="admin-sidebar__close"
        id="admin-sidebar-close"
        aria-label="بستن منو"
    >
        ×
    </button>

</div>


<!-- ============================================================
     USER
============================================================= -->

<div class="admin-sidebar__user">

    <div class="admin-sidebar__avatar">

        <?= htmlspecialchars(
            mb_substr(
                $name,
                0,
                1,
                'UTF-8'
            ),
            ENT_QUOTES
            | ENT_SUBSTITUTE,
            'UTF-8'
        ) ?>

    </div>


    <div class="admin-sidebar__user-info">

        <strong>

            <?= htmlspecialchars(
                $name,
                ENT_QUOTES
                | ENT_SUBSTITUTE,
                'UTF-8'
            ) ?>

        </strong>


        <span>

            <?= htmlspecialchars(
                $roleLabel,
                ENT_QUOTES
                | ENT_SUBSTITUTE,
                'UTF-8'
            ) ?>

        </span>

    </div>

</div>


<nav
    class="admin-nav"
    aria-label="منوی مدیریت"
>


    <!-- ========================================================
         CONTENT MANAGEMENT
    ========================================================= -->

    <div class="admin-nav__label">
        مدیریت محتوا
    </div>


    <!-- =====================================================
         Dashboard
    ====================================================== -->

    <a
        href="<?= View::url(
            '/admin'
        ) ?>"
        class="admin-nav__link <?= $adminNavActive(
            $currentPath,
            '/admin'
        ) ?>"
    >

        <span class="admin-nav__icon">
            ⊞
        </span>

        <span>
            داشبورد
        </span>

    </a>


    <!-- =====================================================
         Persian Homepage Slider
    ====================================================== -->

    <a
        href="<?= View::url(
            '/admin/slides'
        ) ?>"
        class="admin-nav__link <?= $adminNavActive(
            $currentPath,
            '/admin/slides'
        ) ?>"
    >

        <span class="admin-nav__icon">
            🖼
        </span>

        <span>
            اسلایدر صفحه اصلی
        </span>

    </a>


    <!-- =====================================================
         Persian Slider Settings
    ====================================================== -->

    <a
        href="<?= View::url(
            '/admin/slider-settings'
        ) ?>"
        class="admin-nav__link <?= $adminNavActive(
            $currentPath,
            '/admin/slider-settings'
        ) ?>"
    >

        <span class="admin-nav__icon">
            🎞
        </span>

        <span>
            تنظیمات اسلایدر
        </span>

    </a>


    <!-- =====================================================
         Persian Homepage Services
    ====================================================== -->

    <a
        href="<?= View::url(
            '/admin/services'
        ) ?>"
        class="admin-nav__link <?= $adminNavActive(
            $currentPath,
            '/admin/services'
        ) ?>"
    >

        <span class="admin-nav__icon">
            🔗
        </span>

        <span>
            خدمات صفحه اصلی
        </span>

    </a>


    <!-- =====================================================
         Persian Announcements
    ====================================================== -->

    <a
        href="<?= View::url(
            '/admin/announcements'
        ) ?>"
        class="admin-nav__link <?= $adminNavActive(
            $currentPath,
            '/admin/announcements'
        ) ?>"
    >

        <span class="admin-nav__icon">
            📢
        </span>

        <span>
            اطلاعیه‌ها
        </span>

    </a>


    <!-- =====================================================
         Persian Pages
    ====================================================== -->

    <a
        href="<?= View::url(
            '/admin/pages'
        ) ?>"
        class="admin-nav__link <?= $adminNavActive(
            $currentPath,
            '/admin/pages'
        ) ?>"
    >

        <span class="admin-nav__icon">
            📄
        </span>

        <span>
            صفحات سایت
        </span>

    </a>


    <!-- =====================================================
         Navigation
    ====================================================== -->

    <a
        href="<?= View::url(
            '/admin/navigation'
        ) ?>"
        class="admin-nav__link <?= $adminNavActive(
            $currentPath,
            '/admin/navigation'
        ) ?>"
    >

        <span class="admin-nav__icon">
            ☰
        </span>

        <span>
            منوی سایت
        </span>

    </a>


    <!-- =====================================================
         Documents
    ====================================================== -->

    <a
        href="<?= View::url(
            '/admin/documents'
        ) ?>"
        class="admin-nav__link <?= $adminNavActive(
            $currentPath,
            '/admin/documents'
        ) ?>"
    >

        <span class="admin-nav__icon">
            📁
        </span>

        <span>
            اسناد و فرم‌ها
        </span>

    </a>


    <!-- =====================================================
         Media
    ====================================================== -->

    <a
        href="<?= View::url(
            '/admin/media'
        ) ?>"
        class="admin-nav__link <?= $adminNavActive(
            $currentPath,
            '/admin/media'
        ) ?>"
    >

        <span class="admin-nav__icon">
            🖼
        </span>

        <span>
            کتابخانه رسانه
        </span>

    </a>


    <!-- ========================================================
         ENGLISH WEBSITE
    ========================================================= -->

    <div
        class="
            admin-nav__label
            admin-nav__label--english
            <?= $englishSectionActive
                ? 'admin-nav__label--active'
                : ''
            ?>
        "
    >
        سایت انگلیسی
    </div>


    <div
        class="
            admin-nav__english-group
            <?= $englishSectionActive
                ? 'admin-nav__english-group--active'
                : ''
            ?>
        "
    >


        <!-- =====================================================
             English Dashboard
        ====================================================== -->

        <a
            href="<?= View::url(
                '/admin/english'
            ) ?>"
            class="
                admin-nav__link
                admin-nav__link--english
                <?= $adminNavActive(
                    $currentPath,
                    '/admin/english'
                ) ?>
            "
        >

            <span class="admin-nav__icon">
                🌐
            </span>

            <span>
                داشبورد انگلیسی
            </span>

        </a>


        <!-- =====================================================
             English Homepage
        ====================================================== -->

        <a
            href="<?= View::url(
                '/admin/english/home'
            ) ?>"
            class="
                admin-nav__link
                admin-nav__link--english
                <?= $adminNavActive(
                    $currentPath,
                    '/admin/english/home'
                ) ?>
            "
        >

            <span class="admin-nav__icon">
                🏠
            </span>

            <span>
                صفحه اصلی انگلیسی
            </span>

        </a>


        <!-- =====================================================
             English Homepage Slider
        ====================================================== -->

        <a
            href="<?= View::url(
                '/admin/english/slides'
            ) ?>"
            class="
                admin-nav__link
                admin-nav__link--english
                <?= $adminNavActive(
                    $currentPath,
                    '/admin/english/slides'
                ) ?>
            "
        >

            <span class="admin-nav__icon">
                🖼
            </span>

            <span>
                اسلایدهای صفحه اصلی انگلیسی
            </span>

        </a>


        <!-- =====================================================
             English Slider Settings
        ====================================================== -->

        <a
            href="<?= View::url(
                '/admin/english/slider'
            ) ?>"
            class="
                admin-nav__link
                admin-nav__link--english
                <?= $adminNavActive(
                    $currentPath,
                    '/admin/english/slider'
                ) ?>
            "
        >

            <span class="admin-nav__icon">
                🎞
            </span>

            <span>
                تنظیمات اسلایدر انگلیسی
            </span>

        </a>


        <!-- =====================================================
             English Homepage Services
        ====================================================== -->

        <a
            href="<?= View::url(
                '/admin/english/services'
            ) ?>"
            class="
                admin-nav__link
                admin-nav__link--english
                <?= $adminNavActive(
                    $currentPath,
                    '/admin/english/services'
                ) ?>
            "
        >

            <span class="admin-nav__icon">
                🔗
            </span>

            <span>
                خدمات صفحه اصلی انگلیسی
            </span>

        </a>


        <!-- =====================================================
             English Static Pages
        ====================================================== -->

        <div
            class="
                admin-nav__sub-label
                admin-nav__sub-label--english
            "
        >
            صفحات انگلیسی
        </div>


        <!-- About -->

        <a
            href="<?= View::url(
                '/admin/english/pages/about'
            ) ?>"
            class="
                admin-nav__link
                admin-nav__link--english
                admin-nav__link--english-sub
                <?= $adminNavActive(
                    $currentPath,
                    '/admin/english/pages/about'
                ) ?>
            "
        >

            <span class="admin-nav__icon">
                ℹ
            </span>

            <span>
                درباره انگلیسی
            </span>

        </a>


        <!-- Presidency -->

        <a
            href="<?= View::url(
                '/admin/english/pages/presidency'
            ) ?>"
            class="
                admin-nav__link
                admin-nav__link--english
                admin-nav__link--english-sub
                <?= $adminNavActive(
                    $currentPath,
                    '/admin/english/pages/presidency'
                ) ?>
            "
        >

            <span class="admin-nav__icon">
                👤
            </span>

            <span>
                ریاست انگلیسی
            </span>

        </a>


        <!-- Faculties page -->

        <a
            href="<?= View::url(
                '/admin/english/pages/faculties'
            ) ?>"
            class="
                admin-nav__link
                admin-nav__link--english
                admin-nav__link--english-sub
                <?= $adminNavActive(
                    $currentPath,
                    '/admin/english/pages/faculties'
                ) ?>
            "
        >

            <span class="admin-nav__icon">
                🎓
            </span>

            <span>
                صفحه دانشکده‌های انگلیسی
            </span>

        </a>


        <!-- Programs page -->

        <a
            href="<?= View::url(
                '/admin/english/pages/programs'
            ) ?>"
            class="
                admin-nav__link
                admin-nav__link--english
                admin-nav__link--english-sub
                <?= $adminNavActive(
                    $currentPath,
                    '/admin/english/pages/programs'
                ) ?>
            "
        >

            <span class="admin-nav__icon">
                📚
            </span>

            <span>
                صفحه رشته‌های انگلیسی
            </span>

        </a>


        <!-- Research page -->

        <a
            href="<?= View::url(
                '/admin/english/pages/research'
            ) ?>"
            class="
                admin-nav__link
                admin-nav__link--english
                admin-nav__link--english-sub
                <?= $adminNavActive(
                    $currentPath,
                    '/admin/english/pages/research'
                ) ?>
            "
        >

            <span class="admin-nav__icon">
                🔬
            </span>

            <span>
                صفحه پژوهش انگلیسی
            </span>

        </a>


        <!-- Announcements page -->

        <a
            href="<?= View::url(
                '/admin/english/pages/announcements'
            ) ?>"
            class="
                admin-nav__link
                admin-nav__link--english
                admin-nav__link--english-sub
                <?= $adminNavActive(
                    $currentPath,
                    '/admin/english/pages/announcements'
                ) ?>
            "
        >

            <span class="admin-nav__icon">
                📢
            </span>

            <span>
                صفحه اطلاعیه‌های انگلیسی
            </span>

        </a>


        <!-- Contact page -->

        <a
            href="<?= View::url(
                '/admin/english/pages/contact'
            ) ?>"
            class="
                admin-nav__link
                admin-nav__link--english
                admin-nav__link--english-sub
                <?= $adminNavActive(
                    $currentPath,
                    '/admin/english/pages/contact'
                ) ?>
            "
        >

            <span class="admin-nav__icon">
                ✉
            </span>

            <span>
                صفحه تماس انگلیسی
            </span>

        </a>


        <!-- =====================================================
             English Content
        ====================================================== -->

        <div
            class="
                admin-nav__sub-label
                admin-nav__sub-label--english
            "
        >
            محتوای انگلیسی
        </div>


        <!-- English Announcements -->

        <a
            href="<?= View::url(
                '/admin/english/announcements'
            ) ?>"
            class="
                admin-nav__link
                admin-nav__link--english
                <?= $adminNavActive(
                    $currentPath,
                    '/admin/english/announcements'
                ) ?>
            "
        >

            <span class="admin-nav__icon">
                📣
            </span>

            <span>
                اطلاعیه‌های انگلیسی
            </span>

        </a>


        <!-- English Faculties -->

        <a
            href="<?= View::url(
                '/admin/english/faculties'
            ) ?>"
            class="
                admin-nav__link
                admin-nav__link--english
                <?= $adminNavActive(
                    $currentPath,
                    '/admin/english/faculties'
                ) ?>
            "
        >

            <span class="admin-nav__icon">
                🎓
            </span>

            <span>
                دانشکده‌های انگلیسی
            </span>

        </a>


        <!-- English Programs -->

        <a
            href="<?= View::url(
                '/admin/english/programs'
            ) ?>"
            class="
                admin-nav__link
                admin-nav__link--english
                <?= $adminNavActive(
                    $currentPath,
                    '/admin/english/programs'
                ) ?>
            "
        >

            <span class="admin-nav__icon">
                📚
            </span>

            <span>
                رشته‌های انگلیسی
            </span>

        </a>


        <!-- English People -->

        <a
            href="<?= View::url(
                '/admin/english/people'
            ) ?>"
            class="
                admin-nav__link
                admin-nav__link--english
                <?= $adminNavActive(
                    $currentPath,
                    '/admin/english/people'
                ) ?>
            "
        >

            <span class="admin-nav__icon">
                👨‍🏫
            </span>

            <span>
                افراد و اعضای انگلیسی
            </span>

        </a>


        <!-- English Research Centers -->

        <a
            href="<?= View::url(
                '/admin/english/research-centers'
            ) ?>"
            class="
                admin-nav__link
                admin-nav__link--english
                <?= $adminNavActive(
                    $currentPath,
                    '/admin/english/research-centers'
                ) ?>
            "
        >

            <span class="admin-nav__icon">
                🔬
            </span>

            <span>
                مراکز پژوهشی انگلیسی
            </span>

        </a>

    </div>


    <!-- ========================================================
         EDUCATION & RESEARCH
    ========================================================= -->

    <div class="admin-nav__label">
        آموزش و پژوهش
    </div>


    <!-- Faculties -->

    <a
        href="<?= View::url(
            '/admin/faculties'
        ) ?>"
        class="admin-nav__link <?= $adminNavActive(
            $currentPath,
            '/admin/faculties'
        ) ?>"
    >

        <span class="admin-nav__icon">
            🎓
        </span>

        <span>
            دانشکده‌ها
        </span>

    </a>


    <!-- Programs -->

    <a
        href="<?= View::url(
            '/admin/programs'
        ) ?>"
        class="admin-nav__link <?= $adminNavActive(
            $currentPath,
            '/admin/programs'
        ) ?>"
    >

        <span class="admin-nav__icon">
            📚
        </span>

        <span>
            رشته‌ها و برنامه‌ها
        </span>

    </a>


    <!-- Research Centers -->

    <a
        href="<?= View::url(
            '/admin/research-centers'
        ) ?>"
        class="admin-nav__link <?= $adminNavActive(
            $currentPath,
            '/admin/research-centers'
        ) ?>"
    >

        <span class="admin-nav__icon">
            🔬
        </span>

        <span>
            پژوهشکده‌ها
        </span>

    </a>


    <!-- People -->

    <a
        href="<?= View::url(
            '/admin/people'
        ) ?>"
        class="admin-nav__link <?= $adminNavActive(
            $currentPath,
            '/admin/people'
        ) ?>"
    >

        <span class="admin-nav__icon">
            👨‍🏫
        </span>

        <span>
            اعضای هیئت علمی و کارکنان
        </span>

    </a>


    <!-- ========================================================
         SYSTEM MANAGEMENT
    ========================================================= -->

    <?php if (
        in_array(
            $role,
            [
                'admin',
                'super_admin',
            ],
            true
        )
    ): ?>

        <div class="admin-nav__label">
            مدیریت سیستم
        </div>


        <!-- Users -->

        <a
            href="<?= View::url(
                '/admin/users'
            ) ?>"
            class="admin-nav__link <?= $adminNavActive(
                $currentPath,
                '/admin/users'
            ) ?>"
        >

            <span class="admin-nav__icon">
                👥
            </span>

            <span>
                کاربران
            </span>

        </a>

    <?php endif; ?>


    <?php if (
        $role === 'super_admin'
    ): ?>

        <!-- Settings -->

        <a
            href="<?= View::url(
                '/admin/settings'
            ) ?>"
            class="admin-nav__link <?= $adminNavActive(
                $currentPath,
                '/admin/settings'
            ) ?>"
        >

            <span class="admin-nav__icon">
                ⚙
            </span>

            <span>
                تنظیمات سیستم
            </span>

        </a>

    <?php endif; ?>

</nav>


<!-- ============================================================
     SIDEBAR BOTTOM
============================================================= -->

<div class="admin-sidebar__bottom">

    <!-- Persian website -->

    <a
        href="<?= View::url(
            '/'
        ) ?>"
        class="admin-sidebar__website"
    >
        ↗ مشاهده سایت
    </a>


    <!-- English website -->

    <a
        href="<?= View::url(
            '/english'
        ) ?>"
        target="_blank"
        rel="noopener noreferrer"
        class="
            admin-sidebar__website
            admin-sidebar__website--english
        "
    >
        🌐 مشاهده سایت انگلیسی
    </a>


    <!-- Logout -->

    <form
        method="POST"
        action="<?= View::url(
            '/teacher/logout'
        ) ?>"
    >

        <?= Csrf::field() ?>


        <button
            type="submit"
            class="admin-sidebar__logout"
        >
            خروج از حساب
        </button>

    </form>

</div>


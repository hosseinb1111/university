<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;

$currentPath =
    is_string($currentPath ?? null)
        ? $currentPath
        : '/admin';

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
    $name = 'کاربر';
}


/*
|--------------------------------------------------------------------------
| Active navigation helper
|--------------------------------------------------------------------------
*/

$adminNavActive =
    static function (
        string $currentPath,
        string $path
    ): string {
        if (
            $path === '/admin'
        ) {
            return $currentPath === '/admin'
                ? 'admin-nav__link--active'
                : '';
        }

        return str_starts_with(
            $currentPath,
            $path
        )
            ? 'admin-nav__link--active'
            : '';
    };


/*
|--------------------------------------------------------------------------
| Role label
|--------------------------------------------------------------------------
*/

$roleLabel =
    match ($role) {
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
        href="<?= View::url('/admin') ?>"
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


<div class="admin-sidebar__user">

    <div class="admin-sidebar__avatar">

        <?= htmlspecialchars(
            mb_substr(
                $name,
                0,
                1,
                'UTF-8'
            ),
            ENT_QUOTES | ENT_SUBSTITUTE,
            'UTF-8'
        ) ?>

    </div>


    <div class="admin-sidebar__user-info">

        <strong>
            <?= htmlspecialchars(
                $name,
                ENT_QUOTES | ENT_SUBSTITUTE,
                'UTF-8'
            ) ?>
        </strong>

        <span>
            <?= htmlspecialchars(
                $roleLabel,
                ENT_QUOTES | ENT_SUBSTITUTE,
                'UTF-8'
            ) ?>
        </span>

    </div>

</div>


<nav
    class="admin-nav"
    aria-label="منوی مدیریت"
>


    <!-- =====================================================
         CONTENT MANAGEMENT
    ====================================================== -->

    <div class="admin-nav__label">
        مدیریت محتوا
    </div>


    <a
        href="<?= View::url('/admin') ?>"
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


    <!-- Homepage slider -->

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


    <!-- Announcements -->

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


    <!-- Pages -->

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


    <!-- Navigation -->

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


    <!-- Documents -->

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


    <!-- Media -->

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


    <!-- =====================================================
         EDUCATION & RESEARCH
    ====================================================== -->

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


    <!-- Research centers -->

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


    <!-- =====================================================
         SYSTEM MANAGEMENT
    ====================================================== -->

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


<div class="admin-sidebar__bottom">


    <a
        href="<?= View::url('/') ?>"
        class="admin-sidebar__website"
    >
        ↗ مشاهده سایت
    </a>


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
<?php

declare(strict_types=1);

$name =
    trim(
        ($user['first_name'] ?? '')
        . ' '
        . ($user['last_name'] ?? '')
    );

if (
    $name === ''
) {
    $name = 'کاربر';
}


/*
|--------------------------------------------------------------------------
| Dashboard statistics
|--------------------------------------------------------------------------
*/

$stats =
    is_array(
        $stats ?? null
    )
        ? $stats
        : [];

$announcementsCount =
    (int) (
        $stats['announcements']
        ?? 0
    );

$pagesCount =
    (int) (
        $stats['pages']
        ?? 0
    );

$documentsCount =
    (int) (
        $stats['documents']
        ?? 0
    );

$facultiesCount =
    (int) (
        $stats['faculties']
        ?? 0
    );

$programsCount =
    (int) (
        $stats['programs']
        ?? 0
    );

$peopleCount =
    (int) (
        $stats['people']
        ?? 0
    );

$researchCentersCount =
    (int) (
        $stats['researchCenters']
        ?? 0
    );

$slidesCount =
    (int) (
        $stats['slides']
        ?? 0
    );

$servicesCount =
    (int) (
        $stats['services']
        ?? 0
    );

?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>

            <h1>
                داشبورد
            </h1>

            <p>
                خوش آمدید
                <?= htmlspecialchars(
                    $name,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
                👋
            </p>

        </div>

    </div>


    <!-- =========================================================
         CONTENT STATISTICS
    ========================================================== -->

    <div class="admin-stats">

        <div class="admin-stat-card">

            <div class="admin-stat-card__icon">
                📢
            </div>

            <div>

                <span>
                    اطلاعیه‌ها
                </span>

                <strong>
                    <?= $announcementsCount ?>
                </strong>

            </div>

        </div>


        <div class="admin-stat-card">

            <div class="admin-stat-card__icon">
                📄
            </div>

            <div>

                <span>
                    صفحات
                </span>

                <strong>
                    <?= $pagesCount ?>
                </strong>

            </div>

        </div>


        <div class="admin-stat-card">

            <div class="admin-stat-card__icon">
                📁
            </div>

            <div>

                <span>
                    اسناد
                </span>

                <strong>
                    <?= $documentsCount ?>
                </strong>

            </div>

        </div>


        <div class="admin-stat-card">

            <div class="admin-stat-card__icon">
                🎓
            </div>

            <div>

                <span>
                    دانشکده‌ها
                </span>

                <strong>
                    <?= $facultiesCount ?>
                </strong>

            </div>

        </div>


        <div class="admin-stat-card">

            <div class="admin-stat-card__icon">
                📚
            </div>

            <div>

                <span>
                    رشته‌ها
                </span>

                <strong>
                    <?= $programsCount ?>
                </strong>

            </div>

        </div>


        <div class="admin-stat-card">

            <div class="admin-stat-card__icon">
                👥
            </div>

            <div>

                <span>
                    اعضا
                </span>

                <strong>
                    <?= $peopleCount ?>
                </strong>

            </div>

        </div>


        <div class="admin-stat-card">

            <div class="admin-stat-card__icon">
                🔬
            </div>

            <div>

                <span>
                    پژوهشکده‌ها
                </span>

                <strong>
                    <?= $researchCentersCount ?>
                </strong>

            </div>

        </div>


        <div class="admin-stat-card">

            <div class="admin-stat-card__icon">
                🖼
            </div>

            <div>

                <span>
                    اسلایدها
                </span>

                <strong>
                    <?= $slidesCount ?>
                </strong>

            </div>

        </div>

    </div>


    <!-- =========================================================
         DASHBOARD GRID
    ========================================================== -->

    <div class="admin-dashboard-grid">


        <!-- =====================================================
             QUICK ACTIONS
        ====================================================== -->

        <section class="admin-panel">

            <div class="admin-panel__header">

                <div>

                    <h2>
                        دسترسی سریع
                    </h2>

                    <p>
                        مدیریت بخش‌های مختلف سایت
                    </p>

                </div>

            </div>


            <div class="admin-quick-actions">

                <a
                    href="/admin/announcements"
                    class="admin-quick-action"
                >

                    <span>
                        📢
                    </span>

                    <strong>
                        اطلاعیه‌ها
                    </strong>

                </a>


                <a
                    href="/admin/pages"
                    class="admin-quick-action"
                >

                    <span>
                        📄
                    </span>

                    <strong>
                        صفحات سایت
                    </strong>

                </a>


                <a
                    href="/admin/documents"
                    class="admin-quick-action"
                >

                    <span>
                        📁
                    </span>

                    <strong>
                        اسناد
                    </strong>

                </a>


                <a
                    href="/admin/faculties"
                    class="admin-quick-action"
                >

                    <span>
                        🎓
                    </span>

                    <strong>
                        دانشکده‌ها
                    </strong>

                </a>


                <a
                    href="/admin/programs"
                    class="admin-quick-action"
                >

                    <span>
                        📚
                    </span>

                    <strong>
                        رشته‌ها و برنامه‌ها
                    </strong>

                </a>


                <a
                    href="/admin/people"
                    class="admin-quick-action"
                >

                    <span>
                        👥
                    </span>

                    <strong>
                        اعضای هیئت علمی و کارکنان
                    </strong>

                </a>


                <a
                    href="/admin/research-centers"
                    class="admin-quick-action"
                >

                    <span>
                        🔬
                    </span>

                    <strong>
                        پژوهشکده‌ها
                    </strong>

                </a>


                <a
                    href="/admin/services"
                    class="admin-quick-action"
                >

                    <span>
                        🔗
                    </span>

                    <strong>
                        خدمات صفحه اصلی
                    </strong>

                </a>


                <a
                    href="/admin/slides"
                    class="admin-quick-action"
                >

                    <span>
                        🖼
                    </span>

                    <strong>
                        اسلایدر صفحه اصلی
                    </strong>

                </a>

            </div>

        </section>


        <!-- =====================================================
             SYSTEM STATUS
        ====================================================== -->

        <section class="admin-panel">

            <div class="admin-panel__header">

                <div>

                    <h2>
                        وضعیت سیستم
                    </h2>

                    <p>
                        وضعیت فعلی سامانه
                    </p>

                </div>

            </div>


            <div class="admin-system-status">

                <div class="admin-status-item">

                    <span>
                        وضعیت سامانه
                    </span>

                    <strong
                        class="admin-status--success"
                    >
                        فعال
                    </strong>

                </div>


                <div class="admin-status-item">

                    <span>
                        نقش شما
                    </span>

                    <strong>
                        <?= htmlspecialchars(
                            $user['role']
                            ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </strong>

                </div>


                <div class="admin-status-item">

                    <span>
                        دانشکده‌ها
                    </span>

                    <strong>
                        <?= $facultiesCount ?>
                    </strong>

                </div>


                <div class="admin-status-item">

                    <span>
                        رشته‌ها
                    </span>

                    <strong>
                        <?= $programsCount ?>
                    </strong>

                </div>


                <div class="admin-status-item">

                    <span>
                        اعضای ثبت‌شده
                    </span>

                    <strong>
                        <?= $peopleCount ?>
                    </strong>

                </div>


                <div class="admin-status-item">

                    <span>
                        خدمات صفحه اصلی
                    </span>

                    <strong>
                        <?= $servicesCount ?>
                    </strong>

                </div>

            </div>

        </section>

    </div>

</div>
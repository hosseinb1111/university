<?php

declare(strict_types=1);

$name = trim(
    ($user['first_name'] ?? '')
    . ' '
    . ($user['last_name'] ?? '')
);

if ($name === '') {
    $name = 'کاربر';
}

?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>

            <h1>
                داشبورد
            </h1>

            <p>
                خوش آمدید <?= htmlspecialchars(
                    $name,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?> 👋
            </p>

        </div>

    </div>


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
                    --
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
                    --
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
                    --
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
                    --
                </strong>

            </div>

        </div>

    </div>


    <div class="admin-dashboard-grid">

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

            </div>

        </section>


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

                    <strong class="admin-status--success">
                        فعال
                    </strong>

                </div>


                <div class="admin-status-item">

                    <span>
                        نقش شما
                    </span>

                    <strong>
                        <?= htmlspecialchars(
                            $user['role'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </strong>

                </div>

            </div>

        </section>

    </div>

</div>
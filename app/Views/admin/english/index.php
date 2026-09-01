<?php

declare(strict_types=1);

use App\Core\View;


/*
|--------------------------------------------------------------------------
| Normalize
|--------------------------------------------------------------------------
*/

$stats =
    is_array($stats ?? null)
        ? $stats
        : [];

$slideCount =
    (int) (
        $stats['slides']
        ?? 0
    );

$serviceCount =
    (int) (
        $stats['services']
        ?? 0
    );

$announcementCount =
    (int) (
        $stats['announcements']
        ?? 0
    );

$facultyCount =
    (int) (
        $stats['faculties']
        ?? 0
    );

$programCount =
    (int) (
        $stats['programs']
        ?? 0
    );

$peopleCount =
    (int) (
        $stats['people']
        ?? 0
    );

$researchCount =
    (int) (
        $stats['researchCenters']
        ?? 0
    );

?>

<div class="admin-page">

    <div class="english-admin-dashboard">


        <!-- =========================================================
             HEADER
        ========================================================== -->

        <header class="english-admin-dashboard__header">

            <div class="english-admin-dashboard__header-main">

                <div class="english-admin-dashboard__title-row">

                    <div
                        class="english-admin-dashboard__title-icon"
                        aria-hidden="true"
                    >
                        🌐
                    </div>

                    <div class="english-admin-dashboard__title-content">

                        <span class="english-admin-dashboard__eyebrow">
                            مدیریت محتوای نسخه انگلیسی
                        </span>

                        <h1>
                            سایت انگلیسی
                        </h1>

                        <p>
                            تمام محتوای نسخه انگلیسی سایت را
                            از اینجا مدیریت کنید.
                        </p>

                    </div>

                </div>

            </div>


            <div class="english-admin-dashboard__header-actions">

                <a
                    href="<?= View::url(
                        '/english'
                    ) ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="english-admin-dashboard__preview"
                >
                    مشاهده سایت انگلیسی

                    <span aria-hidden="true">
                        ↗
                    </span>
                </a>

            </div>

        </header>


        <!-- =========================================================
             OVERVIEW
        ========================================================== -->

        <section class="english-admin-dashboard__overview">


            <div class="english-admin-dashboard__overview-card">

                <div
                    class="english-admin-dashboard__overview-icon"
                    aria-hidden="true"
                >
                    🖼️
                </div>

                <div class="english-admin-dashboard__overview-content">

                    <span>
                        اسلایدها
                    </span>

                    <strong>
                        <?= $slideCount ?>
                    </strong>

                    <small>
                        اسلاید فعال در صفحه اصلی
                    </small>

                </div>

            </div>


            <div class="english-admin-dashboard__overview-card">

                <div
                    class="english-admin-dashboard__overview-icon"
                    aria-hidden="true"
                >
                    🔗
                </div>

                <div class="english-admin-dashboard__overview-content">

                    <span>
                        خدمات
                    </span>

                    <strong>
                        <?= $serviceCount ?>
                    </strong>

                    <small>
                        سرویس و پرتال صفحه اصلی
                    </small>

                </div>

            </div>


            <div class="english-admin-dashboard__overview-card">

                <div
                    class="english-admin-dashboard__overview-icon"
                    aria-hidden="true"
                >
                    📢
                </div>

                <div class="english-admin-dashboard__overview-content">

                    <span>
                        اطلاعیه‌ها
                    </span>

                    <strong>
                        <?= $announcementCount ?>
                    </strong>

                    <small>
                        محتوای خبری نسخه انگلیسی
                    </small>

                </div>

            </div>


            <div class="english-admin-dashboard__overview-card">

                <div
                    class="english-admin-dashboard__overview-icon"
                    aria-hidden="true"
                >
                    🎓
                </div>

                <div class="english-admin-dashboard__overview-content">

                    <span>
                        دانشکده‌ها
                    </span>

                    <strong>
                        <?= $facultyCount ?>
                    </strong>

                    <small>
                        ساختار آموزشی
                    </small>

                </div>

            </div>

        </section>


        <!-- =========================================================
             HOMEPAGE
        ========================================================== -->

        <section class="english-admin-dashboard__panel">

            <div class="english-admin-dashboard__panel-header">

                <div>

                    <span>
                        PAGE 01
                    </span>

                    <h2>
                        صفحه اصلی انگلیسی
                    </h2>

                    <p>
                        محتوای اصلی صفحه، اسلایدر، خدمات و تنظیمات
                        نمایش صفحه اصلی را مدیریت کنید.
                    </p>

                </div>

            </div>


            <div class="english-admin-dashboard__section-grid">


                <article
                    class="
                        english-admin-dashboard__section-card
                        english-admin-dashboard__section-card--home
                    "
                >

                    <div class="english-admin-dashboard__section-top">

                        <div
                            class="english-admin-dashboard__section-icon"
                            aria-hidden="true"
                        >
                            🏠
                        </div>

                        <span>
                            HOMEPAGE
                        </span>

                    </div>


                    <h3>
                        محتوای صفحه اصلی
                    </h3>

                    <p>
                        متن‌های هیرو، دسترسی سریع، معرفی موسسه،
                        بخش‌های صفحه و دعوت به تماس.
                    </p>


                    <div class="english-admin-dashboard__section-actions">

                        <a
                            href="<?= View::url(
                                '/admin/english/home'
                            ) ?>"
                            class="english-admin-dashboard__edit"
                        >
                            مدیریت
                        </a>

                        <a
                            href="<?= View::url(
                                '/english'
                            ) ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="english-admin-dashboard__view"
                        >
                            مشاهده
                            <span aria-hidden="true">
                                ↗
                            </span>
                        </a>

                    </div>

                </article>


                <article
                    class="
                        english-admin-dashboard__section-card
                        english-admin-dashboard__section-card--slider
                    "
                >

                    <div class="english-admin-dashboard__section-top">

                        <div
                            class="english-admin-dashboard__section-icon"
                            aria-hidden="true"
                        >
                            🖼️
                        </div>

                        <span>
                            SLIDER
                        </span>

                    </div>


                    <h3>
                        اسلایدهای صفحه اصلی
                    </h3>

                    <p>
                        اسلایدها را ایجاد، ویرایش، حذف، فعال یا
                        غیرفعال کنید و تصاویر دسکتاپ و موبایل را مدیریت کنید.
                    </p>


                    <div class="english-admin-dashboard__section-actions">

                        <a
                            href="<?= View::url(
                                '/admin/english/slides'
                            ) ?>"
                            class="english-admin-dashboard__edit"
                        >
                            مدیریت اسلایدها
                        </a>

                    </div>

                </article>


                <article
                    class="
                        english-admin-dashboard__section-card
                        english-admin-dashboard__section-card--services
                    "
                >

                    <div class="english-admin-dashboard__section-top">

                        <div
                            class="english-admin-dashboard__section-icon"
                            aria-hidden="true"
                        >
                            🔗
                        </div>

                        <span>
                            SERVICES
                        </span>

                    </div>


                    <h3>
                        خدمات و پرتال‌ها
                    </h3>

                    <p>
                        لینک‌ها، عنوان‌ها، تصاویر، ترتیب و وضعیت
                        نمایش سرویس‌های صفحه اصلی را مدیریت کنید.
                    </p>


                    <div class="english-admin-dashboard__section-actions">

                        <a
                            href="<?= View::url(
                                '/admin/english/services'
                            ) ?>"
                            class="english-admin-dashboard__edit"
                        >
                            مدیریت خدمات
                        </a>

                    </div>

                </article>


                <article
                    class="
                        english-admin-dashboard__section-card
                        english-admin-dashboard__section-card--settings
                    "
                >

                    <div class="english-admin-dashboard__section-top">

                        <div
                            class="english-admin-dashboard__section-icon"
                            aria-hidden="true"
                        >
                            ⚙️
                        </div>

                        <span>
                            SETTINGS
                        </span>

                    </div>


                    <h3>
                        تنظیمات اسلایدر
                    </h3>

                    <p>
                        پخش خودکار، زمان‌بندی، فلش‌ها، نقاط،
                        پس‌زمینه و نحوه نمایش تصاویر.
                    </p>


                    <div class="english-admin-dashboard__section-actions">

                        <a
                            href="<?= View::url(
                                '/admin/english/slider'
                            ) ?>"
                            class="english-admin-dashboard__edit"
                        >
                            تنظیمات
                        </a>

                    </div>

                </article>

            </div>

        </section>


        <!-- =========================================================
             STRUCTURED CONTENT
        ========================================================== -->

        <section class="english-admin-dashboard__panel">

            <div class="english-admin-dashboard__panel-header">

                <div>

                    <span>
                        CONTENT
                    </span>

                    <h2>
                        محتوای ساختاری انگلیسی
                    </h2>

                    <p>
                        داده‌هایی که به‌صورت مستقیم در صفحات عمومی
                        نسخه انگلیسی نمایش داده می‌شوند.
                    </p>

                </div>

            </div>


            <div class="english-admin-dashboard__section-grid">


                <article class="english-admin-dashboard__section-card">

                    <div class="english-admin-dashboard__section-top">

                        <div
                            class="english-admin-dashboard__section-icon"
                            aria-hidden="true"
                        >
                            📢
                        </div>

                        <span>
                            ANNOUNCEMENTS
                        </span>

                    </div>

                    <h3>
                        اطلاعیه‌های انگلیسی
                    </h3>

                    <p>
                        خبرها و اطلاعیه‌های رسمی نسخه انگلیسی سایت.
                    </p>

                    <div class="english-admin-dashboard__section-actions">

                        <a
                            href="<?= View::url(
                                '/admin/english/announcements'
                            ) ?>"
                            class="english-admin-dashboard__edit"
                        >
                            مدیریت
                        </a>

                        <a
                            href="<?= View::url(
                                '/english/announcements'
                            ) ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="english-admin-dashboard__view"
                        >
                            مشاهده
                            <span aria-hidden="true">
                                ↗
                            </span>
                        </a>

                    </div>

                </article>


                <article class="english-admin-dashboard__section-card">

                    <div class="english-admin-dashboard__section-top">

                        <div
                            class="english-admin-dashboard__section-icon"
                            aria-hidden="true"
                        >
                            🎓
                        </div>

                        <span>
                            FACULTIES
                        </span>

                    </div>

                    <h3>
                        دانشکده‌های انگلیسی
                    </h3>

                    <p>
                        محتوای انگلیسی دانشکده‌ها و اطلاعات تماس آنها.
                    </p>

                    <div class="english-admin-dashboard__section-actions">

                        <a
                            href="<?= View::url(
                                '/admin/english/faculties'
                            ) ?>"
                            class="english-admin-dashboard__edit"
                        >
                            مدیریت
                        </a>

                        <a
                            href="<?= View::url(
                                '/english/faculties'
                            ) ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="english-admin-dashboard__view"
                        >
                            مشاهده
                            <span aria-hidden="true">
                                ↗
                            </span>
                        </a>

                    </div>

                </article>


                <article class="english-admin-dashboard__section-card">

                    <div class="english-admin-dashboard__section-top">

                        <div
                            class="english-admin-dashboard__section-icon"
                            aria-hidden="true"
                        >
                            📚
                        </div>

                        <span>
                            PROGRAMS
                        </span>

                    </div>

                    <h3>
                        برنامه‌های آموزشی انگلیسی
                    </h3>

                    <p>
                        رشته‌ها، مقاطع، گرایش‌ها، توضیحات و اطلاعات
                        پذیرش نسخه انگلیسی.
                    </p>

                    <div class="english-admin-dashboard__section-actions">

                        <a
                            href="<?= View::url(
                                '/admin/english/programs'
                            ) ?>"
                            class="english-admin-dashboard__edit"
                        >
                            مدیریت
                        </a>

                        <a
                            href="<?= View::url(
                                '/english/programs'
                            ) ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="english-admin-dashboard__view"
                        >
                            مشاهده
                            <span aria-hidden="true">
                                ↗
                            </span>
                        </a>

                    </div>

                </article>


                <article class="english-admin-dashboard__section-card">

                    <div class="english-admin-dashboard__section-top">

                        <div
                            class="english-admin-dashboard__section-icon"
                            aria-hidden="true"
                        >
                            👥
                        </div>

                        <span>
                            PEOPLE
                        </span>

                    </div>

                    <h3>
                        افراد و اعضای دانشگاه
                    </h3>

                    <p>
                        اطلاعات اعضای هیئت علمی، کارکنان و اعضای
                        جامعه دانشگاهی.
                    </p>

                    <div class="english-admin-dashboard__section-actions">

                        <a
                            href="<?= View::url(
                                '/admin/english/people'
                            ) ?>"
                            class="english-admin-dashboard__edit"
                        >
                            مدیریت
                        </a>

                    </div>

                </article>


                <article class="english-admin-dashboard__section-card">

                    <div class="english-admin-dashboard__section-top">

                        <div
                            class="english-admin-dashboard__section-icon"
                            aria-hidden="true"
                        >
                            🔬
                        </div>

                        <span>
                            RESEARCH
                        </span>

                    </div>

                    <h3>
                        مراکز پژوهشی انگلیسی
                    </h3>

                    <p>
                        اطلاعات، عنوان، توضیحات و محتوای مراکز پژوهشی.
                    </p>

                    <div class="english-admin-dashboard__section-actions">

                        <a
                            href="<?= View::url(
                                '/admin/english/research-centers'
                            ) ?>"
                            class="english-admin-dashboard__edit"
                        >
                            مدیریت
                        </a>

                        <a
                            href="<?= View::url(
                                '/english/research'
                            ) ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="english-admin-dashboard__view"
                        >
                            مشاهده
                            <span aria-hidden="true">
                                ↗
                            </span>
                        </a>

                    </div>

                </article>

            </div>

        </section>


        <!-- =========================================================
             STATIC PAGES
        ========================================================== -->

        <section class="english-admin-dashboard__panel">

            <div class="english-admin-dashboard__panel-header">

                <div>

                    <span>
                        STATIC PAGES
                    </span>

                    <h2>
                        صفحات ثابت انگلیسی
                    </h2>

                    <p>
                        متن‌های معرفی و محتوای عمومی صفحات ثابت.
                    </p>

                </div>

            </div>


            <div class="english-admin-dashboard__section-grid">

                <?php

                $staticPages = [
                    [
                        'title' =>
                            'درباره',

                        'key' =>
                            'about',

                        'public' =>
                            '/english/about',
                    ],

                    [
                        'title' =>
                            'ریاست',

                        'key' =>
                            'presidency',

                        'public' =>
                            '/english/presidency',
                    ],

                    [
                        'title' =>
                            'دانشکده‌ها',

                        'key' =>
                            'faculties',

                        'public' =>
                            '/english/faculties',
                    ],

                    [
                        'title' =>
                            'برنامه‌های آموزشی',

                        'key' =>
                            'programs',

                        'public' =>
                            '/english/programs',
                    ],

                    [
                        'title' =>
                            'پژوهش',

                        'key' =>
                            'research',

                        'public' =>
                            '/english/research',
                    ],

                    [
                        'title' =>
                            'اطلاعیه‌ها',

                        'key' =>
                            'announcements',

                        'public' =>
                            '/english/announcements',
                    ],

                    [
                        'title' =>
                            'تماس با ما',

                        'key' =>
                            'contact',

                        'public' =>
                            '/english/contact',
                    ],
                ];

                ?>

                <?php foreach (
                    $staticPages
                    as $page
                ): ?>

                    <article
                        class="english-admin-dashboard__section-card"
                    >

                        <div class="english-admin-dashboard__section-top">

                            <div
                                class="english-admin-dashboard__section-icon"
                                aria-hidden="true"
                            >
                                📄
                            </div>

                            <span>
                                <?= View::escape(
                                    strtoupper(
                                        (string) (
                                            $page['key']
                                            ?? ''
                                        )
                                    )
                                ) ?>
                            </span>

                        </div>


                        <h3>
                            <?= View::escape(
                                (string) (
                                    $page['title']
                                    ?? ''
                                )
                            ) ?>
                        </h3>


                        <p>
                            ویرایش برچسب، عنوان و توضیحات صفحه.
                        </p>


                        <div class="english-admin-dashboard__section-actions">

                            <a
                                href="<?= View::url(
                                    '/admin/english/pages/'
                                    . rawurlencode(
                                        (string) (
                                            $page['key']
                                            ?? ''
                                        )
                                    )
                                ) ?>"
                                class="english-admin-dashboard__edit"
                            >
                                مدیریت
                            </a>


                            <a
                                href="<?= View::url(
                                    (string) (
                                        $page['public']
                                        ?? '/english'
                                    )
                                ) ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="english-admin-dashboard__view"
                            >
                                مشاهده

                                <span aria-hidden="true">
                                    ↗
                                </span>
                            </a>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        </section>


        <!-- =========================================================
             SUMMARY NOTE
        ========================================================== -->

        <section class="english-admin-dashboard__note">

            <div
                class="english-admin-dashboard__note-icon"
                aria-hidden="true"
            >
                💡
            </div>

            <div class="english-admin-dashboard__note-content">

                <strong>
                    نسخه انگلیسی مستقل مدیریت می‌شود
                </strong>

                <p>
                    ساختار این بخش در همان پنل مدیریت اصلی سایت قرار دارد،
                    اما محتوای انگلیسی از محتوای فارسی جداست. ویرایش
                    محتوای انگلیسی نباید محتوای فارسی را تغییر دهد.
                </p>

            </div>

        </section>

    </div>

</div>
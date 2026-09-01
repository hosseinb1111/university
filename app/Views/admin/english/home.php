<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


/*
|--------------------------------------------------------------------------
| Normalize values
|--------------------------------------------------------------------------
*/

$settings =
    is_array($settings ?? null)
        ? $settings
        : [];

$errors =
    is_array($errors ?? null)
        ? $errors
        : [];

$success =
    is_string($success ?? null)
        ? $success
        : null;


/*
|--------------------------------------------------------------------------
| Helper
|--------------------------------------------------------------------------
*/

$value =
    static function (
        string $key,
        string $default = ''
    ) use (
        $settings
    ): string {
        $value =
            trim(
                (string) (
                    $settings[$key]
                    ?? $default
                )
            );

        return $value !== ''
            ? $value
            : $default;
};


/*
|--------------------------------------------------------------------------
| Public homepage
|--------------------------------------------------------------------------
*/

$publicHomeUrl =
    View::url(
        '/english'
    );

?>

<div class="admin-page">

    <div class="english-admin-home">


        <!-- =========================================================
             HEADER
        ========================================================== -->

        <header class="english-admin-home__header">

            <div class="english-admin-home__header-main">

                <a
                    href="<?= View::url(
                        '/admin/english'
                    ) ?>"
                    class="english-admin-home__back"
                >
                    <span aria-hidden="true">
                        →
                    </span>

                    بازگشت به مدیریت سایت انگلیسی
                </a>


                <div class="english-admin-home__title-row">

                    <div
                        class="english-admin-home__title-icon"
                        aria-hidden="true"
                    >
                        🏠
                    </div>


                    <div>

                        <span class="english-admin-home__eyebrow">
                            مدیریت محتوای انگلیسی
                        </span>

                        <h1>
                            صفحه اصلی انگلیسی
                        </h1>

                        <p>
                            متن‌ها، عنوان‌ها و بخش‌های قابل ویرایش
                            صفحه اصلی نسخه انگلیسی سایت را مدیریت کنید.
                        </p>

                    </div>

                </div>

            </div>


            <div class="english-admin-home__header-actions">

                <a
                    href="<?= $publicHomeUrl ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="english-admin-home__preview"
                >
                    مشاهده سایت
                    <span aria-hidden="true">
                        ↗
                    </span>
                </a>

            </div>

        </header>


        <!-- =========================================================
             STATUS MESSAGES
        ========================================================== -->

        <?php if (
            $success !== null
        ): ?>

            <div
                class="english-admin-home__message english-admin-home__message--success"
                role="status"
            >

                <span
                    class="english-admin-home__message-icon"
                    aria-hidden="true"
                >
                    ✓
                </span>

                <div>

                    <strong>
                        تغییرات ذخیره شد
                    </strong>

                    <p>
                        تنظیمات صفحه اصلی انگلیسی با موفقیت
                        به‌روزرسانی شد.
                    </p>

                </div>

            </div>

        <?php endif; ?>


        <?php if (
            isset(
                $errors['general']
            )
        ): ?>

            <div
                class="english-admin-home__message english-admin-home__message--error"
                role="alert"
            >

                <span
                    class="english-admin-home__message-icon"
                    aria-hidden="true"
                >
                    !
                </span>

                <div>

                    <strong>
                        خطا در ذخیره اطلاعات
                    </strong>

                    <p>
                        <?= View::escape(
                            $errors['general']
                        ) ?>
                    </p>

                </div>

            </div>

        <?php endif; ?>


        <!-- =========================================================
             FORM
        ========================================================== -->

        <form
            method="POST"
            action="<?= View::url(
                '/admin/english/home'
            ) ?>"
            class="english-admin-home__form"
        >

            <?= Csrf::field() ?>


            <!-- =====================================================
                 HERO
            ====================================================== -->

            <section class="english-admin-home__card">

                <div class="english-admin-home__card-header">

                    <div>

                        <span>
                            بخش اول صفحه
                        </span>

                        <h2>
                            معرفی و هیرو
                        </h2>

                        <p>
                            این متن‌ها در ابتدای صفحه اصلی انگلیسی
                            و در بخش اصلی اسلایدر نمایش داده می‌شوند.
                        </p>

                    </div>

                </div>


                <div class="english-admin-home__card-body">


                    <div class="english-admin-home__field">

                        <label for="hero_eyebrow">
                            برچسب بالای عنوان
                        </label>

                        <input
                            id="hero_eyebrow"
                            type="text"
                            name="hero_eyebrow"
                            value="<?= View::escape(
                                $value(
                                    'hero_eyebrow',
                                    'Sadra Institute of Higher Education'
                                )
                            ) ?>"
                            maxlength="255"
                            placeholder="مثال: Sadra Institute of Higher Education"
                        >

                        <small>
                            یک عبارت کوتاه که بالای عنوان اصلی نمایش داده می‌شود.
                        </small>

                    </div>


                    <div class="english-admin-home__field">

                        <label for="hero_title">
                            عنوان اصلی
                        </label>

                        <input
                            id="hero_title"
                            type="text"
                            name="hero_title"
                            value="<?= View::escape(
                                $value(
                                    'hero_title',
                                    'Education, Research, and Innovation'
                                )
                            ) ?>"
                            maxlength="255"
                            placeholder="عنوان اصلی صفحه"
                        >

                        <small>
                            پیام اصلی و مهم صفحه اصلی را اینجا وارد کنید.
                        </small>

                    </div>


                    <div class="english-admin-home__field">

                        <label for="hero_description">
                            توضیحات
                        </label>

                        <textarea
                            id="hero_description"
                            name="hero_description"
                            rows="5"
                            maxlength="5000"
                            placeholder="توضیح کوتاه درباره موسسه..."
                        ><?= View::escape(
                            $value(
                                'hero_description',
                                'A higher education environment dedicated to academic excellence, research, innovation, and professional development.'
                            )
                        ) ?></textarea>

                        <small>
                            توضیحی کوتاه که زیر عنوان اصلی نمایش داده می‌شود.
                        </small>

                    </div>


                    <div class="english-admin-home__preview english-admin-home__preview--hero">

                        <span>
                            پیش‌نمایش متن
                        </span>

                        <strong>
                            <?= View::escape(
                                $value(
                                    'hero_title',
                                    'Education, Research, and Innovation'
                                )
                            ) ?>
                        </strong>

                        <p>
                            <?= View::escape(
                                $value(
                                    'hero_description',
                                    'A higher education environment dedicated to academic excellence, research, innovation, and professional development.'
                                )
                            ) ?>
                        </p>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 QUICK ACCESS
            ====================================================== -->

            <section class="english-admin-home__card">

                <div class="english-admin-home__card-header">

                    <div>

                        <span>
                            دسترسی سریع
                        </span>

                        <h2>
                            خدمات و پرتال‌ها
                        </h2>

                        <p>
                            عنوان و متن معرفی بخش دسترسی سریع
                            صفحه اصلی را تنظیم کنید.
                        </p>

                    </div>

                </div>


                <div class="english-admin-home__card-body">

                    <div class="english-admin-home__grid">

                        <div class="english-admin-home__field">

                            <label for="quick_links_eyebrow">
                                برچسب
                            </label>

                            <input
                                id="quick_links_eyebrow"
                                type="text"
                                name="quick_links_eyebrow"
                                value="<?= View::escape(
                                    $value(
                                        'quick_links_eyebrow',
                                        'Quick Access'
                                    )
                                ) ?>"
                                maxlength="255"
                            >

                        </div>


                        <div class="english-admin-home__field">

                            <label for="quick_links_title">
                                عنوان
                            </label>

                            <input
                                id="quick_links_title"
                                type="text"
                                name="quick_links_title"
                                value="<?= View::escape(
                                    $value(
                                        'quick_links_title',
                                        'Services & Portals'
                                    )
                                ) ?>"
                                maxlength="255"
                            >

                        </div>

                    </div>


                    <div class="english-admin-home__field">

                        <label for="quick_links_description">
                            توضیحات
                        </label>

                        <textarea
                            id="quick_links_description"
                            name="quick_links_description"
                            rows="4"
                            maxlength="5000"
                        ><?= View::escape(
                            $value(
                                'quick_links_description',
                                'Quick access to important services, portals, and resources.'
                            )
                        ) ?></textarea>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 HOMEPAGE SECTIONS
            ====================================================== -->

            <section class="english-admin-home__card">

                <div class="english-admin-home__card-header">

                    <div>

                        <span>
                            بخش‌های محتوایی
                        </span>

                        <h2>
                            اخبار، دانشکده‌ها و پژوهش
                        </h2>

                        <p>
                            عنوان‌هایی که بالای بخش‌های مختلف
                            صفحه اصلی نمایش داده می‌شوند.
                        </p>

                    </div>

                </div>


                <div class="english-admin-home__card-body">

                    <div class="english-admin-home__section-grid">


                        <!-- News -->

                        <article class="english-admin-home__section-editor">

                            <div class="english-admin-home__section-editor-icon">
                                📢
                            </div>

                            <div class="english-admin-home__section-editor-head">

                                <h3>
                                    اطلاعیه‌ها
                                </h3>

                                <span>
                                    Announcements
                                </span>

                            </div>


                            <div class="english-admin-home__field">

                                <label for="announcements_eyebrow">
                                    برچسب
                                </label>

                                <input
                                    id="announcements_eyebrow"
                                    type="text"
                                    name="announcements_eyebrow"
                                    value="<?= View::escape(
                                        $value(
                                            'announcements_eyebrow',
                                            'Latest News'
                                        )
                                    ) ?>"
                                    maxlength="255"
                                >

                            </div>


                            <div class="english-admin-home__field">

                                <label for="announcements_title">
                                    عنوان
                                </label>

                                <input
                                    id="announcements_title"
                                    type="text"
                                    name="announcements_title"
                                    value="<?= View::escape(
                                        $value(
                                            'announcements_title',
                                            'Latest Announcements'
                                        )
                                    ) ?>"
                                    maxlength="255"
                                >

                            </div>

                        </article>


                        <!-- Faculties -->

                        <article class="english-admin-home__section-editor">

                            <div class="english-admin-home__section-editor-icon">
                                🎓
                            </div>

                            <div class="english-admin-home__section-editor-head">

                                <h3>
                                    دانشکده‌ها
                                </h3>

                                <span>
                                    Faculties
                                </span>

                            </div>


                            <div class="english-admin-home__field">

                                <label for="faculties_eyebrow">
                                    برچسب
                                </label>

                                <input
                                    id="faculties_eyebrow"
                                    type="text"
                                    name="faculties_eyebrow"
                                    value="<?= View::escape(
                                        $value(
                                            'faculties_eyebrow',
                                            'Academics'
                                        )
                                    ) ?>"
                                    maxlength="255"
                                >

                            </div>


                            <div class="english-admin-home__field">

                                <label for="faculties_title">
                                    عنوان
                                </label>

                                <input
                                    id="faculties_title"
                                    type="text"
                                    name="faculties_title"
                                    value="<?= View::escape(
                                        $value(
                                            'faculties_title',
                                            'Faculties'
                                        )
                                    ) ?>"
                                    maxlength="255"
                                >

                            </div>

                        </article>


                        <!-- Research -->

                        <article class="english-admin-home__section-editor">

                            <div class="english-admin-home__section-editor-icon">
                                🔬
                            </div>

                            <div class="english-admin-home__section-editor-head">

                                <h3>
                                    پژوهش
                                </h3>

                                <span>
                                    Research
                                </span>

                            </div>


                            <div class="english-admin-home__field">

                                <label for="research_eyebrow">
                                    برچسب
                                </label>

                                <input
                                    id="research_eyebrow"
                                    type="text"
                                    name="research_eyebrow"
                                    value="<?= View::escape(
                                        $value(
                                            'research_eyebrow',
                                            'Research'
                                        )
                                    ) ?>"
                                    maxlength="255"
                                >

                            </div>


                            <div class="english-admin-home__field">

                                <label for="research_title">
                                    عنوان
                                </label>

                                <input
                                    id="research_title"
                                    type="text"
                                    name="research_title"
                                    value="<?= View::escape(
                                        $value(
                                            'research_title',
                                            'Research Centers'
                                        )
                                    ) ?>"
                                    maxlength="255"
                                >

                            </div>

                        </article>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 ABOUT
            ====================================================== -->

            <section class="english-admin-home__card">

                <div class="english-admin-home__card-header">

                    <div>

                        <span>
                            معرفی موسسه
                        </span>

                        <h2>
                            بخش درباره صدرا
                        </h2>

                        <p>
                            متن معرفی کوتاهی که در صفحه اصلی
                            درباره موسسه نمایش داده می‌شود.
                        </p>

                    </div>

                </div>


                <div class="english-admin-home__card-body">

                    <div class="english-admin-home__grid">

                        <div class="english-admin-home__field">

                            <label for="about_eyebrow">
                                برچسب
                            </label>

                            <input
                                id="about_eyebrow"
                                type="text"
                                name="about_eyebrow"
                                value="<?= View::escape(
                                    $value(
                                        'about_eyebrow',
                                        'About Sadra'
                                    )
                                ) ?>"
                                maxlength="255"
                            >

                        </div>


                        <div class="english-admin-home__field">

                            <label for="about_title">
                                عنوان
                            </label>

                            <input
                                id="about_title"
                                type="text"
                                name="about_title"
                                value="<?= View::escape(
                                    $value(
                                        'about_title',
                                        'A place for learning and discovery'
                                    )
                                ) ?>"
                                maxlength="255"
                            >

                        </div>

                    </div>


                    <div class="english-admin-home__field">

                        <label for="about_description">
                            توضیحات
                        </label>

                        <textarea
                            id="about_description"
                            name="about_description"
                            rows="5"
                            maxlength="5000"
                        ><?= View::escape(
                            $value(
                                'about_description',
                                'Sadra Institute of Higher Education provides an academic environment focused on education, research, innovation, and preparing students for professional careers.'
                            )
                        ) ?></textarea>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 CONTACT CTA
            ====================================================== -->

            <section class="english-admin-home__card">

                <div class="english-admin-home__card-header">

                    <div>

                        <span>
                            دعوت به اقدام
                        </span>

                        <h2>
                            بخش تماس با ما
                        </h2>

                        <p>
                            متن بخش پایانی صفحه اصلی که کاربر را
                            به صفحه تماس هدایت می‌کند.
                        </p>

                    </div>

                </div>


                <div class="english-admin-home__card-body">

                    <div class="english-admin-home__grid">

                        <div class="english-admin-home__field">

                            <label for="contact_eyebrow">
                                برچسب
                            </label>

                            <input
                                id="contact_eyebrow"
                                type="text"
                                name="contact_eyebrow"
                                value="<?= View::escape(
                                    $value(
                                        'contact_eyebrow',
                                        'Get in touch'
                                    )
                                ) ?>"
                                maxlength="255"
                            >

                        </div>


                        <div class="english-admin-home__field">

                            <label for="contact_button">
                                متن دکمه
                            </label>

                            <input
                                id="contact_button"
                                type="text"
                                name="contact_button"
                                value="<?= View::escape(
                                    $value(
                                        'contact_button',
                                        'Contact Us'
                                    )
                                ) ?>"
                                maxlength="255"
                            >

                        </div>

                    </div>


                    <div class="english-admin-home__field">

                        <label for="contact_title">
                            عنوان
                        </label>

                        <input
                            id="contact_title"
                            type="text"
                            name="contact_title"
                            value="<?= View::escape(
                                $value(
                                    'contact_title',
                                    'We are here to help.'
                                )
                            ) ?>"
                            maxlength="255"
                        >

                    </div>


                    <div class="english-admin-home__field">

                        <label for="contact_description">
                            توضیحات
                        </label>

                        <textarea
                            id="contact_description"
                            name="contact_description"
                            rows="5"
                            maxlength="5000"
                        ><?= View::escape(
                            $value(
                                'contact_description',
                                'For more information about Sadra Institute, academic programs, admissions, and services, contact us.'
                            )
                        ) ?></textarea>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 SAVE BAR
            ====================================================== -->

            <div class="english-admin-home__savebar">

                <div>

                    <strong>
                        آماده ذخیره تغییرات؟
                    </strong>

                    <span>
                        تغییرات پس از ذخیره در صفحه اصلی انگلیسی
                        نمایش داده می‌شوند.
                    </span>

                </div>


                <div class="english-admin-home__save-actions">

                    <a
                        href="<?= View::url(
                            '/admin/english'
                        ) ?>"
                        class="english-admin-home__cancel"
                    >
                        انصراف
                    </a>


                    <button
                        type="submit"
                        class="english-admin-home__save"
                    >
                        <span aria-hidden="true">
                            ✓
                        </span>

                        ذخیره تغییرات
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


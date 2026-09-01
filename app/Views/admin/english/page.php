<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


$page =
    trim(
        (string) (
            $page
            ?? ''
        )
    );


$pageLabel =
    trim(
        (string) (
            $pageLabel
            ?? 'صفحه انگلیسی'
        )
    );


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


$publicPaths = [
    'about' =>
        '/english/about',

    'presidency' =>
        '/english/presidency',

    'faculties' =>
        '/english/faculties',

    'programs' =>
        '/english/programs',

    'research' =>
        '/english/research',

    'announcements' =>
        '/english/announcements',

    'contact' =>
        '/english/contact',
];


$publicPath =
    $publicPaths[$page]
    ?? '/english';


$pageLabels = [
    'about' =>
        'درباره',

    'presidency' =>
        'ریاست',

    'faculties' =>
        'دانشکده‌ها',

    'programs' =>
        'برنامه‌های آموزشی',

    'research' =>
        'پژوهش',

    'announcements' =>
        'اطلاعیه‌ها',

    'contact' =>
        'تماس با ما',
];


$displayPageLabel =
    $pageLabels[$page]
    ?? $pageLabel;


$isContactPage =
    $page === 'contact';

?>


<div class="admin-page">

    <div class="english-admin-editor">


        <header class="english-admin-editor__header">

            <div class="english-admin-editor__header-main">

                <a
                    href="<?= View::url(
                        '/admin/english'
                    ) ?>"
                    class="english-admin-editor__back"
                >
                    ←
                    بازگشت به مدیریت سایت انگلیسی
                </a>


                <div class="english-admin-editor__title-row">

                    <div
                        class="english-admin-editor__title-icon"
                        aria-hidden="true"
                    >
                        📄
                    </div>


                    <div>

                        <span class="english-admin-editor__eyebrow">
                            STATIC ENGLISH CONTENT
                        </span>

                        <h1>
                            <?= View::escape(
                                $displayPageLabel
                            ) ?>
                        </h1>

                        <p>
                            محتوای صفحه
                            <?= View::escape(
                                $displayPageLabel
                            ) ?>
                            را مدیریت کنید.
                        </p>

                    </div>

                </div>

            </div>


            <div class="english-admin-editor__header-actions">

                <a
                    href="<?= View::url(
                        $publicPath
                    ) ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="english-admin-editor__preview-button"
                >
                    مشاهده صفحه
                    ↗
                </a>

            </div>

        </header>


        <?php if (
            $success !== null
        ): ?>

            <div
                class="english-admin-message english-admin-message--success"
                role="status"
            >

                <span
                    class="english-admin-message__icon"
                    aria-hidden="true"
                >
                    ✓
                </span>

                <div>

                    <strong>
                        تغییرات ذخیره شد
                    </strong>

                    <p>
                        محتوای صفحه با موفقیت به‌روزرسانی شد.
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
                class="english-admin-message english-admin-message--error"
                role="alert"
            >

                <span
                    class="english-admin-message__icon"
                    aria-hidden="true"
                >
                    !
                </span>

                <div>

                    <strong>
                        ذخیره تغییرات انجام نشد
                    </strong>

                    <p>
                        <?= View::escape(
                            $errors['general']
                        ) ?>
                    </p>

                </div>

            </div>

        <?php endif; ?>


        <form
            method="POST"
            action="<?= View::url(
                '/admin/english/pages/'
                . rawurlencode(
                    $page
                )
            ) ?>"
            class="english-admin-editor__form"
        >

            <?= Csrf::field() ?>


            <!-- =====================================================
                 PAGE CONTENT
            ====================================================== -->

            <section class="english-admin-card">

                <div class="english-admin-card__header">

                    <div>

                        <span class="english-admin-card__eyebrow">
                            PAGE CONTENT
                        </span>

                        <h2>
                            محتوای صفحه
                        </h2>

                        <p>
                            متن‌های اصلی این صفحه را مدیریت کنید.
                        </p>

                    </div>

                </div>


                <div class="english-admin-card__body">


                    <div class="english-admin-field">

                        <label for="english-page-eyebrow">
                            برچسب بالای عنوان
                        </label>

                        <input
                            id="english-page-eyebrow"
                            type="text"
                            name="eyebrow"
                            maxlength="255"
                            value="<?= View::escape(
                                $settings['eyebrow']
                                ?? ''
                            ) ?>"
                            placeholder="Contact"
                        >

                        <?php if (
                            isset(
                                $errors['eyebrow']
                            )
                        ): ?>

                            <span class="english-admin-field__error">
                                <?= View::escape(
                                    $errors['eyebrow']
                                ) ?>
                            </span>

                        <?php endif; ?>

                    </div>


                    <div class="english-admin-field">

                        <label for="english-page-title">
                            عنوان
                        </label>

                        <input
                            id="english-page-title"
                            type="text"
                            name="title"
                            maxlength="255"
                            value="<?= View::escape(
                                $settings['title']
                                ?? ''
                            ) ?>"
                            placeholder="Contact Us"
                        >

                        <?php if (
                            isset(
                                $errors['title']
                            )
                        ): ?>

                            <span class="english-admin-field__error">
                                <?= View::escape(
                                    $errors['title']
                                ) ?>
                            </span>

                        <?php endif; ?>

                    </div>


                    <div class="english-admin-field">

                        <label for="english-page-description">
                            توضیحات
                        </label>

                        <textarea
                            id="english-page-description"
                            name="description"
                            rows="8"
                            maxlength="5000"
                            placeholder="Contact information for Sadra Institute of Higher Education."
                        ><?= View::escape(
                            $settings['description']
                            ?? ''
                        ) ?></textarea>

                        <?php if (
                            isset(
                                $errors['description']
                            )
                        ): ?>

                            <span class="english-admin-field__error">
                                <?= View::escape(
                                    $errors['description']
                                ) ?>
                            </span>

                        <?php endif; ?>

                    </div>


                </div>

            </section>


            <?php if (
                $isContactPage
            ): ?>


                <!-- =================================================
                     CONTACT INFORMATION
                ================================================== -->

                <section class="english-admin-card">

                    <div class="english-admin-card__header">

                        <div>

                            <span class="english-admin-card__eyebrow">
                                CONTACT INFORMATION
                            </span>

                            <h2>
                                اطلاعات تماس
                            </h2>

                            <p>
                                این اطلاعات مستقیماً در صفحه تماس
                                نسخه انگلیسی نمایش داده می‌شوند.
                            </p>

                        </div>

                    </div>


                    <div class="english-admin-card__body">


                        <div class="english-admin-editor__grid">


                            <!-- EMAIL -->

                            <div class="english-admin-field">

                                <label for="english-contact-email">
                                    ایمیل
                                </label>

                                <input
                                    id="english-contact-email"
                                    type="email"
                                    name="email"
                                    maxlength="255"
                                    value="<?= View::escape(
                                        $settings['email']
                                        ?? ''
                                    ) ?>"
                                    placeholder="info@sadra.ac.ir"
                                    dir="ltr"
                                    inputmode="email"
                                    autocomplete="email"
                                >

                                <?php if (
                                    isset(
                                        $errors['email']
                                    )
                                ): ?>

                                    <span class="english-admin-field__error">
                                        <?= View::escape(
                                            $errors['email']
                                        ) ?>
                                    </span>

                                <?php endif; ?>

                            </div>


                            <!-- PHONE -->

                            <div class="english-admin-field">

                                <label for="english-contact-phone">
                                    شماره تلفن
                                </label>

                                <input
                                    id="english-contact-phone"
                                    type="text"
                                    name="phone"
                                    maxlength="100"
                                    value="<?= View::escape(
                                        $settings['phone']
                                        ?? ''
                                    ) ?>"
                                    placeholder="02140445580"
                                    dir="ltr"
                                    inputmode="tel"
                                    autocomplete="tel"
                                >

                                <?php if (
                                    isset(
                                        $errors['phone']
                                    )
                                ): ?>

                                    <span class="english-admin-field__error">
                                        <?= View::escape(
                                            $errors['phone']
                                        ) ?>
                                    </span>

                                <?php endif; ?>

                            </div>


                            <!-- FAX -->

                            <div class="english-admin-field">

                                <label for="english-contact-fax">
                                    فکس
                                </label>

                                <input
                                    id="english-contact-fax"
                                    type="text"
                                    name="fax"
                                    maxlength="100"
                                    value="<?= View::escape(
                                        $settings['fax']
                                        ?? ''
                                    ) ?>"
                                    placeholder="02140445581"
                                    dir="ltr"
                                    inputmode="tel"
                                >

                                <?php if (
                                    isset(
                                        $errors['fax']
                                    )
                                ): ?>

                                    <span class="english-admin-field__error">
                                        <?= View::escape(
                                            $errors['fax']
                                        ) ?>
                                    </span>

                                <?php endif; ?>

                            </div>


                            <!-- ADDRESS -->

                            <div class="english-admin-field">

                                <label for="english-contact-address">
                                    آدرس
                                </label>

                                <textarea
                                    id="english-contact-address"
                                    name="address"
                                    rows="4"
                                    maxlength="1000"
                                    placeholder="Tehran, Iran"
                                ><?= View::escape(
                                    $settings['address']
                                    ?? ''
                                ) ?></textarea>

                                <?php if (
                                    isset(
                                        $errors['address']
                                    )
                                ): ?>

                                    <span class="english-admin-field__error">
                                        <?= View::escape(
                                            $errors['address']
                                        ) ?>
                                    </span>

                                <?php endif; ?>

                            </div>


                        </div>


                    </div>

                </section>


                <!-- =================================================
                     GOOGLE MAP
                ================================================== -->

                <section class="english-admin-card">

                    <div class="english-admin-card__header">

                        <div>

                            <span class="english-admin-card__eyebrow">
                                GOOGLE MAP
                            </span>

                            <h2>
                                نقشه
                            </h2>

                            <p>
                                آدرس Embed نقشه Google Maps را وارد کنید.
                                فقط مقدار URL را وارد کنید، نه تگ کامل iframe.
                            </p>

                        </div>

                    </div>


                    <div class="english-admin-card__body">


                        <div class="english-admin-field">

                            <label for="english-contact-map">
                                لینک Google Maps Embed
                            </label>

                            <textarea
                                id="english-contact-map"
                                name="map_embed_url"
                                rows="5"
                                maxlength="5000"
                                dir="ltr"
                                spellcheck="false"
                                placeholder="https://www.google.com/maps/embed?pb=..."
                            ><?= View::escape(
                                $settings['map_embed_url']
                                ?? ''
                            ) ?></textarea>


                            <small>
                                از Google Maps گزینه
                                <strong>Share → Embed a map</strong>
                                را انتخاب کنید و فقط مقدار
                                <code>src</code>
                                مربوط به iframe را اینجا قرار دهید.
                            </small>


                            <?php if (
                                isset(
                                    $errors['map_embed_url']
                                )
                            ): ?>

                                <span class="english-admin-field__error">
                                    <?= View::escape(
                                        $errors['map_embed_url']
                                    ) ?>
                                </span>

                            <?php endif; ?>

                        </div>


                        <?php if (
                            !empty(
                                $settings['map_embed_url']
                            )
                        ): ?>

                            <div class="english-admin-preview">

                                <div class="english-admin-preview__item english-admin-preview__item--wide">

                                    <span>
                                        MAP URL
                                    </span>

                                    <strong dir="ltr">
                                        <?= View::escape(
                                            $settings['map_embed_url']
                                        ) ?>
                                    </strong>

                                </div>

                            </div>

                        <?php endif; ?>


                    </div>

                </section>


            <?php endif; ?>


            <!-- =====================================================
                 PAGE INFORMATION
            ====================================================== -->

            <section class="english-admin-card">

                <div class="english-admin-card__header">

                    <div>

                        <span class="english-admin-card__eyebrow">
                            PAGE INFORMATION
                        </span>

                        <h2>
                            اطلاعات صفحه
                        </h2>

                    </div>

                </div>


                <div class="english-admin-card__body">

                    <div class="english-admin-preview">


                        <div class="english-admin-preview__item">

                            <span>
                                صفحه
                            </span>

                            <strong>
                                <?= View::escape(
                                    $displayPageLabel
                                ) ?>
                            </strong>

                        </div>


                        <div class="english-admin-preview__item">

                            <span>
                                مسیر
                            </span>

                            <strong dir="ltr">
                                <?= View::escape(
                                    $publicPath
                                ) ?>
                            </strong>

                        </div>


                        <div class="english-admin-preview__item english-admin-preview__item--wide">

                            <span>
                                وضعیت
                            </span>

                            <strong>
                                <?= $isContactPage
                                    ? 'محتوای صفحه و اطلاعات تماس قابل ویرایش'
                                    : 'محتوای متنی قابل ویرایش'
                                ?>
                            </strong>

                        </div>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 SAVE BAR
            ====================================================== -->

            <div class="english-admin-editor__savebar">

                <div>

                    <span>
                        آماده ذخیره تغییرات؟
                    </span>

                    <small>
                        تغییرات مستقیماً در صفحه انگلیسی اعمال می‌شوند.
                    </small>

                </div>


                <div class="english-admin-editor__save-actions">

                    <a
                        href="<?= View::url(
                            '/admin/english'
                        ) ?>"
                        class="english-admin-editor__cancel"
                    >
                        انصراف
                    </a>


                    <button
                        type="submit"
                        class="english-admin-editor__save"
                    >
                        ✓
                        ذخیره تغییرات
                    </button>

                </div>

            </div>


        </form>

    </div>

</div>
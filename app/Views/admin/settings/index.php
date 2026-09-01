<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;

$settings =
    is_array(
        $settings ?? null
    )
        ? $settings
        : [];

$errors =
    is_array(
        $errors ?? null
    )
        ? $errors
        : [];

$success =
    is_string(
        $success ?? null
    )
        ? trim($success)
        : '';


/*
|--------------------------------------------------------------------------
| Homepage
|--------------------------------------------------------------------------
*/

$quickLinksEyebrow =
    (string) (
        $settings['quick_links_eyebrow']
        ?? 'دسترسی سریع'
    );

$quickLinksTitle =
    (string) (
        $settings['quick_links_title']
        ?? 'سامانه‌ها و خدمات'
    );

$quickLinksDescription =
    (string) (
        $settings['quick_links_description']
        ?? 'دسترسی سریع به سامانه‌ها و خدمات مهم موسسه'
    );


/*
|--------------------------------------------------------------------------
| About
|--------------------------------------------------------------------------
*/

$aboutEyebrow =
    (string) (
        $settings['about_eyebrow']
        ?? 'معرفی موسسه'
    );

$aboutTitle =
    (string) (
        $settings['about_title']
        ?? 'موسسه آموزش عالی صدرالمتالهین'
    );

$aboutIntro =
    (string) (
        $settings['about_intro']
        ?? ''
    );

$aboutCardEyebrow =
    (string) (
        $settings['about_card_eyebrow']
        ?? 'درباره ما'
    );

$aboutCardTitle =
    (string) (
        $settings['about_card_title']
        ?? 'معرفی موسسه'
    );

$aboutCardText1 =
    (string) (
        $settings['about_card_text_1']
        ?? ''
    );

$aboutCardText2 =
    (string) (
        $settings['about_card_text_2']
        ?? ''
    );

$aboutGoalsEyebrow =
    (string) (
        $settings['about_goals_eyebrow']
        ?? 'اهداف'
    );

$aboutGoalsTitle =
    (string) (
        $settings['about_goals_title']
        ?? 'اهداف و رویکرد'
    );

$aboutGoalsText =
    (string) (
        $settings['about_goals_text']
        ?? ''
    );

$aboutStructureEyebrow =
    (string) (
        $settings['about_structure_eyebrow']
        ?? 'ساختار'
    );

$aboutStructureTitle =
    (string) (
        $settings['about_structure_title']
        ?? 'ساختار دانشگاهی'
    );

$aboutStructureText =
    (string) (
        $settings['about_structure_text']
        ?? ''
    );

$aboutMoreEyebrow =
    (string) (
        $settings['about_more_eyebrow']
        ?? 'اطلاعات بیشتر'
    );

$aboutMoreTitle =
    (string) (
        $settings['about_more_title']
        ?? 'مسیرهای دسترسی'
    );


/*
|--------------------------------------------------------------------------
| Contact
|--------------------------------------------------------------------------
*/

$contactEyebrow =
    (string) (
        $settings['contact_eyebrow']
        ?? 'ارتباط با موسسه'
    );

$contactTitle =
    (string) (
        $settings['contact_title']
        ?? 'تماس با ما'
    );

$contactDescription =
    (string) (
        $settings['contact_description']
        ?? ''
    );

$contactEmail =
    (string) (
        $settings['contact_email']
        ?? 'info@sadra.ac.ir'
    );

$contactPhone =
    (string) (
        $settings['contact_phone']
        ?? ''
    );

$contactFax =
    (string) (
        $settings['contact_fax']
        ?? ''
    );

$contactAddress =
    (string) (
        $settings['contact_address']
        ?? ''
    );

$contactMapEyebrow =
    (string) (
        $settings['contact_map_eyebrow']
        ?? 'موقعیت موسسه'
    );

$contactMapTitle =
    (string) (
        $settings['contact_map_title']
        ?? 'تهران، ایران'
    );

$contactMapDescription =
    (string) (
        $settings['contact_map_description']
        ?? ''
    );

$contactMapEmbed =
    (string) (
        $settings['contact_map_embed']
        ?? ''
    );

?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>

            <span class="admin-page__eyebrow">
                تنظیمات سایت
            </span>

            <h1>
                تنظیمات سایت
            </h1>

            <p>
                محتوای قابل ویرایش بخش‌های اصلی سایت را از یک مکان مدیریت کنید.
            </p>

        </div>

    </div>


    <?php if (
        $success !== ''
    ): ?>

        <div
            class="admin-alert admin-alert--success"
            role="status"
        >
            <?= View::escape(
                $success
            ) ?>
        </div>

    <?php endif; ?>


    <?php if (
        $errors !== []
    ): ?>

        <div
            class="admin-alert admin-alert--error"
            role="alert"
        >

            <strong>
                تنظیمات ذخیره نشد.
            </strong>

            <ul>

                <?php foreach (
                    $errors
                    as $error
                ): ?>

                    <li>
                        <?= View::escape(
                            (string) $error
                        ) ?>
                    </li>

                <?php endforeach; ?>

            </ul>

        </div>

    <?php endif; ?>


    <form
        method="POST"
        action="<?= View::route(
            'admin.settings.update'
        ) ?>"
    >

        <?= Csrf::field() ?>


        <!-- =====================================================
             HOMEPAGE
        ====================================================== -->

        <section class="admin-panel">

            <div class="admin-panel__header">

                <div>

                    <h2>
                        صفحه اصلی
                    </h2>

                    <p>
                        متن‌های بخش «سامانه‌ها و خدمات» صفحه اصلی.
                    </p>

                </div>

            </div>


            <div class="admin-form__grid">

                <div
                    class="
                        admin-form__field
                        admin-form__field--full
                    "
                >

                    <label
                        for="quick_links_eyebrow"
                    >
                        متن بالای عنوان
                    </label>

                    <input
                        id="quick_links_eyebrow"
                        name="quick_links_eyebrow"
                        type="text"
                        value="<?= View::escape(
                            $quickLinksEyebrow
                        ) ?>"
                        maxlength="255"
                        required
                    >

                </div>


                <div
                    class="
                        admin-form__field
                        admin-form__field--full
                    "
                >

                    <label
                        for="quick_links_title"
                    >
                        عنوان بخش
                    </label>

                    <input
                        id="quick_links_title"
                        name="quick_links_title"
                        type="text"
                        value="<?= View::escape(
                            $quickLinksTitle
                        ) ?>"
                        maxlength="255"
                        required
                    >

                </div>


                <div
                    class="
                        admin-form__field
                        admin-form__field--full
                    "
                >

                    <label
                        for="quick_links_description"
                    >
                        توضیحات
                    </label>

                    <textarea
                        id="quick_links_description"
                        name="quick_links_description"
                        rows="4"
                        maxlength="1000"
                    ><?= View::escape(
                        $quickLinksDescription
                    ) ?></textarea>

                </div>

            </div>

        </section>


        <!-- =====================================================
             ABOUT
        ====================================================== -->

        <section
            class="admin-panel"
            style="margin-top:24px;"
        >

            <div class="admin-panel__header">

                <div>

                    <h2>
                        درباره موسسه
                    </h2>

                    <p>
                        تمام متن‌های قابل ویرایش صفحه «درباره موسسه».
                    </p>

                </div>

            </div>


            <div class="admin-form__grid">

                <div class="admin-form__field">

                    <label
                        for="about_eyebrow"
                    >
                        متن بالای صفحه
                    </label>

                    <input
                        id="about_eyebrow"
                        name="about_eyebrow"
                        type="text"
                        value="<?= View::escape(
                            $aboutEyebrow
                        ) ?>"
                        maxlength="255"
                        required
                    >

                </div>


                <div class="admin-form__field">

                    <label
                        for="about_title"
                    >
                        عنوان اصلی
                    </label>

                    <input
                        id="about_title"
                        name="about_title"
                        type="text"
                        value="<?= View::escape(
                            $aboutTitle
                        ) ?>"
                        maxlength="255"
                        required
                    >

                </div>


                <div
                    class="
                        admin-form__field
                        admin-form__field--full
                    "
                >

                    <label
                        for="about_intro"
                    >
                        معرفی کوتاه
                    </label>

                    <textarea
                        id="about_intro"
                        name="about_intro"
                        rows="5"
                        maxlength="3000"
                        required
                    ><?= View::escape(
                        $aboutIntro
                    ) ?></textarea>

                </div>


                <div class="admin-form__field">

                    <label
                        for="about_card_eyebrow"
                    >
                        برچسب «درباره ما»
                    </label>

                    <input
                        id="about_card_eyebrow"
                        name="about_card_eyebrow"
                        type="text"
                        value="<?= View::escape(
                            $aboutCardEyebrow
                        ) ?>"
                        maxlength="255"
                    >

                </div>


                <div class="admin-form__field">

                    <label
                        for="about_card_title"
                    >
                        عنوان معرفی
                    </label>

                    <input
                        id="about_card_title"
                        name="about_card_title"
                        type="text"
                        value="<?= View::escape(
                            $aboutCardTitle
                        ) ?>"
                        maxlength="255"
                        required
                    >

                </div>


                <div class="admin-form__field">

                    <label
                        for="about_card_text_1"
                    >
                        متن معرفی اول
                    </label>

                    <textarea
                        id="about_card_text_1"
                        name="about_card_text_1"
                        rows="6"
                        maxlength="5000"
                    ><?= View::escape(
                        $aboutCardText1
                    ) ?></textarea>

                </div>


                <div class="admin-form__field">

                    <label
                        for="about_card_text_2"
                    >
                        متن معرفی دوم
                    </label>

                    <textarea
                        id="about_card_text_2"
                        name="about_card_text_2"
                        rows="6"
                        maxlength="5000"
                    ><?= View::escape(
                        $aboutCardText2
                    ) ?></textarea>

                </div>


                <div class="admin-form__field">

                    <label
                        for="about_goals_eyebrow"
                    >
                        برچسب اهداف
                    </label>

                    <input
                        id="about_goals_eyebrow"
                        name="about_goals_eyebrow"
                        type="text"
                        value="<?= View::escape(
                            $aboutGoalsEyebrow
                        ) ?>"
                        maxlength="255"
                    >

                </div>


                <div class="admin-form__field">

                    <label
                        for="about_goals_title"
                    >
                        عنوان اهداف
                    </label>

                    <input
                        id="about_goals_title"
                        name="about_goals_title"
                        type="text"
                        value="<?= View::escape(
                            $aboutGoalsTitle
                        ) ?>"
                        maxlength="255"
                        required
                    >

                </div>


                <div
                    class="
                        admin-form__field
                        admin-form__field--full
                    "
                >

                    <label
                        for="about_goals_text"
                    >
                        متن اهداف
                    </label>

                    <textarea
                        id="about_goals_text"
                        name="about_goals_text"
                        rows="5"
                        maxlength="5000"
                    ><?= View::escape(
                        $aboutGoalsText
                    ) ?></textarea>

                </div>


                <div class="admin-form__field">

                    <label
                        for="about_structure_eyebrow"
                    >
                        برچسب ساختار
                    </label>

                    <input
                        id="about_structure_eyebrow"
                        name="about_structure_eyebrow"
                        type="text"
                        value="<?= View::escape(
                            $aboutStructureEyebrow
                        ) ?>"
                        maxlength="255"
                    >

                </div>


                <div class="admin-form__field">

                    <label
                        for="about_structure_title"
                    >
                        عنوان ساختار
                    </label>

                    <input
                        id="about_structure_title"
                        name="about_structure_title"
                        type="text"
                        value="<?= View::escape(
                            $aboutStructureTitle
                        ) ?>"
                        maxlength="255"
                        required
                    >

                </div>


                <div
                    class="
                        admin-form__field
                        admin-form__field--full
                    "
                >

                    <label
                        for="about_structure_text"
                    >
                        متن ساختار
                    </label>

                    <textarea
                        id="about_structure_text"
                        name="about_structure_text"
                        rows="5"
                        maxlength="5000"
                    ><?= View::escape(
                        $aboutStructureText
                    ) ?></textarea>

                </div>


                <div class="admin-form__field">

                    <label
                        for="about_more_eyebrow"
                    >
                        برچسب اطلاعات بیشتر
                    </label>

                    <input
                        id="about_more_eyebrow"
                        name="about_more_eyebrow"
                        type="text"
                        value="<?= View::escape(
                            $aboutMoreEyebrow
                        ) ?>"
                        maxlength="255"
                    >

                </div>


                <div class="admin-form__field">

                    <label
                        for="about_more_title"
                    >
                        عنوان اطلاعات بیشتر
                    </label>

                    <input
                        id="about_more_title"
                        name="about_more_title"
                        type="text"
                        value="<?= View::escape(
                            $aboutMoreTitle
                        ) ?>"
                        maxlength="255"
                        required
                    >

                </div>

            </div>

        </section>


        <!-- =====================================================
             CONTACT
        ====================================================== -->

        <section
            class="admin-panel"
            style="margin-top:24px;"
        >

            <div class="admin-panel__header">

                <div>

                    <h2>
                        تماس با ما
                    </h2>

                    <p>
                        اطلاعات تماس، آدرس و نقشه صفحه تماس.
                    </p>

                </div>

            </div>


            <div class="admin-form__grid">

                <div class="admin-form__field">

                    <label
                        for="contact_eyebrow"
                    >
                        متن بالای صفحه
                    </label>

                    <input
                        id="contact_eyebrow"
                        name="contact_eyebrow"
                        type="text"
                        value="<?= View::escape(
                            $contactEyebrow
                        ) ?>"
                        maxlength="255"
                        required
                    >

                </div>


                <div class="admin-form__field">

                    <label
                        for="contact_title"
                    >
                        عنوان صفحه
                    </label>

                    <input
                        id="contact_title"
                        name="contact_title"
                        type="text"
                        value="<?= View::escape(
                            $contactTitle
                        ) ?>"
                        maxlength="255"
                        required
                    >

                </div>


                <div
                    class="
                        admin-form__field
                        admin-form__field--full
                    "
                >

                    <label
                        for="contact_description"
                    >
                        توضیحات
                    </label>

                    <textarea
                        id="contact_description"
                        name="contact_description"
                        rows="4"
                        maxlength="3000"
                        required
                    ><?= View::escape(
                        $contactDescription
                    ) ?></textarea>

                </div>


                <div class="admin-form__field">

                    <label
                        for="contact_email"
                    >
                        ایمیل
                    </label>

                    <input
                        id="contact_email"
                        name="contact_email"
                        type="email"
                        value="<?= View::escape(
                            $contactEmail
                        ) ?>"
                        maxlength="255"
                    >

                </div>


                <div class="admin-form__field">

                    <label
                        for="contact_phone"
                    >
                        تلفن
                    </label>

                    <input
                        id="contact_phone"
                        name="contact_phone"
                        type="text"
                        value="<?= View::escape(
                            $contactPhone
                        ) ?>"
                        maxlength="255"
                    >

                </div>


                <div class="admin-form__field">

                    <label
                        for="contact_fax"
                    >
                        دورنگار
                    </label>

                    <input
                        id="contact_fax"
                        name="contact_fax"
                        type="text"
                        value="<?= View::escape(
                            $contactFax
                        ) ?>"
                        maxlength="255"
                    >

                </div>


                <div class="admin-form__field">

                    <label
                        for="contact_address"
                    >
                        آدرس
                    </label>

                    <textarea
                        id="contact_address"
                        name="contact_address"
                        rows="4"
                        maxlength="2000"
                        required
                    ><?= View::escape(
                        $contactAddress
                    ) ?></textarea>

                </div>


                <div class="admin-form__field">

                    <label
                        for="contact_map_eyebrow"
                    >
                        برچسب نقشه
                    </label>

                    <input
                        id="contact_map_eyebrow"
                        name="contact_map_eyebrow"
                        type="text"
                        value="<?= View::escape(
                            $contactMapEyebrow
                        ) ?>"
                        maxlength="255"
                    >

                </div>


                <div class="admin-form__field">

                    <label
                        for="contact_map_title"
                    >
                        عنوان نقشه
                    </label>

                    <input
                        id="contact_map_title"
                        name="contact_map_title"
                        type="text"
                        value="<?= View::escape(
                            $contactMapTitle
                        ) ?>"
                        maxlength="255"
                    >

                </div>


                <div
                    class="
                        admin-form__field
                        admin-form__field--full
                    "
                >

                    <label
                        for="contact_map_description"
                    >
                        توضیحات نقشه
                    </label>

                    <textarea
                        id="contact_map_description"
                        name="contact_map_description"
                        rows="4"
                        maxlength="2000"
                    ><?= View::escape(
                        $contactMapDescription
                    ) ?></textarea>

                </div>


                <div
                    class="
                        admin-form__field
                        admin-form__field--full
                    "
                >

                    <label
                        for="contact_map_embed"
                    >
                        آدرس Google Maps Embed
                    </label>

                    <textarea
                        id="contact_map_embed"
                        name="contact_map_embed"
                        rows="6"
                        maxlength="5000"
                        dir="ltr"
                    ><?= View::escape(
                        $contactMapEmbed
                    ) ?></textarea>

                    <small>
                        فقط آدرس
                        <strong>src</strong>
                        مربوط به iframe نقشه را وارد کنید، نه کل تگ iframe.
                    </small>

                </div>

            </div>

        </section>


        <!-- =====================================================
             ACTIONS
        ====================================================== -->

        <div class="admin-form__actions">

            <button
                type="submit"
                class="button button--primary"
            >
                ذخیره همه تغییرات
            </button>


            <a
                href="<?= View::url(
                    '/about'
                ) ?>"
                class="button button--secondary"
                target="_blank"
                rel="noopener noreferrer"
            >
                مشاهده درباره موسسه
            </a>


            <a
                href="<?= View::url(
                    '/contact'
                ) ?>"
                class="button button--secondary"
                target="_blank"
                rel="noopener noreferrer"
            >
                مشاهده تماس با ما
            </a>

        </div>

    </form>


    <!-- =====================================================
         SERVICES SHORTCUT
    ====================================================== -->

    <section
        class="admin-panel"
        style="margin-top:24px;"
    >

        <div class="admin-panel__header">

            <div>

                <h2>
                    مدیریت خدمات
                </h2>

                <p>
                    برای اضافه کردن، ویرایش، حذف و مرتب‌سازی خدمات از مدیریت خدمات استفاده کنید.
                </p>

            </div>

        </div>


        <div
            style="
                display:flex;
                align-items:center;
                justify-content:space-between;
                gap:16px;
                flex-wrap:wrap;
                padding:4px 0;
            "
        >

            <div>

                <strong>
                    خدمات اصلی صفحه
                </strong>

                <p
                    style="
                        margin:6px 0 0;
                        color:var(--admin-muted,#64748b);
                        font-size:13px;
                    "
                >
                    محتوای کارت‌ها در بخش «خدمات صفحه اصلی» مدیریت می‌شود.
                </p>

            </div>


            <a
                href="<?= View::route(
                    'admin.services.index'
                ) ?>"
                class="button button--secondary"
            >
                مدیریت خدمات
            </a>

        </div>

    </section>

</div>
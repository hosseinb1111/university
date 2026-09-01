<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


/*
|--------------------------------------------------------------------------
| Normalize
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
| Current values
|--------------------------------------------------------------------------
*/

$autoplay =
    !empty(
        $settings['autoplay']
        ?? true
    );

$interval =
    max(
        2000,
        min(
            30000,
            (int) (
                $settings['interval']
                ?? 5000
            )
        )
    );

$showArrows =
    !empty(
        $settings['show_arrows']
        ?? true
    );

$showDots =
    !empty(
        $settings['show_dots']
        ?? true
    );

$backgroundMode =
    (string) (
        $settings['background_mode']
        ?? 'blur'
    );

$backgroundColor =
    (string) (
        $settings['background_color']
        ?? '#111827'
    );

$gradient =
    (string) (
        $settings['gradient']
        ?? 'dark'
    );

$imageFit =
    (string) (
        $settings['image_fit']
        ?? 'contain'
    );

$imagePosition =
    (string) (
        $settings['image_position']
        ?? 'center center'
    );


/*
|--------------------------------------------------------------------------
| Select options
|--------------------------------------------------------------------------
*/

$backgroundModes = [
    'blur' =>
        'تصویر محو',

    'dominant' =>
        'رنگ غالب تصویر',

    'solid' =>
        'رنگ ثابت',

    'gradient' =>
        'گرادیان',

    'none' =>
        'بدون پس‌زمینه',
];


$gradients = [
    'dark' =>
        'تیره',

    'ocean' =>
        'اقیانوسی',

    'purple' =>
        'بنفش',

    'sunset' =>
        'غروب',

    'light' =>
        'روشن',
];


$imageFits = [
    'contain' =>
        'نمایش کامل تصویر',

    'cover' =>
        'پر کردن کامل',

    'fill' =>
        'کشیده شدن تصویر',
];


$positions = [
    'center center' =>
        'مرکز',

    'center top' =>
        'بالا',

    'center bottom' =>
        'پایین',

    'left center' =>
        'چپ',

    'right center' =>
        'راست',

    'left top' =>
        'بالا چپ',

    'right top' =>
        'بالا راست',

    'left bottom' =>
        'پایین چپ',

    'right bottom' =>
        'پایین راست',
];

?>

<div class="admin-page">

    <div class="english-admin-slider">


        <!-- =========================================================
             HEADER
        ========================================================== -->

        <header class="english-admin-slider__header">

            <div class="english-admin-slider__header-main">

                <a
                    href="<?= View::url(
                        '/admin/english'
                    ) ?>"
                    class="english-admin-slider__back"
                >
                    <span aria-hidden="true">
                        →
                    </span>

                    بازگشت به مدیریت سایت انگلیسی
                </a>


                <div class="english-admin-slider__title-row">

                    <div
                        class="english-admin-slider__title-icon"
                        aria-hidden="true"
                    >
                        🖼️
                    </div>


                    <div>

                        <span class="english-admin-slider__eyebrow">
                            مدیریت صفحه اصلی انگلیسی
                        </span>

                        <h1>
                            تنظیمات اسلایدر
                        </h1>

                        <p>
                            نحوه نمایش، حرکت و قرارگیری تصاویر
                            اسلایدر صفحه اصلی نسخه انگلیسی را تنظیم کنید.
                        </p>

                    </div>

                </div>

            </div>


            <div class="english-admin-slider__header-actions">

                <a
                    href="<?= View::url(
                        '/english'
                    ) ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="english-admin-slider__preview"
                >
                    مشاهده صفحه اصلی
                    <span aria-hidden="true">
                        ↗
                    </span>
                </a>

            </div>

        </header>


        <!-- =========================================================
             MESSAGES
        ========================================================== -->

        <?php if (
            $success !== null
        ): ?>

            <div
                class="english-admin-slider__message english-admin-slider__message--success"
                role="status"
            >

                <span
                    class="english-admin-slider__message-icon"
                    aria-hidden="true"
                >
                    ✓
                </span>

                <div>

                    <strong>
                        تنظیمات ذخیره شد
                    </strong>

                    <p>
                        تنظیمات اسلایدر انگلیسی با موفقیت
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
                class="english-admin-slider__message english-admin-slider__message--error"
                role="alert"
            >

                <span
                    class="english-admin-slider__message-icon"
                    aria-hidden="true"
                >
                    !
                </span>

                <div>

                    <strong>
                        خطا در ذخیره تنظیمات
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
                '/admin/english/slider'
            ) ?>"
            class="english-admin-slider__form"
        >

            <?= Csrf::field() ?>


            <!-- =====================================================
                 PLAYBACK
            ====================================================== -->

            <section class="english-admin-slider__card">

                <div class="english-admin-slider__card-header">

                    <div>

                        <span>
                            01
                        </span>

                        <div>

                            <h2>
                                پخش خودکار
                            </h2>

                            <p>
                                نحوه حرکت خودکار اسلایدها را کنترل کنید.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="english-admin-slider__card-body">

                    <label
                        class="english-admin-slider__toggle"
                        for="english-slider-autoplay"
                    >

                        <span
                            class="english-admin-slider__toggle-switch"
                            aria-hidden="true"
                        >
                            <span></span>
                        </span>


                        <input
                            id="english-slider-autoplay"
                            type="checkbox"
                            name="autoplay"
                            value="1"
                            <?= $autoplay
                                ? 'checked'
                                : ''
                            ?>
                        >


                        <span class="english-admin-slider__toggle-copy">

                            <strong>
                                پخش خودکار اسلایدها فعال باشد
                            </strong>

                            <small>
                                اسلایدها بدون نیاز به کلیک کاربر
                                به‌صورت خودکار تغییر می‌کنند.
                            </small>

                        </span>

                    </label>


                    <div class="english-admin-slider__field">

                        <label
                            for="english-slider-interval"
                        >
                            فاصله زمانی بین اسلایدها
                        </label>

                        <div class="english-admin-slider__input-with-unit">

                            <input
                                id="english-slider-interval"
                                type="number"
                                name="interval"
                                min="2000"
                                max="30000"
                                step="500"
                                value="<?= $interval ?>"
                            >

                            <span>
                                میلی‌ثانیه
                            </span>

                        </div>

                        <small>
                            مقدار بین ۲۰۰۰ تا ۳۰۰۰۰ میلی‌ثانیه قابل انتخاب است.
                            برای مثال، ۵۰۰۰ یعنی ۵ ثانیه.
                        </small>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 CONTROLS
            ====================================================== -->

            <section class="english-admin-slider__card">

                <div class="english-admin-slider__card-header">

                    <div>

                        <span>
                            02
                        </span>

                        <div>

                            <h2>
                                کنترل‌های اسلایدر
                            </h2>

                            <p>
                                مشخص کنید بازدیدکننده چه کنترل‌هایی
                                روی اسلایدر داشته باشد.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="english-admin-slider__card-body">

                    <div class="english-admin-slider__option-grid">

                        <label
                            class="english-admin-slider__toggle"
                            for="english-slider-arrows"
                        >

                            <span
                                class="english-admin-slider__toggle-switch"
                                aria-hidden="true"
                            >
                                <span></span>
                            </span>


                            <input
                                id="english-slider-arrows"
                                type="checkbox"
                                name="show_arrows"
                                value="1"
                                <?= $showArrows
                                    ? 'checked'
                                    : ''
                                ?>
                            >


                            <span class="english-admin-slider__toggle-copy">

                                <strong>
                                    دکمه‌های قبلی و بعدی
                                </strong>

                                <small>
                                    نمایش فلش‌های جابه‌جایی اسلاید.
                                </small>

                            </span>

                        </label>


                        <label
                            class="english-admin-slider__toggle"
                            for="english-slider-dots"
                        >

                            <span
                                class="english-admin-slider__toggle-switch"
                                aria-hidden="true"
                            >
                                <span></span>
                            </span>


                            <input
                                id="english-slider-dots"
                                type="checkbox"
                                name="show_dots"
                                value="1"
                                <?= $showDots
                                    ? 'checked'
                                    : ''
                                ?>
                            >


                            <span class="english-admin-slider__toggle-copy">

                                <strong>
                                    نقاط انتخاب اسلاید
                                </strong>

                                <small>
                                    نمایش نقاط پایین اسلایدر برای انتخاب سریع.
                                </small>

                            </span>

                        </label>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 BACKGROUND
            ====================================================== -->

            <section class="english-admin-slider__card">

                <div class="english-admin-slider__card-header">

                    <div>

                        <span>
                            03
                        </span>

                        <div>

                            <h2>
                                پس‌زمینه
                            </h2>

                            <p>
                                فضای اطراف تصویر اصلی را با یکی از
                                حالت‌های موجود پر کنید.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="english-admin-slider__card-body">

                    <div class="english-admin-slider__field">

                        <label
                            for="english-slider-background-mode"
                        >
                            حالت پس‌زمینه
                        </label>

                        <select
                            id="english-slider-background-mode"
                            name="background_mode"
                        >

                            <?php foreach (
                                $backgroundModes
                                as $value => $label
                            ): ?>

                                <option
                                    value="<?= View::escape(
                                        $value
                                    ) ?>"
                                    <?= $backgroundMode === $value
                                        ? 'selected'
                                        : ''
                                    ?>
                                >
                                    <?= View::escape(
                                        $label
                                    ) ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <div class="english-admin-slider__grid">

                        <div class="english-admin-slider__field">

                            <label
                                for="english-slider-background-color"
                            >
                                رنگ پس‌زمینه
                            </label>

                            <div class="english-admin-slider__color-field">

                                <input
                                    id="english-slider-background-color"
                                    type="color"
                                    name="background_color"
                                    value="<?= View::escape(
                                        $backgroundColor
                                    ) ?>"
                                >

                                <code>
                                    <?= View::escape(
                                        strtoupper(
                                            $backgroundColor
                                        )
                                    ) ?>
                                </code>

                            </div>

                            <small>
                                زمانی استفاده می‌شود که حالت رنگ ثابت انتخاب شده باشد.
                            </small>

                        </div>


                        <div class="english-admin-slider__field">

                            <label
                                for="english-slider-gradient"
                            >
                                نوع گرادیان
                            </label>

                            <select
                                id="english-slider-gradient"
                                name="gradient"
                            >

                                <?php foreach (
                                    $gradients
                                    as $value => $label
                                ): ?>

                                    <option
                                        value="<?= View::escape(
                                            $value
                                        ) ?>"
                                        <?= $gradient === $value
                                            ? 'selected'
                                            : ''
                                        ?>
                                    >
                                        <?= View::escape(
                                            $label
                                        ) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                            <small>
                                زمانی استفاده می‌شود که حالت گرادیان انتخاب شده باشد.
                            </small>

                        </div>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 IMAGE
            ====================================================== -->

            <section class="english-admin-slider__card">

                <div class="english-admin-slider__card-header">

                    <div>

                        <span>
                            04
                        </span>

                        <div>

                            <h2>
                                نمایش تصویر
                            </h2>

                            <p>
                                نحوه قرارگیری تصویر اصلی در قاب اسلایدر
                                را مشخص کنید.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="english-admin-slider__card-body">

                    <div class="english-admin-slider__grid">

                        <div class="english-admin-slider__field">

                            <label
                                for="english-slider-image-fit"
                            >
                                حالت تصویر
                            </label>

                            <select
                                id="english-slider-image-fit"
                                name="image_fit"
                            >

                                <?php foreach (
                                    $imageFits
                                    as $value => $label
                                ): ?>

                                    <option
                                        value="<?= View::escape(
                                            $value
                                        ) ?>"
                                        <?= $imageFit === $value
                                            ? 'selected'
                                            : ''
                                        ?>
                                    >
                                        <?= View::escape(
                                            $label
                                        ) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                            <small>
                                پیشنهاد می‌شود برای نمایش کامل تصویر،
                                گزینه «نمایش کامل تصویر» انتخاب شود.
                            </small>

                        </div>


                        <div class="english-admin-slider__field">

                            <label
                                for="english-slider-image-position"
                            >
                                موقعیت تصویر
                            </label>

                            <select
                                id="english-slider-image-position"
                                name="image_position"
                            >

                                <?php foreach (
                                    $positions
                                    as $value => $label
                                ): ?>

                                    <option
                                        value="<?= View::escape(
                                            $value
                                        ) ?>"
                                        <?= $imagePosition === $value
                                            ? 'selected'
                                            : ''
                                        ?>
                                    >
                                        <?= View::escape(
                                            $label
                                        ) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                            <small>
                                نقطه قرارگیری تصویر داخل قاب اسلایدر.
                            </small>

                        </div>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 SUMMARY
            ====================================================== -->

            <section class="english-admin-slider__summary">

                <div class="english-admin-slider__summary-icon">
                    ⚙
                </div>


                <div>

                    <span>
                        وضعیت فعلی
                    </span>

                    <strong>
                        اسلایدر انگلیسی
                        <?= $autoplay
                            ? 'به‌صورت خودکار پخش می‌شود'
                            : 'به‌صورت دستی کنترل می‌شود'
                        ?>
                    </strong>

                    <small>
                        فاصله:
                        <?= $interval ?>
                        میلی‌ثانیه
                        ·
                        فلش‌ها:
                        <?= $showArrows
                            ? 'فعال'
                            : 'غیرفعال'
                        ?>
                        ·
                        نقاط:
                        <?= $showDots
                            ? 'فعال'
                            : 'غیرفعال'
                        ?>
                    </small>

                </div>

            </section>


            <!-- =====================================================
                 SAVE
            ====================================================== -->

            <div class="english-admin-slider__savebar">

                <div>

                    <strong>
                        آماده ذخیره تنظیمات؟
                    </strong>

                    <span>
                        این تنظیمات فقط روی اسلایدر نسخه انگلیسی تأثیر می‌گذارند.
                    </span>

                </div>


                <div class="english-admin-slider__actions">

                    <a
                        href="<?= View::url(
                            '/admin/english'
                        ) ?>"
                        class="english-admin-slider__cancel"
                    >
                        انصراف
                    </a>


                    <button
                        type="submit"
                        class="english-admin-slider__save"
                    >

                        <span aria-hidden="true">
                            ✓
                        </span>

                        ذخیره تنظیمات

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


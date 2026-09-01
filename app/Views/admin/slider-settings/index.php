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

$previewImage =
    trim(
        (string) (
            $previewImage
            ?? ''
        )
    );


$autoplay =
    (bool) (
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
    (bool) (
        $settings['show_arrows']
        ?? true
    );

$showDots =
    (bool) (
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

?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>

            <span
                style="
                    display:block;
                    margin-bottom:6px;
                    color:var(--admin-muted-color,#667085);
                    font-size:13px;
                    font-weight:600;
                "
            >
                صفحه اصلی
            </span>

            <h1>
                تنظیمات اسلایدر
            </h1>

            <p>
                نحوه نمایش، پس‌زمینه و رفتار اسلایدر صفحه اصلی را مدیریت کنید.
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
                            is_string($error)
                                ? $error
                                : 'خطای نامشخص'
                        ) ?>
                    </li>

                <?php endforeach; ?>

            </ul>

        </div>

    <?php endif; ?>


    <form
        method="POST"
        action="<?= View::route(
            'admin.slider-settings.update'
        ) ?>"
        class="admin-form"
        id="slider-settings-form"
    >

        <?= Csrf::field() ?>


        <!-- =================================================
             SLIDER BEHAVIOR
        ================================================== -->

        <section class="admin-panel">

            <div class="admin-panel__header">

                <div>

                    <h2>
                        رفتار اسلایدر
                    </h2>

                    <p>
                        کنترل حرکت خودکار و کنترل‌های اسلایدر.
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

                    <label class="admin-checkbox">

                        <input
                            type="checkbox"
                            name="autoplay"
                            value="1"
                            <?= $autoplay
                                ? 'checked'
                                : ''
                            ?>
                        >

                        <span>
                            پخش خودکار اسلایدها
                        </span>

                    </label>

                    <small>
                        اسلایدها به صورت خودکار جابه‌جا می‌شوند.
                    </small>

                </div>


                <div class="admin-form__field">

                    <label for="interval">
                        مدت نمایش هر اسلاید
                    </label>

                    <div
                        style="
                            display:flex;
                            align-items:center;
                            gap:10px;
                            max-width:420px;
                        "
                    >

                        <input
                            id="interval"
                            name="interval"
                            type="number"
                            min="2000"
                            max="30000"
                            step="500"
                            value="<?= $interval ?>"
                            required
                        >

                        <span>
                            میلی‌ثانیه
                        </span>

                    </div>

                    <small>
                        بین ۲ تا ۳۰ ثانیه.
                        مقدار ۵۰۰۰ یعنی ۵ ثانیه.
                    </small>

                </div>


                <div
                    class="
                        admin-form__field
                        admin-form__field--full
                    "
                >

                    <label class="admin-checkbox">

                        <input
                            type="checkbox"
                            name="show_arrows"
                            value="1"
                            <?= $showArrows
                                ? 'checked'
                                : ''
                            ?>
                        >

                        <span>
                            نمایش دکمه‌های قبلی و بعدی
                        </span>

                    </label>

                </div>


                <div
                    class="
                        admin-form__field
                        admin-form__field--full
                    "
                >

                    <label class="admin-checkbox">

                        <input
                            type="checkbox"
                            name="show_dots"
                            value="1"
                            <?= $showDots
                                ? 'checked'
                                : ''
                            ?>
                        >

                        <span>
                            نمایش نشانگرهای اسلاید
                        </span>

                    </label>

                    <small>
                        دایره‌های پایین اسلایدر که امکان انتخاب مستقیم اسلاید را می‌دهند.
                    </small>

                </div>

            </div>

        </section>


        <!-- =================================================
             BACKGROUND
        ================================================== -->

        <section
            class="admin-panel"
            style="margin-top:24px;"
        >

            <div class="admin-panel__header">

                <div>

                    <h2>
                        پس‌زمینه اسلایدر
                    </h2>

                    <p>
                        مشخص کنید فضای پشت تصویر چگونه نمایش داده شود.
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

                    <label for="background_mode">
                        نوع پس‌زمینه
                    </label>

                    <select
                        id="background_mode"
                        name="background_mode"
                    >

                        <option
                            value="blur"
                            <?= $backgroundMode === 'blur'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            تاریک و محو
                        </option>

                        <option
                            value="dominant"
                            <?= $backgroundMode === 'dominant'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            رنگ غالب تصویر
                        </option>

                        <option
                            value="solid"
                            <?= $backgroundMode === 'solid'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            رنگ ثابت
                        </option>

                        <option
                            value="gradient"
                            <?= $backgroundMode === 'gradient'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            گرادیان
                        </option>

                        <option
                            value="none"
                            <?= $backgroundMode === 'none'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            بدون پس‌زمینه
                        </option>

                    </select>

                </div>


                <div
                    class="admin-form__field"
                    id="background-color-field"
                >

                    <label for="background_color">
                        رنگ پس‌زمینه
                    </label>

                    <div
                        style="
                            display:flex;
                            align-items:center;
                            gap:12px;
                        "
                    >

                        <input
                            type="color"
                            id="background_color"
                            name="background_color"
                            value="<?= View::escape(
                                $backgroundColor
                            ) ?>"
                            style="
                                width:64px;
                                height:44px;
                                padding:4px;
                                cursor:pointer;
                            "
                        >

                        <input
                            type="text"
                            id="background_color_text"
                            value="<?= View::escape(
                                $backgroundColor
                            ) ?>"
                            maxlength="7"
                            style="
                                max-width:120px;
                                direction:ltr;
                                text-align:left;
                            "
                        >

                    </div>

                    <small>
                        برای حالت «رنگ ثابت» استفاده می‌شود.
                    </small>

                </div>


                <div
                    class="admin-form__field"
                    id="gradient-field"
                >

                    <label for="gradient">
                        نوع گرادیان
                    </label>

                    <select
                        id="gradient"
                        name="gradient"
                    >

                        <option
                            value="dark"
                            <?= $gradient === 'dark'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            تیره
                        </option>

                        <option
                            value="ocean"
                            <?= $gradient === 'ocean'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            اقیانوسی
                        </option>

                        <option
                            value="purple"
                            <?= $gradient === 'purple'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            بنفش
                        </option>

                        <option
                            value="sunset"
                            <?= $gradient === 'sunset'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            غروب
                        </option>

                        <option
                            value="light"
                            <?= $gradient === 'light'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            روشن
                        </option>

                    </select>

                </div>

            </div>

        </section>


        <!-- =================================================
             IMAGE DISPLAY
        ================================================== -->

        <section
            class="admin-panel"
            style="margin-top:24px;"
        >

            <div class="admin-panel__header">

                <div>

                    <h2>
                        نحوه نمایش تصویر
                    </h2>

                    <p>
                        مشخص کنید تصویر اسلاید چگونه داخل قاب قرار بگیرد.
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

                    <label for="image_fit">
                        نحوه نمایش
                    </label>

                    <select
                        id="image_fit"
                        name="image_fit"
                    >

                        <option
                            value="contain"
                            <?= $imageFit === 'contain'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            نمایش کامل
                        </option>

                        <option
                            value="cover"
                            <?= $imageFit === 'cover'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            پر کردن قاب
                        </option>

                        <option
                            value="fill"
                            <?= $imageFit === 'fill'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            کشیده / آزاد
                        </option>

                    </select>

                    <small>
                        «نمایش کامل» تصویر را بدون برش نشان می‌دهد.
                    </small>

                </div>


                <div
                    class="
                        admin-form__field
                        admin-form__field--full
                    "
                >

                    <label for="image_position">
                        موقعیت تصویر
                    </label>

                    <select
                        id="image_position"
                        name="image_position"
                    >

                        <option
                            value="center center"
                            <?= $imagePosition === 'center center'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            مرکز
                        </option>

                        <option
                            value="center top"
                            <?= $imagePosition === 'center top'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            بالا
                        </option>

                        <option
                            value="center bottom"
                            <?= $imagePosition === 'center bottom'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            پایین
                        </option>

                        <option
                            value="left center"
                            <?= $imagePosition === 'left center'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            چپ
                        </option>

                        <option
                            value="right center"
                            <?= $imagePosition === 'right center'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            راست
                        </option>

                        <option
                            value="left top"
                            <?= $imagePosition === 'left top'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            بالا - چپ
                        </option>

                        <option
                            value="right top"
                            <?= $imagePosition === 'right top'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            بالا - راست
                        </option>

                        <option
                            value="left bottom"
                            <?= $imagePosition === 'left bottom'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            پایین - چپ
                        </option>

                        <option
                            value="right bottom"
                            <?= $imagePosition === 'right bottom'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            پایین - راست
                        </option>

                    </select>

                </div>

            </div>

        </section>


        <!-- =================================================
             LIVE PREVIEW
        ================================================== -->

        <section
            class="admin-panel"
            style="margin-top:24px;"
        >

            <div class="admin-panel__header">

                <div>

                    <h2>
                        پیش‌نمایش زنده
                    </h2>

                    <p>
                        تغییرات انتخابی شما در اینجا به صورت تقریبی دیده می‌شود.
                    </p>

                </div>

            </div>


            <div
                id="slider-settings-preview"
                style="
                    position:relative;
                    width:100%;
                    aspect-ratio:16 / 5;
                    min-height:220px;
                    overflow:hidden;
                    border-radius:12px;
                    background:#111827;
                    isolation:isolate;
                "
            >

                <div
                    id="slider-settings-preview-backdrop"
                    style="
                        position:absolute;
                        inset:0;
                        background-position:center;
                        background-size:cover;
                        filter:blur(28px) brightness(.55);
                        transform:scale(1.18);
                    "
                ></div>


                <?php if (
                    $previewImage !== ''
                ): ?>

                    <img
                        id="slider-settings-preview-image"
                        src="<?= View::escape(
                            $previewImage
                        ) ?>"
                        alt=""
                        style="
                            position:absolute;
                            inset:0;
                            width:100%;
                            height:100%;
                            object-fit:contain;
                            object-position:center center;
                        "
                    >

                <?php else: ?>

                    <div
                        id="slider-settings-preview-image"
                        style="
                            position:absolute;
                            inset:0;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            color:#fff;
                            font-size:14px;
                            background:#111827;
                        "
                    >
                        هنوز اسلایدی برای پیش‌نمایش وجود ندارد.
                    </div>

                <?php endif; ?>


                <div
                    id="slider-settings-preview-overlay"
                    style="
                        position:absolute;
                        inset:0;
                        pointer-events:none;
                        background:
                            linear-gradient(
                                90deg,
                                rgba(15,23,42,.72),
                                rgba(15,23,42,.20),
                                rgba(15,23,42,.05)
                            );
                    "
                ></div>


                <div
                    style="
                        position:absolute;
                        right:28px;
                        top:50%;
                        transform:translateY(-50%);
                        z-index:5;
                        color:#fff;
                        max-width:55%;
                    "
                >

                    <small
                        style="
                            display:block;
                            margin-bottom:8px;
                            opacity:.8;
                        "
                    >
                        پیش‌نمایش اسلاید
                    </small>

                    <strong
                        style="
                            display:block;
                            font-size:clamp(20px,3vw,34px);
                            line-height:1.4;
                        "
                    >
                        عنوان نمونه اسلاید
                    </strong>

                </div>

            </div>

        </section>


        <!-- =================================================
             ACTIONS
        ================================================== -->

        <div class="admin-form__actions">

            <button
                type="submit"
                class="button button--primary"
            >
                ذخیره تنظیمات
            </button>


            <a
                href="<?= View::url(
                    '/admin/slides'
                ) ?>"
                class="button button--secondary"
            >
                مدیریت اسلایدها
            </a>


            <a
                href="<?= View::url(
                    '/'
                ) ?>"
                class="button button--secondary"
                target="_blank"
                rel="noopener noreferrer"
            >
                مشاهده صفحه اصلی
            </a>

        </div>

    </form>

</div>


<script>
(function () {
    'use strict';

    const form =
        document.getElementById(
            'slider-settings-form'
        );

    if (!form) {
        return;
    }


    const backgroundMode =
        document.getElementById(
            'background_mode'
        );

    const backgroundColor =
        document.getElementById(
            'background_color'
        );

    const backgroundColorText =
        document.getElementById(
            'background_color_text'
        );

    const gradient =
        document.getElementById(
            'gradient'
        );

    const imageFit =
        document.getElementById(
            'image_fit'
        );

    const imagePosition =
        document.getElementById(
            'image_position'
        );


    const colorField =
        document.getElementById(
            'background-color-field'
        );

    const gradientField =
        document.getElementById(
            'gradient-field'
        );


    const preview =
        document.getElementById(
            'slider-settings-preview'
        );

    const previewBackdrop =
        document.getElementById(
            'slider-settings-preview-backdrop'
        );

    const previewImage =
        document.getElementById(
            'slider-settings-preview-image'
        );


    const gradients = {
        dark:
            'linear-gradient(135deg, #0f172a, #1e293b)',

        ocean:
            'linear-gradient(135deg, #0f172a, #0369a1)',

        purple:
            'linear-gradient(135deg, #1e1b4b, #7e22ce)',

        sunset:
            'linear-gradient(135deg, #7c2d12, #db2777)',

        light:
            'linear-gradient(135deg, #e5e7eb, #f8fafc)',
    };


    function getDominantColor(imageElement) {

        if (
            !imageElement
            || imageElement.tagName !== 'IMG'
        ) {
            return '#111827';
        }


        try {

            const canvas =
                document.createElement(
                    'canvas'
                );

            const context =
                canvas.getContext(
                    '2d'
                );

            if (!context) {
                return '#111827';
            }


            const width = 32;
            const height = 32;

            canvas.width = width;
            canvas.height = height;


            context.drawImage(
                imageElement,
                0,
                0,
                width,
                height
            );


            const data =
                context.getImageData(
                    0,
                    0,
                    width,
                    height
                ).data;


            let red = 0;
            let green = 0;
            let blue = 0;
            let count = 0;


            for (
                let index = 0;
                index < data.length;
                index += 16
            ) {
                const r = data[index];
                const g = data[index + 1];
                const b = data[index + 2];

                if (
                    r > 245
                    && g > 245
                    && b > 245
                ) {
                    continue;
                }

                red += r;
                green += g;
                blue += b;

                count++;
            }


            if (
                count === 0
            ) {
                return '#111827';
            }


            red =
                Math.round(
                    red / count
                );

            green =
                Math.round(
                    green / count
                );

            blue =
                Math.round(
                    blue / count
                );


            return (
                '#'
                + red.toString(16).padStart(2, '0')
                + green.toString(16).padStart(2, '0')
                + blue.toString(16).padStart(2, '0')
            );

        } catch (
            error
        ) {
            return '#111827';
        }
    }


    function updateFields() {

        const mode =
            backgroundMode.value;


        if (
            colorField
        ) {
            colorField.style.display =
                mode === 'solid'
                    ? ''
                    : 'none';
        }


        if (
            gradientField
        ) {
            gradientField.style.display =
                mode === 'gradient'
                    ? ''
                    : 'none';
        }
    }


    function updatePreview() {

        if (
            !preview
        ) {
            return;
        }


        const mode =
            backgroundMode.value;


        const color =
            backgroundColor.value
            || '#111827';


        const gradientValue =
            gradients[
                gradient.value
            ]
            || gradients.dark;


        /*
        |--------------------------------------------------------------------------
        | Image
        |--------------------------------------------------------------------------
        */

        if (
            previewImage
            && previewImage.tagName === 'IMG'
        ) {
            previewImage.style.objectFit =
                imageFit.value;

            previewImage.style.objectPosition =
                imagePosition.value;

            previewImage.style.display =
                'block';
        }


        /*
        |--------------------------------------------------------------------------
        | Background
        |--------------------------------------------------------------------------
        */

        preview.style.background =
            '#111827';


        if (
            previewBackdrop
        ) {
            previewBackdrop.style.display =
                'none';

            previewBackdrop.style.backgroundColor =
                'transparent';

            previewBackdrop.style.backgroundImage =
                'none';

            previewBackdrop.style.filter =
                'none';
        }


        if (
            mode === 'blur'
        ) {
            preview.style.background =
                '#111827';

            if (
                previewBackdrop
                && previewImage
                && previewImage.tagName === 'IMG'
            ) {
                previewBackdrop.style.display =
                    'block';

                previewBackdrop.style.backgroundImage =
                    'url("' + previewImage.src + '")';

                previewBackdrop.style.backgroundPosition =
                    imagePosition.value;

                previewBackdrop.style.backgroundSize =
                    'cover';

                previewBackdrop.style.filter =
                    'blur(28px) brightness(.55)';

            }
        }


        if (
            mode === 'dominant'
        ) {
            const dominant =
                getDominantColor(
                    previewImage
                );

            preview.style.background =
                dominant;

            if (
                previewBackdrop
                && previewImage
                && previewImage.tagName === 'IMG'
            ) {
                previewBackdrop.style.display =
                    'block';

                previewBackdrop.style.backgroundImage =
                    'url("' + previewImage.src + '")';

                previewBackdrop.style.backgroundPosition =
                    imagePosition.value;

                previewBackdrop.style.backgroundSize =
                    'cover';

                previewBackdrop.style.backgroundColor =
                    dominant;

                previewBackdrop.style.filter =
                    'blur(28px) brightness(.55)';
            }
        }


        if (
            mode === 'solid'
        ) {
            preview.style.background =
                color;
        }


        if (
            mode === 'gradient'
        ) {
            preview.style.background =
                gradientValue;
        }


        if (
            mode === 'none'
        ) {
            preview.style.background =
                'transparent';
        }


        updateFields();
    }


    if (
        backgroundColor
        && backgroundColorText
    ) {

        backgroundColor.addEventListener(
            'input',
            function () {
                backgroundColorText.value =
                    backgroundColor.value;

                updatePreview();
            }
        );


        backgroundColorText.addEventListener(
            'input',
            function () {

                const value =
                    backgroundColorText.value;


                if (
                    /^#[0-9a-fA-F]{6}$/.test(
                        value
                    )
                ) {
                    backgroundColor.value =
                        value;

                    updatePreview();
                }
            }
        );
    }


    [
        backgroundMode,
        gradient,
        imageFit,
        imagePosition,
    ].forEach(
        function (element) {

            if (!element) {
                return;
            }

            element.addEventListener(
                'change',
                updatePreview
            );
        }
    );


    if (
        previewImage
        && previewImage.tagName === 'IMG'
    ) {
        if (
            previewImage.complete
        ) {
            updatePreview();
        } else {
            previewImage.addEventListener(
                'load',
                updatePreview
            );
        }
    } else {
        updatePreview();
    }
})();
</script>
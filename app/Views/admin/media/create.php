<?php

declare(strict_types=1);

use App\Core\Session;
use App\Core\View;

$error =
    Session::getFlash(
        'error'
    );

$oldSuccess =
    Session::getFlash(
        'success'
    );

?>

<div class="media-admin--create">

    <!-- =========================================================
         HEADER
    ========================================================== -->

    <header class="media-admin__header">

        <a
            href="<?= View::route(
                'admin.media.index'
            ) ?>"
            class="media-admin__back"
        >

            <span aria-hidden="true">
                →
            </span>

            بازگشت به کتابخانه رسانه

        </a>


        <span class="media-admin__eyebrow">
            کتابخانه رسانه
        </span>


        <h1>
            افزودن رسانه
        </h1>


        <p>
            تصاویر و فایل‌های مورد نیاز سایت را
            آپلود کنید.
            می‌توانید چند فایل را هم‌زمان انتخاب
            یا مستقیماً داخل کادر زیر بکشید.
        </p>

    </header>


    <!-- =========================================================
         ERROR
    ========================================================== -->

    <?php if (
        is_string($error)
        && $error !== ''
    ): ?>

        <div
            class="
                media-admin__alert
                media-admin__alert--error
            "
            role="alert"
        >

            <span
                class="media-admin__alert-icon"
                aria-hidden="true"
            >
                !
            </span>

            <span>
                <?= View::escape(
                    $error
                ) ?>
            </span>

        </div>

    <?php endif; ?>


    <!-- =========================================================
         SUCCESS
    ========================================================== -->

    <?php if (
        is_string($oldSuccess)
        && $oldSuccess !== ''
    ): ?>

        <div
            class="
                media-admin__alert
                media-admin__alert--success
            "
            role="status"
        >

            <span
                class="media-admin__alert-icon"
                aria-hidden="true"
            >
                ✓
            </span>

            <span>
                <?= View::escape(
                    $oldSuccess
                ) ?>
            </span>

        </div>

    <?php endif; ?>


    <!-- =========================================================
         PANEL
    ========================================================== -->

    <section class="media-admin__panel">


        <!-- =====================================================
             PANEL HEADER
        ====================================================== -->

        <div class="media-admin__panel-header">

            <span>
                Upload
            </span>

            <h2>
                انتخاب فایل
            </h2>

            <p>
                فایل‌ها را بکشید و اینجا رها کنید،
                یا روی دکمه انتخاب فایل کلیک کنید.
            </p>

        </div>


        <!-- =====================================================
             FORM
        ====================================================== -->

        <form
            method="POST"
            action="<?= View::route(
                'admin.media.store'
            ) ?>"
            enctype="multipart/form-data"
            class="media-upload-form"
            id="media-upload-form"
        >

            <?= \App\Core\Csrf::field() ?>


            <!-- =================================================
                 REAL FILE INPUT
            ================================================== -->

            <input
                id="media"
                name="media[]"
                type="file"
                multiple
                hidden
                accept="
                    image/jpeg,
                    image/png,
                    image/webp,
                    image/gif,
                    application/pdf
                "
            >


            <!-- =================================================
                 DROPZONE
            ================================================== -->

            <div
                class="media-dropzone"
                id="media-dropzone"
                role="button"
                tabindex="0"
                aria-label="انتخاب یا رها کردن فایل‌ها برای آپلود"
            >

                <div
                    class="media-dropzone__icon"
                    aria-hidden="true"
                >
                    ↑
                </div>


                <div class="media-dropzone__content">

                    <strong>
                        فایل‌ها را اینجا رها کنید
                    </strong>

                    <span>
                        یا از دستگاه خود فایل انتخاب کنید
                    </span>

                    <small>
                        امکان انتخاب یا کشیدن چند فایل به صورت هم‌زمان وجود دارد.
                    </small>

                </div>


                <button
                    type="button"
                    class="media-dropzone__button"
                    id="media-select-button"
                >
                    انتخاب فایل
                </button>

            </div>


            <!-- =================================================
                 SELECTED FILES
            ================================================== -->

            <section
                class="media-upload-list"
                id="media-upload-list"
                hidden
            >

                <header class="media-upload-list__header">

                    <div>

                        <strong>
                            فایل‌های انتخاب‌شده
                        </strong>

                        <span id="media-upload-count">
                            ۰ فایل
                        </span>

                    </div>


                    <button
                        type="button"
                        class="media-upload-list__clear"
                        id="media-upload-clear"
                    >
                        حذف همه
                    </button>

                </header>


                <div
                    class="media-upload-list__items"
                    id="media-upload-items"
                ></div>


                <div class="media-upload-summary">

                    <span>
                        حجم کل
                    </span>

                    <strong id="media-upload-total-size">
                        ۰ بایت
                    </strong>

                </div>

            </section>


            <!-- =================================================
                 ALT TEXT
            ================================================== -->

            <div class="media-upload-field">

                <label
                    for="alt_text"
                >
                    متن جایگزین تصویر
                </label>


                <input
                    id="alt_text"
                    name="alt_text"
                    type="text"
                    maxlength="255"
                    placeholder="مثلاً نمای ساختمان موسسه"
                >


                <small>
                    برای تصاویر، متن جایگزین به دسترس‌پذیری و سئو کمک می‌کند.
                </small>

            </div>


            <!-- =================================================
                 ACTIONS
            ================================================== -->

            <div class="media-upload-actions">

                <a
                    href="<?= View::route(
                        'admin.media.index'
                    ) ?>"
                    class="
                        media-upload-button
                        media-upload-button--secondary
                    "
                >
                    انصراف
                </a>


                <button
                    type="submit"
                    class="
                        media-upload-button
                        media-upload-button--primary
                    "
                    id="media-upload-submit"
                    disabled
                >
                    آپلود فایل‌ها
                </button>

            </div>

        </form>

    </section>

</div>
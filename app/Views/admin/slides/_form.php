<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;

$slide =
    is_array(
        $slide ?? null
    )
        ? $slide
        : [];

$errors =
    is_array(
        $errors ?? null
    )
        ? $errors
        : [];

$action =
    is_string(
        $action ?? null
    )
        ? $action
        : '';

$submitLabel =
    is_string(
        $submitLabel ?? null
    )
        ? $submitLabel
        : 'ذخیره';


/*
|--------------------------------------------------------------------------
| Existing values
|--------------------------------------------------------------------------
*/

$title =
    (string) (
        $slide['title']
        ?? ''
    );

$subtitle =
    (string) (
        $slide['subtitle']
        ?? ''
    );

$description =
    (string) (
        $slide['description']
        ?? ''
    );

$buttonText =
    (string) (
        $slide['button_text']
        ?? ''
    );

$buttonUrl =
    (string) (
        $slide['button_url']
        ?? ''
    );

$image =
    trim(
        (string) (
            $slide['image']
            ?? ''
        )
    );

$mobileImage =
    trim(
        (string) (
            $slide['mobile_image']
            ?? ''
        )
    );

$sortOrder =
    (int) (
        $slide['sort_order']
        ?? 0
    );

$isActive =
    (int) (
        $slide['is_active']
        ?? 1
    ) === 1;


?>

<form
    method="POST"
    action="<?= View::escape(
        $action
    ) ?>"
    class="admin-form"
    enctype="multipart/form-data"
>

    <?= Csrf::field() ?>


    <?php if (
        $errors !== []
    ): ?>

        <div
            class="admin-alert admin-alert--error"
            role="alert"
        >

            <strong>
                فرم دارای خطا است.
            </strong>

            <ul>

                <?php foreach (
                    $errors
                    as $error
                ): ?>

                    <li>
                        <?= View::escape(
                            is_string(
                                $error
                            )
                                ? $error
                                : 'خطای نامشخص'
                        ) ?>
                    </li>

                <?php endforeach; ?>

            </ul>

        </div>

    <?php endif; ?>


    <div class="admin-form__grid">


        <!-- =================================================
             Title
        ================================================== -->

        <div
            class="
                admin-form__field
                admin-form__field--full
            "
        >

            <label
                for="title"
            >
                عنوان (اختیاری)
            </label>

            <input
                id="title"
                name="title"
                type="text"
                value="<?= View::escape(
                    $title
                ) ?>"
                maxlength="255"
                autofocus
            >

        </div>


        <!-- =================================================
             Subtitle
        ================================================== -->

        <div class="admin-form__field">

            <label
                for="subtitle"
            >
                زیرعنوان
            </label>

            <input
                id="subtitle"
                name="subtitle"
                type="text"
                value="<?= View::escape(
                    $subtitle
                ) ?>"
                maxlength="255"
            >

        </div>


        <!-- =================================================
             Sort order
        ================================================== -->

        <div class="admin-form__field">

            <label
                for="sort_order"
            >
                ترتیب نمایش
            </label>

            <input
                id="sort_order"
                name="sort_order"
                type="number"
                min="0"
                max="999999"
                step="1"
                value="<?= $sortOrder ?>"
            >

        </div>


        <!-- =================================================
             Description
        ================================================== -->

        <div
            class="
                admin-form__field
                admin-form__field--full
            "
        >

            <label
                for="description"
            >
                توضیحات
            </label>

            <textarea
                id="description"
                name="description"
                rows="6"
            ><?= View::escape(
                $description
            ) ?></textarea>

        </div>


        <!-- =================================================
             Button text
        ================================================== -->

        <div class="admin-form__field">

            <label
                for="button_text"
            >
                متن دکمه
            </label>

            <input
                id="button_text"
                name="button_text"
                type="text"
                value="<?= View::escape(
                    $buttonText
                ) ?>"
                maxlength="255"
                placeholder="مثلاً مشاهده اطلاعیه‌ها"
            >

        </div>


        <!-- =================================================
             Button URL
        ================================================== -->

        <div class="admin-form__field">

            <label
                for="button_url"
            >
                لینک دکمه
            </label>

            <input
                id="button_url"
                name="button_url"
                type="text"
                value="<?= View::escape(
                    $buttonUrl
                ) ?>"
                maxlength="500"
                placeholder="/announcements"
            >

            <small>
                لینک داخلی مانند
                /announcements
                یا لینک خارجی با
                https://
            </small>

        </div>


        <!-- =================================================
             Desktop image (direct upload)
        ================================================== -->

        <div
            class="
                admin-form__field
                admin-form__field--full
            "
        >

            <label
                for="image"
            >
                تصویر اصلی
            </label>

            <div
                class="admin-dropzone"
                id="image-dropzone"
                tabindex="0"
                role="button"
                aria-describedby="image-dropzone-hint"
            >

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept="image/*"
                    class="admin-dropzone__input"
                >

                <div class="admin-dropzone__body">

                    <span class="admin-dropzone__icon" aria-hidden="true">
                        📁
                    </span>

                    <span class="admin-dropzone__text">
                        تصویر را اینجا رها کنید، یا برای انتخاب فایل کلیک کنید
                    </span>

                    <span
                        class="admin-dropzone__filename"
                        id="image-filename"
                    ></span>

                </div>

                <div
                    class="admin-image-preview<?= $image === '' ? ' admin-image-preview--empty' : '' ?>"
                    id="image-preview-wrap"
                >

                    <img
                        src="<?= View::escape(
                            $image
                        ) ?>"
                        alt=""
                        loading="lazy"
                        id="image-preview"
                    >

                </div>

            </div>

            <small id="image-dropzone-hint">
                فرمت مجاز: jpg، png، webp — حداکثر ۵ مگابایت.
                <?php if (
                    $image !== ''
                ): ?>
                    برای حفظ تصویر فعلی، این فیلد را خالی بگذارید.
                <?php endif; ?>
            </small>

        </div>


        <!-- =================================================
             Mobile image (direct upload)
        ================================================== -->

        <div
            class="
                admin-form__field
                admin-form__field--full
            "
        >

            <label
                for="mobile_image"
            >
                تصویر موبایل
            </label>

            <div
                class="admin-dropzone"
                id="mobile_image-dropzone"
                tabindex="0"
                role="button"
                aria-describedby="mobile_image-dropzone-hint"
            >

                <input
                    type="file"
                    id="mobile_image"
                    name="mobile_image"
                    accept="image/*"
                    class="admin-dropzone__input"
                >

                <div class="admin-dropzone__body">

                    <span class="admin-dropzone__icon" aria-hidden="true">
                        📁
                    </span>

                    <span class="admin-dropzone__text">
                        تصویر را اینجا رها کنید، یا برای انتخاب فایل کلیک کنید
                    </span>

                    <span
                        class="admin-dropzone__filename"
                        id="mobile_image-filename"
                    ></span>

                </div>

                <div
                    class="admin-image-preview<?= $mobileImage === '' ? ' admin-image-preview--empty' : '' ?>"
                    id="mobile_image-preview-wrap"
                >

                    <img
                        src="<?= View::escape(
                            $mobileImage
                        ) ?>"
                        alt=""
                        loading="lazy"
                        id="mobile_image-preview"
                    >

                </div>

            </div>

            <small id="mobile_image-dropzone-hint">
                اختیاری؛ در صورت خالی بودن، تصویر اصلی استفاده می‌شود.
                <?php if (
                    $mobileImage !== ''
                ): ?>
                    برای حفظ تصویر فعلی، این فیلد را خالی بگذارید.
                <?php endif; ?>
            </small>

        </div>


        <!-- =================================================
             Active
        ================================================== -->

        <div
            class="
                admin-form__field
                admin-form__field--full
            "
        >

            <label class="admin-checkbox">

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    <?= $isActive
                        ? 'checked'
                        : ''
                    ?>
                >

                <span>
                    این اسلاید فعال باشد
                </span>

            </label>

        </div>

    </div>


    <div class="admin-form__actions">

        <button
            type="submit"
            class="button button--primary"
        >
            <?= View::escape(
                $submitLabel
            ) ?>
        </button>


        <a
            href="<?= View::url(
                '/admin/slides'
            ) ?>"
            class="button button--secondary"
        >
            انصراف
        </a>

    </div>

</form>


<style>
.admin-dropzone {
    position: relative;
    display: block;
    border: 2px dashed var(--admin-border-color, #d0d5dd);
    border-radius: 8px;
    padding: 24px 16px;
    text-align: center;
    cursor: pointer;
    transition: border-color .15s ease, background-color .15s ease;
}

.admin-dropzone:hover,
.admin-dropzone:focus-visible {
    border-color: var(--admin-primary-color, #2563eb);
    outline: none;
}

.admin-dropzone.is-dragover {
    border-color: var(--admin-primary-color, #2563eb);
    background-color: rgba(37, 99, 235, .05);
}

.admin-dropzone__input {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.admin-dropzone__body {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    pointer-events: none;
}

.admin-dropzone__icon {
    font-size: 24px;
}

.admin-dropzone__filename {
    font-size: 13px;
    color: var(--admin-primary-color, #2563eb);
    word-break: break-all;
}

.admin-image-preview {
    margin-top: 12px;
    pointer-events: none;
}

.admin-image-preview--empty {
    display: none;
}

.admin-image-preview img {
    max-width: 220px;
    max-height: 140px;
    border-radius: 6px;
    object-fit: cover;
}
</style>


<script>
(function () {
    function bindDropzone(inputId, zoneId, wrapId, imgId, filenameId) {
        var input = document.getElementById(inputId);
        var zone = document.getElementById(zoneId);

        if (!input || !zone) {
            return;
        }

        function showFile(file) {
            if (!file) {
                return;
            }

            var img = document.getElementById(imgId);
            var wrap = document.getElementById(wrapId);

            if (!img) {
                wrap = document.createElement('div');
                wrap.className = 'admin-image-preview';
                wrap.id = wrapId;

                img = document.createElement('img');
                img.id = imgId;
                img.alt = '';
                img.loading = 'lazy';

                wrap.appendChild(img);
                zone.appendChild(wrap);
            }

            wrap.classList.remove('admin-image-preview--empty');
            img.src = URL.createObjectURL(file);

            var filenameEl = document.getElementById(filenameId);

            if (filenameEl) {
                filenameEl.textContent = file.name;
            }
        }

        /*
         * Click-to-browse / manual selection.
         */
        input.addEventListener('change', function (event) {
            showFile(event.target.files[0]);
        });

        /*
         * Keyboard access (Enter / Space) since the input itself
         * is transparent and stretched over the whole dropzone.
         */
        zone.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                input.click();
            }
        });

        /*
         * Drag and drop.
         */
        ['dragenter', 'dragover'].forEach(function (eventName) {
            zone.addEventListener(eventName, function (event) {
                event.preventDefault();
                event.stopPropagation();
                zone.classList.add('is-dragover');
            });
        });

        ['dragleave', 'dragend'].forEach(function (eventName) {
            zone.addEventListener(eventName, function (event) {
                event.preventDefault();
                event.stopPropagation();
                zone.classList.remove('is-dragover');
            });
        });

        zone.addEventListener('drop', function (event) {
            event.preventDefault();
            event.stopPropagation();
            zone.classList.remove('is-dragover');

            var files = event.dataTransfer ? event.dataTransfer.files : null;

            if (!files || !files.length) {
                return;
            }

            var file = files[0];

            if (file.type.indexOf('image/') !== 0) {
                return;
            }

            /*
             * Assign the dropped file to the real <input type="file">
             * so it submits with the form exactly like a manually
             * chosen file would.
             */
            var dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            input.files = dataTransfer.files;

            showFile(file);
        });
    }

    bindDropzone('image', 'image-dropzone', 'image-preview-wrap', 'image-preview', 'image-filename');
    bindDropzone('mobile_image', 'mobile_image-dropzone', 'mobile_image-preview-wrap', 'mobile_image-preview', 'mobile_image-filename');
})();
</script>
<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;

$item =
    is_array($item ?? null)
        ? $item
        : [];

$errors =
    is_array($errors ?? null)
        ? $errors
        : [];

$action =
    (string) (
        $action
        ?? ''
    );

$submitLabel =
    (string) (
        $submitLabel
        ?? 'ذخیره'
    );

$image =
    trim(
        (string) (
            $item['image']
            ?? ''
        )
    );

?>

<style>
    .admin-image-upload {
        position: relative;

        width: 100%;
    }

    .admin-image-upload__dropzone {
        position: relative;

        display: flex;
        flex-direction: column;

        align-items: center;
        justify-content: center;

        width: 100%;
        min-height: 190px;

        padding: 28px 24px;

        border:
            2px dashed
            var(--border-color, #d1d5db);

        border-radius:
            var(--radius-md, 10px);

        background:
            var(
                --surface-muted,
                #f9fafb
            );

        color:
            var(
                --text-muted,
                #6b7280
            );

        text-align: center;

        cursor: pointer;

        transition:
            border-color 0.2s ease,
            background 0.2s ease,
            color 0.2s ease,
            transform 0.2s ease;
    }

    .admin-image-upload__dropzone:hover {
        border-color:
            var(
                --primary-color,
                #2563eb
            );

        background:
            rgba(
                37,
                99,
                235,
                0.04
            );

        color:
            var(
                --text-color,
                #374151
            );
    }

    .admin-image-upload__dropzone.is-dragging {
        border-color:
            var(
                --primary-color,
                #2563eb
            );

        background:
            rgba(
                37,
                99,
                235,
                0.08
            );

        color:
            var(
                --primary-color,
                #2563eb
            );

        transform: scale(1.01);
    }

    .admin-image-upload__icon {
        display: flex;

        align-items: center;
        justify-content: center;

        width: 52px;
        height: 52px;

        margin-bottom: 12px;

        border-radius: 50%;

        background:
            rgba(
                37,
                99,
                235,
                0.1
            );

        color:
            var(
                --primary-color,
                #2563eb
            );

        font-size: 24px;

        line-height: 1;
    }

    .admin-image-upload__title {
        display: block;

        margin-bottom: 6px;

        color:
            var(
                --text-color,
                #111827
            );

        font-size: 15px;

        font-weight: 700;
    }

    .admin-image-upload__hint {
        display: block;

        max-width: 500px;

        font-size: 13px;

        line-height: 1.7;
    }

    .admin-image-upload__filename {
        display: none;

        margin-top: 12px;

        padding:
            7px
            12px;

        border-radius: 999px;

        background:
            rgba(
                37,
                99,
                235,
                0.08
            );

        color:
            var(
                --primary-color,
                #2563eb
            );

        font-size: 12px;

        font-weight: 600;

        word-break: break-word;
    }

    .admin-image-upload__filename.is-visible {
        display: inline-block;
    }

    .admin-image-upload__input {
        position: absolute;

        width: 1px;
        height: 1px;

        padding: 0;
        margin: -1px;

        overflow: hidden;

        clip: rect(
            0,
            0,
            0,
            0
        );

        white-space: nowrap;

        border: 0;
    }

    .admin-image-upload__preview {
        display: none;

        width: 100%;

        margin-top: 14px;

        padding: 12px;

        border:
            1px solid
            var(--border-color, #e5e7eb);

        border-radius:
            var(
                --radius-md,
                10px
            );

        background:
            var(
                --surface,
                #ffffff
            );
    }

    .admin-image-upload__preview.is-visible {
        display: block;
    }

    .admin-image-upload__preview img {
        display: block;

        width: auto;
        max-width: 100%;
        height: auto;

        max-height: 220px;

        margin: 0 auto;

        border-radius: 8px;

        object-fit: contain;
    }

    .admin-image-upload__current {
        margin-top: 14px;

        padding-top: 14px;

        border-top:
            1px solid
            var(--border-color, #e5e7eb);
    }

    .admin-image-upload__current-preview {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        margin-top: 10px;

        padding: 8px;

        border:
            1px solid
            var(--border-color, #e5e7eb);

        border-radius: 8px;

        background:
            var(
                --surface,
                #ffffff
            );
    }

    .admin-image-upload__current-preview img {
        display: block;

        max-width: 220px;
        max-height: 140px;

        border-radius: 6px;

        object-fit: cover;
    }

    .admin-image-upload__current small {
        display: block;

        margin-top: 8px;

        color:
            var(
                --text-muted,
                #6b7280
            );

        font-size: 12px;

        line-height: 1.7;
    }
</style>


<form
    method="POST"
    action="<?= View::escape($action) ?>"
    class="admin-form"
    enctype="multipart/form-data"
>

    <?= Csrf::field() ?>


    <?php if ($errors !== []): ?>

        <div
            class="admin-alert admin-alert--error"
            role="alert"
        >

            <strong>
                فرم دارای خطا است.
            </strong>

            <ul>

                <?php foreach ($errors as $error): ?>

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


    <div class="admin-form__grid">

        <!-- =====================================================
             TITLE
        ====================================================== -->

        <div
            class="admin-form__field admin-form__field--full"
        >

            <label for="title">
                عنوان
            </label>

            <input
                id="title"
                name="title"
                type="text"
                value="<?= View::escape(
                    $item['title']
                    ?? ''
                ) ?>"
                maxlength="255"
                autofocus
            >

        </div>


        <!-- =====================================================
             URL
        ====================================================== -->

        <div
            class="admin-form__field admin-form__field--full"
        >

            <label for="url">
                لینک
            </label>

            <input
                id="url"
                name="url"
                type="text"
                value="<?= View::escape(
                    $item['url']
                    ?? ''
                ) ?>"
                maxlength="500"
                placeholder="/documents/forms یا https://example.com"
            >

        </div>


        <!-- =====================================================
             SORT ORDER
        ====================================================== -->

        <div class="admin-form__field">

            <label for="sort_order">
                ترتیب نمایش
            </label>

            <input
                id="sort_order"
                name="sort_order"
                type="number"
                min="0"
                max="999999"
                value="<?= (int) (
                    $item['sort_order']
                    ?? 0
                ) ?>"
            >

        </div>


        <!-- =====================================================
             ACTIVE
        ====================================================== -->

        <div class="admin-form__field">

            <label class="admin-checkbox">

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    <?= (int) (
                        $item['is_active']
                        ?? 1
                    ) === 1
                        ? 'checked'
                        : ''
                    ?>
                >

                <span>
                    فعال باشد
                </span>

            </label>

        </div>


        <!-- =====================================================
             IMAGE UPLOAD
        ====================================================== -->

        <div
            class="admin-form__field admin-form__field--full"
        >

            <label for="image">
                تصویر
            </label>


            <div class="admin-image-upload">

                <label
                    for="image"
                    class="admin-image-upload__dropzone"
                    id="image-dropzone"
                >

                    <span
                        class="admin-image-upload__icon"
                        aria-hidden="true"
                    >
                        ⇧
                    </span>


                    <span
                        class="admin-image-upload__title"
                    >
                        تصویر را اینجا بکشید و رها کنید
                    </span>


                    <span
                        class="admin-image-upload__hint"
                    >
                        یا برای انتخاب فایل کلیک کنید
                        <br>
                        فرمت‌های تصویری مانند JPG، PNG، WEBP و GIF
                    </span>


                    <span
                        class="admin-image-upload__filename"
                        id="image-filename"
                    ></span>

                </label>


                <input
                    type="file"
                    id="image"
                    name="image"
                    accept="image/*"
                    class="admin-image-upload__input"
                >


                <div
                    class="admin-image-upload__preview"
                    id="image-preview"
                >

                    <img
                        id="image-preview-img"
                        src=""
                        alt="پیش‌نمایش تصویر انتخاب‌شده"
                    >

                </div>


                <?php if ($image !== ''): ?>

                    <div
                        class="admin-image-upload__current"
                    >

                        <div>
                            تصویر فعلی
                        </div>


                        <div
                            class="admin-image-upload__current-preview"
                        >

                            <img
                                src="<?= View::escape(
                                    $image
                                ) ?>"
                                alt=""
                            >

                        </div>


                        <small>
                            برای حفظ تصویر فعلی، فیلد انتخاب تصویر را خالی بگذارید.
                        </small>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>


    <!-- =====================================================
         FORM ACTIONS
    ====================================================== -->

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


<script>
(function () {
    'use strict';

    const input =
        document.getElementById(
            'image'
        );

    const dropzone =
        document.getElementById(
            'image-dropzone'
        );

    const filename =
        document.getElementById(
            'image-filename'
        );

    const preview =
        document.getElementById(
            'image-preview'
        );

    const previewImage =
        document.getElementById(
            'image-preview-img'
        );


    if (
        !input ||
        !dropzone ||
        !filename ||
        !preview ||
        !previewImage
    ) {
        return;
    }


    const resetPreview = function () {

        filename.textContent = '';

        filename.classList.remove(
            'is-visible'
        );

        preview.classList.remove(
            'is-visible'
        );

        previewImage.removeAttribute(
            'src'
        );
    };


    const handleFile = function (
        file
    ) {

        if (!file) {
            resetPreview();

            return;
        }


        if (
            !file.type.startsWith(
                'image/'
            )
        ) {

            input.value = '';

            resetPreview();

            window.alert(
                'لطفاً یک فایل تصویری انتخاب کنید.'
            );

            return;
        }


        filename.textContent =
            file.name;

        filename.classList.add(
            'is-visible'
        );


        const objectUrl =
            URL.createObjectURL(
                file
            );


        previewImage.src =
            objectUrl;


        preview.classList.add(
            'is-visible'
        );


        previewImage.onload =
            function () {

                URL.revokeObjectURL(
                    objectUrl
                );

            };
    };


    input.addEventListener(
        'change',
        function () {

            const file =
                input.files &&
                input.files.length > 0
                    ? input.files[0]
                    : null;


            handleFile(
                file
            );
        }
    );


    [
        'dragenter',
        'dragover'
    ].forEach(
        function (
            eventName
        ) {

            dropzone.addEventListener(
                eventName,
                function (
                    event
                ) {

                    event.preventDefault();

                    event.stopPropagation();

                    dropzone.classList.add(
                        'is-dragging'
                    );
                }
            );
        }
    );


    [
        'dragleave',
        'dragend'
    ].forEach(
        function (
            eventName
        ) {

            dropzone.addEventListener(
                eventName,
                function (
                    event
                ) {

                    event.preventDefault();

                    event.stopPropagation();

                    dropzone.classList.remove(
                        'is-dragging'
                    );
                }
            );
        }
    );


    dropzone.addEventListener(
        'drop',
        function (
            event
        ) {

            event.preventDefault();

            event.stopPropagation();


            dropzone.classList.remove(
                'is-dragging'
            );


            const files =
                event.dataTransfer &&
                event.dataTransfer.files
                    ? event.dataTransfer.files
                    : null;


            if (
                !files ||
                files.length === 0
            ) {
                return;
            }


            const file =
                files[0];


            /*
             * Assign the dropped file to the
             * actual <input type="file"> so
             * multipart/form-data submission
             * includes it.
             */
            if (
                typeof DataTransfer !==
                'undefined'
            ) {

                try {

                    const dataTransfer =
                        new DataTransfer();

                    dataTransfer.items.add(
                        file
                    );

                    input.files =
                        dataTransfer.files;

                } catch (
                    error
                ) {

                    /*
                     * Some browsers may not allow
                     * programmatic assignment.
                     *
                     * The preview still works.
                     */
                }
            }


            handleFile(
                file
            );
        }
    );

})();
</script>
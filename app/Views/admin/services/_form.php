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
                required
                autofocus
            >

        </div>


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
                required
            >

        </div>


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


        <div
            class="admin-form__field admin-form__field--full"
        >

            <label for="image">
                تصویر
            </label>


            <div
                class="admin-service-upload"
                id="service-image-dropzone"
            >

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept="image/*"
                    class="admin-service-upload__input"
                >


                <div class="admin-service-upload__icon">
                    ⇧
                </div>


                <strong>
                    تصویر را اینجا بکشید و رها کنید
                </strong>


                <span>
                    یا برای انتخاب فایل کلیک کنید
                </span>


                <small id="service-image-filename"></small>

            </div>


            <div
                class="admin-service-upload__preview"
                id="service-image-preview"
            >

                <img
                    id="service-image-preview-image"
                    src="<?= View::escape(
                        $image
                    ) ?>"
                    alt=""
                >

            </div>


            <?php if ($image !== ''): ?>

                <small>
                    برای حفظ تصویر فعلی، فایل جدیدی انتخاب نکنید.
                </small>

            <?php endif; ?>

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
                '/admin/services'
            ) ?>"
            class="button button--secondary"
        >
            انصراف
        </a>

    </div>

</form>


<style>
.admin-service-upload {
    position: relative;

    display: flex;
    flex-direction: column;

    align-items: center;
    justify-content: center;

    width: 100%;
    min-height: 180px;

    padding: 28px;

    text-align: center;

    border:
        2px dashed
        var(--admin-border-color, #d0d5dd);

    border-radius: 10px;

    cursor: pointer;

    transition:
        border-color .2s ease,
        background-color .2s ease,
        transform .2s ease;
}

.admin-service-upload:hover,
.admin-service-upload.is-dragover {
    border-color:
        var(
            --admin-primary-color,
            #2563eb
        );

    background:
        rgba(
            37,
            99,
            235,
            .05
        );
}

.admin-service-upload.is-dragover {
    transform: scale(1.01);
}

.admin-service-upload__input {
    position: absolute;

    inset: 0;

    width: 100%;
    height: 100%;

    opacity: 0;

    cursor: pointer;
}

.admin-service-upload__icon {
    display: flex;

    align-items: center;
    justify-content: center;

    width: 50px;
    height: 50px;

    margin-bottom: 12px;

    border-radius: 50%;

    background:
        rgba(
            37,
            99,
            235,
            .1
        );

    font-size: 24px;
}

.admin-service-upload strong {
    font-size: 15px;
}

.admin-service-upload span {
    margin-top: 5px;

    color:
        var(
            --admin-muted-color,
            #667085
        );

    font-size: 13px;
}

.admin-service-upload small {
    margin-top: 10px;

    color:
        var(
            --admin-primary-color,
            #2563eb
        );

    word-break: break-word;
}

.admin-service-upload__preview {
    display:
        <?= $image !== '' ? 'block' : 'none' ?>;

    margin-top: 14px;

    text-align: center;
}

.admin-service-upload__preview img {
    display: inline-block;

    max-width: 220px;
    max-height: 140px;

    border-radius: 8px;

    object-fit: contain;
}
</style>


<script>
(function () {
    'use strict';

    const input =
        document.getElementById(
            'image'
        );

    const dropzone =
        document.getElementById(
            'service-image-dropzone'
        );

    const filename =
        document.getElementById(
            'service-image-filename'
        );

    const preview =
        document.getElementById(
            'service-image-preview'
        );

    const previewImage =
        document.getElementById(
            'service-image-preview-image'
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

    function showFile(file) {
        if (!file) {
            return;
        }

        if (
            !file.type.startsWith(
                'image/'
            )
        ) {
            input.value = '';

            window.alert(
                'لطفاً یک فایل تصویری انتخاب کنید.'
            );

            return;
        }

        filename.textContent =
            file.name;

        const objectUrl =
            URL.createObjectURL(
                file
            );

        previewImage.src =
            objectUrl;

        preview.style.display =
            'block';

        previewImage.onload =
            function () {
                URL.revokeObjectURL(
                    objectUrl
                );
            };
    }

    input.addEventListener(
        'change',
        function () {
            showFile(
                input.files &&
                input.files.length
                    ? input.files[0]
                    : null
            );
        }
    );

    [
        'dragenter',
        'dragover'
    ].forEach(
        function (eventName) {

            dropzone.addEventListener(
                eventName,
                function (event) {
                    event.preventDefault();
                    event.stopPropagation();

                    dropzone.classList.add(
                        'is-dragover'
                    );
                }
            );
        }
    );

    [
        'dragleave',
        'dragend'
    ].forEach(
        function (eventName) {

            dropzone.addEventListener(
                eventName,
                function (event) {
                    event.preventDefault();
                    event.stopPropagation();

                    dropzone.classList.remove(
                        'is-dragover'
                    );
                }
            );
        }
    );

    dropzone.addEventListener(
        'drop',
        function (event) {

            event.preventDefault();
            event.stopPropagation();

            dropzone.classList.remove(
                'is-dragover'
            );

            const files =
                event.dataTransfer
                    ? event.dataTransfer.files
                    : null;

            if (
                !files ||
                !files.length
            ) {
                return;
            }

            const file =
                files[0];

            if (
                !file.type.startsWith(
                    'image/'
                )
            ) {
                return;
            }

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
                // Preview still works.
            }

            showFile(file);
        }
    );
})();
</script>
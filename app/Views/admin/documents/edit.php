<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\Session;
use App\Core\View;

$categories =
    is_array(
        $categories ?? null
    )
        ? $categories
        : [];

$document =
    is_array(
        $document ?? null
    )
        ? $document
        : [];

$form =
    Session::getFlash(
        'document_form'
    );

$formErrors =
    Session::getFlash(
        'document_errors'
    );

if (
    is_array($form)
) {
    $document =
        array_merge(
            $document,
            $form
        );
}

$errors =
    is_array($formErrors)
        ? $formErrors
        : [];

$errorMessage =
    Session::getFlash(
        'error'
    );

$documentId =
    (int) (
        $document['id']
        ?? 0
    );
?>

<div class="admin-documents">

    <div class="admin-documents__header">

        <div class="admin-documents__header-main">

            <span class="admin-documents__eyebrow">
                اسناد و فرم‌ها
            </span>

            <h1>
                ویرایش سند
            </h1>

            <p>
                مشخصات سند را ویرایش کنید یا فایل جدید جایگزین کنید.
            </p>

        </div>

        <div class="admin-documents__header-actions">

            <a
                href="<?= View::url(
                    '/admin/documents'
                ) ?>"
                class="button button--secondary"
            >
                بازگشت
            </a>

        </div>

    </div>


    <?php if (
        is_string($errorMessage)
        && $errorMessage !== ''
    ): ?>

        <div
            class="admin-documents__alert admin-documents__alert--error"
            role="alert"
        >
            <strong>
                <?= View::escape(
                    $errorMessage
                ) ?>
            </strong>
        </div>

    <?php endif; ?>


    <?php if (
        $errors !== []
    ): ?>

        <div
            class="admin-documents__errors"
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
                            (string) $error
                        ) ?>
                    </li>

                <?php endforeach; ?>

            </ul>

        </div>

    <?php endif; ?>


    <section class="admin-documents__panel">

        <div class="admin-documents__panel-header">

            <div>

                <span>
                    ویرایش
                </span>

                <h2>
                    اطلاعات سند
                </h2>

                <p>
                    اطلاعات سند را به‌روزرسانی کنید.
                </p>

            </div>

        </div>


        <form
            method="POST"
            action="<?= View::url(
                '/admin/documents/'
                . $documentId
            ) ?>"
            enctype="multipart/form-data"
            class="admin-documents__form"
            id="document-edit-form"
        >

            <?= Csrf::field() ?>


            <div class="admin-documents__grid">


                <div class="admin-documents__field">

                    <label
                        for="category_id"
                    >
                        دسته‌بندی *
                    </label>

                    <select
                        id="category_id"
                        name="category_id"
                        required
                    >

                        <option value="">
                            انتخاب دسته‌بندی
                        </option>

                        <?php foreach (
                            $categories
                            as $category
                        ): ?>

                            <option
                                value="<?= (int) $category['id'] ?>"
                                <?= (
                                    (int) (
                                        $document['category_id']
                                        ?? 0
                                    )
                                    ===
                                    (int) $category['id']
                                )
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                <?= View::escape(
                                    $category['name']
                                ) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <div class="admin-documents__field">

                    <label
                        for="title"
                    >
                        عنوان *
                    </label>

                    <input
                        id="title"
                        name="title"
                        type="text"
                        value="<?= View::escape(
                            $document['title']
                            ?? ''
                        ) ?>"
                        maxlength="255"
                        required
                    >

                </div>


                <div class="admin-documents__field admin-documents__field--full">

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
                        $document['description']
                        ?? ''
                    ) ?></textarea>

                </div>


                <div class="admin-documents__field admin-documents__field--full">

                    <label>
                        فایل فعلی
                    </label>

                    <div class="admin-document-current-file">

                        <div
                            class="admin-document-current-file__icon"
                            aria-hidden="true"
                        >
                            📄
                        </div>


                        <div
                            class="admin-document-current-file__info"
                        >

                            <strong>
                                <?= View::escape(
                                    $document['file_name']
                                    ?? 'فایل ثبت نشده'
                                ) ?>
                            </strong>

                            <?php if (
                                !empty(
                                    $document['mime_type']
                                )
                            ): ?>

                                <span>
                                    <?= View::escape(
                                        $document['mime_type']
                                    ) ?>
                                </span>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>


                <div class="admin-documents__field admin-documents__field--full">

                    <label>
                        فایل جدید
                    </label>


                    <div class="document-upload">

                        <label
                            class="document-upload__dropzone"
                            id="document-dropzone"
                            for="document-file"
                            tabindex="0"
                        >

                            <input
                                id="document-file"
                                name="file"
                                type="file"
                                class="document-upload__input"
                                accept="
                                    application/pdf,
                                    application/msword,
                                    application/vnd.openxmlformats-officedocument.wordprocessingml.document,
                                    application/vnd.ms-excel,
                                    application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,
                                    application/vnd.ms-powerpoint,
                                    application/vnd.openxmlformats-officedocument.presentationml.presentation
                                "
                            >


                            <div
                                class="document-upload__icon"
                                aria-hidden="true"
                            >
                                ↑
                            </div>


                            <div>

                                <div class="document-upload__title">
                                    فایل جدید را اینجا رها کنید
                                </div>

                                <div class="document-upload__subtitle">
                                    یا برای انتخاب فایل کلیک کنید
                                </div>

                                <div class="document-upload__hint">
                                    خالی بگذارید تا فایل فعلی حفظ شود.
                                </div>

                            </div>


                            <span
                                class="document-upload__choose"
                            >
                                انتخاب فایل
                            </span>


                            <div
                                class="document-upload__selected"
                                id="document-selected"
                            >

                                <div
                                    class="document-upload__selected-icon"
                                    aria-hidden="true"
                                >
                                    📄
                                </div>


                                <div
                                    class="document-upload__selected-info"
                                >

                                    <strong
                                        id="document-selected-name"
                                    >
                                        -
                                    </strong>

                                    <span
                                        id="document-selected-size"
                                    >
                                        -
                                    </span>

                                </div>


                                <button
                                    type="button"
                                    class="document-upload__remove"
                                    id="document-remove"
                                    aria-label="حذف فایل انتخاب‌شده"
                                >
                                    ×
                                </button>

                            </div>

                        </label>

                    </div>


                    <small>
                        فقط در صورت انتخاب فایل جدید، فایل قبلی جایگزین خواهد شد.
                    </small>

                </div>


                <div class="admin-documents__field">

                    <label
                        for="published_at"
                    >
                        تاریخ انتشار
                    </label>

                    <input
                        id="published_at"
                        name="published_at"
                        type="text"
                        dir="ltr"
                        placeholder="1405/05/31 14:05"
                        value="<?= View::escape(
                            $document['published_at']
                            ?? ''
                        ) ?>"
                        data-jalali-datepicker
                        autocomplete="off"
                    >

                    <small>
                        تاریخ را به صورت شمسی وارد کنید.
                    </small>

                </div>


                <div class="admin-documents__field">

                    <label class="admin-documents__checkbox">

                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            <?= (
                                (int) (
                                    $document['is_active']
                                    ?? 1
                                ) === 1
                            )
                                ? 'checked'
                                : ''
                            ?>
                        >

                        <span>
                            سند فعال باشد
                        </span>

                    </label>

                </div>

            </div>


            <div class="admin-documents__actions">

                <a
                    href="<?= View::url(
                        '/admin/documents'
                    ) ?>"
                    class="button button--secondary"
                >
                    انصراف
                </a>


                <button
                    type="submit"
                    class="button button--primary"
                >
                    ذخیره تغییرات
                </button>

            </div>

        </form>

    </section>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const input =
        document.getElementById('document-file');

    const dropzone =
        document.getElementById('document-dropzone');

    const removeButton =
        document.getElementById('document-remove');

    const selectedName =
        document.getElementById('document-selected-name');

    const selectedSize =
        document.getElementById('document-selected-size');

    if (
        !input
        || !dropzone
    ) {
        return;
    }

    const formatBytes = function (bytes) {

        if (bytes < 1024) {
            return bytes + ' B';
        }

        if (bytes < 1024 * 1024) {
            return (
                (bytes / 1024).toFixed(1)
                + ' KB'
            );
        }

        if (bytes < 1024 * 1024 * 1024) {
            return (
                (bytes / (1024 * 1024)).toFixed(1)
                + ' MB'
            );
        }

        return (
            (bytes / (1024 * 1024 * 1024)).toFixed(1)
            + ' GB'
        );
    };


    const updateFile = function (file) {

        if (!file) {
            return;
        }

        selectedName.textContent =
            file.name;

        selectedSize.textContent =
            formatBytes(file.size);

        dropzone.classList.add(
            'document-upload__dropzone--has-file'
        );
    };


    input.addEventListener(
        'change',
        function () {

            const file =
                input.files[0];

            if (!file) {
                return;
            }

            updateFile(file);
        }
    );


    removeButton.addEventListener(
        'click',
        function (event) {

            event.preventDefault();
            event.stopPropagation();

            input.value = '';

            selectedName.textContent =
                '-';

            selectedSize.textContent =
                '-';

            dropzone.classList.remove(
                'document-upload__dropzone--has-file'
            );
        }
    );


    [
        'dragenter',
        'dragover'
    ].forEach(function (eventName) {

        dropzone.addEventListener(
            eventName,
            function (event) {

                event.preventDefault();
                event.stopPropagation();

                dropzone.classList.add(
                    'document-upload__dropzone--dragging'
                );
            }
        );

    });


    [
        'dragleave',
        'dragend'
    ].forEach(function (eventName) {

        dropzone.addEventListener(
            eventName,
            function (event) {

                event.preventDefault();
                event.stopPropagation();

                dropzone.classList.remove(
                    'document-upload__dropzone--dragging'
                );
            }
        );

    });


    dropzone.addEventListener(
        'drop',
        function (event) {

            event.preventDefault();
            event.stopPropagation();

            dropzone.classList.remove(
                'document-upload__dropzone--dragging'
            );

            const files =
                event.dataTransfer.files;

            if (
                !files
                || files.length === 0
            ) {
                return;
            }

            const file =
                files[0];

            const dataTransfer =
                new DataTransfer();

            dataTransfer.items.add(file);

            input.files =
                dataTransfer.files;

            updateFile(file);
        }
    );


    dropzone.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Enter'
                || event.key === ' '
            ) {

                event.preventDefault();

                input.click();
            }
        }
    );

});
</script>
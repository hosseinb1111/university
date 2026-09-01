<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\Session;
use App\Core\View;

$error =
    Session::getFlash(
        'error'
    );
?>

<div class="media-admin media-admin--create">

    <!-- =========================================================
         HEADER
    ========================================================== -->

    <header class="media-admin__header">

        <div>

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
                یک یا چند فایل را هم‌زمان انتخاب یا مستقیماً داخل کادر زیر رها کنید.
            </p>

        </div>

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
         UPLOAD PANEL
    ========================================================== -->

    <section class="media-admin__panel">

        <div class="media-admin__panel-header">

            <div>

                <span>
                    آپلود فایل
                </span>

                <h2>
                    فایل‌های رسانه‌ای
                </h2>

                <p>
                    تصاویر و فایل‌های مجاز را انتخاب کنید.
                </p>

            </div>

        </div>


        <form
            method="POST"
            action="<?= View::route(
                'admin.media.store'
            ) ?>"
            enctype="multipart/form-data"
            class="media-upload-form"
            id="media-upload-form"
        >

            <?= Csrf::field() ?>


            <!-- =================================================
                 DROPZONE
            ================================================== -->

            <div
                class="media-dropzone"
                id="media-dropzone"
                tabindex="0"
                role="button"
                aria-label="انتخاب یا رها کردن فایل‌ها"
            >

                <input
                    id="media"
                    name="media[]"
                    type="file"
                    multiple
                    hidden
                    accept="image/jpeg,image/png,image/webp,application/pdf"
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
                        یا برای انتخاب فایل کلیک کنید
                    </span>

                    <small>
                        امکان انتخاب چند فایل به‌صورت هم‌زمان وجود دارد.
                    </small>

                </div>


                <button
                    type="button"
                    class="media-dropzone__button"
                    id="media-select-button"
                >
                    انتخاب فایل‌ها
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

                <div class="media-upload-list__header">

                    <div>

                        <strong>
                            فایل‌های انتخاب‌شده
                        </strong>

                        <span id="media-file-count">
                            ۰ فایل
                        </span>

                    </div>


                    <button
                        type="button"
                        class="media-upload-list__clear"
                        id="media-clear-button"
                    >
                        حذف همه
                    </button>

                </div>


                <div
                    class="media-upload-list__items"
                    id="media-upload-items"
                ></div>


                <div class="media-upload-summary">

                    <span>
                        حجم کل
                    </span>

                    <strong id="media-total-size">
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
                    متن جایگزین
                </label>

                <input
                    id="alt_text"
                    name="alt_text"
                    type="text"
                    maxlength="255"
                    placeholder="مثلاً نمای ساختمان موسسه"
                >

                <small>
                    این متن برای همه فایل‌های انتخاب‌شده استفاده می‌شود.
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
                    id="media-submit"
                >
                    آپلود فایل‌ها
                </button>

            </div>

        </form>

    </section>

</div>


<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        const form =
            document.getElementById(
                'media-upload-form'
            );

        const input =
            document.getElementById(
                'media'
            );

        const dropzone =
            document.getElementById(
                'media-dropzone'
            );

        const selectButton =
            document.getElementById(
                'media-select-button'
            );

        const list =
            document.getElementById(
                'media-upload-list'
            );

        const itemsContainer =
            document.getElementById(
                'media-upload-items'
            );

        const clearButton =
            document.getElementById(
                'media-clear-button'
            );

        const countElement =
            document.getElementById(
                'media-file-count'
            );

        const totalSizeElement =
            document.getElementById(
                'media-total-size'
            );

        const submitButton =
            document.getElementById(
                'media-submit'
            );


        if (
            !form
            || !input
            || !dropzone
        ) {
            return;
        }


        let selectedFiles = [];


        /*
         * ---------------------------------------------------------
         * Helpers
         * ---------------------------------------------------------
         */

        const formatBytes =
            function (
                bytes
            ) {

                if (
                    bytes <= 0
                ) {
                    return '۰ بایت';
                }


                const units = [
                    'بایت',
                    'کیلوبایت',
                    'مگابایت',
                    'گیگابایت'
                ];


                let value =
                    Number(bytes);

                let unitIndex =
                    0;


                while (
                    value >= 1024
                    && unitIndex
                    < units.length - 1
                ) {

                    value /= 1024;

                    unitIndex++;
                }


                const rounded =
                    unitIndex === 0
                        ? Math.round(value)
                        : value.toFixed(1);


                return (
                    String(
                        rounded
                    )
                    + ' '
                    + units[
                        unitIndex
                    ]
                );
            };


        const toPersianDigits =
            function (
                value
            ) {

                return String(
                    value
                ).replace(
                    /\d/g,
                    function (
                        digit
                    ) {
                        return '۰۱۲۳۴۵۶۷۸۹'[
                            digit
                        ];
                    }
                );
            };


        const getFileKey =
            function (
                file
            ) {

                return [
                    file.name,
                    file.size,
                    file.lastModified
                ].join(
                    ':'
                );
            };


        /*
         * ---------------------------------------------------------
         * Render
         * ---------------------------------------------------------
         */

        const render =
            function () {

                itemsContainer.innerHTML = '';


                const totalSize =
                    selectedFiles.reduce(
                        function (
                            total,
                            file
                        ) {

                            return total
                                + file.size;

                        },
                        0
                    );


                if (
                    selectedFiles.length === 0
                ) {

                    list.hidden =
                        true;

                    countElement.textContent =
                        '۰ فایل';

                    totalSizeElement.textContent =
                        '۰ بایت';

                    submitButton.disabled =
                        true;

                    return;
                }


                list.hidden =
                    false;


                countElement.textContent =
                    toPersianDigits(
                        selectedFiles.length
                    )
                    + ' فایل';


                totalSizeElement.textContent =
                    formatBytes(
                        totalSize
                    );


                submitButton.disabled =
                    false;


                selectedFiles.forEach(
                    function (
                        file,
                        index
                    ) {

                        const item =
                            document.createElement(
                                'div'
                            );


                        item.className =
                            'media-upload-item';


                        const preview =
                            document.createElement(
                                'div'
                            );


                        preview.className =
                            'media-upload-item__preview';


                        if (
                            file.type.startsWith(
                                'image/'
                            )
                        ) {

                            const image =
                                document.createElement(
                                    'img'
                                );


                            image.alt =
                                '';


                            image.src =
                                URL.createObjectURL(
                                    file
                                );


                            preview.appendChild(
                                image
                            );

                        } else {

                            preview.textContent =
                                'PDF';

                            preview.classList.add(
                                'media-upload-item__preview--file'
                            );
                        }


                        const info =
                            document.createElement(
                                'div'
                            );


                        info.className =
                            'media-upload-item__info';


                        const name =
                            document.createElement(
                                'strong'
                            );


                        name.textContent =
                            file.name;


                        const meta =
                            document.createElement(
                                'span'
                            );


                        meta.textContent =
                            formatBytes(
                                file.size
                            );


                        info.appendChild(
                            name
                        );

                        info.appendChild(
                            meta
                        );


                        const remove =
                            document.createElement(
                                'button'
                            );


                        remove.type =
                            'button';


                        remove.className =
                            'media-upload-item__remove';


                        remove.textContent =
                            '×';


                        remove.setAttribute(
                            'aria-label',
                            'حذف فایل'
                        );


                        remove.addEventListener(
                            'click',
                            function () {

                                selectedFiles.splice(
                                    index,
                                    1
                                );

                                syncInput();

                                render();

                            }
                        );


                        item.appendChild(
                            preview
                        );

                        item.appendChild(
                            info
                        );

                        item.appendChild(
                            remove
                        );


                        itemsContainer.appendChild(
                            item
                        );
                    }
                );
            };


        /*
         * ---------------------------------------------------------
         * Sync the real file input.
         * ---------------------------------------------------------
         */

        const syncInput =
            function () {

                const dataTransfer =
                    new DataTransfer();


                selectedFiles.forEach(
                    function (
                        file
                    ) {

                        dataTransfer.items.add(
                            file
                        );

                    }
                );


                input.files =
                    dataTransfer.files;
            };


        /*
         * ---------------------------------------------------------
         * Add files.
         * ---------------------------------------------------------
         */

        const addFiles =
            function (
                files
            ) {

                Array.from(
                    files
                ).forEach(
                    function (
                        file
                    ) {

                        const key =
                            getFileKey(
                                file
                            );


                        const exists =
                            selectedFiles.some(
                                function (
                                    existing
                                ) {
                                    return (
                                        getFileKey(
                                            existing
                                        )
                                        === key
                                    );
                                }
                            );


                        if (
                            !exists
                        ) {
                            selectedFiles.push(
                                file
                            );
                        }
                    }
                );


                syncInput();

                render();
            };


        /*
         * ---------------------------------------------------------
         * Open picker.
         * ---------------------------------------------------------
         */

        selectButton.addEventListener(
            'click',
            function (
                event
            ) {

                event.stopPropagation();

                input.click();
            }
        );


        dropzone.addEventListener(
            'click',
            function (
                event
            ) {

                if (
                    event.target
                    === selectButton
                ) {
                    return;
                }

                input.click();
            }
        );


        dropzone.addEventListener(
            'keydown',
            function (
                event
            ) {

                if (
                    event.key === 'Enter'
                    || event.key === ' '
                ) {

                    event.preventDefault();

                    input.click();
                }
            }
        );


        input.addEventListener(
            'change',
            function () {

                addFiles(
                    input.files
                );

            }
        );


        /*
         * ---------------------------------------------------------
         * Drag and drop.
         * ---------------------------------------------------------
         */

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
                            'media-dropzone--dragging'
                        );
                    }
                );
            }
        );


        [
            'dragleave',
            'dragend',
            'drop'
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
                            'media-dropzone--dragging'
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

                const files =
                    event.dataTransfer
                        ? event.dataTransfer.files
                        : [];


                addFiles(
                    files
                );
            }
        );


        /*
         * ---------------------------------------------------------
         * Clear all.
         * ---------------------------------------------------------
         */

        clearButton.addEventListener(
            'click',
            function () {

                selectedFiles =
                    [];


                input.value =
                    '';


                render();
            }
        );


        /*
         * ---------------------------------------------------------
         * Prevent empty submission.
         * ---------------------------------------------------------
         */

        form.addEventListener(
            'submit',
            function (
                event
            ) {

                if (
                    selectedFiles.length === 0
                ) {

                    event.preventDefault();

                    dropzone.focus();

                    return;
                }


                submitButton.disabled =
                    true;

                submitButton.textContent =
                    'در حال آپلود...';
            }
        );


        /*
         * ---------------------------------------------------------
         * Initial state.
         * ---------------------------------------------------------
         */

        submitButton.disabled =
            true;

        render();

    }
);
</script>
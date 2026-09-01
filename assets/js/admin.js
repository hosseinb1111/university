'use strict';

document.addEventListener(
    'DOMContentLoaded',
    () => {
        const sidebar = document.getElementById(
            'admin-sidebar'
        );

        const menuToggle = document.getElementById(
            'admin-menu-toggle'
        );

        const closeButton = document.getElementById(
            'admin-sidebar-close'
        );

        if (
            sidebar === null
        ) {
            return;
        }

        const openSidebar = () => {
            sidebar.classList.add(
                'admin-sidebar--open'
            );
        };

        const closeSidebar = () => {
            sidebar.classList.remove(
                'admin-sidebar--open'
            );
        };

        menuToggle?.addEventListener(
            'click',
            openSidebar
        );

        closeButton?.addEventListener(
            'click',
            closeSidebar
        );

        document.addEventListener(
            'click',
            (event) => {
                if (
                    window.innerWidth > 900
                ) {
                    return;
                }

                const target = event.target;

                if (
                    !(target instanceof Node)
                ) {
                    return;
                }

                const clickedInsideSidebar =
                    sidebar.contains(target);

                const clickedMenuButton =
                    menuToggle?.contains(target)
                    ?? false;

                if (
                    !clickedInsideSidebar
                    && !clickedMenuButton
                ) {
                    closeSidebar();
                }
            }
        );

        window.addEventListener(
            'resize',
            () => {
                if (
                    window.innerWidth > 900
                ) {
                    closeSidebar();
                }
            }
        );
    }
);
/*
|--------------------------------------------------------------------------
| Media uploader
|--------------------------------------------------------------------------
*/

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

        const uploadList =
            document.getElementById(
                'media-upload-list'
            );

        const uploadItems =
            document.getElementById(
                'media-upload-items'
            );

        const uploadCount =
            document.getElementById(
                'media-upload-count'
            );

        const totalSize =
            document.getElementById(
                'media-upload-total-size'
            );

        const clearButton =
            document.getElementById(
                'media-upload-clear'
            );

        const submitButton =
            document.getElementById(
                'media-upload-submit'
            );


        /*
        |--------------------------------------------------------------------------
        | Stop if this is not the media upload page.
        |--------------------------------------------------------------------------
        */

        if (
            !form
            || !input
            || !dropzone
        ) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Selected files
        |--------------------------------------------------------------------------
        */

        let selectedFiles = [];


        /*
        |--------------------------------------------------------------------------
        | Utilities
        |--------------------------------------------------------------------------
        */

        const formatSize =
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


                let size =
                    bytes;


                let unitIndex =
                    0;


                while (
                    size >= 1024
                    && unitIndex < units.length - 1
                ) {

                    size =
                        size / 1024;


                    unitIndex++;

                }


                const rounded =
                    unitIndex === 0
                        ? Math.round(
                            size
                        )
                        : size.toFixed(
                            1
                        );


                return (
                    rounded
                    + ' '
                    + units[unitIndex]
                );
            };


        const formatCount =
            function (
                count
            ) {

                const digits =
                    String(
                        count
                    )
                    .replace(
                        /\d/g,
                        function (
                            digit
                        ) {
                            return (
                                '۰۱۲۳۴۵۶۷۸۹'
                                [Number(digit)]
                            );
                        }
                    );


                return (
                    digits
                    + ' فایل'
                );
            };


        const isImage =
            function (
                file
            ) {

                return (
                    file
                    && file.type
                    && file.type.startsWith(
                        'image/'
                    )
                );

            };


        /*
        |--------------------------------------------------------------------------
        | Synchronize FileList
        |--------------------------------------------------------------------------
        |
        | Important:
        |
        | The browser's file input is the source submitted
        | to PHP. We therefore rebuild it using DataTransfer
        | whenever the selected files change.
        |
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
        |--------------------------------------------------------------------------
        | Render selected files
        |--------------------------------------------------------------------------
        */

        const renderFiles =
            function () {

                uploadItems.innerHTML =
                    '';


                let bytes =
                    0;


                selectedFiles.forEach(
                    function (
                        file,
                        index
                    ) {

                        bytes +=
                            file.size;


                        const item =
                            document.createElement(
                                'div'
                            );


                        item.className =
                            'media-upload-item';


                        /*
                         * Preview
                         */

                        const preview =
                            document.createElement(
                                'div'
                            );


                        preview.className =
                            'media-upload-item__preview';


                        if (
                            isImage(
                                file
                            )
                        ) {

                            const image =
                                document.createElement(
                                    'img'
                                );


                            image.alt =
                                file.name;


                            const objectUrl =
                                URL.createObjectURL(
                                    file
                                );


                            image.src =
                                objectUrl;


                            image.addEventListener(
                                'load',
                                function () {

                                    URL.revokeObjectURL(
                                        objectUrl
                                    );

                                },
                                {
                                    once: true
                                }
                            );


                            preview.appendChild(
                                image
                            );

                        } else {

                            preview.classList.add(
                                'media-upload-item__preview--file'
                            );


                            preview.textContent =
                                'FILE';
                        }


                        /*
                         * Info
                         */

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
                            file.type
                            + ' • '
                            + formatSize(
                                file.size
                            );


                        info.appendChild(
                            name
                        );


                        info.appendChild(
                            meta
                        );


                        /*
                         * Remove button
                         */

                        const remove =
                            document.createElement(
                                'button'
                            );


                        remove.type =
                            'button';


                        remove.className =
                            'media-upload-item__remove';


                        remove.setAttribute(
                            'aria-label',
                            'حذف '
                            + file.name
                        );


                        remove.textContent =
                            '×';


                        remove.addEventListener(
                            'click',
                            function () {

                                selectedFiles.splice(
                                    index,
                                    1
                                );


                                syncInput();


                                renderFiles();

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


                        uploadItems.appendChild(
                            item
                        );

                    }
                );


                /*
                 * Empty state
                 */

                const hasFiles =
                    selectedFiles.length > 0;


                uploadList.hidden =
                    !hasFiles;


                submitButton.disabled =
                    !hasFiles;


                if (
                    hasFiles
                ) {

                    uploadCount.textContent =
                        formatCount(
                            selectedFiles.length
                        );


                    totalSize.textContent =
                        formatSize(
                            bytes
                        );

                } else {

                    uploadCount.textContent =
                        '۰ فایل';


                    totalSize.textContent =
                        '۰ بایت';

                }

            };


        /*
        |--------------------------------------------------------------------------
        | Add files
        |--------------------------------------------------------------------------
        */

        const addFiles =
            function (
                files
            ) {

                if (
                    !files
                    || files.length === 0
                ) {
                    return;
                }


                const incoming =
                    Array.from(
                        files
                    );


                incoming.forEach(
                    function (
                        file
                    ) {

                        /*
                         * Prevent duplicate files.
                         */
                        const duplicate =
                            selectedFiles.some(
                                function (
                                    existing
                                ) {

                                    return (
                                        existing.name
                                        === file.name
                                        && existing.size
                                        === file.size
                                        && existing.lastModified
                                        === file.lastModified
                                    );

                                }
                            );


                        if (
                            !duplicate
                        ) {

                            selectedFiles.push(
                                file
                            );
                        }

                    }
                );


                syncInput();


                renderFiles();

            };


        /*
        |--------------------------------------------------------------------------
        | Select button
        |--------------------------------------------------------------------------
        */

        selectButton.addEventListener(
            'click',
            function (
                event
            ) {

                event.preventDefault();

                event.stopPropagation();

                input.click();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Clicking the dropzone
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | Keyboard support
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | Normal file selection
        |--------------------------------------------------------------------------
        */

        input.addEventListener(
            'change',
            function () {

                addFiles(
                    input.files
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Drag enter
        |--------------------------------------------------------------------------
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


        /*
        |--------------------------------------------------------------------------
        | Drag leave / drop
        |--------------------------------------------------------------------------
        */

        [
            'dragleave',
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


        /*
        |--------------------------------------------------------------------------
        | Handle dropped files
        |--------------------------------------------------------------------------
        */

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
        |--------------------------------------------------------------------------
        | Clear all
        |--------------------------------------------------------------------------
        */

        clearButton.addEventListener(
            'click',
            function () {

                selectedFiles =
                    [];


                input.value =
                    '';


                renderFiles();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Submit protection
        |--------------------------------------------------------------------------
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

                    return;

                }


                submitButton.disabled =
                    true;


                submitButton.textContent =
                    'در حال آپلود...';

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Initial state
        |--------------------------------------------------------------------------
        */

        renderFiles();

    }
);
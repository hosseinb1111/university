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

<div class="admin-page">

    <div class="admin-page__header">

        <div>

            <span class="admin-page__eyebrow">
                اسناد و فرم‌ها
            </span>

            <h1>
                ویرایش سند
            </h1>

            <p>
                اطلاعات سند یا فایل آن را تغییر دهید.
            </p>

        </div>


        <a
            href="<?= View::url(
                '/admin/documents'
            ) ?>"
            class="button button--secondary"
        >
            بازگشت
        </a>

    </div>


    <?php if (
        is_string(
            $errorMessage
        )
        && $errorMessage !== ''
    ): ?>

        <div
            class="admin-alert admin-alert--error"
            role="alert"
        >
            <?= View::escape(
                $errorMessage
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


    <div class="admin-panel">

        <form
            method="POST"
            action="<?= View::url(
                '/admin/documents/'
                . $documentId
            ) ?>"
            enctype="multipart/form-data"
            class="admin-form"
        >

            <?= Csrf::field() ?>


            <div class="admin-form__grid">


                <div class="admin-form__field">

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
                                        $document[
                                            'category_id'
                                        ]
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


                <div class="admin-form__field">

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
                        $document[
                            'description'
                        ]
                        ?? ''
                    ) ?></textarea>

                </div>


                <div
                    class="
                        admin-form__field
                        admin-form__field--full
                    "
                >

                    <label>
                        فایل فعلی
                    </label>

                    <div class="admin-current-file">

                        <strong>
                            <?= View::escape(
                                $document[
                                    'file_name'
                                ]
                                ?? ''
                            ) ?>
                        </strong>

                        <?php if (
                            !empty(
                                $document[
                                    'mime_type'
                                ]
                            )
                        ): ?>

                            <span>
                                <?= View::escape(
                                    $document[
                                        'mime_type'
                                    ]
                                ) ?>
                            </span>

                        <?php endif; ?>

                    </div>

                </div>


                <div
                    class="
                        admin-form__field
                        admin-form__field--full
                    "
                >

                    <label
                        for="file"
                    >
                        فایل جدید
                    </label>

                    <input
                        id="file"
                        name="file"
                        type="file"
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

                    <small>
                        خالی بگذارید تا فایل فعلی حفظ شود.
                    </small>

                </div>


                <div class="admin-form__field">

                    <label
                        for="published_at"
                    >
                        تاریخ انتشار
                    </label>

                    <input
                        id="published_at"
                        name="published_at"
                        type="datetime-local"
                        value="<?= View::escape(
                            !empty(
                                $document[
                                    'published_at'
                                ]
                            )
                                ? date(
                                    'Y-m-d\TH:i',
                                    strtotime(
                                        $document[
                                            'published_at'
                                        ]
                                    )
                                )
                                : ''
                        ) ?>"
                    >

                </div>


                <div class="admin-form__field">

                    <label class="admin-checkbox">

                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            <?= (
                                (int) (
                                    $document[
                                        'is_active'
                                    ]
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


            <div class="admin-form__actions">

                <button
                    type="submit"
                    class="button button--primary"
                >
                    ذخیره تغییرات
                </button>


                <a
                    href="<?= View::url(
                        '/admin/documents'
                    ) ?>"
                    class="button button--secondary"
                >
                    انصراف
                </a>

            </div>

        </form>

    </div>

</div>
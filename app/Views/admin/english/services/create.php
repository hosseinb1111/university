<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


$service =
    is_array($service ?? null)
        ? $service
        : [];

$errors =
    is_array($errors ?? null)
        ? $errors
        : [];

$action =
    (string) (
        $action
        ?? View::route(
            'admin.english.services.store'
        )
    );

$submitLabel =
    (string) (
        $submitLabel
        ?? 'Create Service'
    );

?>

<div class="admin-page">

    <div class="english-admin-form">

        <header class="english-admin-form__header">

            <div>

                <a
                    href="<?= View::url(
                        '/admin/english/services'
                    ) ?>"
                    class="english-admin-form__back"
                >
                    ←
                    بازگشت به خدمات
                </a>

                <span>
                    ENGLISH HOMEPAGE
                </span>

                <h1>
                    ایجاد خدمت
                </h1>

                <p>
                    یک کارت خدمات جدید برای صفحه اصلی انگلیسی ایجاد کنید.
                </p>

            </div>

        </header>


        <?php if (
            isset(
                $errors['general']
            )
        ): ?>

            <div class="english-admin-form__error">
                <?= View::escape(
                    $errors['general']
                ) ?>
            </div>

        <?php endif; ?>


        <form
            method="POST"
            action="<?= View::escape(
                $action
            ) ?>"
            enctype="multipart/form-data"
            class="english-admin-form__form"
        >

            <?= Csrf::field() ?>


            <section class="english-admin-form__card">

                <div class="english-admin-form__card-header">

                    <span>
                        01
                    </span>

                    <div>

                        <h2>
                            اطلاعات خدمت
                        </h2>

                        <p>
                            عنوان و آدرس مقصد کارت خدمات.
                        </p>

                    </div>

                </div>


                <div class="english-admin-form__fields">


                    <div class="english-admin-form__field">

                        <label for="english-service-title">
                            عنوان
                        </label>

                        <input
                            id="english-service-title"
                            type="text"
                            name="title"
                            maxlength="255"
                            value="<?= View::escape(
                                $service['title']
                                ?? ''
                            ) ?>"
                            placeholder="مثال: Student Portal"
                        >

                        <?php if (
                            isset(
                                $errors['title']
                            )
                        ): ?>

                            <small class="english-admin-form__field-error">
                                <?= View::escape(
                                    $errors['title']
                                ) ?>
                            </small>

                        <?php endif; ?>

                    </div>


                    <div class="english-admin-form__field">

                        <label for="english-service-url">
                            آدرس
                        </label>

                        <input
                            id="english-service-url"
                            type="text"
                            name="url"
                            value="<?= View::escape(
                                $service['url']
                                ?? ''
                            ) ?>"
                            dir="ltr"
                            placeholder="/student-portal"
                        >

                        <?php if (
                            isset(
                                $errors['url']
                            )
                        ): ?>

                            <small class="english-admin-form__field-error">
                                <?= View::escape(
                                    $errors['url']
                                ) ?>
                            </small>

                        <?php endif; ?>

                    </div>

                </div>

            </section>


            <section class="english-admin-form__card">

                <div class="english-admin-form__card-header">

                    <span>
                        02
                    </span>

                    <div>

                        <h2>
                            تصویر
                        </h2>

                        <p>
                            یک تصویر برای کارت خدمات انتخاب کنید.
                        </p>

                    </div>

                </div>


                <div class="english-admin-form__fields">

                    <div class="english-admin-form__field">

                        <label for="english-service-image">
                            تصویر
                        </label>

                        <input
                            id="english-service-image"
                            type="file"
                            name="image"
                            accept="image/*"
                        >

                    </div>

                </div>

            </section>


            <section class="english-admin-form__card">

                <div class="english-admin-form__card-header">

                    <span>
                        03
                    </span>

                    <div>

                        <h2>
                            نمایش
                        </h2>

                    </div>

                </div>


                <div class="english-admin-form__fields">

                    <div class="english-admin-form__grid">


                        <div class="english-admin-form__field">

                            <label for="english-service-sort-order">
                                ترتیب نمایش
                            </label>

                            <input
                                id="english-service-sort-order"
                                type="number"
                                name="sort_order"
                                min="0"
                                step="1"
                                value="<?= (int) (
                                    $service['sort_order']
                                    ?? 0
                                ) ?>"
                            >

                        </div>


                        <label
                            class="english-admin-form__checkbox"
                            for="english-service-active"
                        >

                            <input
                                id="english-service-active"
                                type="checkbox"
                                name="is_active"
                                value="1"
                                <?= (int) (
                                    $service['is_active']
                                    ?? 1
                                ) === 1
                                    ? 'checked'
                                    : ''
                                ?>
                            >

                            <span>

                                <strong>
                                    خدمت فعال باشد
                                </strong>

                                <small>
                                    این کارت در صفحه اصلی نمایش داده خواهد شد.
                                </small>

                            </span>

                        </label>

                    </div>

                </div>

            </section>


            <div class="english-admin-form__savebar">

                <a
                    href="<?= View::url(
                        '/admin/english/services'
                    ) ?>"
                    class="english-admin-form__cancel"
                >
                    انصراف
                </a>

                <button
                    type="submit"
                    class="english-admin-form__save"
                >
                    ✓
                    <?= View::escape(
                        $submitLabel
                    ) ?>
                </button>

            </div>

        </form>

    </div>

</div>
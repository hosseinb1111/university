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
        ?? ''
    );

$submitLabel =
    (string) (
        $submitLabel
        ?? 'Save Changes'
    );

$currentImage =
    trim(
        (string) (
            $service['image']
            ?? ''
        )
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
                    ویرایش خدمت
                </h1>

                <p>
                    اطلاعات سرویس صفحه اصلی انگلیسی را ویرایش کنید.
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

                    </div>

                </div>


                <div class="english-admin-form__fields">

                    <?php if (
                        $currentImage !== ''
                    ): ?>

                        <div class="english-admin-form__current-image">

                            <span>
                                تصویر فعلی
                            </span>

                            <img
                                src="<?= View::escape(
                                    $currentImage
                                ) ?>"
                                alt=""
                            >

                        </div>

                    <?php endif; ?>


                    <div class="english-admin-form__field">

                        <label for="english-service-image">
                            تصویر جدید
                        </label>

                        <input
                            id="english-service-image"
                            type="file"
                            name="image"
                            accept="image/*"
                        >

                        <small>
                            انتخاب نکردن فایل، تصویر فعلی را حفظ می‌کند.
                        </small>

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
                                    ?? 0
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
                                    وضعیت نمایش این سرویس در سایت.
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
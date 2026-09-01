<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


$slide =
    is_array($slide ?? null)
        ? $slide
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
            $slide['image']
            ?? ''
        )
    );

$currentMobileImage =
    trim(
        (string) (
            $slide['mobile_image']
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
                        '/admin/english/slides'
                    ) ?>"
                    class="english-admin-form__back"
                >
                    ←
                    بازگشت به اسلایدها
                </a>

                <span>
                    ENGLISH HOMEPAGE
                </span>

                <h1>
                    ویرایش اسلاید
                </h1>

                <p>
                    اطلاعات این اسلاید را اصلاح و ذخیره کنید.
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
                            محتوای اسلاید
                        </h2>

                    </div>

                </div>


                <div class="english-admin-form__fields">

                    <div class="english-admin-form__field">

                        <label for="english-slide-title">
                            عنوان
                        </label>

                        <input
                            id="english-slide-title"
                            type="text"
                            name="title"
                            maxlength="255"
                            value="<?= View::escape(
                                $slide['title']
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

                        <label for="english-slide-subtitle">
                            زیرعنوان
                        </label>

                        <input
                            id="english-slide-subtitle"
                            type="text"
                            name="subtitle"
                            maxlength="255"
                            value="<?= View::escape(
                                $slide['subtitle']
                                ?? ''
                            ) ?>"
                        >

                    </div>


                    <div class="english-admin-form__field">

                        <label for="english-slide-description">
                            توضیحات
                        </label>

                        <textarea
                            id="english-slide-description"
                            name="description"
                            rows="6"
                            maxlength="5000"
                        ><?= View::escape(
                            $slide['description']
                            ?? ''
                        ) ?></textarea>

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
                            دکمه
                        </h2>

                    </div>

                </div>


                <div class="english-admin-form__fields">

                    <div class="english-admin-form__grid">

                        <div class="english-admin-form__field">

                            <label for="english-slide-button-text">
                                متن دکمه
                            </label>

                            <input
                                id="english-slide-button-text"
                                type="text"
                                name="button_text"
                                maxlength="255"
                                value="<?= View::escape(
                                    $slide['button_text']
                                    ?? ''
                                ) ?>"
                            >

                        </div>


                        <div class="english-admin-form__field">

                            <label for="english-slide-button-url">
                                آدرس دکمه
                            </label>

                            <input
                                id="english-slide-button-url"
                                type="text"
                                name="button_url"
                                value="<?= View::escape(
                                    $slide['button_url']
                                    ?? ''
                                ) ?>"
                                dir="ltr"
                            >

                            <?php if (
                                isset(
                                    $errors['button_url']
                                )
                            ): ?>

                                <small class="english-admin-form__field-error">
                                    <?= View::escape(
                                        $errors['button_url']
                                    ) ?>
                                </small>

                            <?php endif; ?>

                        </div>

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
                            تصاویر
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

                        <label for="english-slide-image">
                            تصویر اصلی جدید
                        </label>

                        <input
                            id="english-slide-image"
                            type="file"
                            name="image"
                            accept="image/*"
                        >

                        <small>
                            در صورت انتخاب، تصویر فعلی جایگزین می‌شود.
                        </small>

                    </div>


                    <?php if (
                        $currentMobileImage !== ''
                    ): ?>

                        <div class="english-admin-form__current-image">

                            <span>
                                تصویر موبایل فعلی
                            </span>

                            <img
                                src="<?= View::escape(
                                    $currentMobileImage
                                ) ?>"
                                alt=""
                            >

                        </div>

                    <?php endif; ?>


                    <div class="english-admin-form__field">

                        <label for="english-slide-mobile-image">
                            تصویر موبایل جدید
                        </label>

                        <input
                            id="english-slide-mobile-image"
                            type="file"
                            name="mobile_image"
                            accept="image/*"
                        >

                        <small>
                            اختیاری؛ انتخاب نکردن فایل، تصویر فعلی را حفظ می‌کند.
                        </small>

                    </div>

                </div>

            </section>


            <section class="english-admin-form__card">

                <div class="english-admin-form__card-header">

                    <span>
                        04
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

                            <label for="english-slide-sort-order">
                                ترتیب نمایش
                            </label>

                            <input
                                id="english-slide-sort-order"
                                type="number"
                                name="sort_order"
                                min="0"
                                step="1"
                                value="<?= (int) (
                                    $slide['sort_order']
                                    ?? 0
                                ) ?>"
                            >

                        </div>


                        <label
                            class="english-admin-form__checkbox"
                            for="english-slide-active"
                        >

                            <input
                                id="english-slide-active"
                                type="checkbox"
                                name="is_active"
                                value="1"
                                <?= (int) (
                                    $slide['is_active']
                                    ?? 0
                                ) === 1
                                    ? 'checked'
                                    : ''
                                ?>
                            >

                            <span>

                                <strong>
                                    اسلاید فعال باشد
                                </strong>

                                <small>
                                    این اسلاید در صفحه اصلی قابل نمایش خواهد بود.
                                </small>

                            </span>

                        </label>

                    </div>

                </div>

            </section>


            <div class="english-admin-form__savebar">

                <a
                    href="<?= View::url(
                        '/admin/english/slides'
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
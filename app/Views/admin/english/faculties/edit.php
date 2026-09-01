<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


$faculty =
    is_array($faculty ?? null)
        ? $faculty
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
        ?? 'ذخیره تغییرات'
    );

$image =
    trim(
        (string) (
            $faculty['image']
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
                        '/admin/english/faculties'
                    ) ?>"
                    class="english-admin-form__back"
                >
                    ←
                    بازگشت به دانشکده‌ها
                </a>


                <span>
                    ENGLISH FACULTIES
                </span>


                <h1>
                    ویرایش دانشکده
                </h1>


                <p>
                    اطلاعات این دانشکده را اصلاح و ذخیره کنید.
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
                            اطلاعات اصلی
                        </h2>

                        <p>
                            نام، شناسه و توضیحات دانشکده.
                        </p>

                    </div>

                </div>


                <div class="english-admin-form__fields">

                    <div class="english-admin-form__grid">


                        <div class="english-admin-form__field">

                            <label for="english-faculty-name">
                                نام دانشکده
                            </label>

                            <input
                                id="english-faculty-name"
                                type="text"
                                name="name"
                                maxlength="255"
                                value="<?= View::escape(
                                    $faculty['name']
                                    ?? ''
                                ) ?>"
                            >


                            <?php if (
                                isset(
                                    $errors['name']
                                )
                            ): ?>

                                <small class="english-admin-form__field-error">

                                    <?= View::escape(
                                        $errors['name']
                                    ) ?>

                                </small>

                            <?php endif; ?>

                        </div>


                        <div class="english-admin-form__field">

                            <label for="english-faculty-short-name">
                                نام کوتاه
                            </label>

                            <input
                                id="english-faculty-short-name"
                                type="text"
                                name="short_name"
                                maxlength="255"
                                value="<?= View::escape(
                                    $faculty['short_name']
                                    ?? ''
                                ) ?>"
                            >

                        </div>


                        <div class="english-admin-form__field">

                            <label for="english-faculty-slug">
                                Slug
                            </label>

                            <input
                                id="english-faculty-slug"
                                type="text"
                                name="slug"
                                maxlength="255"
                                value="<?= View::escape(
                                    $faculty['slug']
                                    ?? ''
                                ) ?>"
                                dir="ltr"
                            >


                            <?php if (
                                isset(
                                    $errors['slug']
                                )
                            ): ?>

                                <small class="english-admin-form__field-error">

                                    <?= View::escape(
                                        $errors['slug']
                                    ) ?>

                                </small>

                            <?php endif; ?>

                        </div>

                    </div>


                    <div class="english-admin-form__field">

                        <label for="english-faculty-description">
                            توضیحات
                        </label>

                        <textarea
                            id="english-faculty-description"
                            name="description"
                            rows="7"
                        ><?= View::escape(
                            $faculty['description']
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
                            اطلاعات تماس
                        </h2>

                        <p>
                            اطلاعات ارتباطی این دانشکده.
                        </p>

                    </div>

                </div>


                <div class="english-admin-form__fields">

                    <div class="english-admin-form__grid">


                        <div class="english-admin-form__field">

                            <label for="english-faculty-email">
                                ایمیل
                            </label>

                            <input
                                id="english-faculty-email"
                                type="email"
                                name="email"
                                maxlength="255"
                                value="<?= View::escape(
                                    $faculty['email']
                                    ?? ''
                                ) ?>"
                                dir="ltr"
                            >

                        </div>


                        <div class="english-admin-form__field">

                            <label for="english-faculty-phone">
                                تلفن
                            </label>

                            <input
                                id="english-faculty-phone"
                                type="text"
                                name="phone"
                                maxlength="255"
                                value="<?= View::escape(
                                    $faculty['phone']
                                    ?? ''
                                ) ?>"
                                dir="ltr"
                            >

                        </div>


                        <div class="english-admin-form__field">

                            <label for="english-faculty-fax">
                                فکس
                            </label>

                            <input
                                id="english-faculty-fax"
                                type="text"
                                name="fax"
                                maxlength="255"
                                value="<?= View::escape(
                                    $faculty['fax']
                                    ?? ''
                                ) ?>"
                                dir="ltr"
                            >

                        </div>


                        <div class="english-admin-form__field">

                            <label for="english-faculty-address">
                                آدرس
                            </label>

                            <input
                                id="english-faculty-address"
                                type="text"
                                name="address"
                                maxlength="1000"
                                value="<?= View::escape(
                                    $faculty['address']
                                    ?? ''
                                ) ?>"
                            >

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
                            تصویر
                        </h2>

                        <p>
                            تصویر دانشکده را مدیریت کنید.
                        </p>

                    </div>

                </div>


                <div class="english-admin-form__fields">


                    <?php if (
                        $image !== ''
                    ): ?>

                        <div class="english-admin-form__current-image">

                            <span>
                                تصویر فعلی
                            </span>


                            <img
                                src="<?= View::escape(
                                    $image
                                ) ?>"
                                alt=""
                            >

                        </div>

                    <?php endif; ?>


                    <div class="english-admin-form__field">

                        <label for="english-faculty-image">
                            آدرس تصویر
                        </label>

                        <input
                            id="english-faculty-image"
                            type="text"
                            name="image"
                            value="<?= View::escape(
                                $faculty['image']
                                ?? ''
                            ) ?>"
                            placeholder="/uploads/faculties/engineering.jpg"
                            dir="ltr"
                        >

                        <small>
                            مسیر یا URL تصویر دانشکده را وارد کنید.
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

                        <p>
                            ترتیب و وضعیت نمایش دانشکده را مشخص کنید.
                        </p>

                    </div>

                </div>


                <div class="english-admin-form__fields">

                    <div class="english-admin-form__grid">


                        <div class="english-admin-form__field">

                            <label for="english-faculty-sort-order">
                                ترتیب نمایش
                            </label>

                            <input
                                id="english-faculty-sort-order"
                                type="number"
                                name="sort_order"
                                min="0"
                                step="1"
                                value="<?= (int) (
                                    $faculty['sort_order']
                                    ?? 0
                                ) ?>"
                            >

                        </div>


                        <label
                            class="english-admin-form__checkbox"
                            for="english-faculty-active"
                        >

                            <input
                                id="english-faculty-active"
                                type="checkbox"
                                name="is_active"
                                value="1"
                                <?= (int) (
                                    $faculty['is_active']
                                    ?? 0
                                ) === 1
                                    ? 'checked'
                                    : ''
                                ?>
                            >


                            <span>

                                <strong>
                                    دانشکده فعال باشد
                                </strong>

                                <small>
                                    در صورت فعال بودن، دانشکده در نسخه انگلیسی سایت نمایش داده می‌شود.
                                </small>

                            </span>

                        </label>

                    </div>

                </div>

            </section>


            <div class="english-admin-form__savebar">

                <a
                    href="<?= View::url(
                        '/admin/english/faculties'
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
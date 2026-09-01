<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


$researchCenter =
    is_array($researchCenter ?? null)
        ? $researchCenter
        : [];

$people =
    is_array($people ?? null)
        ? $people
        : [];

$errors =
    is_array($errors ?? null)
        ? $errors
        : [];


$action =
    View::route(
        'admin.english.research-centers.store'
    );

?>

<div class="admin-page">

    <div class="english-admin-form">


        <!-- =========================================================
             HEADER
        ========================================================== -->

        <header class="english-admin-form__header">

            <div>

                <a
                    href="<?= View::url(
                        '/admin/english/research-centers'
                    ) ?>"
                    class="english-admin-form__back"
                >
                    ←
                    بازگشت به مراکز پژوهشی
                </a>


                <span>
                    ENGLISH WEBSITE
                </span>


                <h1>
                    ایجاد مرکز پژوهشی انگلیسی
                </h1>


                <p>
                    اطلاعات یک مرکز پژوهشی جدید برای نسخه انگلیسی
                    سایت وارد کنید.
                </p>

            </div>

        </header>


        <!-- =========================================================
             GENERAL ERROR
        ========================================================== -->

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


        <!-- =========================================================
             FORM
        ========================================================== -->

        <form
            method="POST"
            action="<?= View::escape(
                $action
            ) ?>"
            class="english-admin-form__form"
        >

            <?= Csrf::field() ?>


            <!-- =====================================================
                 BASIC INFORMATION
            ====================================================== -->

            <section class="english-admin-form__card">

                <div class="english-admin-form__card-header">

                    <span>
                        01
                    </span>

                    <div>

                        <h2>
                            اطلاعات مرکز
                        </h2>

                        <p>
                            نام، نام کوتاه و آدرس صفحه مرکز پژوهشی.
                        </p>

                    </div>

                </div>


                <div class="english-admin-form__fields">


                    <div class="english-admin-form__field">

                        <label for="english-research-name">
                            نام مرکز پژوهشی
                        </label>

                        <input
                            id="english-research-name"
                            type="text"
                            name="name"
                            maxlength="255"
                            value="<?= View::escape(
                                $researchCenter['name']
                                ?? ''
                            ) ?>"
                            placeholder="Center for ..."
                        >

                        <?php if (
                            isset(
                                $errors['name']
                            )
                        ): ?>

                            <small
                                class="english-admin-form__field-error"
                            >
                                <?= View::escape(
                                    $errors['name']
                                ) ?>
                            </small>

                        <?php endif; ?>

                    </div>


                    <div class="english-admin-form__grid">


                        <div class="english-admin-form__field">

                            <label for="english-research-short-name">
                                نام کوتاه
                            </label>

                            <input
                                id="english-research-short-name"
                                type="text"
                                name="short_name"
                                maxlength="255"
                                value="<?= View::escape(
                                    $researchCenter['short_name']
                                    ?? ''
                                ) ?>"
                                placeholder="Research Center"
                            >

                        </div>


                        <div class="english-admin-form__field">

                            <label for="english-research-slug">
                                اسلاگ
                            </label>

                            <input
                                id="english-research-slug"
                                type="text"
                                name="slug"
                                maxlength="255"
                                value="<?= View::escape(
                                    $researchCenter['slug']
                                    ?? ''
                                ) ?>"
                                placeholder="research-center"
                                dir="ltr"
                            >

                            <small>
                                در صورت خالی بودن، اسلاگ بر اساس نام مرکز ساخته می‌شود.
                            </small>


                            <?php if (
                                isset(
                                    $errors['slug']
                                )
                            ): ?>

                                <small
                                    class="english-admin-form__field-error"
                                >
                                    <?= View::escape(
                                        $errors['slug']
                                    ) ?>
                                </small>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 DESCRIPTION
            ====================================================== -->

            <section class="english-admin-form__card">

                <div class="english-admin-form__card-header">

                    <span>
                        02
                    </span>

                    <div>

                        <h2>
                            معرفی
                        </h2>

                        <p>
                            توضیحات مربوط به فعالیت و حوزه پژوهشی مرکز.
                        </p>

                    </div>

                </div>


                <div class="english-admin-form__fields">

                    <div class="english-admin-form__field">

                        <label for="english-research-description">
                            توضیحات
                        </label>

                        <textarea
                            id="english-research-description"
                            name="description"
                            rows="8"
                            maxlength="5000"
                            placeholder="Describe the research center..."
                        ><?= View::escape(
                            $researchCenter['description']
                            ?? ''
                        ) ?></textarea>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 DIRECTOR
            ====================================================== -->

            <section class="english-admin-form__card">

                <div class="english-admin-form__card-header">

                    <span>
                        03
                    </span>

                    <div>

                        <h2>
                            مدیر مرکز
                        </h2>

                        <p>
                            در صورت وجود، مدیر مرکز پژوهشی را انتخاب کنید.
                        </p>

                    </div>

                </div>


                <div class="english-admin-form__fields">


                    <div class="english-admin-form__field">

                        <label for="english-research-director">
                            مدیر
                        </label>

                        <select
                            id="english-research-director"
                            name="director_person_id"
                        >

                            <option value="">
                                انتخاب مدیر
                            </option>


                            <?php foreach (
                                $people as $person
                            ): ?>

                                <?php

                                if (
                                    !is_array($person)
                                ) {
                                    continue;
                                }

                                $personId =
                                    (int) (
                                        $person['id']
                                        ?? 0
                                    );

                                $firstName =
                                    trim(
                                        (string) (
                                            $person['first_name']
                                            ?? ''
                                        )
                                    );

                                $lastName =
                                    trim(
                                        (string) (
                                            $person['last_name']
                                            ?? ''
                                        )
                                    );

                                $personName =
                                    trim(
                                        $firstName
                                        . ' '
                                        . $lastName
                                    );

                                if (
                                    $personId <= 0
                                    || $personName === ''
                                ) {
                                    continue;
                                }

                                ?>

                                <option
                                    value="<?= $personId ?>"
                                    <?= (string) (
                                        $researchCenter['director_person_id']
                                        ?? ''
                                    ) === (string) $personId
                                        ? 'selected'
                                        : ''
                                    ?>
                                >
                                    <?= View::escape(
                                        $personName
                                    ) ?>
                                </option>

                            <?php endforeach; ?>

                        </select>


                        <?php if (
                            isset(
                                $errors['director_person_id']
                            )
                        ): ?>

                            <small
                                class="english-admin-form__field-error"
                            >
                                <?= View::escape(
                                    $errors['director_person_id']
                                ) ?>
                            </small>

                        <?php endif; ?>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 CONTACT
            ====================================================== -->

            <section class="english-admin-form__card">

                <div class="english-admin-form__card-header">

                    <span>
                        04
                    </span>

                    <div>

                        <h2>
                            اطلاعات تماس
                        </h2>

                        <p>
                            راه‌های ارتباط با مرکز پژوهشی.
                        </p>

                    </div>

                </div>


                <div class="english-admin-form__fields">


                    <div class="english-admin-form__grid">


                        <div class="english-admin-form__field">

                            <label for="english-research-email">
                                ایمیل
                            </label>

                            <input
                                id="english-research-email"
                                type="email"
                                name="email"
                                maxlength="255"
                                value="<?= View::escape(
                                    $researchCenter['email']
                                    ?? ''
                                ) ?>"
                                placeholder="research@example.com"
                                dir="ltr"
                            >

                        </div>


                        <div class="english-admin-form__field">

                            <label for="english-research-phone">
                                تلفن
                            </label>

                            <input
                                id="english-research-phone"
                                type="text"
                                name="phone"
                                maxlength="100"
                                value="<?= View::escape(
                                    $researchCenter['phone']
                                    ?? ''
                                ) ?>"
                                placeholder="+98 ..."
                                dir="ltr"
                            >

                        </div>

                    </div>


                    <div class="english-admin-form__field">

                        <label for="english-research-address">
                            آدرس
                        </label>

                        <textarea
                            id="english-research-address"
                            name="address"
                            rows="4"
                            maxlength="1000"
                            placeholder="Tehran, Iran..."
                        ><?= View::escape(
                            $researchCenter['address']
                            ?? ''
                        ) ?></textarea>

                    </div>


                    <div class="english-admin-form__field">

                        <label for="english-research-website">
                            وب‌سایت
                        </label>

                        <input
                            id="english-research-website"
                            type="url"
                            name="website"
                            value="<?= View::escape(
                                $researchCenter['website']
                                ?? ''
                            ) ?>"
                            placeholder="https://example.com"
                            dir="ltr"
                        >

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 IMAGE
            ====================================================== -->

            <section class="english-admin-form__card">

                <div class="english-admin-form__card-header">

                    <span>
                        05
                    </span>

                    <div>

                        <h2>
                            تصویر
                        </h2>

                        <p>
                            آدرس تصویر مرکز پژوهشی را وارد کنید.
                        </p>

                    </div>

                </div>


                <div class="english-admin-form__fields">

                    <div class="english-admin-form__field">

                        <label for="english-research-image">
                            آدرس تصویر
                        </label>

                        <input
                            id="english-research-image"
                            type="text"
                            name="image"
                            value="<?= View::escape(
                                $researchCenter['image']
                                ?? ''
                            ) ?>"
                            placeholder="/media/research/example.jpg"
                            dir="ltr"
                        >

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 DISPLAY
            ====================================================== -->

            <section class="english-admin-form__card">

                <div class="english-admin-form__card-header">

                    <span>
                        06
                    </span>

                    <div>

                        <h2>
                            نمایش
                        </h2>

                        <p>
                            ترتیب و وضعیت نمایش مرکز پژوهشی را مشخص کنید.
                        </p>

                    </div>

                </div>


                <div class="english-admin-form__fields">

                    <div class="english-admin-form__grid">


                        <div class="english-admin-form__field">

                            <label for="english-research-sort-order">
                                ترتیب نمایش
                            </label>

                            <input
                                id="english-research-sort-order"
                                type="number"
                                name="sort_order"
                                min="0"
                                step="1"
                                value="<?= (int) (
                                    $researchCenter['sort_order']
                                    ?? 0
                                ) ?>"
                            >

                        </div>


                        <label
                            class="english-admin-form__checkbox"
                            for="english-research-active"
                        >

                            <input
                                id="english-research-active"
                                type="checkbox"
                                name="is_active"
                                value="1"
                                <?= (int) (
                                    $researchCenter['is_active']
                                    ?? 1
                                ) === 1
                                    ? 'checked'
                                    : ''
                                ?>
                            >

                            <span>

                                <strong>
                                    مرکز فعال باشد
                                </strong>

                                <small>
                                    در صورت فعال بودن، این مرکز در نسخه انگلیسی سایت نمایش داده می‌شود.
                                </small>

                            </span>

                        </label>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 SAVE
            ====================================================== -->

            <div class="english-admin-form__savebar">

                <a
                    href="<?= View::url(
                        '/admin/english/research-centers'
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
                    ایجاد مرکز پژوهشی
                </button>

            </div>

        </form>

    </div>

</div>
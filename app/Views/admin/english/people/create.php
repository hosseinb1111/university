<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


$person =
    is_array($person ?? null)
        ? $person
        : [];

$faculties =
    is_array($faculties ?? null)
        ? $faculties
        : [];

$errors =
    is_array($errors ?? null)
        ? $errors
        : [];


$action =
    View::route(
        'admin.english.people.store'
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
                        '/admin/english/people'
                    ) ?>"
                    class="english-admin-form__back"
                >
                    ←
                    بازگشت به افراد انگلیسی
                </a>


                <span>
                    ENGLISH WEBSITE
                </span>


                <h1>
                    ایجاد فرد انگلیسی
                </h1>


                <p>
                    اطلاعات عضو هیئت علمی، مدیر یا فرد موردنظر
                    را برای نسخه انگلیسی سایت وارد کنید.
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
                 IDENTITY
            ====================================================== -->

            <section class="english-admin-form__card">

                <div class="english-admin-form__card-header">

                    <span>
                        01
                    </span>

                    <div>

                        <h2>
                            اطلاعات فرد
                        </h2>

                        <p>
                            نام و سمت فرد در نسخه انگلیسی سایت.
                        </p>

                    </div>

                </div>


                <div class="english-admin-form__fields">


                    <div class="english-admin-form__grid">


                        <div class="english-admin-form__field">

                            <label for="english-person-first-name">
                                نام
                            </label>

                            <input
                                id="english-person-first-name"
                                type="text"
                                name="first_name"
                                maxlength="100"
                                value="<?= View::escape(
                                    $firstName
                                ) ?>"
                                placeholder="John"
                            >

                            <?php if (
                                isset(
                                    $errors['first_name']
                                )
                            ): ?>

                                <small
                                    class="english-admin-form__field-error"
                                >
                                    <?= View::escape(
                                        $errors['first_name']
                                    ) ?>
                                </small>

                            <?php endif; ?>

                        </div>


                        <div class="english-admin-form__field">

                            <label for="english-person-last-name">
                                نام خانوادگی
                            </label>

                            <input
                                id="english-person-last-name"
                                type="text"
                                name="last_name"
                                maxlength="100"
                                value="<?= View::escape(
                                    $lastName
                                ) ?>"
                                placeholder="Smith"
                            >

                            <?php if (
                                isset(
                                    $errors['last_name']
                                )
                            ): ?>

                                <small
                                    class="english-admin-form__field-error"
                                >
                                    <?= View::escape(
                                        $errors['last_name']
                                    ) ?>
                                </small>

                            <?php endif; ?>

                        </div>

                    </div>


                    <div class="english-admin-form__field">

                        <label for="english-person-position">
                            سمت
                        </label>

                        <input
                            id="english-person-position"
                            type="text"
                            name="position"
                            maxlength="255"
                            value="<?= View::escape(
                                $person['position']
                                ?? ''
                            ) ?>"
                            placeholder="Professor / Dean / Faculty Member"
                        >

                    </div>


                    <div class="english-admin-form__field">

                        <label for="english-person-faculty">
                            دانشکده
                        </label>

                        <select
                            id="english-person-faculty"
                            name="faculty_id"
                        >

                            <option value="">
                                انتخاب دانشکده
                            </option>


                            <?php foreach (
                                $faculties as $faculty
                            ): ?>

                                <?php

                                if (
                                    !is_array($faculty)
                                ) {
                                    continue;
                                }

                                $facultyId =
                                    (int) (
                                        $faculty['id']
                                        ?? 0
                                    );

                                $facultyName =
                                    trim(
                                        (string) (
                                            $faculty['name']
                                            ?? ''
                                        )
                                    );

                                if (
                                    $facultyId <= 0
                                    || $facultyName === ''
                                ) {
                                    continue;
                                }

                                ?>

                                <option
                                    value="<?= $facultyId ?>"
                                    <?= (string) (
                                        $person['faculty_id']
                                        ?? ''
                                    ) === (string) $facultyId
                                        ? 'selected'
                                        : ''
                                    ?>
                                >
                                    <?= View::escape(
                                        $facultyName
                                    ) ?>
                                </option>

                            <?php endforeach; ?>

                        </select>


                        <?php if (
                            isset(
                                $errors['faculty_id']
                            )
                        ): ?>

                            <small
                                class="english-admin-form__field-error"
                            >
                                <?= View::escape(
                                    $errors['faculty_id']
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
                        02
                    </span>

                    <div>

                        <h2>
                            اطلاعات تماس
                        </h2>

                        <p>
                            راه‌های ارتباطی این فرد را وارد کنید.
                        </p>

                    </div>

                </div>


                <div class="english-admin-form__fields">


                    <div class="english-admin-form__grid">


                        <div class="english-admin-form__field">

                            <label for="english-person-email">
                                ایمیل
                            </label>

                            <input
                                id="english-person-email"
                                type="email"
                                name="email"
                                maxlength="255"
                                value="<?= View::escape(
                                    $person['email']
                                    ?? ''
                                ) ?>"
                                placeholder="name@example.com"
                                dir="ltr"
                            >

                            <?php if (
                                isset(
                                    $errors['email']
                                )
                            ): ?>

                                <small
                                    class="english-admin-form__field-error"
                                >
                                    <?= View::escape(
                                        $errors['email']
                                    ) ?>
                                </small>

                            <?php endif; ?>

                        </div>


                        <div class="english-admin-form__field">

                            <label for="english-person-phone">
                                تلفن
                            </label>

                            <input
                                id="english-person-phone"
                                type="text"
                                name="phone"
                                maxlength="100"
                                value="<?= View::escape(
                                    $person['phone']
                                    ?? ''
                                ) ?>"
                                placeholder="+98 ..."
                                dir="ltr"
                            >

                        </div>

                    </div>


                    <div class="english-admin-form__grid">


                        <div class="english-admin-form__field">

                            <label for="english-person-fax">
                                فکس
                            </label>

                            <input
                                id="english-person-fax"
                                type="text"
                                name="fax"
                                maxlength="100"
                                value="<?= View::escape(
                                    $person['fax']
                                    ?? ''
                                ) ?>"
                                dir="ltr"
                            >

                        </div>


                        <div class="english-admin-form__field">

                            <label for="english-person-office">
                                محل دفتر
                            </label>

                            <input
                                id="english-person-office"
                                type="text"
                                name="office_location"
                                maxlength="255"
                                value="<?= View::escape(
                                    $person['office_location']
                                    ?? ''
                                ) ?>"
                                placeholder="Faculty Building, Room 204"
                            >

                        </div>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 IMAGE
            ====================================================== -->

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
                            آدرس تصویر این فرد را وارد کنید.
                        </p>

                    </div>

                </div>


                <div class="english-admin-form__fields">

                    <div class="english-admin-form__field">

                        <label for="english-person-image">
                            آدرس تصویر
                        </label>

                        <input
                            id="english-person-image"
                            type="text"
                            name="image"
                            value="<?= View::escape(
                                $person['image']
                                ?? ''
                            ) ?>"
                            placeholder="/media/people/example.jpg"
                            dir="ltr"
                        >

                        <small>
                            این کنترلر در حال حاضر آدرس تصویر را
                            از طریق فیلد متنی ذخیره می‌کند.
                        </small>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 BIOGRAPHY
            ====================================================== -->

            <section class="english-admin-form__card">

                <div class="english-admin-form__card-header">

                    <span>
                        04
                    </span>

                    <div>

                        <h2>
                            معرفی
                        </h2>

                        <p>
                            توضیحات و سوابق فرد را وارد کنید.
                        </p>

                    </div>

                </div>


                <div class="english-admin-form__fields">

                    <div class="english-admin-form__field">

                        <label for="english-person-biography">
                            بیوگرافی
                        </label>

                        <textarea
                            id="english-person-biography"
                            name="biography"
                            rows="8"
                            maxlength="5000"
                            placeholder="Short professional biography..."
                        ><?= View::escape(
                            $person['biography']
                            ?? ''
                        ) ?></textarea>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 DISPLAY
            ====================================================== -->

            <section class="english-admin-form__card">

                <div class="english-admin-form__card-header">

                    <span>
                        05
                    </span>

                    <div>

                        <h2>
                            نمایش
                        </h2>

                        <p>
                            ترتیب و وضعیت نمایش فرد را مشخص کنید.
                        </p>

                    </div>

                </div>


                <div class="english-admin-form__fields">


                    <div class="english-admin-form__grid">


                        <div class="english-admin-form__field">

                            <label for="english-person-sort-order">
                                ترتیب نمایش
                            </label>

                            <input
                                id="english-person-sort-order"
                                type="number"
                                name="sort_order"
                                min="0"
                                step="1"
                                value="<?= (int) (
                                    $person['sort_order']
                                    ?? 0
                                ) ?>"
                            >

                        </div>


                        <label
                            class="english-admin-form__checkbox"
                            for="english-person-active"
                        >

                            <input
                                id="english-person-active"
                                type="checkbox"
                                name="is_active"
                                value="1"
                                <?= (int) (
                                    $person['is_active']
                                    ?? 1
                                ) === 1
                                    ? 'checked'
                                    : ''
                                ?>
                            >

                            <span>

                                <strong>
                                    فرد فعال باشد
                                </strong>

                                <small>
                                    در صورت فعال بودن، فرد در نسخه انگلیسی سایت قابل نمایش خواهد بود.
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
                        '/admin/english/people'
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
                    ایجاد فرد
                </button>

            </div>

        </form>

    </div>

</div>
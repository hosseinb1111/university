<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\Session;
use App\Core\View;

$form =
    Session::getFlash(
        'teacher_profile_form'
    );

$profileErrors =
    Session::getFlash(
        'teacher_profile_errors'
    );

$passwordErrors =
    Session::getFlash(
        'teacher_password_errors'
    );

if (
    is_array($form)
    && is_array($person ?? null)
) {
    $person =
        array_merge(
            $person,
            $form
        );
}

$displayName =
    trim(
        (string) (
            $user['first_name']
            ?? ''
        )
        . ' '
        . (string) (
            $user['last_name']
            ?? ''
        )
    );

if (
    $displayName === ''
) {
    $displayName =
        (string) (
            $user['username']
            ?? 'کاربر'
        );
}
?>

<section class="teacher-page">

    <div class="teacher-page__header">

        <div>

            <span class="teacher-page__eyebrow">
                پروفایل
            </span>

            <h1>
                اطلاعات من
            </h1>

            <p>
                اطلاعات عمومی پروفایل دانشگاهی خود را مدیریت کنید.
            </p>

        </div>

    </div>


    <?php if (
        is_string($success ?? null)
        && $success !== ''
    ): ?>

        <div
            class="teacher-alert teacher-alert--success"
            role="status"
        >

            <?= View::escape(
                $success
            ) ?>

        </div>

    <?php endif; ?>


    <?php if (
        is_array($profileErrors)
        && $profileErrors !== []
    ): ?>

        <div
            class="form-errors"
            role="alert"
        >

            <ul>

                <?php foreach (
                    $profileErrors
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


    <?php if (
        is_array($passwordErrors)
        && $passwordErrors !== []
    ): ?>

        <div
            class="form-errors"
            role="alert"
        >

            <ul>

                <?php foreach (
                    $passwordErrors
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


    <?php if (
        !is_array($person ?? null)
    ): ?>

        <div class="teacher-card">

            <h2>
                پروفایل دانشگاهی ایجاد نشده است
            </h2>

            <p>
                این حساب هنوز به یک رکورد اعضای هیئت علمی یا کارکنان
                متصل نشده است. لطفاً مدیر سیستم ابتدا پروفایل دانشگاهی
                شما را ایجاد کند.
            </p>

        </div>

    <?php else: ?>

        <div class="teacher-panel-grid">


            <section class="teacher-card">

                <h2>
                    اطلاعات عمومی
                </h2>


                <form
                    method="POST"
                    action="<?= View::route(
                        'teacher.profile.update'
                    ) ?>"
                    class="auth-form"
                >

                    <?= Csrf::field() ?>


                    <div class="form-field">

                        <label
                            for="first_name"
                            class="form-field__label"
                        >
                            نام
                        </label>

                        <input
                            id="first_name"
                            name="first_name"
                            type="text"
                            class="form-field__input"
                            value="<?= View::escape(
                                (string) (
                                    $person['first_name']
                                    ?? ''
                                )
                            ) ?>"
                            autocomplete="given-name"
                            maxlength="100"
                            required
                        >

                    </div>


                    <div class="form-field">

                        <label
                            for="last_name"
                            class="form-field__label"
                        >
                            نام خانوادگی
                        </label>

                        <input
                            id="last_name"
                            name="last_name"
                            type="text"
                            class="form-field__input"
                            value="<?= View::escape(
                                (string) (
                                    $person['last_name']
                                    ?? ''
                                )
                            ) ?>"
                            autocomplete="family-name"
                            maxlength="100"
                            required
                        >

                    </div>


                    <div class="form-field">

                        <label
                            for="email"
                            class="form-field__label"
                        >
                            ایمیل
                        </label>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            class="form-field__input"
                            value="<?= View::escape(
                                (string) (
                                    $person['email']
                                    ?? ''
                                )
                            ) ?>"
                            autocomplete="email"
                            maxlength="255"
                        >

                    </div>


                    <div class="form-field">

                        <label
                            for="phone"
                            class="form-field__label"
                        >
                            تلفن
                        </label>

                        <input
                            id="phone"
                            name="phone"
                            type="text"
                            class="form-field__input"
                            value="<?= View::escape(
                                (string) (
                                    $person['phone']
                                    ?? ''
                                )
                            ) ?>"
                            autocomplete="tel"
                            maxlength="100"
                        >

                    </div>


                    <div class="form-field">

                        <label
                            for="office_location"
                            class="form-field__label"
                        >
                            محل دفتر
                        </label>

                        <input
                            id="office_location"
                            name="office_location"
                            type="text"
                            class="form-field__input"
                            value="<?= View::escape(
                                (string) (
                                    $person['office_location']
                                    ?? ''
                                )
                            ) ?>"
                            maxlength="255"
                        >

                    </div>


                    <div class="form-field">

                        <label
                            for="biography"
                            class="form-field__label"
                        >
                            معرفی / زندگی‌نامه
                        </label>

                        <textarea
                            id="biography"
                            name="biography"
                            class="form-field__input"
                            rows="10"
                        ><?= View::escape(
                            (string) (
                                $person['biography']
                                ?? ''
                            )
                        ) ?></textarea>

                    </div>


                    <button
                        type="submit"
                        class="button button--primary"
                    >
                        ذخیره اطلاعات
                    </button>

                </form>

            </section>


            <section class="teacher-card">

                <h2>
                    تغییر رمز عبور
                </h2>


                <p>
                    برای افزایش امنیت حساب خود، رمز عبور را به‌صورت دوره‌ای
                    تغییر دهید.
                </p>


                <form
                    method="POST"
                    action="<?= View::route(
                        'teacher.password.update'
                    ) ?>"
                    class="auth-form"
                >

                    <?= Csrf::field() ?>


                    <div class="form-field">

                        <label
                            for="current_password"
                            class="form-field__label"
                        >
                            رمز عبور فعلی
                        </label>

                        <input
                            id="current_password"
                            name="current_password"
                            type="password"
                            class="form-field__input"
                            autocomplete="current-password"
                            required
                        >

                    </div>


                    <div class="form-field">

                        <label
                            for="new_password"
                            class="form-field__label"
                        >
                            رمز عبور جدید
                        </label>

                        <input
                            id="new_password"
                            name="new_password"
                            type="password"
                            class="form-field__input"
                            autocomplete="new-password"
                            required
                        >

                    </div>


                    <div class="form-field">

                        <label
                            for="new_password_confirmation"
                            class="form-field__label"
                        >
                            تکرار رمز عبور جدید
                        </label>

                        <input
                            id="new_password_confirmation"
                            name="new_password_confirmation"
                            type="password"
                            class="form-field__input"
                            autocomplete="new-password"
                            required
                        >

                    </div>


                    <button
                        type="submit"
                        class="button button--primary"
                    >
                        تغییر رمز عبور
                    </button>

                </form>

            </section>

        </div>

    <?php endif; ?>

</section>
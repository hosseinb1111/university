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
    $profileErrors
    ?? Session::getFlash(
        'teacher_profile_errors'
    );

$passwordErrors =
    $passwordErrors
    ?? Session::getFlash(
        'teacher_password_errors'
    );

$person =
    is_array($person ?? null)
        ? $person
        : null;

$faculties =
    is_array($faculties ?? null)
        ? $faculties
        : [];

if (
    is_array($form)
    && $person !== null
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

$profileUrl =
    $person !== null
        ? View::url(
            '/people/'
            . (int) $person['id']
        )
        : null;

$currentFacultyId =
    $person !== null
        ? (int) (
            $person['faculty_id']
            ?? 0
        )
        : 0;
?>

<section class="teacher-page">

    <div class="teacher-page__header">

        <div>

            <span class="teacher-page__eyebrow">
                پروفایل اعضای هیئت علمی
            </span>

            <h1>
                اطلاعات من
            </h1>

            <p>
                اطلاعاتی که اینجا ویرایش می‌کنید مستقیماً
                در پروفایل عمومی شما در وب‌سایت نمایش داده می‌شود.
            </p>

        </div>

        <?php if (
            $profileUrl !== null
        ): ?>

            <a
                href="<?= View::escape(
                    $profileUrl
                ) ?>"
                class="button button--secondary"
                target="_blank"
                rel="noopener noreferrer"
            >
                مشاهده پروفایل عمومی
            </a>

        <?php endif; ?>

    </div>


    <?php if (
        is_string($success ?? null)
        && trim($success) !== ''
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
            class="teacher-alert teacher-alert--error"
            role="alert"
        >

            <strong>
                اطلاعات پروفایل ذخیره نشد.
            </strong>

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
            class="teacher-alert teacher-alert--error"
            role="alert"
        >

            <strong>
                تغییر رمز عبور انجام نشد.
            </strong>

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
        $person === null
    ): ?>

        <section class="teacher-card">

            <div class="teacher-card__icon">
                !
            </div>

            <h2>
                پروفایل دانشگاهی قابل ایجاد نیست
            </h2>

            <p>
                سامانه نتوانست پروفایل دانشگاهی حساب شما را ایجاد یا پیدا کند.
                لطفاً مدیر سیستم را مطلع کنید.
            </p>

        </section>

    <?php else: ?>

        <div class="teacher-panel-grid">


            <!-- =====================================================
                 PUBLIC PROFILE INFORMATION
            ====================================================== -->

            <section class="teacher-card">

                <div class="teacher-card__header">

                    <div>

                        <span class="teacher-card__eyebrow">
                            پروفایل عمومی
                        </span>

                        <h2>
                            اطلاعات قابل ویرایش
                        </h2>

                    </div>

                </div>


                <div class="teacher-card__notice">

                    <strong>
                        این اطلاعات در سایت نمایش داده می‌شود.
                    </strong>

                    <span>
                        نام، دانشکده، ایمیل، تلفن، محل دفتر و معرفی شما
                        در پروفایل عمومی اعضای هیئت علمی استفاده می‌شوند.
                    </span>

                </div>


                <form
                    method="POST"
                    action="<?= View::route(
                        'teacher.profile.update'
                    ) ?>"
                    class="auth-form"
                >

                    <?= Csrf::field() ?>


                    <div class="teacher-form-grid">


                        <!-- =================================================
                             FIRST NAME
                        ================================================== -->

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

                            <small>
                                نامی که در پروفایل عمومی شما نمایش داده می‌شود.
                            </small>

                        </div>


                        <!-- =================================================
                             LAST NAME
                        ================================================== -->

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


                        <!-- =================================================
                             FACULTY
                        ================================================== -->

                        <div
                            class="
                                form-field
                                teacher-form-field--full
                            "
                        >

                            <label
                                for="faculty_id"
                                class="form-field__label"
                            >
                                دانشکده
                            </label>

                            <select
                                id="faculty_id"
                                name="faculty_id"
                                class="form-field__input"
                            >

                                <option value="">
                                    دانشکده ثبت نشده
                                </option>

                                <?php foreach (
                                    $faculties
                                    as $faculty
                                ): ?>

                                    <?php
                                    $facultyId =
                                        (int) (
                                            $faculty['id']
                                            ?? 0
                                        );

                                    if (
                                        $facultyId <= 0
                                    ) {
                                        continue;
                                    }
                                    ?>

                                    <option
                                        value="<?= $facultyId ?>"
                                        <?= $facultyId === $currentFacultyId
                                            ? 'selected'
                                            : ''
                                        ?>
                                    >
                                        <?= View::escape(
                                            (string) (
                                                $faculty['name']
                                                ?? 'دانشکده'
                                            )
                                        ) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                            <small>
                                دانشکده‌ای را انتخاب کنید که در پروفایل عمومی شما نمایش داده شود.
                                در صورت انتخاب «دانشکده ثبت نشده»، هیچ دانشکده‌ای برای پروفایل شما ثبت نمی‌شود.
                            </small>

                        </div>


                        <!-- =================================================
                             EMAIL
                        ================================================== -->

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

                            <small>
                                ایمیل عمومی و ایمیل حساب کاربری با هم هماهنگ می‌شوند.
                            </small>

                        </div>


                        <!-- =================================================
                             PHONE
                        ================================================== -->

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


                        <!-- =================================================
                             OFFICE
                        ================================================== -->

                        <div
                            class="
                                form-field
                                teacher-form-field--full
                            "
                        >

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
                                placeholder="مثلاً ساختمان آموزشی، طبقه دوم، اتاق ۱۲"
                            >

                        </div>


                        <!-- =================================================
                             BIOGRAPHY
                        ================================================== -->

                        <div
                            class="
                                form-field
                                teacher-form-field--full
                            "
                        >

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
                                maxlength="10000"
                                placeholder="معرفی کوتاه، زمینه تخصص، سوابق علمی و اطلاعاتی که می‌خواهید در پروفایل عمومی نمایش داده شود."
                            ><?= View::escape(
                                (string) (
                                    $person['biography']
                                    ?? ''
                                )
                            ) ?></textarea>

                            <small>
                                این متن مستقیماً در صفحه عمومی شما نمایش داده می‌شود.
                            </small>

                        </div>


                    </div>


                    <div class="teacher-form__actions">

                        <button
                            type="submit"
                            class="button button--primary"
                        >
                            ذخیره اطلاعات
                        </button>


                        <?php if (
                            $profileUrl !== null
                        ): ?>

                            <a
                                href="<?= View::escape(
                                    $profileUrl
                                ) ?>"
                                class="button button--secondary"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                مشاهده نتیجه
                            </a>

                        <?php endif; ?>

                    </div>

                </form>

            </section>


            <!-- =====================================================
                 ADMIN CONTROLLED INFORMATION
            ====================================================== -->

            <section class="teacher-card">

                <div class="teacher-card__header">

                    <div>

                        <span class="teacher-card__eyebrow">
                            اطلاعات دانشگاهی
                        </span>

                        <h2>
                            اطلاعات تحت مدیریت
                        </h2>

                    </div>

                </div>


                <p>
                    این بخش فقط برای مشاهده است.
                    موارد زیر توسط مدیر سیستم مدیریت می‌شوند و
                    مدرس نمی‌تواند مستقیماً آن‌ها را تغییر دهد.
                </p>


                <div class="teacher-readonly-list">

                    <div class="teacher-readonly-item">

                        <span>
                            سمت
                        </span>

                        <strong>
                            <?= View::escape(
                                (string) (
                                    $person['position']
                                    ?? 'ثبت نشده'
                                )
                            ) ?>
                        </strong>

                    </div>


                    <div class="teacher-readonly-item">

                        <span>
                            دانشکده
                        </span>

                        <strong>
                            <?= View::escape(
                                (string) (
                                    $person['faculty_name']
                                    ?? 'ثبت نشده'
                                )
                            ) ?>
                        </strong>

                    </div>


                    <div class="teacher-readonly-item">

                        <span>
                            وضعیت پروفایل
                        </span>

                        <strong>

                            <?php if (
                                (int) (
                                    $person['is_active']
                                    ?? 0
                                ) === 1
                            ): ?>

                                فعال

                            <?php else: ?>

                                غیرفعال

                            <?php endif; ?>

                        </strong>

                    </div>

                </div>


                <div class="teacher-card__notice teacher-card__notice--muted">

                    <strong>
                        نیاز به تغییر این موارد دارید؟
                    </strong>

                    <span>
                        برای تغییر سمت، تصویر، وضعیت نمایش
                        یا سایر اطلاعات مدیریتی با مدیر سیستم تماس بگیرید.
                        دانشکده را می‌توانید از بخش «اطلاعات قابل ویرایش» انتخاب کنید.
                    </span>

                </div>

            </section>


            <!-- =====================================================
                 PASSWORD
            ====================================================== -->

            <section class="teacher-card">

                <div class="teacher-card__header">

                    <div>

                        <span class="teacher-card__eyebrow">
                            امنیت
                        </span>

                        <h2>
                            تغییر رمز عبور
                        </h2>

                    </div>

                </div>


                <p>
                    برای حفظ امنیت حساب، رمز عبور خود را فقط از طریق این بخش تغییر دهید.
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

                        <small>
                            حداقل
                            <?= (int) config(
                                'app.security.minimum_password_length',
                                8
                            ) ?>
                            کاراکتر.
                        </small>

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
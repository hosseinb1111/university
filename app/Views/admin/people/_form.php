<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\Session;
use App\Core\View;


/*
|--------------------------------------------------------------------------
| Normalize data
|--------------------------------------------------------------------------
*/

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
    is_string($action ?? null)
        ? $action
        : '';


$submitLabel =
    is_string($submitLabel ?? null)
        ? $submitLabel
        : 'ذخیره';


$presidentId =
    isset($presidentId)
    && $presidentId !== null
        ? (int) $presidentId
        : 0;


/*
|--------------------------------------------------------------------------
| Restore president checkbox after failed submission
|--------------------------------------------------------------------------
|
| PeopleController flashes this value separately because
| "is_president" is not a column in the people table.
|
*/

$flashedPresident =
    Session::getFlash(
        'person_is_president'
    );


/*
|--------------------------------------------------------------------------
| Determine current president state
|--------------------------------------------------------------------------
*/

$isPresident =
    (
        $presidentId > 0
        && (int) (
            $person['id']
            ?? 0
        ) === $presidentId
    );


/*
|--------------------------------------------------------------------------
| Failed form submission overrides the normal state
|--------------------------------------------------------------------------
*/

if (
    $flashedPresident !== null
) {
    $isPresident =
        (bool) $flashedPresident;
}


/*
|--------------------------------------------------------------------------
| Form
|--------------------------------------------------------------------------
*/

?>

<form
    method="POST"
    action="<?= View::escape(
        $action
    ) ?>"
    class="people-admin-form"
>

    <?= Csrf::field() ?>


    <?php if (
        $errors !== []
    ): ?>

        <div
            class="people-admin-form__errors"
            role="alert"
        >

            <div
                class="people-admin-form__errors-icon"
                aria-hidden="true"
            >
                !
            </div>

            <div>

                <strong>
                    لطفاً موارد زیر را اصلاح کنید.
                </strong>

                <ul>

                    <?php foreach (
                        $errors
                        as $message
                    ): ?>

                        <li>
                            <?= View::escape(
                                (string) $message
                            ) ?>
                        </li>

                    <?php endforeach; ?>

                </ul>

            </div>

        </div>

    <?php endif; ?>


    <div class="people-admin-form__grid">


        <!-- =========================================================
             FIRST NAME
        ========================================================== -->

        <div class="people-admin-form__field">

            <label
                for="first_name"
            >
                نام
                <span>*</span>
            </label>

            <input
                id="first_name"
                name="first_name"
                type="text"
                value="<?= View::escape(
                    $person['first_name']
                    ?? ''
                ) ?>"
                required
                maxlength="100"
                autocomplete="given-name"
                placeholder="نام"
            >

        </div>


        <!-- =========================================================
             LAST NAME
        ========================================================== -->

        <div class="people-admin-form__field">

            <label
                for="last_name"
            >
                نام خانوادگی
                <span>*</span>
            </label>

            <input
                id="last_name"
                name="last_name"
                type="text"
                value="<?= View::escape(
                    $person['last_name']
                    ?? ''
                ) ?>"
                required
                maxlength="100"
                autocomplete="family-name"
                placeholder="نام خانوادگی"
            >

        </div>


        <!-- =========================================================
             POSITION
        ========================================================== -->

        <div class="people-admin-form__field">

            <label
                for="position"
            >
                سمت
            </label>

            <input
                id="position"
                name="position"
                type="text"
                value="<?= View::escape(
                    $person['position']
                    ?? ''
                ) ?>"
                maxlength="255"
                placeholder="مثلاً استاد، رئیس دانشکده، عضو هیئت علمی..."
            >

            <small>
                سمت یا عنوان رسمی این شخص را وارد کنید.
            </small>

        </div>


        <!-- =========================================================
             FACULTY
        ========================================================== -->

        <div class="people-admin-form__field">

            <label
                for="faculty_id"
            >
                دانشکده
            </label>

            <select
                id="faculty_id"
                name="faculty_id"
            >

                <option value="">
                    بدون دانشکده
                </option>

                <?php foreach (
                    $faculties
                    as $faculty
                ): ?>

                    <?php

                    $facultyId =
                        (string) (
                            $faculty['id']
                            ?? ''
                        );


                    $selectedFaculty =
                        (string) (
                            $person['faculty_id']
                            ?? ''
                        );

                    ?>

                    <option
                        value="<?= View::escape(
                            $facultyId
                        ) ?>"
                        <?= $facultyId === $selectedFaculty
                            ? 'selected'
                            : ''
                        ?>
                    >
                        <?= View::escape(
                            $faculty['name']
                            ?? 'دانشکده'
                        ) ?>
                    </option>

                <?php endforeach; ?>

            </select>

            <small>
                دانشکده‌ای را انتخاب کنید که این شخص به آن وابسته است.
            </small>

        </div>


        <!-- =========================================================
             EMAIL
        ========================================================== -->

        <div class="people-admin-form__field">

            <label
                for="email"
            >
                ایمیل
            </label>

            <input
                id="email"
                name="email"
                type="email"
                value="<?= View::escape(
                    $person['email']
                    ?? ''
                ) ?>"
                dir="ltr"
                maxlength="255"
                autocomplete="email"
                placeholder="example@sadra.ac.ir"
            >

        </div>


        <!-- =========================================================
             PHONE
        ========================================================== -->

        <div class="people-admin-form__field">

            <label
                for="phone"
            >
                تلفن
            </label>

            <input
                id="phone"
                name="phone"
                type="text"
                value="<?= View::escape(
                    $person['phone']
                    ?? ''
                ) ?>"
                dir="ltr"
                maxlength="100"
                autocomplete="tel"
                placeholder="021..."
            >

        </div>


        <!-- =========================================================
             FAX
        ========================================================== -->

        <div class="people-admin-form__field">

            <label
                for="fax"
            >
                فکس
            </label>

            <input
                id="fax"
                name="fax"
                type="text"
                value="<?= View::escape(
                    $person['fax']
                    ?? ''
                ) ?>"
                dir="ltr"
                maxlength="100"
                placeholder="021..."
            >

        </div>


        <!-- =========================================================
             OFFICE
        ========================================================== -->

        <div class="people-admin-form__field">

            <label
                for="office_location"
            >
                محل دفتر
            </label>

            <input
                id="office_location"
                name="office_location"
                type="text"
                value="<?= View::escape(
                    $person['office_location']
                    ?? ''
                ) ?>"
                maxlength="255"
                placeholder="مثلاً ساختمان اداری، طبقه دوم، اتاق ۲۰۳"
            >

            <small>
                محل دفتر این شخص در پروفایل عمومی او نمایش داده می‌شود.
            </small>

        </div>


        <!-- =========================================================
             USER ACCOUNT
        ========================================================== -->

        <div class="people-admin-form__field">

            <label
                for="user_id"
            >
                حساب کاربری
            </label>

            <input
                id="user_id"
                name="user_id"
                type="number"
                value="<?= View::escape(
                    $person['user_id']
                    ?? ''
                ) ?>"
                min="1"
                placeholder="شناسه حساب کاربری"
            >

            <small>
                در صورت اتصال حساب کاربری، صاحب این پروفایل می‌تواند
                از پنل اعضای هیئت علمی اطلاعات شخصی خود را ویرایش کند.
            </small>

        </div>


        <!-- =========================================================
             IMAGE
        ========================================================== -->

        <div
            class="
                people-admin-form__field
                people-admin-form__field--full
            "
        >

            <label
                for="image"
            >
                تصویر
            </label>

            <input
                id="image"
                name="image"
                type="text"
                value="<?= View::escape(
                    $person['image']
                    ?? ''
                ) ?>"
                dir="ltr"
                maxlength="500"
                placeholder="/media/people/example.jpg"
            >

            <small>
                مسیر تصویر شخص را وارد کنید. این تصویر در صفحه عمومی
                اعضای هیئت علمی و صفحه اختصاصی او نمایش داده می‌شود.
            </small>

        </div>


        <!-- =========================================================
             BIOGRAPHY
        ========================================================== -->

        <div
            class="
                people-admin-form__field
                people-admin-form__field--full
            "
        >

            <label
                for="biography"
            >
                زندگی‌نامه / معرفی
            </label>

            <textarea
                id="biography"
                name="biography"
                rows="11"
                maxlength="10000"
                placeholder="سوابق تحصیلی، سمت‌ها، تخصص‌ها، فعالیت‌های علمی و معرفی شخص..."
            ><?= View::escape(
                $person['biography']
                ?? ''
            ) ?></textarea>

            <small>
                این متن در صفحه عمومی پروفایل شخص نمایش داده می‌شود.
            </small>

        </div>


        <!-- =========================================================
             SORT ORDER
        ========================================================== -->

        <div class="people-admin-form__field">

            <label
                for="sort_order"
            >
                ترتیب نمایش
            </label>

            <input
                id="sort_order"
                name="sort_order"
                type="number"
                min="0"
                max="100000"
                value="<?= View::escape(
                    $person['sort_order']
                    ?? 0
                ) ?>"
            >

            <small>
                عدد کمتر یعنی نمایش بالاتر در فهرست اعضای هیئت علمی.
            </small>

        </div>


        <!-- =========================================================
             ACTIVE
        ========================================================== -->

        <div class="people-admin-form__field">

            <label>
                وضعیت
            </label>

            <label
                class="people-admin-form__switch"
                for="is_active"
            >

                <input
                    id="is_active"
                    type="checkbox"
                    name="is_active"
                    value="1"
                    <?= (
                        (int) (
                            $person['is_active']
                            ?? 1
                        ) === 1
                    )
                        ? 'checked'
                        : ''
                    ?>
                >

                <span
                    class="people-admin-form__switch-track"
                    aria-hidden="true"
                >
                    <span></span>
                </span>

                <span class="people-admin-form__switch-text">

                    <strong>
                        شخص فعال باشد
                    </strong>

                    <small>
                        اعضای فعال در بخش عمومی سایت نمایش داده می‌شوند.
                    </small>

                </span>

            </label>

        </div>


        <!-- =========================================================
             PRESIDENT
        ========================================================== -->

        <div
            class="
                people-admin-form__field
                people-admin-form__field--full
            "
        >

            <label>
                جایگاه ویژه
            </label>

            <label
                class="
                    people-admin-form__special-option
                "
                for="is_president"
            >

                <input
                    id="is_president"
                    name="is_president"
                    type="checkbox"
                    value="1"
                    <?= $isPresident
                        ? 'checked'
                        : ''
                    ?>
                >

                <span
                    class="
                        people-admin-form__special-option-check
                    "
                    aria-hidden="true"
                >
                    ✓
                </span>

                <span
                    class="
                        people-admin-form__special-option-content
                    "
                >

                    <strong>
                        این شخص رئیس موسسه است
                    </strong>

                    <small>
                        با فعال کردن این گزینه، اطلاعات این شخص در صفحه
                        «ریاست موسسه» نمایش داده می‌شود.
                        با انتخاب شخص دیگری، رئیس قبلی جایگزین خواهد شد.
                    </small>

                </span>

            </label>

        </div>

    </div>


    <!-- =========================================================
         FORM ACTIONS
    ========================================================== -->

    <div class="people-admin-form__actions">

        <a
            href="<?= View::route(
                'admin.people.index'
            ) ?>"
            class="
                people-admin-form__button
                people-admin-form__button--secondary
            "
        >
            انصراف
        </a>


        <button
            type="submit"
            class="
                people-admin-form__button
                people-admin-form__button--primary
            "
        >
            <?= View::escape(
                $submitLabel
            ) ?>
        </button>

    </div>

</form>
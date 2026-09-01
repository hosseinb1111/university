<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


$program =
    is_array($program ?? null)
        ? $program
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
    (string) (
        $action
        ?? View::route(
            'admin.english.programs.update',
            [
                'id' =>
                    (int) (
                        $program['id']
                        ?? 0
                    ),
            ]
        )
    );


$submitLabel =
    (string) (
        $submitLabel
        ?? 'ذخیره تغییرات'
    );


$currentSlug =
    trim(
        (string) (
            $program['slug']
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
                        '/admin/english/programs'
                    ) ?>"
                    class="english-admin-form__back"
                >
                    ←
                    بازگشت به رشته‌ها
                </a>


                <span>
                    ENGLISH ACADEMICS
                </span>


                <h1>
                    ویرایش رشته انگلیسی
                </h1>


                <p>
                    اطلاعات این برنامه آموزشی را اصلاح و ذخیره کنید.
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
                            اطلاعات اصلی
                        </h2>

                        <p>
                            عنوان، دانشکده و شناسه آدرس برنامه.
                        </p>

                    </div>

                </div>


                <div class="english-admin-form__fields">


                    <!-- FACULTY -->

                    <div class="english-admin-form__field">

                        <label
                            for="english-program-faculty"
                        >
                            دانشکده
                        </label>


                        <select
                            id="english-program-faculty"
                            name="faculty_id"
                        >

                            <option
                                value="0"
                                <?= (int) (
                                    $program['faculty_id']
                                    ?? 0
                                ) <= 0
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                انتخاب دانشکده
                            </option>


                            <?php foreach (
                                $faculties
                                as $faculty
                            ): ?>

                                <?php

                                if (
                                    !is_array(
                                        $faculty
                                    )
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
                                    <?= (int) (
                                        $program['faculty_id']
                                        ?? 0
                                    ) === $facultyId
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


                    <!-- NAME -->

                    <div class="english-admin-form__field">

                        <label
                            for="english-program-name"
                        >
                            نام رشته
                        </label>


                        <input
                            id="english-program-name"
                            type="text"
                            name="name"
                            maxlength="255"
                            value="<?= View::escape(
                                $program['name']
                                ?? ''
                            ) ?>"
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


                    <!-- SLUG -->

                    <div class="english-admin-form__field">

                        <label
                            for="english-program-slug"
                        >
                            شناسه آدرس (Slug)
                        </label>


                        <input
                            id="english-program-slug"
                            type="text"
                            name="slug"
                            value="<?= View::escape(
                                $program['slug']
                                ?? ''
                            ) ?>"
                            dir="ltr"
                        >


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

                        <?php else: ?>

                            <small>
                                در صورت ویرایش، تغییر Slug باعث تغییر
                                آدرس عمومی این برنامه می‌شود.
                            </small>

                        <?php endif; ?>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 ACADEMIC DETAILS
            ====================================================== -->

            <section class="english-admin-form__card">

                <div class="english-admin-form__card-header">

                    <span>
                        02
                    </span>

                    <div>

                        <h2>
                            مشخصات آموزشی
                        </h2>

                        <p>
                            مشخصات پایه برنامه آموزشی.
                        </p>

                    </div>

                </div>


                <div class="english-admin-form__fields">

                    <div class="english-admin-form__grid">


                        <!-- DEGREE -->

                        <div class="english-admin-form__field">

                            <label
                                for="english-program-degree"
                            >
                                مقطع / مدرک
                            </label>


                            <input
                                id="english-program-degree"
                                type="text"
                                name="degree"
                                maxlength="255"
                                value="<?= View::escape(
                                    $program['degree']
                                    ?? ''
                                ) ?>"
                            >

                        </div>


                        <!-- FIELD -->

                        <div class="english-admin-form__field">

                            <label
                                for="english-program-field"
                            >
                                حوزه تحصیلی
                            </label>


                            <input
                                id="english-program-field"
                                type="text"
                                name="field"
                                maxlength="255"
                                value="<?= View::escape(
                                    $program['field']
                                    ?? ''
                                ) ?>"
                            >

                        </div>


                        <!-- DURATION -->

                        <div class="english-admin-form__field">

                            <label
                                for="english-program-duration"
                            >
                                مدت تحصیل
                            </label>


                            <input
                                id="english-program-duration"
                                type="text"
                                name="duration"
                                maxlength="255"
                                value="<?= View::escape(
                                    $program['duration']
                                    ?? ''
                                ) ?>"
                            >

                        </div>


                        <!-- SORT -->

                        <div class="english-admin-form__field">

                            <label
                                for="english-program-sort-order"
                            >
                                ترتیب نمایش
                            </label>


                            <input
                                id="english-program-sort-order"
                                type="number"
                                name="sort_order"
                                min="0"
                                step="1"
                                value="<?= (int) (
                                    $program['sort_order']
                                    ?? 0
                                ) ?>"
                            >

                        </div>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 CONTENT
            ====================================================== -->

            <section class="english-admin-form__card">

                <div class="english-admin-form__card-header">

                    <span>
                        03
                    </span>

                    <div>

                        <h2>
                            محتوای رشته
                        </h2>

                        <p>
                            توضیحات، پذیرش و ساختار دروس.
                        </p>

                    </div>

                </div>


                <div class="english-admin-form__fields">


                    <!-- DESCRIPTION -->

                    <div class="english-admin-form__field">

                        <label
                            for="english-program-description"
                        >
                            توضیحات
                        </label>


                        <textarea
                            id="english-program-description"
                            name="description"
                            rows="7"
                            maxlength="5000"
                        ><?= View::escape(
                            $program['description']
                            ?? ''
                        ) ?></textarea>

                    </div>


                    <!-- ADMISSION -->

                    <div class="english-admin-form__field">

                        <label
                            for="english-program-admission"
                        >
                            اطلاعات پذیرش
                        </label>


                        <textarea
                            id="english-program-admission"
                            name="admission_info"
                            rows="6"
                            maxlength="5000"
                        ><?= View::escape(
                            $program['admission_info']
                            ?? ''
                        ) ?></textarea>

                    </div>


                    <!-- CURRICULUM -->

                    <div class="english-admin-form__field">

                        <label
                            for="english-program-curriculum"
                        >
                            سرفصل / ساختار دروس
                        </label>


                        <textarea
                            id="english-program-curriculum"
                            name="curriculum"
                            rows="7"
                            maxlength="5000"
                        ><?= View::escape(
                            $program['curriculum']
                            ?? ''
                        ) ?></textarea>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 STATUS
            ====================================================== -->

            <section class="english-admin-form__card">

                <div class="english-admin-form__card-header">

                    <span>
                        04
                    </span>

                    <div>

                        <h2>
                            وضعیت نمایش
                        </h2>

                        <p>
                            وضعیت فعال بودن برنامه در سایت انگلیسی.
                        </p>

                    </div>

                </div>


                <div class="english-admin-form__fields">

                    <label
                        class="english-admin-form__checkbox"
                        for="english-program-active"
                    >

                        <input
                            id="english-program-active"
                            type="checkbox"
                            name="is_active"
                            value="1"
                            <?= (int) (
                                $program['is_active']
                                ?? 0
                            ) === 1
                                ? 'checked'
                                : ''
                            ?>
                        >


                        <span>

                            <strong>
                                رشته فعال باشد
                            </strong>

                            <small>
                                در صورت فعال بودن، برنامه در
                                سایت انگلیسی نمایش داده می‌شود.
                            </small>

                        </span>

                    </label>

                </div>

            </section>


            <!-- =====================================================
                 PUBLIC LINK
            ====================================================== -->

            <?php if (
                $currentSlug !== ''
            ): ?>

                <section class="english-admin-form__card">

                    <div class="english-admin-form__card-header">

                        <span>
                            05
                        </span>

                        <div>

                            <h2>
                                لینک عمومی
                            </h2>

                            <p>
                                آدرس فعلی این برنامه در سایت انگلیسی.
                            </p>

                        </div>

                    </div>


                    <div class="english-admin-form__fields">

                        <a
                            href="<?= View::url(
                                '/english/programs/'
                                . rawurlencode(
                                    $currentSlug
                                )
                            ) ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="english-admin-form__public-link"
                            dir="ltr"
                        >
                            <?= View::escape(
                                '/english/programs/'
                                . $currentSlug
                            ) ?>

                            ↗
                        </a>

                    </div>

                </section>

            <?php endif; ?>


            <!-- =====================================================
                 SAVE BAR
            ====================================================== -->

            <div class="english-admin-form__savebar">

                <a
                    href="<?= View::url(
                        '/admin/english/programs'
                    ) ?>"
                    class="english-admin-form__cancel"
                >
                    انصراف
                </a>


                <button
                    type="submit"
                    class="english-admin-form__save"
                >

                    <span aria-hidden="true">
                        ✓
                    </span>

                    <?= View::escape(
                        $submitLabel
                    ) ?>

                </button>

            </div>

        </form>

    </div>

</div>
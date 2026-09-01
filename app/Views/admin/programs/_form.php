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
    is_string($action ?? null)
        ? $action
        : '';

$submitLabel =
    is_string($submitLabel ?? null)
        ? $submitLabel
        : 'ذخیره';
?>

<form
    method="POST"
    action="<?= View::escape(
        $action
    ) ?>"
    class="program-admin-form"
>

    <?= Csrf::field() ?>


    <?php if (
        $errors !== []
    ): ?>

        <div class="program-admin-form__errors">

            <div
                class="program-admin-form__errors-icon"
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
                        $errors as $message
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


    <div class="program-admin-form__grid">


        <!-- Faculty -->

        <div class="program-admin-form__field">

            <label for="faculty_id">
                دانشکده
                <span>*</span>
            </label>

            <select
                id="faculty_id"
                name="faculty_id"
                required
            >

                <option value="">
                    انتخاب دانشکده
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
                            $program['faculty_id']
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

            <?php if (
                isset(
                    $errors['faculty_id']
                )
            ): ?>

                <small class="program-admin-form__error">
                    <?= View::escape(
                        $errors['faculty_id']
                    ) ?>
                </small>

            <?php endif; ?>

        </div>


        <!-- Program name -->

        <div class="program-admin-form__field">

            <label for="name">
                نام برنامه
                <span>*</span>
            </label>

            <input
                id="name"
                name="name"
                type="text"
                value="<?= View::escape(
                    $program['name']
                    ?? ''
                ) ?>"
                maxlength="255"
                required
                placeholder="مثلاً مهندسی کامپیوتر"
            >

            <?php if (
                isset(
                    $errors['name']
                )
            ): ?>

                <small class="program-admin-form__error">
                    <?= View::escape(
                        $errors['name']
                    ) ?>
                </small>

            <?php endif; ?>

        </div>


        <!-- Slug -->

        <div class="program-admin-form__field">

            <label for="slug">
                شناسه URL
            </label>

            <div class="program-admin-form__input-prefix">

                <span dir="ltr">
                    /programs/
                </span>

                <input
                    id="slug"
                    name="slug"
                    type="text"
                    value="<?= View::escape(
                        $program['slug']
                        ?? ''
                    ) ?>"
                    maxlength="255"
                    dir="ltr"
                    placeholder="computer-engineering-bsc"
                >

            </div>

            <?php if (
                isset(
                    $errors['slug']
                )
            ): ?>

                <small class="program-admin-form__error">
                    <?= View::escape(
                        $errors['slug']
                    ) ?>
                </small>

            <?php else: ?>

                <small>
                    در صورت خالی بودن، شناسه به‌صورت خودکار ساخته می‌شود.
                </small>

            <?php endif; ?>

        </div>


        <!-- Degree -->

        <div class="program-admin-form__field">

            <label for="degree">
                مقطع تحصیلی
            </label>

            <input
                id="degree"
                name="degree"
                type="text"
                value="<?= View::escape(
                    $program['degree']
                    ?? ''
                ) ?>"
                maxlength="100"
                placeholder="مثلاً کارشناسی"
            >

            <?php if (
                isset(
                    $errors['degree']
                )
            ): ?>

                <small class="program-admin-form__error">
                    <?= View::escape(
                        $errors['degree']
                    ) ?>
                </small>

            <?php endif; ?>

        </div>


        <!-- Field -->

        <div class="program-admin-form__field">

            <label for="field">
                گرایش
            </label>

            <input
                id="field"
                name="field"
                type="text"
                value="<?= View::escape(
                    $program['field']
                    ?? ''
                ) ?>"
                maxlength="255"
                placeholder="مثلاً نرم‌افزار"
            >

            <?php if (
                isset(
                    $errors['field']
                )
            ): ?>

                <small class="program-admin-form__error">
                    <?= View::escape(
                        $errors['field']
                    ) ?>
                </small>

            <?php endif; ?>

        </div>


        <!-- Duration -->

        <div class="program-admin-form__field">

            <label for="duration">
                مدت تحصیل
            </label>

            <input
                id="duration"
                name="duration"
                type="text"
                value="<?= View::escape(
                    $program['duration']
                    ?? ''
                ) ?>"
                placeholder="مثلاً ۴ سال"
            >

        </div>


        <!-- Description -->

        <div
            class="
                program-admin-form__field
                program-admin-form__field--full
            "
        >

            <label for="description">
                معرفی برنامه
            </label>

            <textarea
                id="description"
                name="description"
                rows="7"
                placeholder="توضیحی درباره برنامه، اهداف آموزشی و محتوای آن بنویسید."
            ><?= View::escape(
                $program['description']
                ?? ''
            ) ?></textarea>

        </div>


        <!-- Admission -->

        <div
            class="
                program-admin-form__field
                program-admin-form__field--full
            "
        >

            <label for="admission_info">
                اطلاعات پذیرش
            </label>

            <textarea
                id="admission_info"
                name="admission_info"
                rows="7"
                placeholder="شرایط و توضیحات مربوط به پذیرش دانشجو."
            ><?= View::escape(
                $program['admission_info']
                ?? ''
            ) ?></textarea>

        </div>


        <!-- Curriculum -->

        <div
            class="
                program-admin-form__field
                program-admin-form__field--full
            "
        >

            <label for="curriculum">
                برنامه درسی
            </label>

            <textarea
                id="curriculum"
                name="curriculum"
                rows="9"
                placeholder="واحدها، دروس یا توضیحات برنامه درسی را وارد کنید."
            ><?= View::escape(
                $program['curriculum']
                ?? ''
            ) ?></textarea>

        </div>


        <!-- Sort order -->

        <div class="program-admin-form__field">

            <label for="sort_order">
                ترتیب نمایش
            </label>

            <input
                id="sort_order"
                name="sort_order"
                type="number"
                min="0"
                value="<?= View::escape(
                    $program['sort_order']
                    ?? 0
                ) ?>"
            >

            <small>
                عدد کمتر، جایگاه بالاتری خواهد داشت.
            </small>

        </div>


        <!-- Active -->

        <div class="program-admin-form__field">

            <label>
                وضعیت برنامه
            </label>

            <label class="program-admin-form__switch">

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    <?= (
                        (int) (
                            $program['is_active']
                            ?? 1
                        ) === 1
                    )
                        ? 'checked'
                        : ''
                    ?>
                >

                <span
                    class="program-admin-form__switch-track"
                    aria-hidden="true"
                >
                    <span></span>
                </span>

                <span class="program-admin-form__switch-text">

                    <strong>
                        برنامه فعال باشد
                    </strong>

                    <small>
                        برنامه‌های فعال در سایت عمومی نمایش داده می‌شوند.
                    </small>

                </span>

            </label>

        </div>

    </div>


    <div class="program-admin-form__actions">

        <a
            href="<?= View::route(
                'admin.programs.index'
            ) ?>"
            class="program-admin-form__button program-admin-form__button--secondary"
        >
            انصراف
        </a>


        <button
            type="submit"
            class="program-admin-form__button program-admin-form__button--primary"
        >
            <?= View::escape(
                $submitLabel
            ) ?>
        </button>

    </div>

</form>
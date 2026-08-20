<?php

declare(strict_types=1);

$program = $program ?? [];

$faculties = $faculties ?? [];

$errors = $errors ?? [];

$action = $action ?? '';

$submitLabel = $submitLabel ?? 'ذخیره';
?>

<form
    method="POST"
    action="<?= View::escape($action) ?>"
    class="admin-form"
>

    <?= \App\Core\Csrf::field() ?>


    <?php if ($errors !== []): ?>

        <div class="form-errors">

            <strong>
                لطفاً موارد زیر را اصلاح کنید:
            </strong>

            <ul>

                <?php foreach ($errors as $error): ?>

                    <li>
                        <?= View::escape($error) ?>
                    </li>

                <?php endforeach; ?>

            </ul>

        </div>

    <?php endif; ?>


    <div class="form-grid">

        <div class="form-field">

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
                required
            >

                <option value="">
                    انتخاب دانشکده
                </option>

                <?php foreach (
                    $faculties
                    as $faculty
                ): ?>

                    <option
                        value="<?= (int) $faculty['id'] ?>"
                        <?= (
                            (string) (
                                $program['faculty_id']
                                ?? ''
                            )
                            === (string) (
                                $faculty['id']
                            )
                        )
                            ? 'selected'
                            : ''
                        ?>
                    >
                        <?= View::escape(
                            $faculty['name']
                        ) ?>
                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <div class="form-field">

            <label
                for="name"
                class="form-field__label"
            >
                نام برنامه
            </label>

            <input
                id="name"
                name="name"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $program['name'] ?? ''
                ) ?>"
                maxlength="255"
                required
            >

        </div>


        <div class="form-field">

            <label
                for="slug"
                class="form-field__label"
            >
                آدرس
            </label>

            <input
                id="slug"
                name="slug"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $program['slug'] ?? ''
                ) ?>"
                placeholder="computer-engineering-bsc"
                required
            >

        </div>


        <div class="form-field">

            <label
                for="degree"
                class="form-field__label"
            >
                مقطع
            </label>

            <input
                id="degree"
                name="degree"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $program['degree'] ?? ''
                ) ?>"
                placeholder="کارشناسی"
            >

        </div>


        <div class="form-field">

            <label
                for="field"
                class="form-field__label"
            >
                گرایش
            </label>

            <input
                id="field"
                name="field"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $program['field'] ?? ''
                ) ?>"
            >

        </div>


        <div class="form-field">

            <label
                for="duration"
                class="form-field__label"
            >
                مدت تحصیل
            </label>

            <input
                id="duration"
                name="duration"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $program['duration'] ?? ''
                ) ?>"
                placeholder="۴ سال"
            >

        </div>


        <div
            class="form-field form-field--full"
        >

            <label
                for="description"
                class="form-field__label"
            >
                معرفی برنامه
            </label>

            <textarea
                id="description"
                name="description"
                class="form-field__textarea"
                rows="6"
            ><?= View::escape(
                $program['description'] ?? ''
            ) ?></textarea>

        </div>


        <div
            class="form-field form-field--full"
        >

            <label
                for="admission_info"
                class="form-field__label"
            >
                اطلاعات پذیرش
            </label>

            <textarea
                id="admission_info"
                name="admission_info"
                class="form-field__textarea"
                rows="6"
            ><?= View::escape(
                $program['admission_info'] ?? ''
            ) ?></textarea>

        </div>


        <div
            class="form-field form-field--full"
        >

            <label
                for="curriculum"
                class="form-field__label"
            >
                برنامه درسی
            </label>

            <textarea
                id="curriculum"
                name="curriculum"
                class="form-field__textarea"
                rows="8"
            ><?= View::escape(
                $program['curriculum'] ?? ''
            ) ?></textarea>

        </div>


        <div class="form-field">

            <label
                for="sort_order"
                class="form-field__label"
            >
                ترتیب
            </label>

            <input
                id="sort_order"
                name="sort_order"
                type="number"
                class="form-field__input"
                value="<?= View::escape(
                    $program['sort_order'] ?? 0
                ) ?>"
            >

        </div>


        <div class="form-field">

            <label
                style="
                    display:flex;
                    align-items:center;
                    gap:8px;
                    min-height:46px;
                "
            >

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

                برنامه فعال باشد

            </label>

        </div>

    </div>


    <div class="admin-form__actions">

        <button
            type="submit"
            class="button button--primary"
        >
            <?= View::escape(
                $submitLabel
            ) ?>
        </button>

        <a
            href="<?= View::route(
                'admin.programs.index'
            ) ?>"
            class="button button--secondary"
        >
            انصراف
        </a>

    </div>

</form>
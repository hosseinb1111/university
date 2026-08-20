<?php

declare(strict_types=1);

$faculty =
    $faculty ?? [];

$people =
    $people ?? [];

$errors =
    $errors ?? [];

$action =
    $action ?? '';

$submitLabel =
    $submitLabel ?? 'ذخیره';
?>

<form
    method="POST"
    action="<?= View::escape(
        $action
    ) ?>"
    class="admin-form"
>

    <?= \App\Core\Csrf::field() ?>


    <?php if (
        $errors !== []
    ): ?>

        <div class="form-errors">

            <strong>
                لطفاً موارد زیر را اصلاح کنید:
            </strong>

            <ul>

                <?php foreach (
                    $errors
                    as $error
                ): ?>

                    <li>
                        <?= View::escape(
                            $error
                        ) ?>
                    </li>

                <?php endforeach; ?>

            </ul>

        </div>

    <?php endif; ?>


    <div class="form-grid">

        <div class="form-field">

            <label
                for="name"
                class="form-field__label"
            >
                نام دانشکده
            </label>

            <input
                id="name"
                name="name"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $faculty['name']
                    ?? ''
                ) ?>"
                required
            >

        </div>


        <div class="form-field">

            <label
                for="short_name"
                class="form-field__label"
            >
                نام کوتاه
            </label>

            <input
                id="short_name"
                name="short_name"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $faculty['short_name']
                    ?? ''
                ) ?>"
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
                    $faculty['slug']
                    ?? ''
                ) ?>"
                placeholder="computer-engineering"
                required
            >

        </div>


        <div class="form-field">

            <label
                for="dean_person_id"
                class="form-field__label"
            >
                رئیس دانشکده
            </label>

            <select
                id="dean_person_id"
                name="dean_person_id"
                class="form-field__input"
            >

                <option value="">
                    انتخاب نشده
                </option>

                <?php foreach (
                    $people
                    as $person
                ): ?>

                    <option
                        value="<?= (int) $person['id'] ?>"
                        <?= (
                            (string) (
                                $faculty[
                                    'dean_person_id'
                                ] ?? ''
                            )
                            === (string) (
                                $person['id']
                            )
                        )
                            ? 'selected'
                            : ''
                        ?>
                    >
                        <?= View::escape(
                            trim(
                                $person['first_name']
                                . ' '
                                . $person['last_name']
                            )
                        ) ?>
                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <div
            class="form-field form-field--full"
        >

            <label
                for="description"
                class="form-field__label"
            >
                معرفی دانشکده
            </label>

            <textarea
                id="description"
                name="description"
                class="form-field__textarea"
                rows="7"
            ><?= View::escape(
                $faculty['description']
                ?? ''
            ) ?></textarea>

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
                    $faculty['email']
                    ?? ''
                ) ?>"
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
                    $faculty['phone']
                    ?? ''
                ) ?>"
            >

        </div>


        <div class="form-field">

            <label
                for="fax"
                class="form-field__label"
            >
                فکس
            </label>

            <input
                id="fax"
                name="fax"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $faculty['fax']
                    ?? ''
                ) ?>"
            >

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
                    $faculty['sort_order']
                    ?? 0
                ) ?>"
            >

        </div>


        <div
            class="form-field form-field--full"
        >

            <label
                for="address"
                class="form-field__label"
            >
                آدرس
            </label>

            <textarea
                id="address"
                name="address"
                class="form-field__textarea"
                rows="3"
            ><?= View::escape(
                $faculty['address']
                ?? ''
            ) ?></textarea>

        </div>


        <div
            class="form-field form-field--full"
        >

            <label
                for="image"
                class="form-field__label"
            >
                تصویر
            </label>

            <input
                id="image"
                name="image"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $faculty['image']
                    ?? ''
                ) ?>"
                placeholder="/media/..."
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
                            $faculty['is_active']
                            ?? 1
                        ) === 1
                    )
                        ? 'checked'
                        : ''
                    ?>
                >

                دانشکده فعال باشد

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
                'admin.faculties.index'
            ) ?>"
            class="button button--secondary"
        >
            انصراف
        </a>

    </div>

</form>
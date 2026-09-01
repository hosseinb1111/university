<?php
declare(strict_types=1);

use App\Core\View;
$person =
    $person ?? [];

$faculties =
    $faculties ?? [];

$errors =
    $errors ?? [];

$action =
    $action ?? '';

$submitLabel =
    $submitLabel ?? 'Ø°Ø®ÛŒØ±Ù‡';
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
                Ù„Ø·ÙØ§Ù‹ Ù…ÙˆØ§Ø±Ø¯ Ø²ÛŒØ± Ø±Ø§ Ø§ØµÙ„Ø§Ø­ Ú©Ù†ÛŒØ¯:
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
                for="first_name"
                class="form-field__label"
            >
                Ù†Ø§Ù…
            </label>

            <input
                id="first_name"
                name="first_name"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $person['first_name']
                    ?? ''
                ) ?>"
                required
            >

        </div>


        <div class="form-field">

            <label
                for="last_name"
                class="form-field__label"
            >
                Ù†Ø§Ù… Ø®Ø§Ù†ÙˆØ§Ø¯Ú¯ÛŒ
            </label>

            <input
                id="last_name"
                name="last_name"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $person['last_name']
                    ?? ''
                ) ?>"
                required
            >

        </div>


        <div class="form-field">

            <label
                for="position"
                class="form-field__label"
            >
                Ø³Ù…Øª
            </label>

            <input
                id="position"
                name="position"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $person['position']
                    ?? ''
                ) ?>"
            >

        </div>


        <div class="form-field">

            <label
                for="faculty_id"
                class="form-field__label"
            >
                Ø¯Ø§Ù†Ø´Ú©Ø¯Ù‡
            </label>

            <select
                id="faculty_id"
                name="faculty_id"
                class="form-field__input"
            >

                <option value="">
                    Ø¨Ø¯ÙˆÙ† Ø¯Ø§Ù†Ø´Ú©Ø¯Ù‡
                </option>

                <?php foreach (
                    $faculties
                    as $faculty
                ): ?>

                    <option
                        value="<?= (int) $faculty['id'] ?>"
                        <?= (
                            (string) (
                                $person['faculty_id']
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
                for="email"
                class="form-field__label"
            >
                Ø§ÛŒÙ…ÛŒÙ„
            </label>

            <input
                id="email"
                name="email"
                type="email"
                class="form-field__input"
                value="<?= View::escape(
                    $person['email']
                    ?? ''
                ) ?>"
            >

        </div>


        <div class="form-field">

            <label
                for="phone"
                class="form-field__label"
            >
                ØªÙ„ÙÙ†
            </label>

            <input
                id="phone"
                name="phone"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $person['phone']
                    ?? ''
                ) ?>"
            >

        </div>


        <div class="form-field">

            <label
                for="fax"
                class="form-field__label"
            >
                ÙÚ©Ø³
            </label>

            <input
                id="fax"
                name="fax"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $person['fax']
                    ?? ''
                ) ?>"
            >

        </div>


        <div class="form-field">

            <label
                for="office_location"
                class="form-field__label"
            >
                Ù…Ø­Ù„ Ø¯ÙØªØ±
            </label>

            <input
                id="office_location"
                name="office_location"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $person['office_location']
                    ?? ''
                ) ?>"
            >

        </div>


        <div
            class="form-field form-field--full"
        >

            <label
                for="image"
                class="form-field__label"
            >
                ØªØµÙˆÛŒØ±
            </label>

            <input
                id="image"
                name="image"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $person['image']
                    ?? ''
                ) ?>"
                placeholder="/media/..."
            >

        </div>


        <div
            class="form-field form-field--full"
        >

            <label
                for="biography"
                class="form-field__label"
            >
                Ø²Ù†Ø¯Ú¯ÛŒâ€ŒÙ†Ø§Ù…Ù‡ / Ù…Ø¹Ø±ÙÛŒ
            </label>

            <textarea
                id="biography"
                name="biography"
                class="form-field__textarea"
                rows="10"
            ><?= View::escape(
                $person['biography']
                ?? ''
            ) ?></textarea>

        </div>


        <div class="form-field">

            <label
                for="sort_order"
                class="form-field__label"
            >
                ØªØ±ØªÛŒØ¨ Ù†Ù…Ø§ÛŒØ´
            </label>

            <input
                id="sort_order"
                name="sort_order"
                type="number"
                class="form-field__input"
                value="<?= View::escape(
                    $person['sort_order']
                    ?? 0
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
                            $person['is_active']
                            ?? 1
                        ) === 1
                    )
                        ? 'checked'
                        : ''
                    ?>
                >

                Ø´Ø®Øµ ÙØ¹Ø§Ù„ Ø¨Ø§Ø´Ø¯

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
                'admin.people.index'
            ) ?>"
            class="button button--secondary"
        >
            Ø§Ù†ØµØ±Ø§Ù
        </a>

    </div>

</form>

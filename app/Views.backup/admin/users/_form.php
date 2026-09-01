<?php
declare(strict_types=1);

use App\Core\View;
$user =
    $user ?? [];

$errors =
    $errors ?? [];

$action =
    $action ?? '';

$submitLabel =
    $submitLabel ?? 'Ø°Ø®ÛŒØ±Ù‡';

$isEdit =
    isset($user['id']);
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
                for="username"
                class="form-field__label"
            >
                Ù†Ø§Ù… Ú©Ø§Ø±Ø¨Ø±ÛŒ
            </label>

            <input
                id="username"
                name="username"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $user['username'] ?? ''
                ) ?>"
                maxlength="100"
                autocomplete="username"
                required
            >

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
                    $user['email'] ?? ''
                ) ?>"
                autocomplete="email"
            >

        </div>


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
                    $user['first_name'] ?? ''
                ) ?>"
                autocomplete="given-name"
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
                    $user['last_name'] ?? ''
                ) ?>"
                autocomplete="family-name"
            >

        </div>


        <div class="form-field">

            <label
                for="role"
                class="form-field__label"
            >
                Ù†Ù‚Ø´
            </label>

            <select
                id="role"
                name="role"
                class="form-field__input"
                required
            >

                <option
                    value="teacher"
                    <?= (
                        ($user['role'] ?? 'teacher')
                        === 'teacher'
                    )
                        ? 'selected'
                        : ''
                    ?>
                >
                    Ø¹Ø¶Ùˆ Ù‡ÛŒØ¦Øª Ø¹Ù„Ù…ÛŒ
                </option>

                <option
                    value="editor"
                    <?= (
                        ($user['role'] ?? '')
                        === 'editor'
                    )
                        ? 'selected'
                        : ''
                    ?>
                >
                    ÙˆÛŒØ±Ø§Ø³ØªØ§Ø±
                </option>

                <option
                    value="admin"
                    <?= (
                        ($user['role'] ?? '')
                        === 'admin'
                    )
                        ? 'selected'
                        : ''
                    ?>
                >
                    Ù…Ø¯ÛŒØ±
                </option>

                <option
                    value="super_admin"
                    <?= (
                        ($user['role'] ?? '')
                        === 'super_admin'
                    )
                        ? 'selected'
                        : ''
                    ?>
                >
                    Ù…Ø¯ÛŒØ± Ø§Ø±Ø´Ø¯
                </option>

            </select>

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
                            $user['is_active']
                            ?? 1
                        ) === 1
                    )
                        ? 'checked'
                        : ''
                    ?>
                >

                Ø­Ø³Ø§Ø¨ ÙØ¹Ø§Ù„ Ø¨Ø§Ø´Ø¯

            </label>

        </div>


        <div
            class="form-field form-field--full"
        >

            <label
                for="password"
                class="form-field__label"
            >
                Ø±Ù…Ø² Ø¹Ø¨ÙˆØ±
                <?php if ($isEdit): ?>
                    <span
                        style="
                            color:#94a3b8;
                            font-size:12px;
                            font-weight:400;
                        "
                    >
                        (Ø¨Ø±Ø§ÛŒ ØªØºÛŒÛŒØ± Ø±Ù…Ø² ÙˆØ§Ø±Ø¯ Ú©Ù†ÛŒØ¯)
                    </span>
                <?php endif; ?>
            </label>

            <input
                id="password"
                name="password"
                type="password"
                class="form-field__input"
                autocomplete="new-password"
                <?= $isEdit ? '' : 'required' ?>
            >

            <small
                style="
                    color:#64748b;
                    font-size:12px;
                "
            >
                Ø­Ø¯Ø§Ù‚Ù„ Û¸ Ú©Ø§Ø±Ø§Ú©ØªØ±
            </small>

        </div>


        <div
            class="form-field form-field--full"
        >

            <label
                for="password_confirmation"
                class="form-field__label"
            >
                ØªÚ©Ø±Ø§Ø± Ø±Ù…Ø² Ø¹Ø¨ÙˆØ±
            </label>

            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                class="form-field__input"
                autocomplete="new-password"
                <?= $isEdit ? '' : 'required' ?>
            >

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
                'admin.users.index'
            ) ?>"
            class="button button--secondary"
        >
            Ø§Ù†ØµØ±Ø§Ù
        </a>

    </div>

</form>

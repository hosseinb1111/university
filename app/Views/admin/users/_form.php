<?php

declare(strict_types=1);

$user =
    $user ?? [];

$errors =
    $errors ?? [];

$action =
    $action ?? '';

$submitLabel =
    $submitLabel ?? 'ذخیره';

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
                for="username"
                class="form-field__label"
            >
                نام کاربری
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
                ایمیل
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
                نام
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
                نام خانوادگی
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
                نقش
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
                    عضو هیئت علمی
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
                    ویراستار
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
                    مدیر
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
                    مدیر ارشد
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

                حساب فعال باشد

            </label>

        </div>


        <div
            class="form-field form-field--full"
        >

            <label
                for="password"
                class="form-field__label"
            >
                رمز عبور
                <?php if ($isEdit): ?>
                    <span
                        style="
                            color:#94a3b8;
                            font-size:12px;
                            font-weight:400;
                        "
                    >
                        (برای تغییر رمز وارد کنید)
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
                حداقل ۸ کاراکتر
            </small>

        </div>


        <div
            class="form-field form-field--full"
        >

            <label
                for="password_confirmation"
                class="form-field__label"
            >
                تکرار رمز عبور
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
            انصراف
        </a>

    </div>

</form>
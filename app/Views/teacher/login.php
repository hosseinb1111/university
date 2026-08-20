<?php

declare(strict_types=1);

use App\Core\Csrf;
?>

<section class="auth-page">

    <div class="container">

        <div class="auth-card">

            <div class="auth-card__header">

                <span class="auth-card__eyebrow">
                    سامانه دانشگاه
                </span>

                <h1 class="auth-card__title">
                    سامانه اعضای هیئت علمی
                </h1>

                <p class="auth-card__description">
                    برای ورود، نام کاربری و رمز عبور خود را وارد کنید.
                </p>

            </div>

            <form
                method="post"
                action="<?= View::route(
                    'teacher.login.submit'
                ) ?>"
                class="auth-form"
                novalidate
            >

                <?= Csrf::field() ?>

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
                        autocomplete="username"
                        maxlength="100"
                        required
                        autofocus
                    >

                </div>

                <div class="form-field">

                    <label
                        for="password"
                        class="form-field__label"
                    >
                        رمز عبور
                    </label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="form-field__input"
                        autocomplete="current-password"
                        required
                    >

                </div>

                <button
                    type="submit"
                    class="button button--primary button--full"
                >
                    ورود
                </button>

            </form>

            <div class="auth-card__footer">

                <a
                    href="<?= View::route(
                        'teacher.password.request'
                    ) ?>"
                >
                    رمز عبور خود را فراموش کرده‌اید؟
                </a>

            </div>

        </div>

    </div>

</section>
<?php

declare(strict_types=1);

use App\Core\View;
use App\Core\Csrf;
?>

<section class="auth-page">

    <div class="container">

        <div class="auth-card">

            <div class="auth-card__header">

                <span class="auth-card__eyebrow">
                    سامانه اعضای هیئت علمی
                </span>

                <h1 class="auth-card__title">
                    بازیابی رمز عبور
                </h1>

                <p class="auth-card__description">
                    پست الکترونیکی حساب کاربری خود را وارد کنید.
                </p>

            </div>

            <form
                method="post"
                action="<?= View::route(
                    'teacher.password.email'
                ) ?>"
                class="auth-form"
            >

                <?= Csrf::field() ?>

                <div class="form-field">

                    <label
                        for="email"
                        class="form-field__label"
                    >
                        پست الکترونیکی
                    </label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        class="form-field__input"
                        autocomplete="email"
                        maxlength="255"
                        required
                    >

                </div>

                <button
                    type="submit"
                    class="button button--primary button--full"
                >
                    ارسال لینک بازیابی
                </button>

            </form>

            <div class="auth-card__footer">

                <a
                    href="<?= View::route(
                        'teacher.login'
                    ) ?>"
                >
                    بازگشت به صفحه ورود
                </a>

            </div>

        </div>

    </div>

</section>
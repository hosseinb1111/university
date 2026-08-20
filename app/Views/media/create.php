<?php

declare(strict_types=1);

use App\Core\Session;

$error =
    Session::getFlash(
        'error'
    );
?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>

            <h1>
                افزودن تصویر
            </h1>

            <p>
                تصویر را برای استفاده در سایت آپلود کنید.
            </p>

        </div>

    </div>


    <div class="admin-panel">

        <?php if (
            is_string($error)
            && $error !== ''
        ): ?>

            <div class="form-errors">

                <?= View::escape(
                    $error
                ) ?>

            </div>

        <?php endif; ?>


        <form
            method="POST"
            action="<?= View::route(
                'admin.media.store'
            ) ?>"
            enctype="multipart/form-data"
            class="admin-form"
        >

            <?= \App\Core\Csrf::field() ?>


            <div class="form-grid">

                <div
                    class="form-field form-field--full"
                >

                    <label
                        for="media"
                        class="form-field__label"
                    >
                        تصویر
                    </label>

                    <input
                        id="media"
                        name="media"
                        type="file"
                        class="form-field__input"
                        accept="image/jpeg,image/png,image/webp"
                        required
                    >

                    <small
                        style="
                            color:#64748b;
                            font-size:12px;
                        "
                    >
                        فرمت‌های مجاز:
                        JPG، PNG، WebP
                        — حداکثر ۵ مگابایت
                    </small>

                </div>


                <div
                    class="form-field form-field--full"
                >

                    <label
                        for="alt_text"
                        class="form-field__label"
                    >
                        متن جایگزین تصویر
                    </label>

                    <input
                        id="alt_text"
                        name="alt_text"
                        type="text"
                        class="form-field__input"
                        maxlength="255"
                        placeholder="مثلاً نمای ساختمان موسسه"
                    >

                </div>

            </div>


            <div class="admin-form__actions">

                <button
                    type="submit"
                    class="button button--primary"
                >
                    آپلود تصویر
                </button>

                <a
                    href="<?= View::route(
                        'admin.media.index'
                    ) ?>"
                    class="button button--secondary"
                >
                    انصراف
                </a>

            </div>

        </form>

    </div>

</div>
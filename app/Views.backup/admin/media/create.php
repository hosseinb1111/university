<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\Session;
use App\Core\View;

$errorMessage =
    Session::getFlash(
        'error'
    );

$oldAltText =
    Session::getFlash(
        'media_alt_text'
    );

if (
    !is_string(
        $oldAltText
    )
) {
    $oldAltText = '';
}

?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>

            <span class="admin-page__eyebrow">
                کتابخانه رسانه
            </span>

            <h1>
                آپلود فایل
            </h1>

            <p>
                تصویر یا فایل مورد نیاز سایت را به کتابخانه رسانه اضافه کنید.
            </p>

        </div>


        <a
            href="<?= View::url(
                '/admin/media'
            ) ?>"
            class="button button--secondary"
        >
            بازگشت
        </a>

    </div>


    <?php if (
        is_string(
            $errorMessage
        )
        && $errorMessage !== ''
    ): ?>

        <div
            class="admin-alert admin-alert--error"
            role="alert"
        >

            <?= View::escape(
                $errorMessage
            ) ?>

        </div>

    <?php endif; ?>


    <div class="admin-panel">

        <div class="admin-panel__header">

            <div>

                <strong>
                    فایل جدید
                </strong>

                <span>
                    حداکثر حجم:
                    <?= number_format(
                        (int) config(
                            'app.uploads.max_file_size',
                            10 * 1024 * 1024
                        )
                        / 1024
                        / 1024,
                        2
                    ) ?>
                    MB
                </span>

            </div>

        </div>


        <form
            method="POST"
            action="<?= View::url(
                '/admin/media'
            ) ?>"
            enctype="multipart/form-data"
            class="admin-form"
        >

            <?= Csrf::field() ?>


            <div class="admin-form__grid">


                <!-- File -->

                <div
                    class="
                        admin-form__field
                        admin-form__field--full
                    "
                >

                    <label
                        for="file"
                    >
                        فایل *
                    </label>

                    <input
                        id="file"
                        name="file"
                        type="file"
                        required
                        accept="
                            image/jpeg,
                            image/png,
                            image/webp,
                            application/pdf,
                            application/msword,
                            application/vnd.openxmlformats-officedocument.wordprocessingml.document,
                            application/vnd.ms-excel,
                            application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,
                            application/vnd.ms-powerpoint,
                            application/vnd.openxmlformats-officedocument.presentationml.presentation
                        "
                    >

                    <small>
                        فرمت‌های مجاز:
                        JPG، PNG، WebP، PDF، Word، Excel و PowerPoint.
                    </small>

                </div>


                <!-- Alt text -->

                <div
                    class="
                        admin-form__field
                        admin-form__field--full
                    "
                >

                    <label
                        for="alt_text"
                    >
                        متن جایگزین تصویر
                    </label>

                    <input
                        id="alt_text"
                        name="alt_text"
                        type="text"
                        value="<?= View::escape(
                            $oldAltText
                        ) ?>"
                        maxlength="255"
                        placeholder="مثلاً تصویر ساختمان اصلی موسسه"
                    >

                    <small>
                        برای تصاویر، یک توضیح کوتاه و توصیفی وارد کنید.
                    </small>

                </div>

            </div>


            <div class="admin-form__actions">

                <button
                    type="submit"
                    class="button button--primary"
                >
                    آپلود فایل
                </button>


                <a
                    href="<?= View::url(
                        '/admin/media'
                    ) ?>"
                    class="button button--secondary"
                >
                    انصراف
                </a>

            </div>

        </form>

    </div>


    <div class="admin-panel admin-upload-info">

        <div class="admin-panel__header">

            <strong>
                نکات آپلود
            </strong>

        </div>


        <div class="admin-upload-info__body">

            <p>
                نام فایل نهایی توسط سرور ساخته می‌شود؛ بنابراین نام فایل اصلی کاربر مستقیماً به عنوان نام فایل ذخیره‌شده استفاده نمی‌شود.
            </p>

            <p>
                نوع فایل بر اساس محتوای واقعی فایل بررسی می‌شود، نه فقط پسوند فایل.
            </p>

            <p>
                برای تصاویر، ابعاد تصویر نیز در کتابخانه رسانه ذخیره می‌شود.
            </p>

        </div>

    </div>

</div>
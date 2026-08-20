<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;

$slide =
    is_array(
        $slide ?? null
    )
        ? $slide
        : [];

$errors =
    is_array(
        $errors ?? null
    )
        ? $errors
        : [];

$action =
    is_string(
        $action ?? null
    )
        ? $action
        : '';

$submitLabel =
    is_string(
        $submitLabel ?? null
    )
        ? $submitLabel
        : 'ذخیره';

$mediaItems =
    is_array(
        $mediaItems ?? null
    )
        ? $mediaItems
        : [];


/*
|--------------------------------------------------------------------------
| Existing values
|--------------------------------------------------------------------------
*/

$title =
    (string) (
        $slide['title']
        ?? ''
    );

$subtitle =
    (string) (
        $slide['subtitle']
        ?? ''
    );

$description =
    (string) (
        $slide['description']
        ?? ''
    );

$buttonText =
    (string) (
        $slide['button_text']
        ?? ''
    );

$buttonUrl =
    (string) (
        $slide['button_url']
        ?? ''
    );

$image =
    trim(
        (string) (
            $slide['image']
            ?? ''
        )
    );

$mobileImage =
    trim(
        (string) (
            $slide['mobile_image']
            ?? ''
        )
    );

$sortOrder =
    (int) (
        $slide['sort_order']
        ?? 0
    );

$isActive =
    (int) (
        $slide['is_active']
        ?? 1
    ) === 1;


/*
|--------------------------------------------------------------------------
| Datetime formatter
|--------------------------------------------------------------------------
*/

$formatDateTime =
    static function (
        mixed $value
    ): string {
        if (
            !is_string(
                $value
            )
            || trim(
                $value
            ) === ''
        ) {
            return '';
        }

        $timestamp =
            strtotime(
                $value
            );

        if (
            $timestamp === false
        ) {
            return '';
        }

        return date(
            'Y-m-d\TH:i',
            $timestamp
        );
    };


$startsAt =
    $formatDateTime(
        $slide['starts_at']
        ?? ''
    );

$endsAt =
    $formatDateTime(
        $slide['ends_at']
        ?? ''
    );

?>

<form
    method="POST"
    action="<?= View::escape(
        $action
    ) ?>"
    class="admin-form"
>

    <?= Csrf::field() ?>


    <?php if (
        $errors !== []
    ): ?>

        <div
            class="admin-alert admin-alert--error"
            role="alert"
        >

            <strong>
                فرم دارای خطا است.
            </strong>

            <ul>

                <?php foreach (
                    $errors
                    as $error
                ): ?>

                    <li>
                        <?= View::escape(
                            is_string(
                                $error
                            )
                                ? $error
                                : 'خطای نامشخص'
                        ) ?>
                    </li>

                <?php endforeach; ?>

            </ul>

        </div>

    <?php endif; ?>


    <div class="admin-form__grid">


        <!-- =================================================
             Title
        ================================================== -->

        <div
            class="
                admin-form__field
                admin-form__field--full
            "
        >

            <label
                for="title"
            >
                عنوان *
            </label>

            <input
                id="title"
                name="title"
                type="text"
                value="<?= View::escape(
                    $title
                ) ?>"
                maxlength="255"
                required
                autofocus
            >

        </div>


        <!-- =================================================
             Subtitle
        ================================================== -->

        <div class="admin-form__field">

            <label
                for="subtitle"
            >
                زیرعنوان
            </label>

            <input
                id="subtitle"
                name="subtitle"
                type="text"
                value="<?= View::escape(
                    $subtitle
                ) ?>"
                maxlength="255"
            >

        </div>


        <!-- =================================================
             Sort order
        ================================================== -->

        <div class="admin-form__field">

            <label
                for="sort_order"
            >
                ترتیب نمایش
            </label>

            <input
                id="sort_order"
                name="sort_order"
                type="number"
                min="0"
                max="999999"
                step="1"
                value="<?= $sortOrder ?>"
            >

        </div>


        <!-- =================================================
             Description
        ================================================== -->

        <div
            class="
                admin-form__field
                admin-form__field--full
            "
        >

            <label
                for="description"
            >
                توضیحات
            </label>

            <textarea
                id="description"
                name="description"
                rows="6"
            ><?= View::escape(
                $description
            ) ?></textarea>

        </div>


        <!-- =================================================
             Button text
        ================================================== -->

        <div class="admin-form__field">

            <label
                for="button_text"
            >
                متن دکمه
            </label>

            <input
                id="button_text"
                name="button_text"
                type="text"
                value="<?= View::escape(
                    $buttonText
                ) ?>"
                maxlength="255"
                placeholder="مثلاً مشاهده اطلاعیه‌ها"
            >

        </div>


        <!-- =================================================
             Button URL
        ================================================== -->

        <div class="admin-form__field">

            <label
                for="button_url"
            >
                لینک دکمه
            </label>

            <input
                id="button_url"
                name="button_url"
                type="text"
                value="<?= View::escape(
                    $buttonUrl
                ) ?>"
                maxlength="500"
                placeholder="/announcements"
            >

            <small>
                لینک داخلی مانند
                /announcements
                یا لینک خارجی با
                https://
            </small>

        </div>


        <!-- =================================================
             Desktop image
        ================================================== -->

        <div
            class="
                admin-form__field
                admin-form__field--full
            "
        >

            <label
                for="image"
            >
                تصویر اصلی
            </label>


            <select
                id="image"
                name="image"
            >

                <option value="">
                    بدون تصویر
                </option>


                <?php foreach (
                    $mediaItems
                    as $media
                ): ?>

                    <?php
                    $mediaPath =
                        trim(
                            (string) (
                                $media['public_url']
                                ?? $media['url']
                                ?? ''
                            )
                        );

                    $mediaName =
                        (string) (
                            $media['original_name']
                            ?? $media['file_name']
                            ?? 'تصویر'
                        );

                    $mediaMime =
                        strtolower(
                            (string) (
                                $media['mime_type']
                                ?? ''
                            )
                        );
                    ?>

                    <?php if (
                        $mediaPath !== ''
                        && str_starts_with(
                            $mediaMime,
                            'image/'
                        )
                    ): ?>

                        <option
                            value="<?= View::escape(
                                $mediaPath
                            ) ?>"
                            <?= $image === $mediaPath
                                ? 'selected'
                                : ''
                            ?>
                        >
                            <?= View::escape(
                                $mediaName
                            ) ?>
                        </option>

                    <?php endif; ?>

                <?php endforeach; ?>

            </select>


            <small>
                تصاویر را ابتدا از کتابخانه رسانه آپلود کنید.
            </small>


            <?php if (
                $image !== ''
            ): ?>

                <div class="admin-image-preview">

                    <img
                        src="<?= View::escape(
                            $image
                        ) ?>"
                        alt=""
                        loading="lazy"
                    >

                </div>

            <?php endif; ?>

        </div>


        <!-- =================================================
             Mobile image
        ================================================== -->

        <div
            class="
                admin-form__field
                admin-form__field--full
            "
        >

            <label
                for="mobile_image"
            >
                تصویر موبایل
            </label>


            <select
                id="mobile_image"
                name="mobile_image"
            >

                <option value="">
                    استفاده از تصویر اصلی
                </option>


                <?php foreach (
                    $mediaItems
                    as $media
                ): ?>

                    <?php
                    $mediaPath =
                        trim(
                            (string) (
                                $media['public_url']
                                ?? $media['url']
                                ?? ''
                            )
                        );

                    $mediaName =
                        (string) (
                            $media['original_name']
                            ?? $media['file_name']
                            ?? 'تصویر'
                        );

                    $mediaMime =
                        strtolower(
                            (string) (
                                $media['mime_type']
                                ?? ''
                            )
                        );
                    ?>

                    <?php if (
                        $mediaPath !== ''
                        && str_starts_with(
                            $mediaMime,
                            'image/'
                        )
                    ): ?>

                        <option
                            value="<?= View::escape(
                                $mediaPath
                            ) ?>"
                            <?= $mobileImage === $mediaPath
                                ? 'selected'
                                : ''
                            ?>
                        >
                            <?= View::escape(
                                $mediaName
                            ) ?>
                        </option>

                    <?php endif; ?>

                <?php endforeach; ?>

            </select>


            <small>
                اختیاری؛ برای موبایل می‌توانید تصویر متفاوتی انتخاب کنید.
            </small>


            <?php if (
                $mobileImage !== ''
            ): ?>

                <div class="admin-image-preview">

                    <img
                        src="<?= View::escape(
                            $mobileImage
                        ) ?>"
                        alt=""
                        loading="lazy"
                    >

                </div>

            <?php endif; ?>

        </div>


        <!-- =================================================
             Start date
        ================================================== -->

        <div class="admin-form__field">

            <label
                for="starts_at"
            >
                شروع نمایش
            </label>

            <input
                id="starts_at"
                name="starts_at"
                type="datetime-local"
                value="<?= View::escape(
                    $startsAt
                ) ?>"
            >

            <small>
                خالی = نمایش بدون شروع زمان‌بندی‌شده.
            </small>

        </div>


        <!-- =================================================
             End date
        ================================================== -->

        <div class="admin-form__field">

            <label
                for="ends_at"
            >
                پایان نمایش
            </label>

            <input
                id="ends_at"
                name="ends_at"
                type="datetime-local"
                value="<?= View::escape(
                    $endsAt
                ) ?>"
            >

            <small>
                خالی = بدون پایان زمان‌بندی‌شده.
            </small>

        </div>


        <!-- =================================================
             Active
        ================================================== -->

        <div
            class="
                admin-form__field
                admin-form__field--full
            "
        >

            <label class="admin-checkbox">

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    <?= $isActive
                        ? 'checked'
                        : ''
                    ?>
                >

                <span>
                    این اسلاید فعال باشد
                </span>

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
            href="<?= View::url(
                '/admin/slides'
            ) ?>"
            class="button button--secondary"
        >
            انصراف
        </a>

    </div>

</form>
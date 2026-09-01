<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


$errors =
    is_array(
        $errors
        ?? null
    )
        ? $errors
        : [];


$announcement =
    is_array(
        $announcement
        ?? null
    )
        ? $announcement
        : [];


$action =
    is_string(
        $action
        ?? null
    )
        ? $action
        : '';


$submitLabel =
    is_string(
        $submitLabel
        ?? null
    )
        ? $submitLabel
        : 'ذخیره';


$status =
    (string) (
        $announcement['status']
        ?? 'draft'
    );


?>

<form
    method="POST"
    action="<?= View::escape(
        $action
    ) ?>"
    class="admin-announcement-form"
>

    <?= Csrf::field() ?>


    <?php if (
        $errors !== []
    ): ?>

        <div
            class="admin-announcement-form-errors"
            role="alert"
        >

            <div class="admin-announcement-form-errors__title">

                <span aria-hidden="true">
                    !
                </span>

                لطفاً موارد زیر را اصلاح کنید.
            </div>


            <ul>

                <?php foreach (
                    $errors
                    as $error
                ): ?>

                    <?php if (
                        is_string($error)
                        && trim($error) !== ''
                    ): ?>

                        <li>
                            <?= View::escape(
                                $error
                            ) ?>
                        </li>

                    <?php endif; ?>

                <?php endforeach; ?>

            </ul>

        </div>

    <?php endif; ?>


    <!-- =========================================================
         BASIC INFORMATION
    ========================================================== -->

    <section class="admin-announcement-form-section">

        <div class="admin-announcement-form-section__header">

            <div>

                <span>
                    اطلاعات اصلی
                </span>

                <h2>
                    مشخصات اطلاعیه
                </h2>

            </div>

            <p>
                عنوان، آدرس و اولویت اطلاعیه را مشخص کنید.
            </p>

        </div>


        <div class="admin-announcement-form-grid">


            <!-- Title -->

            <div
                class="
                    admin-announcement-field
                    admin-announcement-field--full
                "
            >

                <label
                    for="title"
                    class="admin-announcement-field__label"
                >
                    عنوان اطلاعیه
                    <span>*</span>
                </label>


                <input
                    id="title"
                    name="title"
                    type="text"
                    class="admin-announcement-field__input"
                    value="<?= View::escape(
                        $announcement['title']
                        ?? ''
                    ) ?>"
                    maxlength="255"
                    autocomplete="off"
                    required
                >


                <?php if (
                    isset(
                        $errors['title']
                    )
                ): ?>

                    <small class="admin-announcement-field__error">
                        <?= View::escape(
                            $errors['title']
                        ) ?>
                    </small>

                <?php endif; ?>

            </div>


            <!-- Slug -->

            <div class="admin-announcement-field">

                <label
                    for="slug"
                    class="admin-announcement-field__label"
                >
                    آدرس صفحه
                </label>


                <input
                    id="slug"
                    name="slug"
                    type="text"
                    class="admin-announcement-field__input admin-announcement-field__input--ltr"
                    value="<?= View::escape(
                        $announcement['slug']
                        ?? ''
                    ) ?>"
                    maxlength="255"
                    autocomplete="off"
                    placeholder="announcement-example"
                >


                <small class="admin-announcement-field__hint">
                    در صورت خالی بودن، آدرس به‌صورت خودکار ساخته می‌شود.
                </small>


                <?php if (
                    isset(
                        $errors['slug']
                    )
                ): ?>

                    <small class="admin-announcement-field__error">
                        <?= View::escape(
                            $errors['slug']
                        ) ?>
                    </small>

                <?php endif; ?>

            </div>


            <!-- Priority -->

            <div class="admin-announcement-field">

                <label
                    for="priority"
                    class="admin-announcement-field__label"
                >
                    اولویت نمایش
                </label>


                <input
                    id="priority"
                    name="priority"
                    type="number"
                    class="admin-announcement-field__input"
                    value="<?= View::escape(
                        $announcement['priority']
                        ?? 0
                    ) ?>"
                    min="-1000"
                    max="1000"
                    step="1"
                >


                <small class="admin-announcement-field__hint">
                    عدد بزرگ‌تر باعث قرارگیری بالاتر در فهرست می‌شود.
                </small>

            </div>


            <!-- Status -->

            <div class="admin-announcement-field">

                <label
                    for="status"
                    class="admin-announcement-field__label"
                >
                    وضعیت
                    <span>*</span>
                </label>


                <select
                    id="status"
                    name="status"
                    class="admin-announcement-field__input"
                >

                    <option
                        value="draft"
                        <?= $status === 'draft'
                            ? 'selected'
                            : ''
                        ?>
                    >
                        پیش‌نویس
                    </option>


                    <option
                        value="published"
                        <?= $status === 'published'
                            ? 'selected'
                            : ''
                        ?>
                    >
                        منتشر شده
                    </option>


                    <option
                        value="archived"
                        <?= $status === 'archived'
                            ? 'selected'
                            : ''
                        ?>
                    >
                        بایگانی شده
                    </option>

                </select>

            </div>

        </div>

    </section>


    <!-- =========================================================
         SCHEDULE
    ========================================================== -->

    <section class="admin-announcement-form-section">

        <div class="admin-announcement-form-section__header">

            <div>

                <span>
                    زمان‌بندی
                </span>

                <h2>
                    انتشار و انقضا
                </h2>

            </div>

            <p>
                می‌توانید انتشار اطلاعیه را برای زمان آینده تنظیم کنید.
            </p>

        </div>


        <div class="admin-announcement-form-grid">


            <!-- Published -->

            <div class="admin-announcement-field">

                <label
                    for="published_at"
                    class="admin-announcement-field__label"
                >
                    تاریخ انتشار
                </label>


                <input
                    id="published_at"
                    name="published_at"
                    type="text"
                    dir="ltr"
                    inputmode="numeric"
                    autocomplete="off"
                    class="
                        admin-announcement-field__input
                        admin-announcement-field__input--ltr
                        <?= isset(
                            $errors['published_at']
                        )
                            ? 'admin-announcement-field__input--error'
                            : ''
                        ?>
                    "
                    value="<?= View::escape(
                        $announcement['published_at']
                        ?? ''
                    ) ?>"
                    placeholder="1405/05/31 14:05"
                    data-jalali-picker
                >


                <small class="admin-announcement-field__hint">
                    خالی = استفاده از زمان فعلی هنگام انتشار.
                </small>


                <?php if (
                    isset(
                        $errors['published_at']
                    )
                ): ?>

                    <small class="admin-announcement-field__error">
                        <?= View::escape(
                            $errors['published_at']
                        ) ?>
                    </small>

                <?php endif; ?>

            </div>


            <!-- Expires -->

            <div class="admin-announcement-field">

                <label
                    for="expires_at"
                    class="admin-announcement-field__label"
                >
                    تاریخ انقضا
                </label>


                <input
                    id="expires_at"
                    name="expires_at"
                    type="text"
                    dir="ltr"
                    inputmode="numeric"
                    autocomplete="off"
                    class="
                        admin-announcement-field__input
                        admin-announcement-field__input--ltr
                        <?= isset(
                            $errors['expires_at']
                        )
                            ? 'admin-announcement-field__input--error'
                            : ''
                        ?>
                    "
                    value="<?= View::escape(
                        $announcement['expires_at']
                        ?? ''
                    ) ?>"
                    placeholder="1405/06/31 14:05"
                    data-jalali-picker
                >


                <small class="admin-announcement-field__hint">
                    خالی = بدون تاریخ انقضا.
                </small>


                <?php if (
                    isset(
                        $errors['expires_at']
                    )
                ): ?>

                    <small class="admin-announcement-field__error">
                        <?= View::escape(
                            $errors['expires_at']
                        ) ?>
                    </small>

                <?php endif; ?>

            </div>

        </div>


        <div class="admin-announcement-schedule-note">

            <span aria-hidden="true">
                ⏱
            </span>

            <div>

                <strong>
                    اطلاعیه زمان‌بندی‌شده
                </strong>

                <p>
                    اگر تاریخ انتشار در آینده باشد، اطلاعیه در پنل مدیریت
                    قابل مشاهده خواهد بود اما تا رسیدن زمان تعیین‌شده
                    در سایت عمومی نمایش داده نمی‌شود.
                </p>

            </div>

        </div>

    </section>


    <!-- =========================================================
         CONTENT
    ========================================================== -->

    <section class="admin-announcement-form-section">

        <div class="admin-announcement-form-section__header">

            <div>

                <span>
                    محتوا
                </span>

                <h2>
                    متن اطلاعیه
                </h2>

            </div>

            <p>
                محتوایی که کاربران در صفحه اطلاعیه خواهند دید.
            </p>

        </div>


        <div class="admin-announcement-form-grid">


            <!-- Featured image -->

            <div
                class="
                    admin-announcement-field
                    admin-announcement-field--full
                "
            >

                <label
                    for="featured_image"
                    class="admin-announcement-field__label"
                >
                    تصویر شاخص
                </label>


                <input
                    id="featured_image"
                    name="featured_image"
                    type="text"
                    class="
                        admin-announcement-field__input
                        admin-announcement-field__input--ltr
                    "
                    value="<?= View::escape(
                        $announcement['featured_image']
                        ?? ''
                    ) ?>"
                    maxlength="500"
                    placeholder="/uploads/..."
                >


                <small class="admin-announcement-field__hint">
                    اختیاری است. در صورت خالی بودن هیچ تصویر پیش‌فرضی نمایش داده نمی‌شود.
                </small>

            </div>


            <!-- Excerpt -->

            <div
                class="
                    admin-announcement-field
                    admin-announcement-field--full
                "
            >

                <label
                    for="excerpt"
                    class="admin-announcement-field__label"
                >
                    خلاصه اطلاعیه
                </label>


                <textarea
                    id="excerpt"
                    name="excerpt"
                    class="admin-announcement-field__textarea"
                    rows="4"
                ><?= View::escape(
                    $announcement['excerpt']
                    ?? ''
                ) ?></textarea>


                <small class="admin-announcement-field__hint">
                    یک خلاصه کوتاه که در فهرست اطلاعیه‌ها نمایش داده می‌شود.
                </small>

            </div>


            <!-- Content -->

            <div
                class="
                    admin-announcement-field
                    admin-announcement-field--full
                "
            >

                <label
                    for="content"
                    class="admin-announcement-field__label"
                >
                    متن کامل اطلاعیه
                    <span>*</span>
                </label>


                <textarea
                    id="content"
                    name="content"
                    class="admin-announcement-field__textarea admin-announcement-field__textarea--large"
                    rows="16"
                    required
                ><?= View::escape(
                    $announcement['content']
                    ?? ''
                ) ?></textarea>


                <?php if (
                    isset(
                        $errors['content']
                    )
                ): ?>

                    <small class="admin-announcement-field__error">
                        <?= View::escape(
                            $errors['content']
                        ) ?>
                    </small>

                <?php endif; ?>

            </div>

        </div>

    </section>


    <!-- =========================================================
         ACTIONS
    ========================================================== -->

    <div class="admin-announcement-form-actions">

        <button
            type="submit"
            class="admin-announcement-form-button admin-announcement-form-button--primary"
        >
            <?= View::escape(
                $submitLabel
            ) ?>
        </button>


        <a
            href="<?= View::route(
                'admin.announcements.index'
            ) ?>"
            class="admin-announcement-form-button admin-announcement-form-button--secondary"
        >
            انصراف
        </a>

    </div>

</form>
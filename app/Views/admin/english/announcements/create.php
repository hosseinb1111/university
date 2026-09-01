<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


/*
|--------------------------------------------------------------------------
| Normalize
|--------------------------------------------------------------------------
*/

$announcement =
    is_array($announcement ?? null)
        ? $announcement
        : [];

$errors =
    is_array($errors ?? null)
        ? $errors
        : [];


/*
|--------------------------------------------------------------------------
| Values
|--------------------------------------------------------------------------
*/

$title =
    (string) (
        $announcement['title']
        ?? ''
    );

$slug =
    (string) (
        $announcement['slug']
        ?? ''
    );

$excerpt =
    (string) (
        $announcement['excerpt']
        ?? ''
    );

$content =
    (string) (
        $announcement['content']
        ?? ''
    );

$featuredImage =
    (string) (
        $announcement['featured_image']
        ?? ''
    );

$status =
    (string) (
        $announcement['status']
        ?? 'draft'
    );

$priority =
    (int) (
        $announcement['priority']
        ?? 0
    );

$publishedAt =
    (string) (
        $announcement['published_at']
        ?? ''
    );

$expiresAt =
    (string) (
        $announcement['expires_at']
        ?? ''
    );

?>

<div class="admin-page">

    <div class="english-announcement-form">


        <!-- =========================================================
             HEADER
        ========================================================== -->

        <header class="english-announcement-form__header">

            <div>

                <a
                    href="<?= View::url(
                        '/admin/english/announcements'
                    ) ?>"
                    class="english-announcement-form__back"
                >
                    <span aria-hidden="true">
                        →
                    </span>

                    بازگشت به اطلاعیه‌های انگلیسی
                </a>


                <div class="english-announcement-form__title-row">

                    <div
                        class="english-announcement-form__title-icon"
                        aria-hidden="true"
                    >
                        📢
                    </div>


                    <div>

                        <span class="english-announcement-form__eyebrow">
                            ENGLISH WEBSITE
                        </span>


                        <h1>
                            ایجاد اطلاعیه انگلیسی
                        </h1>


                        <p>
                            یک اطلاعیه جدید برای نسخه انگلیسی سایت ایجاد کنید.
                        </p>

                    </div>

                </div>

            </div>


            <div class="english-announcement-form__header-action">

                <a
                    href="<?= View::url(
                        '/english/announcements'
                    ) ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="
                        english-announcement-form__preview
                    "
                >
                    مشاهده اطلاعیه‌ها
                    <span aria-hidden="true">
                        ↗
                    </span>
                </a>

            </div>

        </header>


        <!-- =========================================================
             GENERAL ERROR
        ========================================================== -->

        <?php if (
            isset(
                $errors['general']
            )
        ): ?>

            <div
                class="
                    english-announcement-form__message
                    english-announcement-form__message--error
                "
                role="alert"
            >

                <span aria-hidden="true">
                    !
                </span>

                <?= View::escape(
                    $errors['general']
                ) ?>

            </div>

        <?php endif; ?>


        <!-- =========================================================
             FORM
        ========================================================== -->

        <form
            method="POST"
            action="<?= View::route(
                'admin.english.announcements.store'
            ) ?>"
            class="english-announcement-form__form"
        >

            <?= Csrf::field() ?>


            <!-- =====================================================
                 MAIN CONTENT
            ====================================================== -->

            <section class="english-announcement-form__card">

                <div class="english-announcement-form__card-header">

                    <span>
                        01
                    </span>

                    <div>

                        <span>
                            CONTENT
                        </span>

                        <h2>
                            محتوای اطلاعیه
                        </h2>

                        <p>
                            عنوان و متن اصلی اطلاعیه انگلیسی را وارد کنید.
                        </p>

                    </div>

                </div>


                <div class="english-announcement-form__card-body">


                    <div class="english-announcement-form__field">

                        <label for="english-announcement-title">
                            عنوان
                        </label>

                        <input
                            id="english-announcement-title"
                            type="text"
                            name="title"
                            value="<?= View::escape(
                                $title
                            ) ?>"
                            maxlength="255"
                            required
                            autofocus
                            placeholder="مثال: Registration for the New Academic Term"
                        >

                        <?php if (
                            isset(
                                $errors['title']
                            )
                        ): ?>

                            <small
                                class="
                                    english-announcement-form__field-error
                                "
                            >
                                <?= View::escape(
                                    $errors['title']
                                ) ?>
                            </small>

                        <?php else: ?>

                            <small>
                                عنوان اصلی اطلاعیه که در فهرست و صفحه جزئیات نمایش داده می‌شود.
                            </small>

                        <?php endif; ?>

                    </div>


                    <div class="english-announcement-form__field">

                        <label for="english-announcement-slug">
                            شناسه آدرس (Slug)
                        </label>

                        <input
                            id="english-announcement-slug"
                            type="text"
                            name="slug"
                            value="<?= View::escape(
                                $slug
                            ) ?>"
                            maxlength="255"
                            dir="ltr"
                            placeholder="registration-for-new-academic-term"
                        >

                        <?php if (
                            isset(
                                $errors['slug']
                            )
                        ): ?>

                            <small
                                class="
                                    english-announcement-form__field-error
                                "
                            >
                                <?= View::escape(
                                    $errors['slug']
                                ) ?>
                            </small>

                        <?php else: ?>

                            <small>
                                در صورت خالی بودن، سیستم از عنوان اطلاعیه یک Slug یکتا ایجاد می‌کند.
                            </small>

                        <?php endif; ?>

                    </div>


                    <div class="english-announcement-form__field">

                        <label for="english-announcement-excerpt">
                            خلاصه
                        </label>

                        <textarea
                            id="english-announcement-excerpt"
                            name="excerpt"
                            rows="4"
                            maxlength="5000"
                            placeholder="A short summary shown in announcement lists..."
                        ><?= View::escape(
                            $excerpt
                        ) ?></textarea>

                        <?php if (
                            isset(
                                $errors['excerpt']
                            )
                        ): ?>

                            <small
                                class="
                                    english-announcement-form__field-error
                                "
                            >
                                <?= View::escape(
                                    $errors['excerpt']
                                ) ?>
                            </small>

                        <?php else: ?>

                            <small>
                                متن کوتاهی برای معرفی اطلاعیه در صفحه فهرست.
                            </small>

                        <?php endif; ?>

                    </div>


                    <div class="english-announcement-form__field">

                        <label for="english-announcement-content">
                            متن کامل اطلاعیه
                        </label>

                        <textarea
                            id="english-announcement-content"
                            name="content"
                            rows="14"
                            maxlength="50000"
                            required
                            placeholder="Write the complete English announcement here..."
                        ><?= View::escape(
                            $content
                        ) ?></textarea>

                        <?php if (
                            isset(
                                $errors['content']
                            )
                        ): ?>

                            <small
                                class="
                                    english-announcement-form__field-error
                                "
                            >
                                <?= View::escape(
                                    $errors['content']
                                ) ?>
                            </small>

                        <?php else: ?>

                            <small>
                                متن کامل اطلاعیه در صفحه جزئیات نمایش داده می‌شود.
                            </small>

                        <?php endif; ?>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 IMAGE
            ====================================================== -->

            <section class="english-announcement-form__card">

                <div class="english-announcement-form__card-header">

                    <span>
                        02
                    </span>

                    <div>

                        <span>
                            MEDIA
                        </span>

                        <h2>
                            تصویر اطلاعیه
                        </h2>

                        <p>
                            در صورت نیاز، آدرس تصویر شاخص اطلاعیه را وارد کنید.
                        </p>

                    </div>

                </div>


                <div class="english-announcement-form__card-body">

                    <div class="english-announcement-form__field">

                        <label for="english-announcement-image">
                            آدرس تصویر
                        </label>

                        <input
                            id="english-announcement-image"
                            type="text"
                            name="featured_image"
                            value="<?= View::escape(
                                $featuredImage
                            ) ?>"
                            dir="ltr"
                            placeholder="/media/announcement.jpg"
                        >

                        <small>
                            این فیلد مطابق کنترلر فعلی یک آدرس تصویر دریافت می‌کند.
                        </small>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 PUBLICATION
            ====================================================== -->

            <section class="english-announcement-form__card">

                <div class="english-announcement-form__card-header">

                    <span>
                        03
                    </span>

                    <div>

                        <span>
                            PUBLICATION
                        </span>

                        <h2>
                            وضعیت انتشار
                        </h2>

                        <p>
                            وضعیت، اولویت و زمان‌بندی انتشار اطلاعیه را مشخص کنید.
                        </p>

                    </div>

                </div>


                <div class="english-announcement-form__card-body">

                    <div class="english-announcement-form__grid">


                        <div class="english-announcement-form__field">

                            <label
                                for="english-announcement-status"
                            >
                                وضعیت
                            </label>

                            <select
                                id="english-announcement-status"
                                name="status"
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


                        <div class="english-announcement-form__field">

                            <label
                                for="english-announcement-priority"
                            >
                                اولویت
                            </label>

                            <input
                                id="english-announcement-priority"
                                type="number"
                                name="priority"
                                value="<?= $priority ?>"
                                min="-1000"
                                max="1000"
                                step="1"
                            >

                            <small>
                                مقدار بیشتر یعنی اولویت بالاتر در فهرست.
                            </small>

                        </div>

                    </div>


                    <div class="english-announcement-form__grid">

                        <div class="english-announcement-form__field">

                            <label
                                for="english-announcement-published-at"
                            >
                                تاریخ انتشار
                            </label>

                            <input
                                id="english-announcement-published-at"
                                type="text"
                                name="published_at"
                                value="<?= View::escape(
                                    $publishedAt
                                ) ?>"
                                dir="ltr"
                                placeholder="1405/06/05 14:30"
                                autocomplete="off"
                            >

                            <?php if (
                                isset(
                                    $errors['published_at']
                                )
                            ): ?>

                                <small
                                    class="
                                        english-announcement-form__field-error
                                    "
                                >
                                    <?= View::escape(
                                        $errors['published_at']
                                    ) ?>
                                </small>

                            <?php else: ?>

                                <small>
                                    فرمت تاریخ جلالی: سال/ماه/روز ساعت:دقیقه
                                </small>

                            <?php endif; ?>

                        </div>


                        <div class="english-announcement-form__field">

                            <label
                                for="english-announcement-expires-at"
                            >
                                تاریخ انقضا
                            </label>

                            <input
                                id="english-announcement-expires-at"
                                type="text"
                                name="expires_at"
                                value="<?= View::escape(
                                    $expiresAt
                                ) ?>"
                                dir="ltr"
                                placeholder="1405/07/01 23:59"
                                autocomplete="off"
                            >

                            <?php if (
                                isset(
                                    $errors['expires_at']
                                )
                            ): ?>

                                <small
                                    class="
                                        english-announcement-form__field-error
                                    "
                                >
                                    <?= View::escape(
                                        $errors['expires_at']
                                    ) ?>
                                </small>

                            <?php else: ?>

                                <small>
                                    اختیاری؛ در صورت تعیین، باید بعد از تاریخ انتشار باشد.
                                </small>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 SAVE BAR
            ====================================================== -->

            <div class="english-announcement-form__savebar">

                <div>

                    <strong>
                        آماده ذخیره اطلاعیه هستید؟
                    </strong>

                    <span>
                        می‌توانید بعداً آن را ویرایش یا منتشر کنید.
                    </span>

                </div>


                <div class="english-announcement-form__save-actions">

                    <a
                        href="<?= View::url(
                            '/admin/english/announcements'
                        ) ?>"
                        class="english-announcement-form__cancel"
                    >
                        انصراف
                    </a>


                    <button
                        type="submit"
                        class="english-announcement-form__save"
                    >
                        <span aria-hidden="true">
                            ✓
                        </span>

                        ایجاد اطلاعیه
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>
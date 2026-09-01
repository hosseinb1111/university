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

$id =
    (int) (
        $announcement['id']
        ?? 0
    );

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

$createdAt =
    (string) (
        $announcement['created_at']
        ?? ''
    );

$updatedAt =
    (string) (
        $announcement['updated_at']
        ?? ''
    );

$publicUrl =
    $slug !== ''
        ? View::url(
            '/english/announcements/'
            . rawurlencode(
                $slug
            )
        )
        : View::url(
            '/english/announcements'
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
                        ✎
                    </div>


                    <div>

                        <span class="english-announcement-form__eyebrow">
                            ENGLISH WEBSITE
                        </span>


                        <h1>
                            ویرایش اطلاعیه انگلیسی
                        </h1>


                        <p>
                            اطلاعات اطلاعیه را اصلاح و تغییرات را ذخیره کنید.
                        </p>

                    </div>

                </div>

            </div>


            <div class="english-announcement-form__header-action">

                <a
                    href="<?= View::escape(
                        $publicUrl
                    ) ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="
                        english-announcement-form__preview
                    "
                >
                    مشاهده اطلاعیه
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
                'admin.english.announcements.update',
                [
                    'id' =>
                        $id,
                ]
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
                            عنوان، Slug و متن اصلی اطلاعیه انگلیسی را مدیریت کنید.
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
                                این مقدار در URL عمومی اطلاعیه استفاده می‌شود.
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
                        ><?= View::escape(
                            $excerpt
                        ) ?></textarea>

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
                            آدرس تصویر شاخص اطلاعیه را مدیریت کنید.
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
                        >

                        <?php if (
                            trim($featuredImage) !== ''
                        ): ?>

                            <div
                                class="
                                    english-announcement-form__image-preview
                                "
                            >

                                <span>
                                    تصویر فعلی
                                </span>


                                <img
                                    src="<?= View::escape(
                                        $featuredImage
                                    ) ?>"
                                    alt="<?= View::escape(
                                        $title
                                    ) ?>"
                                    loading="lazy"
                                >

                            </div>

                        <?php endif; ?>

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
                            وضعیت فعلی و زمان‌بندی این اطلاعیه را مدیریت کنید.
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

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            </section>


            <!-- =====================================================
                 RECORD INFORMATION
            ====================================================== -->

            <section class="english-announcement-form__meta">

                <div>

                    <span>
                        شناسه رکورد
                    </span>

                    <strong>
                        #<?= $id ?>
                    </strong>

                </div>


                <?php if (
                    $createdAt !== ''
                ): ?>

                    <div>

                        <span>
                            ایجاد شده
                        </span>

                        <strong>
                            <?= View::escape(
                                $createdAt
                            ) ?>
                        </strong>

                    </div>

                <?php endif; ?>


                <?php if (
                    $updatedAt !== ''
                ): ?>

                    <div>

                        <span>
                            آخرین ویرایش
                        </span>

                        <strong>
                            <?= View::escape(
                                $updatedAt
                            ) ?>
                        </strong>

                    </div>

                <?php endif; ?>

            </section>


            <!-- =====================================================
                 ACTIONS
            ====================================================== -->

            <div class="english-announcement-form__savebar">

                <div>

                    <strong>
                        ذخیره تغییرات
                    </strong>

                    <span>
                        تغییرات پس از ذخیره در نسخه انگلیسی سایت اعمال می‌شوند.
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

                        ذخیره تغییرات
                    </button>

                </div>

            </div>

        </form>


        <!-- =========================================================
             QUICK ACTIONS
        ========================================================== -->

        <div class="english-announcement-form__quick-actions">

            <?php if (
                $status !== 'published'
            ): ?>

                <form
                    method="POST"
                    action="<?= View::route(
                        'admin.english.announcements.publish',
                        [
                            'id' =>
                                $id,
                        ]
                    ) ?>"
                    onsubmit="return confirm('آیا از انتشار این اطلاعیه مطمئن هستید؟');"
                >

                    <?= Csrf::field() ?>

                    <button
                        type="submit"
                        class="
                            english-announcement-form__quick-button
                            english-announcement-form__quick-button--publish
                        "
                    >
                        انتشار مستقیم
                    </button>

                </form>

            <?php endif; ?>


            <?php if (
                $status === 'published'
            ): ?>

                <form
                    method="POST"
                    action="<?= View::route(
                        'admin.english.announcements.archive',
                        [
                            'id' =>
                                $id,
                        ]
                    ) ?>"
                    onsubmit="return confirm('آیا از بایگانی این اطلاعیه مطمئن هستید؟');"
                >

                    <?= Csrf::field() ?>

                    <button
                        type="submit"
                        class="
                            english-announcement-form__quick-button
                            english-announcement-form__quick-button--archive
                        "
                    >
                        بایگانی
                    </button>

                </form>

            <?php endif; ?>


            <form
                method="POST"
                action="<?= View::route(
                    'admin.english.announcements.delete',
                    [
                        'id' =>
                            $id,
                    ]
                ) ?>"
                onsubmit="return confirm('آیا از حذف این اطلاعیه مطمئن هستید؟ این عملیات قابل بازگشت نیست.');"
            >

                <?= Csrf::field() ?>

                <button
                    type="submit"
                    class="
                        english-announcement-form__quick-button
                        english-announcement-form__quick-button--delete
                    "
                >
                    حذف اطلاعیه
                </button>

            </form>

        </div>

    </div>

</div>
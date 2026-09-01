<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;

$errors =
    is_array(
        $errors ?? null
    )
        ? $errors
        : [];

$page =
    is_array(
        $page ?? null
    )
        ? $page
        : [];

$parents =
    is_array(
        $parents ?? null
    )
        ? $parents
        : [];

$action =
    (string) (
        $action
        ?? ''
    );

$submitLabel =
    (string) (
        $submitLabel
        ?? 'ذخیره'
    );

$status =
    (string) (
        $page['status']
        ?? 'draft'
    );

/*
 * Database stores Gregorian DATETIME.
 *
 * Admin interface displays Jalali.
 *
 * The value passed to jalali_date_fa() must remain
 * the original Gregorian database string.
 */
$publishedAt = '';

if (
    !empty(
        $page['published_at']
        ?? null
    )
) {
    $publishedAt =
        jalali_date_fa(
            (string) $page['published_at'],
            'Y/m/d H:i'
        );
}
?>

<form
    method="POST"
    action="<?= View::escape(
        $action
    ) ?>"
    class="admin-pages__form"
>

    <?= Csrf::field() ?>


    <?php if (
        $errors !== []
    ): ?>

        <div
            class="
                admin-pages__alert
                admin-pages__alert--error
            "
            role="alert"
        >

            <div>

                <strong>
                    لطفاً موارد زیر را اصلاح کنید:
                </strong>

                <ul>

                    <?php foreach (
                        $errors
                        as $key => $error
                    ): ?>

                        <?php if (
                            is_array($error)
                        ): ?>

                            <?php foreach (
                                $error
                                as $nestedError
                            ): ?>

                                <li>
                                    <?= View::escape(
                                        (string) $nestedError
                                    ) ?>
                                </li>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <li>
                                <?= View::escape(
                                    (string) $error
                                ) ?>
                            </li>

                        <?php endif; ?>

                    <?php endforeach; ?>

                </ul>

            </div>

        </div>

    <?php endif; ?>


    <div class="admin-pages__form-grid">


        <!-- Title -->

        <div
            class="
                admin-pages__field
                admin-pages__field--full
            "
        >

            <label
                for="title"
            >
                عنوان صفحه
            </label>

            <input
                id="title"
                name="title"
                type="text"
                value="<?= View::escape(
                    $page['title']
                    ?? ''
                ) ?>"
                maxlength="255"
                required
            >

            <?php if (
                isset(
                    $errors['title']
                )
            ): ?>

                <small
                    class="admin-pages__field-error"
                >
                    <?= View::escape(
                        (string) $errors['title']
                    ) ?>
                </small>

            <?php endif; ?>

        </div>


        <!-- Slug -->

        <div class="admin-pages__field">

            <label
                for="slug"
            >
                آدرس صفحه
            </label>

            <input
                id="slug"
                name="slug"
                type="text"
                value="<?= View::escape(
                    $page['slug']
                    ?? ''
                ) ?>"
                maxlength="255"
                placeholder="about"
                required
                dir="ltr"
            >

            <?php if (
                isset(
                    $errors['slug']
                )
            ): ?>

                <small
                    class="admin-pages__field-error"
                >
                    <?= View::escape(
                        (string) $errors['slug']
                    ) ?>
                </small>

            <?php endif; ?>

        </div>


        <!-- Parent -->

        <div class="admin-pages__field">

            <label
                for="parent_id"
            >
                صفحه والد
            </label>

            <select
                id="parent_id"
                name="parent_id"
            >

                <option value="">
                    بدون والد
                </option>

                <?php foreach (
                    $parents
                    as $parent
                ): ?>

                    <option
                        value="<?= (int) $parent['id'] ?>"
                        <?= (
                            (string) (
                                $page['parent_id']
                                ?? ''
                            )
                            ===
                            (string) (
                                $parent['id']
                                ?? ''
                            )
                        )
                            ? 'selected'
                            : ''
                        ?>
                    >
                        <?= View::escape(
                            (string) (
                                $parent['title']
                                ?? ''
                            )
                        ) ?>
                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <!-- Status -->

        <div class="admin-pages__field">

            <label
                for="status"
            >
                وضعیت
            </label>

            <select
                id="status"
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
                    value="private"
                    <?= $status === 'private'
                        ? 'selected'
                        : ''
                    ?>
                >
                    خصوصی
                </option>

            </select>

        </div>


        <!-- Published At -->

        <div class="admin-pages__field">

            <label
                for="published_at"
            >
                تاریخ انتشار
            </label>

            <div
                class="admin-pages__date-field"
            >

                <input
                    id="published_at"
                    name="published_at"
                    type="text"
                    value="<?= View::escape(
                        $publishedAt
                    ) ?>"
                    inputmode="numeric"
                    autocomplete="off"
                    dir="ltr"
                    placeholder="۱۴۰۵/۰۶/۰۵ ۱۱:۱۴"
                    maxlength="16"
                    data-jalali-picker
                    data-jalali-time="1"
                >

            </div>

            <small>
                تاریخ انتشار را با تقویم شمسی انتخاب کنید.
                در صورت نیاز می‌توانید تاریخ را به صورت دستی نیز وارد کنید.
            </small>

            <?php if (
                isset(
                    $errors['published_at']
                )
            ): ?>

                <small
                    class="admin-pages__field-error"
                >
                    <?= View::escape(
                        (string) $errors['published_at']
                    ) ?>
                </small>

            <?php endif; ?>

        </div>


        <!-- Featured Image -->

        <div
            class="
                admin-pages__field
                admin-pages__field--full
            "
        >

            <label
                for="featured_image"
            >
                تصویر شاخص
            </label>

            <input
                id="featured_image"
                name="featured_image"
                type="text"
                value="<?= View::escape(
                    $page['featured_image']
                    ?? ''
                ) ?>"
                maxlength="500"
                placeholder="/media/example.webp"
                dir="ltr"
            >

            <small>
                مسیر یا آدرس تصویر شاخص صفحه را وارد کنید.
            </small>

        </div>


        <!-- Excerpt -->

        <div
            class="
                admin-pages__field
                admin-pages__field--full
            "
        >

            <label
                for="excerpt"
            >
                خلاصه صفحه
            </label>

            <textarea
                id="excerpt"
                name="excerpt"
                rows="5"
            ><?= View::escape(
                $page['excerpt']
                ?? ''
            ) ?></textarea>

            <small>
                خلاصه کوتاهی برای معرفی صفحه و استفاده‌های احتمالی در لیست‌ها.
            </small>

        </div>


        <!-- Content -->

        <div
            class="
                admin-pages__field
                admin-pages__field--full
            "
        >

            <label
                for="content"
            >
                محتوای صفحه
            </label>

            <textarea
                id="content"
                name="content"
                rows="18"
            ><?= View::escape(
                $page['content']
                ?? ''
            ) ?></textarea>

            <small>
                محتوای اصلی صفحه را در این بخش وارد کنید.
            </small>

        </div>

    </div>


    <!-- SEO -->

    <section class="admin-pages__section">

        <header class="admin-pages__section-header">

            <div
                class="admin-pages__section-icon"
                aria-hidden="true"
            >
                ⚙
            </div>

            <div>

                <h2>
                    تنظیمات SEO
                </h2>

                <p>
                    اطلاعاتی که برای موتورهای جستجو استفاده می‌شود.
                </p>

            </div>

        </header>


        <div class="admin-pages__form-grid">


            <div
                class="
                    admin-pages__field
                    admin-pages__field--full
                "
            >

                <label
                    for="seo_title"
                >
                    عنوان SEO
                </label>

                <input
                    id="seo_title"
                    name="seo_title"
                    type="text"
                    value="<?= View::escape(
                        $page['seo_title']
                        ?? ''
                    ) ?>"
                    maxlength="255"
                >

            </div>


            <div
                class="
                    admin-pages__field
                    admin-pages__field--full
                "
            >

                <label
                    for="seo_description"
                >
                    توضیحات SEO
                </label>

                <textarea
                    id="seo_description"
                    name="seo_description"
                    rows="5"
                ><?= View::escape(
                    $page['seo_description']
                    ?? ''
                ) ?></textarea>

            </div>


            <div
                class="
                    admin-pages__field
                    admin-pages__field--full
                "
            >

                <label
                    for="seo_keywords"
                >
                    کلمات کلیدی
                </label>

                <input
                    id="seo_keywords"
                    name="seo_keywords"
                    type="text"
                    value="<?= View::escape(
                        $page['seo_keywords']
                        ?? ''
                    ) ?>"
                    maxlength="1000"
                    placeholder="صدرا، دانشگاه، آموزش عالی"
                >

            </div>

        </div>

    </section>


    <!-- Actions -->

    <div class="admin-pages__form-actions">

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
                'admin.pages.index'
            ) ?>"
            class="button button--secondary"
        >
            انصراف
        </a>

    </div>

</form>
<?php

declare(strict_types=1);

$errors = $errors ?? [];

$announcement = $announcement ?? [];

$action = $action ?? '';
$submitLabel = $submitLabel ?? 'ذخیره';
?>

<form
    method="POST"
    action="<?= View::escape($action) ?>"
    class="admin-form"
>

    <?= \App\Core\Csrf::field() ?>


    <?php if ($errors !== []): ?>

        <div
            class="form-errors"
            role="alert"
        >

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

        <div class="form-field form-field--full">

            <label
                for="title"
                class="form-field__label"
            >
                عنوان اطلاعیه
            </label>

            <input
                id="title"
                name="title"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $announcement['title']
                    ?? ''
                ) ?>"
                maxlength="255"
                required
            >

            <?php if (
                isset($errors['title'])
            ): ?>

                <small class="form-field__error">
                    <?= View::escape(
                        $errors['title']
                    ) ?>
                </small>

            <?php endif; ?>

        </div>


        <div class="form-field">

            <label
                for="slug"
                class="form-field__label"
            >
                آدرس صفحه
            </label>

            <input
                id="slug"
                name="slug"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $announcement['slug']
                    ?? ''
                ) ?>"
                maxlength="255"
                placeholder="مثلاً registration-semester-1405"
            >

            <?php if (
                isset($errors['slug'])
            ): ?>

                <small class="form-field__error">
                    <?= View::escape(
                        $errors['slug']
                    ) ?>
                </small>

            <?php endif; ?>

        </div>


        <div class="form-field">

            <label
                for="priority"
                class="form-field__label"
            >
                اولویت
            </label>

            <input
                id="priority"
                name="priority"
                type="number"
                class="form-field__input"
                value="<?= View::escape(
                    $announcement['priority']
                    ?? 0
                ) ?>"
                min="-1000"
                max="1000"
            >

        </div>


        <div class="form-field">

            <label
                for="status"
                class="form-field__label"
            >
                وضعیت
            </label>

            <select
                id="status"
                name="status"
                class="form-field__input"
            >

                <option
                    value="draft"
                    <?= (
                        ($announcement['status'] ?? 'draft')
                        === 'draft'
                    )
                        ? 'selected'
                        : ''
                    ?>
                >
                    پیش‌نویس
                </option>

                <option
                    value="published"
                    <?= (
                        ($announcement['status'] ?? '')
                        === 'published'
                    )
                        ? 'selected'
                        : ''
                    ?>
                >
                    منتشر شده
                </option>

                <option
                    value="archived"
                    <?= (
                        ($announcement['status'] ?? '')
                        === 'archived'
                    )
                        ? 'selected'
                        : ''
                    ?>
                >
                    بایگانی شده
                </option>

            </select>

        </div>


        <div class="form-field">

            <label
                for="published_at"
                class="form-field__label"
            >
                تاریخ انتشار
            </label>

            <input
                id="published_at"
                name="published_at"
                type="datetime-local"
                class="form-field__input"
                value="<?= View::escape(
    !empty($announcement['published_at'])
        ? date(
            'Y-m-d\TH:i',
            strtotime(
                $announcement['published_at']
            )
        )
        : ''
) ?>"
            >

        </div>


        <div class="form-field">

            <label
                for="expires_at"
                class="form-field__label"
            >
                تاریخ انقضا
            </label>

            <input
                id="expires_at"
                name="expires_at"
                type="datetime-local"
                class="form-field__input"
                value="<?= View::escape(
    !empty($announcement['expires_at'])
        ? date(
            'Y-m-d\TH:i',
            strtotime(
                $announcement['expires_at']
            )
        )
        : ''
) ?>"
            >

        </div>


        <div class="form-field form-field--full">

            <label
                for="featured_image"
                class="form-field__label"
            >
                تصویر شاخص
            </label>

            <input
                id="featured_image"
                name="featured_image"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $announcement['featured_image']
                    ?? ''
                ) ?>"
                maxlength="500"
                placeholder="/uploads/..."
            >

        </div>


        <div class="form-field form-field--full">

            <label
                for="excerpt"
                class="form-field__label"
            >
                خلاصه
            </label>

            <textarea
                id="excerpt"
                name="excerpt"
                class="form-field__textarea"
                rows="4"
            ><?= View::escape(
                $announcement['excerpt']
                ?? ''
            ) ?></textarea>

        </div>


        <div class="form-field form-field--full">

            <label
                for="content"
                class="form-field__label"
            >
                متن اطلاعیه
            </label>

            <textarea
                id="content"
                name="content"
                class="form-field__textarea"
                rows="16"
                required
            ><?= View::escape(
                $announcement['content']
                ?? ''
            ) ?></textarea>

            <?php if (
                isset($errors['content'])
            ): ?>

                <small class="form-field__error">
                    <?= View::escape(
                        $errors['content']
                    ) ?>
                </small>

            <?php endif; ?>

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
                'admin.announcements.index'
            ) ?>"
            class="button button--secondary"
        >
            انصراف
        </a>

    </div>

</form>
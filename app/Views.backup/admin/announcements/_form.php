<?php
declare(strict_types=1);

use App\Core\View;
$errors = $errors ?? [];

$announcement = $announcement ?? [];

$action = $action ?? '';
$submitLabel = $submitLabel ?? 'Ø°Ø®ÛŒØ±Ù‡';
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
                Ù„Ø·ÙØ§Ù‹ Ù…ÙˆØ§Ø±Ø¯ Ø²ÛŒØ± Ø±Ø§ Ø§ØµÙ„Ø§Ø­ Ú©Ù†ÛŒØ¯:
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
                Ø¹Ù†ÙˆØ§Ù† Ø§Ø·Ù„Ø§Ø¹ÛŒÙ‡
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
                Ø¢Ø¯Ø±Ø³ ØµÙØ­Ù‡
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
                placeholder="Ù…Ø«Ù„Ø§Ù‹ registration-semester-1405"
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
                Ø§ÙˆÙ„ÙˆÛŒØª
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
                ÙˆØ¶Ø¹ÛŒØª
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
                    Ù¾ÛŒØ´â€ŒÙ†ÙˆÛŒØ³
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
                    Ù…Ù†ØªØ´Ø± Ø´Ø¯Ù‡
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
                    Ø¨Ø§ÛŒÚ¯Ø§Ù†ÛŒ Ø´Ø¯Ù‡
                </option>

            </select>

        </div>


        <div class="form-field">

            <label
                for="published_at"
                class="form-field__label"
            >
                ØªØ§Ø±ÛŒØ® Ø§Ù†ØªØ´Ø§Ø±
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
                ØªØ§Ø±ÛŒØ® Ø§Ù†Ù‚Ø¶Ø§
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
                ØªØµÙˆÛŒØ± Ø´Ø§Ø®Øµ
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
                Ø®Ù„Ø§ØµÙ‡
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
                Ù…ØªÙ† Ø§Ø·Ù„Ø§Ø¹ÛŒÙ‡
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
            Ø§Ù†ØµØ±Ø§Ù
        </a>

    </div>

</form>

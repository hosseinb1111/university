<?php
declare(strict_types=1);

use App\Core\View;
$errors = $errors ?? [];

$page = $page ?? [];

$parents = $parents ?? [];

$action = $action ?? '';

$submitLabel =
    $submitLabel ?? 'Ø°Ø®ÛŒØ±Ù‡';
?>

<form
    method="POST"
    action="<?= View::escape(
        $action
    ) ?>"
    class="admin-form"
>

    <?= \App\Core\Csrf::field() ?>


    <?php if (
        $errors !== []
    ): ?>

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
                Ø¹Ù†ÙˆØ§Ù† ØµÙØ­Ù‡
            </label>

            <input
                id="title"
                name="title"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $page['title'] ?? ''
                ) ?>"
                maxlength="255"
                required
            >

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
                    $page['slug'] ?? ''
                ) ?>"
                maxlength="255"
                placeholder="Ù…Ø«Ù„Ø§Ù‹ about"
                required
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
                for="parent_id"
                class="form-field__label"
            >
                ØµÙØ­Ù‡ ÙˆØ§Ù„Ø¯
            </label>

            <select
                id="parent_id"
                name="parent_id"
                class="form-field__input"
            >

                <option value="">
                    Ø¨Ø¯ÙˆÙ† ÙˆØ§Ù„Ø¯
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
                            === (string) $parent['id']
                        )
                            ? 'selected'
                            : ''
                        ?>
                    >
                        <?= View::escape(
                            $parent['title']
                        ) ?>
                    </option>

                <?php endforeach; ?>

            </select>

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
                        ($page['status']
                        ?? 'draft')
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
                        ($page['status']
                        ?? '')
                        === 'published'
                    )
                        ? 'selected'
                        : ''
                    ?>
                >
                    Ù…Ù†ØªØ´Ø± Ø´Ø¯Ù‡
                </option>

                <option
                    value="private"
                    <?= (
                        ($page['status']
                        ?? '')
                        === 'private'
                    )
                        ? 'selected'
                        : ''
                    ?>
                >
                    Ø®ØµÙˆØµÛŒ
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
                    !empty(
                        $page['published_at']
                    )
                        ? date(
                            'Y-m-d\TH:i',
                            strtotime(
                                $page['published_at']
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
                    $page['featured_image']
                    ?? ''
                ) ?>"
                maxlength="500"
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
                $page['excerpt'] ?? ''
            ) ?></textarea>

        </div>


        <div class="form-field form-field--full">

            <label
                for="content"
                class="form-field__label"
            >
                Ù…Ø­ØªÙˆØ§ÛŒ ØµÙØ­Ù‡
            </label>

            <textarea
                id="content"
                name="content"
                class="form-field__textarea"
                rows="18"
            ><?= View::escape(
                $page['content'] ?? ''
            ) ?></textarea>

        </div>

    </div>


    <div
        style="
            margin-top:32px;
            padding-top:28px;
            border-top:1px solid #e2e8f0;
        "
    >

        <h2
            style="
                margin:0 0 20px;
                font-size:18px;
            "
        >
            ØªÙ†Ø¸ÛŒÙ…Ø§Øª SEO
        </h2>


        <div class="form-grid">

            <div class="form-field form-field--full">

                <label
                    for="seo_title"
                    class="form-field__label"
                >
                    Ø¹Ù†ÙˆØ§Ù† SEO
                </label>

                <input
                    id="seo_title"
                    name="seo_title"
                    type="text"
                    class="form-field__input"
                    value="<?= View::escape(
                        $page['seo_title'] ?? ''
                    ) ?>"
                    maxlength="255"
                >

            </div>


            <div class="form-field form-field--full">

                <label
                    for="seo_description"
                    class="form-field__label"
                >
                    ØªÙˆØ¶ÛŒØ­Ø§Øª SEO
                </label>

                <textarea
                    id="seo_description"
                    name="seo_description"
                    class="form-field__textarea"
                    rows="4"
                ><?= View::escape(
                    $page['seo_description']
                    ?? ''
                ) ?></textarea>

            </div>


            <div class="form-field form-field--full">

                <label
                    for="seo_keywords"
                    class="form-field__label"
                >
                    Ú©Ù„Ù…Ø§Øª Ú©Ù„ÛŒØ¯ÛŒ
                </label>

                <input
                    id="seo_keywords"
                    name="seo_keywords"
                    type="text"
                    class="form-field__input"
                    value="<?= View::escape(
                        $page['seo_keywords']
                        ?? ''
                    ) ?>"
                    maxlength="1000"
                >

            </div>

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
                'admin.pages.index'
            ) ?>"
            class="button button--secondary"
        >
            Ø§Ù†ØµØ±Ø§Ù
        </a>

    </div>

</form>

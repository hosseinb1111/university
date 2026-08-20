<?php

declare(strict_types=1);

$item = $item ?? [];

$parents = $parents ?? [];

$pages = $pages ?? [];

$errors = $errors ?? [];

$action = $action ?? '';

$submitLabel =
    $submitLabel ?? 'ذخیره';
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
                عنوان
            </label>

            <input
                id="title"
                name="title"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $item['title']
                    ?? ''
                ) ?>"
                maxlength="255"
                required
            >

        </div>


        <div class="form-field">

            <label
                for="parent_id"
                class="form-field__label"
            >
                آیتم والد
            </label>

            <select
                id="parent_id"
                name="parent_id"
                class="form-field__input"
            >

                <option value="">
                    منوی اصلی
                </option>

                <?php foreach (
                    $parents
                    as $parent
                ): ?>

                    <option
                        value="<?= (int) $parent['id'] ?>"
                        <?= (
                            (string) (
                                $item['parent_id']
                                ?? ''
                            )
                            === (string) (
                                $parent['id']
                            )
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
                for="page_id"
                class="form-field__label"
            >
                صفحه مقصد
            </label>

            <select
                id="page_id"
                name="page_id"
                class="form-field__input"
            >

                <option value="">
                    بدون صفحه
                </option>

                <?php foreach (
                    $pages
                    as $page
                ): ?>

                    <option
                        value="<?= (int) $page['id'] ?>"
                        <?= (
                            (string) (
                                $item['page_id']
                                ?? ''
                            )
                            === (string) (
                                $page['id']
                            )
                        )
                            ? 'selected'
                            : ''
                        ?>
                    >
                        <?= View::escape(
                            $page['title']
                        ) ?>
                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <div class="form-field form-field--full">

            <label
                for="url"
                class="form-field__label"
            >
                یا آدرس مستقیم
            </label>

            <input
                id="url"
                name="url"
                type="text"
                class="form-field__input"
                value="<?= View::escape(
                    $item['url']
                    ?? ''
                ) ?>"
                maxlength="500"
                placeholder="https://example.com یا /contact"
            >

            <?php if (
                isset(
                    $errors['destination']
                )
            ): ?>

                <small class="form-field__error">
                    <?= View::escape(
                        $errors['destination']
                    ) ?>
                </small>

            <?php endif; ?>

        </div>


        <div class="form-field">

            <label
                for="target"
                class="form-field__label"
            >
                نحوه باز شدن
            </label>

            <select
                id="target"
                name="target"
                class="form-field__input"
            >

                <option
                    value="_self"
                    <?= (
                        ($item['target']
                        ?? '_self')
                        === '_self'
                    )
                        ? 'selected'
                        : ''
                    ?>
                >
                    همین صفحه
                </option>

                <option
                    value="_blank"
                    <?= (
                        ($item['target']
                        ?? '')
                        === '_blank'
                    )
                        ? 'selected'
                        : ''
                    ?>
                >
                    تب جدید
                </option>

            </select>

        </div>


        <div class="form-field">

            <label
                for="sort_order"
                class="form-field__label"
            >
                ترتیب
            </label>

            <input
                id="sort_order"
                name="sort_order"
                type="number"
                class="form-field__input"
                value="<?= View::escape(
                    $item['sort_order']
                    ?? 0
                ) ?>"
                min="-10000"
                max="10000"
            >

        </div>


        <div class="form-field">

            <label
                for="is_active"
                class="form-field__label"
            >
                وضعیت
            </label>

            <label
                style="
                    display:flex;
                    align-items:center;
                    gap:8px;
                    min-height:46px;
                "
            >

                <input
                    id="is_active"
                    name="is_active"
                    type="checkbox"
                    value="1"
                    <?= (
                        (int) (
                            $item['is_active']
                            ?? 1
                        ) === 1
                    )
                        ? 'checked'
                        : ''
                    ?>
                >

                فعال باشد

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
            href="<?= View::route(
                'admin.navigation.index'
            ) ?>"
            class="button button--secondary"
        >
            انصراف
        </a>

    </div>

</form>
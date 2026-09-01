<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;

$faculty =
    is_array($faculty ?? null)
        ? $faculty
        : [];

$errors =
    is_array($errors ?? null)
        ? $errors
        : [];

$action =
    is_string($action ?? null)
        ? $action
        : '';

$submitLabel =
    is_string($submitLabel ?? null)
        ? $submitLabel
        : 'ذخیره';
?>

<form
    method="POST"
    action="<?= View::escape(
        $action
    ) ?>"
    class="faculty-admin-form"
>

    <?= Csrf::field() ?>


    <?php if (
        $errors !== []
    ): ?>

        <div class="faculty-admin-form__errors">

            <div
                class="faculty-admin-form__errors-icon"
                aria-hidden="true"
            >
                !
            </div>

            <div>

                <strong>
                    لطفاً موارد زیر را اصلاح کنید.
                </strong>

                <ul>

                    <?php foreach (
                        $errors
                        as $field => $message
                    ): ?>

                        <li>
                            <?= View::escape(
                                (string) $message
                            ) ?>
                        </li>

                    <?php endforeach; ?>

                </ul>

            </div>

        </div>

    <?php endif; ?>


    <div class="faculty-admin-form__grid">

        <div class="faculty-admin-form__field">

            <label for="name">
                نام دانشکده
                <span>*</span>
            </label>

            <input
                id="name"
                name="name"
                type="text"
                value="<?= View::escape(
                    $faculty['name']
                    ?? ''
                ) ?>"
                maxlength="255"
                required
                autocomplete="organization"
                placeholder="مثلاً دانشکده مهندسی کامپیوتر"
            >

            <?php if (
                isset(
                    $errors['name']
                )
            ): ?>

                <small class="faculty-admin-form__error">
                    <?= View::escape(
                        $errors['name']
                    ) ?>
                </small>

            <?php endif; ?>

        </div>


        <div class="faculty-admin-form__field">

            <label for="short_name">
                نام کوتاه
            </label>

            <input
                id="short_name"
                name="short_name"
                type="text"
                value="<?= View::escape(
                    $faculty['short_name']
                    ?? ''
                ) ?>"
                maxlength="100"
                placeholder="مثلاً فنی"
            >

            <small>
                نام کوتاه برای استفاده در بخش‌های فشرده سایت.
            </small>

        </div>


        <div class="faculty-admin-form__field">

            <label for="slug">
                شناسه URL
            </label>

            <div class="faculty-admin-form__input-prefix">

                <span dir="ltr">
                    /faculties/
                </span>

                <input
                    id="slug"
                    name="slug"
                    type="text"
                    value="<?= View::escape(
                        $faculty['slug']
                        ?? ''
                    ) ?>"
                    maxlength="255"
                    dir="ltr"
                    placeholder="computer-engineering"
                >

            </div>

            <?php if (
                isset(
                    $errors['slug']
                )
            ): ?>

                <small class="faculty-admin-form__error">
                    <?= View::escape(
                        $errors['slug']
                    ) ?>
                </small>

            <?php else: ?>

                <small>
                    در صورت خالی بودن، شناسه از روی نام دانشکده ساخته می‌شود.
                </small>

            <?php endif; ?>

        </div>


        <div
            class="faculty-admin-form__field faculty-admin-form__field--full"
        >

            <label for="description">
                معرفی دانشکده
            </label>

            <textarea
                id="description"
                name="description"
                rows="7"
                placeholder="توضیح مختصری درباره دانشکده، گروه‌های آموزشی و زمینه فعالیت آن بنویسید."
            ><?= View::escape(
                $faculty['description']
                ?? ''
            ) ?></textarea>

        </div>


        <div class="faculty-admin-form__field">

            <label for="email">
                ایمیل
            </label>

            <input
                id="email"
                name="email"
                type="email"
                value="<?= View::escape(
                    $faculty['email']
                    ?? ''
                ) ?>"
                autocomplete="email"
                placeholder="faculty@example.com"
            >

            <?php if (
                isset(
                    $errors['email']
                )
            ): ?>

                <small class="faculty-admin-form__error">
                    <?= View::escape(
                        $errors['email']
                    ) ?>
                </small>

            <?php endif; ?>

        </div>


        <div class="faculty-admin-form__field">

            <label for="phone">
                تلفن
            </label>

            <input
                id="phone"
                name="phone"
                type="text"
                value="<?= View::escape(
                    $faculty['phone']
                    ?? ''
                ) ?>"
                placeholder="۰۲۱-..."
            >

        </div>


        <div class="faculty-admin-form__field">

            <label for="fax">
                فکس
            </label>

            <input
                id="fax"
                name="fax"
                type="text"
                value="<?= View::escape(
                    $faculty['fax']
                    ?? ''
                ) ?>"
                placeholder="۰۲۱-..."
            >

        </div>


        <div class="faculty-admin-form__field">

            <label for="sort_order">
                ترتیب نمایش
            </label>

            <input
                id="sort_order"
                name="sort_order"
                type="number"
                min="0"
                value="<?= View::escape(
                    $faculty['sort_order']
                    ?? 0
                ) ?>"
            >

            <small>
                عدد کمتر، جایگاه بالاتری در ترتیب نمایش خواهد داشت.
            </small>

        </div>


        <div
            class="faculty-admin-form__field faculty-admin-form__field--full"
        >

            <label for="address">
                آدرس
            </label>

            <textarea
                id="address"
                name="address"
                rows="3"
                placeholder="آدرس کامل دانشکده"
            ><?= View::escape(
                $faculty['address']
                ?? ''
            ) ?></textarea>

        </div>


        <div
            class="faculty-admin-form__field faculty-admin-form__field--full"
        >

            <label for="image">
                تصویر دانشکده
            </label>

            <input
                id="image"
                name="image"
                type="text"
                value="<?= View::escape(
                    $faculty['image']
                    ?? ''
                ) ?>"
                maxlength="500"
                dir="ltr"
                placeholder="/media/faculties/example.jpg"
            >

            <small>
                مسیر داخلی فایل یا آدرس کامل تصویر را وارد کنید.
            </small>

            <?php if (
                isset(
                    $errors['image']
                )
            ): ?>

                <small class="faculty-admin-form__error">
                    <?= View::escape(
                        $errors['image']
                    ) ?>
                </small>

            <?php endif; ?>

        </div>

    </div>


    <div class="faculty-admin-form__settings">

        <div class="faculty-admin-form__setting">

            <div>

                <strong>
                    وضعیت دانشکده
                </strong>

                <span>
                    دانشکده‌های فعال در سایت عمومی نمایش داده می‌شوند.
                </span>

            </div>


            <label class="faculty-admin-form__switch">

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    <?= (
                        (int) (
                            $faculty['is_active']
                            ?? 1
                        ) === 1
                    )
                        ? 'checked'
                        : ''
                    ?>
                >

                <span
                    class="faculty-admin-form__switch-track"
                    aria-hidden="true"
                >
                    <span></span>
                </span>

                <strong>
                    فعال
                </strong>

            </label>

        </div>

    </div>


    <div class="faculty-admin-form__actions">

        <a
            href="<?= View::route(
                'admin.faculties.index'
            ) ?>"
            class="faculty-admin-form__button faculty-admin-form__button--secondary"
        >
            انصراف
        </a>


        <button
            type="submit"
            class="faculty-admin-form__button faculty-admin-form__button--primary"
        >
            <?= View::escape(
                $submitLabel
            ) ?>
        </button>

    </div>

</form>
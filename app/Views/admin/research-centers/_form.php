<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;

$center =
    is_array($center ?? null)
        ? $center
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
    class="research-admin-form"
>

    <?= Csrf::field() ?>


    <?php if (
        $errors !== []
    ): ?>

        <div class="research-admin-form__errors">

            <div
                class="research-admin-form__errors-icon"
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
                        as $message
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


    <div class="research-admin-form__grid">

        <!-- Name -->

        <div class="research-admin-form__field">

            <label for="name">
                نام پژوهشکده
                <span>*</span>
            </label>

            <input
                id="name"
                name="name"
                type="text"
                value="<?= View::escape(
                    $center['name']
                    ?? ''
                ) ?>"
                maxlength="255"
                required
                placeholder="مثلاً پژوهشکده فناوری اطلاعات"
            >

        </div>


        <!-- Slug -->

        <div class="research-admin-form__field">

            <label for="slug">
                آدرس
                <span>*</span>
            </label>

            <input
                id="slug"
                name="slug"
                type="text"
                value="<?= View::escape(
                    $center['slug']
                    ?? ''
                ) ?>"
                maxlength="255"
                required
                dir="ltr"
                placeholder="information-technology-research-center"
            >

            <small>
                برای ساخت آدرس عمومی پژوهشکده استفاده می‌شود.
            </small>

        </div>


        <!-- Email -->

        <div class="research-admin-form__field">

            <label for="email">
                ایمیل
            </label>

            <input
                id="email"
                name="email"
                type="email"
                value="<?= View::escape(
                    $center['email']
                    ?? ''
                ) ?>"
                dir="ltr"
                placeholder="research@sadra.ac.ir"
            >

        </div>


        <!-- Phone -->

        <div class="research-admin-form__field">

            <label for="phone">
                تلفن
            </label>

            <input
                id="phone"
                name="phone"
                type="text"
                value="<?= View::escape(
                    $center['phone']
                    ?? ''
                ) ?>"
                dir="ltr"
                placeholder="021..."
            >

        </div>


        <!-- Description -->

        <div
            class="
                research-admin-form__field
                research-admin-form__field--full
            "
        >

            <label for="description">
                معرفی پژوهشکده
            </label>

            <textarea
                id="description"
                name="description"
                rows="9"
                placeholder="معرفی پژوهشکده، زمینه‌های فعالیت، اهداف و حوزه‌های پژوهشی..."
            ><?= View::escape(
                $center['description']
                ?? ''
            ) ?></textarea>

        </div>


        <!-- Address -->

        <div
            class="
                research-admin-form__field
                research-admin-form__field--full
            "
        >

            <label for="address">
                آدرس
            </label>

            <textarea
                id="address"
                name="address"
                rows="4"
                placeholder="آدرس محل پژوهشکده..."
            ><?= View::escape(
                $center['address']
                ?? ''
            ) ?></textarea>

        </div>


        <!-- Sort order -->

        <div class="research-admin-form__field">

            <label for="sort_order">
                ترتیب نمایش
            </label>

            <input
                id="sort_order"
                name="sort_order"
                type="number"
                min="0"
                value="<?= View::escape(
                    $center['sort_order']
                    ?? 0
                ) ?>"
            >

            <small>
                عدد کمتر، نمایش بالاتر.
            </small>

        </div>


        <!-- Status -->

        <div class="research-admin-form__field">

            <label>
                وضعیت
            </label>

            <label class="research-admin-form__switch">

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    <?= (
                        (int) (
                            $center['is_active']
                            ?? 1
                        ) === 1
                    )
                        ? 'checked'
                        : ''
                    ?>
                >

                <span
                    class="research-admin-form__switch-track"
                    aria-hidden="true"
                >
                    <span></span>
                </span>

                <span class="research-admin-form__switch-copy">

                    <strong>
                        پژوهشکده فعال باشد
                    </strong>

                    <small>
                        پژوهشکده‌های فعال در سایت عمومی نمایش داده می‌شوند.
                    </small>

                </span>

            </label>

        </div>

    </div>


    <div class="research-admin-form__actions">

        <a
            href="<?= View::route(
                'admin.research-centers.index'
            ) ?>"
            class="
                research-admin-form__button
                research-admin-form__button--secondary
            "
        >
            انصراف
        </a>


        <button
            type="submit"
            class="
                research-admin-form__button
                research-admin-form__button--primary
            "
        >
            <?= View::escape(
                $submitLabel
            ) ?>
        </button>

    </div>

</form>
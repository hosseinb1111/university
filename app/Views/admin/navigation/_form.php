<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


$item =
    is_array(
        $item ?? null
    )
        ? $item
        : [];


$parents =
    is_array(
        $parents ?? null
    )
        ? $parents
        : [];


$pages =
    is_array(
        $pages ?? null
    )
        ? $pages
        : [];


$errors =
    is_array(
        $errors ?? null
    )
        ? $errors
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


$displayLocation =
    (
        $item[
            'display_location'
        ]
        ?? 'main'
    ) === 'quick'
        ? 'quick'
        : 'main';


$destinationType =
    (
        $item[
            'destination_type'
        ]
        ?? ''
    ) === 'url'
        ? 'url'
        : 'page';


if (
    $destinationType === 'page'
    && empty(
        $item['page_id']
        ?? null
    )
    && !empty(
        $item['url']
        ?? null
    )
) {
    $destinationType =
        'url';
}

?>

<form
    method="POST"
    action="<?= View::escape(
        $action
    ) ?>"
    class="admin-navigation-form"
>

    <?= Csrf::field() ?>


    <?php if (
        $errors !== []
    ): ?>

        <div
            class="admin-navigation-form__errors"
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
                            (string) $error
                        ) ?>
                    </li>

                <?php endforeach; ?>

            </ul>

        </div>

    <?php endif; ?>


    <div class="admin-navigation-form__panel">

        <div class="admin-navigation-form__header">

            <div
                class="admin-navigation-form__header-icon"
                aria-hidden="true"
            >
                ☰
            </div>

            <div>

                <h2>
                    اطلاعات آیتم منو
                </h2>

                <p>
                    اطلاعاتی که در سایت نمایش داده می‌شود را تنظیم کنید.
                </p>

            </div>

        </div>


        <div class="admin-navigation-form__body">

            <div class="admin-navigation-form__grid">


                <div class="
                    admin-navigation-form__field
                    admin-navigation-form__field--full
                ">

                    <label
                        for="title"
                    >
                        عنوان آیتم
                    </label>

                    <input
                        id="title"
                        name="title"
                        type="text"
                        class="admin-navigation-form__input"
                        value="<?= View::escape(
                            $item['title']
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
                            class="admin-navigation-form__error"
                        >
                            <?= View::escape(
                                $errors['title']
                            ) ?>
                        </small>

                    <?php endif; ?>

                </div>


                <div class="
                    admin-navigation-form__field
                    admin-navigation-form__field--full
                ">

                    <label
                        for="description"
                    >
                        توضیحات
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        class="admin-navigation-form__textarea"
                        maxlength="500"
                        rows="4"
                        placeholder="مثلاً دسترسی سریع به سامانه آموزشی دانشگاه"
                    ><?= View::escape(
                        $item['description']
                        ?? ''
                    ) ?></textarea>

                    <span
                        class="admin-navigation-form__help"
                    >
                        این توضیحات برای معرفی بهتر آیتم، مخصوصاً در بخش «سامانه‌ها و خدمات»، استفاده می‌شود.
                    </span>

                    <?php if (
                        isset(
                            $errors['description']
                        )
                    ): ?>

                        <small
                            class="admin-navigation-form__error"
                        >
                            <?= View::escape(
                                $errors['description']
                            ) ?>
                        </small>

                    <?php endif; ?>

                </div>


                <div class="admin-navigation-form__field">

                    <label
                        for="display_location"
                    >
                        محل نمایش
                    </label>

                    <select
                        id="display_location"
                        name="display_location"
                        class="admin-navigation-form__select"
                    >

                        <option
                            value="main"
                            <?= $displayLocation === 'main'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            منوی اصلی
                        </option>

                        <option
                            value="quick"
                            <?= $displayLocation === 'quick'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            دسترسی سریع / سامانه‌ها و خدمات
                        </option>

                    </select>

                    <span
                        class="admin-navigation-form__help"
                    >
                        آیتم‌های دسترسی سریع در منوی اصلی قرار نمی‌گیرند.
                    </span>

                </div>


                <div
                    class="admin-navigation-form__field"
                    id="navigation-parent-field"
                >

                    <label
                        for="parent_id"
                    >
                        آیتم والد
                    </label>

                    <select
                        id="parent_id"
                        name="parent_id"
                        class="admin-navigation-form__select"
                    >

                        <option value="">
                            بدون والد
                        </option>

                        <?php foreach (
                            $parents
                            as $parent
                        ): ?>

                            <option
                                value="<?= (int) (
                                    $parent['id']
                                    ?? 0
                                ) ?>"
                                <?= (
                                    (string) (
                                        $item['parent_id']
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
                                    $parent['title']
                                    ?? ''
                                ) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <div class="
                    admin-navigation-form__field
                    admin-navigation-form__field--full
                ">

                    <label>
                        نوع مقصد
                    </label>

                    <div class="admin-navigation-form__destination-switch">

                        <label
                            class="
                                admin-navigation-form__destination-option
                                <?= $destinationType === 'page'
                                    ? 'admin-navigation-form__destination-option--active'
                                    : ''
                                ?>
                            "
                        >

                            <input
                                type="radio"
                                name="destination_type"
                                value="page"
                                <?= $destinationType === 'page'
                                    ? 'checked'
                                    : ''
                                ?>
                            >

                            <span>
                                صفحه داخلی سایت
                            </span>

                        </label>


                        <label
                            class="
                                admin-navigation-form__destination-option
                                <?= $destinationType === 'url'
                                    ? 'admin-navigation-form__destination-option--active'
                                    : ''
                                ?>
                            "
                        >

                            <input
                                type="radio"
                                name="destination_type"
                                value="url"
                                <?= $destinationType === 'url'
                                    ? 'checked'
                                    : ''
                                ?>
                            >

                            <span>
                                آدرس مستقیم
                            </span>

                        </label>

                    </div>

                </div>


                <div
                    class="admin-navigation-form__field"
                    id="navigation-page-field"
                >

                    <label
                        for="page_id"
                    >
                        صفحه مقصد
                    </label>

                    <select
                        id="page_id"
                        name="page_id"
                        class="admin-navigation-form__select"
                    >

                        <option value="">
                            انتخاب صفحه
                        </option>

                        <?php foreach (
                            $pages
                            as $page
                        ): ?>

                            <option
                                value="<?= (int) (
                                    $page['id']
                                    ?? 0
                                ) ?>"
                                <?= (
                                    (string) (
                                        $item['page_id']
                                        ?? ''
                                    )
                                    ===
                                    (string) (
                                        $page['id']
                                        ?? ''
                                    )
                                )
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                <?= View::escape(
                                    $page['title']
                                    ?? ''
                                ) ?>

                                <?php if (
                                    !empty(
                                        $page['slug']
                                    )
                                ): ?>

                                    —
                                    /
                                    <?= View::escape(
                                        $page['slug']
                                    ) ?>

                                <?php endif; ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                    <?php if (
                        isset(
                            $errors['page_id']
                        )
                    ): ?>

                        <small
                            class="admin-navigation-form__error"
                        >
                            <?= View::escape(
                                $errors['page_id']
                            ) ?>
                        </small>

                    <?php endif; ?>

                </div>


                <div
                    class="admin-navigation-form__field"
                    id="navigation-url-field"
                >

                    <label
                        for="url"
                    >
                        آدرس مستقیم
                    </label>

                    <input
                        id="url"
                        name="url"
                        type="text"
                        class="admin-navigation-form__input"
                        value="<?= View::escape(
                            $item['url']
                            ?? ''
                        ) ?>"
                        maxlength="500"
                        placeholder="/documents یا https://example.com"
                    >

                    <span
                        class="admin-navigation-form__help"
                    >
                        برای لینک داخلی از مسیرهایی مانند
                        <span dir="ltr">/documents</span>
                        و برای لینک خارجی از
                        <span dir="ltr">https://</span>
                        استفاده کنید.
                    </span>

                    <?php if (
                        isset(
                            $errors['url']
                        )
                    ): ?>

                        <small
                            class="admin-navigation-form__error"
                        >
                            <?= View::escape(
                                $errors['url']
                            ) ?>
                        </small>

                    <?php endif; ?>

                </div>


                <?php if (
                    isset(
                        $errors['destination']
                    )
                ): ?>

                    <div
                        class="
                            admin-navigation-form__field
                            admin-navigation-form__field--full
                        "
                    >

                        <small
                            class="admin-navigation-form__error"
                        >
                            <?= View::escape(
                                $errors['destination']
                            ) ?>
                        </small>

                    </div>

                <?php endif; ?>


                <div class="admin-navigation-form__field">

                    <label
                        for="target"
                    >
                        نحوه باز شدن
                    </label>

                    <select
                        id="target"
                        name="target"
                        class="admin-navigation-form__select"
                    >

                        <option
                            value="_self"
                            <?= (
                                (
                                    $item['target']
                                    ?? '_self'
                                ) === '_self'
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
                                (
                                    $item['target']
                                    ?? '_self'
                                ) === '_blank'
                            )
                                ? 'selected'
                                : ''
                            ?>
                        >
                            تب جدید
                        </option>

                    </select>

                </div>


                <div class="admin-navigation-form__field">

                    <label
                        for="sort_order"
                    >
                        ترتیب نمایش
                    </label>

                    <input
                        id="sort_order"
                        name="sort_order"
                        type="number"
                        class="admin-navigation-form__input"
                        value="<?= View::escape(
                            $item['sort_order']
                            ?? 0
                        ) ?>"
                        min="-10000"
                        max="10000"
                    >

                </div>


                <div class="
                    admin-navigation-form__field
                    admin-navigation-form__field--full
                ">

                    <label
                        class="admin-navigation-form__checkbox"
                        for="is_active"
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

                        <span>
                            این آیتم در سایت فعال و قابل نمایش باشد
                        </span>

                    </label>

                </div>

            </div>


            <div class="admin-navigation-form__info">

                <div
                    class="admin-navigation-form__info-icon"
                    aria-hidden="true"
                >
                    i
                </div>

                <div>
                    مقصد و وضعیت این آیتم بلافاصله روی منوی عمومی سایت و در صورت انتخاب «دسترسی سریع»، روی بخش «سامانه‌ها و خدمات» اعمال می‌شود.
                </div>

            </div>


            <div class="admin-navigation-form__actions">

                <a
                    href="<?= View::route(
                        'admin.navigation.index'
                    ) ?>"
                    class="admin-navigation-form__cancel"
                >
                    انصراف
                </a>


                <button
                    type="submit"
                    class="admin-navigation-form__save"
                >
                    <?= View::escape(
                        $submitLabel
                    ) ?>
                </button>

            </div>

        </div>

    </div>

</form>


<script>
(function () {
    const locationSelect =
        document.getElementById(
            'display_location'
        );

    const parentField =
        document.getElementById(
            'navigation-parent-field'
        );

    const parentSelect =
        document.getElementById(
            'parent_id'
        );

    const pageField =
        document.getElementById(
            'navigation-page-field'
        );

    const pageSelect =
        document.getElementById(
            'page_id'
        );

    const urlField =
        document.getElementById(
            'navigation-url-field'
        );

    const urlInput =
        document.getElementById(
            'url'
        );

    const destinationRadios =
        document.querySelectorAll(
            'input[name="destination_type"]'
        );

    if (
        !locationSelect
        || !parentField
        || !parentSelect
        || !pageField
        || !pageSelect
        || !urlField
        || !urlInput
    ) {
        return;
    }

    function getDestinationType() {
        const checked =
            document.querySelector(
                'input[name="destination_type"]:checked'
            );

        return checked
            ? checked.value
            : 'page';
    }

    function updateParentVisibility() {
        const isQuick =
            locationSelect.value === 'quick';

        parentField.hidden =
            isQuick;

        if (
            isQuick
        ) {
            parentSelect.value =
                '';
        }
    }

    function updateDestinationVisibility() {
        const type =
            getDestinationType();

        const isPage =
            type === 'page';

        pageField.hidden =
            !isPage;

        urlField.hidden =
            isPage;

        if (
            isPage
        ) {
            urlInput.value =
                '';
        } else {
            pageSelect.value =
                '';
        }

        destinationRadios.forEach(
            function (radio) {
                const label =
                    radio.closest(
                        '.admin-navigation-form__destination-option'
                    );

                if (
                    !label
                ) {
                    return;
                }

                label.classList.toggle(
                    'admin-navigation-form__destination-option--active',
                    radio.checked
                );
            }
        );
    }

    locationSelect.addEventListener(
        'change',
        updateParentVisibility
    );

    destinationRadios.forEach(
        function (radio) {
            radio.addEventListener(
                'change',
                updateDestinationVisibility
            );
        }
    );

    updateParentVisibility();
    updateDestinationVisibility();
})();
</script>
<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


$items =
    is_array(
        $items ?? null
    )
        ? $items
        : [];


$success =
    is_string(
        $success ?? null
    )
        ? $success
        : null;


$error =
    is_string(
        $error ?? null
    )
        ? $error
        : null;


$mainItems =
    0;

$quickItems =
    0;

$activeItems =
    0;


foreach (
    $items
    as $navigationItem
) {
    $location =
        (
            $navigationItem[
                'display_location'
            ]
            ?? 'main'
        ) === 'quick'
            ? 'quick'
            : 'main';

    if (
        $location === 'quick'
    ) {
        $quickItems++;
    } else {
        $mainItems++;
    }

    if (
        (int) (
            $navigationItem[
                'is_active'
            ]
            ?? 0
        ) === 1
    ) {
        $activeItems++;
    }
}

?>

<div class="admin-navigation">

    <header class="admin-navigation__header">

        <div class="admin-navigation__header-main">

            <span class="admin-navigation__eyebrow">
                ساختار سایت
            </span>

            <h1>
                منوی سایت
            </h1>

            <p>
                تمام آیتم‌های منوی اصلی و بخش «سامانه‌ها و خدمات» را از اینجا مدیریت کنید.
            </p>

        </div>


        <div class="admin-navigation__header-action">

            <a
                href="<?= View::route(
                    'admin.navigation.create'
                ) ?>"
                class="admin-navigation__create-button"
            >

                <span
                    class="admin-navigation__create-button-icon"
                    aria-hidden="true"
                >
                    +
                </span>

                افزودن آیتم

            </a>

        </div>

    </header>


    <?php if (
        $success !== null
        && $success !== ''
    ): ?>

        <div
            class="
                admin-navigation__alert
                admin-navigation__alert--success
            "
            role="status"
        >

            <span
                class="admin-navigation__alert-icon"
                aria-hidden="true"
            >
                ✓
            </span>

            <div>
                <?= View::escape(
                    $success
                ) ?>
            </div>

        </div>

    <?php endif; ?>


    <?php if (
        $error !== null
        && $error !== ''
    ): ?>

        <div
            class="
                admin-navigation__alert
                admin-navigation__alert--error
            "
            role="alert"
        >

            <span
                class="admin-navigation__alert-icon"
                aria-hidden="true"
            >
                !
            </span>

            <div>
                <?= View::escape(
                    $error
                ) ?>
            </div>

        </div>

    <?php endif; ?>


    <section class="admin-navigation__panel">

        <header class="admin-navigation__panel-header">

            <div class="admin-navigation__panel-title">

                <div
                    class="admin-navigation__panel-icon"
                    aria-hidden="true"
                >
                    ☰
                </div>

                <div>

                    <strong>
                        آیتم‌های منو
                    </strong>

                    <span>
                        <?= number_format(
                            count($items)
                        ) ?>
                        آیتم
                        ·
                        <?= number_format(
                            $activeItems
                        ) ?>
                        فعال
                    </span>

                </div>

            </div>


            <div class="admin-navigation__stats">

                <span>
                    منوی اصلی:
                    <strong>
                        <?= number_format(
                            $mainItems
                        ) ?>
                    </strong>
                </span>

                <span>
                    دسترسی سریع:
                    <strong>
                        <?= number_format(
                            $quickItems
                        ) ?>
                    </strong>
                </span>

            </div>

        </header>


        <?php if (
            $items === []
        ): ?>

            <div class="admin-navigation__empty">

                <div
                    class="admin-navigation__empty-icon"
                    aria-hidden="true"
                >
                    ☰
                </div>

                <h2>
                    هنوز آیتمی ایجاد نشده است.
                </h2>

                <p>
                    اولین آیتم منوی سایت یا یکی از سامانه‌ها و خدمات را اضافه کنید.
                </p>

                <a
                    href="<?= View::route(
                        'admin.navigation.create'
                    ) ?>"
                    class="admin-navigation__create-button"
                >
                    افزودن اولین آیتم
                </a>

            </div>

        <?php else: ?>

            <div class="admin-navigation__table-wrapper">

                <table class="admin-navigation__table">

                    <thead>

                    <tr>

                        <th>
                            عنوان
                        </th>

                        <th>
                            محل نمایش
                        </th>

                        <th>
                            والد
                        </th>

                        <th>
                            مقصد
                        </th>

                        <th>
                            وضعیت
                        </th>

                        <th>
                            ترتیب
                        </th>

                        <th>
                            عملیات
                        </th>

                    </tr>

                    </thead>

                    <tbody>

                    <?php foreach (
                        $items
                        as $navigationItem
                    ): ?>

                        <?php

                        $id =
                            (int) (
                                $navigationItem[
                                    'id'
                                ]
                                ?? 0
                            );

                        $location =
                            (
                                $navigationItem[
                                    'display_location'
                                ]
                                ?? 'main'
                            ) === 'quick'
                                ? 'quick'
                                : 'main';

                        $title =
                            trim(
                                (string) (
                                    $navigationItem[
                                        'title'
                                    ]
                                    ?? ''
                                )
                            );

                        $description =
                            trim(
                                (string) (
                                    $navigationItem[
                                        'description'
                                    ]
                                    ?? ''
                                )
                            );

                        $parentTitle =
                            trim(
                                (string) (
                                    $navigationItem[
                                        'parent_title'
                                    ]
                                    ?? ''
                                )
                            );

                        $pageSlug =
                            trim(
                                (string) (
                                    $navigationItem[
                                        'page_slug'
                                    ]
                                    ?? ''
                                )
                            );

                        $url =
                            trim(
                                (string) (
                                    $navigationItem[
                                        'url'
                                    ]
                                    ?? ''
                                )
                            );

                        $isActive =
                            (int) (
                                $navigationItem[
                                    'is_active'
                                ]
                                ?? 0
                            ) === 1;

                        $sortOrder =
                            (int) (
                                $navigationItem[
                                    'sort_order'
                                ]
                                ?? 0
                            );

                        $destination =
                            $url !== ''
                                ? $url
                                : (
                                    $pageSlug !== ''
                                        ? '/pages/'
                                            . $pageSlug
                                        : '#'
                                );

                        ?>

                        <tr>

                            <td>

                                <div class="admin-navigation__item">

                                    <div
                                        class="admin-navigation__item-icon"
                                        aria-hidden="true"
                                    >
                                        <?= $location === 'quick'
                                            ? '⚡'
                                            : '☰'
                                        ?>
                                    </div>

                                    <div class="admin-navigation__item-text">

                                        <strong
                                            class="admin-navigation__item-title"
                                        >
                                            <?= View::escape(
                                                $title
                                            ) ?>
                                        </strong>

                                        <?php if (
                                            $description !== ''
                                        ): ?>

                                            <span
                                                class="
                                                    admin-navigation__item-description
                                                "
                                            >
                                                <?= View::escape(
                                                    $description
                                                ) ?>
                                            </span>

                                        <?php endif; ?>

                                    </div>

                                </div>

                            </td>


                            <td>

                                <span
                                    class="
                                        admin-navigation__badge
                                        admin-navigation__badge--<?= $location ?>
                                    "
                                >

                                    <?= $location === 'quick'
                                        ? 'دسترسی سریع'
                                        : 'منوی اصلی'
                                    ?>

                                </span>

                            </td>


                            <td>

                                <?php if (
                                    $location === 'quick'
                                ): ?>

                                    <span
                                        class="admin-navigation__parent admin-navigation__parent--root"
                                    >
                                        سطح اصلی
                                    </span>

                                <?php elseif (
                                    $parentTitle !== ''
                                ): ?>

                                    <span
                                        class="admin-navigation__parent"
                                    >
                                        <?= View::escape(
                                            $parentTitle
                                        ) ?>
                                    </span>

                                <?php else: ?>

                                    <span
                                        class="
                                            admin-navigation__parent
                                            admin-navigation__parent--root
                                        "
                                    >
                                        بدون والد
                                    </span>

                                <?php endif; ?>

                            </td>


                            <td>

                                <div
                                    class="admin-navigation__destination"
                                    title="<?= View::escape(
                                        $destination
                                    ) ?>"
                                >
                                    <?= View::escape(
                                        $destination
                                    ) ?>
                                </div>

                            </td>


                            <td>

                                <span
                                    class="
                                        admin-navigation__status
                                        admin-navigation__status--<?= $isActive
                                            ? 'active'
                                            : 'inactive'
                                        ?>
                                    "
                                >
                                    <?= $isActive
                                        ? 'فعال'
                                        : 'غیرفعال'
                                    ?>
                                </span>

                            </td>


                            <td>

                                <span
                                    class="admin-navigation__order"
                                >
                                    <?= $sortOrder ?>
                                </span>

                            </td>


                            <td>

                                <div
                                    class="admin-navigation__actions"
                                >

                                    <a
                                        href="<?= View::url(
                                            '/admin/navigation/'
                                            . $id
                                            . '/edit'
                                        ) ?>"
                                        class="
                                            admin-navigation__action
                                            admin-navigation__action--edit
                                        "
                                    >
                                        ویرایش
                                    </a>


                                    <form
                                        method="POST"
                                        action="<?= View::url(
                                            '/admin/navigation/'
                                            . $id
                                            . '/delete'
                                        ) ?>"
                                        onsubmit="return confirm('آیا از حذف این آیتم مطمئن هستید؟');"
                                    >

                                        <?= Csrf::field() ?>

                                        <button
                                            type="submit"
                                            class="
                                                admin-navigation__action
                                                admin-navigation__action--delete
                                            "
                                        >
                                            حذف
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    </section>

</div>
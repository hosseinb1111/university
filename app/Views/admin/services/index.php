<?php

declare(strict_types=1);

use App\Core\View;

$services =
    is_array(
        $services ?? null
    )
        ? $services
        : [];

$items =
    is_array(
        $services['items']
        ?? null
    )
        ? $services['items']
        : [];

$page =
    max(
        1,
        (int) (
            $services['page']
            ?? 1
        )
    );

$totalPages =
    max(
        1,
        (int) (
            $services['totalPages']
            ?? 1
        )
    );

$success =
    trim(
        (string) (
            $success
            ?? ''
        )
    );

$error =
    trim(
        (string) (
            $error
            ?? ''
        )
    );

?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>

            <span class="admin-page__eyebrow">
                صفحه اصلی
            </span>

            <h1>
                خدمات
            </h1>

            <p>
                مدیریت سامانه‌ها و خدمات نمایش‌داده‌شده در صفحه اصلی.
            </p>

        </div>


        <a
            href="<?= View::route(
                'admin.services.create'
            ) ?>"
            class="button button--primary"
        >
            ایجاد خدمت
        </a>

    </div>


    <?php if ($success !== ''): ?>

        <div
            class="admin-alert admin-alert--success"
            role="status"
        >
            <?= View::escape(
                $success
            ) ?>
        </div>

    <?php endif; ?>


    <?php if ($error !== ''): ?>

        <div
            class="admin-alert admin-alert--error"
            role="alert"
        >
            <?= View::escape(
                $error
            ) ?>
        </div>

    <?php endif; ?>


    <?php if ($items === []): ?>

        <div class="admin-empty">

            <strong>
                هنوز خدمتی ثبت نشده است.
            </strong>

            <span>
                اولین خدمت را برای نمایش در صفحه اصلی ایجاد کنید.
            </span>

            <a
                href="<?= View::route(
                    'admin.services.create'
                ) ?>"
                class="button button--primary"
            >
                ایجاد اولین خدمت
            </a>

        </div>

    <?php else: ?>

        <div class="admin-table-wrap">

            <table class="admin-table">

                <thead>

                    <tr>

                        <th>
                            تصویر
                        </th>

                        <th>
                            عنوان
                        </th>

                        <th>
                            لینک
                        </th>

                        <th>
                            ترتیب
                        </th>

                        <th>
                            وضعیت
                        </th>

                        <th>
                            عملیات
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <?php foreach (
                        $items
                        as $service
                    ): ?>

                        <?php
                        $id =
                            (int) (
                                $service['id']
                                ?? 0
                            );

                        $title =
                            trim(
                                (string) (
                                    $service['title']
                                    ?? ''
                                )
                            );

                        $url =
                            trim(
                                (string) (
                                    $service['url']
                                    ?? ''
                                )
                            );

                        $image =
                            trim(
                                (string) (
                                    $service['image']
                                    ?? ''
                                )
                            );

                        $sortOrder =
                            (int) (
                                $service['sort_order']
                                ?? 0
                            );

                        $isActive =
                            (int) (
                                $service['is_active']
                                ?? 0
                            ) === 1;
                        ?>

                        <tr>

                            <td>

                                <?php if (
                                    $image !== ''
                                ): ?>

                                    <img
                                        src="<?= View::escape(
                                            $image
                                        ) ?>"
                                        alt=""
                                        loading="lazy"
                                        style="
                                            width:72px;
                                            height:48px;
                                            object-fit:cover;
                                            border-radius:8px;
                                        "
                                    >

                                <?php else: ?>

                                    <span>
                                        بدون تصویر
                                    </span>

                                <?php endif; ?>

                            </td>


                            <td>

                                <strong>
                                    <?= View::escape(
                                        $title
                                    ) ?>
                                </strong>

                            </td>


                            <td>

                                <a
                                    href="<?= View::escape(
                                        $url
                                    ) ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    <?= View::escape(
                                        $url
                                    ) ?>
                                </a>

                            </td>


                            <td>
                                <?= $sortOrder ?>
                            </td>


                            <td>

                                <?php if (
                                    $isActive
                                ): ?>

                                    <span
                                        class="admin-status admin-status--success"
                                    >
                                        فعال
                                    </span>

                                <?php else: ?>

                                    <span
                                        class="admin-status"
                                    >
                                        غیرفعال
                                    </span>

                                <?php endif; ?>

                            </td>


                            <td>

                                <div
                                    style="
                                        display:flex;
                                        gap:8px;
                                        flex-wrap:wrap;
                                    "
                                >

                                    <a
                                        href="<?= View::route(
                                            'admin.services.edit',
                                            [
                                                'id' =>
                                                    $id,
                                            ]
                                        ) ?>"
                                        class="button button--secondary"
                                    >
                                        ویرایش
                                    </a>


                                    <form
                                        method="POST"
                                        action="<?= View::route(
                                            'admin.services.delete',
                                            [
                                                'id' =>
                                                    $id,
                                            ]
                                        ) ?>"
                                        onsubmit="return confirm('آیا از حذف این خدمت مطمئن هستید؟');"
                                    >

                                        <?= \App\Core\Csrf::field() ?>

                                        <button
                                            type="submit"
                                            class="button button--danger"
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


        <?php if (
            $totalPages > 1
        ): ?>

            <nav
                class="admin-pagination"
                aria-label="صفحه‌بندی خدمات"
            >

                <?php for (
                    $index = 1;
                    $index <= $totalPages;
                    $index++
                ): ?>

                    <a
                        href="<?= View::url(
                            '/admin/services?page='
                            . $index
                        ) ?>"
                        class="<?= $index === $page
                            ? 'is-active'
                            : ''
                        ?>"
                    >
                        <?= $index ?>
                    </a>

                <?php endfor; ?>

            </nav>

        <?php endif; ?>

    <?php endif; ?>

</div>
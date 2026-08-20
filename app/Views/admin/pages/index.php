<?php

declare(strict_types=1);

$items = $pages['items'] ?? [];

$total = (int) (
    $pages['total'] ?? 0
);

$pageNumber = (int) (
    $pages['page'] ?? 1
);

$totalPages = (int) (
    $pages['totalPages'] ?? 1
);
?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>
            <h1>
                صفحات سایت
            </h1>

            <p>
                مدیریت صفحات و محتوای اصلی سایت
            </p>
        </div>

        <a
            href="<?= View::route(
                'admin.pages.create'
            ) ?>"
            class="button button--primary"
        >
            + ایجاد صفحه
        </a>

    </div>


    <?php if ($success !== null): ?>

        <div
            style="
                margin-bottom:20px;
                padding:14px 16px;
                background:#f0fdf4;
                border:1px solid #bbf7d0;
                border-radius:12px;
                color:#166534;
            "
        >
            <?= View::escape(
                $success
            ) ?>
        </div>

    <?php endif; ?>


    <div class="admin-panel">

        <div
            style="
                margin-bottom:20px;
                color:#64748b;
                font-size:13px;
            "
        >
            مجموع:
            <?= number_format(
                $total
            ) ?>
            صفحه
        </div>


        <?php if ($items === []): ?>

            <div
                style="
                    padding:50px 20px;
                    text-align:center;
                    color:#64748b;
                "
            >
                هنوز صفحه‌ای ایجاد نشده است.
            </div>

        <?php else: ?>

            <div class="announcement-table-wrapper">

                <table class="announcement-table">

                    <thead>

                    <tr>
                        <th>عنوان</th>
                        <th>والد</th>
                        <th>وضعیت</th>
                        <th>آدرس</th>
                        <th>عملیات</th>
                    </tr>

                    </thead>

                    <tbody>

                    <?php foreach (
                        $items
                        as $page
                    ): ?>

                        <tr>

                            <td>
                                <strong>
                                    <?= View::escape(
                                        $page['title']
                                    ) ?>
                                </strong>
                            </td>

                            <td>
                                <?= View::escape(
                                    $page['parent_title']
                                    ?? '—'
                                ) ?>
                            </td>

                            <td>

                                <?php
                                $status =
                                    $page['status']
                                    ?? 'draft';
                                ?>

                                <span
                                    class="
                                        announcement-status
                                        announcement-status--<?= View::escape(
                                            $status
                                        ) ?>
                                    "
                                >
                                    <?php if (
                                        $status === 'published'
                                    ): ?>

                                        منتشر شده

                                    <?php elseif (
                                        $status === 'private'
                                    ): ?>

                                        خصوصی

                                    <?php else: ?>

                                        پیش‌نویس

                                    <?php endif; ?>
                                </span>

                            </td>

                            <td>
                                /pages/<?= View::escape(
                                    $page['slug']
                                ) ?>
                            </td>

                            <td>

                                <div
                                    style="
                                        display:flex;
                                        flex-wrap:wrap;
                                        gap:6px;
                                    "
                                >

                                    <?php if (
                                        $status === 'published'
                                    ): ?>

                                        <a
                                            href="/pages/<?= rawurlencode(
                                                $page['slug']
                                            ) ?>"
                                            class="table-action"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >
                                            مشاهده
                                        </a>

                                    <?php endif; ?>

                                    <a
                                        href="/admin/pages/<?= (int) $page['id'] ?>/edit"
                                        class="table-action"
                                    >
                                        ویرایش
                                    </a>

                                    <form
                                        method="POST"
                                        action="/admin/pages/<?= (int) $page['id'] ?>/delete"
                                        onsubmit="return confirm('آیا از حذف این صفحه مطمئن هستید؟');"
                                    >

                                        <?= \App\Core\Csrf::field() ?>

                                        <button
                                            type="submit"
                                            class="table-action table-action--danger"
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

    </div>


    <?php if (
        $totalPages > 1
    ): ?>

        <div
            style="
                display:flex;
                justify-content:center;
                gap:8px;
                margin-top:20px;
                flex-wrap:wrap;
            "
        >

            <?php for (
                $i = 1;
                $i <= $totalPages;
                $i++
            ): ?>

                <a
                    href="/admin/pages?page=<?= $i ?>"
                    class="table-action <?= $i === $pageNumber ? 'table-action--active' : '' ?>"
                >
                    <?= $i ?>
                </a>

            <?php endfor; ?>

        </div>

    <?php endif; ?>

</div>
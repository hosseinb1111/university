<?php

declare(strict_types=1);
?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>
            <h1>
                منوی سایت
            </h1>

            <p>
                مدیریت ساختار منوی اصلی و زیرمنوهای سایت
            </p>
        </div>

        <a
            href="<?= View::route(
                'admin.navigation.create'
            ) ?>"
            class="button button--primary"
        >
            + افزودن آیتم
        </a>

    </div>


    <?php if (
        $success !== null
    ): ?>

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

        <?php if (
            $items === []
        ): ?>

            <div
                style="
                    padding:50px 20px;
                    text-align:center;
                    color:#64748b;
                "
            >
                هنوز آیتمی برای منوی سایت ایجاد نشده است.
            </div>

        <?php else: ?>

            <div class="announcement-table-wrapper">

                <table class="announcement-table">

                    <thead>

                    <tr>
                        <th>عنوان</th>
                        <th>والد</th>
                        <th>مقصد</th>
                        <th>وضعیت</th>
                        <th>ترتیب</th>
                        <th>عملیات</th>
                    </tr>

                    </thead>

                    <tbody>

                    <?php foreach (
                        $items
                        as $item
                    ): ?>

                        <tr>

                            <td>
                                <strong>
                                    <?= View::escape(
                                        $item['title']
                                    ) ?>
                                </strong>
                            </td>

                            <td>
                                <?= View::escape(
                                    $item['parent_title']
                                    ?? 'منوی اصلی'
                                ) ?>
                            </td>

                            <td>
                                <?php if (
                                    !empty(
                                        $item['page_slug']
                                    )
                                ): ?>

                                    /pages/<?= View::escape(
                                        $item['page_slug']
                                    ) ?>

                                <?php else: ?>

                                    <?= View::escape(
                                        $item['url']
                                        ?? '#'
                                    ) ?>

                                <?php endif; ?>
                            </td>

                            <td>

                                <?php if (
                                    (int) (
                                        $item['is_active']
                                        ?? 0
                                    ) === 1
                                ): ?>

                                    <span class="announcement-status announcement-status--published">
                                        فعال
                                    </span>

                                <?php else: ?>

                                    <span class="announcement-status announcement-status--draft">
                                        غیرفعال
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>
                                <?= (int) (
                                    $item['sort_order']
                                    ?? 0
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

                                    <a
                                        href="/admin/navigation/<?= (int) $item['id'] ?>/edit"
                                        class="table-action"
                                    >
                                        ویرایش
                                    </a>

                                    <form
                                        method="POST"
                                        action="/admin/navigation/<?= (int) $item['id'] ?>/delete"
                                        onsubmit="return confirm('آیا از حذف این آیتم مطمئن هستید؟');"
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

</div>
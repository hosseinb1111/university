<?php

declare(strict_types=1);

$items =
    $centers['items'] ?? [];

$total =
    (int) (
        $centers['total'] ?? 0
    );
?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>
            <h1>
                پژوهشکده‌ها
            </h1>

            <p>
                مدیریت مراکز و پژوهشکده‌های پژوهشی موسسه
            </p>
        </div>

        <a
            href="<?= View::route(
                'admin.research-centers.create'
            ) ?>"
            class="button button--primary"
        >
            + ایجاد پژوهشکده
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
            <?= View::escape($success) ?>
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
            <?= number_format($total) ?>
            پژوهشکده
        </div>


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
                هنوز پژوهشکده‌ای ثبت نشده است.
            </div>

        <?php else: ?>

            <div class="announcement-table-wrapper">

                <table class="announcement-table">

                    <thead>
                    <tr>
                        <th>نام</th>
                        <th>نام کوتاه</th>
                        <th>وضعیت</th>
                        <th>ترتیب</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>

                    <tbody>

                    <?php foreach (
                        $items
                        as $center
                    ): ?>

                        <tr>

                            <td>
                                <strong>
                                    <?= View::escape(
                                        $center['name']
                                    ) ?>
                                </strong>
                            </td>

                            <td>
                                <?= View::escape(
                                    $center['short_name']
                                    ?? '—'
                                ) ?>
                            </td>

                            <td>

                                <?php if (
                                    (int) (
                                        $center['is_active']
                                        ?? 0
                                    ) === 1
                                ): ?>

                                    <span
                                        class="announcement-status announcement-status--published"
                                    >
                                        فعال
                                    </span>

                                <?php else: ?>

                                    <span
                                        class="announcement-status announcement-status--draft"
                                    >
                                        غیرفعال
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>
                                <?= (int) (
                                    $center['sort_order']
                                    ?? 0
                                ) ?>
                            </td>

                            <td>

                                <a
                                    href="/admin/research-centers/<?= (int) $center['id'] ?>/edit"
                                    class="table-action"
                                >
                                    ویرایش
                                </a>

                                <?php if (
                                    (int) (
                                        $center['is_active']
                                        ?? 0
                                    ) === 1
                                ): ?>

                                    <a
                                        href="/research-centers/<?= rawurlencode(
                                            $center['slug']
                                        ) ?>"
                                        class="table-action"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >
                                        مشاهده
                                    </a>

                                <?php endif; ?>

                                <form
                                    method="POST"
                                    action="/admin/research-centers/<?= (int) $center['id'] ?>/delete"
                                    style="display:inline"
                                    onsubmit="return confirm('آیا از حذف این پژوهشکده مطمئن هستید؟');"
                                >

                                    <?= \App\Core\Csrf::field() ?>

                                    <button
                                        type="submit"
                                        class="table-action table-action--danger"
                                    >
                                        حذف
                                    </button>

                                </form>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    </div>

</div>
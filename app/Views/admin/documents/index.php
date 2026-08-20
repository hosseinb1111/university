<?php

declare(strict_types=1);

$items =
    $documents['items']
    ?? [];

$total =
    (int) (
        $documents['total']
        ?? 0
    );

$page =
    (int) (
        $documents['page']
        ?? 1
    );

$totalPages =
    (int) (
        $documents['totalPages']
        ?? 1
    );
?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>
            <h1>
                اسناد و فرم‌ها
            </h1>

            <p>
                مدیریت فرم‌ها، آیین‌نامه‌ها و فایل‌های موسسه
            </p>
        </div>

        <a
            href="<?= View::route(
                'admin.documents.create'
            ) ?>"
            class="button button--primary"
        >
            + افزودن سند
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
            سند
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
                هنوز سندی ثبت نشده است.
            </div>

        <?php else: ?>

            <div class="announcement-table-wrapper">

                <table class="announcement-table">

                    <thead>

                    <tr>
                        <th>عنوان</th>
                        <th>دسته</th>
                        <th>فایل</th>
                        <th>وضعیت</th>
                        <th>دانلود</th>
                        <th>عملیات</th>
                    </tr>

                    </thead>

                    <tbody>

                    <?php foreach (
                        $items
                        as $document
                    ): ?>

                        <tr>

                            <td>
                                <strong>
                                    <?= View::escape(
                                        $document['title']
                                    ) ?>
                                </strong>

                                <?php if (
                                    !empty(
                                        $document['description']
                                    )
                                ): ?>

                                    <div
                                        style="
                                            margin-top:4px;
                                            color:#94a3b8;
                                            font-size:12px;
                                        "
                                    >
                                        <?= View::escape(
                                            mb_strimwidth(
                                                $document['description'],
                                                0,
                                                100,
                                                '...',
                                                'UTF-8'
                                            )
                                        ) ?>
                                    </div>

                                <?php endif; ?>
                            </td>


                            <td>
                                <?= View::escape(
                                    $document['category_name']
                                    ?? ''
                                ) ?>
                            </td>


                            <td>
                                <?= View::escape(
                                    $document['file_name']
                                    ?? ''
                                ) ?>
                            </td>


                            <td>

                                <?php if (
                                    (int) (
                                        $document['is_active']
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
                                <?= number_format(
                                    (int) (
                                        $document['download_count']
                                        ?? 0
                                    )
                                ) ?>
                            </td>


                            <td>

                                <div
                                    style="
                                        display:flex;
                                        gap:6px;
                                        flex-wrap:wrap;
                                    "
                                >

                                    <a
                                        href="/admin/documents/<?= (int) $document['id'] ?>/edit"
                                        class="table-action"
                                    >
                                        ویرایش
                                    </a>

                                    <a
                                        href="/documents/<?= rawurlencode(
                                            $document['category_slug']
                                        ) ?>/<?= (int) $document['id'] ?>"
                                        class="table-action"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >
                                        دانلود
                                    </a>

                                    <form
                                        method="POST"
                                        action="/admin/documents/<?= (int) $document['id'] ?>/delete"
                                        onsubmit="return confirm('آیا از حذف این سند مطمئن هستید؟');"
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
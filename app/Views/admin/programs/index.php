<?php

declare(strict_types=1);

$items = $programs['items'] ?? [];

$total = (int) (
    $programs['total'] ?? 0
);

$pageNumber = (int) (
    $programs['page'] ?? 1
);

$totalPages = (int) (
    $programs['totalPages'] ?? 1
);
?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>
            <h1>
                رشته‌ها و برنامه‌های آموزشی
            </h1>

            <p>
                مدیریت رشته‌ها و برنامه‌های آموزشی دانشکده‌ها
            </p>
        </div>

        <a
            href="<?= View::route(
                'admin.programs.create'
            ) ?>"
            class="button button--primary"
        >
            + ایجاد برنامه
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
            برنامه
        </div>


        <?php if ($items === []): ?>

            <div
                style="
                    padding:50px 20px;
                    text-align:center;
                    color:#64748b;
                "
            >
                هنوز برنامه‌ای ثبت نشده است.
            </div>

        <?php else: ?>

            <div class="announcement-table-wrapper">

                <table class="announcement-table">

                    <thead>
                    <tr>
                        <th>نام برنامه</th>
                        <th>دانشکده</th>
                        <th>مقطع</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>

                    <tbody>

                    <?php foreach ($items as $program): ?>

                        <tr>

                            <td>
                                <strong>
                                    <?= View::escape(
                                        $program['name']
                                    ) ?>
                                </strong>

                                <?php if (
                                    !empty(
                                        $program['field']
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
                                            $program['field']
                                        ) ?>
                                    </div>

                                <?php endif; ?>
                            </td>

                            <td>
                                <?= View::escape(
                                    $program['faculty_name']
                                ) ?>
                            </td>

                            <td>
                                <?= View::escape(
                                    $program['degree']
                                    ?? '—'
                                ) ?>
                            </td>

                            <td>

                                <?php if (
                                    (int) (
                                        $program['is_active']
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

                                <a
                                    href="/admin/programs/<?= (int) $program['id'] ?>/edit"
                                    class="table-action"
                                >
                                    ویرایش
                                </a>

                                <form
                                    method="POST"
                                    action="/admin/programs/<?= (int) $program['id'] ?>/delete"
                                    style="display:inline"
                                    onsubmit="return confirm('آیا از حذف این برنامه مطمئن هستید؟');"
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


    <?php if ($totalPages > 1): ?>

        <div
            style="
                display:flex;
                justify-content:center;
                gap:8px;
                flex-wrap:wrap;
                margin-top:20px;
            "
        >

            <?php for (
                $i = 1;
                $i <= $totalPages;
                $i++
            ): ?>

                <a
                    href="/admin/programs?page=<?= $i ?>"
                    class="table-action <?= $i === $pageNumber ? 'table-action--active' : '' ?>"
                >
                    <?= $i ?>
                </a>

            <?php endfor; ?>

        </div>

    <?php endif; ?>

</div>
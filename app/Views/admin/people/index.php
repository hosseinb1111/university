<?php

declare(strict_types=1);

$items =
    $people['items'] ?? [];

$total =
    (int) (
        $people['total'] ?? 0
    );
?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>

            <h1>
                اعضای هیئت علمی و کارکنان
            </h1>

            <p>
                مدیریت اطلاعات اساتید، مدیران و کارکنان موسسه
            </p>

        </div>

        <a
            href="<?= View::route(
                'admin.people.create'
            ) ?>"
            class="button button--primary"
        >
            + افزودن شخص
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
            <?= number_format($total) ?>
            نفر
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
                هنوز شخصی ثبت نشده است.
            </div>

        <?php else: ?>

            <div class="announcement-table-wrapper">

                <table class="announcement-table">

                    <thead>

                    <tr>
                        <th>نام</th>
                        <th>سمت</th>
                        <th>دانشکده</th>
                        <th>ایمیل</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>

                    </thead>

                    <tbody>

                    <?php foreach (
                        $items
                        as $person
                    ): ?>

                        <tr>

                            <td>

                                <strong>
                                    <?= View::escape(
                                        trim(
                                            $person['first_name']
                                            . ' '
                                            . $person['last_name']
                                        )
                                    ) ?>
                                </strong>

                            </td>

                            <td>
                                <?= View::escape(
                                    $person['position']
                                    ?? '—'
                                ) ?>
                            </td>

                            <td>
                                <?= View::escape(
                                    $person['faculty_name']
                                    ?? '—'
                                ) ?>
                            </td>

                            <td>
                                <?= View::escape(
                                    $person['email']
                                    ?? '—'
                                ) ?>
                            </td>

                            <td>

                                <?php if (
                                    (int) (
                                        $person['is_active']
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
                                    href="/admin/people/<?= (int) $person['id'] ?>/edit"
                                    class="table-action"
                                >
                                    ویرایش
                                </a>

                                <a
                                    href="/people/<?= (int) $person['id'] ?>"
                                    class="table-action"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    مشاهده
                                </a>

                                <form
                                    method="POST"
                                    action="/admin/people/<?= (int) $person['id'] ?>/delete"
                                    style="display:inline"
                                    onsubmit="return confirm('آیا از حذف این شخص مطمئن هستید؟');"
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
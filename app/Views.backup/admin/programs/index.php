<?php
declare(strict_types=1);

use App\Core\View;
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
                Ø±Ø´ØªÙ‡â€ŒÙ‡Ø§ Ùˆ Ø¨Ø±Ù†Ø§Ù…Ù‡â€ŒÙ‡Ø§ÛŒ Ø¢Ù…ÙˆØ²Ø´ÛŒ
            </h1>

            <p>
                Ù…Ø¯ÛŒØ±ÛŒØª Ø±Ø´ØªÙ‡â€ŒÙ‡Ø§ Ùˆ Ø¨Ø±Ù†Ø§Ù…Ù‡â€ŒÙ‡Ø§ÛŒ Ø¢Ù…ÙˆØ²Ø´ÛŒ Ø¯Ø§Ù†Ø´Ú©Ø¯Ù‡â€ŒÙ‡Ø§
            </p>
        </div>

        <a
            href="<?= View::route(
                'admin.programs.create'
            ) ?>"
            class="button button--primary"
        >
            + Ø§ÛŒØ¬Ø§Ø¯ Ø¨Ø±Ù†Ø§Ù…Ù‡
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
            Ù…Ø¬Ù…ÙˆØ¹:
            <?= number_format($total) ?>
            Ø¨Ø±Ù†Ø§Ù…Ù‡
        </div>


        <?php if ($items === []): ?>

            <div
                style="
                    padding:50px 20px;
                    text-align:center;
                    color:#64748b;
                "
            >
                Ù‡Ù†ÙˆØ² Ø¨Ø±Ù†Ø§Ù…Ù‡â€ŒØ§ÛŒ Ø«Ø¨Øª Ù†Ø´Ø¯Ù‡ Ø§Ø³Øª.
            </div>

        <?php else: ?>

            <div class="announcement-table-wrapper">

                <table class="announcement-table">

                    <thead>
                    <tr>
                        <th>Ù†Ø§Ù… Ø¨Ø±Ù†Ø§Ù…Ù‡</th>
                        <th>Ø¯Ø§Ù†Ø´Ú©Ø¯Ù‡</th>
                        <th>Ù…Ù‚Ø·Ø¹</th>
                        <th>ÙˆØ¶Ø¹ÛŒØª</th>
                        <th>Ø¹Ù…Ù„ÛŒØ§Øª</th>
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
                                    ?? 'â€”'
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
                                        ÙØ¹Ø§Ù„
                                    </span>

                                <?php else: ?>

                                    <span
                                        class="announcement-status announcement-status--draft"
                                    >
                                        ØºÛŒØ±ÙØ¹Ø§Ù„
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>

                                <a
                                    href="/admin/programs/<?= (int) $program['id'] ?>/edit"
                                    class="table-action"
                                >
                                    ÙˆÛŒØ±Ø§ÛŒØ´
                                </a>

                                <form
                                    method="POST"
                                    action="/admin/programs/<?= (int) $program['id'] ?>/delete"
                                    style="display:inline"
                                    onsubmit="return confirm('Ø¢ÛŒØ§ Ø§Ø² Ø­Ø°Ù Ø§ÛŒÙ† Ø¨Ø±Ù†Ø§Ù…Ù‡ Ù…Ø·Ù…Ø¦Ù† Ù‡Ø³ØªÛŒØ¯ØŸ');"
                                >

                                    <?= \App\Core\Csrf::field() ?>

                                    <button
                                        type="submit"
                                        class="table-action table-action--danger"
                                    >
                                        Ø­Ø°Ù
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

<?php
declare(strict_types=1);

use App\Core\View;
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
                Ù¾Ú˜ÙˆÙ‡Ø´Ú©Ø¯Ù‡â€ŒÙ‡Ø§
            </h1>

            <p>
                Ù…Ø¯ÛŒØ±ÛŒØª Ù…Ø±Ø§Ú©Ø² Ùˆ Ù¾Ú˜ÙˆÙ‡Ø´Ú©Ø¯Ù‡â€ŒÙ‡Ø§ÛŒ Ù¾Ú˜ÙˆÙ‡Ø´ÛŒ Ù…ÙˆØ³Ø³Ù‡
            </p>
        </div>

        <a
            href="<?= View::route(
                'admin.research-centers.create'
            ) ?>"
            class="button button--primary"
        >
            + Ø§ÛŒØ¬Ø§Ø¯ Ù¾Ú˜ÙˆÙ‡Ø´Ú©Ø¯Ù‡
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
            Ù…Ø¬Ù…ÙˆØ¹:
            <?= number_format($total) ?>
            Ù¾Ú˜ÙˆÙ‡Ø´Ú©Ø¯Ù‡
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
                Ù‡Ù†ÙˆØ² Ù¾Ú˜ÙˆÙ‡Ø´Ú©Ø¯Ù‡â€ŒØ§ÛŒ Ø«Ø¨Øª Ù†Ø´Ø¯Ù‡ Ø§Ø³Øª.
            </div>

        <?php else: ?>

            <div class="announcement-table-wrapper">

                <table class="announcement-table">

                    <thead>
                    <tr>
                        <th>Ù†Ø§Ù…</th>
                        <th>Ù†Ø§Ù… Ú©ÙˆØªØ§Ù‡</th>
                        <th>ÙˆØ¶Ø¹ÛŒØª</th>
                        <th>ØªØ±ØªÛŒØ¨</th>
                        <th>Ø¹Ù…Ù„ÛŒØ§Øª</th>
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
                                    ?? 'â€”'
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
                                    ÙˆÛŒØ±Ø§ÛŒØ´
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
                                        Ù…Ø´Ø§Ù‡Ø¯Ù‡
                                    </a>

                                <?php endif; ?>

                                <form
                                    method="POST"
                                    action="/admin/research-centers/<?= (int) $center['id'] ?>/delete"
                                    style="display:inline"
                                    onsubmit="return confirm('Ø¢ÛŒØ§ Ø§Ø² Ø­Ø°Ù Ø§ÛŒÙ† Ù¾Ú˜ÙˆÙ‡Ø´Ú©Ø¯Ù‡ Ù…Ø·Ù…Ø¦Ù† Ù‡Ø³ØªÛŒØ¯ØŸ');"
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

</div>

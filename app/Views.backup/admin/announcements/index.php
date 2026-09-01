<?php
declare(strict_types=1);

use App\Core\View;
$items = $announcements['items'] ?? [];

$total = (int) (
    $announcements['total'] ?? 0
);

$page = (int) (
    $announcements['page'] ?? 1
);

$totalPages = (int) (
    $announcements['totalPages'] ?? 1
);
?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>

            <h1>
                Ø§Ø·Ù„Ø§Ø¹ÛŒÙ‡â€ŒÙ‡Ø§
            </h1>

            <p>
                Ù…Ø¯ÛŒØ±ÛŒØª Ø§Ø·Ù„Ø§Ø¹ÛŒÙ‡â€ŒÙ‡Ø§ÛŒ Ù…ÙˆØ³Ø³Ù‡
            </p>

        </div>

        <a
            href="<?= View::route(
                'admin.announcements.create'
            ) ?>"
            class="button button--primary"
        >
            + Ø§ÛŒØ¬Ø§Ø¯ Ø§Ø·Ù„Ø§Ø¹ÛŒÙ‡
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
            Ù…Ø¬Ù…ÙˆØ¹:
            <?= number_format(
                $total
            ) ?>
            Ø§Ø·Ù„Ø§Ø¹ÛŒÙ‡
        </div>


        <?php if ($items === []): ?>

            <div
                style="
                    padding:50px 20px;
                    text-align:center;
                    color:#64748b;
                "
            >
                Ù‡Ù†ÙˆØ² Ù‡ÛŒÚ† Ø§Ø·Ù„Ø§Ø¹ÛŒÙ‡â€ŒØ§ÛŒ Ø§ÛŒØ¬Ø§Ø¯ Ù†Ø´Ø¯Ù‡ Ø§Ø³Øª.
            </div>

        <?php else: ?>

            <div class="announcement-table-wrapper">

                <table class="announcement-table">

                    <thead>

                        <tr>
                            <th>Ø¹Ù†ÙˆØ§Ù†</th>
                            <th>ÙˆØ¶Ø¹ÛŒØª</th>
                            <th>Ø§Ù†ØªØ´Ø§Ø±</th>
                            <th>Ø¹Ù…Ù„ÛŒØ§Øª</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php foreach (
                        $items
                        as $announcement
                    ): ?>

                        <tr>

                            <td>

                                <strong>
                                    <?= View::escape(
                                        $announcement['title']
                                    ) ?>
                                </strong>

                                <div
                                    style="
                                        margin-top:4px;
                                        color:#94a3b8;
                                        font-size:12px;
                                    "
                                >
                                    /<?= View::escape(
                                        $announcement['slug']
                                    ) ?>
                                </div>

                            </td>


                            <td>

                                <?php
                                $status =
                                    $announcement['status']
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

                                        Ù…Ù†ØªØ´Ø± Ø´Ø¯Ù‡

                                    <?php elseif (
                                        $status === 'archived'
                                    ): ?>

                                        Ø¨Ø§ÛŒÚ¯Ø§Ù†ÛŒ Ø´Ø¯Ù‡

                                    <?php else: ?>

                                        Ù¾ÛŒØ´â€ŒÙ†ÙˆÛŒØ³

                                    <?php endif; ?>
                                </span>

                            </td>


                            <td>

                                <?= !empty(
                                    $announcement['published_at']
                                )
                                    ? View::escape(
                                        $announcement['published_at']
                                    )
                                    : 'â€”'
                                ?>

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
                                        href="/admin/announcements/<?= (int) $announcement['id'] ?>/edit"
                                        class="table-action"
                                    >
                                        ÙˆÛŒØ±Ø§ÛŒØ´
                                    </a>


                                    <?php if (
                                        $status !== 'published'
                                    ): ?>

                                        <form
                                            method="POST"
                                            action="/admin/announcements/<?= (int) $announcement['id'] ?>/publish"
                                        >

                                            <?= \App\Core\Csrf::field() ?>

                                            <button
                                                type="submit"
                                                class="table-action table-action--success"
                                            >
                                                Ø§Ù†ØªØ´Ø§Ø±
                                            </button>

                                        </form>

                                    <?php endif; ?>


                                    <?php if (
                                        $status !== 'archived'
                                    ): ?>

                                        <form
                                            method="POST"
                                            action="/admin/announcements/<?= (int) $announcement['id'] ?>/archive"
                                        >

                                            <?= \App\Core\Csrf::field() ?>

                                            <button
                                                type="submit"
                                                class="table-action"
                                            >
                                                Ø¨Ø§ÛŒÚ¯Ø§Ù†ÛŒ
                                            </button>

                                        </form>

                                    <?php endif; ?>


                                    <form
                                        method="POST"
                                        action="/admin/announcements/<?= (int) $announcement['id'] ?>/delete"
                                        onsubmit="return confirm('Ø¢ÛŒØ§ Ø§Ø² Ø­Ø°Ù Ø§ÛŒÙ† Ø§Ø·Ù„Ø§Ø¹ÛŒÙ‡ Ù…Ø·Ù…Ø¦Ù† Ù‡Ø³ØªÛŒØ¯ØŸ');"
                                    >

                                        <?= \App\Core\Csrf::field() ?>

                                        <button
                                            type="submit"
                                            class="table-action table-action--danger"
                                        >
                                            Ø­Ø°Ù
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
            "
        >

            <?php for (
                $i = 1;
                $i <= $totalPages;
                $i++
            ): ?>

                <a
                    href="/admin/announcements?page=<?= $i ?>"
                    class="table-action <?= $i === $page ? 'table-action--active' : '' ?>"
                >
                    <?= $i ?>
                </a>

            <?php endfor; ?>

        </div>

    <?php endif; ?>

</div>

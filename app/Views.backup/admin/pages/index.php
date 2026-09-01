<?php
declare(strict_types=1);

use App\Core\View;
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
                ØµÙØ­Ø§Øª Ø³Ø§ÛŒØª
            </h1>

            <p>
                Ù…Ø¯ÛŒØ±ÛŒØª ØµÙØ­Ø§Øª Ùˆ Ù…Ø­ØªÙˆØ§ÛŒ Ø§ØµÙ„ÛŒ Ø³Ø§ÛŒØª
            </p>
        </div>

        <a
            href="<?= View::route(
                'admin.pages.create'
            ) ?>"
            class="button button--primary"
        >
            + Ø§ÛŒØ¬Ø§Ø¯ ØµÙØ­Ù‡
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
            Ù…Ø¬Ù…ÙˆØ¹:
            <?= number_format(
                $total
            ) ?>
            ØµÙØ­Ù‡
        </div>


        <?php if ($items === []): ?>

            <div
                style="
                    padding:50px 20px;
                    text-align:center;
                    color:#64748b;
                "
            >
                Ù‡Ù†ÙˆØ² ØµÙØ­Ù‡â€ŒØ§ÛŒ Ø§ÛŒØ¬Ø§Ø¯ Ù†Ø´Ø¯Ù‡ Ø§Ø³Øª.
            </div>

        <?php else: ?>

            <div class="announcement-table-wrapper">

                <table class="announcement-table">

                    <thead>

                    <tr>
                        <th>Ø¹Ù†ÙˆØ§Ù†</th>
                        <th>ÙˆØ§Ù„Ø¯</th>
                        <th>ÙˆØ¶Ø¹ÛŒØª</th>
                        <th>Ø¢Ø¯Ø±Ø³</th>
                        <th>Ø¹Ù…Ù„ÛŒØ§Øª</th>
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
                                    ?? 'â€”'
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

                                        Ù…Ù†ØªØ´Ø± Ø´Ø¯Ù‡

                                    <?php elseif (
                                        $status === 'private'
                                    ): ?>

                                        Ø®ØµÙˆØµÛŒ

                                    <?php else: ?>

                                        Ù¾ÛŒØ´â€ŒÙ†ÙˆÛŒØ³

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
                                            Ù…Ø´Ø§Ù‡Ø¯Ù‡
                                        </a>

                                    <?php endif; ?>

                                    <a
                                        href="/admin/pages/<?= (int) $page['id'] ?>/edit"
                                        class="table-action"
                                    >
                                        ÙˆÛŒØ±Ø§ÛŒØ´
                                    </a>

                                    <form
                                        method="POST"
                                        action="/admin/pages/<?= (int) $page['id'] ?>/delete"
                                        onsubmit="return confirm('Ø¢ÛŒØ§ Ø§Ø² Ø­Ø°Ù Ø§ÛŒÙ† ØµÙØ­Ù‡ Ù…Ø·Ù…Ø¦Ù† Ù‡Ø³ØªÛŒØ¯ØŸ');"
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

<?php
declare(strict_types=1);

use App\Core\View;
?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>
            <h1>
                Ù…Ù†ÙˆÛŒ Ø³Ø§ÛŒØª
            </h1>

            <p>
                Ù…Ø¯ÛŒØ±ÛŒØª Ø³Ø§Ø®ØªØ§Ø± Ù…Ù†ÙˆÛŒ Ø§ØµÙ„ÛŒ Ùˆ Ø²ÛŒØ±Ù…Ù†ÙˆÙ‡Ø§ÛŒ Ø³Ø§ÛŒØª
            </p>
        </div>

        <a
            href="<?= View::route(
                'admin.navigation.create'
            ) ?>"
            class="button button--primary"
        >
            + Ø§ÙØ²ÙˆØ¯Ù† Ø¢ÛŒØªÙ…
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
                Ù‡Ù†ÙˆØ² Ø¢ÛŒØªÙ…ÛŒ Ø¨Ø±Ø§ÛŒ Ù…Ù†ÙˆÛŒ Ø³Ø§ÛŒØª Ø§ÛŒØ¬Ø§Ø¯ Ù†Ø´Ø¯Ù‡ Ø§Ø³Øª.
            </div>

        <?php else: ?>

            <div class="announcement-table-wrapper">

                <table class="announcement-table">

                    <thead>

                    <tr>
                        <th>Ø¹Ù†ÙˆØ§Ù†</th>
                        <th>ÙˆØ§Ù„Ø¯</th>
                        <th>Ù…Ù‚ØµØ¯</th>
                        <th>ÙˆØ¶Ø¹ÛŒØª</th>
                        <th>ØªØ±ØªÛŒØ¨</th>
                        <th>Ø¹Ù…Ù„ÛŒØ§Øª</th>
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
                                    ?? 'Ù…Ù†ÙˆÛŒ Ø§ØµÙ„ÛŒ'
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
                                        ÙØ¹Ø§Ù„
                                    </span>

                                <?php else: ?>

                                    <span class="announcement-status announcement-status--draft">
                                        ØºÛŒØ±ÙØ¹Ø§Ù„
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
                                        ÙˆÛŒØ±Ø§ÛŒØ´
                                    </a>

                                    <form
                                        method="POST"
                                        action="/admin/navigation/<?= (int) $item['id'] ?>/delete"
                                        onsubmit="return confirm('Ø¢ÛŒØ§ Ø§Ø² Ø­Ø°Ù Ø§ÛŒÙ† Ø¢ÛŒØªÙ… Ù…Ø·Ù…Ø¦Ù† Ù‡Ø³ØªÛŒØ¯ØŸ');"
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

</div>

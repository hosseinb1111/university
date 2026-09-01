<?php
declare(strict_types=1);

use App\Core\View;
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
                Ø§Ø³Ù†Ø§Ø¯ Ùˆ ÙØ±Ù…â€ŒÙ‡Ø§
            </h1>

            <p>
                Ù…Ø¯ÛŒØ±ÛŒØª ÙØ±Ù…â€ŒÙ‡Ø§ØŒ Ø¢ÛŒÛŒÙ†â€ŒÙ†Ø§Ù…Ù‡â€ŒÙ‡Ø§ Ùˆ ÙØ§ÛŒÙ„â€ŒÙ‡Ø§ÛŒ Ù…ÙˆØ³Ø³Ù‡
            </p>
        </div>

        <a
            href="<?= View::route(
                'admin.documents.create'
            ) ?>"
            class="button button--primary"
        >
            + Ø§ÙØ²ÙˆØ¯Ù† Ø³Ù†Ø¯
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
            Ø³Ù†Ø¯
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
                Ù‡Ù†ÙˆØ² Ø³Ù†Ø¯ÛŒ Ø«Ø¨Øª Ù†Ø´Ø¯Ù‡ Ø§Ø³Øª.
            </div>

        <?php else: ?>

            <div class="announcement-table-wrapper">

                <table class="announcement-table">

                    <thead>

                    <tr>
                        <th>Ø¹Ù†ÙˆØ§Ù†</th>
                        <th>Ø¯Ø³ØªÙ‡</th>
                        <th>ÙØ§ÛŒÙ„</th>
                        <th>ÙˆØ¶Ø¹ÛŒØª</th>
                        <th>Ø¯Ø§Ù†Ù„ÙˆØ¯</th>
                        <th>Ø¹Ù…Ù„ÛŒØ§Øª</th>
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
                                        ÙˆÛŒØ±Ø§ÛŒØ´
                                    </a>

                                    <a
                                        href="/documents/<?= rawurlencode(
                                            $document['category_slug']
                                        ) ?>/<?= (int) $document['id'] ?>"
                                        class="table-action"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >
                                        Ø¯Ø§Ù†Ù„ÙˆØ¯
                                    </a>

                                    <form
                                        method="POST"
                                        action="/admin/documents/<?= (int) $document['id'] ?>/delete"
                                        onsubmit="return confirm('Ø¢ÛŒØ§ Ø§Ø² Ø­Ø°Ù Ø§ÛŒÙ† Ø³Ù†Ø¯ Ù…Ø·Ù…Ø¦Ù† Ù‡Ø³ØªÛŒØ¯ØŸ');"
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

<?php
declare(strict_types=1);

use App\Core\View;
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
                Ø§Ø¹Ø¶Ø§ÛŒ Ù‡ÛŒØ¦Øª Ø¹Ù„Ù…ÛŒ Ùˆ Ú©Ø§Ø±Ú©Ù†Ø§Ù†
            </h1>

            <p>
                Ù…Ø¯ÛŒØ±ÛŒØª Ø§Ø·Ù„Ø§Ø¹Ø§Øª Ø§Ø³Ø§ØªÛŒØ¯ØŒ Ù…Ø¯ÛŒØ±Ø§Ù† Ùˆ Ú©Ø§Ø±Ú©Ù†Ø§Ù† Ù…ÙˆØ³Ø³Ù‡
            </p>

        </div>

        <a
            href="<?= View::route(
                'admin.people.create'
            ) ?>"
            class="button button--primary"
        >
            + Ø§ÙØ²ÙˆØ¯Ù† Ø´Ø®Øµ
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
            <?= number_format($total) ?>
            Ù†ÙØ±
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
                Ù‡Ù†ÙˆØ² Ø´Ø®ØµÛŒ Ø«Ø¨Øª Ù†Ø´Ø¯Ù‡ Ø§Ø³Øª.
            </div>

        <?php else: ?>

            <div class="announcement-table-wrapper">

                <table class="announcement-table">

                    <thead>

                    <tr>
                        <th>Ù†Ø§Ù…</th>
                        <th>Ø³Ù…Øª</th>
                        <th>Ø¯Ø§Ù†Ø´Ú©Ø¯Ù‡</th>
                        <th>Ø§ÛŒÙ…ÛŒÙ„</th>
                        <th>ÙˆØ¶Ø¹ÛŒØª</th>
                        <th>Ø¹Ù…Ù„ÛŒØ§Øª</th>
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
                                    ?? 'â€”'
                                ) ?>
                            </td>

                            <td>
                                <?= View::escape(
                                    $person['faculty_name']
                                    ?? 'â€”'
                                ) ?>
                            </td>

                            <td>
                                <?= View::escape(
                                    $person['email']
                                    ?? 'â€”'
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
                                    href="/admin/people/<?= (int) $person['id'] ?>/edit"
                                    class="table-action"
                                >
                                    ÙˆÛŒØ±Ø§ÛŒØ´
                                </a>

                                <a
                                    href="/people/<?= (int) $person['id'] ?>"
                                    class="table-action"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    Ù…Ø´Ø§Ù‡Ø¯Ù‡
                                </a>

                                <form
                                    method="POST"
                                    action="/admin/people/<?= (int) $person['id'] ?>/delete"
                                    style="display:inline"
                                    onsubmit="return confirm('Ø¢ÛŒØ§ Ø§Ø² Ø­Ø°Ù Ø§ÛŒÙ† Ø´Ø®Øµ Ù…Ø·Ù…Ø¦Ù† Ù‡Ø³ØªÛŒØ¯ØŸ');"
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

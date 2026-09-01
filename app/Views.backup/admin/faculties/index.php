<?php
declare(strict_types=1);

use App\Core\View;
$items =
    $faculties['items']
    ?? [];

$total =
    (int) (
        $faculties['total']
        ?? 0
    );
?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>
            <h1>
                Ø¯Ø§Ù†Ø´Ú©Ø¯Ù‡â€ŒÙ‡Ø§
            </h1>

            <p>
                Ù…Ø¯ÛŒØ±ÛŒØª Ø¯Ø§Ù†Ø´Ú©Ø¯Ù‡â€ŒÙ‡Ø§ Ùˆ Ú¯Ø±ÙˆÙ‡â€ŒÙ‡Ø§ÛŒ Ø¢Ù…ÙˆØ²Ø´ÛŒ
            </p>
        </div>

        <a
            href="<?= View::route(
                'admin.faculties.create'
            ) ?>"
            class="button button--primary"
        >
            + Ø§ÛŒØ¬Ø§Ø¯ Ø¯Ø§Ù†Ø´Ú©Ø¯Ù‡
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
            Ø¯Ø§Ù†Ø´Ú©Ø¯Ù‡
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
                Ù‡Ù†ÙˆØ² Ø¯Ø§Ù†Ø´Ú©Ø¯Ù‡â€ŒØ§ÛŒ Ø§ÛŒØ¬Ø§Ø¯ Ù†Ø´Ø¯Ù‡ Ø§Ø³Øª.
            </div>

        <?php else: ?>

            <div class="announcement-table-wrapper">

                <table class="announcement-table">

                    <thead>
                    <tr>
                        <th>Ù†Ø§Ù…</th>
                        <th>Ù†Ø§Ù… Ú©ÙˆØªØ§Ù‡</th>
                        <th>Ø±Ø¦ÛŒØ³</th>
                        <th>ÙˆØ¶Ø¹ÛŒØª</th>
                        <th>Ø¹Ù…Ù„ÛŒØ§Øª</th>
                    </tr>
                    </thead>

                    <tbody>

                    <?php foreach (
                        $items as $faculty
                    ): ?>

                        <tr>

                            <td>
                                <strong>
                                    <?= View::escape(
                                        $faculty['name']
                                    ) ?>
                                </strong>
                            </td>

                            <td>
                                <?= View::escape(
                                    $faculty['short_name']
                                    ?? 'â€”'
                                ) ?>
                            </td>

                            <td>
                                <?php
                                $deanName =
                                    trim(
                                        (
                                            $faculty[
                                                'dean_first_name'
                                            ] ?? ''
                                        )
                                        . ' '
                                        . (
                                            $faculty[
                                                'dean_last_name'
                                            ] ?? ''
                                        )
                                    );
                                ?>

                                <?= View::escape(
                                    $deanName ?: 'â€”'
                                ) ?>
                            </td>

                            <td>

                                <?php if (
                                    (int) (
                                        $faculty['is_active']
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

                                <a
                                    href="/admin/faculties/<?= (int) $faculty['id'] ?>/edit"
                                    class="table-action"
                                >
                                    ÙˆÛŒØ±Ø§ÛŒØ´
                                </a>

                                <form
                                    method="POST"
                                    action="/admin/faculties/<?= (int) $faculty['id'] ?>/delete"
                                    style="display:inline"
                                    onsubmit="return confirm('Ø­Ø°Ù Ø¯Ø§Ù†Ø´Ú©Ø¯Ù‡ Ø¨Ø§Ø¹Ø« Ø­Ø°Ù Ø±Ø´ØªÙ‡â€ŒÙ‡Ø§ÛŒ Ù…Ø±ØªØ¨Ø· Ù†ÛŒØ² Ù…ÛŒâ€ŒØ´ÙˆØ¯. Ø§Ø¯Ø§Ù…Ù‡ Ù…ÛŒâ€ŒØ¯Ù‡ÛŒØ¯ØŸ');"
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

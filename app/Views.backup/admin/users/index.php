<?php
declare(strict_types=1);

use App\Core\View;
$items =
    $users['items'] ?? [];

$total =
    (int) (
        $users['total'] ?? 0
    );

$pageNumber =
    (int) (
        $users['page'] ?? 1
    );

$totalPages =
    (int) (
        $users['totalPages'] ?? 1
    );

$error =
    \App\Core\Session::getFlash(
        'error'
    );
?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>

            <h1>
                Ú©Ø§Ø±Ø¨Ø±Ø§Ù†
            </h1>

            <p>
                Ù…Ø¯ÛŒØ±ÛŒØª Ø­Ø³Ø§Ø¨â€ŒÙ‡Ø§ÛŒ Ú©Ø§Ø±Ø¨Ø±ÛŒ Ø³Ø§Ù…Ø§Ù†Ù‡
            </p>

        </div>

        <a
            href="<?= View::route(
                'admin.users.create'
            ) ?>"
            class="button button--primary"
        >
            + Ø§ÛŒØ¬Ø§Ø¯ Ú©Ø§Ø±Ø¨Ø±
        </a>

    </div>


    <?php if (
        is_string($error)
        && $error !== ''
    ): ?>

        <div class="form-errors">
            <?= View::escape($error) ?>
        </div>

    <?php endif; ?>


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
            Ú©Ø§Ø±Ø¨Ø±
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
                Ù‡Ù†ÙˆØ² Ú©Ø§Ø±Ø¨Ø±ÛŒ Ø§ÛŒØ¬Ø§Ø¯ Ù†Ø´Ø¯Ù‡ Ø§Ø³Øª.
            </div>

        <?php else: ?>

            <div class="announcement-table-wrapper">

                <table class="announcement-table">

                    <thead>

                    <tr>
                        <th>Ú©Ø§Ø±Ø¨Ø±</th>
                        <th>Ø§ÛŒÙ…ÛŒÙ„</th>
                        <th>Ù†Ù‚Ø´</th>
                        <th>ÙˆØ¶Ø¹ÛŒØª</th>
                        <th>Ø¢Ø®Ø±ÛŒÙ† ÙˆØ±ÙˆØ¯</th>
                        <th>Ø¹Ù…Ù„ÛŒØ§Øª</th>
                    </tr>

                    </thead>

                    <tbody>

                    <?php foreach (
                        $items
                        as $account
                    ): ?>

                        <?php
                        $fullName =
                            trim(
                                ($account['first_name'] ?? '')
                                . ' '
                                . ($account['last_name'] ?? '')
                            );
                        ?>

                        <tr>

                            <td>

                                <strong>
                                    <?= View::escape(
                                        $fullName
                                        !== ''
                                            ? $fullName
                                            : $account['username']
                                    ) ?>
                                </strong>

                                <div
                                    style="
                                        margin-top:4px;
                                        color:#94a3b8;
                                        font-size:12px;
                                    "
                                >
                                    <?= View::escape(
                                        $account['username']
                                    ) ?>
                                </div>

                            </td>


                            <td>
                                <?= View::escape(
                                    $account['email']
                                    ?? 'â€”'
                                ) ?>
                            </td>


                            <td>

                                <?php
                                $labels = [
                                    'super_admin' =>
                                        'Ù…Ø¯ÛŒØ± Ø§Ø±Ø´Ø¯',

                                    'admin' =>
                                        'Ù…Ø¯ÛŒØ±',

                                    'editor' =>
                                        'ÙˆÛŒØ±Ø§Ø³ØªØ§Ø±',

                                    'teacher' =>
                                        'Ø¹Ø¶Ùˆ Ù‡ÛŒØ¦Øª Ø¹Ù„Ù…ÛŒ',
                                ];
                                ?>

                                <span
                                    class="announcement-status announcement-status--published"
                                >
                                    <?= View::escape(
                                        $labels[
                                            $account['role']
                                        ]
                                        ?? $account['role']
                                    ) ?>
                                </span>

                            </td>


                            <td>

                                <?php if (
                                    (int) (
                                        $account['is_active']
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
                                <?= View::escape(
                                    $account['last_login_at']
                                    ?? 'â€”'
                                ) ?>
                            </td>


                            <td>

                                <a
                                    href="/admin/users/<?= (int) $account['id'] ?>/edit"
                                    class="table-action"
                                >
                                    ÙˆÛŒØ±Ø§ÛŒØ´
                                </a>


                                <form
                                    method="POST"
                                    action="/admin/users/<?= (int) $account['id'] ?>/delete"
                                    style="display:inline"
                                    onsubmit="return confirm('Ø¢ÛŒØ§ Ø§Ø² Ø­Ø°Ù Ø§ÛŒÙ† Ú©Ø§Ø±Ø¨Ø± Ù…Ø·Ù…Ø¦Ù† Ù‡Ø³ØªÛŒØ¯ØŸ');"
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


    <?php if (
        $totalPages > 1
    ): ?>

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
                    href="/admin/users?page=<?= $i ?>"
                    class="table-action <?= $i === $pageNumber ? 'table-action--active' : '' ?>"
                >
                    <?= $i ?>
                </a>

            <?php endfor; ?>

        </div>

    <?php endif; ?>

</div>

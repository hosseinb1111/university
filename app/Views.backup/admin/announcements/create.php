<?php
declare(strict_types=1);

use App\Core\View;
?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>

            <h1>
                Ø§ÛŒØ¬Ø§Ø¯ Ø§Ø·Ù„Ø§Ø¹ÛŒÙ‡
            </h1>

            <p>
                Ø§Ø·Ù„Ø§Ø¹ÛŒÙ‡ Ø¬Ø¯ÛŒØ¯ Ø¨Ø±Ø§ÛŒ Ø³Ø§ÛŒØª Ø§ÛŒØ¬Ø§Ø¯ Ú©Ù†ÛŒØ¯.
            </p>

        </div>

    </div>


    <div class="admin-panel">

        <?php
        $action = View::route(
            'admin.announcements.store'
        );

        $submitLabel = 'Ø§ÛŒØ¬Ø§Ø¯ Ø§Ø·Ù„Ø§Ø¹ÛŒÙ‡';

        require __DIR__ . '/_form.php';
        ?>

    </div>

</div>

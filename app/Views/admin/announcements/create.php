<?php

declare(strict_types=1);
?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>

            <h1>
                ایجاد اطلاعیه
            </h1>

            <p>
                اطلاعیه جدید برای سایت ایجاد کنید.
            </p>

        </div>

    </div>


    <div class="admin-panel">

        <?php
        $action = View::route(
            'admin.announcements.store'
        );

        $submitLabel = 'ایجاد اطلاعیه';

        require __DIR__ . '/_form.php';
        ?>

    </div>

</div>
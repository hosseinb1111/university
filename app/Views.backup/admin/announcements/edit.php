<?php

declare(strict_types=1);
?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>

            <h1>
                ویرایش اطلاعیه
            </h1>

            <p>
                اطلاعات اطلاعیه را ویرایش کنید.
            </p>

        </div>

    </div>


    <div class="admin-panel">

        <?php
        $action =
            '/admin/announcements/'
            . (int) $announcement['id'];

        $submitLabel = 'ذخیره تغییرات';

        require __DIR__ . '/_form.php';
        ?>

    </div>

</div>
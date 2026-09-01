<?php

declare(strict_types=1);

use App\Core\View;

?>

<div class="admin-page admin-announcements-page">

    <div class="admin-announcements-form-header">

        <div>

            <span class="admin-announcements-form-header__eyebrow">
                مدیریت اطلاعیه‌ها
            </span>

            <h1>
                ویرایش اطلاعیه
            </h1>

            <p>
                اطلاعات اطلاعیه را ویرایش و تغییرات را ذخیره کنید.
            </p>

        </div>


        <div class="admin-announcements-form-header__actions">

            <a
                href="<?= View::route(
                    'admin.announcements.index'
                ) ?>"
                class="admin-announcement-secondary-button"
            >
                <span aria-hidden="true">
                    ←
                </span>

                بازگشت به اطلاعیه‌ها
            </a>

        </div>

    </div>


    <div class="admin-announcement-form-card">

        <?php

        $action =
            View::url(
                '/admin/announcements/'
                . (int) (
                    $announcement['id']
                    ?? 0
                )
            );

        $submitLabel =
            'ذخیره تغییرات';

        require __DIR__ . '/_form.php';

        ?>

    </div>

</div>
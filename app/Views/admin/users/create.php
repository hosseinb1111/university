<?php

declare(strict_types=1);

use App\Core\Session;
use App\Core\View;


$form =
    Session::getFlash(
        'user_form'
    );


$formErrors =
    Session::getFlash(
        'user_errors'
    );


$user =
    is_array(
        $user ?? null
    )
        ? $user
        : [];


if (
    is_array($form)
) {
    $user =
        array_merge(
            $user,
            $form
        );
}


$errors =
    is_array(
        $formErrors
    )
        ? $formErrors
        : [];


$action =
    View::route(
        'admin.users.store'
    );


$submitLabel =
    'ایجاد کاربر';

?>

<div class="admin-users">


    <header class="admin-users__header">

        <div class="admin-users__header-main">

            <span class="admin-users__eyebrow">
                مدیریت دسترسی
            </span>


            <h1>
                ایجاد کاربر
            </h1>


            <p>
                یک حساب کاربری جدید برای استفاده از سامانه ایجاد کنید.
            </p>

        </div>


        <div class="admin-users__header-action">

            <a
                href="<?= View::route(
                    'admin.users.index'
                ) ?>"
                class="admin-users__create-button"
            >

                ←
                بازگشت به کاربران

            </a>

        </div>

    </header>


    <?php

    require __DIR__
        . '/_form.php';

    ?>

</div>
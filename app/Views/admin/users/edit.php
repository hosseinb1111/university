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
    '/admin/users/'
    . (int) (
        $user['id']
        ?? 0
    );


$submitLabel =
    'ذخیره تغییرات';

?>

<div class="admin-users">


    <header class="admin-users__header">

        <div class="admin-users__header-main">

            <span class="admin-users__eyebrow">
                مدیریت دسترسی
            </span>


            <h1>
                ویرایش کاربر
            </h1>


            <p>
                اطلاعات حساب، نقش و وضعیت دسترسی این کاربر را مدیریت کنید.
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
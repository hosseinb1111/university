<?php

declare(strict_types=1);

use App\Core\Session;
use App\Core\View;


$form =
    Session::getFlash(
        'navigation_form'
    );


$formErrors =
    Session::getFlash(
        'navigation_errors'
    );


if (
    is_array($form)
) {
    $item =
        array_merge(
            $item,
            $form
        );
}


$errors =
    is_array($formErrors)
        ? $formErrors
        : [];


$action =
    View::route(
        'admin.navigation.store'
    );


$submitLabel =
    'ایجاد آیتم';

?>

<div class="admin-navigation">

    <header class="admin-navigation__header">

        <div class="admin-navigation__header-main">

            <span class="admin-navigation__eyebrow">
                ساختار سایت
            </span>

            <h1>
                افزودن آیتم منو
            </h1>

            <p>
                یک آیتم جدید برای منوی اصلی یا بخش سامانه‌ها و خدمات ایجاد کنید.
            </p>

        </div>


        <div class="admin-navigation__header-action">

            <a
                href="<?= View::route(
                    'admin.navigation.index'
                ) ?>"
                class="admin-navigation__action"
            >
                بازگشت
            </a>

        </div>

    </header>


    <?php

    require __DIR__
        . '/_form.php';

    ?>

</div>
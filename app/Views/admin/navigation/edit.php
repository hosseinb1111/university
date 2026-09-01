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


$itemId =
    (int) (
        $item['id']
        ?? 0
    );


$action =
    View::url(
        '/admin/navigation/'
        . $itemId
);


$submitLabel =
    'ذخیره تغییرات';

?>

<div class="admin-navigation">

    <header class="admin-navigation__header">

        <div class="admin-navigation__header-main">

            <span class="admin-navigation__eyebrow">
                ساختار سایت
            </span>

            <h1>
                ویرایش آیتم منو
            </h1>

            <p>
                اطلاعات، مقصد و وضعیت این آیتم را تغییر دهید.
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
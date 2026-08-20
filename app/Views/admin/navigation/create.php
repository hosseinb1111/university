<?php

declare(strict_types=1);

use App\Core\Session;

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
    $item = array_merge(
        $item,
        $form
    );
}

if (
    is_array($formErrors)
) {
    $errors = $formErrors;
}

$action =
    View::route(
        'admin.navigation.store'
    );

$submitLabel =
    'ایجاد آیتم';

require __DIR__
    . '/_form.php';
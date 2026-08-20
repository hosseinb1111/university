<?php

declare(strict_types=1);

use App\Core\Session;

$form =
    Session::getFlash(
        'user_form'
    );

$formErrors =
    Session::getFlash(
        'user_errors'
    );

if (is_array($form)) {
    $user =
        array_merge(
            $user,
            $form
        );
}

if (is_array($formErrors)) {
    $errors =
        $formErrors;
}

$action =
    '/admin/users/'
    . (int) $user['id'];

$submitLabel =
    'ذخیره تغییرات';

require __DIR__
    . '/_form.php';
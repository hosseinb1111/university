<?php

declare(strict_types=1);

use App\Core\Session;

$form =
    Session::getFlash(
        'person_form'
    );

$formErrors =
    Session::getFlash(
        'person_errors'
    );

if (is_array($form)) {
    $person = array_merge(
        $person,
        $form
    );
}

if (is_array($formErrors)) {
    $errors = $formErrors;
}

$action =
    View::route(
        'admin.people.store'
    );

$submitLabel =
    'ایجاد شخص';

require __DIR__
    . '/_form.php';
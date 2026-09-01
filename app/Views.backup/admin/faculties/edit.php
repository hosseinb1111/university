<?php

declare(strict_types=1);

use App\Core\Session;

$form =
    Session::getFlash(
        'faculty_form'
    );

$formErrors =
    Session::getFlash(
        'faculty_errors'
    );

if (
    is_array($form)
) {
    $faculty =
        array_merge(
            $faculty,
            $form
        );
}

if (
    is_array($formErrors)
) {
    $errors =
        $formErrors;
}

$action =
    '/admin/faculties/'
    . (int) $faculty['id'];

$submitLabel =
    'ذخیره تغییرات';

require __DIR__
    . '/_form.php';
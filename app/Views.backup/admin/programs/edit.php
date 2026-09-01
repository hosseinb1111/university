<?php

declare(strict_types=1);

use App\Core\Session;

$form = Session::getFlash(
    'program_form'
);

$formErrors = Session::getFlash(
    'program_errors'
);

if (is_array($form)) {
    $program = array_merge(
        $program,
        $form
    );
}

if (is_array($formErrors)) {
    $errors = $formErrors;
}

$action =
    '/admin/programs/'
    . (int) $program['id'];

$submitLabel = 'ذخیره تغییرات';

require __DIR__ . '/_form.php';
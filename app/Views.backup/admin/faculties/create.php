<?php
declare(strict_types=1);

use App\Core\View;
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
    View::route(
        'admin.faculties.store'
    );

$submitLabel =
    'Ø§ÛŒØ¬Ø§Ø¯ Ø¯Ø§Ù†Ø´Ú©Ø¯Ù‡';

require __DIR__
    . '/_form.php';

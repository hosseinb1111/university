<?php
declare(strict_types=1);

use App\Core\View;
use App\Core\Session;

$form =
    Session::getFlash(
        'research_center_form'
    );

$formErrors =
    Session::getFlash(
        'research_center_errors'
    );

if (is_array($form)) {
    $center = array_merge(
        $center,
        $form
    );
}

if (is_array($formErrors)) {
    $errors = $formErrors;
}

$action =
    View::route(
        'admin.research-centers.store'
    );

$submitLabel =
    'Ø§ÛŒØ¬Ø§Ø¯ Ù¾Ú˜ÙˆÙ‡Ø´Ú©Ø¯Ù‡';

require __DIR__
    . '/_form.php';

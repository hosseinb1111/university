<?php

declare(strict_types=1);

use App\Core\Session;

$formPage =
    Session::getFlash(
        'page_form'
    );

$formErrors =
    Session::getFlash(
        'page_errors'
    );

if (
    is_array($formPage)
) {
    $page = array_merge(
        $page,
        $formPage
    );
}

if (
    is_array($formErrors)
) {
    $errors = $formErrors;
}

$action =
    '/admin/pages/'
    . (int) $page['id'];

$submitLabel =
    'ذخیره تغییرات';

require __DIR__
    . '/_form.php';
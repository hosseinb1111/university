<?php

declare(strict_types=1);

use App\Core\Session;

$form =
    Session::getFlash(
        'slide_form'
    );

$formErrors =
    Session::getFlash(
        'slide_errors'
    );

if (
    !isset($slide)
    || !is_array($slide)
) {
    $slide = [];
}

if (
    is_array($form)
) {
    $slide =
        array_merge(
            $slide,
            $form
        );
}

$errors =
    is_array($formErrors)
        ? $formErrors
        : [];

$slideId =
    (int) (
        $slide['id']
        ?? 0
    );

$action =
    '/admin/slides/'
    . $slideId;

$submitLabel =
    'ذخیره تغییرات';

require __DIR__
    . '/_form.php';
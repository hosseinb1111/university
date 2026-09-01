<?php

declare(strict_types=1);

use App\Core\View;

View::display(
    'admin/services/_form',
    [
        'item' =>
            $item ?? [],

        'errors' =>
            $errors ?? [],

        'action' =>
            $action ?? '',

        'submitLabel' =>
            $submitLabel ?? 'ایجاد خدمت',
    ]
);
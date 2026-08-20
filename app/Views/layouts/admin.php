<?php

declare(strict_types=1);

use App\Core\Session;
use App\Core\View;

$user = $user ?? Session::user();
$title = $title ?? 'پنل مدیریت | صدرا';

$currentPath = parse_url(
    $_SERVER['REQUEST_URI'] ?? '/',
    PHP_URL_PATH
);

if (!is_string($currentPath)) {
    $currentPath = '/admin';
}

?>
<!DOCTYPE html>

<html
    lang="fa"
    dir="rtl"
>
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>
        <?= htmlspecialchars(
            $title,
            ENT_QUOTES,
            'UTF-8'
        ) ?>
    </title>

    <link
        rel="stylesheet"
        href="/assets/css/admin.css"
    >
<link
    rel="stylesheet"
    href="/assets/css/announcements.css"
>
<link
    rel="stylesheet"
    href="/assets/css/media.css"
>
</head>

<body class="admin-body">

<div class="admin-layout">

    <aside
        class="admin-sidebar"
        id="admin-sidebar"
    >

        <?php

        echo View::render(
            'admin/partials/sidebar',
            [
                'user' => $user,
                'currentPath' => $currentPath,
            ]
        );

        ?>

    </aside>


    <div class="admin-main">

        <header class="admin-header">

            <?php

            echo View::render(
                'admin/partials/header',
                [
                    'user' => $user,
                    'title' => $title,
                ]
            );

            ?>

        </header>


        <main class="admin-content">

            <?= $content ?? '' ?>

        </main>

    </div>

</div>


<script src="/assets/js/admin.js"></script>

</body>
</html>
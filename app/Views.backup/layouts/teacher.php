<?php

declare(strict_types=1);

use App\Core\View;

$title =
    $title
    ?? 'پنل صدرا';
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
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="robots"
        content="noindex,nofollow"
    >

    <title>
        <?= View::escape($title) ?>
    </title>

    <link
        rel="stylesheet"
        href="/assets/css/app.css"
    >

    <link
        rel="stylesheet"
        href="/assets/css/teacher.css"
    >

</head>

<body class="teacher-layout">

    <div class="teacher-shell">

        <aside class="teacher-sidebar">

            <a
                href="/teacher/dashboard"
                class="teacher-brand"
            >

                <span class="teacher-brand__logo">
                    ص
                </span>

                <span>

                    <strong>
                        موسسه صدرا
                    </strong>

                    <small>
                        پنل اعضای هیئت علمی
                    </small>

                </span>

            </a>


            <nav
                class="teacher-nav"
                aria-label="پنل اعضای هیئت علمی"
            >

                <a
                    href="/teacher/dashboard"
                    class="teacher-nav__link"
                >
                    داشبورد
                </a>

                <a
                    href="/teacher/profile"
                    class="teacher-nav__link"
                >
                    پروفایل من
                </a>

                <a
                    href="/"
                    class="teacher-nav__link"
                >
                    مشاهده سایت
                </a>

            </nav>


            <form
                method="POST"
                action="/teacher/logout"
                class="teacher-logout"
            >

                <?= \App\Core\Csrf::field() ?>

                <button
                    type="submit"
                >
                    خروج از حساب
                </button>

            </form>

        </aside>


        <main class="teacher-main">

            <?= $content ?>

        </main>

    </div>

</body>

</html>
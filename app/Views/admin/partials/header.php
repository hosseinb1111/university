<?php

declare(strict_types=1);

$name = trim(
    ($user['first_name'] ?? '')
    . ' '
    . ($user['last_name'] ?? '')
);

if ($name === '') {
    $name = 'کاربر';
}

?>

<div class="admin-header__right">

    <button
        type="button"
        class="admin-menu-toggle"
        id="admin-menu-toggle"
        aria-label="باز کردن منو"
    >
        ☰
    </button>


    <div class="admin-header__title">

        <span>
            سامانه مدیریت محتوا
        </span>

    </div>

</div>


<div class="admin-header__left">

    <div class="admin-header__profile">

        <div class="admin-header__profile-info">

            <strong>
                <?= htmlspecialchars(
                    $name,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </strong>

            <span>
                <?= htmlspecialchars(
                    $user['email'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </span>

        </div>


        <div class="admin-header__avatar">

            <?= htmlspecialchars(
                mb_substr(
                    $name,
                    0,
                    1,
                    'UTF-8'
                ),
                ENT_QUOTES,
                'UTF-8'
            ) ?>

        </div>

    </div>

</div>
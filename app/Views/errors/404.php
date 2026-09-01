<?php

declare(strict_types=1);

use App\Core\View;

$currentPath =
    parse_url(
        $_SERVER['REQUEST_URI'] ?? '/',
        PHP_URL_PATH
    );

if (
    !is_string($currentPath)
    || $currentPath === ''
) {
    $currentPath = '/';
}

$message =
    is_string($message ?? null)
        && $message !== ''
        ? $message
        : 'صفحه مورد نظر پیدا نشد.';
?>

<section class="error-page">

    <div class="container">

        <div class="error-card">

            <div class="error-card__code">
                404
            </div>

            <span class="error-card__eyebrow">
                صفحه پیدا نشد
            </span>

            <h1 class="error-card__title">
                صفحه مورد نظر وجود ندارد
            </h1>

            <p class="error-card__description">
                <?= View::escape(
                    $message
                ) ?>
            </p>

            <div class="error-card__path">
                <?= View::escape(
                    $currentPath
                ) ?>
            </div>

            <div class="error-card__actions">

                <a
                    href="<?= View::url('/') ?>"
                    class="button button--primary"
                >
                    بازگشت به صفحه اصلی
                </a>

                <button
                    type="button"
                    class="button button--secondary"
                    onclick="history.back()"
                >
                    بازگشت به صفحه قبل
                </button>

            </div>

        </div>

    </div>

</section>
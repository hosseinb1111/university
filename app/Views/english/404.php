<?php

declare(strict_types=1);

use App\Core\View;

$message =
    is_string(
        $message ?? null
    )
        ? trim($message)
        : '';

?>

<section class="english-error-page">

    <div class="english-container">

        <div class="english-error-page__inner">


            <div
                class="english-error-page__code"
                aria-hidden="true"
            >
                404
            </div>


            <span class="english-error-page__eyebrow">
                PAGE NOT FOUND
            </span>


            <h1>
                We couldn't find that page.
            </h1>


            <p>
                <?= View::escape(
                    $message !== ''
                        ? $message
                        : 'The page you are looking for may have been moved, removed, or never existed.'
                ) ?>
            </p>


            <div
                class="english-error-page__actions"
            >

                <a
                    href="<?= View::url(
                        '/english'
                    ) ?>"
                    class="
                        english-button
                        english-button--primary
                    "
                >
                    Back to English Home
                </a>


                <a
                    href="<?= View::url(
                        '/english/announcements'
                    ) ?>"
                    class="
                        english-button
                        english-button--secondary
                    "
                >
                    Browse Announcements
                </a>

            </div>

        </div>

    </div>

</section>
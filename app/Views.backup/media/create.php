<?php
declare(strict_types=1);

use App\Core\View;
use App\Core\Session;

$error =
    Session::getFlash(
        'error'
    );
?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>

            <h1>
                Ø§ÙØ²ÙˆØ¯Ù† ØªØµÙˆÛŒØ±
            </h1>

            <p>
                ØªØµÙˆÛŒØ± Ø±Ø§ Ø¨Ø±Ø§ÛŒ Ø§Ø³ØªÙØ§Ø¯Ù‡ Ø¯Ø± Ø³Ø§ÛŒØª Ø¢Ù¾Ù„ÙˆØ¯ Ú©Ù†ÛŒØ¯.
            </p>

        </div>

    </div>


    <div class="admin-panel">

        <?php if (
            is_string($error)
            && $error !== ''
        ): ?>

            <div class="form-errors">

                <?= View::escape(
                    $error
                ) ?>

            </div>

        <?php endif; ?>


        <form
            method="POST"
            action="<?= View::route(
                'admin.media.store'
            ) ?>"
            enctype="multipart/form-data"
            class="admin-form"
        >

            <?= \App\Core\Csrf::field() ?>


            <div class="form-grid">

                <div
                    class="form-field form-field--full"
                >

                    <label
                        for="media"
                        class="form-field__label"
                    >
                        ØªØµÙˆÛŒØ±
                    </label>

                    <input
                        id="media"
                        name="media"
                        type="file"
                        class="form-field__input"
                        accept="image/jpeg,image/png,image/webp"
                        required
                    >

                    <small
                        style="
                            color:#64748b;
                            font-size:12px;
                        "
                    >
                        ÙØ±Ù…Øªâ€ŒÙ‡Ø§ÛŒ Ù…Ø¬Ø§Ø²:
                        JPGØŒ PNGØŒ WebP
                        â€” Ø­Ø¯Ø§Ú©Ø«Ø± Ûµ Ù…Ú¯Ø§Ø¨Ø§ÛŒØª
                    </small>

                </div>


                <div
                    class="form-field form-field--full"
                >

                    <label
                        for="alt_text"
                        class="form-field__label"
                    >
                        Ù…ØªÙ† Ø¬Ø§ÛŒÚ¯Ø²ÛŒÙ† ØªØµÙˆÛŒØ±
                    </label>

                    <input
                        id="alt_text"
                        name="alt_text"
                        type="text"
                        class="form-field__input"
                        maxlength="255"
                        placeholder="Ù…Ø«Ù„Ø§Ù‹ Ù†Ù…Ø§ÛŒ Ø³Ø§Ø®ØªÙ…Ø§Ù† Ù…ÙˆØ³Ø³Ù‡"
                    >

                </div>

            </div>


            <div class="admin-form__actions">

                <button
                    type="submit"
                    class="button button--primary"
                >
                    Ø¢Ù¾Ù„ÙˆØ¯ ØªØµÙˆÛŒØ±
                </button>

                <a
                    href="<?= View::route(
                        'admin.media.index'
                    ) ?>"
                    class="button button--secondary"
                >
                    Ø§Ù†ØµØ±Ø§Ù
                </a>

            </div>

        </form>

    </div>

</div>

<?php
declare(strict_types=1);

use App\Core\View;
?>

<section class="english-page">

    <div class="english-container">

        <div class="english-page__hero">

            <span>
                Contact
            </span>

            <h1>
                Contact Us
            </h1>

            <p>
                Contact information for Sadra Institute of Higher Education.
            </p>

        </div>


        <div class="english-contact-grid">

            <article class="english-panel">

                <h2>
                    Email
                </h2>

                <a
                    href="mailto:<?= View::escape(
                        $contact['email']
                    ) ?>"
                >
                    <?= View::escape(
                        $contact['email']
                    ) ?>
                </a>

            </article>


            <article class="english-panel">

                <h2>
                    Phone
                </h2>

                <a
                    href="tel:<?= View::escape(
                        preg_replace(
                            '/[^0-9+]/',
                            '',
                            $contact['phone']
                        )
                    ) ?>"
                >
                    <?= View::escape(
                        $contact['phone']
                    ) ?>
                </a>

            </article>


            <article class="english-panel">

                <h2>
                    Fax
                </h2>

                <p>
                    <?= View::escape(
                        $contact['fax']
                    ) ?>
                </p>

            </article>


            <article class="english-panel">

                <h2>
                    Address
                </h2>

                <p>
                    <?= View::escape(
                        $contact['address']
                    ) ?>
                </p>

            </article>

        </div>

    </div>

</section>

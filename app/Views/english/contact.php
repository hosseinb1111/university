<?php

declare(strict_types=1);

use App\Core\View;


/*
|--------------------------------------------------------------------------
| Normalize contact data
|--------------------------------------------------------------------------
*/

$contact =
    is_array($contact ?? null)
        ? $contact
        : [];


$email =
    trim(
        (string) (
            $contact['email']
            ?? ''
        )
    );


$phone =
    trim(
        (string) (
            $contact['phone']
            ?? ''
        )
    );


$fax =
    trim(
        (string) (
            $contact['fax']
            ?? ''
        )
    );


$address =
    trim(
        (string) (
            $contact['address']
            ?? ''
        )
    );


/*
|--------------------------------------------------------------------------
| Google Maps embed URL
|--------------------------------------------------------------------------
|
| The CMS should normally provide this value through:
|
| english.pages.contact.map_embed_url
|
| Only the iframe SRC URL should be stored.
|
| The fallback below is temporary so the map section is visible
| immediately even before a map URL has been entered in the CMS.
|
*/

$mapEmbedUrl =
    trim(
        (string) (
            $contact['map_embed_url']
            ?? ''
        )
    );


if (
    $mapEmbedUrl === ''
) {
    $mapEmbedUrl =
        'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1112.5980473810423!2d51.31874342393493!3d35.72341748475049!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f8dfdb8d4edbb99%3A0x87fdc915c1e8e94f!2sMeykhosh%20Pizza!5e0!3m2!1sen!2s!4v1787785294527!5m2!1sen!2s';
}


/*
|--------------------------------------------------------------------------
| Phone href
|--------------------------------------------------------------------------
*/

$phoneHref =
    preg_replace(
        '/[^0-9+]/',
        '',
        $phone
    );


if (
    !is_string($phoneHref)
) {
    $phoneHref = '';
}


/*
|--------------------------------------------------------------------------
| Availability
|--------------------------------------------------------------------------
*/

$hasEmail =
    $email !== '';


$hasPhone =
    $phone !== ''
    && $phoneHref !== '';


$hasFax =
    $fax !== '';


$hasAddress =
    $address !== '';


$hasMap =
    $mapEmbedUrl !== '';

?>


<section class="english-contact-page">


    <!-- =====================================================
         HERO
    ====================================================== -->

    <header class="english-contact-hero">

        <div class="english-container">

            <div class="english-contact-hero__content">

                <span>
                    CONTACT
                </span>

                <h1>
                    Get in touch with Sadra.
                </h1>

                <p>
                    Whether you are a student, researcher,
                    faculty member, applicant, or visitor,
                    our institutional contact channels are
                    available to help you find the right
                    information.
                </p>

            </div>


            <div
                class="english-contact-hero__mark"
                aria-hidden="true"
            >
                →
            </div>

        </div>

    </header>


    <!-- =====================================================
         CONTACT INFORMATION
    ====================================================== -->

    <section class="english-contact-section">

        <div class="english-container">


            <div class="english-contact-section__heading">

                <div>

                    <span>
                        CONTACT INFORMATION
                    </span>

                    <h2>
                        Reach the institute.
                    </h2>

                </div>


                <p>
                    Use the contact method that works
                    best for you.
                </p>

            </div>


            <div class="english-contact-grid">


                <!-- =================================================
                     EMAIL
                ================================================== -->

                <article
                    class="
                        english-contact-card
                        english-contact-card--featured
                    "
                >

                    <div
                        class="english-contact-card__icon"
                        aria-hidden="true"
                    >
                        @
                    </div>


                    <div>

                        <span>
                            EMAIL
                        </span>

                        <h3>
                            Email the institute
                        </h3>

                    </div>


                    <?php if (
                        $hasEmail
                    ): ?>

                        <a
                            href="mailto:<?= View::escape(
                                $email
                            ) ?>"
                            class="english-contact-card__value"
                        >
                            <?= View::escape(
                                $email
                            ) ?>
                        </a>


                        <a
                            href="mailto:<?= View::escape(
                                $email
                            ) ?>"
                            class="english-contact-card__action"
                        >
                            <span>
                                Send an email
                            </span>

                            <strong>
                                →
                            </strong>
                        </a>

                    <?php else: ?>

                        <p class="english-contact-card__unavailable">
                            Email information is not currently
                            available.
                        </p>

                    <?php endif; ?>

                </article>


                <!-- =================================================
                     PHONE
                ================================================== -->

                <article class="english-contact-card">

                    <div
                        class="english-contact-card__icon"
                        aria-hidden="true"
                    >
                        ☎
                    </div>


                    <div>

                        <span>
                            PHONE
                        </span>

                        <h3>
                            Call the institute
                        </h3>

                    </div>


                    <?php if (
                        $hasPhone
                    ): ?>

                        <a
                            href="tel:<?= View::escape(
                                $phoneHref
                            ) ?>"
                            class="english-contact-card__value"
                        >
                            <?= View::escape(
                                $phone
                            ) ?>
                        </a>


                        <a
                            href="tel:<?= View::escape(
                                $phoneHref
                            ) ?>"
                            class="english-contact-card__action"
                        >
                            <span>
                                Call now
                            </span>

                            <strong>
                                →
                            </strong>
                        </a>

                    <?php else: ?>

                        <p class="english-contact-card__unavailable">
                            Phone information is not currently
                            available.
                        </p>

                    <?php endif; ?>

                </article>


                <!-- =================================================
                     FAX
                ================================================== -->

                <article class="english-contact-card">

                    <div
                        class="english-contact-card__icon"
                        aria-hidden="true"
                    >
                        #
                    </div>


                    <div>

                        <span>
                            FAX
                        </span>

                        <h3>
                            Fax
                        </h3>

                    </div>


                    <?php if (
                        $hasFax
                    ): ?>

                        <div class="english-contact-card__value">
                            <?= View::escape(
                                $fax
                            ) ?>
                        </div>


                        <div class="english-contact-card__note">
                            Institutional fax line
                        </div>

                    <?php else: ?>

                        <p class="english-contact-card__unavailable">
                            Fax information is not currently
                            available.
                        </p>

                    <?php endif; ?>

                </article>


                <!-- =================================================
                     ADDRESS
                ================================================== -->

                <article
                    class="
                        english-contact-card
                        english-contact-card--wide
                    "
                >

                    <div
                        class="english-contact-card__icon"
                        aria-hidden="true"
                    >
                        ●
                    </div>


                    <div>

                        <span>
                            LOCATION
                        </span>

                        <h3>
                            Visit the institute
                        </h3>

                    </div>


                    <?php if (
                        $hasAddress
                    ): ?>

                        <address class="english-contact-card__address">
                            <?= nl2br(
                                View::escape(
                                    $address
                                )
                            ) ?>
                        </address>

                    <?php else: ?>

                        <p class="english-contact-card__unavailable">
                            Address information is not currently
                            available.
                        </p>

                    <?php endif; ?>

                </article>


                <!-- =================================================
                     MAP
                ================================================== -->

                <?php if (
                    $hasMap
                ): ?>

                    <article
                        class="
                            english-contact-card
                            english-contact-card--wide
                            english-contact-card--map
                        "
                    >

                        <div
                            class="english-contact-card__icon"
                            aria-hidden="true"
                        >
                            +
                        </div>


                        <div>

                            <span>
                                MAP
                            </span>

                            <h3>
                                Find us
                            </h3>

                        </div>


                        <div class="english-contact-card__map">

                            <iframe
                                src="<?= View::escape(
                                    $mapEmbedUrl
                                ) ?>"
                                title="Sadra Institute location map"
                                loading="lazy"
                                allowfullscreen
                                referrerpolicy="strict-origin-when-cross-origin"
                            ></iframe>

                        </div>

                    </article>

                <?php endif; ?>


            </div>

        </div>

    </section>


    <!-- =====================================================
         HELP / NAVIGATION
    ====================================================== -->

    <section class="english-contact-help">

        <div class="english-container">

            <div class="english-contact-help__grid">


                <div>

                    <span>
                        NEED MORE HELP?
                    </span>

                    <h2>
                        Start with the right department.
                    </h2>

                    <p>
                        Explore the academic and institutional
                        sections of the English website to find
                        the information you need.
                    </p>

                </div>


                <div class="english-contact-help__links">


                    <a
                        href="<?= View::url(
                            '/english/faculties'
                        ) ?>"
                    >

                        <span>
                            Faculties
                        </span>

                        <strong>
                            →
                        </strong>

                    </a>


                    <a
                        href="<?= View::url(
                            '/english/programs'
                        ) ?>"
                    >

                        <span>
                            Academic Programs
                        </span>

                        <strong>
                            →
                        </strong>

                    </a>


                    <a
                        href="<?= View::url(
                            '/english/research'
                        ) ?>"
                    >

                        <span>
                            Research Centers
                        </span>

                        <strong>
                            →
                        </strong>

                    </a>


                    <a
                        href="<?= View::url(
                            '/english/announcements'
                        ) ?>"
                    >

                        <span>
                            Announcements
                        </span>

                        <strong>
                            →
                        </strong>

                    </a>


                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         CTA
    ====================================================== -->

    <section class="english-contact-cta">

        <div class="english-container">

            <div class="english-contact-cta__inner">


                <div>

                    <span>
                        SADRA INSTITUTE
                    </span>

                    <h2>
                        We are here to help.
                    </h2>

                    <p>
                        Stay connected with the institute through
                        our academic, research, and institutional
                        channels.
                    </p>

                </div>


                <div class="english-contact-cta__actions">

                    <a
                        href="<?= View::url(
                            '/english/about'
                        ) ?>"
                        class="
                            english-button
                            english-button--primary
                        "
                    >
                        About Sadra
                    </a>


                    <a
                        href="<?= View::url(
                            '/english'
                        ) ?>"
                        class="
                            english-button
                            english-button--secondary
                        "
                    >
                        Back to Home
                    </a>

                </div>


            </div>

        </div>

    </section>


</section>
<?php

declare(strict_types=1);

use App\Core\View;


/*
|--------------------------------------------------------------------------
| Normalize faculty
|--------------------------------------------------------------------------
*/

$faculty =
    is_array($faculty ?? null)
        ? $faculty
        : [];


/*
|--------------------------------------------------------------------------
| Faculty data
|--------------------------------------------------------------------------
*/

$name =
    trim(
        (string) (
            $faculty['name']
            ?? 'Faculty'
        )
    );

if (
    $name === ''
) {
    $name =
        'Faculty';
}


$shortName =
    trim(
        (string) (
            $faculty['short_name']
            ?? ''
        )
    );


$description =
    trim(
        (string) (
            $faculty['description']
            ?? ''
        )
    );


$image =
    trim(
        (string) (
            $faculty['image']
            ?? ''
        )
    );


$email =
    trim(
        (string) (
            $faculty['email']
            ?? ''
        )
    );


$phone =
    trim(
        (string) (
            $faculty['phone']
            ?? ''
        )
    );


$website =
    trim(
        (string) (
            $faculty['website']
            ?? ''
        )
    );


$address =
    trim(
        (string) (
            $faculty['address']
            ?? ''
        )
    );


/*
|--------------------------------------------------------------------------
| Initial
|--------------------------------------------------------------------------
*/

$initial =
    mb_strtoupper(
        mb_substr(
            $name,
            0,
            1,
            'UTF-8'
        ),
        'UTF-8'
    );

?>


<section class="english-faculty-page">


    <!-- =====================================================
         HERO
    ====================================================== -->

    <header class="english-faculty-hero">

        <div class="english-container">

            <a
                href="<?= View::url(
                    '/english/faculties'
                ) ?>"
                class="english-faculty-back"
            >
                <span>
                    ←
                </span>

                Back to faculties
            </a>


            <div class="english-faculty-hero__content">

                <span>
                    ACADEMICS
                </span>


                <?php if (
                    $shortName !== ''
                ): ?>

                    <small>
                        <?= View::escape(
                            $shortName
                        ) ?>
                    </small>

                <?php endif; ?>


                <h1>
                    <?= View::escape(
                        $name
                    ) ?>
                </h1>


                <p>
                    Academic information, programs, and
                    institutional resources related to
                    <?= View::escape(
                        $name
                    ) ?>.
                </p>

            </div>

        </div>

    </header>


    <!-- =====================================================
         MAIN CONTENT
    ====================================================== -->

    <main class="english-faculty-content">

        <div class="english-container">

            <div class="english-faculty-layout">


                <!-- =================================================
                     Faculty visual
                ================================================== -->

                <aside
                    class="english-faculty-sidebar"
                >

                    <div
                        class="english-faculty-visual"
                    >

                        <?php if (
                            $image !== ''
                        ): ?>

                            <img
                                src="<?= View::escape(
                                    $image
                                ) ?>"
                                alt="<?= View::escape(
                                    $name
                                ) ?>"
                            >

                        <?php else: ?>

                            <div
                                class="
                                    english-faculty-visual__placeholder
                                "
                                aria-hidden="true"
                            >
                                <?= View::escape(
                                    $initial
                                ) ?>
                            </div>

                        <?php endif; ?>

                    </div>


                    <div
                        class="
                            english-faculty-sidebar__card
                        "
                    >

                        <span>
                            FACULTY
                        </span>


                        <strong>
                            <?= View::escape(
                                $name
                            ) ?>
                        </strong>


                        <?php if (
                            $shortName !== ''
                        ): ?>

                            <small>
                                <?= View::escape(
                                    $shortName
                                ) ?>
                            </small>

                        <?php endif; ?>

                    </div>


                    <?php if (
                        $email !== ''
                        || $phone !== ''
                        || $website !== ''
                        || $address !== ''
                    ): ?>

                        <div
                            class="
                                english-faculty-contact
                            "
                        >

                            <span>
                                CONTACT
                            </span>


                            <?php if (
                                $email !== ''
                            ): ?>

                                <a
                                    href="mailto:<?= View::escape(
                                        $email
                                    ) ?>"
                                >

                                    <small>
                                        Email
                                    </small>

                                    <strong>
                                        <?= View::escape(
                                            $email
                                        ) ?>
                                    </strong>

                                </a>

                            <?php endif; ?>


                            <?php if (
                                $phone !== ''
                            ): ?>

                                <?php
                                $phoneHref =
                                    preg_replace(
                                        '/[^0-9+]/',
                                        '',
                                        $phone
                                    ) ?? '';
                                ?>

                                <a
                                    href="tel:<?= View::escape(
                                        $phoneHref
                                    ) ?>"
                                >

                                    <small>
                                        Phone
                                    </small>

                                    <strong>
                                        <?= View::escape(
                                            $phone
                                        ) ?>
                                    </strong>

                                </a>

                            <?php endif; ?>


                            <?php if (
                                $website !== ''
                            ): ?>

                                <a
                                    href="<?= View::escape(
                                        $website
                                    ) ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >

                                    <small>
                                        Website
                                    </small>

                                    <strong>
                                        Visit website
                                    </strong>

                                </a>

                            <?php endif; ?>


                            <?php if (
                                $address !== ''
                            ): ?>

                                <div>

                                    <small>
                                        Location
                                    </small>

                                    <strong>
                                        <?= View::escape(
                                            $address
                                        ) ?>
                                    </strong>

                                </div>

                            <?php endif; ?>

                        </div>

                    <?php endif; ?>

                </aside>


                <!-- =================================================
                     Faculty information
                ================================================== -->

                <div
                    class="english-faculty-main"
                >

                    <div
                        class="
                            english-faculty-main__heading
                        "
                    >

                        <span>
                            ABOUT THE FACULTY
                        </span>

                        <h2>
                            <?= View::escape(
                                $name
                            ) ?>
                        </h2>

                    </div>


                    <?php if (
                        $description !== ''
                    ): ?>

                        <div
                            class="
                                english-faculty-description
                            "
                        >

                            <?= nl2br(
                                View::escape(
                                    $description
                                )
                            ) ?>

                        </div>

                    <?php else: ?>

                        <div
                            class="
                                english-faculty-empty
                            "
                        >

                            <div
                                class="
                                    english-faculty-empty__icon
                                "
                                aria-hidden="true"
                            >
                                —
                            </div>

                            <h3>
                                Faculty information
                            </h3>

                            <p>
                                Detailed information about this
                                faculty is not currently available.
                            </p>

                        </div>

                    <?php endif; ?>


                    <!-- =================================================
                         Explore
                    ================================================== -->

                    <section
                        class="
                            english-faculty-explore
                        "
                    >

                        <div>

                            <span>
                                EXPLORE
                            </span>

                            <h3>
                                Continue exploring Sadra.
                            </h3>

                        </div>


                        <div
                            class="
                                english-faculty-explore__links
                            "
                        >

                            <a
                                href="<?= View::url(
                                    '/english/programs'
                                ) ?>"
                                class="
                                    english-faculty-explore__link
                                "
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
                                class="
                                    english-faculty-explore__link
                                "
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
                                    '/english/faculties'
                                ) ?>"
                                class="
                                    english-faculty-explore__link
                                "
                            >

                                <span>
                                    All Faculties
                                </span>

                                <strong>
                                    →
                                </strong>

                            </a>

                        </div>

                    </section>

                </div>

            </div>

        </div>

    </main>


    <!-- =====================================================
         CTA
    ====================================================== -->

    <section class="english-faculty-cta">

        <div class="english-container">

            <div
                class="
                    english-faculty-cta__inner
                "
            >

                <div>

                    <span>
                        SADRA INSTITUTE
                    </span>

                    <h2>
                        Discover the academic community.
                    </h2>

                    <p>
                        Explore programs, research activities,
                        announcements, and other areas of the
                        institute.
                    </p>

                </div>


                <div
                    class="
                        english-faculty-cta__actions
                    "
                >

                    <a
                        href="<?= View::url(
                            '/english/programs'
                        ) ?>"
                        class="
                            english-button
                            english-button--primary
                        "
                    >
                        Explore Programs
                    </a>


                    <a
                        href="<?= View::url(
                            '/english/contact'
                        ) ?>"
                        class="
                            english-button
                            english-button--secondary
                        "
                    >
                        Contact Us
                    </a>

                </div>

            </div>

        </div>

    </section>

</section>
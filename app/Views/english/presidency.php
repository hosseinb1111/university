<?php

declare(strict_types=1);

use App\Core\View;


/*
|--------------------------------------------------------------------------
| Normalize president
|--------------------------------------------------------------------------
*/

$president =
    is_array($president ?? null)
        ? $president
        : [];


/*
|--------------------------------------------------------------------------
| Build full name
|--------------------------------------------------------------------------
*/

$firstName =
    trim(
        (string) (
            $president['first_name']
            ?? ''
        )
    );

$lastName =
    trim(
        (string) (
            $president['last_name']
            ?? ''
        )
    );

$fullName =
    trim(
        $firstName
        . ' '
        . $lastName
    );

if (
    $fullName === ''
) {
    $fullName =
        'President of Sadra Institute';
}


/*
|--------------------------------------------------------------------------
| Optional data
|--------------------------------------------------------------------------
*/

$position =
    trim(
        (string) (
            $president['position']
            ?? ''
        )
    );

$biography =
    trim(
        (string) (
            $president['biography']
            ?? ''
        )
    );

$email =
    trim(
        (string) (
            $president['email']
            ?? ''
        )
    );

$phone =
    trim(
        (string) (
            $president['phone']
            ?? ''
        )
    );

$officeLocation =
    trim(
        (string) (
            $president['office_location']
            ?? ''
        )
    );

$image =
    trim(
        (string) (
            $president['image']
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
            $fullName,
            0,
            1,
            'UTF-8'
        ),
        'UTF-8'
    );

?>


<section class="english-presidency-page">


    <!-- =====================================================
         HERO
    ====================================================== -->

    <header class="english-presidency-hero">

        <div class="english-container">

            <div class="english-presidency-hero__content">

                <span>
                    LEADERSHIP
                </span>

                <h1>
                    Office of the President
                </h1>

                <p>
                    The presidency provides leadership and
                    direction for the academic and institutional
                    development of Sadra Institute of Higher
                    Education.
                </p>

            </div>


            <div
                class="english-presidency-hero__mark"
                aria-hidden="true"
            >
                S
            </div>

        </div>

    </header>


    <!-- =====================================================
         LEADERSHIP PROFILE
    ====================================================== -->

    <section class="english-presidency-section">

        <div class="english-container">


            <?php if (
                $president !== []
            ): ?>

                <article
                    class="english-president-profile"
                >

                    <!-- =================================================
                         Portrait
                    ================================================== -->

                    <div
                        class="english-president-profile__visual"
                    >

                        <?php if (
                            $image !== ''
                        ): ?>

                            <img
                                src="<?= View::escape(
                                    $image
                                ) ?>"
                                alt="<?= View::escape(
                                    $fullName
                                ) ?>"
                            >

                        <?php else: ?>

                            <div
                                class="
                                    english-president-profile__placeholder
                                "
                                aria-hidden="true"
                            >

                                <?= View::escape(
                                    $initial
                                ) ?>

                            </div>

                        <?php endif; ?>


                        <div
                            class="
                                english-president-profile__portrait-label
                            "
                        >
                            <span>
                                PRESIDENT
                            </span>
                        </div>

                    </div>


                    <!-- =================================================
                         Profile content
                    ================================================== -->

                    <div
                        class="english-president-profile__content"
                    >

                        <div
                            class="
                                english-president-profile__eyebrow
                            "
                        >
                            <span>
                                INSTITUTIONAL LEADERSHIP
                            </span>

                            <strong>
                                01
                            </strong>
                        </div>


                        <?php if (
                            $position !== ''
                        ): ?>

                            <div
                                class="
                                    english-president-profile__position
                                "
                            >
                                <?= View::escape(
                                    $position
                                ) ?>
                            </div>

                        <?php else: ?>

                            <div
                                class="
                                    english-president-profile__position
                                "
                            >
                                President
                            </div>

                        <?php endif; ?>


                        <h2>
                            <?= View::escape(
                                $fullName
                            ) ?>
                        </h2>


                        <?php if (
                            $biography !== ''
                        ): ?>

                            <div
                                class="
                                    english-president-profile__biography
                                "
                            >

                                <?= nl2br(
                                    View::escape(
                                        $biography
                                    )
                                ) ?>

                            </div>

                        <?php else: ?>

                            <p
                                class="
                                    english-president-profile__fallback
                                "
                            >
                                The Office of the President provides
                                leadership for the institute's academic,
                                institutional, and strategic direction.
                            </p>

                        <?php endif; ?>


                        <div
                            class="
                                english-president-profile__details
                            "
                        >

                            <?php if (
                                $email !== ''
                            ): ?>

                                <a
                                    href="mailto:<?= View::escape(
                                        $email
                                    ) ?>"
                                    class="
                                        english-president-detail
                                    "
                                >

                                    <span
                                        class="
                                            english-president-detail__label
                                        "
                                    >
                                        Email
                                    </span>

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

                                <a
                                    href="tel:<?= View::escape(
                                        preg_replace(
                                            '/[^0-9+]/',
                                            '',
                                            $phone
                                        ) ?? ''
                                    ) ?>"
                                    class="
                                        english-president-detail
                                    "
                                >

                                    <span
                                        class="
                                            english-president-detail__label
                                        "
                                    >
                                        Phone
                                    </span>

                                    <strong>
                                        <?= View::escape(
                                            $phone
                                        ) ?>
                                    </strong>

                                </a>

                            <?php endif; ?>


                            <?php if (
                                $officeLocation !== ''
                            ): ?>

                                <div
                                    class="
                                        english-president-detail
                                    "
                                >

                                    <span
                                        class="
                                            english-president-detail__label
                                        "
                                    >
                                        Office
                                    </span>

                                    <strong>
                                        <?= View::escape(
                                            $officeLocation
                                        ) ?>
                                    </strong>

                                </div>

                            <?php endif; ?>

                        </div>

                    </div>

                </article>


            <?php else: ?>


                <!-- =================================================
                     Empty state
                ================================================== -->

                <div
                    class="
                        english-empty
                        english-presidency-empty
                    "
                >

                    <div
                        class="
                            english-presidency-empty__icon
                        "
                        aria-hidden="true"
                    >
                        S
                    </div>


                    <h2>
                        Presidency information is not currently available.
                    </h2>


                    <p>
                        Leadership information will be published here
                        when it becomes available.
                    </p>


                    <a
                        href="<?= View::url(
                            '/english/contact'
                        ) ?>"
                        class="
                            english-button
                            english-button--secondary
                        "
                    >
                        Contact the Institute
                    </a>

                </div>

            <?php endif; ?>

        </div>

    </section>


    <!-- =====================================================
         OFFICE OF THE PRESIDENT
    ====================================================== -->

    <?php if (
        $president !== []
    ): ?>

        <section
            class="
                english-presidency-information
            "
        >

            <div class="english-container">

                <div
                    class="
                        english-presidency-information__grid
                    "
                >

                    <div>

                        <span>
                            THE OFFICE
                        </span>

                        <h2>
                            Leadership with an
                            academic perspective.
                        </h2>

                    </div>


                    <div>

                        <p>
                            The Office of the President is responsible
                            for guiding the institute's overall
                            academic and institutional direction.
                        </p>

                        <p>
                            Through collaboration with faculty,
                            academic units, staff, and the wider
                            university community, the office supports
                            the continued development of Sadra Institute.
                        </p>

                    </div>

                </div>


                <div
                    class="
                        english-presidency-pillars
                    "
                >

                    <article>

                        <span>
                            01
                        </span>

                        <h3>
                            Academic Leadership
                        </h3>

                        <p>
                            Supporting educational quality and
                            academic development across the institute.
                        </p>

                    </article>


                    <article>

                        <span>
                            02
                        </span>

                        <h3>
                            Institutional Direction
                        </h3>

                        <p>
                            Providing strategic direction for the
                            continued growth of the institution.
                        </p>

                    </article>


                    <article>

                        <span>
                            03
                        </span>

                        <h3>
                            Community
                        </h3>

                        <p>
                            Encouraging collaboration across the
                            academic and institutional community.
                        </p>

                    </article>

                </div>

            </div>

        </section>

    <?php endif; ?>


    <!-- =====================================================
         CTA
    ====================================================== -->

    <section class="english-presidency-cta">

        <div class="english-container">

            <div
                class="
                    english-presidency-cta__inner
                "
            >

                <div>

                    <span>
                        SADRA INSTITUTE
                    </span>

                    <h2>
                        Learn more about
                        our academic community.
                    </h2>

                    <p>
                        Explore faculties, research centers,
                        academic programs, and institutional news.
                    </p>

                </div>


                <div
                    class="
                        english-presidency-cta__actions
                    "
                >

                    <a
                        href="<?= View::url(
                            '/english/faculties'
                        ) ?>"
                        class="
                            english-button
                            english-button--primary
                        "
                    >
                        Explore Faculties
                    </a>


                    <a
                        href="<?= View::url(
                            '/english/research'
                        ) ?>"
                        class="
                            english-button
                            english-button--secondary
                        "
                    >
                        Explore Research
                    </a>

                </div>

            </div>

        </div>

    </section>

</section>
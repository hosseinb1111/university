<?php

declare(strict_types=1);

use App\Core\View;


/*
|--------------------------------------------------------------------------
| Page settings
|--------------------------------------------------------------------------
*/

$pageEyebrow =
    trim(
        (string) (
            $eyebrow
            ?? 'ABOUT SADRA'
        )
    );

$pageTitle =
    trim(
        (string) (
            $pageTitle
            ?? 'A place for learning, research, and growth.'
        )
    );

$pageDescription =
    trim(
        (string) (
            $pageDescription
            ?? 'Sadra Institute of Higher Education is an academic institution in Tehran committed to education, scientific development, research, and preparing students for meaningful professional careers.'
        )
    );


if (
    $pageEyebrow === ''
) {
    $pageEyebrow =
        'ABOUT SADRA';
}


if (
    $pageTitle === ''
) {
    $pageTitle =
        'A place for learning, research, and growth.';
}


if (
    $pageDescription === ''
) {
    $pageDescription =
        'Sadra Institute of Higher Education is an academic institution in Tehran committed to education, scientific development, research, and preparing students for meaningful professional careers.';
}

?>

<section class="english-about-page">


    <!-- =====================================================
         HERO
    ====================================================== -->

    <header class="english-about-hero">

        <div class="english-container">

            <div class="english-about-hero__content">

                <span class="english-about-hero__eyebrow">

                    <?= View::escape(
                        $pageEyebrow
                    ) ?>

                </span>


                <h1>

                    <?= View::escape(
                        $pageTitle
                    ) ?>

                </h1>


                <p>

                    <?= View::escape(
                        $pageDescription
                    ) ?>

                </p>


                <div class="english-about-hero__actions">

                    <a
                        href="<?= View::url(
                            '/english/faculties'
                        ) ?>"
                        class="english-button english-button--primary"
                    >
                        Explore Faculties
                    </a>


                    <a
                        href="<?= View::url(
                            '/english/programs'
                        ) ?>"
                        class="english-button english-button--secondary"
                    >
                        Academic Programs
                    </a>

                </div>

            </div>


            <div
                class="english-about-hero__mark"
                aria-hidden="true"
            >
                <span>
                    S
                </span>
            </div>

        </div>

    </header>


    <!-- =====================================================
         INTRO
    ====================================================== -->

    <section class="english-about-intro">

        <div class="english-container">

            <div class="english-about-intro__grid">

                <div>

                    <span class="english-about-section-label">
                        WHO WE ARE
                    </span>

                    <h2>
                        An academic community built around
                        knowledge and opportunity.
                    </h2>

                </div>


                <div class="english-about-intro__text">

                    <p>
                        Sadra Institute of Higher Education brings
                        together students, academics, researchers,
                        and professionals in an environment designed
                        to support learning and intellectual growth.
                    </p>


                    <p>
                        Through academic programs, research activities,
                        institutional services, and collaboration,
                        the institute aims to create meaningful
                        opportunities for students and the wider
                        academic community.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         CORE AREAS
    ====================================================== -->

    <section class="english-about-section english-about-section--soft">

        <div class="english-container">

            <div class="english-about-section__heading">

                <span>
                    OUR ACADEMIC ENVIRONMENT
                </span>

                <h2>
                    More than a classroom.
                </h2>

                <p>
                    The institute's academic environment connects
                    education, research, people, and professional
                    development.
                </p>

            </div>


            <div class="english-about-feature-grid">

                <article class="english-about-feature">

                    <div class="english-about-feature__number">
                        01
                    </div>

                    <div>

                        <h3>
                            Education
                        </h3>

                        <p>
                            Academic programs designed to provide
                            students with knowledge, practical
                            understanding, and a strong foundation
                            for professional development.
                        </p>

                        <a
                            href="<?= View::url(
                                '/english/programs'
                            ) ?>"
                        >
                            Explore programs
                        </a>

                    </div>

                </article>


                <article class="english-about-feature">

                    <div class="english-about-feature__number">
                        02
                    </div>

                    <div>

                        <h3>
                            Research
                        </h3>

                        <p>
                            Research centers and academic activities
                            that encourage scientific inquiry,
                            innovation, and knowledge creation.
                        </p>

                        <a
                            href="<?= View::url(
                                '/english/research'
                            ) ?>"
                        >
                            Explore research
                        </a>

                    </div>

                </article>


                <article class="english-about-feature">

                    <div class="english-about-feature__number">
                        03
                    </div>

                    <div>

                        <h3>
                            Academic Community
                        </h3>

                        <p>
                            Students, faculty members, researchers,
                            and staff working together as part of
                            a connected academic community.
                        </p>

                        <a
                            href="<?= View::url(
                                '/english/faculties'
                            ) ?>"
                        >
                            Meet our faculties
                        </a>

                    </div>

                </article>


                <article class="english-about-feature">

                    <div class="english-about-feature__number">
                        04
                    </div>

                    <div>

                        <h3>
                            Professional Growth
                        </h3>

                        <p>
                            An environment that encourages students
                            to develop the knowledge, confidence,
                            and skills needed beyond university.
                        </p>

                        <a
                            href="<?= View::url(
                                '/english/programs'
                            ) ?>"
                        >
                            Discover opportunities
                        </a>

                    </div>

                </article>

            </div>

        </div>

    </section>


    <!-- =====================================================
         MISSION / VISION
    ====================================================== -->

    <section class="english-about-section">

        <div class="english-container">

            <div class="english-about-mission-grid">

                <article
                    class="english-about-mission-card english-about-mission-card--dark"
                >

                    <span>
                        OUR MISSION
                    </span>

                    <h2>
                        Supporting quality education
                        and meaningful academic growth.
                    </h2>

                    <p>
                        We aim to provide an environment in which
                        students can learn, develop professionally,
                        engage with academic ideas, and build the
                        foundation for their future.
                    </p>

                </article>


                <article class="english-about-mission-card">

                    <span>
                        OUR VISION
                    </span>

                    <h2>
                        A stronger connection between
                        knowledge and society.
                    </h2>

                    <p>
                        We seek to encourage education and research
                        that create value beyond the classroom and
                        contribute to scientific and professional
                        development.
                    </p>

                </article>

            </div>

        </div>

    </section>


    <!-- =====================================================
         VALUES
    ====================================================== -->

    <section class="english-about-values">

        <div class="english-container">

            <div class="english-about-section__heading">

                <span>
                    WHAT MATTERS
                </span>

                <h2>
                    Our values
                </h2>

                <p>
                    Principles that shape the academic environment
                    we want to build.
                </p>

            </div>


            <div class="english-about-values__grid">

                <article>

                    <div>
                        01
                    </div>

                    <h3>
                        Academic Excellence
                    </h3>

                    <p>
                        Encouraging high standards in education,
                        learning, and academic work.
                    </p>

                </article>


                <article>

                    <div>
                        02
                    </div>

                    <h3>
                        Curiosity
                    </h3>

                    <p>
                        Supporting questioning, exploration,
                        creativity, and continuous learning.
                    </p>

                </article>


                <article>

                    <div>
                        03
                    </div>

                    <h3>
                        Responsibility
                    </h3>

                    <p>
                        Building a culture based on integrity,
                        respect, and responsibility.
                    </p>

                </article>


                <article>

                    <div>
                        04
                    </div>

                    <h3>
                        Innovation
                    </h3>

                    <p>
                        Encouraging new ideas, research,
                        technology, and practical solutions.
                    </p>

                </article>

            </div>

        </div>

    </section>


    <!-- =====================================================
         EXPLORE
    ====================================================== -->

    <section class="english-about-explore">

        <div class="english-container">

            <div class="english-about-explore__inner">

                <div>

                    <span>
                        EXPLORE SADRA
                    </span>

                    <h2>
                        Discover the academic community.
                    </h2>

                    <p>
                        Explore our faculties, programs, research
                        activities, and latest institutional news.
                    </p>

                </div>


                <div class="english-about-explore__links">

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
                            Research
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
         CONTACT CTA
    ====================================================== -->

    <section class="english-about-contact">

        <div class="english-container">

            <div class="english-about-contact__inner">

                <div>

                    <span>
                        HAVE A QUESTION?
                    </span>

                    <h2>
                        Get in touch with Sadra.
                    </h2>

                    <p>
                        Contact the institute for more information
                        about academic programs, services, and
                        institutional activities.
                    </p>

                </div>


                <a
                    href="<?= View::url(
                        '/english/contact'
                    ) ?>"
                    class="english-button english-button--primary"
                >
                    Contact Us
                </a>

            </div>

        </div>

    </section>

</section>
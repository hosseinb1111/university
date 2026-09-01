<?php

declare(strict_types=1);

use App\Core\View;


/*
|--------------------------------------------------------------------------
| Normalize program
|--------------------------------------------------------------------------
*/

$program =
    is_array($program ?? null)
        ? $program
        : [];


/*
|--------------------------------------------------------------------------
| Program values
|--------------------------------------------------------------------------
*/

$name =
    trim(
        (string) (
            $program['name']
            ?? ''
        )
    );

$degree =
    trim(
        (string) (
            $program['degree']
            ?? ''
        )
    );

$field =
    trim(
        (string) (
            $program['field']
            ?? ''
        )
    );

$description =
    trim(
        (string) (
            $program['description']
            ?? ''
        )
    );

$duration =
    trim(
        (string) (
            $program['duration']
            ?? ''
        )
    );

$admissionInfo =
    trim(
        (string) (
            $program['admission_info']
            ?? ''
        )
    );

$curriculum =
    trim(
        (string) (
            $program['curriculum']
            ?? ''
        )
    );

$facultyName =
    trim(
        (string) (
            $program['faculty_name']
            ?? ''
        )
    );

$facultySlug =
    trim(
        (string) (
            $program['faculty_slug']
            ?? ''
        )
    );


if (
    $name === ''
) {
    $name =
        'Academic Program';
}


/*
|--------------------------------------------------------------------------
| Content availability
|--------------------------------------------------------------------------
*/

$hasOverview =
    $description !== '';

$hasCurriculum =
    $curriculum !== '';

$hasAdmissionInfo =
    $admissionInfo !== '';

$hasDetails =
    $degree !== ''
    || $field !== ''
    || $duration !== ''
    || $facultyName !== '';


/*
|--------------------------------------------------------------------------
| Program initial
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


<section class="english-program-detail-page">


    <!-- =====================================================
         HERO
    ====================================================== -->

    <header class="english-program-detail-hero">

        <div class="english-container">

            <a
                href="<?= View::url(
                    '/english/programs'
                ) ?>"
                class="english-program-detail-back"
            >

                <span>
                    ←
                </span>

                Back to programs

            </a>


            <div
                class="
                    english-program-detail-hero__content
                "
            >

                <span>
                    ACADEMIC PROGRAM
                </span>


                <?php if (
                    $degree !== ''
                ): ?>

                    <div
                        class="
                            english-program-detail-hero__degree
                        "
                    >
                        <?= View::escape(
                            $degree
                        ) ?>
                    </div>

                <?php endif; ?>


                <h1>
                    <?= View::escape(
                        $name
                    ) ?>
                </h1>


                <?php if (
                    $field !== ''
                ): ?>

                    <p>
                        <?= View::escape(
                            $field
                        ) ?>
                    </p>

                <?php endif; ?>

            </div>

        </div>

    </header>


    <!-- =====================================================
         MAIN
    ====================================================== -->

    <main class="english-program-detail-content">

        <div class="english-container">

            <div
                class="
                    english-program-detail-layout
                "
            >


                <!-- =================================================
                     Main article
                ================================================== -->

                <div
                    class="
                        english-program-detail-main
                    "
                >


                    <?php if (
                        $hasOverview
                    ): ?>

                        <section
                            class="
                                english-program-detail-section
                            "
                        >

                            <div
                                class="
                                    english-program-detail-section__heading
                                "
                            >

                                <span>
                                    OVERVIEW
                                </span>

                                <h2>
                                    About the program
                                </h2>

                            </div>


                            <div
                                class="
                                    english-program-detail-text
                                "
                            >

                                <?= nl2br(
                                    View::escape(
                                        $description
                                    )
                                ) ?>

                            </div>

                        </section>

                    <?php endif; ?>


                    <?php if (
                        $hasCurriculum
                    ): ?>

                        <section
                            class="
                                english-program-detail-section
                            "
                        >

                            <div
                                class="
                                    english-program-detail-section__heading
                                "
                            >

                                <span>
                                    CURRICULUM
                                </span>

                                <h2>
                                    Course structure
                                </h2>

                            </div>


                            <div
                                class="
                                    english-program-detail-text
                                    english-program-detail-text--secondary
                                "
                            >

                                <?= nl2br(
                                    View::escape(
                                        $curriculum
                                    )
                                ) ?>

                            </div>

                        </section>

                    <?php endif; ?>


                    <?php if (
                        $hasAdmissionInfo
                    ): ?>

                        <section
                            class="
                                english-program-detail-section
                            "
                        >

                            <div
                                class="
                                    english-program-detail-section__heading
                                "
                            >

                                <span>
                                    ADMISSIONS
                                </span>

                                <h2>
                                    Admission information
                                </h2>

                            </div>


                            <div
                                class="
                                    english-program-detail-text
                                    english-program-detail-text--secondary
                                "
                            >

                                <?= nl2br(
                                    View::escape(
                                        $admissionInfo
                                    )
                                ) ?>

                            </div>

                        </section>

                    <?php endif; ?>


                    <?php if (
                        !$hasOverview
                        && !$hasCurriculum
                        && !$hasAdmissionInfo
                    ): ?>

                        <section
                            class="
                                english-program-detail-section
                            "
                        >

                            <div
                                class="
                                    english-program-detail-empty
                                "
                            >

                                <div
                                    class="
                                        english-program-detail-empty__icon
                                    "
                                    aria-hidden="true"
                                >
                                    <?= View::escape(
                                        $initial
                                    ) ?>
                                </div>


                                <h2>
                                    Program information
                                </h2>


                                <p>
                                    Detailed information about this
                                    academic program is not currently
                                    available.
                                </p>

                            </div>

                        </section>

                    <?php endif; ?>


                    <!-- =================================================
                         Explore related areas
                    ================================================== -->

                    <section
                        class="
                            english-program-detail-explore
                        "
                    >

                        <div>

                            <span>
                                EXPLORE
                            </span>

                            <h2>
                                Continue exploring Sadra.
                            </h2>

                        </div>


                        <div
                            class="
                                english-program-detail-explore__links
                            "
                        >

                            <?php if (
                                $facultySlug !== ''
                            ): ?>

                                <a
                                    href="<?= View::url(
                                        '/english/faculties/'
                                        . rawurlencode(
                                            $facultySlug
                                        )
                                    ) ?>"
                                >

                                    <span>
                                        <?= View::escape(
                                            $facultyName !== ''
                                                ? $facultyName
                                                : 'Faculty'
                                        ) ?>
                                    </span>

                                    <strong>
                                        →
                                    </strong>

                                </a>

                            <?php endif; ?>


                            <a
                                href="<?= View::url(
                                    '/english/programs'
                                ) ?>"
                            >

                                <span>
                                    All Programs
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

                        </div>

                    </section>

                </div>


                <!-- =================================================
                     Sidebar
                ================================================== -->

                <aside
                    class="
                        english-program-detail-sidebar
                    "
                >


                    <!-- Program identity -->

                    <div
                        class="
                            english-program-detail-card
                            english-program-detail-card--identity
                        "
                    >

                        <div
                            class="
                                english-program-detail-card__mark
                            "
                            aria-hidden="true"
                        >
                            <?= View::escape(
                                $initial
                            ) ?>
                        </div>


                        <span>
                            ACADEMIC PROGRAM
                        </span>


                        <strong>
                            <?= View::escape(
                                $name
                            ) ?>
                        </strong>

                    </div>


                    <?php if (
                        $hasDetails
                    ): ?>

                        <div
                            class="
                                english-program-detail-card
                            "
                        >

                            <span
                                class="
                                    english-program-detail-card__title
                                "
                            >
                                PROGRAM DETAILS
                            </span>


                            <?php if (
                                $degree !== ''
                            ): ?>

                                <div
                                    class="
                                        english-program-detail-stat
                                    "
                                >

                                    <small>
                                        Degree
                                    </small>

                                    <strong>
                                        <?= View::escape(
                                            $degree
                                        ) ?>
                                    </strong>

                                </div>

                            <?php endif; ?>


                            <?php if (
                                $field !== ''
                            ): ?>

                                <div
                                    class="
                                        english-program-detail-stat
                                    "
                                >

                                    <small>
                                        Field of Study
                                    </small>

                                    <strong>
                                        <?= View::escape(
                                            $field
                                        ) ?>
                                    </strong>

                                </div>

                            <?php endif; ?>


                            <?php if (
                                $duration !== ''
                            ): ?>

                                <div
                                    class="
                                        english-program-detail-stat
                                    "
                                >

                                    <small>
                                        Duration
                                    </small>

                                    <strong>
                                        <?= View::escape(
                                            $duration
                                        ) ?>
                                    </strong>

                                </div>

                            <?php endif; ?>


                            <?php if (
                                $facultyName !== ''
                            ): ?>

                                <div
                                    class="
                                        english-program-detail-stat
                                    "
                                >

                                    <small>
                                        Faculty
                                    </small>

                                    <strong>
                                        <?= View::escape(
                                            $facultyName
                                        ) ?>
                                    </strong>

                                </div>

                            <?php endif; ?>

                        </div>

                    <?php endif; ?>


                    <!-- Navigation -->

                    <div
                        class="
                            english-program-detail-navigation
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
                            All Programs
                        </a>


                        <?php if (
                            $facultySlug !== ''
                        ): ?>

                            <a
                                href="<?= View::url(
                                    '/english/faculties/'
                                    . rawurlencode(
                                        $facultySlug
                                    )
                                ) ?>"
                                class="
                                    english-button
                                    english-button--secondary
                                "
                            >
                                View Faculty
                            </a>

                        <?php endif; ?>

                    </div>

                </aside>

            </div>

        </div>

    </main>


    <!-- =====================================================
         CTA
    ====================================================== -->

    <section
        class="
            english-program-detail-cta
        "
    >

        <div class="english-container">

            <div
                class="
                    english-program-detail-cta__inner
                "
            >

                <div>

                    <span>
                        ACADEMIC COMMUNITY
                    </span>

                    <h2>
                        Explore more of Sadra.
                    </h2>

                    <p>
                        Discover faculties, research centers,
                        announcements, and the wider academic
                        community of the institute.
                    </p>

                </div>


                <div
                    class="
                        english-program-detail-cta__actions
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
                        Faculties
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
                        Research
                    </a>

                </div>

            </div>

        </div>

    </section>

</section>
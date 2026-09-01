<?php

declare(strict_types=1);

use App\Core\View;


/*
|--------------------------------------------------------------------------
| Normalize data
|--------------------------------------------------------------------------
*/

$programs =
    is_array($programs ?? null)
        ? $programs
        : [];

$faculties =
    is_array($faculties ?? null)
        ? $faculties
        : [];


/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

$shorten =
    static function (
        mixed $value,
        int $width
    ): string {
        if (
            !is_string($value)
            || trim($value) === ''
        ) {
            return '';
        }

        return mb_strimwidth(
            trim($value),
            0,
            $width,
            '...',
            'UTF-8'
        );
    };


/*
|--------------------------------------------------------------------------
| Faculty lookup
|--------------------------------------------------------------------------
*/

$facultyNames = [];

$facultySlugs = [];

foreach (
    $faculties
    as $faculty
) {
    $facultyId =
        (int) (
            $faculty['id']
            ?? 0
        );

    if (
        $facultyId <= 0
    ) {
        continue;
    }

    $facultyName =
        trim(
            (string) (
                $faculty['name']
                ?? 'Faculty'
            )
        );

    $facultyNames[$facultyId] =
        $facultyName !== ''
            ? $facultyName
            : 'Faculty';

    $facultySlugs[$facultyId] =
        trim(
            (string) (
                $faculty['slug']
                ?? ''
            )
        );
}


/*
|--------------------------------------------------------------------------
| Program statistics
|--------------------------------------------------------------------------
*/

$programCount =
    count(
        $programs
    );

$facultyCount =
    count(
        array_filter(
            $facultyNames,
            static function (
                string $name
            ): bool {
                return $name !== '';
            }
        )
    );


/*
|--------------------------------------------------------------------------
| Available degrees
|--------------------------------------------------------------------------
*/

$degrees = [];

foreach (
    $programs
    as $program
) {
    $degree =
        trim(
            (string) (
                $program['degree']
                ?? ''
            )
        );

    if (
        $degree !== ''
    ) {
        $degrees[$degree] =
            true;
    }
}

$degreeCount =
    count(
        $degrees
    );

?>


<section class="english-programs-page">


    <!-- =====================================================
         HERO
    ====================================================== -->

    <header class="english-programs-hero">

        <div class="english-container">

            <div
                class="english-programs-hero__content"
            >

                <span>
                    ACADEMICS
                </span>

                <h1>
                    Academic Programs
                </h1>

                <p>
                    Explore the fields of study and academic
                    programs offered by Sadra Institute of
                    Higher Education.
                </p>

            </div>


            <?php if (
                $programCount > 0
            ): ?>

                <div
                    class="english-programs-hero__stats"
                >

                    <div>

                        <strong>
                            <?= $programCount ?>
                        </strong>

                        <span>
                            <?= $programCount === 1
                                ? 'Program'
                                : 'Programs'
                            ?>
                        </span>

                    </div>


                    <div>

                        <strong>
                            <?= $facultyCount ?>
                        </strong>

                        <span>
                            <?= $facultyCount === 1
                                ? 'Faculty'
                                : 'Faculties'
                            ?>
                        </span>

                    </div>


                    <div>

                        <strong>
                            <?= $degreeCount ?>
                        </strong>

                        <span>
                            <?= $degreeCount === 1
                                ? 'Degree'
                                : 'Degrees'
                            ?>
                        </span>

                    </div>

                </div>

            <?php endif; ?>

        </div>

    </header>


    <!-- =====================================================
         INTRO
    ====================================================== -->

    <section class="english-programs-intro">

        <div class="english-container">

            <div
                class="english-programs-intro__grid"
            >

                <div>

                    <span>
                        FIND YOUR PATH
                    </span>

                    <h2>
                        Explore what you can study
                        at Sadra.
                    </h2>

                </div>


                <div>

                    <p>
                        Our academic programs bring together
                        education, professional development,
                        and academic inquiry across different
                        fields of study.
                    </p>

                    <p>
                        Browse the programs below to learn more
                        about their academic structure, field,
                        duration, and admission information.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         FACULTIES
    ====================================================== -->

    <?php if (
        $faculties !== []
    ): ?>

        <section class="english-programs-faculties">

            <div class="english-container">

                <div
                    class="
                        english-programs-section-heading
                    "
                >

                    <div>

                        <span>
                            ACADEMIC STRUCTURE
                        </span>

                        <h2>
                            Faculties
                        </h2>

                    </div>

                </div>


                <div
                    class="
                        english-programs-faculty-grid
                    "
                >

                    <?php foreach (
                        $faculties
                        as $faculty
                    ): ?>

                        <?php
                        $facultyId =
                            (int) (
                                $faculty['id']
                                ?? 0
                            );

                        $facultyName =
                            trim(
                                (string) (
                                    $faculty['name']
                                    ?? ''
                                )
                            );

                        $facultyShortName =
                            trim(
                                (string) (
                                    $faculty['short_name']
                                    ?? ''
                                )
                            );

                        $facultySlug =
                            $facultySlugs[
                                $facultyId
                            ]
                            ?? '';
                        ?>


                        <?php if (
                            $facultyId <= 0
                            || $facultyName === ''
                        ): ?>

                            <?php continue; ?>

                        <?php endif; ?>


                        <article
                            class="
                                english-programs-faculty-card
                            "
                        >

                            <div
                                class="
                                    english-programs-faculty-card__number
                                "
                            >
                                <?= str_pad(
                                    (string) (
                                        array_search(
                                            $facultyId,
                                            array_keys(
                                                $facultyNames
                                            ),
                                            true
                                        ) + 1
                                    ),
                                    2,
                                    '0',
                                    STR_PAD_LEFT
                                ) ?>
                            </div>


                            <div>

                                <?php if (
                                    $facultyShortName !== ''
                                ): ?>

                                    <span
                                        class="
                                            english-programs-faculty-card__short
                                        "
                                    >
                                        <?= View::escape(
                                            $facultyShortName
                                        ) ?>
                                    </span>

                                <?php endif; ?>


                                <h3>
                                    <?= View::escape(
                                        $facultyName
                                    ) ?>
                                </h3>

                            </div>


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
                                    aria-label="View <?= View::escape(
                                        $facultyName
                                    ) ?>"
                                >
                                    →
                                </a>

                            <?php endif; ?>

                        </article>

                    <?php endforeach; ?>

                </div>

            </div>

        </section>

    <?php endif; ?>


    <!-- =====================================================
         PROGRAMS
    ====================================================== -->

    <section
        class="
            english-programs-section
        "
    >

        <div class="english-container">

            <div
                class="
                    english-programs-section-heading
                "
            >

                <div>

                    <span>
                        PROGRAM CATALOG
                    </span>

                    <h2>
                        Programs
                    </h2>

                </div>


                <?php if (
                    $programCount > 0
                ): ?>

                    <span
                        class="
                            english-programs-section-heading__count
                        "
                    >
                        <?= $programCount ?>
                        <?= $programCount === 1
                            ? 'program'
                            : 'programs'
                        ?>
                    </span>

                <?php endif; ?>

            </div>


            <?php if (
                $programs === []
            ): ?>

                <div
                    class="
                        english-empty
                        english-programs-empty
                    "
                >

                    <div
                        class="
                            english-programs-empty__icon
                        "
                        aria-hidden="true"
                    >
                        +
                    </div>

                    <h2>
                        No academic programs are currently available.
                    </h2>

                    <p>
                        Please check back later for updated
                        program information.
                    </p>

                </div>

            <?php else: ?>

                <div
                    class="
                        english-programs-grid
                    "
                >

                    <?php foreach (
                        $programs
                        as $index => $program
                    ): ?>

                        <?php
                        $slug =
                            trim(
                                (string) (
                                    $program['slug']
                                    ?? ''
                                )
                            );

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

                        $duration =
                            trim(
                                (string) (
                                    $program['duration']
                                    ?? ''
                                )
                            );

                        $description =
                            $shorten(
                                $program['description']
                                ?? '',
                                190
                            );

                        $facultyId =
                            (int) (
                                $program['faculty_id']
                                ?? 0
                            );

                        $facultyName =
                            $facultyNames[
                                $facultyId
                            ]
                            ?? '';

                        $number =
                            str_pad(
                                (string) (
                                    $index + 1
                                ),
                                2,
                                '0',
                                STR_PAD_LEFT
                            );
                        ?>


                        <?php if (
                            $name === ''
                        ): ?>

                            <?php continue; ?>

                        <?php endif; ?>


                        <article
                            class="
                                english-program-card
                            "
                        >

                            <div
                                class="
                                    english-program-card__top
                                "
                            >

                                <span>
                                    PROGRAM
                                </span>

                                <strong>
                                    <?= $number ?>
                                </strong>

                            </div>


                            <?php if (
                                $degree !== ''
                            ): ?>

                                <div
                                    class="
                                        english-program-card__degree
                                    "
                                >
                                    <?= View::escape(
                                        $degree
                                    ) ?>
                                </div>

                            <?php endif; ?>


                            <h2>
                                <?= View::escape(
                                    $name
                                ) ?>
                            </h2>


                            <?php if (
                                $facultyName !== ''
                            ): ?>

                                <div
                                    class="
                                        english-program-card__faculty
                                    "
                                >

                                    <span>
                                        Faculty
                                    </span>

                                    <strong>
                                        <?= View::escape(
                                            $facultyName
                                        ) ?>
                                    </strong>

                                </div>

                            <?php endif; ?>


                            <?php if (
                                $field !== ''
                            ): ?>

                                <div
                                    class="
                                        english-program-card__field
                                    "
                                >

                                    <span>
                                        Field of Study
                                    </span>

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
                                        english-program-card__duration
                                    "
                                >

                                    <span>
                                        Duration
                                    </span>

                                    <strong>
                                        <?= View::escape(
                                            $duration
                                        ) ?>
                                    </strong>

                                </div>

                            <?php endif; ?>


                            <?php if (
                                $description !== ''
                            ): ?>

                                <p>
                                    <?= View::escape(
                                        $description
                                    ) ?>
                                </p>

                            <?php else: ?>

                                <p>
                                    Explore the academic structure,
                                    study field, and other details
                                    of this program.
                                </p>

                            <?php endif; ?>


                            <?php if (
                                $slug !== ''
                            ): ?>

                                <a
                                    href="<?= View::url(
                                        '/english/programs/'
                                        . rawurlencode(
                                            $slug
                                        )
                                    ) ?>"
                                    class="
                                        english-program-card__link
                                    "
                                >

                                    <span>
                                        View program
                                    </span>

                                    <strong>
                                        →
                                    </strong>

                                </a>

                            <?php endif; ?>

                        </article>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </div>

    </section>


    <!-- =====================================================
         CTA
    ====================================================== -->

    <section class="english-programs-cta">

        <div class="english-container">

            <div
                class="
                    english-programs-cta__inner
                "
            >

                <div>

                    <span>
                        ACADEMIC JOURNEY
                    </span>

                    <h2>
                        Find the program
                        that fits your future.
                    </h2>

                    <p>
                        Explore our academic environment,
                        research activities, and institutional
                        community.
                    </p>

                </div>


                <div
                    class="
                        english-programs-cta__actions
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
<?php

declare(strict_types=1);

use App\Core\View;


/*
|--------------------------------------------------------------------------
| Normalize data
|--------------------------------------------------------------------------
*/

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
| Faculty count
|--------------------------------------------------------------------------
*/

$facultyCount =
    count(
        $faculties
    );

?>


<section
    class="english-faculties-page"
    lang="en"
    dir="ltr"
>


    <!-- =====================================================
         HERO
    ====================================================== -->

    <header
        class="
            english-faculties-hero
        "
    >

        <div
            class="
                english-container
            "
        >

            <div
                class="
                    english-faculties-hero__content
                "
            >

                <span>
                    ACADEMICS
                </span>


                <h1>
                    Faculties
                </h1>


                <p>
                    Explore the academic faculties of
                    Sadra Institute of Higher Education.
                    Discover their fields of study,
                    academic structure, and related
                    institutional information.
                </p>

            </div>


            <div
                class="
                    english-faculties-hero__meta
                "
                aria-label="Faculty statistics"
            >

                <strong>
                    <?= number_format(
                        $facultyCount
                    ) ?>
                </strong>


                <span>
                    Active Faculties
                </span>

            </div>

        </div>

    </header>


    <!-- =====================================================
         FACULTY LIST
    ====================================================== -->

    <main
        class="
            english-faculties-content
        "
    >

        <div
            class="
                english-container
            "
        >


            <?php if (
                $faculties === []
            ): ?>


                <!-- =============================================
                     EMPTY STATE
                ============================================== -->

                <section
                    class="
                        english-faculties-empty
                    "
                >

                    <div
                        class="
                            english-faculties-empty__mark
                        "
                        aria-hidden="true"
                    >
                        A
                    </div>


                    <span>
                        ACADEMICS
                    </span>


                    <h2>
                        No faculties are currently available.
                    </h2>


                    <p>
                        Faculty information has not yet been
                        published on the English version of
                        the website.
                    </p>


                    <a
                        href="<?= View::url(
                            '/english'
                        ) ?>"
                        class="
                            english-button
                            english-button--primary
                        "
                    >
                        Back to Home
                    </a>

                </section>


            <?php else: ?>


                <!-- =============================================
                     SECTION HEADER
                ============================================== -->

                <div
                    class="
                        english-faculties-heading
                    "
                >

                    <div>

                        <span>
                            ACADEMIC STRUCTURE
                        </span>


                        <h2>
                            Our Faculties
                        </h2>


                        <p>
                            Browse the active faculties and
                            explore their academic information.
                        </p>

                    </div>


                    <div
                        class="
                            english-faculties-heading__count
                        "
                    >

                        <strong>
                            <?= number_format(
                                $facultyCount
                            ) ?>
                        </strong>

                        <span>
                            Faculties
                        </span>

                    </div>

                </div>


                <!-- =============================================
                     FACULTY GRID
                ============================================== -->

                <div
                    class="
                        english-faculties-grid
                    "
                >

                    <?php foreach (
                        $faculties as $index => $faculty
                    ): ?>

                        <?php

                        /*
                         * Faculty data.
                         */

                        $id =
                            (int) (
                                $faculty['id']
                                ?? 0
                            );


                        $slug =
                            trim(
                                (string) (
                                    $faculty['slug']
                                    ?? ''
                                )
                            );


                        $name =
                            trim(
                                (string) (
                                    $faculty['name']
                                    ?? ''
                                )
                            );


                        $shortName =
                            trim(
                                (string) (
                                    $faculty['short_name']
                                    ?? ''
                                )
                            );


                        $description =
                            $shorten(
                                $faculty['description']
                                ?? '',
                                190
                            );


                        $image =
                            trim(
                                (string) (
                                    $faculty['image']
                                    ?? ''
                                )
                            );


                        $deanFirstName =
                            trim(
                                (string) (
                                    $faculty[
                                        'dean_first_name'
                                    ]
                                    ?? ''
                                )
                            );


                        $deanLastName =
                            trim(
                                (string) (
                                    $faculty[
                                        'dean_last_name'
                                    ]
                                    ?? ''
                                )
                            );


                        $deanName =
                            trim(
                                $deanFirstName
                                . ' '
                                . $deanLastName
                            );


                        /*
                         * Skip malformed records without a name.
                         */

                        if (
                            $name === ''
                        ) {
                            continue;
                        }


                        /*
                         * Initial fallback.
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


                        /*
                         * Public detail URL.
                         */

                        $facultyUrl =
                            $slug !== ''
                                ? View::url(
                                    '/english/faculties/'
                                    . rawurlencode(
                                        $slug
                                    )
                                )
                                : '';

                        ?>

                        <article
                            class="
                                english-faculties-card
                            "
                        >

                            <!-- =================================
                                 Visual
                            ================================== -->

                            <div
                                class="
                                    english-faculties-card__visual
                                "
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
                                        loading="lazy"
                                    >

                                <?php else: ?>

                                    <div
                                        class="
                                            english-faculties-card__placeholder
                                        "
                                        aria-hidden="true"
                                    >
                                        <?= View::escape(
                                            $initial
                                        ) ?>
                                    </div>

                                <?php endif; ?>


                                <span
                                    class="
                                        english-faculties-card__index
                                    "
                                    aria-hidden="true"
                                >
                                    <?= str_pad(
                                        (string) (
                                            $index + 1
                                        ),
                                        2,
                                        '0',
                                        STR_PAD_LEFT
                                    ) ?>
                                </span>

                            </div>


                            <!-- =================================
                                 Body
                            ================================== -->

                            <div
                                class="
                                    english-faculties-card__body
                                "
                            >

                                <span
                                    class="
                                        english-faculties-card__eyebrow
                                    "
                                >
                                    FACULTY
                                </span>


                                <?php if (
                                    $shortName !== ''
                                ): ?>

                                    <small
                                        class="
                                            english-faculties-card__short-name
                                        "
                                    >
                                        <?= View::escape(
                                            $shortName
                                        ) ?>
                                    </small>

                                <?php endif; ?>


                                <h3>
                                    <?= View::escape(
                                        $name
                                    ) ?>
                                </h3>


                                <?php if (
                                    $description !== ''
                                ): ?>

                                    <p>
                                        <?= View::escape(
                                            $description
                                        ) ?>
                                    </p>

                                <?php endif; ?>


                                <?php if (
                                    $deanName !== ''
                                ): ?>

                                    <div
                                        class="
                                            english-faculties-card__dean
                                        "
                                    >

                                        <span>
                                            DEAN
                                        </span>

                                        <strong>
                                            <?= View::escape(
                                                $deanName
                                            ) ?>
                                        </strong>

                                    </div>

                                <?php endif; ?>


                                <?php if (
                                    $facultyUrl !== ''
                                ): ?>

                                    <a
                                        href="<?= View::escape(
                                            $facultyUrl
                                        ) ?>"
                                        class="
                                            english-faculties-card__link
                                        "
                                    >

                                        <span>
                                            Explore Faculty
                                        </span>

                                        <strong
                                            aria-hidden="true"
                                        >
                                            →
                                        </strong>

                                    </a>

                                <?php endif; ?>

                            </div>

                        </article>

                    <?php endforeach; ?>

                </div>


                <!-- =============================================
                     BOTTOM CTA
                ============================================== -->

                <section
                    class="
                        english-faculties-cta
                    "
                >

                    <div
                        class="
                            english-faculties-cta__content
                        "
                    >

                        <span>
                            SADRA INSTITUTE
                        </span>


                        <h2>
                            Explore education and research at Sadra.
                        </h2>


                        <p>
                            Learn more about academic programs,
                            research centers, announcements,
                            and the wider academic community.
                        </p>

                    </div>


                    <div
                        class="
                            english-faculties-cta__actions
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
                            Academic Programs
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
                            Research Centers
                        </a>

                    </div>

                </section>

            <?php endif; ?>


        </div>

    </main>

</section>
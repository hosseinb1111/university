<?php

declare(strict_types=1);

use App\Core\View;


/*
|--------------------------------------------------------------------------
| Normalize data
|--------------------------------------------------------------------------
*/

$researchCenters =
    is_array($researchCenters ?? null)
        ? $researchCenters
        : [];


/*
|--------------------------------------------------------------------------
| Helper
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


?>

<section class="english-research-page">


    <!-- =====================================================
         HERO
    ====================================================== -->

    <header class="english-research-hero">

        <div class="english-container">

            <div class="english-research-hero__content">

                <span>
                    RESEARCH & INNOVATION
                </span>

                <h1>
                    Research
                </h1>

                <p>
                    Discover the research centers and scientific
                    activities that contribute to knowledge,
                    innovation, and academic development at
                    Sadra Institute.
                </p>

            </div>


            <?php if (
                $researchCenters !== []
            ): ?>

                <div
                    class="english-research-hero__count"
                    aria-label="Number of research centers"
                >

                    <strong>
                        <?= count(
                            $researchCenters
                        ) ?>
                    </strong>

                    <span>
                        <?= count(
                            $researchCenters
                        ) === 1
                            ? 'Research Center'
                            : 'Research Centers'
                        ?>
                    </span>

                </div>

            <?php endif; ?>

        </div>

    </header>


    <!-- =====================================================
         INTRO
    ====================================================== -->

    <section class="english-research-intro">

        <div class="english-container">

            <div class="english-research-intro__grid">

                <div>

                    <span>
                        A CULTURE OF INQUIRY
                    </span>

                    <h2>
                        Turning questions into
                        knowledge.
                    </h2>

                </div>


                <div>

                    <p>
                        Research is an essential part of a modern
                        academic environment. It creates space for
                        discovery, critical thinking, collaboration,
                        and new ideas.
                    </p>

                    <p>
                        Explore the research centers of Sadra
                        Institute and discover the areas in which
                        academic and scientific activities take place.
                    </p>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         RESEARCH CENTERS
    ====================================================== -->

    <section class="english-research-section">

        <div class="english-container">

            <div class="english-research-section__heading">

                <div>

                    <span>
                        EXPLORE
                    </span>

                    <h2>
                        Research Centers
                    </h2>

                </div>


                <a
                    href="<?= View::url(
                        '/english/contact'
                    ) ?>"
                >
                    Connect with Sadra
                    <strong>→</strong>
                </a>

            </div>


            <?php if (
                $researchCenters === []
            ): ?>

                <div
                    class="
                        english-empty
                        english-research-empty
                    "
                >

                    <div
                        class="english-research-empty__icon"
                        aria-hidden="true"
                    >
                        +
                    </div>

                    <h2>
                        Research information is not currently available.
                    </h2>

                    <p>
                        Please check back later for updated
                        research information.
                    </p>

                </div>

            <?php else: ?>

                <div class="english-research-grid">

                    <?php foreach (
                        $researchCenters
                        as $index => $center
                    ): ?>

                        <?php
                        $centerSlug =
                            trim(
                                (string) (
                                    $center['slug']
                                    ?? ''
                                )
                            );

                        $centerName =
                            trim(
                                (string) (
                                    $center['name']
                                    ?? ''
                                )
                            );

                        $centerShortName =
                            trim(
                                (string) (
                                    $center['short_name']
                                    ?? ''
                                )
                            );

                        $centerDescription =
                            $shorten(
                                $center['description']
                                ?? '',
                                220
                            );

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
                            $centerName === ''
                        ): ?>

                            <?php continue; ?>

                        <?php endif; ?>


                        <article
                            class="english-research-card"
                        >

                            <div
                                class="english-research-card__header"
                            >

                                <div
                                    class="english-research-card__number"
                                >
                                    <?= $number ?>
                                </div>


                                <span>
                                    RESEARCH CENTER
                                </span>

                            </div>


                            <div
                                class="english-research-card__body"
                            >

                                <?php if (
                                    $centerShortName !== ''
                                ): ?>

                                    <span
                                        class="english-research-card__short"
                                    >
                                        <?= View::escape(
                                            $centerShortName
                                        ) ?>
                                    </span>

                                <?php endif; ?>


                                <h2>
                                    <?= View::escape(
                                        $centerName
                                    ) ?>
                                </h2>


                                <?php if (
                                    $centerDescription !== ''
                                ): ?>

                                    <p>
                                        <?= View::escape(
                                            $centerDescription
                                        ) ?>
                                    </p>

                                <?php else: ?>

                                    <p>
                                        Explore the research
                                        activities and academic
                                        focus of this center.
                                    </p>

                                <?php endif; ?>

                            </div>


                            <?php if (
                                $centerSlug !== ''
                            ): ?>

                                <a
                                    href="<?= View::url(
                                        '/english/research/'
                                        . rawurlencode(
                                            $centerSlug
                                        )
                                    ) ?>"
                                    class="english-research-card__link"
                                >

                                    <span>
                                        Explore research center
                                    </span>

                                    <strong>
                                        →
                                    </strong>

                                </a>

                            <?php else: ?>

                                <span
                                    class="
                                        english-research-card__link
                                        english-research-card__link--disabled
                                    "
                                >

                                    <span>
                                        Information
                                    </span>

                                </span>

                            <?php endif; ?>

                        </article>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </div>

    </section>


    <!-- =====================================================
         RESEARCH PRINCIPLES
    ====================================================== -->

    <section class="english-research-principles">

        <div class="english-container">

            <div class="english-research-principles__heading">

                <span>
                    RESEARCH AT SADRA
                </span>

                <h2>
                    Where curiosity becomes
                    meaningful work.
                </h2>

                <p>
                    A strong research environment depends on more
                    than facilities. It depends on curiosity,
                    collaboration, responsibility, and the freedom
                    to explore meaningful questions.
                </p>

            </div>


            <div class="english-research-principles__grid">

                <article>

                    <span>
                        01
                    </span>

                    <h3>
                        Discovery
                    </h3>

                    <p>
                        Encouraging questions that lead to deeper
                        understanding and new perspectives.
                    </p>

                </article>


                <article>

                    <span>
                        02
                    </span>

                    <h3>
                        Collaboration
                    </h3>

                    <p>
                        Connecting researchers, academics, students,
                        and institutions around shared interests.
                    </p>

                </article>


                <article>

                    <span>
                        03
                    </span>

                    <h3>
                        Innovation
                    </h3>

                    <p>
                        Supporting ideas that can become practical
                        solutions, technologies, and new knowledge.
                    </p>

                </article>


                <article>

                    <span>
                        04
                    </span>

                    <h3>
                        Impact
                    </h3>

                    <p>
                        Striving for research that creates value
                        for academia, society, and professional life.
                    </p>

                </article>

            </div>

        </div>

    </section>


    <!-- =====================================================
         CTA
    ====================================================== -->

    <section class="english-research-cta">

        <div class="english-container">

            <div class="english-research-cta__inner">

                <div>

                    <span>
                        WORK WITH US
                    </span>

                    <h2>
                        Interested in research
                        at Sadra?
                    </h2>

                    <p>
                        Get in touch with the institute to learn
                        more about our academic and research
                        activities.
                    </p>

                </div>


                <div
                    class="english-research-cta__actions"
                >

                    <a
                        href="<?= View::url(
                            '/english/contact'
                        ) ?>"
                        class="english-button english-button--primary"
                    >
                        Contact Us
                    </a>


                    <a
                        href="<?= View::url(
                            '/english/faculties'
                        ) ?>"
                        class="
                            english-button
                            english-button--secondary
                        "
                    >
                        Explore Academics
                    </a>

                </div>

            </div>

        </div>

    </section>

</section>
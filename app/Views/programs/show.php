<?php

declare(strict_types=1);

use App\Core\View;

$program =
    is_array($program ?? null)
        ? $program
        : [];

$programName =
    trim(
        (string) (
            $program['name']
            ?? 'رشته آموزشی'
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
    trim(
        (string) (
            $program['description']
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

$programSlug =
    trim(
        (string) (
            $program['slug']
            ?? ''
        )
    );
?>

<section class="institution-page">

    <div class="container">

        <article class="program-detail">


            <!-- =================================================
                 Breadcrumb
            ================================================== -->

            <nav
                class="program-detail__breadcrumb"
                aria-label="مسیر صفحه"
            >

                <a
                    href="<?= View::url(
                        '/programs'
                    ) ?>"
                >
                    رشته‌ها
                </a>


                <?php if (
                    $facultyName !== ''
                    && $facultySlug !== ''
                ): ?>

                    <span aria-hidden="true">
                        /
                    </span>

                    <a
                        href="<?= View::url(
                            '/faculties/'
                            . rawurlencode(
                                $facultySlug
                            )
                        ) ?>"
                    >
                        <?= View::escape(
                            $facultyName
                        ) ?>
                    </a>

                <?php endif; ?>


                <span aria-hidden="true">
                    /
                </span>

                <span>
                    <?= View::escape(
                        $programName
                    ) ?>
                </span>

            </nav>


            <!-- =================================================
                 Header
            ================================================== -->

            <header class="program-detail__header">

                <?php if (
                    $facultyName !== ''
                ): ?>

                    <span>
                        <?= View::escape(
                            $facultyName
                        ) ?>
                    </span>

                <?php else: ?>

                    <span>
                        برنامه آموزشی
                    </span>

                <?php endif; ?>


                <h1>
                    <?= View::escape(
                        $programName
                    ) ?>
                </h1>


                <?php if (
                    $facultyName !== ''
                    && $facultySlug !== ''
                ): ?>

                    <a
                        href="<?= View::url(
                            '/faculties/'
                            . rawurlencode(
                                $facultySlug
                            )
                        ) ?>"
                    >
                        <?= View::escape(
                            $facultyName
                        ) ?>
                    </a>

                <?php endif; ?>

            </header>


            <!-- =================================================
                 Basic information
            ================================================== -->

            <div class="program-detail__grid">

                <?php if (
                    $degree !== ''
                ): ?>

                    <div class="program-info-card">

                        <span>
                            مقطع تحصیلی
                        </span>

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

                    <div class="program-info-card">

                        <span>
                            گرایش / حوزه
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

                    <div class="program-info-card">

                        <span>
                            مدت دوره
                        </span>

                        <strong>
                            <?= View::escape(
                                $duration
                            ) ?>
                        </strong>

                    </div>

                <?php endif; ?>

            </div>


            <!-- =================================================
                 Description
            ================================================== -->

            <?php if (
                $description !== ''
            ): ?>

                <section
                    class="program-detail__section"
                >

                    <h2>
                        معرفی رشته
                    </h2>

                    <div
                        class="program-detail__content"
                    >

                        <?= nl2br(
                            View::escape(
                                $description
                            )
                        ) ?>

                    </div>

                </section>

            <?php endif; ?>


            <!-- =================================================
                 Admission
            ================================================== -->

            <?php if (
                $admissionInfo !== ''
            ): ?>

                <section
                    class="program-detail__section"
                >

                    <h2>
                        اطلاعات پذیرش
                    </h2>

                    <div
                        class="program-detail__content"
                    >

                        <?= nl2br(
                            View::escape(
                                $admissionInfo
                            )
                        ) ?>

                    </div>

                </section>

            <?php endif; ?>


            <!-- =================================================
                 Curriculum
            ================================================== -->

            <?php if (
                $curriculum !== ''
            ): ?>

                <section
                    class="program-detail__section"
                >

                    <h2>
                        برنامه درسی
                    </h2>

                    <div
                        class="program-detail__content"
                    >

                        <?= nl2br(
                            View::escape(
                                $curriculum
                            )
                        ) ?>

                    </div>

                </section>

            <?php endif; ?>


            <!-- =================================================
                 Actions
            ================================================== -->

            <div
                class="program-detail__actions"
            >

                <?php if (
                    $facultySlug !== ''
                ): ?>

                    <a
                        href="<?= View::url(
                            '/faculties/'
                            . rawurlencode(
                                $facultySlug
                            )
                        ) ?>"
                        class="button button--primary"
                    >
                        مشاهده دانشکده
                    </a>

                <?php endif; ?>


                <a
                    href="<?= View::url(
                        '/programs'
                    ) ?>"
                    class="button button--secondary"
                >
                    همه رشته‌ها
                </a>


                <?php if (
                    $facultySlug === ''
                    && $programSlug === ''
                ): ?>

                    <a
                        href="<?= View::url(
                            '/contact'
                        ) ?>"
                        class="button button--secondary"
                    >
                        تماس با موسسه
                    </a>

                <?php endif; ?>

            </div>

        </article>

    </div>

</section>
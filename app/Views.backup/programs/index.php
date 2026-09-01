<?php

declare(strict_types=1);

use App\Core\View;

$programs =
    is_array($programs ?? null)
        ? $programs
        : [];

$faculties =
    is_array($faculties ?? null)
        ? $faculties
        : [];
?>

<section class="institution-page">

    <div class="container">

        <header class="institution-hero">

            <span>
                آموزش
            </span>

            <h1>
                رشته‌ها و برنامه‌های آموزشی
            </h1>

            <p>
                فهرست رشته‌ها و برنامه‌های آموزشی موسسه آموزش عالی صدرالمتالهین.
            </p>

        </header>


        <?php if ($programs === []): ?>

            <div class="institution-empty">

                <strong>
                    رشته‌ای برای نمایش وجود ندارد.
                </strong>

                <p>
                    اطلاعات رشته‌ها هنوز ثبت یا منتشر نشده است.
                </p>

            </div>

        <?php else: ?>

            <?php
            $facultyGroups = [];

            foreach ($programs as $program) {
                $facultyId =
                    (int) (
                        $program['faculty_id']
                        ?? 0
                    );

                if (!isset(
                    $facultyGroups[$facultyId]
                )) {
                    $facultyGroups[$facultyId] = [];
                }

                $facultyGroups[$facultyId][] =
                    $program;
            }
            ?>

            <?php foreach (
                $facultyGroups
                as $facultyId => $facultyPrograms
            ): ?>

                <?php
                $facultyName = 'رشته‌ها';

                $facultySlug = '';

                foreach ($faculties as $faculty) {
                    if (
                        (int) (
                            $faculty['id']
                            ?? 0
                        ) === (int) $facultyId
                    ) {
                        $facultyName =
                            (string) (
                                $faculty['name']
                                ?? 'رشته‌ها'
                            );

                        $facultySlug =
                            (string) (
                                $faculty['slug']
                                ?? ''
                            );

                        break;
                    }
                }
                ?>

                <section class="program-group">

                    <div
                        class="institution-section__heading"
                    >

                        <div>

                            <span>
                                دانشکده
                            </span>

                            <h2>
                                <?= View::escape(
                                    $facultyName
                                ) ?>
                            </h2>

                        </div>


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
                                class="button button--secondary"
                            >
                                مشاهده دانشکده
                            </a>

                        <?php endif; ?>

                    </div>


                    <div class="program-grid">

                        <?php foreach (
                            $facultyPrograms
                            as $program
                        ): ?>

                            <?php
                            $programName =
                                trim(
                                    (string) (
                                        $program['name']
                                        ?? 'رشته آموزشی'
                                    )
                                );

                            $programSlug =
                                trim(
                                    (string) (
                                        $program['slug']
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
                            ?>

                            <?php if (
                                $programSlug === ''
                            ): ?>

                                <article class="program-card">

                            <?php else: ?>

                                <a
                                    href="<?= View::url(
                                        '/programs/'
                                        . rawurlencode(
                                            $programSlug
                                        )
                                    ) ?>"
                                    class="program-card"
                                >

                            <?php endif; ?>


                                <h3>
                                    <?= View::escape(
                                        $programName
                                    ) ?>
                                </h3>


                                <?php if (
                                    $degree !== ''
                                ): ?>

                                    <div>

                                        <span>
                                            <?= View::escape(
                                                $degree
                                            ) ?>
                                        </span>

                                    </div>

                                <?php endif; ?>


                                <?php if (
                                    $field !== ''
                                ): ?>

                                    <p>
                                        <?= View::escape(
                                            $field
                                        ) ?>
                                    </p>

                                <?php elseif (
                                    $description !== ''
                                ): ?>

                                    <p>
                                        <?= View::escape(
                                            mb_strimwidth(
                                                $description,
                                                0,
                                                150,
                                                '...',
                                                'UTF-8'
                                            )
                                        ) ?>
                                    </p>

                                <?php endif; ?>


                                <?php if (
                                    $programSlug !== ''
                                ): ?>

                                    <span class="program-card__arrow">
                                        مشاهده رشته
                                    </span>

                                <?php endif; ?>


                            <?php if (
                                $programSlug === ''
                            ): ?>

                                </article>

                            <?php else: ?>

                                </a>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    </div>

                </section>

            <?php endforeach; ?>

        <?php endif; ?>


        <section class="institution-section">

            <div class="institution-action-grid">

                <a
                    href="<?= View::url(
                        '/faculties'
                    ) ?>"
                    class="institution-action-card"
                >

                    <strong>
                        دانشکده‌ها
                    </strong>

                    <span>
                        معرفی دانشکده‌ها و گروه‌های آموزشی موسسه.
                    </span>

                </a>


                <a
                    href="<?= View::url(
                        '/research-centers'
                    ) ?>"
                    class="institution-action-card"
                >

                    <strong>
                        پژوهشکده‌ها
                    </strong>

                    <span>
                        مراکز پژوهشی و فعالیت‌های تحقیقاتی موسسه.
                    </span>

                </a>


                <a
                    href="<?= View::url(
                        '/contact'
                    ) ?>"
                    class="institution-action-card"
                >

                    <strong>
                        اطلاعات بیشتر
                    </strong>

                    <span>
                        برای دریافت اطلاعات بیشتر با موسسه تماس بگیرید.
                    </span>

                </a>

            </div>

        </section>

    </div>

</section>
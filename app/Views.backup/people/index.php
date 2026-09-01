<?php

declare(strict_types=1);

use App\Core\View;

$people =
    is_array($people ?? null)
        ? $people
        : [];
?>

<section class="institution-page">

    <div class="container">

        <header class="institution-hero">

            <span>
                اعضای موسسه
            </span>

            <h1>
                اعضای هیئت علمی و کارکنان
            </h1>

            <p>
                فهرست اعضای هیئت علمی، مدیران و کارکنان موسسه آموزش عالی صدرالمتالهین.
            </p>

        </header>


        <?php if ($people === []): ?>

            <div class="institution-empty">

                <strong>
                    عضوی برای نمایش وجود ندارد.
                </strong>

                <p>
                    اطلاعات اعضای موسسه هنوز ثبت نشده است.
                </p>

            </div>

        <?php else: ?>

            <div class="people-grid">

                <?php foreach ($people as $person): ?>

                    <?php
                    $id =
                        (int) (
                            $person['id']
                            ?? 0
                        );

                    $firstName =
                        trim(
                            (string) (
                                $person['first_name']
                                ?? ''
                            )
                        );

                    $lastName =
                        trim(
                            (string) (
                                $person['last_name']
                                ?? ''
                            )
                        );

                    $fullName =
                        trim(
                            $firstName
                            . ' '
                            . $lastName
                        );

                    if ($fullName === '') {
                        $fullName = 'عضو موسسه';
                    }

                    $position =
                        trim(
                            (string) (
                                $person['position']
                                ?? ''
                            )
                        );
                    ?>

                    <article class="person-card">

                        <a
                            href="<?= View::url(
                                '/people/' . $id
                            ) ?>"
                            class="person-card__image"
                        >

                            <?php if (
                                !empty($person['image'])
                            ): ?>

                                <img
                                    src="<?= View::escape(
                                        (string) $person['image']
                                    ) ?>"
                                    alt="<?= View::escape(
                                        $fullName
                                    ) ?>"
                                    loading="lazy"
                                >

                            <?php else: ?>

                                <span aria-hidden="true">
                                    <?= View::escape(
                                        mb_substr(
                                            $fullName,
                                            0,
                                            1,
                                            'UTF-8'
                                        )
                                    ) ?>
                                </span>

                            <?php endif; ?>

                        </a>


                        <div class="person-card__body">

                            <h2>

                                <a
                                    href="<?= View::url(
                                        '/people/' . $id
                                    ) ?>"
                                >
                                    <?= View::escape(
                                        $fullName
                                    ) ?>
                                </a>

                            </h2>


                            <?php if ($position !== ''): ?>

                                <p>
                                    <?= View::escape(
                                        $position
                                    ) ?>
                                </p>

                            <?php endif; ?>


                            <?php if (
                                !empty($person['faculty_name'])
                            ): ?>

                                <span>
                                    <?= View::escape(
                                        (string) $person['faculty_name']
                                    ) ?>
                                </span>

                            <?php endif; ?>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>
<?php

declare(strict_types=1);

use App\Core\View;

$person =
    is_array($person ?? null)
        ? $person
        : [];

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

$facultyName =
    trim(
        (string) (
            $person['faculty_name']
            ?? ''
        )
    );
?>

<section class="institution-page">

    <div class="container">

        <nav
            class="program-detail__breadcrumb"
            aria-label="مسیر صفحه"
        >

            <a
                href="<?= View::url('/people') ?>"
            >
                اعضای موسسه
            </a>

            <span aria-hidden="true">
                /
            </span>

            <span>
                <?= View::escape($fullName) ?>
            </span>

        </nav>


        <article class="person-detail">

            <div class="person-detail__image">

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
                    >

                <?php else: ?>

                    <div
                        class="person-detail__placeholder"
                        aria-hidden="true"
                    >
                        <?= View::escape(
                            mb_substr(
                                $fullName,
                                0,
                                1,
                                'UTF-8'
                            )
                        ) ?>
                    </div>

                <?php endif; ?>

            </div>


            <div class="person-detail__body">

                <span class="person-detail__eyebrow">
                    عضو موسسه
                </span>

                <h1>
                    <?= View::escape(
                        $fullName
                    ) ?>
                </h1>


                <?php if ($position !== ''): ?>

                    <p class="person-detail__position">
                        <?= View::escape(
                            $position
                        ) ?>
                    </p>

                <?php endif; ?>


                <?php if ($facultyName !== ''): ?>

                    <a
                        href="<?= View::url(
                            '/faculties/'
                            . rawurlencode(
                                (string) (
                                    $person['faculty_slug']
                                    ?? ''
                                )
                            )
                        ) ?>"
                        class="person-detail__faculty"
                    >
                        <?= View::escape(
                            $facultyName
                        ) ?>
                    </a>

                <?php endif; ?>


                <?php if (
                    !empty($person['biography'])
                ): ?>

                    <div class="institution-rich-text">

                        <?= nl2br(
                            View::escape(
                                (string) $person['biography']
                            )
                        ) ?>

                    </div>

                <?php endif; ?>


                <div class="person-detail__contact">

                    <?php if (
                        !empty($person['email'])
                    ): ?>

                        <a
                            href="mailto:<?= View::escape(
                                (string) $person['email']
                            ) ?>"
                        >
                            <?= View::escape(
                                (string) $person['email']
                            ) ?>
                        </a>

                    <?php endif; ?>


                    <?php if (
                        !empty($person['phone'])
                    ): ?>

                        <?php
                        $phone =
                            preg_replace(
                                '/[^0-9+]/',
                                '',
                                (string) $person['phone']
                            );
                        ?>

                        <a
                            href="tel:<?= View::escape(
                                is_string($phone)
                                    ? $phone
                                    : ''
                            ) ?>"
                        >
                            <?= View::escape(
                                (string) $person['phone']
                            ) ?>
                        </a>

                    <?php endif; ?>


                    <?php if (
                        !empty($person['office_location'])
                    ): ?>

                        <span>
                            <?= View::escape(
                                (string) $person['office_location']
                            ) ?>
                        </span>

                    <?php endif; ?>

                </div>

            </div>

        </article>

    </div>

</section>
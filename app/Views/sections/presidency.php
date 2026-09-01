<?php

declare(strict_types=1);

use App\Core\View;
use App\Models\SiteSetting;


/*
|--------------------------------------------------------------------------
| Normalize people data
|--------------------------------------------------------------------------
*/

$people =
    is_array(
        $people ?? null
    )
        ? $people
        : [];


/*
|--------------------------------------------------------------------------
| Normalize selected president
|--------------------------------------------------------------------------
*/

$president =
    is_array(
        $president ?? null
    )
        ? $president
        : null;


/*
|--------------------------------------------------------------------------
| Selected president ID
|--------------------------------------------------------------------------
*/

$presidentId =
    null;

if (
    is_array($president)
    && isset(
        $president['id']
    )
) {
    $presidentId =
        (int) $president['id'];
}


/*
|--------------------------------------------------------------------------
| Backward compatibility
|--------------------------------------------------------------------------
*/

if (
    $people === []
    && $president !== null
) {
    $people = [
        $president,
    ];
}


/*
|--------------------------------------------------------------------------
| Management position keywords
|--------------------------------------------------------------------------
|
| Only people whose position identifies them as
| management/leadership are displayed here.
|
*/

$managementKeywords = [
    'رئیس',
    'رییس',
    'معاون',
    'مدیر',
    'سرپرست',
    'مسئول',
    'مسؤول',
    'مدیرکل',
    'مدیر کل',
    'معاونت',
    'رئیس دفتر',
    'رییس دفتر',
];


/*
|--------------------------------------------------------------------------
| Build management-only collection
|--------------------------------------------------------------------------
*/

$managementPeople = [];


foreach (
    $people as $person
) {
    if (
        !is_array($person)
    ) {
        continue;
    }


    $personId =
        isset(
            $person['id']
        )
            ? (int) $person['id']
            : null;


    /*
     * The currently selected president is already
     * displayed in the featured president section.
     */
    if (
        $presidentId !== null
        && $personId === $presidentId
    ) {
        continue;
    }


    $position =
        trim(
            (string) (
                $person['position']
                ?? ''
            )
        );


    /*
     * A person without a position cannot be identified
     * as a manager.
     */
    if (
        $position === ''
    ) {
        continue;
    }


    $isManager =
        false;


    foreach (
        $managementKeywords as $keyword
    ) {
        if (
            str_contains(
                $position,
                $keyword
            )
        ) {
            $isManager =
                true;

            break;
        }
    }


    if (
        !$isManager
    ) {
        continue;
    }


    $managementPeople[] =
        $person;
}


/*
|--------------------------------------------------------------------------
| Explicit management ordering
|--------------------------------------------------------------------------
|
| This is the important fix.
|
| The value entered in the admin "ترتیب" / sort_order
| field is now the authoritative order on this page.
|
| Smaller numbers appear first.
|
| Example:
|
| 1 -> Manager A
| 2 -> Manager B
| 3 -> Manager C
|
| Empty/zero values are placed after explicitly ordered
| managers so they do not unexpectedly jump to the top.
|
*/

usort(
    $managementPeople,
    static function (
        array $a,
        array $b
    ): int {
        $sortA =
            isset(
                $a['sort_order']
            )
                ? (int) $a['sort_order']
                : 0;


        $sortB =
            isset(
                $b['sort_order']
            )
                ? (int) $b['sort_order']
                : 0;


        /*
         * Treat zero as "no explicit order".
         * Explicitly ordered people come first.
         */
        if (
            $sortA === 0
            && $sortB !== 0
        ) {
            return 1;
        }


        if (
            $sortA !== 0
            && $sortB === 0
        ) {
            return -1;
        }


        /*
         * Primary ordering:
         * sort_order ASC
         */
        if (
            $sortA !== $sortB
        ) {
            return $sortA <=> $sortB;
        }


        /*
         * Secondary ordering:
         * last name ASC
         */
        $lastA =
            trim(
                (string) (
                    $a['last_name']
                    ?? ''
                )
            );


        $lastB =
            trim(
                (string) (
                    $b['last_name']
                    ?? ''
                )
            );


        $lastComparison =
            strcmp(
                mb_strtolower(
                    $lastA,
                    'UTF-8'
                ),
                mb_strtolower(
                    $lastB,
                    'UTF-8'
                )
            );


        if (
            $lastComparison !== 0
        ) {
            return $lastComparison;
        }


        /*
         * Tertiary ordering:
         * first name ASC
         */
        $firstA =
            trim(
                (string) (
                    $a['first_name']
                    ?? ''
                )
            );


        $firstB =
            trim(
                (string) (
                    $b['first_name']
                    ?? ''
                )
            );


        $firstComparison =
            strcmp(
                mb_strtolower(
                    $firstA,
                    'UTF-8'
                ),
                mb_strtolower(
                    $firstB,
                    'UTF-8'
                )
            );


        if (
            $firstComparison !== 0
        ) {
            return $firstComparison;
        }


        /*
         * Final deterministic fallback:
         * database ID ASC
         */
        return (
            (int) (
                $a['id']
                ?? 0
            )
        )
            <=>
        (
            (int) (
                $b['id']
                ?? 0
            )
        );
    }
);


/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

$getPersonName =
    static function (
        array $person
    ): string {
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


        $name =
            trim(
                $firstName
                . ' '
                . $lastName
            );


        return $name !== ''
            ? $name
            : 'عضو مدیریتی';
    };


$getPhoneHref =
    static function (
        mixed $phone
    ): string {
        $phone =
            preg_replace(
                '/[^0-9+]/',
                '',
                (string) $phone
            );


        return is_string(
            $phone
        )
            ? $phone
            : '';
    };


$hasPresident =
    $president !== null;


$hasManagementPeople =
    $managementPeople !== [];


/*
|--------------------------------------------------------------------------
| Presidency office email
|--------------------------------------------------------------------------
|
| Read directly from the existing contact setting.
| This keeps the email controlled by the admin panel.
|
*/

$officeEmail =
    trim(
        (string) (
            SiteSetting::get(
                'contact.email',
                'info@sadra.ac.ir'
            )
        )
    );

?>

<section class="institution-page">

    <div class="container">


        <!-- =========================================================
             PAGE HERO
        ========================================================== -->

        <header class="institution-hero">

            <span>
                مدیریت موسسه
            </span>


            <h1>
                ریاست موسسه
            </h1>


            <p>
                اطلاعات ریاست، مدیران و مسئولان مرتبط با ساختار
                مدیریتی موسسه آموزش عالی صدرالمتالهین.
            </p>

        </header>


        <!-- =========================================================
             CURRENT PRESIDENT
        ========================================================== -->

        <?php if (
            $hasPresident
        ): ?>

            <?php
            $presidentName =
                $getPersonName(
                    $president
                );


            $presidentInitial =
                mb_substr(
                    $presidentName,
                    0,
                    1,
                    'UTF-8'
                );


            $presidentPosition =
                trim(
                    (string) (
                        $president['position']
                        ?? ''
                    )
                );


            $presidentFaculty =
                trim(
                    (string) (
                        $president['faculty_name']
                        ?? ''
                    )
                );


            $presidentBiography =
                trim(
                    (string) (
                        $president['biography']
                        ?? ''
                    )
                );


            $presidentEmail =
                trim(
                    (string) (
                        $president['email']
                        ?? ''
                    )
                );


            $presidentPhone =
                trim(
                    (string) (
                        $president['phone']
                        ?? ''
                    )
                );


            $presidentPhoneHref =
                $getPhoneHref(
                    $presidentPhone
                );
            ?>


            <section
                class="presidency-feature"
                aria-labelledby="presidency-current-title"
            >

                <?php if (
                    $presidentPosition !== ''
                ): ?>

                    <div
                        class="
                            presidency-feature__label
                        "
                    >

                        <span>
                            مدیریت
                        </span>


                        <strong>
                            <?= View::escape(
                                $presidentPosition
                            ) ?>
                        </strong>

                    </div>

                <?php endif; ?>


                <article
                    class="
                        presidency-card
                        presidency-card--featured
                    "
                >

                    <!-- =============================================
                         PRESIDENT IMAGE
                    ============================================== -->

                    <div
                        class="
                            presidency-card__media
                        "
                    >

                        <?php if (
                            !empty(
                                $president['image']
                            )
                        ): ?>

                            <img
                                src="<?= View::escape(
                                    (string) $president['image']
                                ) ?>"
                                alt="<?= View::escape(
                                    $presidentName
                                ) ?>"
                                loading="eager"
                            >

                        <?php else: ?>

                            <div
                                class="
                                    presidency-card__placeholder
                                "
                                aria-hidden="true"
                            >
                                <?= View::escape(
                                    $presidentInitial
                                ) ?>
                            </div>

                        <?php endif; ?>

                    </div>


                    <!-- =============================================
                         PRESIDENT INFORMATION
                    ============================================== -->

                    <div
                        class="
                            presidency-card__body
                        "
                    >

                        <?php if (
                            $presidentPosition !== ''
                        ): ?>

                            <span
                                class="
                                    presidency-card__eyebrow
                                "
                            >
                                <?= View::escape(
                                    $presidentPosition
                                ) ?>
                            </span>

                        <?php endif; ?>


                        <h2
                            id="presidency-current-title"
                        >
                            <?= View::escape(
                                $presidentName
                            ) ?>
                        </h2>


                        <?php if (
                            $presidentFaculty !== ''
                        ): ?>

                            <div
                                class="
                                    presidency-card__faculty
                                "
                            >
                                <?= View::escape(
                                    $presidentFaculty
                                ) ?>
                            </div>

                        <?php endif; ?>


                        <?php if (
                            $presidentBiography !== ''
                        ): ?>

                            <div
                                class="
                                    institution-rich-text
                                "
                            >

                                <?= nl2br(
                                    View::escape(
                                        $presidentBiography
                                    )
                                ) ?>

                            </div>

                        <?php endif; ?>


                        <?php if (
                            $presidentEmail !== ''
                            || $presidentPhone !== ''
                        ): ?>

                            <div
                                class="
                                    presidency-contact
                                "
                            >

                                <?php if (
                                    $presidentEmail !== ''
                                ): ?>

                                    <a
                                        href="mailto:<?= View::escape(
                                            $presidentEmail
                                        ) ?>"
                                    >
                                        <?= View::escape(
                                            $presidentEmail
                                        ) ?>
                                    </a>

                                <?php endif; ?>


                                <?php if (
                                    $presidentPhone !== ''
                                    && $presidentPhoneHref !== ''
                                ): ?>

                                    <a
                                        href="tel:<?= View::escape(
                                            $presidentPhoneHref
                                        ) ?>"
                                    >
                                        <?= View::escape(
                                            $presidentPhone
                                        ) ?>
                                    </a>

                                <?php endif; ?>

                            </div>

                        <?php endif; ?>

                    </div>

                </article>

            </section>

        <?php else: ?>

            <div
                class="
                    institution-empty
                "
            >

                <strong>
                    اطلاعات ریاست ثبت نشده است.
                </strong>


                <p>
                    این اطلاعات از بخش اعضای موسسه مدیریت می‌شود.
                </p>

            </div>

        <?php endif; ?>


        <!-- =========================================================
             MANAGEMENT PEOPLE
        ========================================================== -->

        <?php if (
            $hasManagementPeople
        ): ?>

            <section
                class="
                    institution-section
                    presidency-people-section
                "
            >

                <div
                    class="
                        institution-section__heading
                    "
                >

                    <div>

                        <span>
                            مدیران و مسئولان
                        </span>


                        <h2>
                            ساختار مدیریتی موسسه
                        </h2>

                    </div>

                </div>


                <div
                    class="
                        presidency-people-grid
                    "
                >

                    <?php foreach (
                        $managementPeople as $person
                    ): ?>

                        <?php
                        $personName =
                            $getPersonName(
                                $person
                            );


                        $personInitial =
                            mb_substr(
                                $personName,
                                0,
                                1,
                                'UTF-8'
                            );


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


                        $biography =
                            trim(
                                (string) (
                                    $person['biography']
                                    ?? ''
                                )
                            );


                        $email =
                            trim(
                                (string) (
                                    $person['email']
                                    ?? ''
                                )
                            );


                        $phone =
                            trim(
                                (string) (
                                    $person['phone']
                                    ?? ''
                                )
                            );


                        $phoneHref =
                            $getPhoneHref(
                                $phone
                            );


                        $sortOrder =
                            (int) (
                                $person['sort_order']
                                ?? 0
                            );
                        ?>


                        <article
                            class="
                                presidency-card
                                presidency-card--manager
                            "
                            data-sort-order="<?= View::escape(
                                (string) $sortOrder
                            ) ?>"
                        >

                            <!-- =====================================
                                 MANAGER IMAGE
                            ====================================== -->

                            <div
                                class="
                                    presidency-card__media
                                "
                            >

                                <?php if (
                                    !empty(
                                        $person['image']
                                    )
                                ): ?>

                                    <img
                                        src="<?= View::escape(
                                            (string) $person['image']
                                        ) ?>"
                                        alt="<?= View::escape(
                                            $personName
                                        ) ?>"
                                        loading="lazy"
                                    >

                                <?php else: ?>

                                    <div
                                        class="
                                            presidency-card__placeholder
                                        "
                                        aria-hidden="true"
                                    >
                                        <?= View::escape(
                                            $personInitial
                                        ) ?>
                                    </div>

                                <?php endif; ?>

                            </div>


                            <!-- =====================================
                                 MANAGER INFORMATION
                            ====================================== -->

                            <div
                                class="
                                    presidency-card__body
                                "
                            >

                                <?php if (
                                    $position !== ''
                                ): ?>

                                    <span
                                        class="
                                            presidency-card__eyebrow
                                        "
                                    >
                                        <?= View::escape(
                                            $position
                                        ) ?>
                                    </span>

                                <?php endif; ?>


                                <h2>
                                    <?= View::escape(
                                        $personName
                                    ) ?>
                                </h2>


                                <?php if (
                                    $facultyName !== ''
                                ): ?>

                                    <div
                                        class="
                                            presidency-card__faculty
                                        "
                                    >
                                        <?= View::escape(
                                            $facultyName
                                        ) ?>
                                    </div>

                                <?php endif; ?>


                                <?php if (
                                    $biography !== ''
                                ): ?>

                                    <div
                                        class="
                                            institution-rich-text
                                            presidency-card__biography
                                        "
                                    >

                                        <?= nl2br(
                                            View::escape(
                                                $biography
                                            )
                                        ) ?>

                                    </div>

                                <?php endif; ?>


                                <?php if (
                                    $email !== ''
                                    || $phone !== ''
                                ): ?>

                                    <div
                                        class="
                                            presidency-contact
                                        "
                                    >

                                        <?php if (
                                            $email !== ''
                                        ): ?>

                                            <a
                                                href="mailto:<?= View::escape(
                                                    $email
                                                ) ?>"
                                            >
                                                <?= View::escape(
                                                    $email
                                                ) ?>
                                            </a>

                                        <?php endif; ?>


                                        <?php if (
                                            $phone !== ''
                                            && $phoneHref !== ''
                                        ): ?>

                                            <a
                                                href="tel:<?= View::escape(
                                                    $phoneHref
                                                ) ?>"
                                            >
                                                <?= View::escape(
                                                    $phone
                                                ) ?>
                                            </a>

                                        <?php endif; ?>

                                    </div>

                                <?php endif; ?>

                            </div>

                        </article>

                    <?php endforeach; ?>

                </div>

            </section>

        <?php endif; ?>


        <!-- =========================================================
             PRESIDENCY OFFICE
        ========================================================== -->

        <section
            class="
                institution-section
            "
        >

            <div
                class="
                    institution-section__heading
                "
            >

                <div>

                    <span>
                        دفتر ریاست
                    </span>


                    <h2>
                        ارتباط با دفتر ریاست
                    </h2>

                </div>

            </div>


            <div
                class="
                    institution-action-grid
                "
            >

                <a
                    href="<?= View::url(
                        '/contact'
                    ) ?>"
                    class="
                        institution-action-card
                    "
                >

                    <strong>
                        تماس با موسسه
                    </strong>


                    <span>
                        مشاهده اطلاعات تماس رسمی موسسه
                    </span>

                </a>


                <?php if (
                    $officeEmail !== ''
                ): ?>

                    <a
                        href="mailto:<?= View::escape(
                            $officeEmail
                        ) ?>"
                        class="
                            institution-action-card
                        "
                    >

                        <strong>
                            پست الکترونیکی
                        </strong>


                        <span>
                            <?= View::escape(
                                $officeEmail
                            ) ?>
                        </span>

                    </a>

                <?php else: ?>

                    <div
                        class="
                            institution-action-card
                        "
                    >

                        <strong>
                            پست الکترونیکی
                        </strong>


                        <span>
                            اطلاعات ایمیل ثبت نشده است.
                        </span>

                    </div>

                <?php endif; ?>

            </div>

        </section>

    </div>

</section>
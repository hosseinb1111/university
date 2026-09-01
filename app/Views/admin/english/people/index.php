<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


/*
|--------------------------------------------------------------------------
| Normalize data
|--------------------------------------------------------------------------
*/

$peopleData =
    is_array($people ?? null)
        ? $people
        : [];

$items =
    is_array(
        $peopleData['items']
        ?? null
    )
        ? $peopleData['items']
        : [];

$total =
    (int) (
        $peopleData['total']
        ?? count($items)
    );

$page =
    max(
        1,
        (int) (
            $peopleData['page']
            ?? 1
        )
    );

$totalPages =
    max(
        1,
        (int) (
            $peopleData['totalPages']
            ?? 1
        )
    );

$success =
    is_string($success ?? null)
        ? $success
        : null;

$error =
    is_string($error ?? null)
        ? $error
        : null;

?>

<div class="admin-page">

    <div class="english-admin-crud">


        <!-- =========================================================
             HEADER
        ========================================================== -->

        <header class="english-admin-crud__header">

            <div>

                <a
                    href="<?= View::url(
                        '/admin/english'
                    ) ?>"
                    class="english-admin-crud__back"
                >
                    ←
                    بازگشت به مدیریت انگلیسی
                </a>


                <span class="english-admin-crud__eyebrow">
                    ENGLISH WEBSITE
                </span>


                <h1>
                    افراد انگلیسی
                </h1>


                <p>
                    اعضای هیئت علمی، مدیران و سایر افراد
                    قابل نمایش در نسخه انگلیسی سایت را مدیریت کنید.
                </p>

            </div>


            <div class="english-admin-crud__header-actions">

                <a
                    href="<?= View::url(
                        '/admin/english/people/create'
                    ) ?>"
                    class="english-admin-crud__primary"
                >
                    + ایجاد فرد
                </a>


                <a
                    href="<?= View::url(
                        '/english'
                    ) ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="english-admin-crud__secondary"
                >
                    مشاهده سایت ↗
                </a>

            </div>

        </header>


        <!-- =========================================================
             MESSAGES
        ========================================================== -->

        <?php if (
            $success !== null
            && trim($success) !== ''
        ): ?>

            <div
                class="
                    english-admin-crud__message
                    english-admin-crud__message--success
                "
                role="status"
            >

                <span aria-hidden="true">
                    ✓
                </span>

                <?= View::escape(
                    $success
                ) ?>

            </div>

        <?php endif; ?>


        <?php if (
            $error !== null
            && trim($error) !== ''
        ): ?>

            <div
                class="
                    english-admin-crud__message
                    english-admin-crud__message--error
                "
                role="alert"
            >

                <span aria-hidden="true">
                    !
                </span>

                <?= View::escape(
                    $error
                ) ?>

            </div>

        <?php endif; ?>


        <!-- =========================================================
             LIST PANEL
        ========================================================== -->

        <section class="english-admin-crud__panel">

            <div class="english-admin-crud__panel-header">

                <div>

                    <span>
                        PEOPLE
                    </span>

                    <h2>
                        <?= $total ?>
                        نفر
                    </h2>

                </div>

            </div>


            <?php if (
                $items === []
            ): ?>

                <div class="english-admin-crud__empty">

                    <div
                        class="english-admin-crud__empty-icon"
                        aria-hidden="true"
                    >
                        👤
                    </div>


                    <h2>
                        هنوز فردی ثبت نشده است.
                    </h2>


                    <p>
                        اولین فرد نسخه انگلیسی سایت را ایجاد کنید.
                    </p>


                    <a
                        href="<?= View::url(
                            '/admin/english/people/create'
                        ) ?>"
                        class="english-admin-crud__primary"
                    >
                        ایجاد اولین فرد
                    </a>

                </div>

            <?php else: ?>

                <div class="english-admin-people-list">

                    <?php foreach (
                        $items as $index => $person
                    ): ?>

                        <?php

                        if (
                            !is_array($person)
                        ) {
                            continue;
                        }

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

                        if (
                            $fullName === ''
                        ) {
                            $fullName =
                                'بدون نام';
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

                        $email =
                            trim(
                                (string) (
                                    $person['email']
                                    ?? ''
                                )
                            );

                        $image =
                            trim(
                                (string) (
                                    $person['image']
                                    ?? ''
                                )
                            );

                        $sortOrder =
                            (int) (
                                $person['sort_order']
                                ?? 0
                            );

                        $isActive =
                            (int) (
                                $person['is_active']
                                ?? 0
                            ) === 1;

                        $initial =
                            mb_strtoupper(
                                mb_substr(
                                    $fullName,
                                    0,
                                    1,
                                    'UTF-8'
                                ),
                                'UTF-8'
                            );

                        ?>


                        <article class="english-admin-person-row">


                            <!-- =================================================
                                 Number
                            ================================================== -->

                            <div class="english-admin-person-row__number">

                                <?= str_pad(
                                    (string) (
                                        $index + 1
                                    ),
                                    2,
                                    '0',
                                    STR_PAD_LEFT
                                ) ?>

                            </div>


                            <!-- =================================================
                                 Avatar
                            ================================================== -->

                            <div class="english-admin-person-row__avatar">

                                <?php if (
                                    $image !== ''
                                ): ?>

                                    <img
                                        src="<?= View::escape(
                                            $image
                                        ) ?>"
                                        alt="<?= View::escape(
                                            $fullName
                                        ) ?>"
                                        loading="lazy"
                                    >

                                <?php else: ?>

                                    <span aria-hidden="true">
                                        <?= View::escape(
                                            $initial
                                        ) ?>
                                    </span>

                                <?php endif; ?>

                            </div>


                            <!-- =================================================
                                 Content
                            ================================================== -->

                            <div class="english-admin-person-row__content">

                                <div
                                    class="
                                        english-admin-person-row__status
                                    "
                                >

                                    <span
                                        class="
                                            english-admin-status
                                            <?= $isActive
                                                ? 'english-admin-status--active'
                                                : 'english-admin-status--inactive'
                                            ?>
                                        "
                                    >
                                        <?= $isActive
                                            ? 'فعال'
                                            : 'غیرفعال'
                                        ?>
                                    </span>


                                    <span>
                                        ترتیب:
                                        <?= $sortOrder ?>
                                    </span>

                                </div>


                                <h3>
                                    <?= View::escape(
                                        $fullName
                                    ) ?>
                                </h3>


                                <?php if (
                                    $position !== ''
                                ): ?>

                                    <span
                                        class="
                                            english-admin-person-row__position
                                        "
                                    >
                                        <?= View::escape(
                                            $position
                                        ) ?>
                                    </span>

                                <?php endif; ?>


                                <?php if (
                                    $facultyName !== ''
                                ): ?>

                                    <span
                                        class="
                                            english-admin-person-row__faculty
                                        "
                                    >
                                        دانشکده:
                                        <?= View::escape(
                                            $facultyName
                                        ) ?>
                                    </span>

                                <?php endif; ?>


                                <?php if (
                                    $email !== ''
                                ): ?>

                                    <span
                                        class="
                                            english-admin-person-row__email
                                        "
                                        dir="ltr"
                                    >
                                        <?= View::escape(
                                            $email
                                        ) ?>
                                    </span>

                                <?php endif; ?>

                            </div>


                            <!-- =================================================
                                 Actions
                            ================================================== -->

                            <div
                                class="
                                    english-admin-person-row__actions
                                "
                            >

                                <a
                                    href="<?= View::route(
                                        'admin.english.people.edit',
                                        [
                                            'id' =>
                                                $id,
                                        ]
                                    ) ?>"
                                    class="english-admin-crud__secondary"
                                >
                                    ویرایش
                                </a>


                                <form
                                    method="POST"
                                    action="<?= View::route(
                                        'admin.english.people.delete',
                                        [
                                            'id' =>
                                                $id,
                                        ]
                                    ) ?>"
                                    onsubmit="return confirm('آیا از حذف این فرد مطمئن هستید؟');"
                                >

                                    <?= Csrf::field() ?>


                                    <button
                                        type="submit"
                                        class="english-admin-crud__danger"
                                    >
                                        حذف
                                    </button>

                                </form>

                            </div>

                        </article>

                    <?php endforeach; ?>

                </div>


                <!-- =========================================================
                     PAGINATION
                ========================================================== -->

                <?php if (
                    $totalPages > 1
                ): ?>

                    <nav
                        class="english-admin-pagination"
                        aria-label="صفحه‌بندی افراد"
                    >

                        <?php if (
                            $page > 1
                        ): ?>

                            <a
                                href="<?= View::url(
                                    '/admin/english/people?page='
                                    . (
                                        $page - 1
                                    )
                                ) ?>"
                            >
                                ← قبلی
                            </a>

                        <?php endif; ?>


                        <span>
                            صفحه
                            <?= $page ?>
                            از
                            <?= $totalPages ?>
                        </span>


                        <?php if (
                            $page < $totalPages
                        ): ?>

                            <a
                                href="<?= View::url(
                                    '/admin/english/people?page='
                                    . (
                                        $page + 1
                                    )
                                ) ?>"
                            >
                                بعدی →
                            </a>

                        <?php endif; ?>

                    </nav>

                <?php endif; ?>

            <?php endif; ?>

        </section>

    </div>

</div>
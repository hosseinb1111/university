<?php

declare(strict_types=1);

use App\Core\Csrf;
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

$items =
    is_array($programs['items'] ?? null)
        ? $programs['items']
        : [];

$total =
    (int) (
        $programs['total']
        ?? count($items)
    );

$page =
    max(
        1,
        (int) (
            $programs['page']
            ?? 1
        )
    );

$totalPages =
    max(
        1,
        (int) (
            $programs['totalPages']
            ?? 1
        )
    );

$success =
    is_string($success ?? null)
        ? trim($success)
        : null;

$error =
    is_string($error ?? null)
        ? trim($error)
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
                    ENGLISH ACADEMICS
                </span>


                <h1>
                    رشته‌ها و برنامه‌های انگلیسی
                </h1>


                <p>
                    برنامه‌های آموزشی نسخه انگلیسی سایت را
                    ایجاد، ویرایش، مرتب و مدیریت کنید.
                </p>

            </div>


            <div class="english-admin-crud__header-actions">

                <a
                    href="<?= View::url(
                        '/admin/english/programs/create'
                    ) ?>"
                    class="english-admin-crud__primary"
                >
                    + ایجاد رشته
                </a>


                <a
                    href="<?= View::url(
                        '/english/programs'
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
            && $success !== ''
        ): ?>

            <div
                class="
                    english-admin-crud__message
                    english-admin-crud__message--success
                "
                role="status"
            >

                <strong>
                    ✓
                </strong>

                <span>
                    <?= View::escape(
                        $success
                    ) ?>
                </span>

            </div>

        <?php endif; ?>


        <?php if (
            $error !== null
            && $error !== ''
        ): ?>

            <div
                class="
                    english-admin-crud__message
                    english-admin-crud__message--error
                "
                role="alert"
            >

                <strong>
                    !
                </strong>

                <span>
                    <?= View::escape(
                        $error
                    ) ?>
                </span>

            </div>

        <?php endif; ?>


        <!-- =========================================================
             PROGRAM PANEL
        ========================================================== -->

        <section class="english-admin-crud__panel">


            <div class="english-admin-crud__panel-header">

                <div>

                    <span>
                        PROGRAM CATALOG
                    </span>

                    <h2>
                        <?= $total ?>
                        رشته
                    </h2>

                </div>


                <div>

                    <a
                        href="<?= View::url(
                            '/admin/english/programs/create'
                        ) ?>"
                        class="english-admin-crud__secondary"
                    >
                        + افزودن رشته
                    </a>

                </div>

            </div>


            <!-- =====================================================
                 EMPTY STATE
            ====================================================== -->

            <?php if (
                $items === []
            ): ?>

                <div class="english-admin-crud__empty">

                    <div
                        class="english-admin-crud__empty-icon"
                        aria-hidden="true"
                    >
                        📚
                    </div>


                    <h2>
                        هنوز رشته‌ای ایجاد نشده است.
                    </h2>


                    <p>
                        اولین برنامه آموزشی نسخه انگلیسی را
                        ایجاد کنید.
                    </p>


                    <a
                        href="<?= View::url(
                            '/admin/english/programs/create'
                        ) ?>"
                        class="english-admin-crud__primary"
                    >
                        ایجاد اولین رشته
                    </a>

                </div>


            <?php else: ?>


                <!-- =================================================
                     PROGRAM LIST
                ================================================== -->

                <div class="english-admin-program-list">

                    <?php foreach (
                        $items
                        as $index => $program
                    ): ?>

                        <?php

                        if (
                            !is_array(
                                $program
                            )
                        ) {
                            continue;
                        }


                        $id =
                            (int) (
                                $program['id']
                                ?? 0
                            );


                        if (
                            $id <= 0
                        ) {
                            continue;
                        }


                        $name =
                            trim(
                                (string) (
                                    $program['name']
                                    ?? ''
                                )
                            );


                        $slug =
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


                        $duration =
                            trim(
                                (string) (
                                    $program['duration']
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


                        $sortOrder =
                            (int) (
                                $program['sort_order']
                                ?? 0
                            );


                        $isActive =
                            (int) (
                                $program['is_active']
                                ?? 0
                            ) === 1;


                        $description =
                            trim(
                                (string) (
                                    $program['description']
                                    ?? ''
                                )
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


                        <article
                            class="english-admin-program-row"
                        >


                            <!-- =================================================
                                 NUMBER
                            ================================================== -->

                            <div
                                class="english-admin-program-row__number"
                            >

                                <?= View::escape(
                                    $number
                                ) ?>

                            </div>


                            <!-- =================================================
                                 CONTENT
                            ================================================== -->

                            <div
                                class="english-admin-program-row__content"
                            >


                                <div
                                    class="
                                        english-admin-program-row__top
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
                                        $name !== ''
                                            ? $name
                                            : 'بدون نام'
                                    ) ?>
                                </h3>


                                <?php if (
                                    $degree !== ''
                                ): ?>

                                    <div
                                        class="
                                            english-admin-program-row__meta
                                        "
                                    >

                                        <span>
                                            مقطع
                                        </span>

                                        <strong>
                                            <?= View::escape(
                                                $degree
                                            ) ?>
                                        </strong>

                                    </div>

                                <?php endif; ?>


                                <?php if (
                                    $facultyName !== ''
                                ): ?>

                                    <div
                                        class="
                                            english-admin-program-row__meta
                                        "
                                    >

                                        <span>
                                            دانشکده
                                        </span>


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
                                                target="_blank"
                                                rel="noopener noreferrer"
                                            >
                                                <?= View::escape(
                                                    $facultyName
                                                ) ?>
                                            </a>

                                        <?php else: ?>

                                            <strong>
                                                <?= View::escape(
                                                    $facultyName
                                                ) ?>
                                            </strong>

                                        <?php endif; ?>

                                    </div>

                                <?php endif; ?>


                                <?php if (
                                    $field !== ''
                                ): ?>

                                    <div
                                        class="
                                            english-admin-program-row__meta
                                        "
                                    >

                                        <span>
                                            حوزه تحصیلی
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
                                            english-admin-program-row__meta
                                        "
                                    >

                                        <span>
                                            مدت تحصیل
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

                                    <p
                                        class="
                                            english-admin-program-row__description
                                        "
                                    >
                                        <?= View::escape(
                                            mb_strimwidth(
                                                $description,
                                                0,
                                                220,
                                                '...',
                                                'UTF-8'
                                            )
                                        ) ?>
                                    </p>

                                <?php endif; ?>


                                <?php if (
                                    $slug !== ''
                                ): ?>

                                    <div
                                        class="
                                            english-admin-program-row__slug
                                        "
                                    >

                                        <span>
                                            SLUG
                                        </span>

                                        <code dir="ltr">
                                            <?= View::escape(
                                                $slug
                                            ) ?>
                                        </code>

                                    </div>

                                <?php endif; ?>

                            </div>


                            <!-- =================================================
                                 ACTIONS
                            ================================================== -->

                            <div
                                class="
                                    english-admin-program-row__actions
                                "
                            >

                                <a
                                    href="<?= View::route(
                                        'admin.english.programs.edit',
                                        [
                                            'id' =>
                                                $id,
                                        ]
                                    ) ?>"
                                    class="english-admin-crud__secondary"
                                >
                                    ویرایش
                                </a>


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
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="english-admin-crud__secondary"
                                    >
                                        مشاهده
                                    </a>

                                <?php endif; ?>


                                <form
                                    method="POST"
                                    action="<?= View::route(
                                        'admin.english.programs.delete',
                                        [
                                            'id' =>
                                                $id,
                                        ]
                                    ) ?>"
                                    onsubmit="return confirm('آیا از حذف این رشته مطمئن هستید؟');"
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


                <!-- =================================================
                     PAGINATION
                ================================================== -->

                <?php if (
                    $totalPages > 1
                ): ?>

                    <nav
                        class="english-admin-pagination"
                        aria-label="صفحه‌بندی رشته‌ها"
                    >

                        <?php if (
                            $page > 1
                        ): ?>

                            <a
                                href="<?= View::url(
                                    '/admin/english/programs?page='
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
                                    '/admin/english/programs?page='
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
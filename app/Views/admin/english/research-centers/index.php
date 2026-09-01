<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


/*
|--------------------------------------------------------------------------
| Normalize data
|--------------------------------------------------------------------------
*/

$researchData =
    is_array($researchCenters ?? null)
        ? $researchCenters
        : [];

$items =
    is_array(
        $researchData['items']
        ?? null
    )
        ? $researchData['items']
        : [];

$total =
    (int) (
        $researchData['total']
        ?? count($items)
    );

$page =
    max(
        1,
        (int) (
            $researchData['page']
            ?? 1
        )
    );

$totalPages =
    max(
        1,
        (int) (
            $researchData['totalPages']
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
                    RESEARCH & INNOVATION
                </span>


                <h1>
                    مراکز پژوهشی انگلیسی
                </h1>


                <p>
                    مراکز پژوهشی نسخه انگلیسی سایت را ایجاد،
                    ویرایش، مرتب و حذف کنید.
                </p>

            </div>


            <div class="english-admin-crud__header-actions">

                <a
                    href="<?= View::url(
                        '/admin/english/research-centers/create'
                    ) ?>"
                    class="english-admin-crud__primary"
                >
                    + ایجاد مرکز پژوهشی
                </a>


                <a
                    href="<?= View::url(
                        '/english/research'
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
                        RESEARCH CENTERS
                    </span>

                    <h2>
                        <?= $total ?>
                        مرکز پژوهشی
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
                        🔬
                    </div>


                    <h2>
                        هنوز مرکز پژوهشی ثبت نشده است.
                    </h2>


                    <p>
                        اولین مرکز پژوهشی نسخه انگلیسی سایت را ایجاد کنید.
                    </p>


                    <a
                        href="<?= View::url(
                            '/admin/english/research-centers/create'
                        ) ?>"
                        class="english-admin-crud__primary"
                    >
                        ایجاد اولین مرکز پژوهشی
                    </a>

                </div>

            <?php else: ?>

                <div class="english-admin-research-list">

                    <?php foreach (
                        $items as $index => $center
                    ): ?>

                        <?php

                        if (
                            !is_array($center)
                        ) {
                            continue;
                        }

                        $id =
                            (int) (
                                $center['id']
                                ?? 0
                            );

                        $name =
                            trim(
                                (string) (
                                    $center['name']
                                    ?? ''
                                )
                            );

                        $shortName =
                            trim(
                                (string) (
                                    $center['short_name']
                                    ?? ''
                                )
                            );

                        $slug =
                            trim(
                                (string) (
                                    $center['slug']
                                    ?? ''
                                )
                            );

                        $description =
                            trim(
                                (string) (
                                    $center['description']
                                    ?? ''
                                )
                            );

                        $directorFirstName =
                            trim(
                                (string) (
                                    $center['director_first_name']
                                    ?? ''
                                )
                            );

                        $directorLastName =
                            trim(
                                (string) (
                                    $center['director_last_name']
                                    ?? ''
                                )
                            );

                        $directorName =
                            trim(
                                $directorFirstName
                                . ' '
                                . $directorLastName
                            );

                        $email =
                            trim(
                                (string) (
                                    $center['email']
                                    ?? ''
                                )
                            );

                        $image =
                            trim(
                                (string) (
                                    $center['image']
                                    ?? ''
                                )
                            );

                        $sortOrder =
                            (int) (
                                $center['sort_order']
                                ?? 0
                            );

                        $isActive =
                            (int) (
                                $center['is_active']
                                ?? 0
                            ) === 1;

                        $initial =
                            $name !== ''
                                ? mb_strtoupper(
                                    mb_substr(
                                        $name,
                                        0,
                                        1,
                                        'UTF-8'
                                    ),
                                    'UTF-8'
                                )
                                : 'R';

                        ?>


                        <article
                            class="english-admin-research-row"
                        >


                            <!-- =================================================
                                 Number
                            ================================================== -->

                            <div
                                class="
                                    english-admin-research-row__number
                                "
                            >

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
                                 Image
                            ================================================== -->

                            <div
                                class="
                                    english-admin-research-row__image
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

                            <div
                                class="
                                    english-admin-research-row__content
                                "
                            >

                                <div
                                    class="
                                        english-admin-research-row__status
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
                                    $shortName !== ''
                                ): ?>

                                    <span
                                        class="
                                            english-admin-research-row__short
                                        "
                                    >
                                        <?= View::escape(
                                            $shortName
                                        ) ?>
                                    </span>

                                <?php endif; ?>


                                <?php if (
                                    $directorName !== ''
                                ): ?>

                                    <span
                                        class="
                                            english-admin-research-row__director
                                        "
                                    >
                                        مدیر:
                                        <?= View::escape(
                                            $directorName
                                        ) ?>
                                    </span>

                                <?php endif; ?>


                                <?php if (
                                    $email !== ''
                                ): ?>

                                    <span
                                        class="
                                            english-admin-research-row__email
                                        "
                                        dir="ltr"
                                    >
                                        <?= View::escape(
                                            $email
                                        ) ?>
                                    </span>

                                <?php endif; ?>


                                <?php if (
                                    $description !== ''
                                ): ?>

                                    <p>
                                        <?= View::escape(
                                            mb_strimwidth(
                                                $description,
                                                0,
                                                180,
                                                '...',
                                                'UTF-8'
                                            )
                                        ) ?>
                                    </p>

                                <?php endif; ?>


                                <?php if (
                                    $slug !== ''
                                ): ?>

                                    <span
                                        class="
                                            english-admin-research-row__slug
                                        "
                                        dir="ltr"
                                    >
                                        /english/research/<?= View::escape(
                                            $slug
                                        ) ?>
                                    </span>

                                <?php endif; ?>

                            </div>


                            <!-- =================================================
                                 Actions
                            ================================================== -->

                            <div
                                class="
                                    english-admin-research-row__actions
                                "
                            >

                                <a
                                    href="<?= View::route(
                                        'admin.english.research-centers.edit',
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
                                        'admin.english.research-centers.delete',
                                        [
                                            'id' =>
                                                $id,
                                        ]
                                    ) ?>"
                                    onsubmit="return confirm('آیا از حذف این مرکز پژوهشی مطمئن هستید؟');"
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
                        aria-label="صفحه‌بندی مراکز پژوهشی"
                    >

                        <?php if (
                            $page > 1
                        ): ?>

                            <a
                                href="<?= View::url(
                                    '/admin/english/research-centers?page='
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
                                    '/admin/english/research-centers?page='
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
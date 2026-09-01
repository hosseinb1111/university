<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


$faculties =
    is_array($faculties ?? null)
        ? $faculties
        : [];

$items =
    is_array($faculties['items'] ?? null)
        ? $faculties['items']
        : [];

$total =
    (int) (
        $faculties['total']
        ?? count($items)
    );

$page =
    max(
        1,
        (int) (
            $faculties['page']
            ?? 1
        )
    );

$totalPages =
    max(
        1,
        (int) (
            $faculties['totalPages']
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
                    FACULTIES
                </span>


                <h1>
                    دانشکده‌های انگلیسی
                </h1>


                <p>
                    دانشکده‌های نسخه انگلیسی سایت را ایجاد،
                    ویرایش، مرتب و مدیریت کنید.
                </p>

            </div>


            <div class="english-admin-crud__header-actions">

                <a
                    href="<?= View::url(
                        '/admin/english/faculties/create'
                    ) ?>"
                    class="english-admin-crud__primary"
                >
                    + ایجاد دانشکده
                </a>


                <a
                    href="<?= View::url(
                        '/english/faculties'
                    ) ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="english-admin-crud__secondary"
                >
                    مشاهده سایت ↗
                </a>

            </div>

        </header>


        <?php if (
            $success !== null
        ): ?>

            <div
                class="
                    english-admin-crud__message
                    english-admin-crud__message--success
                "
            >
                ✓

                <?= View::escape(
                    $success
                ) ?>
            </div>

        <?php endif; ?>


        <?php if (
            $error !== null
        ): ?>

            <div
                class="
                    english-admin-crud__message
                    english-admin-crud__message--error
                "
            >
                !

                <?= View::escape(
                    $error
                ) ?>
            </div>

        <?php endif; ?>


        <section class="english-admin-crud__panel">

            <div class="english-admin-crud__panel-header">

                <div>

                    <span>
                        FACULTIES
                    </span>

                    <h2>
                        <?= $total ?>
                        دانشکده
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
                        🎓
                    </div>


                    <h2>
                        هنوز دانشکده‌ای ایجاد نشده است.
                    </h2>


                    <p>
                        اولین دانشکده نسخه انگلیسی سایت را ایجاد کنید.
                    </p>


                    <a
                        href="<?= View::url(
                            '/admin/english/faculties/create'
                        ) ?>"
                        class="english-admin-crud__primary"
                    >
                        ایجاد اولین دانشکده
                    </a>

                </div>

            <?php else: ?>

                <div class="english-admin-slide-list">

                    <?php foreach (
                        $items
                        as $index => $faculty
                    ): ?>

                        <?php

                        $id =
                            (int) (
                                $faculty['id']
                                ?? 0
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

                        $slug =
                            trim(
                                (string) (
                                    $faculty['slug']
                                    ?? ''
                                )
                            );

                        $description =
                            trim(
                                (string) (
                                    $faculty['description']
                                    ?? ''
                                )
                            );

                        $image =
                            trim(
                                (string) (
                                    $faculty['image']
                                    ?? ''
                                )
                            );

                        $email =
                            trim(
                                (string) (
                                    $faculty['email']
                                    ?? ''
                                )
                            );

                        $phone =
                            trim(
                                (string) (
                                    $faculty['phone']
                                    ?? ''
                                )
                            );

                        $sortOrder =
                            (int) (
                                $faculty['sort_order']
                                ?? 0
                            );

                        $isActive =
                            (int) (
                                $faculty['is_active']
                                ?? 0
                            ) === 1;

                        ?>


                        <article class="english-admin-slide-row">


                            <div class="english-admin-slide-row__number">

                                <?= str_pad(
                                    (string) (
                                        $index + 1
                                    ),
                                    2,
                                    '0',
                                    STR_PAD_LEFT
                                ) ?>

                            </div>


                            <div class="english-admin-slide-row__image">

                                <?php if (
                                    $image !== ''
                                ): ?>

                                    <img
                                        src="<?= View::escape(
                                            $image
                                        ) ?>"
                                        alt=""
                                        loading="lazy"
                                    >

                                <?php else: ?>

                                    <span aria-hidden="true">
                                        FAC
                                    </span>

                                <?php endif; ?>

                            </div>


                            <div class="english-admin-slide-row__content">

                                <div class="english-admin-slide-row__status">

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

                                    <span class="english-admin-slide-row__subtitle">
                                        <?= View::escape(
                                            $shortName
                                        ) ?>
                                    </span>

                                <?php endif; ?>


                                <?php if (
                                    $slug !== ''
                                ): ?>

                                    <span class="english-admin-slide-row__subtitle">
                                        /
                                        <?= View::escape(
                                            $slug
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
                                    $email !== ''
                                    || $phone !== ''
                                ): ?>

                                    <p>

                                        <?php if (
                                            $email !== ''
                                        ): ?>

                                            <?= View::escape(
                                                $email
                                            ) ?>

                                        <?php endif; ?>


                                        <?php if (
                                            $email !== ''
                                            && $phone !== ''
                                        ): ?>

                                            <span>
                                                ·
                                            </span>

                                        <?php endif; ?>


                                        <?php if (
                                            $phone !== ''
                                        ): ?>

                                            <?= View::escape(
                                                $phone
                                            ) ?>

                                        <?php endif; ?>

                                    </p>

                                <?php endif; ?>

                            </div>


                            <div class="english-admin-slide-row__actions">

                                <a
                                    href="<?= View::route(
                                        'admin.english.faculties.edit',
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
                                        'admin.english.faculties.delete',
                                        [
                                            'id' =>
                                                $id,
                                        ]
                                    ) ?>"
                                    onsubmit="return confirm('آیا از حذف این دانشکده مطمئن هستید؟');"
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


                <?php if (
                    $totalPages > 1
                ): ?>

                    <nav class="english-admin-pagination">

                        <?php if (
                            $page > 1
                        ): ?>

                            <a
                                href="<?= View::url(
                                    '/admin/english/faculties?page='
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
                                    '/admin/english/faculties?page='
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
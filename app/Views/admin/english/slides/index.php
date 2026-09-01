<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


$slides =
    is_array($slides ?? null)
        ? $slides
        : [];

$items =
    is_array($slides['items'] ?? null)
        ? $slides['items']
        : [];

$total =
    (int) (
        $slides['total']
        ?? count($items)
    );

$page =
    max(
        1,
        (int) (
            $slides['page']
            ?? 1
        )
    );

$totalPages =
    max(
        1,
        (int) (
            $slides['totalPages']
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
                    HOMEPAGE
                </span>


                <h1>
                    اسلایدهای صفحه اصلی انگلیسی
                </h1>


                <p>
                    اسلایدهای نسخه انگلیسی را ایجاد، ویرایش،
                    مرتب و حذف کنید.
                </p>

            </div>


            <div class="english-admin-crud__header-actions">

                <a
                    href="<?= View::url(
                        '/admin/english/slides/create'
                    ) ?>"
                    class="english-admin-crud__primary"
                >
                    + ایجاد اسلاید
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
                        SLIDES
                    </span>

                    <h2>
                        <?= $total ?>
                        <?= $total === 1
                            ? 'اسلاید'
                            : 'اسلاید'
                        ?>
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
                        🖼️
                    </div>

                    <h2>
                        هنوز اسلایدی ایجاد نشده است.
                    </h2>

                    <p>
                        اولین اسلاید صفحه اصلی انگلیسی را ایجاد کنید.
                    </p>

                    <a
                        href="<?= View::url(
                            '/admin/english/slides/create'
                        ) ?>"
                        class="english-admin-crud__primary"
                    >
                        ایجاد اولین اسلاید
                    </a>

                </div>

            <?php else: ?>

                <div class="english-admin-slide-list">

                    <?php foreach (
                        $items
                        as $index => $slide
                    ): ?>

                        <?php

                        $id =
                            (int) (
                                $slide['id']
                                ?? 0
                            );

                        $title =
                            trim(
                                (string) (
                                    $slide['title']
                                    ?? ''
                                )
                            );

                        $subtitle =
                            trim(
                                (string) (
                                    $slide['subtitle']
                                    ?? ''
                                )
                            );

                        $description =
                            trim(
                                (string) (
                                    $slide['description']
                                    ?? ''
                                )
                            );

                        $image =
                            trim(
                                (string) (
                                    $slide['image']
                                    ?? ''
                                )
                            );

                        $sortOrder =
                            (int) (
                                $slide['sort_order']
                                ?? 0
                            );

                        $isActive =
                            (int) (
                                $slide['is_active']
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
                                        IMG
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
                                        $title !== ''
                                            ? $title
                                            : 'بدون عنوان'
                                    ) ?>
                                </h3>


                                <?php if (
                                    $subtitle !== ''
                                ): ?>

                                    <span class="english-admin-slide-row__subtitle">
                                        <?= View::escape(
                                            $subtitle
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

                            </div>


                            <div class="english-admin-slide-row__actions">

                                <a
                                    href="<?= View::route(
                                        'admin.english.slides.edit',
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
                                        'admin.english.slides.delete',
                                        [
                                            'id' =>
                                                $id,
                                        ]
                                    ) ?>"
                                    onsubmit="return confirm('آیا از حذف این اسلاید مطمئن هستید؟');"
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
                                    '/admin/english/slides?page='
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
                                    '/admin/english/slides?page='
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
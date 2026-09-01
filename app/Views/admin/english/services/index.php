<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


$services =
    is_array($services ?? null)
        ? $services
        : [];

$items =
    is_array($services['items'] ?? null)
        ? $services['items']
        : [];

$total =
    (int) (
        $services['total']
        ?? count($items)
    );

$page =
    max(
        1,
        (int) (
            $services['page']
            ?? 1
        )
    );

$totalPages =
    max(
        1,
        (int) (
            $services['totalPages']
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
                    خدمات و پرتال‌های انگلیسی
                </h1>

                <p>
                    کارت‌های خدمات صفحه اصلی انگلیسی را مدیریت کنید.
                </p>

            </div>


            <div class="english-admin-crud__header-actions">

                <a
                    href="<?= View::url(
                        '/admin/english/services/create'
                    ) ?>"
                    class="english-admin-crud__primary"
                >
                    + ایجاد خدمت
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
                        SERVICES
                    </span>

                    <h2>
                        <?= $total ?>
                        خدمت
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
                        🔗
                    </div>

                    <h2>
                        هنوز خدمتی ایجاد نشده است.
                    </h2>

                    <p>
                        اولین سرویس صفحه اصلی انگلیسی را ایجاد کنید.
                    </p>

                    <a
                        href="<?= View::url(
                            '/admin/english/services/create'
                        ) ?>"
                        class="english-admin-crud__primary"
                    >
                        ایجاد اولین خدمت
                    </a>

                </div>

            <?php else: ?>

                <div class="english-admin-service-list">

                    <?php foreach (
                        $items
                        as $index => $service
                    ): ?>

                        <?php

                        $id =
                            (int) (
                                $service['id']
                                ?? 0
                            );

                        $title =
                            trim(
                                (string) (
                                    $service['title']
                                    ?? ''
                                )
                            );

                        $url =
                            trim(
                                (string) (
                                    $service['url']
                                    ?? ''
                                )
                            );

                        $image =
                            trim(
                                (string) (
                                    $service['image']
                                    ?? ''
                                )
                            );

                        $sortOrder =
                            (int) (
                                $service['sort_order']
                                ?? 0
                            );

                        $isActive =
                            (int) (
                                $service['is_active']
                                ?? 0
                            ) === 1;

                        ?>

                        <article class="english-admin-service-row">

                            <div class="english-admin-service-row__number">

                                <?= str_pad(
                                    (string) (
                                        $index + 1
                                    ),
                                    2,
                                    '0',
                                    STR_PAD_LEFT
                                ) ?>

                            </div>


                            <div class="english-admin-service-row__image">

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

                                    <span>
                                        →
                                    </span>

                                <?php endif; ?>

                            </div>


                            <div class="english-admin-service-row__content">

                                <div class="english-admin-service-row__status">

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
                                    $url !== ''
                                ): ?>

                                    <a
                                        href="<?= View::escape(
                                            $url
                                        ) ?>"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        dir="ltr"
                                        class="english-admin-service-row__url"
                                    >
                                        <?= View::escape(
                                            $url
                                        ) ?>
                                    </a>

                                <?php endif; ?>

                            </div>


                            <div class="english-admin-service-row__actions">

                                <a
                                    href="<?= View::route(
                                        'admin.english.services.edit',
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
                                        'admin.english.services.delete',
                                        [
                                            'id' =>
                                                $id,
                                        ]
                                    ) ?>"
                                    onsubmit="return confirm('آیا از حذف این خدمت مطمئن هستید؟');"
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
                                    '/admin/english/services?page='
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
                                    '/admin/english/services?page='
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
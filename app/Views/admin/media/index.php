<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\Storage;
use App\Core\View;

$items =
    is_array($media['items'] ?? null)
        ? $media['items']
        : [];

$currentPage =
    max(
        1,
        (int) (
            $media['page']
            ?? 1
        )
    );

$totalPages =
    max(
        1,
        (int) (
            $media['totalPages']
            ?? 1
        )
    );

$total =
    (int) (
        $media['total']
        ?? 0
    );
?>

<div class="admin-page">

    <div class="admin-page__header">

        <div>

            <span class="admin-page__eyebrow">
                فایل‌ها
            </span>

            <h1>
                کتابخانه رسانه
            </h1>

            <p>
                تصاویر و فایل‌های ذخیره‌شده سایت.
            </p>

        </div>


        <a
            href="<?= View::url(
                '/admin/media/create'
            ) ?>"
            class="button button--primary"
        >
            آپلود فایل
        </a>

    </div>


    <?php if (
        !empty($success)
    ): ?>

        <div
            class="admin-alert admin-alert--success"
            role="status"
        >
            <?= View::escape(
                (string) $success
            ) ?>
        </div>

    <?php endif; ?>


    <?php if (
        !empty($error)
    ): ?>

        <div
            class="admin-alert admin-alert--error"
            role="alert"
        >
            <?= View::escape(
                (string) $error
            ) ?>
        </div>

    <?php endif; ?>


    <div class="admin-panel">

        <div class="admin-panel__header">

            <strong>
                <?= number_format(
                    $total
                ) ?>

                فایل
            </strong>

        </div>


        <?php if (
            $items === []
        ): ?>

            <div class="admin-empty">

                <div class="admin-empty__icon">
                    🖼
                </div>

                <h2>
                    کتابخانه رسانه خالی است.
                </h2>

                <p>
                    اولین فایل خود را آپلود کنید.
                </p>

                <a
                    href="<?= View::url(
                        '/admin/media/create'
                    ) ?>"
                    class="button button--primary"
                >
                    آپلود فایل
                </a>

            </div>

        <?php else: ?>

            <div class="media-grid">

                <?php foreach (
                    $items
                    as $item
                ): ?>

                    <?php
                    $id =
                        (int) (
                            $item['id']
                            ?? 0
                        );

                    $mime =
                        (string) (
                            $item['mime_type']
                            ?? ''
                        );

                    $path =
                        (string) (
                            $item['file_path']
                            ?? ''
                        );

                    $url =
                        Storage::publicUrl(
                            $path
                        );

                    $isImage =
                        str_starts_with(
                            $mime,
                            'image/'
                        );
                    ?>

                    <article
                        class="media-card"
                    >

                        <div class="media-card__preview">

                            <?php if (
                                $isImage
                            ): ?>

                                <img
                                    src="<?= View::escape(
                                        $url
                                    ) ?>"
                                    alt="<?= View::escape(
                                        $item['alt_text']
                                        ?? ''
                                    ) ?>"
                                    loading="lazy"
                                >

                            <?php else: ?>

                                <div
                                    class="media-card__file"
                                    aria-hidden="true"
                                >
                                    📄
                                </div>

                            <?php endif; ?>

                        </div>


                        <div class="media-card__body">

                            <strong>
                                <?= View::escape(
                                    $item['original_name']
                                    ?? 'file'
                                ) ?>
                            </strong>


                            <?php if (
                                $isImage
                                && !empty(
                                    $item['width']
                                )
                                && !empty(
                                    $item['height']
                                )
                            ): ?>

                                <span>
                                    <?= (int) $item['width'] ?>
                                    ×
                                    <?= (int) $item['height'] ?>
                                </span>

                            <?php elseif (
                                !empty(
                                    $item['mime_type']
                                )
                            ): ?>

                                <span>
                                    <?= View::escape(
                                        $item['mime_type']
                                    ) ?>
                                </span>

                            <?php endif; ?>


                            <div class="media-card__actions">

                                <a
                                    href="<?= View::escape(
                                        $url
                                    ) ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="button button--secondary button--small"
                                >
                                    مشاهده
                                </a>


                                <form
                                    method="POST"
                                    action="<?= View::url(
                                        '/admin/media/'
                                        . $id
                                        . '/delete'
                                    ) ?>"
                                    onsubmit="return confirm('آیا از حذف این فایل مطمئن هستید؟');"
                                >

                                    <?= Csrf::field() ?>

                                    <button
                                        type="submit"
                                        class="button button--danger button--small"
                                    >
                                        حذف
                                    </button>

                                </form>

                            </div>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>


            <?php if (
                $totalPages > 1
            ): ?>

                <nav
                    class="admin-pagination"
                    aria-label="صفحه‌بندی رسانه"
                >

                    <?php if (
                        $currentPage > 1
                    ): ?>

                        <a
                            href="?page=<?= $currentPage - 1 ?>"
                        >
                            قبلی
                        </a>

                    <?php endif; ?>


                    <span>
                        صفحه
                        <?= $currentPage ?>
                        از
                        <?= $totalPages ?>
                    </span>


                    <?php if (
                        $currentPage < $totalPages
                    ): ?>

                        <a
                            href="?page=<?= $currentPage + 1 ?>"
                        >
                            بعدی
                        </a>

                    <?php endif; ?>

                </nav>

            <?php endif; ?>

        <?php endif; ?>

    </div>

</div>
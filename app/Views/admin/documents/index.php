<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


/*
|--------------------------------------------------------------------------
| Data
|--------------------------------------------------------------------------
*/

$items =
    is_array(
        $documents['items']
        ?? null
    )
        ? $documents['items']
        : [];


$total =
    (int) (
        $documents['total']
        ?? 0
    );


$page =
    max(
        1,
        (int) (
            $documents['page']
            ?? 1
        )
    );


$totalPages =
    max(
        1,
        (int) (
            $documents['totalPages']
            ?? 1
        )
    );


$success =
    is_string(
        $success
        ?? null
    )
        ? $success
        : null;


$error =
    is_string(
        $error
        ?? null
    )
        ? $error
        : null;


/*
|--------------------------------------------------------------------------
| File type helper
|--------------------------------------------------------------------------
*/

$getFileType =
    static function (
        string $mime,
        string $filename
    ): string {

        $mime =
            strtolower(
                trim(
                    $mime
                )
            );


        $extension =
            strtolower(
                (string) pathinfo(
                    $filename,
                    PATHINFO_EXTENSION
                )
            );


        if (
            str_contains(
                $mime,
                'pdf'
            )
            || $extension === 'pdf'
        ) {
            return 'PDF';
        }


        if (
            str_contains(
                $mime,
                'word'
            )
            || str_contains(
                $mime,
                'document'
            )
            || in_array(
                $extension,
                [
                    'doc',
                    'docx',
                ],
                true
            )
        ) {
            return 'DOC';
        }


        if (
            str_contains(
                $mime,
                'excel'
            )
            || str_contains(
                $mime,
                'spreadsheet'
            )
            || in_array(
                $extension,
                [
                    'xls',
                    'xlsx',
                    'csv',
                ],
                true
            )
        ) {
            return 'XLS';
        }


        if (
            str_contains(
                $mime,
                'powerpoint'
            )
            || str_contains(
                $mime,
                'presentation'
            )
            || in_array(
                $extension,
                [
                    'ppt',
                    'pptx',
                ],
                true
            )
        ) {
            return 'PPT';
        }


        if (
            $extension !== ''
        ) {
            return strtoupper(
                substr(
                    $extension,
                    0,
                    4
                )
            );
        }


        return 'FILE';
    };

?>

<div class="admin-documents">

    <header class="admin-documents__header">

        <div class="admin-documents__header-main">

            <div class="admin-documents__eyebrow">
                <span
                    class="admin-documents__eyebrow-icon"
                    aria-hidden="true"
                >
                    📄
                </span>

                اسناد و فرم‌ها
            </div>


            <h1>
                کتابخانه اسناد
            </h1>


            <p>
                فرم‌ها، آیین‌نامه‌ها، فایل‌های رسمی و سایر اسناد
                موسسه را از یک بخش منظم مدیریت کنید.
            </p>

        </div>


        <div class="admin-documents__header-actions">

            <a
                href="<?= View::route(
                    'admin.documents.create'
                ) ?>"
                class="admin-documents__add"
            >

                <span
                    class="admin-documents__add-icon"
                    aria-hidden="true"
                >
                    +
                </span>

                <span>
                    افزودن سند
                </span>

            </a>

        </div>

    </header>


    <?php if (
        $success !== null
        && $success !== ''
    ): ?>

        <div
            class="
                admin-documents__alert
                admin-documents__alert--success
            "
            role="status"
        >

            <span
                class="admin-documents__alert-icon"
                aria-hidden="true"
            >
                ✓
            </span>


            <div>

                <strong>
                    عملیات موفق
                </strong>

                <span>
                    <?= View::escape(
                        $success
                    ) ?>
                </span>

            </div>

        </div>

    <?php endif; ?>


    <?php if (
        $error !== null
        && $error !== ''
    ): ?>

        <div
            class="
                admin-documents__alert
                admin-documents__alert--error
            "
            role="alert"
        >

            <span
                class="admin-documents__alert-icon"
                aria-hidden="true"
            >
                !
            </span>


            <div>

                <strong>
                    خطا
                </strong>

                <span>
                    <?= View::escape(
                        $error
                    ) ?>
                </span>

            </div>

        </div>

    <?php endif; ?>


    <section class="admin-documents__panel">

        <div class="admin-documents__panel-header">

            <div class="admin-documents__panel-heading">

                <div
                    class="admin-documents__panel-icon"
                    aria-hidden="true"
                >
                    📚
                </div>


                <div>

                    <span>
                        Document Library
                    </span>

                    <h2>
                        اسناد ثبت‌شده
                    </h2>

                    <p>
                        فهرست تمام اسناد ذخیره‌شده در سامانه
                    </p>

                </div>

            </div>


            <div class="admin-documents__panel-count">

                <strong>
                    <?= number_format(
                        $total
                    ) ?>
                </strong>

                <span>
                    سند
                </span>

            </div>

        </div>


        <?php if (
            $items === []
        ): ?>

            <div class="admin-documents__empty">

                <div
                    class="admin-documents__empty-icon"
                    aria-hidden="true"
                >
                    📄
                </div>


                <div>

                    <h2>
                        هنوز سندی ثبت نشده است.
                    </h2>

                    <p>
                        اولین فرم، آیین‌نامه یا فایل رسمی موسسه را
                        اضافه کنید تا در این بخش مدیریت شود.
                    </p>

                    <a
                        href="<?= View::route(
                            'admin.documents.create'
                        ) ?>"
                        class="admin-documents__empty-button"
                    >
                        + افزودن اولین سند
                    </a>

                </div>

            </div>

        <?php else: ?>

            <div class="admin-documents__table-shell">

                <div class="admin-documents__table-wrapper">

                    <table class="admin-documents__table">

                        <thead>

                        <tr>

                            <th>
                                سند
                            </th>

                            <th>
                                دسته‌بندی
                            </th>

                            <th>
                                فایل
                            </th>

                            <th>
                                وضعیت
                            </th>

                            <th>
                                دانلود
                            </th>

                            <th>
                                عملیات
                            </th>

                        </tr>

                        </thead>


                        <tbody>

                        <?php foreach (
                            $items
                            as $document
                        ): ?>

                            <?php

                            $id =
                                (int) (
                                    $document['id']
                                    ?? 0
                                );


                            $title =
                                trim(
                                    (string) (
                                        $document['title']
                                        ?? 'سند'
                                    )
                                );


                            $description =
                                trim(
                                    (string) (
                                        $document['description']
                                        ?? ''
                                    )
                                );


                            $fileName =
                                trim(
                                    (string) (
                                        $document['file_name']
                                        ?? ''
                                    )
                                );


                            $mime =
                                trim(
                                    (string) (
                                        $document['mime_type']
                                        ?? ''
                                    )
                                );


                            $categoryName =
                                trim(
                                    (string) (
                                        $document['category_name']
                                        ?? 'بدون دسته'
                                    )
                                );


                            $categorySlug =
                                trim(
                                    (string) (
                                        $document['category_slug']
                                        ?? ''
                                    )
                                );


                            $downloadCount =
                                (int) (
                                    $document['download_count']
                                    ?? 0
                                );


                            $isActive =
                                (int) (
                                    $document['is_active']
                                    ?? 0
                                ) === 1;


                            $fileType =
                                $getFileType(
                                    $mime,
                                    $fileName
                                );


                            $shortDescription =
                                $description !== ''
                                    ? mb_strimwidth(
                                        $description,
                                        0,
                                        90,
                                        '...',
                                        'UTF-8'
                                    )
                                    : '';

                            ?>


                            <tr>

                                <!-- DOCUMENT -->

                                <td>

                                    <div
                                        class="
                                            admin-documents__document-cell
                                        "
                                    >

                                        <div
                                            class="
                                                admin-documents__document-icon
                                                admin-documents__document-icon--<?= View::escape(
                                                    strtolower(
                                                        $fileType
                                                    )
                                                ) ?>
                                            "
                                            aria-hidden="true"
                                        >
                                            <?= View::escape(
                                                $fileType
                                            ) ?>
                                        </div>


                                        <div
                                            class="
                                                admin-documents__document-info
                                            "
                                        >

                                            <strong
                                                class="
                                                    admin-documents__title
                                                "
                                            >
                                                <?= View::escape(
                                                    $title
                                                ) ?>
                                            </strong>


                                            <?php if (
                                                $shortDescription !== ''
                                            ): ?>

                                                <span
                                                    class="
                                                        admin-documents__description
                                                    "
                                                >
                                                    <?= View::escape(
                                                        $shortDescription
                                                    ) ?>
                                                </span>

                                            <?php endif; ?>

                                        </div>

                                    </div>

                                </td>


                                <!-- CATEGORY -->

                                <td>

                                    <span
                                        class="
                                            admin-documents__category
                                        "
                                    >
                                        <span
                                            class="
                                                admin-documents__category-dot
                                            "
                                            aria-hidden="true"
                                        ></span>

                                        <?= View::escape(
                                            $categoryName
                                        ) ?>
                                    </span>

                                </td>


                                <!-- FILE -->

                                <td>

                                    <div
                                        class="
                                            admin-documents__file-cell
                                        "
                                    >

                                        <span
                                            class="
                                                admin-documents__file-name
                                            "
                                            title="<?= View::escape(
                                                $fileName
                                            ) ?>"
                                        >
                                            <?= View::escape(
                                                $fileName !== ''
                                                    ? $fileName
                                                    : 'فایل نامشخص'
                                            ) ?>
                                        </span>


                                        <?php if (
                                            $mime !== ''
                                        ): ?>

                                            <span
                                                class="
                                                    admin-documents__file-meta
                                                "
                                            >
                                                <?= View::escape(
                                                    $mime
                                                ) ?>
                                            </span>

                                        <?php endif; ?>

                                    </div>

                                </td>


                                <!-- STATUS -->

                                <td>

                                    <?php if (
                                        $isActive
                                    ): ?>

                                        <span
                                            class="
                                                admin-documents__status
                                                admin-documents__status--active
                                            "
                                        >

                                            <span
                                                class="
                                                    admin-documents__status-dot
                                                "
                                                aria-hidden="true"
                                            ></span>

                                            فعال

                                        </span>

                                    <?php else: ?>

                                        <span
                                            class="
                                                admin-documents__status
                                                admin-documents__status--inactive
                                            "
                                        >

                                            <span
                                                class="
                                                    admin-documents__status-dot
                                                "
                                                aria-hidden="true"
                                            ></span>

                                            غیرفعال

                                        </span>

                                    <?php endif; ?>

                                </td>


                                <!-- DOWNLOADS -->

                                <td>

                                    <div
                                        class="
                                            admin-documents__download-count
                                        "
                                    >

                                        <span
                                            class="
                                                admin-documents__download-icon
                                            "
                                            aria-hidden="true"
                                        >
                                            ↓
                                        </span>


                                        <strong>
                                            <?= number_format(
                                                $downloadCount
                                            ) ?>
                                        </strong>

                                    </div>

                                </td>


                                <!-- ACTIONS -->

                                <td>

                                    <div
                                        class="
                                            admin-documents__actions
                                        "
                                    >

                                        <a
                                            href="<?= View::url(
                                                '/admin/documents/'
                                                . $id
                                                . '/edit'
                                            ) ?>"
                                            class="
                                                admin-documents__action
                                                admin-documents__action--edit
                                            "
                                        >
                                            ویرایش
                                        </a>


                                        <?php if (
                                            $categorySlug !== ''
                                        ): ?>

                                            <a
                                                href="<?= View::url(
                                                    '/documents/'
                                                    . rawurlencode(
                                                        $categorySlug
                                                    )
                                                    . '/'
                                                    . $id
                                                ) ?>"
                                                class="
                                                    admin-documents__action
                                                    admin-documents__action--download
                                                "
                                                target="_blank"
                                                rel="noopener noreferrer"
                                            >
                                                دانلود
                                            </a>

                                        <?php endif; ?>


                                        <form
                                            method="POST"
                                            action="<?= View::url(
                                                '/admin/documents/'
                                                . $id
                                                . '/delete'
                                            ) ?>"
                                            onsubmit="return confirm('آیا از حذف این سند مطمئن هستید؟');"
                                        >

                                            <?= Csrf::field() ?>


                                            <button
                                                type="submit"
                                                class="
                                                    admin-documents__action
                                                    admin-documents__action--delete
                                                "
                                            >
                                                حذف
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            </div>


            <?php if (
                $totalPages > 1
            ): ?>

                <nav
                    class="admin-documents__pagination"
                    aria-label="صفحه‌بندی اسناد"
                >

                    <?php if (
                        $page > 1
                    ): ?>

                        <a
                            href="/admin/documents?page=<?= $page - 1 ?>"
                            class="
                                admin-documents__pagination-button
                                admin-documents__pagination-button--arrow
                            "
                        >
                            ←
                            <span>
                                قبلی
                            </span>
                        </a>

                    <?php endif; ?>


                    <div
                        class="
                            admin-documents__pagination-current
                        "
                    >

                        <strong>
                            <?= $page ?>
                        </strong>

                        <span>
                            از
                            <?= $totalPages ?>
                        </span>

                    </div>


                    <?php if (
                        $page < $totalPages
                    ): ?>

                        <a
                            href="/admin/documents?page=<?= $page + 1 ?>"
                            class="
                                admin-documents__pagination-button
                                admin-documents__pagination-button--arrow
                            "
                        >

                            <span>
                                بعدی
                            </span>

                            →

                        </a>

                    <?php endif; ?>

                </nav>

            <?php endif; ?>

        <?php endif; ?>

    </section>

</div>
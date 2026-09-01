<?php

declare(strict_types=1);

use App\Core\Session;
use App\Core\View;

$formPage =
    Session::getFlash(
        'page_form'
    );

$formErrors =
    Session::getFlash(
        'page_errors'
    );

$defaults = [

    'id' =>
        null,

    'parent_id' =>
        null,

    'slug' =>
        '',

    'title' =>
        '',

    'excerpt' =>
        '',

    'content' =>
        '',

    'featured_image' =>
        '',

    'status' =>
        'draft',

    'seo_title' =>
        '',

    'seo_description' =>
        '',

    'seo_keywords' =>
        '',

    'published_at' =>
        null,

    'created_by' =>
        null,

    'updated_by' =>
        null,

];

$page =
    is_array(
        $page ?? null
    )
        ? array_merge(
            $defaults,
            $page
        )
        : $defaults;


if (
    is_array($formPage)
) {
    $page =
        array_merge(
            $page,
            $formPage
        );
}


$errors =
    is_array($formErrors)
        ? $formErrors
        : [];


$action =
    View::route(
        'admin.pages.store'
    );


$submitLabel =
    'ایجاد صفحه';


$errorMessage =
    Session::getFlash(
        'error'
    );

?>

<div class="admin-pages">

    <header class="admin-pages__header">

        <div class="admin-pages__header-main">

            <span class="admin-pages__eyebrow">
                مدیریت صفحات
            </span>

            <h1>
                ایجاد صفحه جدید
            </h1>

            <p>
                یک صفحه جدید ایجاد کنید و محتوای آن را همراه با تنظیمات انتشار و SEO مدیریت کنید.
            </p>

        </div>


        <div class="admin-pages__header-actions">

            <a
                href="<?= View::route(
                    'admin.pages.index'
                ) ?>"
                class="
                    admin-pages__button
                    admin-pages__button--secondary
                "
            >
                بازگشت به صفحات
            </a>

        </div>

    </header>


    <?php if (
        is_string($errorMessage)
        && $errorMessage !== ''
    ): ?>

        <div
            class="
                admin-pages__alert
                admin-pages__alert--error
            "
            role="alert"
        >

            <strong>
                خطا
            </strong>

            <span>
                <?= View::escape(
                    $errorMessage
                ) ?>
            </span>

        </div>

    <?php endif; ?>


    <section class="admin-pages__panel">

        <header class="admin-pages__panel-header">

            <div class="admin-pages__panel-heading">

                <div
                    class="admin-pages__panel-icon"
                    aria-hidden="true"
                >
                    ✎
                </div>

                <div>

                    <strong>
                        اطلاعات صفحه
                    </strong>

                    <span>
                        اطلاعات اصلی و محتوای صفحه
                    </span>

                </div>

            </div>

        </header>


        <?php

        require __DIR__
            . '/_form.php';

        ?>

    </section>

</div>
<?php

declare(strict_types=1);

use App\Core\Session;
use App\Core\View;

$form =
    Session::getFlash(
        'research_center_form'
    );

$formErrors =
    Session::getFlash(
        'research_center_errors'
    );

if (
    is_array($form)
) {
    $center =
        array_merge(
            $center,
            $form
        );
}

if (
    is_array($formErrors)
) {
    $errors =
        $formErrors;
}

$action =
    View::route(
        'admin.research-centers.store'
    );

$submitLabel =
    'ایجاد پژوهشکده';
?>

<div class="research-admin research-admin--form">

    <header class="research-admin__header">

        <div class="research-admin__header-main">

            <a
                href="<?= View::route(
                    'admin.research-centers.index'
                ) ?>"
                class="research-admin__back"
            >
                <span aria-hidden="true">
                    →
                </span>

                بازگشت به پژوهشکده‌ها
            </a>


            <span class="research-admin__eyebrow">
                پژوهش و نوآوری
            </span>


            <div class="research-admin__title-row">

                <div
                    class="research-admin__title-icon"
                    aria-hidden="true"
                >
                    🔬
                </div>

                <div>

                    <h1 class="research-admin__title">
                        ایجاد پژوهشکده
                    </h1>

                    <p class="research-admin__description">
                        اطلاعات مرکز پژوهشی جدید را ثبت کنید.
                    </p>

                </div>

            </div>

        </div>

    </header>


    <section class="research-admin__panel research-admin__panel--form">

        <div class="research-admin__panel-header">

            <div>

                <span class="research-admin__panel-eyebrow">
                    اطلاعات پژوهشکده
                </span>

                <h2>
                    مشخصات اصلی
                </h2>

                <p>
                    نام، آدرس، اطلاعات تماس و معرفی پژوهشکده را وارد کنید.
                </p>

            </div>

        </div>


        <div class="research-admin__form-body">

            <?php
            require __DIR__
                . '/_form.php';
            ?>

        </div>

    </section>

</div>
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

$centerId =
    (int) (
        $center['id']
        ?? 0
    );

$action =
    View::url(
        '/admin/research-centers/'
        . $centerId
    );

$submitLabel =
    'ذخیره تغییرات';
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
                        ویرایش پژوهشکده
                    </h1>

                    <p class="research-admin__description">
                        اطلاعات پژوهشکده را بررسی و به‌روزرسانی کنید.
                    </p>

                </div>

            </div>

        </div>


        <?php if (
            !empty(
                $center['slug']
            )
        ): ?>

            <div class="research-admin__header-actions">

                <a
                    href="<?= View::url(
                        '/research-centers/'
                        . rawurlencode(
                            (string) $center['slug']
                        )
                    ) ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="
                        research-admin__button
                        research-admin__button--secondary
                    "
                >
                    مشاهده صفحه
                    <span aria-hidden="true">
                        ↗
                    </span>
                </a>

            </div>

        <?php endif; ?>

    </header>


    <section class="research-admin__panel research-admin__panel--form">

        <div class="research-admin__panel-header">

            <div>

                <span class="research-admin__panel-eyebrow">
                    ویرایش
                </span>

                <h2>
                    <?= View::escape(
                        $center['name']
                        ?? 'پژوهشکده'
                    ) ?>
                </h2>

                <p>
                    تغییرات مورد نظر را اعمال و ذخیره کنید.
                </p>

            </div>


            <div class="research-admin__record-id">

                #<?= number_format(
                    $centerId
                ) ?>

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
<?php

declare(strict_types=1);

use App\Core\View;

$faculty =
    is_array($faculty ?? null)
        ? $faculty
        : [];

$errors =
    is_array($errors ?? null)
        ? $errors
        : [];

$facultyId =
    (int) (
        $faculty['id']
        ?? 0
    );

$action =
    View::url(
        '/admin/faculties/'
        . $facultyId
    );

$submitLabel =
    'ذخیره تغییرات';
?>

<div class="faculty-admin faculty-admin--form">

    <header class="faculty-admin__header">

        <div class="faculty-admin__header-main">

            <a
                href="<?= View::route(
                    'admin.faculties.index'
                ) ?>"
                class="faculty-admin__back"
            >
                <span aria-hidden="true">
                    →
                </span>

                بازگشت به دانشکده‌ها
            </a>


            <span class="faculty-admin__eyebrow">
                آموزش و پژوهش
            </span>


            <div class="faculty-admin__title-row">

                <div
                    class="faculty-admin__title-icon"
                    aria-hidden="true"
                >
                    🎓
                </div>

                <div>

                    <h1 class="faculty-admin__title">
                        ویرایش دانشکده
                    </h1>

                    <p class="faculty-admin__description">
                        اطلاعات و وضعیت این دانشکده را به‌روزرسانی کنید.
                    </p>

                </div>

            </div>

        </div>


        <div class="faculty-admin__header-actions">

            <?php if (
                !empty(
                    $faculty['slug']
                )
            ): ?>

                <a
                    href="<?= View::url(
                        '/faculties/'
                        . (string) $faculty['slug']
                    ) ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="faculty-admin__button faculty-admin__button--secondary"
                >
                    مشاهده صفحه
                    <span aria-hidden="true">
                        ↗
                    </span>
                </a>

            <?php endif; ?>

        </div>

    </header>


    <section class="faculty-admin__panel faculty-admin__panel--form">

        <div class="faculty-admin__panel-header">

            <div>

                <span class="faculty-admin__panel-eyebrow">
                    ویرایش
                </span>

                <h2>
                    <?= View::escape(
                        $faculty['name']
                        ?? 'دانشکده'
                    ) ?>
                </h2>

                <p>
                    اطلاعات فعلی را بررسی و تغییرات مورد نظر را ذخیره کنید.
                </p>

            </div>


            <div class="faculty-admin__record-id">

                #<?= number_format(
                    $facultyId
                ) ?>

            </div>

        </div>


        <div class="faculty-admin__form-body">

            <?php

            require __DIR__
                . '/_form.php';

            ?>

        </div>

    </section>

</div>
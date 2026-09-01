<?php

declare(strict_types=1);

use App\Core\View;

$program =
    is_array($program ?? null)
        ? $program
        : [];

$faculties =
    is_array($faculties ?? null)
        ? $faculties
        : [];

$errors =
    is_array($errors ?? null)
        ? $errors
        : [];

$programId =
    (int) (
        $program['id']
        ?? 0
    );

$action =
    View::url(
        '/admin/programs/'
        . $programId
    );

$submitLabel =
    'ذخیره تغییرات';
?>

<div class="program-admin program-admin--form">

    <header class="program-admin__header">

        <div class="program-admin__header-main">

            <a
                href="<?= View::route(
                    'admin.programs.index'
                ) ?>"
                class="program-admin__back"
            >
                <span aria-hidden="true">
                    →
                </span>

                بازگشت به برنامه‌ها
            </a>


            <span class="program-admin__eyebrow">
                آموزش و پژوهش
            </span>


            <div class="program-admin__title-row">

                <div
                    class="program-admin__title-icon"
                    aria-hidden="true"
                >
                    📚
                </div>

                <div>

                    <h1 class="program-admin__title">
                        ویرایش برنامه
                    </h1>

                    <p class="program-admin__description">
                        اطلاعات فعلی این برنامه را بررسی و به‌روزرسانی کنید.
                    </p>

                </div>

            </div>

        </div>


        <div class="program-admin__header-actions">

            <?php if (
                !empty(
                    $program['slug']
                )
            ): ?>

                <a
                    href="<?= View::url(
                        '/programs/'
                        . (string) $program['slug']
                    ) ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="program-admin__button program-admin__button--secondary"
                >
                    مشاهده صفحه
                    <span aria-hidden="true">
                        ↗
                    </span>
                </a>

            <?php endif; ?>

        </div>

    </header>


    <section class="program-admin__panel program-admin__panel--form">

        <div class="program-admin__panel-header">

            <div>

                <span class="program-admin__panel-eyebrow">
                    ویرایش
                </span>

                <h2>
                    <?= View::escape(
                        $program['name']
                        ?? 'برنامه آموزشی'
                    ) ?>
                </h2>

                <p>
                    تغییرات مورد نظر را اعمال و ذخیره کنید.
                </p>

            </div>


            <div class="program-admin__record-id">

                #<?= number_format(
                    $programId
                ) ?>

            </div>

        </div>


        <div class="program-admin__form-body">

            <?php

            require __DIR__
                . '/_form.php';

            ?>

        </div>

    </section>

</div>
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

$action =
    View::route(
        'admin.programs.store'
    );

$submitLabel =
    'ایجاد برنامه';
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
                        ایجاد برنامه آموزشی
                    </h1>

                    <p class="program-admin__description">
                        اطلاعات رشته یا برنامه آموزشی جدید را وارد کنید.
                    </p>

                </div>

            </div>

        </div>


        <div class="program-admin__header-actions">

            <span class="program-admin__header-badge">
                ایجاد مورد جدید
            </span>

        </div>

    </header>


    <section class="program-admin__panel program-admin__panel--form">

        <div class="program-admin__panel-header">

            <div>

                <span class="program-admin__panel-eyebrow">
                    اطلاعات برنامه
                </span>

                <h2>
                    مشخصات اصلی
                </h2>

                <p>
                    اطلاعات آموزشی و توضیحات برنامه را وارد کنید.
                </p>

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
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

$action =
    View::route(
        'admin.faculties.store'
    );

$submitLabel =
    'ایجاد دانشکده';
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
                        ایجاد دانشکده
                    </h1>

                    <p class="faculty-admin__description">
                        اطلاعات دانشکده جدید را وارد کنید.
                    </p>

                </div>

            </div>

        </div>


        <div class="faculty-admin__header-actions">

            <span class="faculty-admin__header-badge">
                ایجاد مورد جدید
            </span>

        </div>

    </header>


    <section class="faculty-admin__panel faculty-admin__panel--form">

        <div class="faculty-admin__panel-header">

            <div>

                <span class="faculty-admin__panel-eyebrow">
                    اطلاعات دانشکده
                </span>

                <h2>
                    مشخصات اصلی
                </h2>

                <p>
                    اطلاعاتی که در سایت عمومی برای این دانشکده نمایش داده می‌شود.
                </p>

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
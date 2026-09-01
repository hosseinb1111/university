<?php

declare(strict_types=1);

use App\Core\View;

$person =
    is_array($person ?? null)
        ? $person
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
        'admin.people.store'
    );

$submitLabel =
    'ایجاد شخص';
?>

<div class="people-admin people-admin--form">

    <header class="people-admin__header">

        <div class="people-admin__header-main">

            <a
                href="<?= View::route(
                    'admin.people.index'
                ) ?>"
                class="people-admin__back"
            >
                <span aria-hidden="true">
                    →
                </span>

                بازگشت به اعضا
            </a>


            <span class="people-admin__eyebrow">
                اعضای موسسه
            </span>


            <div class="people-admin__title-row">

                <div
                    class="people-admin__title-icon"
                    aria-hidden="true"
                >
                    👤
                </div>

                <div>

                    <h1 class="people-admin__title">
                        افزودن شخص
                    </h1>

                    <p class="people-admin__description">
                        اطلاعات استاد، مدیر یا کارمند جدید را ثبت کنید.
                    </p>

                </div>

            </div>

        </div>


        <div class="people-admin__header-actions">

            <span class="people-admin__header-badge">
                ایجاد عضو جدید
            </span>

        </div>

    </header>


    <section class="people-admin__panel people-admin__panel--form">

        <div class="people-admin__panel-header">

            <div>

                <span class="people-admin__panel-eyebrow">
                    اطلاعات شخص
                </span>

                <h2>
                    مشخصات اصلی
                </h2>

                <p>
                    اطلاعات تماس، سمت و معرفی شخص را وارد کنید.
                </p>

            </div>

        </div>


        <div class="people-admin__form-body">

            <?php

            require __DIR__
                . '/_form.php';

            ?>

        </div>

    </section>

</div>
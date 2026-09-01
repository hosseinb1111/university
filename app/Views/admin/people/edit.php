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

$personId =
    (int) (
        $person['id']
        ?? 0
    );

$action =
    View::url(
        '/admin/people/'
        . $personId
    );

$submitLabel =
    'ذخیره تغییرات';
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
                        ویرایش شخص
                    </h1>

                    <p class="people-admin__description">
                        اطلاعات فعلی عضو را بررسی و به‌روزرسانی کنید.
                    </p>

                </div>

            </div>

        </div>


        <div class="people-admin__header-actions">

            <a
                href="<?= View::url(
                    '/people/'
                    . $personId
                ) ?>"
                target="_blank"
                rel="noopener noreferrer"
                class="people-admin__button people-admin__button--secondary"
            >
                مشاهده صفحه
                <span aria-hidden="true">
                    ↗
                </span>
            </a>

        </div>

    </header>


    <section class="people-admin__panel people-admin__panel--form">

        <div class="people-admin__panel-header">

            <div>

                <span class="people-admin__panel-eyebrow">
                    ویرایش
                </span>

                <h2>
                    <?= View::escape(
                        trim(
                            (
                                $person['first_name']
                                ?? ''
                            )
                            . ' '
                            . (
                                $person['last_name']
                                ?? ''
                            )
                        )
                        ?: 'عضو موسسه'
                    ) ?>
                </h2>

                <p>
                    تغییرات مورد نظر را اعمال و ذخیره کنید.
                </p>

            </div>


            <div class="people-admin__record-id">

                #<?= number_format(
                    $personId
                ) ?>

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
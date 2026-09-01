<?php

declare(strict_types=1);

use App\Core\View;

$presidentName = '';

if (
    is_array($president)
) {
    $presidentName =
        trim(
            (string) (
                $president['first_name']
                ?? ''
            )
            . ' '
            . (string) (
                $president['last_name']
                ?? ''
            )
        );
}
?>

<section class="institution-page">

    <div class="container">

        <header class="institution-hero">

            <span>
                مدیریت موسسه
            </span>

            <h1>
                ریاست موسسه
            </h1>

            <p>
                اطلاعات ریاست و دفتر ریاست موسسه آموزش عالی صدرالمتالهین.
            </p>

        </header>


        <?php if (
            is_array($president)
        ): ?>

            <article class="presidency-card">

                <div class="presidency-card__media">

                    <?php if (
                        !empty(
                            $president['image']
                        )
                    ): ?>

                        <img
                            src="<?= View::escape(
                                $president['image']
                            ) ?>"
                            alt="<?= View::escape(
                                $presidentName
                            ) ?>"
                            loading="lazy"
                        >

                    <?php else: ?>

                        <div
                            class="presidency-card__placeholder"
                            aria-hidden="true"
                        >
                            <?= View::escape(
                                mb_substr(
                                    $presidentName,
                                    0,
                                    1,
                                    'UTF-8'
                                )
                            ) ?>
                        </div>

                    <?php endif; ?>

                </div>


                <div class="presidency-card__body">

                    <span>
                        رئیس موسسه
                    </span>

                    <h2>
                        <?= View::escape(
                            $presidentName
                        ) ?>
                    </h2>


                    <?php if (
                        !empty(
                            $president['biography']
                        )
                    ): ?>

                        <div class="institution-rich-text">

                            <?= nl2br(
                                View::escape(
                                    $president[
                                        'biography'
                                    ]
                                )
                            ) ?>

                        </div>

                    <?php endif; ?>


                    <div class="presidency-contact">

                        <?php if (
                            !empty(
                                $president['email']
                            )
                        ): ?>

                            <a
                                href="mailto:<?= View::escape(
                                    $president['email']
                                ) ?>"
                            >
                                <?= View::escape(
                                    $president['email']
                                ) ?>
                            </a>

                        <?php endif; ?>


                        <?php if (
                            !empty(
                                $president['phone']
                            )
                        ): ?>

                            <a
                                href="tel:<?= View::escape(
                                    preg_replace(
                                        '/[^0-9+]/',
                                        '',
                                        $president['phone']
                                    )
                                ) ?>"
                            >
                                <?= View::escape(
                                    $president['phone']
                                ) ?>
                            </a>

                        <?php endif; ?>

                    </div>

                </div>

            </article>

        <?php else: ?>

            <div class="institution-empty">

                <strong>
                    اطلاعات ریاست ثبت نشده است.
                </strong>

                <p>
                    این اطلاعات از بخش اعضای موسسه مدیریت می‌شود.
                </p>

            </div>

        <?php endif; ?>


        <section class="institution-section">

            <div class="institution-section__heading">

                <div>

                    <span>
                        دفتر ریاست
                    </span>

                    <h2>
                        ارتباط با دفتر ریاست
                    </h2>

                </div>

            </div>


            <div class="institution-action-grid">

                <a
                    href="<?= View::url(
                        '/contact'
                    ) ?>"
                    class="institution-action-card"
                >

                    <strong>
                        تماس با موسسه
                    </strong>

                    <span>
                        مشاهده اطلاعات تماس رسمی
                    </span>

                </a>


                <a
                    href="mailto:info@sadra.ac.ir"
                    class="institution-action-card"
                >

                    <strong>
                        پست الکترونیکی
                    </strong>

                    <span>
                        ارسال پیام به موسسه
                    </span>

                </a>

            </div>

        </section>

    </div>

</section>
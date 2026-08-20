<?php

declare(strict_types=1);
?>

<section class="institution-page">

    <div class="container">

        <div class="institution-hero">

            <span>
                ارتباط با موسسه
            </span>

            <h1>
                تماس با ما
            </h1>

            <p>
                اطلاعات رسمی تماس موسسه آموزش عالی صدرالمتالهین.
            </p>

        </div>


        <div class="contact-grid">


            <article class="institution-card">

                <span class="contact-card__icon">
                    ✉
                </span>

                <h2>
                    پست الکترونیکی
                </h2>

                <a
                    href="mailto:<?= View::escape(
                        $contact['email']
                    ) ?>"
                >
                    <?= View::escape(
                        $contact['email']
                    ) ?>
                </a>

            </article>


            <article class="institution-card">

                <span class="contact-card__icon">
                    ☎
                </span>

                <h2>
                    تلفن
                </h2>

                <a
                    href="tel:<?= View::escape(
                        preg_replace(
                            '/[^0-9+]/',
                            '',
                            $contact['phone']
                        )
                    ) ?>"
                >
                    <?= View::escape(
                        $contact['phone']
                    ) ?>
                </a>

            </article>


            <article class="institution-card">

                <span class="contact-card__icon">
                    ▣
                </span>

                <h2>
                    دورنگار
                </h2>

                <p>
                    <?= View::escape(
                        $contact['fax']
                    ) ?>
                </p>

            </article>


            <article class="institution-card">

                <span class="contact-card__icon">
                    📍
                </span>

                <h2>
                    نشانی
                </h2>

                <p>
                    <?= View::escape(
                        $contact['address']
                    ) ?>
                </p>

            </article>

        </div>


        <div
            class="contact-map"
        >

            <div>

                <span>
                    موقعیت موسسه
                </span>

                <h2>
                    تهران، ایران
                </h2>

                <p>
                    برای نسخه نهایی سایت می‌توانیم مختصات و نقشه رسمی موسسه را نیز وارد کنیم.
                </p>

            </div>

        </div>

    </div>

</section>
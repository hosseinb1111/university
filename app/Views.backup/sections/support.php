<?php

declare(strict_types=1);

use App\Core\View;
?>

<section class="institution-page">

    <div class="container">

        <header class="institution-hero">

            <span>
                پشتیبانی
            </span>

            <h1>
                پشتیبانی و عمرانی
            </h1>

            <p>
                خدمات اداری، فنی، پشتیبانی و زیرساختی موسسه.
            </p>

        </header>


        <div class="institution-content-grid">

            <article class="institution-card">

                <span class="institution-card__eyebrow">
                    پشتیبانی
                </span>

                <h2>
                    خدمات پشتیبانی
                </h2>

                <p>
                    این بخش برای معرفی خدمات پشتیبانی، اداری و فنی موسسه
                    استفاده می‌شود.
                </p>

                <a
                    href="<?= View::url(
                        '/contact'
                    ) ?>"
                    class="button button--secondary"
                >
                    اطلاعات تماس
                </a>

            </article>


            <article class="institution-card">

                <span class="institution-card__eyebrow">
                    زیرساخت
                </span>

                <h2>
                    خدمات عمرانی و زیرساختی
                </h2>

                <p>
                    اطلاعات مربوط به امکانات فیزیکی، ساختمان‌ها، زیرساخت
                    و خدمات عمرانی موسسه در این بخش قرار می‌گیرد.
                </p>

            </article>


            <article class="institution-card">

                <span class="institution-card__eyebrow">
                    اسناد
                </span>

                <h2>
                    دستورالعمل‌ها
                </h2>

                <p>
                    دستورالعمل‌ها و مقررات مرتبط با امور اداری و مالی را
                    می‌توانید از بخش اسناد مشاهده کنید.
                </p>

                <a
                    href="<?= View::url(
                        '/documents'
                    ) ?>"
                    class="button button--secondary"
                >
                    مشاهده اسناد
                </a>

            </article>


            <article class="institution-card">

                <span class="institution-card__eyebrow">
                    ارتباط
                </span>

                <h2>
                    ارتباط با موسسه
                </h2>

                <p>
                    برای درخواست اطلاعات یا ارتباط با واحدهای مربوطه،
                    از صفحه تماس رسمی موسسه استفاده کنید.
                </p>

                <a
                    href="<?= View::url(
                        '/contact'
                    ) ?>"
                    class="button button--secondary"
                >
                    تماس با ما
                </a>

            </article>

        </div>

    </div>

</section>
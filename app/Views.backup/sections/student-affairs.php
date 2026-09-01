<?php

declare(strict_types=1);

use App\Core\View;
?>

<section class="institution-page">

    <div class="container">

        <header class="institution-hero">

            <span>
                خدمات دانشجویی
            </span>

            <h1>
                دانشجویی و فرهنگی
            </h1>

            <p>
                اطلاعات و خدمات مرتبط با امور دانشجویی، فرهنگی و پشتیبانی
                از دانشجویان.
            </p>

        </header>


        <div class="institution-content-grid">

            <article class="institution-card">

                <span class="institution-card__eyebrow">
                    امور دانشجویی
                </span>

                <h2>
                    خدمات دانشجویی
                </h2>

                <p>
                    این بخش برای ارائه اطلاعات مربوط به خدمات دانشجویی،
                    درخواست‌ها، فرم‌ها و مقررات مورد استفاده قرار می‌گیرد.
                </p>

                <a
                    href="<?= View::url(
                        '/documents'
                    ) ?>"
                    class="button button--secondary"
                >
                    مشاهده فرم‌ها و مقررات
                </a>

            </article>


            <article class="institution-card">

                <span class="institution-card__eyebrow">
                    فرهنگی
                </span>

                <h2>
                    فعالیت‌های فرهنگی
                </h2>

                <p>
                    اخبار، برنامه‌ها و فعالیت‌های فرهنگی و اجتماعی دانشجویان
                    در این بخش قرار می‌گیرد.
                </p>

                <a
                    href="<?= View::url(
                        '/announcements'
                    ) ?>"
                    class="button button--secondary"
                >
                    مشاهده اطلاعیه‌ها
                </a>

            </article>


            <article class="institution-card">

                <span class="institution-card__eyebrow">
                    تقویم
                </span>

                <h2>
                    مقررات و تقویم آموزشی
                </h2>

                <p>
                    مقررات و تقویم‌های رسمی آموزشی از طریق بخش اسناد و فرم‌ها
                    در دسترس قرار می‌گیرند.
                </p>

                <a
                    href="<?= View::url(
                        '/documents/academic-calendar'
                    ) ?>"
                    class="button button--secondary"
                >
                    مشاهده اسناد
                </a>

            </article>


            <article class="institution-card">

                <span class="institution-card__eyebrow">
                    پشتیبانی
                </span>

                <h2>
                    ارتباط با موسسه
                </h2>

                <p>
                    برای پیگیری موضوعات دانشجویی می‌توانید از اطلاعات تماس
                    رسمی موسسه استفاده کنید.
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
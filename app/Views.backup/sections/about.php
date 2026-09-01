<?php

declare(strict_types=1);

use App\Core\View;
?>

<section class="institution-page">

    <div class="container">

        <header class="institution-hero">

            <span>
                معرفی موسسه
            </span>

            <h1>
                موسسه آموزش عالی صدرالمتالهین
            </h1>

            <p>
                موسسه آموزش عالی صدرالمتالهین (صدرا)، یک مجموعه آموزش عالی با تمرکز بر آموزش،
                توسعه علمی و فعالیت‌های پژوهشی است.
            </p>

        </header>


        <div class="institution-content-grid">

            <article class="institution-card">

                <span class="institution-card__eyebrow">
                    درباره ما
                </span>

                <h2>
                    معرفی موسسه
                </h2>

                <p>
                    این بخش برای ارائه معرفی رسمی موسسه، تاریخچه، ساختار و اطلاعات عمومی آن
                    طراحی شده است.
                </p>

                <p>
                    محتوای رسمی و قابل ویرایش می‌تواند در ادامه از طریق پنل مدیریت به این
                    بخش متصل شود.
                </p>

            </article>


            <article class="institution-card">

                <span class="institution-card__eyebrow">
                    اهداف
                </span>

                <h2>
                    اهداف و رویکرد
                </h2>

                <p>
                    توسعه آموزش عالی، تقویت فعالیت‌های علمی و پژوهشی و فراهم کردن محیط مناسب
                    برای رشد دانشجویان و اعضای هیئت علمی.
                </p>

            </article>


            <article class="institution-card">

                <span class="institution-card__eyebrow">
                    ساختار
                </span>

                <h2>
                    ساختار دانشگاهی
                </h2>

                <p>
                    ساختار موسسه شامل بخش‌های آموزشی، پژوهشی، دانشجویی، اداری و پشتیبانی
                    است.
                </p>

            </article>


            <article class="institution-card">

                <span class="institution-card__eyebrow">
                    دسترسی
                </span>

                <h2>
                    بخش‌های اصلی
                </h2>

                <div class="institution-link-list">

                    <a
                        href="<?= View::url(
                            '/faculties'
                        ) ?>"
                    >
                        دانشکده‌ها
                    </a>

                    <a
                        href="<?= View::url(
                            '/programs'
                        ) ?>"
                    >
                        رشته‌ها و برنامه‌های آموزشی
                    </a>

                    <a
                        href="<?= View::url(
                            '/research-centers'
                        ) ?>"
                    >
                        پژوهشکده‌ها
                    </a>

                    <a
                        href="<?= View::url(
                            '/people'
                        ) ?>"
                    >
                        اعضای هیئت علمی
                    </a>

                </div>

            </article>

        </div>


        <section class="institution-section">

            <div class="institution-section__heading">

                <div>

                    <span>
                        اطلاعات بیشتر
                    </span>

                    <h2>
                        مسیرهای دسترسی
                    </h2>

                </div>

            </div>


            <div class="institution-action-grid">

                <a
                    href="<?= View::url(
                        '/announcements'
                    ) ?>"
                    class="institution-action-card"
                >

                    <strong>
                        اطلاعیه‌ها
                    </strong>

                    <span>
                        آخرین اخبار و اطلاعیه‌های رسمی
                    </span>

                </a>


                <a
                    href="<?= View::url(
                        '/documents'
                    ) ?>"
                    class="institution-action-card"
                >

                    <strong>
                        اسناد و فرم‌ها
                    </strong>

                    <span>
                        فرم‌ها، آیین‌نامه‌ها و دستورالعمل‌ها
                    </span>

                </a>


                <a
                    href="<?= View::url(
                        '/contact'
                    ) ?>"
                    class="institution-action-card"
                >

                    <strong>
                        تماس با ما
                    </strong>

                    <span>
                        اطلاعات تماس و راه‌های ارتباطی
                    </span>

                </a>

            </div>

        </section>

    </div>

</section>
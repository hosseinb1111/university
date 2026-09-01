<section class="error-page">
    <div class="container">

        <div class="error-page__content">

            <span class="error-page__code">
                403
            </span>

            <h1>
                دسترسی غیرمجاز
            </h1>

            <p>
                شما اجازه دسترسی به این صفحه را ندارید.
            </p>

            <div class="error-page__actions">

                <a
                    href="/"
                    class="button button--primary"
                >
                    بازگشت به صفحه اصلی
                </a>

                <?php if (\App\Core\Session::authenticated()): ?>

                    <a
                        href="/teacher/dashboard"
                        class="button button--secondary"
                    >
                        بازگشت به داشبورد
                    </a>

                <?php else: ?>

                    <a
                        href="/teacher/login"
                        class="button button--secondary"
                    >
                        ورود به سامانه
                    </a>

                <?php endif; ?>

            </div>

        </div>

    </div>
</section>
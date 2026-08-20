<?php

declare(strict_types=1);

$displayName = trim(
    ($user['first_name'] ?? '')
    . ' '
    . ($user['last_name'] ?? '')
);

if ($displayName === '') {
    $displayName =
        $user['username']
        ?? 'کاربر';
}

$facultyName =
    $person['faculty_name']
    ?? null;

$position =
    $person['position']
    ?? null;
?>

<section class="teacher-page">

    <div class="teacher-page__header">

        <div>

            <span class="teacher-page__eyebrow">
                پنل اعضای هیئت علمی
            </span>

            <h1>
                خوش آمدید،
                <?= View::escape(
                    $displayName
                ) ?>
            </h1>

            <p>
                از این بخش می‌توانید اطلاعات حساب و پروفایل دانشگاهی خود را مدیریت کنید.
            </p>

        </div>

    </div>


    <div class="teacher-card-grid">

        <article class="teacher-card">

            <span class="teacher-card__label">
                حساب کاربری
            </span>

            <strong>
                <?= View::escape(
                    $user['username']
                ) ?>
            </strong>

            <p>
                نقش:
                <?= View::escape(
                    match (
                        $user['role']
                        ?? ''
                    ) {
                        'super_admin' =>
                            'مدیر ارشد',

                        'admin' =>
                            'مدیر',

                        'editor' =>
                            'ویراستار',

                        default =>
                            'عضو هیئت علمی',
                    }
                ) ?>
            </p>

        </article>


        <article class="teacher-card">

            <span class="teacher-card__label">
                پروفایل دانشگاهی
            </span>

            <strong>
                <?= $person !== null
                    ? 'تکمیل شده'
                    : 'ایجاد نشده'
                ?>
            </strong>

            <p>
                <?= $person !== null
                    ? 'اطلاعات عمومی شما در سایت قابل مدیریت است.'
                    : 'برای حساب شما هنوز پروفایل دانشگاهی ثبت نشده است.'
                ?>
            </p>

        </article>


        <article class="teacher-card">

            <span class="teacher-card__label">
                دانشکده
            </span>

            <strong>
                <?= View::escape(
                    $facultyName
                    ?? 'ثبت نشده'
                ) ?>
            </strong>

            <p>
                <?= View::escape(
                    $position
                    ?? 'سمت ثبت نشده'
                ) ?>
            </p>

        </article>

    </div>


    <div class="teacher-actions">

        <a
            href="/teacher/profile"
            class="button button--primary"
        >
            ویرایش پروفایل
        </a>

        <a
            href="/"
            class="button button--secondary"
        >
            بازگشت به سایت
        </a>

    </div>

</section>
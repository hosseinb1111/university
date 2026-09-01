<?php

declare(strict_types=1);

use App\Core\View;

$displayName =
    trim(
        (string) (
            $user['first_name']
            ?? ''
        )
        . ' '
        . (string) (
            $user['last_name']
            ?? ''
        )
    );

if (
    $displayName === ''
) {
    $displayName =
        (string) (
            $user['username']
            ?? 'کاربر'
        );
}

$facultyName =
    $person['faculty_name']
    ?? null;

$position =
    $person['position']
    ?? null;

$roleLabel =
    match (
        (string) (
            $user['role']
            ?? ''
        )
    ) {
        'super_admin' =>
            'مدیر ارشد',

        'admin' =>
            'مدیر',

        'editor' =>
            'ویراستار',

        default =>
            'عضو هیئت علمی',
    };

$profileStatus =
    $person !== null
        ? 'تکمیل شده'
        : 'ایجاد نشده';

$profileDescription =
    $person !== null
        ? 'اطلاعات عمومی شما در سایت قابل مدیریت است.'
        : 'برای حساب شما هنوز پروفایل دانشگاهی ثبت نشده است.';

$facultyDisplay =
    is_string($facultyName)
    && trim($facultyName) !== ''
        ? $facultyName
        : 'ثبت نشده';

$positionDisplay =
    is_string($position)
    && trim($position) !== ''
        ? $position
        : 'سمت ثبت نشده';
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
                از این بخش می‌توانید اطلاعات حساب و پروفایل دانشگاهی
                خود را مدیریت کنید.
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
                    (string) (
                        $user['username']
                        ?? ''
                    )
                ) ?>
            </strong>

            <p>
                نقش:
                <?= View::escape(
                    $roleLabel
                ) ?>
            </p>

        </article>


        <article class="teacher-card">

            <span class="teacher-card__label">
                پروفایل دانشگاهی
            </span>

            <strong>
                <?= View::escape(
                    $profileStatus
                ) ?>
            </strong>

            <p>
                <?= View::escape(
                    $profileDescription
                ) ?>
            </p>

        </article>


        <article class="teacher-card">

            <span class="teacher-card__label">
                دانشکده
            </span>

            <strong>
                <?= View::escape(
                    $facultyDisplay
                ) ?>
            </strong>

            <p>
                <?= View::escape(
                    $positionDisplay
                ) ?>
            </p>

        </article>

    </div>


    <div class="teacher-actions">

        <a
            href="<?= View::route(
                'teacher.profile'
            ) ?>"
            class="button button--primary"
        >
            ویرایش پروفایل
        </a>

        <a
            href="<?= View::url(
                '/'
            ) ?>"
            class="button button--secondary"
        >
            بازگشت به سایت
        </a>

    </div>

</section>
<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\View;


$user =
    is_array(
        $user ?? null
    )
        ? $user
        : [];


$errors =
    is_array(
        $errors ?? null
    )
        ? $errors
        : [];


$action =
    (string) (
        $action
        ?? ''
    );


$submitLabel =
    (string) (
        $submitLabel
        ?? 'ذخیره'
    );


$isEdit =
    isset(
        $user['id']
    );


$username =
    (string) (
        $user['username']
        ?? ''
    );


$email =
    (string) (
        $user['email']
        ?? ''
    );


$firstName =
    (string) (
        $user['first_name']
        ?? ''
    );


$lastName =
    (string) (
        $user['last_name']
        ?? ''
    );


$role =
    (string) (
        $user['role']
        ?? 'teacher'
    );


$isActive =
    (int) (
        $user['is_active']
        ?? 1
    ) === 1;

?>

<form
    method="POST"
    action="<?= View::escape(
        $action
    ) ?>"
    class="admin-user-form"
>

    <?= Csrf::field() ?>


    <section
        class="admin-user-form__panel"
    >


        <!-- =====================================================
             FORM HEADER
        ====================================================== -->

        <header
            class="admin-user-form__header"
        >

            <div
                class="admin-user-form__header-icon"
                aria-hidden="true"
            >
                👤
            </div>


            <div>

                <h2>
                    <?= $isEdit
                        ? 'اطلاعات حساب کاربری'
                        : 'اطلاعات کاربر جدید'
                    ?>
                </h2>


                <p>
                    <?= $isEdit
                        ? 'مشخصات، نقش و وضعیت این حساب را مدیریت کنید.'
                        : 'اطلاعات کاربر و سطح دسترسی او را مشخص کنید.'
                    ?>
                </p>

            </div>

        </header>


        <!-- =====================================================
             VALIDATION ERRORS
        ====================================================== -->

        <?php if (
            $errors !== []
        ): ?>

            <div
                class="admin-user-form__errors"
                role="alert"
            >

                <strong>
                    لطفاً موارد زیر را اصلاح کنید:
                </strong>


                <ul>

                    <?php foreach (
                        $errors
                        as $error
                    ): ?>

                        <li>
                            <?= View::escape(
                                (string) $error
                            ) ?>
                        </li>

                    <?php endforeach; ?>

                </ul>

            </div>

        <?php endif; ?>


        <!-- =====================================================
             FORM BODY
        ====================================================== -->

        <div
            class="admin-user-form__body"
        >


            <div
                class="admin-user-form__grid"
            >


                <!-- USERNAME -->

                <div
                    class="admin-user-form__field"
                >

                    <label
                        for="username"
                    >
                        نام کاربری

                        <span
                            class="admin-user-form__required"
                        >
                            *
                        </span>
                    </label>


                    <input
                        id="username"
                        name="username"
                        type="text"
                        class="admin-user-form__input"
                        value="<?= View::escape(
                            $username
                        ) ?>"
                        maxlength="100"
                        autocomplete="username"
                        placeholder="username"
                        dir="ltr"
                        required
                    >


                    <small
                        class="admin-user-form__help"
                    >
                        فقط حروف انگلیسی، عدد، نقطه، خط تیره و زیرخط.
                    </small>

                </div>


                <!-- EMAIL -->

                <div
                    class="admin-user-form__field"
                >

                    <label
                        for="email"
                    >
                        ایمیل
                    </label>


                    <input
                        id="email"
                        name="email"
                        type="email"
                        class="admin-user-form__input"
                        value="<?= View::escape(
                            $email
                        ) ?>"
                        autocomplete="email"
                        placeholder="example@example.com"
                        dir="ltr"
                    >

                </div>


                <!-- FIRST NAME -->

                <div
                    class="admin-user-form__field"
                >

                    <label
                        for="first_name"
                    >
                        نام
                    </label>


                    <input
                        id="first_name"
                        name="first_name"
                        type="text"
                        class="admin-user-form__input"
                        value="<?= View::escape(
                            $firstName
                        ) ?>"
                        autocomplete="given-name"
                        placeholder="نام"
                    >

                </div>


                <!-- LAST NAME -->

                <div
                    class="admin-user-form__field"
                >

                    <label
                        for="last_name"
                    >
                        نام خانوادگی
                    </label>


                    <input
                        id="last_name"
                        name="last_name"
                        type="text"
                        class="admin-user-form__input"
                        value="<?= View::escape(
                            $lastName
                        ) ?>"
                        autocomplete="family-name"
                        placeholder="نام خانوادگی"
                    >

                </div>


                <!-- ROLE -->

                <div
                    class="admin-user-form__field"
                >

                    <label
                        for="role"
                    >
                        نقش کاربری

                        <span
                            class="admin-user-form__required"
                        >
                            *
                        </span>
                    </label>


                    <select
                        id="role"
                        name="role"
                        class="admin-user-form__select"
                        required
                    >

                        <option
                            value="teacher"
                            <?= $role === 'teacher'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            عضو هیئت علمی
                        </option>


                        <option
                            value="editor"
                            <?= $role === 'editor'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            ویراستار
                        </option>


                        <option
                            value="admin"
                            <?= $role === 'admin'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            مدیر
                        </option>


                        <option
                            value="super_admin"
                            <?= $role === 'super_admin'
                                ? 'selected'
                                : ''
                            ?>
                        >
                            مدیر ارشد
                        </option>

                    </select>


                    <small
                        class="admin-user-form__help"
                    >
                        این گزینه سطح دسترسی کاربر را مشخص می‌کند.
                    </small>

                </div>


                <!-- STATUS -->

                <div
                    class="admin-user-form__field"
                >

                    <label>
                        وضعیت حساب
                    </label>


                    <label
                        class="admin-user-form__checkbox"
                    >

                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            <?= $isActive
                                ? 'checked'
                                : ''
                            ?>
                        >


                        <span>
                            حساب کاربری فعال باشد
                        </span>

                    </label>

                </div>

            </div>


            <!-- =================================================
                 PASSWORD
            ================================================== -->

            <section
                class="admin-user-form__password-section"
            >

                <div
                    class="admin-user-form__section-heading"
                >

                    <div
                        class="admin-user-form__section-heading-icon"
                        aria-hidden="true"
                    >
                        🔒
                    </div>


                    <div>

                        <strong>
                            رمز عبور
                        </strong>

                        <span>
                            <?= $isEdit
                                ? 'برای تغییر رمز عبور، فیلدها را پر کنید.'
                                : 'برای حساب جدید یک رمز عبور تعیین کنید.'
                            ?>
                        </span>

                    </div>

                </div>


                <div
                    class="admin-user-form__grid"
                >

                    <div
                        class="admin-user-form__field"
                    >

                        <label
                            for="password"
                        >
                            رمز عبور

                            <?php if (
                                !$isEdit
                            ): ?>

                                <span
                                    class="admin-user-form__required"
                                >
                                    *
                                </span>

                            <?php endif; ?>

                        </label>


                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="admin-user-form__input"
                            autocomplete="new-password"
                            placeholder="حداقل ۸ کاراکتر"
                            <?= $isEdit
                                ? ''
                                : 'required'
                            ?>
                        >


                        <small
                            class="admin-user-form__help"
                        >
                            حداقل ۸ کاراکتر.
                        </small>

                    </div>


                    <div
                        class="admin-user-form__field"
                    >

                        <label
                            for="password_confirmation"
                        >
                            تکرار رمز عبور

                            <?php if (
                                !$isEdit
                            ): ?>

                                <span
                                    class="admin-user-form__required"
                                >
                                    *
                                </span>

                            <?php endif; ?>

                        </label>


                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            class="admin-user-form__input"
                            autocomplete="new-password"
                            placeholder="رمز عبور را دوباره وارد کنید"
                            <?= $isEdit
                                ? ''
                                : 'required'
                            ?>
                        >

                    </div>

                </div>

            </section>


            <!-- =================================================
                 ACTIONS
            ================================================== -->

            <div
                class="admin-user-form__actions"
            >

                <button
                    type="submit"
                    class="admin-user-form__save"
                >
                    <?= View::escape(
                        $submitLabel
                    ) ?>
                </button>


                <a
                    href="<?= View::route(
                        'admin.users.index'
                    ) ?>"
                    class="admin-user-form__cancel"
                >
                    انصراف
                </a>

            </div>

        </div>

    </section>

</form>
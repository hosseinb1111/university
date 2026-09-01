<?php
/**
 * Drop this into admin/announcements/create.php and admin/announcements/edit.php
 * where the published_at / expires_at inputs currently live.
 *
 * $announcement['published_at'] / ['expires_at'] arrive already formatted
 * as Jalali strings by the controller (see AnnouncementController::create()
 * and ::edit()) — this view never touches conversion logic itself.
 *
 * $errors is the validation-errors array passed in from the controller.
 */
?>
<div class="form-group">
    <label for="published_at">تاریخ انتشار (شمسی)</label>
    <input
        type="text"
        id="published_at"
        name="published_at"
        dir="ltr"
        class="form-control<?= isset($errors['published_at']) ? ' is-invalid' : '' ?>"
        placeholder="1405/05/31 14:05"
        value="<?= htmlspecialchars((string) ($announcement['published_at'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
        data-jalali-datepicker
        autocomplete="off"
    >
    <small class="form-text text-muted">
        خالی بگذارید تا اطلاعیه بلافاصله پس از انتشار قابل مشاهده باشد.
    </small>
    <?php if (isset($errors['published_at'])): ?>
        <span class="invalid-feedback">
            <?= htmlspecialchars($errors['published_at'], ENT_QUOTES, 'UTF-8') ?>
        </span>
    <?php endif; ?>
</div>

<div class="form-group">
    <label for="expires_at">تاریخ انقضا (شمسی)</label>
    <input
        type="text"
        id="expires_at"
        name="expires_at"
        dir="ltr"
        class="form-control<?= isset($errors['expires_at']) ? ' is-invalid' : '' ?>"
        placeholder="1405/06/31 14:05"
        value="<?= htmlspecialchars((string) ($announcement['expires_at'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
        data-jalali-datepicker
        autocomplete="off"
    >
    <small class="form-text text-muted">
        خالی بگذارید تا اطلاعیه تاریخ انقضا نداشته باشد.
    </small>
    <?php if (isset($errors['expires_at'])): ?>
        <span class="invalid-feedback">
            <?= htmlspecialchars($errors['expires_at'], ENT_QUOTES, 'UTF-8') ?>
        </span>
    <?php endif; ?>
</div>
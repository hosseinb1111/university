<?php
/**
 * Drop this into admin/documents/create.php and admin/documents/edit.php
 * where the published_at input currently lives.
 *
 * $document['published_at'] arrives already formatted as a Jalali string
 * by DocumentController::create() / ::edit().
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
        value="<?= htmlspecialchars((string) ($document['published_at'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
        data-jalali-datepicker
        autocomplete="off"
    >
    <small class="form-text text-muted">
        خالی بگذارید تا سند بلافاصله پس از ثبت قابل دانلود باشد.
    </small>
    <?php if (isset($errors['published_at'])): ?>
        <span class="invalid-feedback">
            <?= htmlspecialchars($errors['published_at'], ENT_QUOTES, 'UTF-8') ?>
        </span>
    <?php endif; ?>
</div>
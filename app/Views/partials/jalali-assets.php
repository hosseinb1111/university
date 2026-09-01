<?php
/**
 * Persian (Jalali) datepicker assets.
 *
 * Include this ONCE in layouts/admin.php, ideally right before </body>,
 * on any admin page that has a [data-jalali-datepicker] input.
 *
 * This is progressive enhancement only: the underlying <input> is a
 * plain text field. If these assets fail to load (offline admin, CDN
 * blocked, etc.) the admin can still type a date by hand in the
 * "YYYY/MM/DD HH:mm" shape, and the server-side jalali_parse_datetime()
 * helper accepts that exact format.
 */
?>
<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css"
>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/persian-date@1.1.0/dist/persian-date.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (!window.jQuery || !jQuery.fn.persianDatepicker) {
        return;
    }

    jQuery('[data-jalali-datepicker]').each(function () {
        var $input = jQuery(this);

        // A field can opt out of the time picker with data-jalali-time="0"
        // (e.g. a date-only field), defaulting to "with time" otherwise.
        var withTime = $input.attr('data-jalali-time') !== '0';

        $input.persianDatepicker({
            format: withTime ? 'YYYY/MM/DD HH:mm' : 'YYYY/MM/DD',
            timePicker: {
                enabled: withTime
            },
            autoClose: true,
            observer: true,
            initialValue: false
        });
    });
});
</script>
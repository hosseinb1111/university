<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Jalali (Persian / Shamsi) calendar helper
|--------------------------------------------------------------------------
|
| Pure PHP, no extensions required (works even without `intl`).
| Based on the well-established "jalaali" algorithm, verified against
| 500+ random reference dates (1900-2120) plus known fixed points
| (e.g. Nowruz 1358 = 1979-03-21).
|
| Usage anywhere in the app (controllers, views, etc.) — these are
| global functions, no `use` statement needed:
|
|   jalali_date($row['created_at']);                // "1405/5/31"
|   jalali_date($row['created_at'], 'Y/m/d');        // "1405/05/31"
|   jalali_date($row['created_at'], 'j F Y');        // "31 مرداد 1405"
|   jalali_date($row['created_at'], 'Y/m/d H:i');    // "1405/05/31 14:05"
|   jalali_date_fa($row['created_at'], 'Y/m/d');     // "۱۴۰۵/۰۵/۳۱"
|
| Admin-form input (Jalali string typed/picked by an admin -> Gregorian
| string ready for a MySQL DATETIME column):
|
|   jalali_parse_datetime('1405/05/31 14:05');       // "2026-08-22 14:05:00"
|   jalali_is_valid_datetime_input($_POST['x']);     // bool, for validation
|
|--------------------------------------------------------------------------
*/

if (!function_exists('jalali_breaks')) {
    /** @return int[] */
    function jalali_breaks(): array
    {
        return [
            -61, 9, 38, 199, 426, 686, 756, 818, 1111, 1181, 1210,
            1635, 2060, 2097, 2192, 2262, 2324, 2394, 2456, 3178,
        ];
    }
}

if (!function_exists('jalali_month_names')) {
    /** @return array<int,string> */
    function jalali_month_names(): array
    {
        return [
            1 => 'فروردین', 2 => 'اردیبهشت', 3 => 'خرداد',
            4 => 'تیر', 5 => 'مرداد', 6 => 'شهریور',
            7 => 'مهر', 8 => 'آبان', 9 => 'آذر',
            10 => 'دی', 11 => 'بهمن', 12 => 'اسفند',
        ];
    }
}

if (!function_exists('jalali_div')) {
    function jalali_div(int $a, int $b): int
    {
        return intdiv($a, $b);
    }
}

if (!function_exists('jalali_mod')) {
    function jalali_mod(int $a, int $b): int
    {
        $m = $a % $b;

        return $m < 0 ? $m + abs($b) : $m;
    }
}

if (!function_exists('jalali_cal')) {
    /** @return array{leap:int,gy:int,march:int} */
    function jalali_cal(int $jy): array
    {
        $breaks = jalali_breaks();
        $bl = count($breaks);
        $gy = $jy + 621;
        $leapJ = -14;
        $jp = $breaks[0];

        if ($jy < $jp || $jy >= $breaks[$bl - 1]) {
            throw new InvalidArgumentException("Invalid Jalali year {$jy}");
        }

        $jump = 0;
        for ($i = 1; $i < $bl; $i++) {
            $jm = $breaks[$i];
            $jump = $jm - $jp;
            if ($jy < $jm) {
                break;
            }
            $leapJ = $leapJ + jalali_div($jump, 33) * 8 + jalali_div(jalali_mod($jump, 33), 4);
            $jp = $jm;
        }

        $n = $jy - $jp;

        $leapJ = $leapJ + jalali_div($n, 33) * 8 + jalali_div(jalali_mod($n, 33) + 3, 4);
        if (jalali_mod($jump, 33) === 4 && $jump - $n === 4) {
            $leapJ += 1;
        }

        $leapG = jalali_div($gy, 4) - jalali_div((jalali_div($gy, 100) + 1) * 3, 4) - 150;
        $march = 20 + $leapJ - $leapG;

        if ($jump - $n < 6) {
            $n = $n - $jump + jalali_div($jump + 4, 33) * 33;
        }
        $leap = jalali_mod(jalali_mod($n + 1, 33) - 1, 4);
        if ($leap === -1) {
            $leap = 4;
        }

        return ['leap' => $leap, 'gy' => $gy, 'march' => $march];
    }
}

if (!function_exists('jalali_is_leap_year')) {
    function jalali_is_leap_year(int $jy): bool
    {
        return jalali_cal($jy)['leap'] === 0;
    }
}

if (!function_exists('jalali_g2d')) {
    function jalali_g2d(int $gy, int $gm, int $gd): int
    {
        $d = jalali_div(($gy + jalali_div($gm - 8, 6) + 100100) * 1461, 4)
            + jalali_div(153 * jalali_mod($gm + 9, 12) + 2, 5)
            + $gd - 34840408;
        $d = $d - jalali_div(jalali_div($gy + jalali_div($gm - 8, 6) + 100100, 100) * 3, 4) + 752;

        return $d;
    }
}

if (!function_exists('jalali_d2g')) {
    /** @return array{gy:int,gm:int,gd:int} */
    function jalali_d2g(int $jdn): array
    {
        $j = 4 * $jdn + 139361631;
        $j = $j + jalali_div(jalali_div(4 * $jdn + 183187720, 146097) * 3, 4) * 4 - 3908;
        $i = jalali_div(jalali_mod($j, 1461), 4) * 5 + 308;
        $gd = jalali_div(jalali_mod($i, 153), 5) + 1;
        $gm = jalali_mod(jalali_div($i, 153), 12) + 1;
        $gy = jalali_div($j, 1461) - 100100 + jalali_div(8 - $gm, 6);

        return ['gy' => $gy, 'gm' => $gm, 'gd' => $gd];
    }
}

if (!function_exists('jalali_d2j')) {
    /** @return array{0:int,1:int,2:int} */
    function jalali_d2j(int $jdn): array
    {
        $gy = jalali_d2g($jdn)['gy'];
        $jy = $gy - 621;
        $r = jalali_cal($jy);
        $jdn1f = jalali_g2d($r['gy'], 3, $r['march']);

        $k = $jdn - $jdn1f;

        if ($k >= 0) {
            if ($k <= 185) {
                $jm = 1 + jalali_div($k, 31);
                $jd = jalali_mod($k, 31) + 1;

                return [$jy, $jm, $jd];
            }
            $k -= 186;
        } else {
            $jy -= 1;
            $k += 179;
            if (jalali_is_leap_year($jy)) {
                $k += 1;
            }
        }

        $jm = 7 + jalali_div($k, 30);
        $jd = jalali_mod($k, 30) + 1;

        return [$jy, $jm, $jd];
    }
}

if (!function_exists('gregorian_to_jalali')) {
    /**
     * Raw conversion: Gregorian y/m/d -> [jy, jm, jd].
     *
     * @return array{0:int,1:int,2:int}
     */
    function gregorian_to_jalali(int $gy, int $gm, int $gd): array
    {
        return jalali_d2j(jalali_g2d($gy, $gm, $gd));
    }
}

if (!function_exists('jalali_to_gregorian')) {
    /**
     * Convert a Jalali date back to Gregorian [gy, gm, gd].
     * Useful for admin forms where an editor picks/types a Jalali date
     * that needs to be saved as a normal Gregorian DATETIME in the DB.
     *
     * @return array{0:int,1:int,2:int}
     */
    function jalali_to_gregorian(int $jy, int $jm, int $jd): array
    {
        $r = jalali_cal($jy);
        $jdn = jalali_g2d($r['gy'], 3, $r['march']) + ($jm - 1) * 31 - jalali_div($jm, 7) * ($jm - 7) + $jd - 1;
        $g = jalali_d2g($jdn);

        return [$g['gy'], $g['gm'], $g['gd']];
    }
}

if (!function_exists('jalali_extract_parts')) {
    /** @return array{0:int,1:int,2:int,3:int,4:int,5:int}|null [gy, gm, gd, H, i, s] */
    function jalali_extract_parts(string|DateTimeInterface|null $date): ?array
    {
        if ($date === null || $date === '') {
            return null;
        }

        if ($date instanceof DateTimeInterface) {
            return [
                (int) $date->format('Y'), (int) $date->format('n'), (int) $date->format('j'),
                (int) $date->format('H'), (int) $date->format('i'), (int) $date->format('s'),
            ];
        }

        $timestamp = strtotime($date);
        if ($timestamp === false) {
            return null;
        }

        return [
            (int) date('Y', $timestamp), (int) date('n', $timestamp), (int) date('j', $timestamp),
            (int) date('H', $timestamp), (int) date('i', $timestamp), (int) date('s', $timestamp),
        ];
    }
}

if (!function_exists('jalali_date')) {
    /**
     * Format a Gregorian date/time as a Jalali string.
     *
     * Accepts anything strtotime() understands ('2026-08-22', a DB DATETIME
     * string like '2026-08-22 14:05:00', etc.) or a DateTimeInterface.
     * Returns '' for empty/invalid input.
     *
     * Supported format tokens (mirrors PHP's date() where practical):
     *   Y  4-digit Jalali year        (e.g. 1405)
     *   y  2-digit Jalali year        (e.g. 05)
     *   m  2-digit month, zero-padded (e.g. 05)
     *   n  month, no padding          (e.g. 5)
     *   F  full Persian month name    (e.g. مرداد)
     *   d  2-digit day, zero-padded   (e.g. 02)
     *   j  day, no padding            (e.g. 2)
     *   H  24h hour, zero-padded
     *   i  minutes, zero-padded
     *   s  seconds, zero-padded
     */
    function jalali_date(string|DateTimeInterface|null $date, string $format = 'Y/n/j'): string
    {
        $parts = jalali_extract_parts($date);
        if ($parts === null) {
            return '';
        }

        [$gy, $gm, $gd, $H, $i, $s] = $parts;
        [$jy, $jm, $jd] = gregorian_to_jalali($gy, $gm, $gd);

        $months = jalali_month_names();

        $replacements = [
            'Y' => (string) $jy,
            'y' => str_pad((string) ($jy % 100), 2, '0', STR_PAD_LEFT),
            'm' => str_pad((string) $jm, 2, '0', STR_PAD_LEFT),
            'n' => (string) $jm,
            'F' => $months[$jm],
            'd' => str_pad((string) $jd, 2, '0', STR_PAD_LEFT),
            'j' => (string) $jd,
            'H' => str_pad((string) $H, 2, '0', STR_PAD_LEFT),
            'i' => str_pad((string) $i, 2, '0', STR_PAD_LEFT),
            's' => str_pad((string) $s, 2, '0', STR_PAD_LEFT),
        ];

        return strtr($format, $replacements);
    }
}

if (!function_exists('jalali_date_fa')) {
    /** Same as jalali_date(), but renders digits using Persian numerals (۰-۹). */
    function jalali_date_fa(string|DateTimeInterface|null $date, string $format = 'Y/n/j'): string
    {
        $latin = jalali_date($date, $format);
        if ($latin === '') {
            return '';
        }

        $digits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

        return strtr($latin, array_combine(
            ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
            $digits
        ));
    }
}

/*
|--------------------------------------------------------------------------
| Admin-form input helpers (Jalali string -> Gregorian for storage)
|--------------------------------------------------------------------------
*/

if (!function_exists('jalali_to_latin_digits')) {
    /** Normalize Persian/Arabic-Indic digits (and Arabic/Persian separators) to plain ASCII. */
    function jalali_to_latin_digits(string $value): string
    {
        static $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        static $arabic  = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        static $latin   = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        $value = str_replace($persian, $latin, $value);

        return str_replace($arabic, $latin, $value);
    }
}

if (!function_exists('jalali_parse_datetime')) {
    /**
     * Parse a Jalali date/datetime string typed or picked by an admin
     * (e.g. "1405/05/31", "1405-05-31 14:05", "۱۴۰۵/۰۵/۳۱ ۱۴:۰۵") into a
     * Gregorian 'Y-m-d H:i:s' string suitable for a MySQL DATETIME column.
     *
     * Returns null when the input is empty, malformed, or not a real
     * calendar date (e.g. day 30 of a 29-day Esfand).
     */
    function jalali_parse_datetime(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim(jalali_to_latin_digits($value));
        if ($value === '') {
            return null;
        }

        if (!preg_match(
            '/^(\d{3,4})[\/\-](\d{1,2})[\/\-](\d{1,2})(?:[ T](\d{1,2}):(\d{1,2})(?::(\d{1,2}))?)?$/',
            $value,
            $m
        )) {
            return null;
        }

        $jy = (int) $m[1];
        $jm = (int) $m[2];
        $jd = (int) $m[3];
        $H  = isset($m[4]) ? (int) $m[4] : 0;
        $i  = isset($m[5]) ? (int) $m[5] : 0;
        $s  = isset($m[6]) ? (int) $m[6] : 0;

        if ($jm < 1 || $jm > 12 || $jd < 1 || $jd > 31 || $H > 23 || $i > 59 || $s > 59) {
            return null;
        }

        try {
            [$gy, $gm, $gd] = jalali_to_gregorian($jy, $jm, $jd);
        } catch (InvalidArgumentException) {
            // Year out of the supported break-point range.
            return null;
        }

        // Round-trip check: rejects real-looking-but-invalid dates such
        // as 1405/12/30 when 1405 is not a Jalali leap year.
        [$backJy, $backJm, $backJd] = gregorian_to_jalali($gy, $gm, $gd);
        if ($backJy !== $jy || $backJm !== $jm || $backJd !== $jd) {
            return null;
        }

        return sprintf('%04d-%02d-%02d %02d:%02d:%02d', $gy, $gm, $gd, $H, $i, $s);
    }
}

if (!function_exists('jalali_is_valid_datetime_input')) {
    /**
     * Validation helper: true if $value is empty (nullable field, allowed)
     * or a parseable Jalali date/datetime string.
     */
    function jalali_is_valid_datetime_input(?string $value): bool
    {
        if ($value === null || trim($value) === '') {
            return true;
        }

        return jalali_parse_datetime($value) !== null;
    }
}
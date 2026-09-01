/**
 * Lightweight Jalali (Persian/Shamsi) date & time picker.
 * No dependencies. Attaches to any <input data-jalali-picker>.
 *
 * The input itself stays a plain text field holding a Jalali string
 * ("1405/05/31 14:05"). This script only adds a popup calendar as
 * progressive enhancement — an admin can still type the value by hand,
 * and the server (jalali_parse_datetime() in app/Helpers/jalali.php)
 * is the source of truth for validating/converting it.
 *
 * Conversion math mirrors app/Helpers/jalali.php exactly (same
 * "jalaali" algorithm, same break-points table) so the calendar grid
 * (days-per-month, leap years, "today" marker) matches the backend.
 *
 * Optional attributes on the input:
 *   data-jalali-time="0"   -> date-only picker, no hour/minute step
 */
(function () {
    'use strict';

    var MONTH_NAMES = [
        'فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور',
        'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'
    ];

    // Persian week starts Saturday.
    var WEEKDAY_NAMES = ['ش', 'ی', 'د', 'س', 'چ', 'پ', 'ج'];

    var BREAKS = [
        -61, 9, 38, 199, 426, 686, 756, 818, 1111, 1181, 1210,
        1635, 2060, 2097, 2192, 2262, 2324, 2394, 2456, 3178
    ];

    function div(a, b) {
        return Math.trunc(a / b);
    }

    function mod(a, b) {
        var m = a % b;
        return m < 0 ? m + Math.abs(b) : m;
    }

    function jalCal(jy) {
        var bl = BREAKS.length;
        var gy = jy + 621;
        var leapJ = -14;
        var jp = BREAKS[0];

        if (jy < jp || jy >= BREAKS[bl - 1]) {
            throw new Error('Invalid Jalali year ' + jy);
        }

        var jump = 0;
        var i;
        for (i = 1; i < bl; i++) {
            var jm = BREAKS[i];
            jump = jm - jp;
            if (jy < jm) break;
            leapJ = leapJ + div(jump, 33) * 8 + div(mod(jump, 33), 4);
            jp = jm;
        }

        var n = jy - jp;
        leapJ = leapJ + div(n, 33) * 8 + div(mod(n, 33) + 3, 4);
        if (mod(jump, 33) === 4 && jump - n === 4) leapJ += 1;

        var leapG = div(gy, 4) - div((div(gy, 100) + 1) * 3, 4) - 150;
        var march = 20 + leapJ - leapG;

        if (jump - n < 6) n = n - jump + div(jump + 4, 33) * 33;
        var leap = mod(mod(n + 1, 33) - 1, 4);
        if (leap === -1) leap = 4;

        return { leap: leap, gy: gy, march: march };
    }

    function isLeapYear(jy) {
        return jalCal(jy).leap === 0;
    }

    function g2d(gy, gm, gd) {
        var d = div((gy + div(gm - 8, 6) + 100100) * 1461, 4)
            + div(153 * mod(gm + 9, 12) + 2, 5)
            + gd - 34840408;
        d = d - div(div(gy + div(gm - 8, 6) + 100100, 100) * 3, 4) + 752;
        return d;
    }

    function d2g(jdn) {
        var j = 4 * jdn + 139361631;
        j = j + div(div(4 * jdn + 183187720, 146097) * 3, 4) * 4 - 3908;
        var i = div(mod(j, 1461), 4) * 5 + 308;
        var gd = div(mod(i, 153), 5) + 1;
        var gm = mod(div(i, 153), 12) + 1;
        var gy = div(j, 1461) - 100100 + div(8 - gm, 6);
        return { gy: gy, gm: gm, gd: gd };
    }

    function gregorianToJalali(gy, gm, gd) {
        var jdn = g2d(gy, gm, gd);
        var gy2 = d2g(jdn).gy;
        var jy = gy2 - 621;
        var r = jalCal(jy);
        var jdn1f = g2d(r.gy, 3, r.march);
        var k = jdn - jdn1f;

        if (k >= 0) {
            if (k <= 185) {
                return [jy, 1 + div(k, 31), mod(k, 31) + 1];
            }
            k -= 186;
        } else {
            jy -= 1;
            k += 179;
            if (isLeapYear(jy)) k += 1;
        }

        return [jy, 7 + div(k, 30), mod(k, 30) + 1];
    }

    function jalaliToGregorian(jy, jm, jd) {
        var r = jalCal(jy);
        var jdn = g2d(r.gy, 3, r.march) + (jm - 1) * 31 - div(jm, 7) * (jm - 7) + jd - 1;
        var g = d2g(jdn);
        return [g.gy, g.gm, g.gd];
    }

    function daysInJalaliMonth(jy, jm) {
        if (jm <= 6) return 31;
        if (jm <= 11) return 30;
        return isLeapYear(jy) ? 30 : 29;
    }

    // 0 = Saturday ... 6 = Friday, to match WEEKDAY_NAMES.
    function jalaliWeekday(jy, jm, jd) {
        var g = jalaliToGregorian(jy, jm, jd);
        var jsDay = new Date(g[0], g[1] - 1, g[2]).getDay(); // 0 = Sunday
        return (jsDay + 1) % 7;
    }

    function todayJalali() {
        var now = new Date();
        return gregorianToJalali(now.getFullYear(), now.getMonth() + 1, now.getDate());
    }

    function pad2(n) {
        n = String(n);
        return n.length < 2 ? '0' + n : n;
    }

    function toLatinDigits(value) {
        var persian = '۰۱۲۳۴۵۶۷۸۹';
        return String(value).replace(/[۰-۹]/g, function (ch) {
            return String(persian.indexOf(ch));
        });
    }

    /**
     * Parse the input's current text ("1405/05/31 14:05" or "1405/05/31")
     * into { jy, jm, jd, h, i } or null if it doesn't parse. Used to seed
     * the calendar with whatever the admin already typed/picked.
     */
    function parseInputValue(value) {
        value = toLatinDigits(value || '').trim();
        var match = value.match(/^(\d{3,4})[\/\-](\d{1,2})[\/\-](\d{1,2})(?:[ T](\d{1,2}):(\d{1,2}))?$/);
        if (!match) return null;

        return {
            jy: parseInt(match[1], 10),
            jm: parseInt(match[2], 10),
            jd: parseInt(match[3], 10),
            h: match[4] !== undefined ? parseInt(match[4], 10) : 0,
            i: match[5] !== undefined ? parseInt(match[5], 10) : 0
        };
    }

    function createPicker(input) {
        var withTime = input.getAttribute('data-jalali-time') !== '0';

        var popup = document.createElement('div');
        popup.className = 'jdp-popup';
        popup.setAttribute('role', 'dialog');
        popup.hidden = true;

        var header = document.createElement('div');
        header.className = 'jdp-header';

        var prevYearBtn = button('«', 'jdp-nav jdp-nav--year');
        var prevMonthBtn = button('‹', 'jdp-nav');
        var label = document.createElement('div');
        label.className = 'jdp-label';
        var nextMonthBtn = button('›', 'jdp-nav');
        var nextYearBtn = button('»', 'jdp-nav jdp-nav--year');

        header.appendChild(prevYearBtn);
        header.appendChild(prevMonthBtn);
        header.appendChild(label);
        header.appendChild(nextMonthBtn);
        header.appendChild(nextYearBtn);

        var weekdayRow = document.createElement('div');
        weekdayRow.className = 'jdp-weekdays';
        WEEKDAY_NAMES.forEach(function (name) {
            var cell = document.createElement('span');
            cell.textContent = name;
            weekdayRow.appendChild(cell);
        });

        var grid = document.createElement('div');
        grid.className = 'jdp-grid';

        popup.appendChild(header);
        popup.appendChild(weekdayRow);
        popup.appendChild(grid);

        var timeRow = null;
        var hourInput = null;
        var minuteInput = null;

        if (withTime) {
            timeRow = document.createElement('div');
            timeRow.className = 'jdp-time';

            hourInput = timeInput(23, 'ساعت');
            minuteInput = timeInput(59, 'دقیقه');

            var sep = document.createElement('span');
            sep.className = 'jdp-time-sep';
            sep.textContent = ':';

            timeRow.appendChild(hourInput);
            timeRow.appendChild(sep);
            timeRow.appendChild(minuteInput);

            popup.appendChild(timeRow);
        }

        var footer = document.createElement('div');
        footer.className = 'jdp-footer';

        var todayBtn = button('امروز', 'jdp-action');
        var clearBtn = button('پاک کردن', 'jdp-action jdp-action--muted');
        var confirmBtn = button('تأیید', 'jdp-action jdp-action--primary');

        footer.appendChild(todayBtn);
        footer.appendChild(clearBtn);
        footer.appendChild(confirmBtn);
        popup.appendChild(footer);

        document.body.appendChild(popup);

        var state = todayJalali();
        var viewYear = state[0];
        var viewMonth = state[1];
        var selected = null; // { jy, jm, jd, h, i }

        function button(text, className) {
            var el = document.createElement('button');
            el.type = 'button';
            el.className = className;
            el.textContent = text;
            return el;
        }

        function timeInput(max, ariaLabel) {
            var el = document.createElement('input');
            el.type = 'number';
            el.min = '0';
            el.max = String(max);
            el.className = 'jdp-time-input';
            el.setAttribute('aria-label', ariaLabel);
            el.value = '00';
            return el;
        }

        function render() {
            label.textContent = MONTH_NAMES[viewMonth - 1] + ' ' + viewYear;
            grid.innerHTML = '';

            var firstWeekday = jalaliWeekday(viewYear, viewMonth, 1);
            var totalDays = daysInJalaliMonth(viewYear, viewMonth);
            var today = todayJalali();

            var i;
            for (i = 0; i < firstWeekday; i++) {
                var blank = document.createElement('span');
                blank.className = 'jdp-day jdp-day--blank';
                grid.appendChild(blank);
            }

            for (var day = 1; day <= totalDays; day++) {
                var cell = document.createElement('button');
                cell.type = 'button';
                cell.className = 'jdp-day';
                cell.textContent = String(day);

                if (viewYear === today[0] && viewMonth === today[1] && day === today[2]) {
                    cell.classList.add('jdp-day--today');
                }

                if (
                    selected
                    && selected.jy === viewYear
                    && selected.jm === viewMonth
                    && selected.jd === day
                ) {
                    cell.classList.add('jdp-day--selected');
                }

                (function (d) {
                    cell.addEventListener('click', function () {
                        selected = {
                            jy: viewYear,
                            jm: viewMonth,
                            jd: d,
                            h: withTime ? clampInt(hourInput.value, 0, 23) : 0,
                            i: withTime ? clampInt(minuteInput.value, 0, 59) : 0
                        };
                        render();
                        if (!withTime) {
                            apply();
                            close();
                        }
                    });
                })(day);

                grid.appendChild(cell);
            }
        }

        function clampInt(value, min, max) {
            var n = parseInt(toLatinDigits(value), 10);
            if (isNaN(n)) n = min;
            return Math.min(max, Math.max(min, n));
        }

        function apply() {
            if (!selected) return;

            var value = selected.jy + '/' + pad2(selected.jm) + '/' + pad2(selected.jd);
            if (withTime) {
                value += ' ' + pad2(selected.h) + ':' + pad2(selected.i);
            }

            input.value = value;
            input.dispatchEvent(new Event('input', { bubbles: true }));
            input.dispatchEvent(new Event('change', { bubbles: true }));
        }

        function seedFromInput() {
            var parsed = parseInputValue(input.value);

            if (parsed) {
                selected = { jy: parsed.jy, jm: parsed.jm, jd: parsed.jd, h: parsed.h, i: parsed.i };
                viewYear = parsed.jy;
                viewMonth = parsed.jm;
            } else {
                selected = null;
                var t = todayJalali();
                viewYear = t[0];
                viewMonth = t[1];
            }

            if (withTime) {
                hourInput.value = pad2(selected ? selected.h : 0);
                minuteInput.value = pad2(selected ? selected.i : 0);
            }
        }

        function open() {
            seedFromInput();
            render();
            position();
            popup.hidden = false;
            document.addEventListener('mousedown', onOutsideClick, true);
        }

        function close() {
            popup.hidden = true;
            document.removeEventListener('mousedown', onOutsideClick, true);
        }

        function onOutsideClick(event) {
            if (popup.contains(event.target) || event.target === input) return;
            close();
        }

        function position() {
            var rect = input.getBoundingClientRect();
            var top = rect.bottom + window.scrollY + 4;
            var left = rect.left + window.scrollX;

            popup.style.top = top + 'px';
            popup.style.left = left + 'px';

            // Keep the popup on-screen if the field sits near the right edge.
            var popupWidth = popup.offsetWidth || 280;
            var viewportWidth = document.documentElement.clientWidth;
            if (left + popupWidth > viewportWidth - 8) {
                popup.style.left = Math.max(8, viewportWidth - popupWidth - 8) + 'px';
            }
        }

        prevMonthBtn.addEventListener('click', function () {
            viewMonth -= 1;
            if (viewMonth < 1) { viewMonth = 12; viewYear -= 1; }
            render();
        });

        nextMonthBtn.addEventListener('click', function () {
            viewMonth += 1;
            if (viewMonth > 12) { viewMonth = 1; viewYear += 1; }
            render();
        });

        prevYearBtn.addEventListener('click', function () {
            viewYear -= 1;
            render();
        });

        nextYearBtn.addEventListener('click', function () {
            viewYear += 1;
            render();
        });

        todayBtn.addEventListener('click', function () {
            var t = todayJalali();
            viewYear = t[0];
            viewMonth = t[1];
            selected = {
                jy: t[0], jm: t[1], jd: t[2],
                h: withTime ? clampInt(hourInput.value, 0, 23) : 0,
                i: withTime ? clampInt(minuteInput.value, 0, 59) : 0
            };
            render();
        });

        clearBtn.addEventListener('click', function () {
            selected = null;
            input.value = '';
            input.dispatchEvent(new Event('input', { bubbles: true }));
            input.dispatchEvent(new Event('change', { bubbles: true }));
            close();
        });

        confirmBtn.addEventListener('click', function () {
            if (!selected) {
                var t = todayJalali();
                selected = {
                    jy: t[0], jm: t[1], jd: t[2],
                    h: withTime ? clampInt(hourInput.value, 0, 23) : 0,
                    i: withTime ? clampInt(minuteInput.value, 0, 59) : 0
                };
            }
            apply();
            close();
        });

        input.addEventListener('focus', open);
        input.addEventListener('click', open);

        window.addEventListener('resize', function () {
            if (!popup.hidden) position();
        });
        window.addEventListener('scroll', function () {
            if (!popup.hidden) position();
        }, true);
    }

    document.addEventListener('DOMContentLoaded', function () {
        var inputs = document.querySelectorAll('input[data-jalali-picker]');
        inputs.forEach(function (input) {
            createPicker(input);
        });
    });
})();
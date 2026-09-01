'use strict';


/*
|--------------------------------------------------------------------------
| Sadra University — Public JavaScript
|--------------------------------------------------------------------------
|
| Contains:
|
|   - Shared theme system
|   - Theme-aware public logo
|   - Mobile public navigation
|   - Homepage slider
|
| The theme system is intentionally initialized first because the slider
| and navigation may return early on pages where they do not exist.
|
|--------------------------------------------------------------------------
*/


document.addEventListener(
    'DOMContentLoaded',
    function () {


        /*
        |--------------------------------------------------------------------------
        | Theme
        |--------------------------------------------------------------------------
        |
        | The Persian and English public sites share the same theme
        | preference:
        |
        |     localStorage key: sadra-theme
        |
        | Valid values:
        |
        |     light
        |     dark
        |
        | The HTML element is the live source of truth:
        |
        |     <html data-theme="light">
        |     <html data-theme="dark">
        |
        |--------------------------------------------------------------------------
        */


        const themeStorageKey =
            'sadra-theme';


        /*
        |--------------------------------------------------------------------------
        | Theme helpers
        |--------------------------------------------------------------------------
        */


        const isValidTheme =
            function (
                theme
            ) {

                return (
                    theme === 'light'
                    || theme === 'dark'
                );

            };


        /*
        |--------------------------------------------------------------------------
        | Read theme from localStorage
        |--------------------------------------------------------------------------
        */

        const getStoredTheme =
            function () {

                try {

                    const storedTheme =
                        localStorage.getItem(
                            themeStorageKey
                        );


                    if (
                        isValidTheme(
                            storedTheme
                        )
                    ) {

                        return storedTheme;

                    }

                } catch (
                    error
                ) {

                    /*
                     * localStorage may be unavailable because of:
                     *
                     * - private browsing restrictions
                     * - disabled storage
                     * - browser security policy
                     */

                }


                return null;

            };


        /*
        |--------------------------------------------------------------------------
        | Read current theme from HTML
        |--------------------------------------------------------------------------
        */

        const getCurrentTheme =
            function () {

                const currentTheme =
                    document.documentElement.getAttribute(
                        'data-theme'
                    );


                return isValidTheme(
                    currentTheme
                )
                    ? currentTheme
                    : 'light';

            };


        /*
        |--------------------------------------------------------------------------
        | Detect system theme
        |--------------------------------------------------------------------------
        */

        const getSystemTheme =
            function () {

                try {

                    if (
                        window.matchMedia
                        && window.matchMedia(
                            '(prefers-color-scheme: dark)'
                        ).matches
                    ) {

                        return 'dark';

                    }

                } catch (
                    error
                ) {

                    /*
                     * Ignore matchMedia failures.
                     */

                }


                return 'light';

            };


        /*
        |--------------------------------------------------------------------------
        | Update theme logos
        |--------------------------------------------------------------------------
        |
        | Both Persian and English layouts can use:
        |
        |     data-theme-logo
        |
        | with:
        |
        |     data-theme-logo-light="..."
        |     data-theme-logo-dark="..."
        |
        | This allows both languages to use the exact same two image files.
        |
        |--------------------------------------------------------------------------
        */

        const updateThemeLogos =
            function (
                theme
            ) {

                const isDark =
                    theme === 'dark';


                document
                    .querySelectorAll(
                        '[data-theme-logo]'
                    )
                    .forEach(
                        function (
                            logo
                        ) {

                            const lightLogo =
                                logo.getAttribute(
                                    'data-theme-logo-light'
                                );


                            const darkLogo =
                                logo.getAttribute(
                                    'data-theme-logo-dark'
                                );


                            /*
                             * A theme-specific logo is required only when
                             * that corresponding asset exists.
                             */

                            const nextLogo =
                                isDark
                                    ? darkLogo
                                    : lightLogo;


                            if (
                                typeof nextLogo !== 'string'
                                || nextLogo.trim() === ''
                            ) {

                                return;

                            }


                            /*
                             * Avoid assigning the same URL repeatedly.
                             */

                            if (
                                logo.getAttribute(
                                    'src'
                                ) !== nextLogo
                            ) {

                                logo.setAttribute(
                                    'src',
                                    nextLogo
                                );

                            }

                        }
                    );

            };


        /*
        |--------------------------------------------------------------------------
        | Update theme controls
        |--------------------------------------------------------------------------
        */

        const updateThemeControls =
            function (
                theme
            ) {

                const isDark =
                    theme === 'dark';


                document
                    .querySelectorAll(
                        '[data-theme-toggle]'
                    )
                    .forEach(
                        function (
                            button
                        ) {

                            button.setAttribute(
                                'aria-pressed',
                                isDark
                                    ? 'true'
                                    : 'false'
                            );


                            button.setAttribute(
                                'aria-label',
                                isDark
                                    ? 'فعال کردن حالت روشن'
                                    : 'فعال کردن حالت تیره'
                            );


                            button.setAttribute(
                                'title',
                                isDark
                                    ? 'حالت روشن'
                                    : 'حالت تیره'
                            );


                            const icon =
                                button.querySelector(
                                    '[data-theme-icon]'
                                );


                            if (
                                icon
                            ) {

                                icon.textContent =
                                    isDark
                                        ? '☀'
                                        : '☾';

                            }

                        }
                    );

            };


        /*
        |--------------------------------------------------------------------------
        | Update browser theme-color
        |--------------------------------------------------------------------------
        */

        const updateThemeColor =
            function (
                theme
            ) {

                const themeColorMeta =
                    document.getElementById(
                        'theme-color-meta'
                    );


                if (
                    !themeColorMeta
                ) {

                    return;

                }


                themeColorMeta.setAttribute(
                    'content',
                    theme === 'dark'
                        ? '#101317'
                        : '#ffffff'
                );

            };


        /*
        |--------------------------------------------------------------------------
        | Save theme
        |--------------------------------------------------------------------------
        */

        const saveTheme =
            function (
                theme
            ) {

                try {

                    localStorage.setItem(
                        themeStorageKey,
                        theme
                    );


                    return true;

                } catch (
                    error
                ) {

                    /*
                     * The theme still works for the current page even when
                     * persistent storage is unavailable.
                     */

                    return false;

                }

            };


        /*
        |--------------------------------------------------------------------------
        | Apply theme
        |--------------------------------------------------------------------------
        */

        const applyTheme =
            function (
                theme,
                persist = true
            ) {

                const normalizedTheme =
                    theme === 'dark'
                        ? 'dark'
                        : 'light';


                /*
                 * 1. Update the actual document theme.
                 */

                document.documentElement.setAttribute(
                    'data-theme',
                    normalizedTheme
                );


                /*
                 * 2. Persist the preference.
                 */

                if (
                    persist
                ) {

                    saveTheme(
                        normalizedTheme
                    );

                }


                /*
                 * 3. Update theme-specific logos.
                 */

                updateThemeLogos(
                    normalizedTheme
                );


                /*
                 * 4. Keep buttons synchronized.
                 */

                updateThemeControls(
                    normalizedTheme
                );


                /*
                 * 5. Keep browser chrome synchronized.
                 */

                updateThemeColor(
                    normalizedTheme
                );


                return normalizedTheme;

            };


        /*
        |--------------------------------------------------------------------------
        | Initialize theme
        |--------------------------------------------------------------------------
        |
        | Priority:
        |
        |   1. Existing HTML data-theme, if supplied by the layout.
        |   2. localStorage.
        |   3. System preference.
        |
        |--------------------------------------------------------------------------
        */

        const htmlTheme =
            document.documentElement.getAttribute(
                'data-theme'
            );


        const storedTheme =
            getStoredTheme();


        let initialTheme;


        if (
            isValidTheme(
                htmlTheme
            )
        ) {

            initialTheme =
                htmlTheme;

        } else if (
            isValidTheme(
                storedTheme
            )
        ) {

            initialTheme =
                storedTheme;

        } else {

            initialTheme =
                getSystemTheme();

        }


        /*
        |--------------------------------------------------------------------------
        | Synchronize everything
        |--------------------------------------------------------------------------
        */

        applyTheme(
            initialTheme,
            false
        );


        /*
        |--------------------------------------------------------------------------
        | Theme toggle
        |--------------------------------------------------------------------------
        |
        | Event delegation allows any current or future
        | [data-theme-toggle] element to use the same logic.
        |
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            function (
                event
            ) {

                const target =
                    event.target;


                if (
                    !(target instanceof Element)
                ) {

                    return;

                }


                const themeToggle =
                    target.closest(
                        '[data-theme-toggle]'
                    );


                if (
                    !themeToggle
                ) {

                    return;

                }


                /*
                 * Use the live DOM state.
                 *
                 * This avoids the old "press twice" problem caused by
                 * comparing against a stale localStorage value.
                 */

                const currentTheme =
                    getCurrentTheme();


                const nextTheme =
                    currentTheme === 'dark'
                        ? 'light'
                        : 'dark';


                applyTheme(
                    nextTheme,
                    true
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Synchronize theme between browser tabs
        |--------------------------------------------------------------------------
        */

        window.addEventListener(
            'storage',
            function (
                event
            ) {

                if (
                    event.key !== themeStorageKey
                ) {

                    return;

                }


                if (
                    !isValidTheme(
                        event.newValue
                    )
                ) {

                    return;

                }


                /*
                 * Another tab already wrote to storage.
                 * Therefore do not write again here.
                 */

                applyTheme(
                    event.newValue,
                    false
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Mobile public navigation
        |--------------------------------------------------------------------------
        */


        const navigationToggle =
            document.getElementById(
                'site-nav-toggle'
            );


        const navigation =
            document.getElementById(
                'site-main-navigation'
            );


        const navigationBackdrop =
            document.getElementById(
                'site-nav-backdrop'
            );


        const navigationClose =
            document.getElementById(
                'site-nav-close'
            );


        /*
        |--------------------------------------------------------------------------
        | Navigation helpers
        |--------------------------------------------------------------------------
        */


        const isNavigationMobile =
            function () {

                return window.matchMedia(
                    '(max-width: 900px)'
                ).matches;

            };


        /*
        |--------------------------------------------------------------------------
        | Open navigation
        |--------------------------------------------------------------------------
        */

        const openNavigation =
            function () {

                if (
                    !navigation
                    || !navigationToggle
                    || !isNavigationMobile()
                ) {

                    return;

                }


                navigation.classList.add(
                    'site-nav--open'
                );


                document.body.classList.add(
                    'site-nav-open'
                );


                document.documentElement.classList.add(
                    'site-nav-open'
                );


                navigationToggle.setAttribute(
                    'aria-expanded',
                    'true'
                );


                navigationToggle.setAttribute(
                    'aria-label',
                    'بستن منوی سایت'
                );

            };


        /*
        |--------------------------------------------------------------------------
        | Close navigation
        |--------------------------------------------------------------------------
        */

        const closeNavigation =
            function () {

                if (
                    navigation
                ) {

                    navigation.classList.remove(
                        'site-nav--open'
                    );

                }


                document.body.classList.remove(
                    'site-nav-open'
                );


                document.documentElement.classList.remove(
                    'site-nav-open'
                );


                if (
                    navigationToggle
                ) {

                    navigationToggle.setAttribute(
                        'aria-expanded',
                        'false'
                    );


                    navigationToggle.setAttribute(
                        'aria-label',
                        'باز کردن منوی سایت'
                    );

                }

            };


        /*
        |--------------------------------------------------------------------------
        | Toggle navigation
        |--------------------------------------------------------------------------
        */

        const toggleNavigation =
            function () {

                if (
                    !navigation
                    || !navigationToggle
                ) {

                    return;

                }


                const isOpen =
                    navigation.classList.contains(
                        'site-nav--open'
                    );


                if (
                    isOpen
                ) {

                    closeNavigation();

                } else {

                    openNavigation();

                }

            };


        /*
        |--------------------------------------------------------------------------
        | Hamburger button
        |--------------------------------------------------------------------------
        */

        if (
            navigationToggle
            && navigation
        ) {

            navigationToggle.addEventListener(
                'click',
                function () {

                    toggleNavigation();

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Dedicated close button
        |--------------------------------------------------------------------------
        */

        if (
            navigationClose
        ) {

            navigationClose.addEventListener(
                'click',
                function () {

                    closeNavigation();

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Backdrop
        |--------------------------------------------------------------------------
        */

        if (
            navigationBackdrop
        ) {

            navigationBackdrop.addEventListener(
                'click',
                function () {

                    closeNavigation();

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Close after clicking navigation links
        |--------------------------------------------------------------------------
        */

        if (
            navigation
        ) {

            navigation
                .querySelectorAll(
                    'a'
                )
                .forEach(
                    function (
                        link
                    ) {

                        link.addEventListener(
                            'click',
                            function () {

                                if (
                                    isNavigationMobile()
                                ) {

                                    closeNavigation();

                                }

                            }
                        );

                    }
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Close drawer when tapping outside
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'click',
            function (
                event
            ) {

                if (
                    !navigation
                    || !navigationToggle
                ) {

                    return;

                }


                if (
                    !isNavigationMobile()
                ) {

                    return;

                }


                if (
                    !navigation.classList.contains(
                        'site-nav--open'
                    )
                ) {

                    return;

                }


                const target =
                    event.target;


                if (
                    !(target instanceof Node)
                ) {

                    return;

                }


                /*
                 * Keep the drawer open when clicking inside the
                 * drawer, hamburger button, or theme button.
                 */

                if (
                    navigation.contains(
                        target
                    )
                    || navigationToggle.contains(
                        target
                    )
                    || (
                        target instanceof Element
                        && target.closest(
                            '[data-theme-toggle]'
                        )
                    )
                ) {

                    return;

                }


                closeNavigation();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Escape key
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'keydown',
            function (
                event
            ) {

                if (
                    event.key !== 'Escape'
                ) {

                    return;

                }


                if (
                    navigation
                    && navigation.classList.contains(
                        'site-nav--open'
                    )
                ) {

                    closeNavigation();

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Close drawer when returning to desktop
        |--------------------------------------------------------------------------
        */

        window.addEventListener(
            'resize',
            function () {

                if (
                    !isNavigationMobile()
                ) {

                    closeNavigation();

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Browser back/forward restoration
        |--------------------------------------------------------------------------
        */

        window.addEventListener(
            'pageshow',
            function () {

                if (
                    !isNavigationMobile()
                ) {

                    closeNavigation();

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Homepage slider
        |--------------------------------------------------------------------------
        */


        const slider =
            document.querySelector(
                '[data-home-slider]'
            );


        /*
         * Theme and navigation are already initialized.
         *
         * The homepage slider is optional. Other public pages therefore
         * safely stop here without affecting the theme system.
         */

        if (
            !slider
        ) {

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Slides
        |--------------------------------------------------------------------------
        */

        const slides =
            Array.from(
                slider.querySelectorAll(
                    '[data-home-slide]'
                )
            );


        /*
        |--------------------------------------------------------------------------
        | Dots
        |--------------------------------------------------------------------------
        */

        const dots =
            Array.from(
                slider.querySelectorAll(
                    '[data-home-slider-dot]'
                )
            );


        /*
        |--------------------------------------------------------------------------
        | Navigation buttons
        |--------------------------------------------------------------------------
        */

        const previousButton =
            slider.querySelector(
                '[data-home-slider-prev]'
            );


        const nextButton =
            slider.querySelector(
                '[data-home-slider-next]'
            );


        const dotsContainer =
            slider.querySelector(
                '.home-slider__dots'
            );


        /*
        |--------------------------------------------------------------------------
        | Slider behavior settings
        |--------------------------------------------------------------------------
        */

        const autoplay =
            slider.dataset.sliderAutoplay !== 'false';


        let interval =
            Number(
                slider.dataset.sliderInterval
            );


        if (
            !Number.isFinite(
                interval
            )
            || interval < 2000
        ) {

            interval =
                5000;

        }


        interval =
            Math.min(
                interval,
                30000
            );


        const showArrows =
            slider.dataset.sliderArrows !== 'false';


        const showDots =
            slider.dataset.sliderDots !== 'false';


        /*
        |--------------------------------------------------------------------------
        | Visual settings
        |--------------------------------------------------------------------------
        */

        const backgroundMode =
            slider.dataset.sliderBackgroundMode
            || 'blur';


        const backgroundColor =
            slider.dataset.sliderBackgroundColor
            || '#111827';


        const gradient =
            slider.dataset.sliderGradient
            || 'dark';


        const imageFit =
            slider.dataset.sliderImageFit
            || 'contain';


        const imagePosition =
            slider.dataset.sliderImagePosition
            || 'center center';


        /*
        |--------------------------------------------------------------------------
        | Gradient presets
        |--------------------------------------------------------------------------
        */

        const gradients = {

            dark:
                'linear-gradient(135deg,#0f172a,#1e293b)',

            ocean:
                'linear-gradient(135deg,#0f172a,#0369a1)',

            purple:
                'linear-gradient(135deg,#1e1b4b,#7e22ce)',

            sunset:
                'linear-gradient(135deg,#7c2d12,#db2777)',

            light:
                'linear-gradient(135deg,#e5e7eb,#f8fafc)',

        };


        /*
        |--------------------------------------------------------------------------
        | Apply image fit and position
        |--------------------------------------------------------------------------
        */

        slider
            .querySelectorAll(
                '.home-slide__image'
            )
            .forEach(
                function (
                    image
                ) {

                    image.style.objectFit =
                        imageFit;


                    image.style.objectPosition =
                        imagePosition;

                }
            );


        /*
        |--------------------------------------------------------------------------
        | Arrow visibility
        |--------------------------------------------------------------------------
        */

        if (
            previousButton
        ) {

            if (
                showArrows
            ) {

                previousButton.hidden =
                    false;


                previousButton.removeAttribute(
                    'aria-hidden'
                );


                previousButton.removeAttribute(
                    'tabindex'
                );

            } else {

                previousButton.hidden =
                    true;


                previousButton.setAttribute(
                    'aria-hidden',
                    'true'
                );


                previousButton.setAttribute(
                    'tabindex',
                    '-1'
                );

            }

        }


        if (
            nextButton
        ) {

            if (
                showArrows
            ) {

                nextButton.hidden =
                    false;


                nextButton.removeAttribute(
                    'aria-hidden'
                );


                nextButton.removeAttribute(
                    'tabindex'
                );

            } else {

                nextButton.hidden =
                    true;


                nextButton.setAttribute(
                    'aria-hidden',
                    'true'
                );


                nextButton.setAttribute(
                    'tabindex',
                    '-1'
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Dots visibility
        |--------------------------------------------------------------------------
        */

        if (
            dotsContainer
        ) {

            if (
                showDots
            ) {

                dotsContainer.hidden =
                    false;


                dotsContainer.removeAttribute(
                    'aria-hidden'
                );

            } else {

                dotsContainer.hidden =
                    true;


                dotsContainer.setAttribute(
                    'aria-hidden',
                    'true'
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Dominant color extraction
        |--------------------------------------------------------------------------
        */

        const getDominantColor =
            function (
                image
            ) {

                if (
                    !image
                    || image.tagName !== 'IMG'
                ) {

                    return '#111827';

                }


                try {

                    const canvas =
                        document.createElement(
                            'canvas'
                        );


                    const context =
                        canvas.getContext(
                            '2d'
                        );


                    if (
                        !context
                    ) {

                        return '#111827';

                    }


                    const width =
                        32;


                    const height =
                        32;


                    canvas.width =
                        width;


                    canvas.height =
                        height;


                    context.drawImage(
                        image,
                        0,
                        0,
                        width,
                        height
                    );


                    const data =
                        context.getImageData(
                            0,
                            0,
                            width,
                            height
                        ).data;


                    let red =
                        0;


                    let green =
                        0;


                    let blue =
                        0;


                    let count =
                        0;


                    for (
                        let index = 0;
                        index < data.length;
                        index += 16
                    ) {

                        const r =
                            data[index];


                        const g =
                            data[index + 1];


                        const b =
                            data[index + 2];


                        /*
                         * Ignore almost-white pixels.
                         */

                        if (
                            r > 245
                            && g > 245
                            && b > 245
                        ) {

                            continue;

                        }


                        red +=
                            r;


                        green +=
                            g;


                        blue +=
                            b;


                        count++;

                    }


                    if (
                        count === 0
                    ) {

                        return '#111827';

                    }


                    red =
                        Math.round(
                            red / count
                        );


                    green =
                        Math.round(
                            green / count
                        );


                    blue =
                        Math.round(
                            blue / count
                        );


                    return (
                        '#'
                        + red
                            .toString(
                                16
                            )
                            .padStart(
                                2,
                                '0'
                            )
                        + green
                            .toString(
                                16
                            )
                            .padStart(
                                2,
                                '0'
                            )
                        + blue
                            .toString(
                                16
                            )
                            .padStart(
                                2,
                                '0'
                            )
                    );

                } catch (
                    error
                ) {

                    return '#111827';

                }

            };


        /*
        |--------------------------------------------------------------------------
        | Apply slider background
        |--------------------------------------------------------------------------
        */

        const applyBackground =
            function (
                slide
            ) {

                const backdrop =
                    slide
                        ? slide.querySelector(
                            '.home-slide__backdrop'
                        )
                        : null;


                /*
                 * Default.
                 */

                slider.style.background =
                    '#111827';


                /*
                 * Blur background.
                 */

                if (
                    backgroundMode === 'blur'
                ) {

                    slider.style.background =
                        '#111827';


                    if (
                        backdrop
                    ) {

                        backdrop.style.display =
                            'block';


                        backdrop.style.visibility =
                            'visible';

                    }


                    return;

                }


                /*
                 * Dominant color.
                 */

                if (
                    backgroundMode === 'dominant'
                ) {

                    const image =
                        slide
                            ? slide.querySelector(
                                '.home-slide__image'
                            )
                            : null;


                    const dominant =
                        getDominantColor(
                            image
                        );


                    slider.style.background =
                        dominant;


                    if (
                        backdrop
                    ) {

                        backdrop.style.display =
                            'block';


                        backdrop.style.visibility =
                            'visible';

                    }


                    return;

                }


                /*
                 * Solid color.
                 */

                if (
                    backgroundMode === 'solid'
                ) {

                    slider.style.background =
                        backgroundColor;


                    if (
                        backdrop
                    ) {

                        backdrop.style.display =
                            'none';


                        backdrop.style.visibility =
                            'hidden';

                    }


                    return;

                }


                /*
                 * Gradient.
                 */

                if (
                    backgroundMode === 'gradient'
                ) {

                    slider.style.background =
                        gradients[gradient]
                        || gradients.dark;


                    if (
                        backdrop
                    ) {

                        backdrop.style.display =
                            'none';


                        backdrop.style.visibility =
                            'hidden';

                    }


                    return;

                }


                /*
                 * No background.
                 */

                if (
                    backgroundMode === 'none'
                ) {

                    slider.style.background =
                        'transparent';


                    if (
                        backdrop
                    ) {

                        backdrop.style.display =
                            'none';


                        backdrop.style.visibility =
                            'hidden';

                    }

                }

            };


        /*
        |--------------------------------------------------------------------------
        | Handle zero / one slide
        |--------------------------------------------------------------------------
        */

        if (
            slides.length <= 1
        ) {

            if (
                previousButton
            ) {

                previousButton.hidden =
                    true;

            }


            if (
                nextButton
            ) {

                nextButton.hidden =
                    true;

            }


            if (
                dotsContainer
            ) {

                dotsContainer.hidden =
                    true;

            }


            if (
                slides[0]
            ) {

                applyBackground(
                    slides[0]
                );

            }


            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Slider state
        |--------------------------------------------------------------------------
        */

        let currentIndex =
            0;


        let timer =
            null;


        /*
        |--------------------------------------------------------------------------
        | Stop autoplay
        |--------------------------------------------------------------------------
        */

        const stopTimer =
            function () {

                if (
                    timer !== null
                ) {

                    window.clearInterval(
                        timer
                    );


                    timer =
                        null;

                }

            };


        /*
        |--------------------------------------------------------------------------
        | Restart autoplay
        |--------------------------------------------------------------------------
        */

        const restartTimer =
            function () {

                if (
                    !autoplay
                ) {

                    stopTimer();

                    return;

                }


                stopTimer();


                timer =
                    window.setInterval(
                        function () {

                            next();

                        },
                        interval
                    );

            };


        /*
        |--------------------------------------------------------------------------
        | Show slide
        |--------------------------------------------------------------------------
        */

        const showSlide =
            function (
                index,
                resetTimer = true
            ) {

                currentIndex =
                    (
                        index
                        + slides.length
                    )
                    % slides.length;


                slides.forEach(
                    function (
                        slide,
                        slideIndex
                    ) {

                        const active =
                            slideIndex
                            === currentIndex;


                        slide.classList.toggle(
                            'home-slide--active',
                            active
                        );


                        slide.setAttribute(
                            'aria-hidden',
                            active
                                ? 'false'
                                : 'true'
                        );

                    }
                );


                dots.forEach(
                    function (
                        dot,
                        dotIndex
                    ) {

                        const active =
                            dotIndex
                            === currentIndex;


                        dot.classList.toggle(
                            'home-slider__dot--active',
                            active
                        );


                        dot.setAttribute(
                            'aria-selected',
                            active
                                ? 'true'
                                : 'false'
                        );

                    }
                );


                applyBackground(
                    slides[currentIndex]
                );


                if (
                    resetTimer
                ) {

                    restartTimer();

                }

            };


        /*
        |--------------------------------------------------------------------------
        | Next
        |--------------------------------------------------------------------------
        */

        const next =
            function () {

                showSlide(
                    currentIndex + 1
                );

            };


        /*
        |--------------------------------------------------------------------------
        | Previous
        |--------------------------------------------------------------------------
        */

        const previous =
            function () {

                showSlide(
                    currentIndex - 1
                );

            };


        /*
        |--------------------------------------------------------------------------
        | Previous button
        |--------------------------------------------------------------------------
        */

        if (
            previousButton
            && showArrows
        ) {

            previousButton.addEventListener(
                'click',
                function () {

                    previous();

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Next button
        |--------------------------------------------------------------------------
        */

        if (
            nextButton
            && showArrows
        ) {

            nextButton.addEventListener(
                'click',
                function () {

                    next();

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Dots
        |--------------------------------------------------------------------------
        */

        if (
            showDots
        ) {

            dots.forEach(
                function (
                    dot,
                    index
                ) {

                    dot.addEventListener(
                        'click',
                        function () {

                            showSlide(
                                index
                            );

                        }
                    );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Pause on hover
        |--------------------------------------------------------------------------
        */

        slider.addEventListener(
            'mouseenter',
            function () {

                if (
                    autoplay
                ) {

                    stopTimer();

                }

            }
        );


        slider.addEventListener(
            'mouseleave',
            function () {

                if (
                    autoplay
                ) {

                    restartTimer();

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Pause when focused
        |--------------------------------------------------------------------------
        */

        slider.addEventListener(
            'focusin',
            function () {

                if (
                    autoplay
                ) {

                    stopTimer();

                }

            }
        );


        slider.addEventListener(
            'focusout',
            function () {

                if (
                    autoplay
                ) {

                    restartTimer();

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Keyboard controls
        |--------------------------------------------------------------------------
        */

        slider.addEventListener(
            'keydown',
            function (
                event
            ) {

                if (
                    event.key === 'ArrowLeft'
                ) {

                    event.preventDefault();

                    next();

                }


                if (
                    event.key === 'ArrowRight'
                ) {

                    event.preventDefault();

                    previous();

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | Touch swipe
        |--------------------------------------------------------------------------
        */

        let touchStartX =
            null;


        slider.addEventListener(
            'touchstart',
            function (
                event
            ) {

                touchStartX =
                    event.touches[0]?.clientX
                    ?? null;

            },
            {
                passive: true,
            }
        );


        slider.addEventListener(
            'touchend',
            function (
                event
            ) {

                if (
                    touchStartX === null
                ) {

                    return;

                }


                const touchEndX =
                    event.changedTouches[0]?.clientX
                    ?? touchStartX;


                const distance =
                    touchEndX
                    - touchStartX;


                touchStartX =
                    null;


                if (
                    Math.abs(
                        distance
                    ) < 50
                ) {

                    return;

                }


                if (
                    distance < 0
                ) {

                    next();

                } else {

                    previous();

                }

            },
            {
                passive: true,
            }
        );


        /*
        |--------------------------------------------------------------------------
        | Initial slider state
        |--------------------------------------------------------------------------
        */

        showSlide(
            0,
            false
        );


        /*
        |--------------------------------------------------------------------------
        | Start autoplay
        |--------------------------------------------------------------------------
        */

        if (
            autoplay
        ) {

            restartTimer();

        }

    }
);


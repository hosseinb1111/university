'use strict';


document.addEventListener(
    'DOMContentLoaded',
    function () {


        /*
        |--------------------------------------------------------------------------
        | Theme system
        |--------------------------------------------------------------------------
        |
        | English and Persian public pages share the same theme preference:
        |
        |     sadra-theme
        |
        | Supported values:
        |
        |     light
        |     dark
        |
        | The theme system also controls the shared logo:
        |
        |     logo-light.png
        |     logo-dark.png
        |
        | The layout provides these through:
        |
        |     data-theme-logo
        |     data-theme-logo-light
        |     data-theme-logo-dark
        |
        |--------------------------------------------------------------------------
        */


        /*
        |--------------------------------------------------------------------------
        | Theme storage key
        |--------------------------------------------------------------------------
        */

        const themeStorageKey =
            'sadra-theme';


        /*
        |--------------------------------------------------------------------------
        | Shared theme logo cache
        |--------------------------------------------------------------------------
        |
        | Keeping the logo paths in the DOM means the JavaScript does not
        | need to know the application's asset URL structure.
        |
        */

        const getThemeLogo =
            function (
                logo,
                theme
            ) {

                if (
                    !logo
                ) {

                    return '';

                }


                const logoLight =
                    logo.getAttribute(
                        'data-theme-logo-light'
                    );


                const logoDark =
                    logo.getAttribute(
                        'data-theme-logo-dark'
                    );


                if (
                    theme === 'dark'
                ) {

                    return logoDark
                        || logoLight
                        || '';

                }


                return logoLight
                    || logoDark
                    || '';

            };


        /*
        |--------------------------------------------------------------------------
        | System theme
        |--------------------------------------------------------------------------
        */

        const getSystemTheme =
            function () {

                try {

                    return (
                        window.matchMedia
                        && window.matchMedia(
                            '(prefers-color-scheme: dark)'
                        ).matches
                    )
                        ? 'dark'
                        : 'light';

                } catch (
                    error
                ) {

                    return 'light';

                }

            };


        /*
        |--------------------------------------------------------------------------
        | Read stored theme
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
                        storedTheme === 'dark'
                        || storedTheme === 'light'
                    ) {

                        return storedTheme;

                    }

                } catch (
                    error
                ) {

                    /*
                     * Ignore storage access failures.
                     */

                }


                /*
                |--------------------------------------------------------------------------
                | No explicit preference.
                |--------------------------------------------------------------------------
                |
                | Follow the operating system.
                |
                */

                return getSystemTheme();

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
        | Update page logos
        |--------------------------------------------------------------------------
        */

        const updateThemeLogos =
            function (
                theme
            ) {

                document
                    .querySelectorAll(
                        '[data-theme-logo]'
                    )
                    .forEach(
                        function (
                            logo
                        ) {

                            const nextLogo =
                                getThemeLogo(
                                    logo,
                                    theme
                                );


                            if (
                                nextLogo === ''
                            ) {

                                return;

                            }


                            /*
                             * Only touch src when it actually needs
                             * to change. This avoids unnecessary image
                             * reloads.
                             */

                            if (
                                logo.getAttribute(
                                    'src'
                                )
                                !== nextLogo
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
        | Update every theme toggle
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

                            /*
                            |--------------------------------------------------------------------------
                            | Accessibility
                            |--------------------------------------------------------------------------
                            */

                            button.setAttribute(
                                'aria-pressed',
                                isDark
                                    ? 'true'
                                    : 'false'
                            );


                            button.setAttribute(
                                'aria-label',
                                isDark
                                    ? 'Switch to light mode'
                                    : 'Switch to dark mode'
                            );


                            button.setAttribute(
                                'title',
                                isDark
                                    ? 'Light mode'
                                    : 'Dark mode'
                            );


                            /*
                            |--------------------------------------------------------------------------
                            | Icon
                            |--------------------------------------------------------------------------
                            */

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
                |--------------------------------------------------------------------------
                | Root theme
                |--------------------------------------------------------------------------
                */

                document.documentElement.setAttribute(
                    'data-theme',
                    normalizedTheme
                );


                /*
                |--------------------------------------------------------------------------
                | Browser chrome
                |--------------------------------------------------------------------------
                */

                updateThemeColor(
                    normalizedTheme
                );


                /*
                |--------------------------------------------------------------------------
                | Theme controls
                |--------------------------------------------------------------------------
                */

                updateThemeControls(
                    normalizedTheme
                );


                /*
                |--------------------------------------------------------------------------
                | Shared light/dark logos
                |--------------------------------------------------------------------------
                */

                updateThemeLogos(
                    normalizedTheme
                );


                /*
                |--------------------------------------------------------------------------
                | Persistence
                |--------------------------------------------------------------------------
                */

                if (
                    persist
                ) {

                    try {

                        localStorage.setItem(
                            themeStorageKey,
                            normalizedTheme
                        );

                    } catch (
                        error
                    ) {

                        /*
                         * Ignore storage failures.
                         */

                    }

                }

            };


        /*
        |--------------------------------------------------------------------------
        | Initial theme
        |--------------------------------------------------------------------------
        |
        | The PHP layout already sets data-theme before the stylesheet loads
        | to avoid the initial theme flash.
        |
        | We synchronize everything here again:
        |
        |     - toggle state
        |     - icon
        |     - browser theme color
        |     - logo
        |
        |--------------------------------------------------------------------------
        */

        applyTheme(
            getStoredTheme(),
            false
        );


        /*
        |--------------------------------------------------------------------------
        | Theme toggle
        |--------------------------------------------------------------------------
        |
        | Event delegation means all current and future theme buttons work
        | automatically.
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


                const currentTheme =
                    document.documentElement.getAttribute(
                        'data-theme'
                    )
                    || getStoredTheme();


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
        | English mobile navigation
        |--------------------------------------------------------------------------
        */

        const navigationToggle =
            document.getElementById(
                'english-menu-toggle'
            );


        const navigation =
            document.getElementById(
                'english-navigation'
            );


        if (
            navigationToggle
            && navigation
        ) {


            /*
            |--------------------------------------------------------------------------
            | Close menu
            |--------------------------------------------------------------------------
            */

            const closeMenu =
                function () {

                    navigation.classList.remove(
                        'english-nav--open'
                    );


                    navigationToggle.setAttribute(
                        'aria-expanded',
                        'false'
                    );


                    navigationToggle.setAttribute(
                        'aria-label',
                        'Open navigation'
                    );


                    document.body.classList.remove(
                        'english-menu-open'
                    );

                };


            /*
            |--------------------------------------------------------------------------
            | Open menu
            |--------------------------------------------------------------------------
            */

            const openMenu =
                function () {

                    navigation.classList.add(
                        'english-nav--open'
                    );


                    navigationToggle.setAttribute(
                        'aria-expanded',
                        'true'
                    );


                    navigationToggle.setAttribute(
                        'aria-label',
                        'Close navigation'
                    );


                    document.body.classList.add(
                        'english-menu-open'
                    );

                };


            /*
            |--------------------------------------------------------------------------
            | Toggle menu
            |--------------------------------------------------------------------------
            */

            navigationToggle.addEventListener(
                'click',
                function () {

                    const isOpen =
                        navigation.classList.contains(
                            'english-nav--open'
                        );


                    if (
                        isOpen
                    ) {

                        closeMenu();

                    } else {

                        openMenu();

                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Close after navigation link
            |--------------------------------------------------------------------------
            |
            | Only anchors close the menu.
            |
            | The theme toggle is outside the navigation and therefore
            | does not trigger this handler.
            |
            */

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

                                closeMenu();

                            }
                        );

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
                        navigation.classList.contains(
                            'english-nav--open'
                        )
                    ) {

                        closeMenu();

                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Click outside navigation
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
                        !(target instanceof Node)
                    ) {

                        return;

                    }


                    if (
                        navigation.contains(
                            target
                        )
                        || navigationToggle.contains(
                            target
                        )
                    ) {

                        return;

                    }


                    /*
                     * Theme control is a separate header action.
                     *
                     * Clicking it should never accidentally close
                     * or otherwise interfere with the navigation.
                     */

                    const themeToggle =
                        target instanceof Element
                            ? target.closest(
                                '[data-theme-toggle]'
                            )
                            : null;


                    if (
                        themeToggle
                    ) {

                        return;

                    }


                    closeMenu();

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Close when returning to desktop
            |--------------------------------------------------------------------------
            */

            const desktopMedia =
                window.matchMedia(
                    '(min-width: 901px)'
                );


            const handleDesktopChange =
                function (
                    event
                ) {

                    if (
                        event.matches
                    ) {

                        closeMenu();

                    }

                };


            if (
                typeof desktopMedia.addEventListener
                === 'function'
            ) {

                desktopMedia.addEventListener(
                    'change',
                    handleDesktopChange
                );

            } else {

                /*
                 * Older Safari support.
                 */

                desktopMedia.addListener(
                    handleDesktopChange
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Initial navigation state
            |--------------------------------------------------------------------------
            */

            closeMenu();

        }


        /*
        |--------------------------------------------------------------------------
        | Homepage slider
        |--------------------------------------------------------------------------
        |
        | Slider initialization is intentionally below theme and navigation.
        |
        | Pages without a slider safely return here.
        |
        |--------------------------------------------------------------------------
        */

        const slider =
            document.querySelector(
                '[data-home-slider].english-home-slider'
            );


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


        if (
            slides.length === 0
        ) {

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Controls
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


        const dots =
            Array.from(
                slider.querySelectorAll(
                    '[data-home-slider-dot]'
                )
            );


        const dotsContainer =
            slider.querySelector(
                '.english-home-slider__dots'
            );


        /*
        |--------------------------------------------------------------------------
        | Slider settings
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
        | Image selectors
        |--------------------------------------------------------------------------
        */

        const imageSelector =
            '.english-home-slide__image';


        const backdropSelector =
            '.english-home-slide__backdrop';


        /*
        |--------------------------------------------------------------------------
        | Apply image settings
        |--------------------------------------------------------------------------
        */

        slider
            .querySelectorAll(
                imageSelector
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
        | Configure previous arrow
        |--------------------------------------------------------------------------
        */

        if (
            previousButton
        ) {

            previousButton.hidden =
                !showArrows;


            if (
                showArrows
            ) {

                previousButton.removeAttribute(
                    'aria-hidden'
                );


                previousButton.removeAttribute(
                    'tabindex'
                );

            } else {

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


        /*
        |--------------------------------------------------------------------------
        | Configure next arrow
        |--------------------------------------------------------------------------
        */

        if (
            nextButton
        ) {

            nextButton.hidden =
                !showArrows;


            if (
                showArrows
            ) {

                nextButton.removeAttribute(
                    'aria-hidden'
                );


                nextButton.removeAttribute(
                    'tabindex'
                );

            } else {

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
        | Configure dots
        |--------------------------------------------------------------------------
        */

        if (
            dotsContainer
        ) {

            dotsContainer.hidden =
                !showDots;


            dotsContainer.setAttribute(
                'aria-hidden',
                showDots
                    ? 'false'
                    : 'true'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Dominant color helper
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
                        |--------------------------------------------------------------------------
                        | Ignore almost-white pixels.
                        |--------------------------------------------------------------------------
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

                    /*
                     * Canvas can fail for images served without
                     * suitable CORS permissions.
                     */

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
                            backdropSelector
                        )
                        : null;


                /*
                |--------------------------------------------------------------------------
                | Blur
                |--------------------------------------------------------------------------
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
                |--------------------------------------------------------------------------
                | Dominant color
                |--------------------------------------------------------------------------
                */

                if (
                    backgroundMode === 'dominant'
                ) {

                    const image =
                        slide
                            ? slide.querySelector(
                                imageSelector
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
                |--------------------------------------------------------------------------
                | Solid
                |--------------------------------------------------------------------------
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
                |--------------------------------------------------------------------------
                | Gradient
                |--------------------------------------------------------------------------
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
                |--------------------------------------------------------------------------
                | No background
                |--------------------------------------------------------------------------
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
        | One slide
        |--------------------------------------------------------------------------
        */

        if (
            slides.length === 1
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


            applyBackground(
                slides[0]
            );


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
        | Stop timer
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
        | Restart timer
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
                            'english-home-slide--active',
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
                            'english-home-slider__dot--active',
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
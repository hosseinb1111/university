'use strict';

document.addEventListener(
    'DOMContentLoaded',
    function () {
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

        if (
            navigationToggle
            && navigation
        ) {
            navigationToggle.addEventListener(
                'click',
                function () {
                    const isOpen =
                        navigation.classList.toggle(
                            'site-nav--open'
                        );

                    navigationToggle.setAttribute(
                        'aria-expanded',
                        isOpen
                            ? 'true'
                            : 'false'
                    );
                }
            );

            navigation
                .querySelectorAll('a')
                .forEach(
                    function (link) {
                        link.addEventListener(
                            'click',
                            function () {
                                navigation.classList.remove(
                                    'site-nav--open'
                                );

                                navigationToggle.setAttribute(
                                    'aria-expanded',
                                    'false'
                                );
                            }
                        );
                    }
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Homepage slider
        |--------------------------------------------------------------------------
        */

        const slider =
            document.querySelector(
                '[data-home-slider]'
            );

        if (!slider) {
            return;
        }

        const slides =
            Array.from(
                slider.querySelectorAll(
                    '[data-home-slide]'
                )
            );

        if (
            slides.length <= 1
        ) {
            return;
        }

        const dots =
            Array.from(
                slider.querySelectorAll(
                    '[data-home-slider-dot]'
                )
            );

        const previousButton =
            slider.querySelector(
                '[data-home-slider-prev]'
            );

        const nextButton =
            slider.querySelector(
                '[data-home-slider-next]'
            );

        let currentIndex = 0;

        let timer = null;

        const interval = 7000;


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

                    timer = null;
                }
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

                if (
                    resetTimer
                ) {
                    restartTimer();
                }
            };


        /*
        |--------------------------------------------------------------------------
        | Next slide
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
        | Previous slide
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
        | Restart autoplay
        |--------------------------------------------------------------------------
        */

        const restartTimer =
            function () {
                stopTimer();

                timer =
                    window.setInterval(
                        next,
                        interval
                    );
            };


        /*
        |--------------------------------------------------------------------------
        | Previous button
        |--------------------------------------------------------------------------
        */

        if (
            previousButton
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


        /*
        |--------------------------------------------------------------------------
        | Pause on hover
        |--------------------------------------------------------------------------
        */

        slider.addEventListener(
            'mouseenter',
            function () {
                stopTimer();
            }
        );

        slider.addEventListener(
            'mouseleave',
            function () {
                restartTimer();
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
                stopTimer();
            }
        );

        slider.addEventListener(
            'focusout',
            function () {
                restartTimer();
            }
        );


        /*
        |--------------------------------------------------------------------------
        | Keyboard navigation
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

        let touchStartX = null;


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
        | Initial state
        |--------------------------------------------------------------------------
        */

        showSlide(
            0,
            false
        );

        restartTimer();
    }
);
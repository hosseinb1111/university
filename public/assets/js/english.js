'use strict';

document.addEventListener(
    'DOMContentLoaded',
    function () {
        const toggle =
            document.getElementById(
                'english-menu-toggle'
            );

        const navigation =
            document.getElementById(
                'english-navigation'
            );

        if (
            !toggle
            || !navigation
        ) {
            return;
        }

        toggle.addEventListener(
            'click',
            function () {
                const isOpen =
                    navigation.classList.toggle(
                        'english-nav--open'
                    );

                toggle.setAttribute(
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
                                'english-nav--open'
                            );

                            toggle.setAttribute(
                                'aria-expanded',
                                'false'
                            );
                        }
                    );
                }
            );
    }
);
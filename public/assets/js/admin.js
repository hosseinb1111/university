'use strict';

document.addEventListener(
    'DOMContentLoaded',
    () => {
        const sidebar = document.getElementById(
            'admin-sidebar'
        );

        const menuToggle = document.getElementById(
            'admin-menu-toggle'
        );

        const closeButton = document.getElementById(
            'admin-sidebar-close'
        );

        if (
            sidebar === null
        ) {
            return;
        }

        const openSidebar = () => {
            sidebar.classList.add(
                'admin-sidebar--open'
            );
        };

        const closeSidebar = () => {
            sidebar.classList.remove(
                'admin-sidebar--open'
            );
        };

        menuToggle?.addEventListener(
            'click',
            openSidebar
        );

        closeButton?.addEventListener(
            'click',
            closeSidebar
        );

        document.addEventListener(
            'click',
            (event) => {
                if (
                    window.innerWidth > 900
                ) {
                    return;
                }

                const target = event.target;

                if (
                    !(target instanceof Node)
                ) {
                    return;
                }

                const clickedInsideSidebar =
                    sidebar.contains(target);

                const clickedMenuButton =
                    menuToggle?.contains(target)
                    ?? false;

                if (
                    !clickedInsideSidebar
                    && !clickedMenuButton
                ) {
                    closeSidebar();
                }
            }
        );

        window.addEventListener(
            'resize',
            () => {
                if (
                    window.innerWidth > 900
                ) {
                    closeSidebar();
                }
            }
        );
    }
);
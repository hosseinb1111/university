<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

final class View
{
    /**
     * Base directory containing view templates.
     */
    private static string $viewsPath = BASE_PATH . '/app/Views';

    /**
     * Shared data available to every view.
     *
     * @var array<string, mixed>
     */
    private static array $shared = [];

    /**
     * Render a view and return its HTML.
     *
     * Example:
     *
     * return View::render('home/index', [
     *     'title' => 'صفحه اصلی',
     * ]);
     */
    public static function render(
        string $view,
        array $data = []
    ): string {
        $viewFile = self::resolve($view);

        /*
         * Merge shared data with local view data.
         *
         * Local data takes precedence.
         */
        $viewData = array_merge(
            self::$shared,
            $data
        );

        /*
         * Make array keys available as variables:
         *
         * [
         *     'title' => 'Home'
         * ]
         *
         * becomes:
         *
         * $title
         *
         * EXTR_SKIP prevents accidental overwriting of
         * existing local variables.
         */
        extract(
            $viewData,
            EXTR_SKIP
        );

        /*
         * Isolate the template execution inside a method scope
         * and capture its output.
         */
        ob_start();

        try {
            require $viewFile;
        } catch (\Throwable $exception) {
            /*
             * Always clean the output buffer when a template fails.
             */
            ob_end_clean();

            throw $exception;
        }

        return (string) ob_get_clean();
    }

    /**
     * Render a view and send it directly to the browser.
     *
     * Useful for controllers that don't need to manipulate
     * the generated HTML.
     */
    public static function display(
        string $view,
        array $data = []
    ): void {
        echo self::render(
            $view,
            $data
        );
    }

    /**
     * Share data with all views.
     */
    public static function share(
        string $key,
        mixed $value
    ): void {
        self::$shared[$key] = $value;
    }

    /**
     * Share multiple values with all views.
     */
    public static function shareMany(
        array $data
    ): void {
        foreach ($data as $key => $value) {
            self::$shared[$key] = $value;
        }
    }

    /**
     * Get a shared value.
     */
    public static function shared(
        string $key,
        mixed $default = null
    ): mixed {
        return self::$shared[$key]
            ?? $default;
    }

    /**
     * Resolve a view name to a PHP template.
     *
     * Example:
     *
     * View::render('home/index')
     *
     * resolves to:
     *
     * app/Views/home/index.php
     */
    private static function resolve(
        string $view
    ): string {
        $view = trim($view);

        if ($view === '') {
            throw new RuntimeException(
                'View name cannot be empty.'
            );
        }

        /*
         * Convert Windows separators to Unix-style separators.
         */
        $view = str_replace(
            '\\',
            '/',
            $view
        );

        /*
         * Prevent path traversal.
         *
         * We only allow a simple view identifier made of:
         * - letters
         * - numbers
         * - underscore
         * - hyphen
         * - slash
         * - dot
         *
         * The ".php" extension is added automatically.
         */
        if (
            preg_match(
                '#^[A-Za-z0-9_./-]+$#',
                $view
            ) !== 1
        ) {
            throw new RuntimeException(
                'Invalid view name.'
            );
        }

        /*
         * Explicitly reject traversal segments.
         */
        if (
            str_contains(
                $view,
                '..'
            )
        ) {
            throw new RuntimeException(
                'Invalid view path.'
            );
        }

        /*
         * Prevent callers from providing the extension themselves.
         */
        if (
            str_ends_with(
                strtolower($view),
                '.php'
            )
        ) {
            $view = substr(
                $view,
                0,
                -4
            );
        }

        $viewFile = self::$viewsPath
            . '/'
            . $view
            . '.php';

        if (!is_file($viewFile)) {
            throw new RuntimeException(
                "View [{$view}] not found."
            );
        }

        return $viewFile;
    }

    /**
     * Generate a named route URL from a view.
     *
     * This is a convenience wrapper around Router::route().
     */
    public static function route(
        string $name,
        array $parameters = []
    ): string {
        return Router::route(
            $name,
            $parameters
        );
    }

    /**
     * Escape HTML safely.
     *
     * Use this when displaying user/database content:
     *
     * <?= View::escape($title) ?>
     */
    public static function escape(
        mixed $value
    ): string {
        return htmlspecialchars(
            (string) $value,
            ENT_QUOTES | ENT_SUBSTITUTE,
            'UTF-8'
        );
    }

    /**
     * Generate an asset URL.
     *
     * Example:
     *
     * View::asset('css/app.css')
     *
     * => /assets/css/app.css
     */
    public static function asset(
        string $path
    ): string {
        $path = ltrim(
            trim($path),
            '/'
        );

        $baseUrl = rtrim(
            (string) config(
                'app.url',
                ''
            ),
            '/'
        );

        return $baseUrl
            . '/assets/'
            . $path;
    }

    /**
     * Get the configured application URL.
     */
    public static function url(
        string $path = ''
    ): string {
        $baseUrl = rtrim(
            (string) config(
                'app.url',
                ''
            ),
            '/'
        );

        $path = trim(
            $path
        );

        if ($path === '' || $path === '/') {
            return $baseUrl . '/';
        }

        return $baseUrl
            . '/'
            . ltrim(
                $path,
                '/'
            );
    }

    /**
     * Render one view inside another.
     *
     * Example:
     *
     * $content = View::render(
     *     'pages/about',
     *     ['title' => 'درباره ما']
     * );
     *
     * return View::render(
     *     'layouts/app',
     *     ['content' => $content]
     * );
     */
    public static function renderIntoLayout(
        string $layout,
        string $view,
        array $data = []
    ): string {
        $content = self::render(
            $view,
            $data
        );

        return self::render(
            $layout,
            array_merge(
                $data,
                [
                    'content' => $content,
                ]
            )
        );
    }
}
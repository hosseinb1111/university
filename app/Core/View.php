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
     * @param array<string, mixed> $data
     */
    public static function render(
        string $view,
        array $data = []
    ): string {
        $viewFile = self::resolve($view);

        $viewData = array_merge(
            self::$shared,
            $data
        );

        extract(
            $viewData,
            EXTR_SKIP
        );

        ob_start();

        try {
            require $viewFile;

            return (string) ob_get_clean();
        } catch (\Throwable $exception) {
            if (ob_get_level() > 0) {
                ob_end_clean();
            }

            throw $exception;
        }
    }

    /**
     * Render a view directly.
     *
     * @param array<string, mixed> $data
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
     * Share a value with all views.
     */
    public static function share(
        string $key,
        mixed $value
    ): void {
        self::$shared[$key] = $value;
    }

    /**
     * Share multiple values with all views.
     *
     * @param array<string, mixed> $data
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
        return self::$shared[$key] ?? $default;
    }

    /**
     * Resolve a view name to a PHP file.
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

        $view = str_replace(
            '\\',
            '/',
            $view
        );

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

        if (str_contains($view, '..')) {
            throw new RuntimeException(
                'Invalid view path.'
            );
        }

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
            . DIRECTORY_SEPARATOR
            . str_replace(
                '/',
                DIRECTORY_SEPARATOR,
                $view
            )
            . '.php';

        if (!is_file($viewFile)) {
            throw new RuntimeException(
                "View [{$view}] not found."
            );
        }

        return $viewFile;
    }

    /**
     * Generate a named route URL.
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
     * Escape HTML safely using UTF-8.
     */
    public static function escape(
        mixed $value
    ): string {
        if ($value === null) {
            return '';
        }

        return htmlspecialchars(
            (string) $value,
            ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5,
            'UTF-8'
        );
    }

    /**
     * Generate an asset URL.
     *
     * Automatically adds a cache-busting version
     * for CSS and JavaScript files based on their
     * last modified time.
     *
     * Examples:
     *
     * View::asset('css/app.css')
     * View::asset('js/app.js')
     * View::asset('images/logo.png')
     */
    public static function asset(
        string $path
    ): string {
        $path = trim($path);

        if ($path === '') {
            return self::baseUrl() . '/assets/';
        }

        $path = str_replace(
            '\\',
            '/',
            $path
        );

        $path = ltrim(
            $path,
            '/'
        );

        if (
            str_starts_with(
                $path,
                'assets/'
            )
        ) {
            $path = substr(
                $path,
                7
            );
        }

        $url = self::baseUrl()
            . '/assets/'
            . $path;

        $version = self::assetVersion(
            $path
        );

        if ($version !== null) {
            $url .= '?v=' . $version;
        }

        return $url;
    }

    /**
     * Return a cache-busting version string for CSS/JS assets,
     * based on the file's last-modified time on disk.
     *
     * Returns null for non-versioned extensions or missing files,
     * so callers fall back to an unversioned URL instead of breaking.
     */
    private static function assetVersion(
        string $relativePath
    ): ?string {
        $extension = strtolower(
            pathinfo(
                $relativePath,
                PATHINFO_EXTENSION
            )
        );

        if (
            !in_array(
                $extension,
                ['css', 'js'],
                true
            )
        ) {
            return null;
        }

        /*
         * Assets are stored in:
         *
         * BASE_PATH/assets/
         */
        $absolutePath = BASE_PATH
            . '/assets/'
            . $relativePath;

        if (!is_file($absolutePath)) {
            return null;
        }

        $mtime = filemtime(
            $absolutePath
        );

        return $mtime !== false
            ? (string) $mtime
            : null;
    }

    /**
     * Generate an application URL.
     */
    public static function url(
        string $path = ''
    ): string {
        $baseUrl = self::baseUrl();

        $path = trim(
            str_replace(
                '\\',
                '/',
                $path
            )
        );

        if (
            $path === ''
            || $path === '/'
        ) {
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
     * Get the application's public base URL.
     *
     * Production hosting can be configured using app.url,
     * while the current request is used as a safe fallback.
     */
    private static function baseUrl(): string
    {
        $configuredUrl = trim(
            (string) config(
                'app.url',
                ''
            )
        );

        /*
         * Prefer explicitly configured application URL.
         */
        if ($configuredUrl !== '') {
            return rtrim(
                $configuredUrl,
                '/'
            );
        }

        /*
         * Fallback for InfinityFree/shared hosting.
         *
         * This allows assets and links to work even if
         * app.url has not been configured correctly.
         */
        $https = (
            (!empty($_SERVER['HTTPS'])
                && strtolower(
                    (string) $_SERVER['HTTPS']
                ) !== 'off')
            || (
                isset($_SERVER['HTTP_X_FORWARDED_PROTO'])
                && strtolower(
                    (string) $_SERVER['HTTP_X_FORWARDED_PROTO']
                ) === 'https'
            )
        );

        $scheme = $https
            ? 'https'
            : 'http';

        $host = trim(
            (string) (
                $_SERVER['HTTP_HOST']
                ?? ''
            )
        );

        if ($host === '') {
            return '';
        }

        return $scheme
            . '://'
            . $host;
    }

    /**
     * Render a view inside a layout.
     *
     * @param array<string, mixed> $data
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
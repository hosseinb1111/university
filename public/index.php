<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
/**
 * =========================================================
 * Sadra University Website
 * Application Entry Point
 * =========================================================
 */

define(
    'BASE_PATH',
    dirname(__DIR__)
);

define(
    'PUBLIC_PATH',
    __DIR__
);

define(
    'APP_PATH',
    BASE_PATH . '/app'
);

define(
    'CONFIG_PATH',
    BASE_PATH . '/config'
);

define(
    'ROUTES_PATH',
    BASE_PATH . '/routes'
);

define(
    'STORAGE_PATH',
    BASE_PATH . '/storage'
);

/*
|--------------------------------------------------------------------------
| Load environment
|--------------------------------------------------------------------------
*/

$envFile = BASE_PATH . '/.env';

if (is_file($envFile)) {
    $lines = file(
        $envFile,
        FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
    );

    if ($lines !== false) {
        foreach ($lines as $line) {
            $line = trim($line);

            if (
                $line === ''
                || str_starts_with(
                    $line,
                    '#'
                )
            ) {
                continue;
            }

            $parts = explode(
                '=',
                $line,
                2
            );

            if (
                count($parts) !== 2
            ) {
                continue;
            }

            $key = trim(
                $parts[0]
            );

            $value = trim(
                $parts[1]
            );

            if (
                strlen($value) >= 2
                && (
                    (
                        $value[0] === '"'
                        && $value[
                            strlen($value) - 1
                        ] === '"'
                    )
                    ||
                    (
                        $value[0] === "'"
                        && $value[
                            strlen($value) - 1
                        ] === "'"
                    )
                )
            ) {
                $value = substr(
                    $value,
                    1,
                    -1
                );
            }

            if (
                getenv($key) === false
                && !isset($_ENV[$key])
                && !isset($_SERVER[$key])
            ) {
                putenv(
                    $key . '=' . $value
                );

                $_ENV[$key] = $value;

                $_SERVER[$key] = $value;
            }
        }
    }
}

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

require_once APP_PATH . '/Helpers/env.php';
require_once APP_PATH . '/Helpers/config.php';

/*
|--------------------------------------------------------------------------
| Application configuration
|--------------------------------------------------------------------------
*/

$appConfig = require CONFIG_PATH . '/app.php';

/*
|--------------------------------------------------------------------------
| Timezone
|--------------------------------------------------------------------------
*/

date_default_timezone_set(
    (string) (
        $appConfig['timezone']
        ?? 'Asia/Tehran'
    )
);

/*
|--------------------------------------------------------------------------
| Error reporting
|--------------------------------------------------------------------------
*/

$debug = (bool) (
    $appConfig['debug']
    ?? false
);

if ($debug) {
    error_reporting(E_ALL);

    ini_set(
        'display_errors',
        '1'
    );

    ini_set(
        'display_startup_errors',
        '1'
    );
} else {
    error_reporting(
        E_ALL
        & ~E_DEPRECATED
        & ~E_STRICT
    );

    ini_set(
        'display_errors',
        '0'
    );

    ini_set(
        'display_startup_errors',
        '0'
    );
}

/*
|--------------------------------------------------------------------------
| Security headers
|--------------------------------------------------------------------------
*/

header(
    'X-Content-Type-Options: nosniff'
);

header(
    'X-Frame-Options: SAMEORIGIN'
);

header(
    'Referrer-Policy: strict-origin-when-cross-origin'
);

header(
    'Permissions-Policy: geolocation=(), microphone=(), camera=()'
);

/*
|--------------------------------------------------------------------------
| PSR-4-style application autoloader
|--------------------------------------------------------------------------
*/

spl_autoload_register(
    static function (
        string $class
    ): void {
        $prefix = 'App\\';

        if (
            !str_starts_with(
                $class,
                $prefix
            )
        ) {
            return;
        }

        $relativeClass = substr(
            $class,
            strlen($prefix)
        );

        $file = APP_PATH
            . '/'
            . str_replace(
                '\\',
                '/',
                $relativeClass
            )
            . '.php';

        if (is_file($file)) {
            require_once $file;
        }
    }
);

/*
|--------------------------------------------------------------------------
| Start session
|--------------------------------------------------------------------------
*/

\App\Core\Session::start();

/*
|--------------------------------------------------------------------------
| Load routes
|--------------------------------------------------------------------------
*/

$routesFile = ROUTES_PATH . '/web.php';

if (is_file($routesFile)) {
    require $routesFile;
}

/*
|--------------------------------------------------------------------------
| Dispatch request
|--------------------------------------------------------------------------
*/

\App\Core\Router::dispatch();
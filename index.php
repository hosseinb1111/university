<?php

// ...

declare(strict_types=1);

/**
 * =========================================================
 * Sadra University Website
 * InfinityFree Entry Point
 * =========================================================
 *
 * Expected production structure:
 *
 * /home/vol11_8/infinityfree.com/if0_42699241/htdocs/
 *
 * ├── index.php
 * ├── .htaccess
 * ├── .env
 * ├── app/
 * │   ├── Core/
 * │   ├── Controllers/
 * │   ├── Helpers/
 * │   ├── Middleware/
 * │   ├── Models/
 * │   └── Views/
 * ├── config/
 * ├── routes/
 * ├── storage/
 * └── assets/
 *
 * =========================================================
 */


/*
|--------------------------------------------------------------------------
| Application paths
|--------------------------------------------------------------------------
*/

define(
    'PUBLIC_PATH',
    __DIR__
);

define(
    'BASE_PATH',
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
| Temporary deployment diagnostics
|--------------------------------------------------------------------------
|
| Keep enabled until the application is confirmed working.
| After deployment is stable, disable display_errors.
|
|--------------------------------------------------------------------------
*/

error_reporting(
    E_ALL
);

ini_set(
    'display_errors',
    '1'
);

ini_set(
    'display_startup_errors',
    '1'
);

ini_set(
    'log_errors',
    '1'
);


/*
|--------------------------------------------------------------------------
| Validate required directories
|--------------------------------------------------------------------------
*/

$requiredDirectories = [
    APP_PATH,
    CONFIG_PATH,
    ROUTES_PATH,
];

foreach (
    $requiredDirectories
    as $directory
) {
    if (
        !is_dir($directory)
    ) {
        http_response_code(500);

        echo '<!doctype html>';
        echo '<html lang="en">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<title>Sadra deployment error</title>';
        echo '<style>';
        echo 'body{margin:0;padding:40px;background:#f8fafc;color:#172033;font-family:Arial,sans-serif}';
        echo '.card{max-width:800px;margin:0 auto;background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:30px;box-shadow:0 10px 30px rgba(0,0,0,.05)}';
        echo 'code{display:block;margin-top:12px;padding:14px;background:#f1f5f9;border-radius:10px;word-break:break-all}';
        echo '</style>';
        echo '</head>';
        echo '<body>';
        echo '<div class="card">';
        echo '<h1>Sadra deployment error</h1>';
        echo '<p>Required directory not found:</p>';
        echo '<code>';
        echo htmlspecialchars(
            $directory,
            ENT_QUOTES,
            'UTF-8'
        );
        echo '</code>';
        echo '</div>';
        echo '</body>';
        echo '</html>';

        exit;
    }
}


/*
|--------------------------------------------------------------------------
| Load .env
|--------------------------------------------------------------------------
*/

$envFile =
    BASE_PATH . '/.env';

if (
    is_file($envFile)
) {
    $lines =
        file(
            $envFile,
            FILE_IGNORE_NEW_LINES
            | FILE_SKIP_EMPTY_LINES
        );

    if (
        $lines !== false
    ) {
        foreach (
            $lines
            as $line
        ) {
            $line =
                trim($line);

            if (
                $line === ''
                || str_starts_with(
                    $line,
                    '#'
                )
            ) {
                continue;
            }

            $parts =
                explode(
                    '=',
                    $line,
                    2
                );

            if (
                count($parts) !== 2
            ) {
                continue;
            }

            $key =
                trim(
                    $parts[0]
                );

            $value =
                trim(
                    $parts[1]
                );

            /*
             * Remove surrounding quotes.
             */
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
                $value =
                    substr(
                        $value,
                        1,
                        -1
                    );
            }

            /*
             * Do not overwrite values already provided
             * by the hosting environment.
             */
            if (
                getenv($key) === false
                && !isset($_ENV[$key])
                && !isset($_SERVER[$key])
            ) {
                putenv(
                    $key
                    . '='
                    . $value
                );

                $_ENV[$key] =
                    $value;

                $_SERVER[$key] =
                    $value;
            }
        }
    }
}


/*
|--------------------------------------------------------------------------
| Load helper functions
|--------------------------------------------------------------------------
*/

$envHelper =
    APP_PATH
    . '/Helpers/env.php';

$configHelper =
    APP_PATH
    . '/Helpers/config.php';

if (
    !is_file($envHelper)
) {
    throw new RuntimeException(
        'Missing helper file: '
        . $envHelper
    );
}

if (
    !is_file($configHelper)
) {
    throw new RuntimeException(
        'Missing helper file: '
        . $configHelper
    );
}

require_once $envHelper;

require_once $configHelper;
require_once APP_PATH . '/Helpers/jalali.php';


/*
|--------------------------------------------------------------------------
| Load application configuration
|--------------------------------------------------------------------------
*/

$appConfigFile =
    CONFIG_PATH
    . '/app.php';

if (
    !is_file($appConfigFile)
) {
    throw new RuntimeException(
        'Missing application configuration: '
        . $appConfigFile
    );
}

$appConfig =
    require $appConfigFile;

if (
    !is_array($appConfig)
) {
    throw new RuntimeException(
        'config/app.php must return an array.'
    );
}


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
| Response encoding
|--------------------------------------------------------------------------
*/

header(
    'Content-Type: text/html; charset=UTF-8'
);


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
|
| Example:
|
| App\Core\Database
|       ↓
| app/Core/Database.php
|
|--------------------------------------------------------------------------
*/

spl_autoload_register(
    static function (
        string $class
    ): void {
        $prefix =
            'App\\';

        if (
            !str_starts_with(
                $class,
                $prefix
            )
        ) {
            return;
        }

        $relativeClass =
            substr(
                $class,
                strlen($prefix)
            );

        $relativePath =
            str_replace(
                '\\',
                DIRECTORY_SEPARATOR,
                $relativeClass
            );

        $file =
            APP_PATH
            . DIRECTORY_SEPARATOR
            . $relativePath
            . '.php';

        if (
            is_file($file)
        ) {
            require_once $file;

            return;
        }

        /*
         * During deployment, provide a useful error rather
         * than silently failing and producing "Class not found".
         */
        throw new RuntimeException(
            'Autoload failed. Class file not found: '
            . $file
        );
    }
);


/*
|--------------------------------------------------------------------------
| Verify critical framework files
|--------------------------------------------------------------------------
*/

$criticalFiles = [
    APP_PATH . '/Core/Database.php',
    APP_PATH . '/Core/Session.php',
    APP_PATH . '/Core/Router.php',
    APP_PATH . '/Core/Response.php',
    APP_PATH . '/Core/View.php',
];

foreach (
    $criticalFiles
    as $file
) {
    if (
        !is_file($file)
    ) {
        throw new RuntimeException(
            'Required application file not found: '
            . $file
        );
    }
}


/*
|--------------------------------------------------------------------------
| Verify important helper files
|--------------------------------------------------------------------------
*/

$helperFiles = [
    APP_PATH . '/Helpers/env.php',
    APP_PATH . '/Helpers/config.php',
];

foreach (
    $helperFiles
    as $file
) {
    if (
        !is_file($file)
    ) {
        throw new RuntimeException(
            'Required helper file not found: '
            . $file
        );
    }
}


/*
|--------------------------------------------------------------------------
| Verify routes
|--------------------------------------------------------------------------
*/

$routesFile =
    ROUTES_PATH
    . '/web.php';

if (
    !is_file($routesFile)
) {
    throw new RuntimeException(
        'Routes file not found: '
        . $routesFile
    );
}


/*
|--------------------------------------------------------------------------
| Verify Database class can be loaded
|--------------------------------------------------------------------------
*/

if (
    !class_exists(
        \App\Core\Database::class
    )
) {
    throw new RuntimeException(
        'App\\Core\\Database could not be loaded. '
        . 'Expected file: '
        . APP_PATH
        . '/Core/Database.php'
    );
}


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

require $routesFile;


/*
|--------------------------------------------------------------------------
| Dispatch request
|--------------------------------------------------------------------------
*/

\App\Core\Router::dispatch();


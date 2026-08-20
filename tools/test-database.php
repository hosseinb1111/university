<?php

declare(strict_types=1);

define(
    'BASE_PATH',
    dirname(__DIR__)
);

define(
    'APP_PATH',
    BASE_PATH . '/app'
);

define(
    'CONFIG_PATH',
    BASE_PATH . '/config'
);

/*
|--------------------------------------------------------------------------
| Load .env
|--------------------------------------------------------------------------
*/

$envFile = BASE_PATH . '/.env';

if (!is_file($envFile)) {
    fwrite(
        STDERR,
        ".env file not found.\n"
    );

    exit(1);
}

$lines = file(
    $envFile,
    FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
);

if ($lines !== false) {
    foreach ($lines as $line) {
        $line = trim($line);

        if (
            $line === ''
            || str_starts_with($line, '#')
        ) {
            continue;
        }

        $parts = explode(
            '=',
            $line,
            2
        );

        if (count($parts) !== 2) {
            continue;
        }

        $key = trim($parts[0]);
        $value = trim($parts[1]);

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

        putenv(
            $key . '=' . $value
        );

        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

/*
|--------------------------------------------------------------------------
| Environment helper
|--------------------------------------------------------------------------
*/

function env(
    string $key,
    mixed $default = null
): mixed {
    $value = getenv($key);

    return $value === false
        ? $default
        : $value;
}

/*
|--------------------------------------------------------------------------
| Database configuration
|--------------------------------------------------------------------------
*/

$dbHost = env(
    'DB_HOST',
    '127.0.0.1'
);

$dbPort = (int) env(
    'DB_PORT',
    3306
);

$dbName = env(
    'DB_DATABASE',
    'sadra'
);

$dbUsername = env(
    'DB_USERNAME',
    'root'
);

$dbPassword = env(
    'DB_PASSWORD',
    ''
);

$dbCharset = env(
    'DB_CHARSET',
    'utf8mb4'
);

$dsn = sprintf(
    'mysql:host=%s;port=%d;dbname=%s;charset=%s',
    $dbHost,
    $dbPort,
    $dbName,
    $dbCharset
);

try {
    $pdo = new PDO(
        $dsn,
        $dbUsername,
        $dbPassword,
        [
            PDO::ATTR_ERRMODE =>
                PDO::ERRMODE_EXCEPTION,

            PDO::ATTR_DEFAULT_FETCH_MODE =>
                PDO::FETCH_ASSOC,

            PDO::ATTR_EMULATE_PREPARES =>
                false,
        ]
    );

    $result = $pdo->query(
        'SELECT DATABASE() AS database_name'
    )->fetch();

    echo PHP_EOL;
    echo "Database connection: OK" . PHP_EOL;
    echo "Database: "
        . ($result['database_name'] ?? 'unknown')
        . PHP_EOL;
    echo PHP_EOL;

    exit(0);

} catch (PDOException $exception) {

    fwrite(
        STDERR,
        PHP_EOL
        . "Database connection FAILED"
        . PHP_EOL
        . $exception->getMessage()
        . PHP_EOL
    );

    exit(1);
}
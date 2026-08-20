<?php

declare(strict_types=1);

/**
 * =========================================================
 * Sadra CLI
 * Create User
 * =========================================================
 *
 * Usage:
 *
 * php tools/create-user.php
 *
 * The script interactively asks for:
 *
 * - username
 * - email
 * - first name
 * - last name
 * - role
 * - password
 *
 * Passwords are hashed with password_hash().
 *
 * No plain-text password is stored in the database.
 * =========================================================
 */

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
        "ERROR: .env file not found.\n"
    );

    exit(1);
}

$lines = file(
    $envFile,
    FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
);

if ($lines === false) {
    fwrite(
        STDERR,
        "ERROR: Unable to read .env.\n"
    );

    exit(1);
}

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
| PDO connection
|--------------------------------------------------------------------------
*/

$host = env(
    'DB_HOST',
    '127.0.0.1'
);

$port = (int) env(
    'DB_PORT',
    3306
);

$database = env(
    'DB_DATABASE',
    'sadra'
);

$username = env(
    'DB_USERNAME',
    'root'
);

$dbPassword = env(
    'DB_PASSWORD',
    ''
);

$charset = env(
    'DB_CHARSET',
    'utf8mb4'
);

$dsn = sprintf(
    'mysql:host=%s;port=%d;dbname=%s;charset=%s',
    $host,
    $port,
    $database,
    $charset
);

try {
    $pdo = new PDO(
        $dsn,
        $username,
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
} catch (
    PDOException $exception
) {
    fwrite(
        STDERR,
        "ERROR: Database connection failed.\n"
    );

    fwrite(
        STDERR,
        $exception->getMessage()
        . PHP_EOL
    );

    exit(1);
}

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

function prompt(
    string $message
): string {
    echo $message . ': ';

    $value = fgets(
        STDIN
    );

    if ($value === false) {
        return '';
    }

    return trim(
        $value
    );
}

function promptHidden(
    string $message
): string {
    echo $message . ': ';

    /*
     * Windows does not always provide `stty`.
     * We therefore use a cross-platform approach:
     *
     * - Unix/macOS: hide terminal input with stty.
     * - Windows: fallback to normal input if stty isn't available.
     */
    if (
        strtoupper(
            substr(
                PHP_OS,
                0,
                3
            )
        ) !== 'WIN'
        && function_exists('shell_exec')
    ) {
        $sttyMode = shell_exec(
            'stty -g 2>/dev/null'
        );

        if (
            is_string($sttyMode)
            && trim($sttyMode) !== ''
        ) {
            shell_exec(
                'stty -echo'
            );

            $value = fgets(
                STDIN
            );

            shell_exec(
                'stty ' . trim($sttyMode)
            );

            echo PHP_EOL;

            return trim(
                (string) $value
            );
        }
    }

    /*
     * Windows fallback.
     */
    $value = fgets(
        STDIN
    );

    echo PHP_EOL;

    return trim(
        (string) $value
    );
}

/*
|--------------------------------------------------------------------------
| Collect data
|--------------------------------------------------------------------------
*/

echo PHP_EOL;
echo "========================================" . PHP_EOL;
echo " Sadra User Creator" . PHP_EOL;
echo "========================================" . PHP_EOL;
echo PHP_EOL;

$username = prompt(
    'Username'
);

if ($username === '') {
    fwrite(
        STDERR,
        "ERROR: Username cannot be empty.\n"
    );

    exit(1);
}

if (
    !preg_match(
        '/^[A-Za-z0-9._-]{3,100}$/',
        $username
    )
) {
    fwrite(
        STDERR,
        "ERROR: Username may contain only letters, numbers, dots, underscores and hyphens.\n"
    );

    exit(1);
}

$email = prompt(
    'Email'
);

if (
    $email !== ''
    && filter_var(
        $email,
        FILTER_VALIDATE_EMAIL
    ) === false
) {
    fwrite(
        STDERR,
        "ERROR: Invalid email address.\n"
    );

    exit(1);
}

$firstName = prompt(
    'First name'
);

$lastName = prompt(
    'Last name'
);

echo PHP_EOL;

echo "Available roles:" . PHP_EOL;
echo "1. teacher" . PHP_EOL;
echo "2. editor" . PHP_EOL;
echo "3. admin" . PHP_EOL;
echo "4. super_admin" . PHP_EOL;
echo PHP_EOL;

$roleNumber = prompt(
    'Role [1]'
);

$roles = [
    '1' => 'teacher',
    '2' => 'editor',
    '3' => 'admin',
    '4' => 'super_admin',
];

$role = $roles[
    $roleNumber
] ?? 'teacher';

echo PHP_EOL;

$password = promptHidden(
    'Password'
);

if (
    strlen($password)
    < 8
) {
    fwrite(
        STDERR,
        "ERROR: Password must be at least 8 characters.\n"
    );

    exit(1);
}

$passwordConfirmation = promptHidden(
    'Confirm password'
);

if (
    !hash_equals(
        $password,
        $passwordConfirmation
    )
) {
    fwrite(
        STDERR,
        "ERROR: Passwords do not match.\n"
    );

    exit(1);
}

/*
|--------------------------------------------------------------------------
| Check for duplicate username
|--------------------------------------------------------------------------
*/

$existingUsername = $pdo->prepare(
    '
    SELECT id
    FROM users
    WHERE username = :username
    LIMIT 1
    '
);

$existingUsername->execute([
    'username' => $username,
]);

if (
    $existingUsername->fetch()
) {
    fwrite(
        STDERR,
        "ERROR: Username already exists.\n"
    );

    exit(1);
}

/*
|--------------------------------------------------------------------------
| Check for duplicate email
|--------------------------------------------------------------------------
*/

if ($email !== '') {
    $existingEmail = $pdo->prepare(
        '
        SELECT id
        FROM users
        WHERE email = :email
        LIMIT 1
        '
    );

    $existingEmail->execute([
        'email' => $email,
    ]);

    if (
        $existingEmail->fetch()
    ) {
        fwrite(
            STDERR,
            "ERROR: Email already exists.\n"
        );

        exit(1);
    }
}

/*
|--------------------------------------------------------------------------
| Hash password
|--------------------------------------------------------------------------
*/

$hash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

if (
    !is_string($hash)
    || $hash === ''
) {
    fwrite(
        STDERR,
        "ERROR: Password hashing failed.\n"
    );

    exit(1);
}

/*
|--------------------------------------------------------------------------
| Insert user
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare(
    '
    INSERT INTO users (
        username,
        email,
        password,
        first_name,
        last_name,
        role,
        is_active
    )
    VALUES (
        :username,
        :email,
        :password,
        :first_name,
        :last_name,
        :role,
        1
    )
    '
);

$stmt->execute([
    'username' => $username,

    'email' =>
        $email === ''
        ? null
        : $email,

    'password' =>
        $hash,

    'first_name' =>
        $firstName === ''
        ? null
        : $firstName,

    'last_name' =>
        $lastName === ''
        ? null
        : $lastName,

    'role' =>
        $role,
]);

$userId = (int) (
    $pdo->lastInsertId()
);

echo PHP_EOL;
echo "========================================" . PHP_EOL;
echo " User created successfully" . PHP_EOL;
echo "========================================" . PHP_EOL;
echo "ID:       {$userId}" . PHP_EOL;
echo "Username: {$username}" . PHP_EOL;
echo "Role:     {$role}" . PHP_EOL;
echo PHP_EOL;
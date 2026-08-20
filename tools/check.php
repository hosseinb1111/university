<?php

declare(strict_types=1);

/**
 * =========================================================
 * Sadra University Website
 * Project Integrity Checker
 * =========================================================
 *
 * Checks:
 * - PHP syntax errors
 * - Required directories
 * - Required configuration files
 * - Required application files
 * - Environment configuration
 *
 * Run:
 *
 *     php tools/check.php
 *
 * =========================================================
 */

$projectRoot = dirname(__DIR__);

$errors = [];

$warnings = [];

$successes = [];


/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

function line(): void
{
    echo str_repeat(
        '=',
        72
    ) . PHP_EOL;
}

function success(
    string $message
): void {
    echo
        "\033[32m✓\033[0m "
        . $message
        . PHP_EOL;
}

function warning(
    string $message
): void {
    echo
        "\033[33m!\033[0m "
        . $message
        . PHP_EOL;
}

function error(
    string $message
): void {
    echo
        "\033[31m✗\033[0m "
        . $message
        . PHP_EOL;
}

function checkFile(
    string $path,
    array &$errors,
    array &$successes
): bool {
    if (
        !is_file($path)
    ) {
        $errors[] =
            'Missing file: '
            . $path;

        error(
            'Missing file: '
            . $path
        );

        return false;
    }

    success(
        'Found: '
        . $path
    );

    $successes[] =
        $path;

    return true;
}

function checkDirectory(
    string $path,
    array &$errors,
    array &$warnings
): bool {
    if (
        !is_dir($path)
    ) {
        $errors[] =
            'Missing directory: '
            . $path;

        error(
            'Missing directory: '
            . $path
        );

        return false;
    }

    if (
        !is_readable($path)
    ) {
        $warnings[] =
            'Directory is not readable: '
            . $path;

        warning(
            'Directory is not readable: '
            . $path
        );
    }

    return true;
}


/*
|--------------------------------------------------------------------------
| Header
|--------------------------------------------------------------------------
*/

line();

echo "Sadra University Website" . PHP_EOL;
echo "Project Integrity Checker" . PHP_EOL;

line();


/*
|--------------------------------------------------------------------------
| PHP Version
|--------------------------------------------------------------------------
*/

echo PHP_EOL;
echo "[1] PHP version" . PHP_EOL;

$phpVersion =
    PHP_VERSION;

echo "Running PHP "
    . $phpVersion
    . PHP_EOL;

if (
    version_compare(
        $phpVersion,
        '8.1.0',
        '<'
    )
) {
    error(
        'PHP 8.1 or newer is required.'
    );

    $errors[] =
        'Unsupported PHP version: '
        . $phpVersion;
} else {
    success(
        'PHP version is supported.'
    );
}


/*
|--------------------------------------------------------------------------
| Required Extensions
|--------------------------------------------------------------------------
*/

echo PHP_EOL;
echo "[2] Required PHP extensions" . PHP_EOL;

$requiredExtensions = [
    'PDO',
    'pdo_mysql',
    'mbstring',
    'fileinfo',
    'openssl',
];

foreach (
    $requiredExtensions
    as $extension
) {
    if (
        extension_loaded(
            $extension
        )
    ) {
        success(
            'Extension loaded: '
            . $extension
        );
    } else {
        error(
            'Missing PHP extension: '
            . $extension
        );

        $errors[] =
            'Missing extension: '
            . $extension;
    }
}


/*
|--------------------------------------------------------------------------
| Required Directories
|--------------------------------------------------------------------------
*/

echo PHP_EOL;
echo "[3] Required directories" . PHP_EOL;

$directories = [
    $projectRoot . '/app',
    $projectRoot . '/app/Core',
    $projectRoot . '/app/Controllers',
    $projectRoot . '/app/Middleware',
    $projectRoot . '/app/Models',
    $projectRoot . '/app/Views',
    $projectRoot . '/config',
    $projectRoot . '/database',
    $projectRoot . '/public',
    $projectRoot . '/public/assets',
    $projectRoot . '/public/assets/css',
    $projectRoot . '/public/assets/js',
    $projectRoot . '/routes',
    $projectRoot . '/storage',
    $projectRoot . '/storage/uploads',
    $projectRoot . '/storage/uploads/documents',
    $projectRoot . '/storage/uploads/images',
    $projectRoot . '/storage/uploads/media',
    $projectRoot . '/tools',
];

foreach (
    $directories
    as $directory
) {
    checkDirectory(
        $directory,
        $errors,
        $warnings
    );
}


/*
|--------------------------------------------------------------------------
| Required Files
|--------------------------------------------------------------------------
*/

echo PHP_EOL;
echo "[4] Required application files" . PHP_EOL;

$requiredFiles = [
    'config/app.php',

    'routes/web.php',

    'app/Core/Database.php',
    'app/Core/Response.php',
    'app/Core/Router.php',
    'app/Core/Session.php',
    'app/Core/View.php',
    'app/Core/Csrf.php',

    'app/Middleware/RequireAuth.php',
    'app/Middleware/RequireRole.php',

    'app/Models/User.php',
    'app/Models/Announcement.php',
    'app/Models/Page.php',
    'app/Models/Navigation.php',
    'app/Models/Document.php',
    'app/Models/DocumentCategory.php',
    'app/Models/Media.php',

    'app/Controllers/AnnouncementController.php',
    'app/Controllers/PageController.php',
    'app/Controllers/NavigationController.php',
    'app/Controllers/DocumentController.php',
    'app/Controllers/MediaController.php',

    'database/schema.sql',

    'public/index.php',

    'app/Views/layouts/app.php',
    'app/Views/layouts/admin.php',

    'app/Views/admin/dashboard.php',
    'app/Views/admin/partials/header.php',
    'app/Views/admin/partials/sidebar.php',

    'app/Views/admin/announcements/index.php',
    'app/Views/admin/announcements/create.php',
    'app/Views/admin/announcements/edit.php',
    'app/Views/admin/announcements/_form.php',

    'app/Views/admin/pages/index.php',
    'app/Views/admin/pages/create.php',
    'app/Views/admin/pages/edit.php',
    'app/Views/admin/pages/_form.php',

    'app/Views/admin/navigation/index.php',
    'app/Views/admin/navigation/create.php',
    'app/Views/admin/navigation/edit.php',
    'app/Views/admin/navigation/_form.php',

    'app/Views/admin/documents/index.php',
    'app/Views/admin/documents/create.php',
    'app/Views/admin/documents/edit.php',

    'app/Views/admin/media/index.php',
    'app/Views/admin/media/create.php',

    'app/Views/errors/403.php',
    'app/Views/errors/404.php',

    'public/assets/css/app.css',
    'public/assets/css/admin.css',
    'public/assets/css/announcements.css',
    'public/assets/css/media.css',
    'public/assets/js/admin.js',
];

foreach (
    $requiredFiles
    as $relativePath
) {
    checkFile(
        $projectRoot
        . '/'
        . $relativePath,
        $errors,
        $successes
    );
}


/*
|--------------------------------------------------------------------------
| PHP Syntax Check
|--------------------------------------------------------------------------
*/

echo PHP_EOL;
echo "[5] PHP syntax check" . PHP_EOL;

$phpFiles = [];

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(
        $projectRoot,
        FilesystemIterator::SKIP_DOTS
    )
);

foreach (
    $iterator
    as $file
) {
    if (
        !$file->isFile()
    ) {
        continue;
    }

    $filename =
        $file->getFilename();

    if (
        !str_ends_with(
            $filename,
            '.php'
        )
    ) {
        continue;
    }

    $fullPath =
        $file->getPathname();

    /*
     * Skip vendor if present.
     */
    if (
        str_contains(
            $fullPath,
            DIRECTORY_SEPARATOR
            . 'vendor'
            . DIRECTORY_SEPARATOR
        )
    ) {
        continue;
    }

    $phpFiles[] =
        $fullPath;
}

sort(
    $phpFiles
);

foreach (
    $phpFiles
    as $phpFile
) {
    $relativePath =
        ltrim(
            str_replace(
                $projectRoot,
                '',
                $phpFile
            ),
            DIRECTORY_SEPARATOR
        );

    $command =
        escapeshellarg(
            PHP_BINARY
        )
        . ' -l '
        . escapeshellarg(
            $phpFile
        );

    $output = [];

    $exitCode = 0;

    exec(
        $command
        . ' 2>&1',
        $output,
        $exitCode
    );

    if (
        $exitCode === 0
    ) {
        success(
            $relativePath
        );
    } else {
        error(
            $relativePath
            . PHP_EOL
            . '    '
            . implode(
                PHP_EOL . '    ',
                $output
            )
        );

        $errors[] =
            'PHP syntax error: '
            . $relativePath;
    }
}


/*
|--------------------------------------------------------------------------
| .env Check
|--------------------------------------------------------------------------
*/

echo PHP_EOL;
echo "[6] Environment configuration" . PHP_EOL;

$envFile =
    $projectRoot
    . '/.env';

if (
    is_file($envFile)
) {
    success(
        '.env exists.'
    );
} else {
    warning(
        '.env does not exist. The application may rely entirely on defaults.'
    );

    $warnings[] =
        '.env file is missing.';
}


/*
|--------------------------------------------------------------------------
| Storage Check
|--------------------------------------------------------------------------
*/

echo PHP_EOL;
echo "[7] Storage permissions" . PHP_EOL;

$storageDirectories = [
    $projectRoot
    . '/storage',

    $projectRoot
    . '/storage/uploads',

    $projectRoot
    . '/storage/uploads/documents',

    $projectRoot
    . '/storage/uploads/images',

    $projectRoot
    . '/storage/uploads/media',
];

foreach (
    $storageDirectories
    as $directory
) {
    if (
        is_writable($directory)
    ) {
        success(
            'Writable: '
            . $directory
        );
    } else {
        warning(
            'Not writable: '
            . $directory
        );

        $warnings[] =
            'Storage directory is not writable: '
            . $directory;
    }
}


/*
|--------------------------------------------------------------------------
| Summary
|--------------------------------------------------------------------------
*/

echo PHP_EOL;
line();

echo "RESULT" . PHP_EOL;

line();

echo "PHP files checked: "
    . count($phpFiles)
    . PHP_EOL;

echo "Successful checks: "
    . count($successes)
    . PHP_EOL;

echo "Errors: "
    . count($errors)
    . PHP_EOL;

echo "Warnings: "
    . count($warnings)
    . PHP_EOL;

line();

if (
    $errors !== []
) {
    error(
        'PROJECT CHECK FAILED.'
    );

    echo PHP_EOL;
    echo "Fix the errors above before continuing."
        . PHP_EOL;

    exit(1);
}

if (
    $warnings !== []
) {
    warning(
        'PROJECT CHECK PASSED WITH WARNINGS.'
    );

    exit(0);
}

success(
    'PROJECT CHECK PASSED.'
);

exit(0);
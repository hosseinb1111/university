<?php

declare(strict_types=1);

/**
 * Read a configuration value using dot notation.
 *
 * Example:
 *
 * config('app.name');
 * config('app.debug', false);
 * config('database.host');
 */
function config(
    string $key,
    mixed $default = null
): mixed {
    static $configs = [];

    $segments = explode('.', $key);

    $file = array_shift($segments);

    if ($file === null || $file === '') {
        return $default;
    }

    if (!array_key_exists($file, $configs)) {
        $path = BASE_PATH . '/config/' . $file . '.php';

        if (!is_file($path)) {
            return $default;
        }

        $configs[$file] = require $path;
    }

    $value = $configs[$file];

    foreach ($segments as $segment) {
        if (
            !is_array($value)
            || !array_key_exists($segment, $value)
        ) {
            return $default;
        }

        $value = $value[$segment];
    }

    return $value;
}
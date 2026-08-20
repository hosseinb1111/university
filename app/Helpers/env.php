<?php

declare(strict_types=1);

/**
 * Get an environment variable.
 *
 * Priority:
 * 1. $_ENV
 * 2. $_SERVER
 * 3. getenv()
 * 4. Default value
 */
function env(
    string $key,
    mixed $default = null
): mixed {
    if (array_key_exists($key, $_ENV)) {
        return $_ENV[$key];
    }

    if (array_key_exists($key, $_SERVER)) {
        return $_SERVER[$key];
    }

    $value = getenv($key);

    if ($value !== false) {
        return $value;
    }

    return $default;
}
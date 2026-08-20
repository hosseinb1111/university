<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

final class Csrf
{
    private const SESSION_KEY = '_csrf_token';

    /**
     * Get the current CSRF token, creating one when necessary.
     */
    public static function token(): string
    {
        Session::start();

        $token = Session::get(self::SESSION_KEY);

        if (
            is_string($token)
            && strlen($token) >= 32
        ) {
            return $token;
        }

        try {
            $token = bin2hex(
                random_bytes(
                    (int) config(
                        'app.security.csrf_token_bytes',
                        32
                    )
                )
            );
        } catch (\Throwable $exception) {
            throw new RuntimeException(
                'Unable to generate CSRF token.',
                0,
                $exception
            );
        }

        Session::put(
            self::SESSION_KEY,
            $token
        );

        return $token;
    }

    /**
     * Return a hidden form field.
     */
    public static function field(): string
    {
        return sprintf(
            '<input type="hidden" name="_csrf" value="%s">',
            htmlspecialchars(
                self::token(),
                ENT_QUOTES | ENT_SUBSTITUTE,
                'UTF-8'
            )
        );
    }

    /**
     * Verify a submitted token.
     */
    public static function verify(
        ?string $token
    ): bool {
        if (
            $token === null
            || $token === ''
        ) {
            return false;
        }

        $stored = Session::get(
            self::SESSION_KEY
        );

        if (
            !is_string($stored)
            || $stored === ''
        ) {
            return false;
        }

        return hash_equals(
            $stored,
            $token
        );
    }

    /**
     * Require a valid token or return a 419 response.
     */
    public static function requireValid(
        ?string $token = null
    ): void {
        $token ??= isset($_POST['_csrf'])
            ? (string) $_POST['_csrf']
            : null;

        if (
            !self::verify($token)
        ) {
            Response::sessionExpired(
                'درخواست نامعتبر یا منقضی شده است. لطفاً صفحه را تازه‌سازی کرده و دوباره تلاش کنید.'
            );
        }
    }

    /**
     * Rotate the CSRF token.
     *
     * Useful after authentication/session changes.
     */
    public static function regenerate(): string
    {
        Session::start();

        try {
            $token = bin2hex(
                random_bytes(
                    (int) config(
                        'app.security.csrf_token_bytes',
                        32
                    )
                )
            );
        } catch (\Throwable $exception) {
            throw new RuntimeException(
                'Unable to regenerate CSRF token.',
                0,
                $exception
            );
        }

        Session::put(
            self::SESSION_KEY,
            $token
        );

        return $token;
    }
}
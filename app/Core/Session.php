<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\User;
use RuntimeException;

final class Session
{
    private const FLASH_KEY = '_flash';

    private const USER_ID_KEY = 'auth_user_id';

    private const AUTHENTICATED_KEY = 'authenticated';

    /**
     * Start the session if it is not active.
     */
    public static function start(): void
    {
        if (
            session_status()
            === PHP_SESSION_ACTIVE
        ) {
            return;
        }

        $config = config(
            'app.session',
            []
        );

        $name = (string) (
            $config['name']
            ?? 'sadra_session'
        );

        $secure = (bool) (
            $config['secure']
            ?? false
        );

        $sameSite = (string) (
            $config['same_site']
            ?? 'Lax'
        );

        session_name(
            $name
        );

        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'secure' => $secure,
            'httponly' => true,
            'samesite' => $sameSite,
        ]);

        if (
            !session_start()
        ) {
            throw new RuntimeException(
                'Unable to start the session.'
            );
        }
    }

    public static function active(): bool
    {
        return session_status()
            === PHP_SESSION_ACTIVE;
    }

    public static function put(
        string $key,
        mixed $value
    ): void {
        self::start();

        $_SESSION[$key] = $value;
    }

    public static function get(
        string $key,
        mixed $default = null
    ): mixed {
        self::start();

        return $_SESSION[$key]
            ?? $default;
    }

    public static function has(
        string $key
    ): bool {
        self::start();

        return array_key_exists(
            $key,
            $_SESSION
        );
    }

    public static function forget(
        string $key
    ): void {
        self::start();

        unset(
            $_SESSION[$key]
        );
    }

    public static function pull(
        string $key,
        mixed $default = null
    ): mixed {
        self::start();

        if (
            !array_key_exists(
                $key,
                $_SESSION
            )
        ) {
            return $default;
        }

        $value = $_SESSION[$key];

        unset(
            $_SESSION[$key]
        );

        return $value;
    }

    public static function all(): array
    {
        self::start();

        return $_SESSION;
    }

    public static function flash(
        string $key,
        mixed $value
    ): void {
        self::start();

        if (
            !isset(
                $_SESSION[self::FLASH_KEY]
            )
            || !is_array(
                $_SESSION[self::FLASH_KEY]
            )
        ) {
            $_SESSION[self::FLASH_KEY] = [];
        }

        $_SESSION[
            self::FLASH_KEY
        ][$key] = $value;
    }

    public static function getFlash(
        string $key,
        mixed $default = null
    ): mixed {
        self::start();

        if (
            !isset(
                $_SESSION[self::FLASH_KEY]
            )
            || !is_array(
                $_SESSION[self::FLASH_KEY]
            )
        ) {
            return $default;
        }

        if (
            !array_key_exists(
                $key,
                $_SESSION[self::FLASH_KEY]
            )
        ) {
            return $default;
        }

        $value = $_SESSION[
            self::FLASH_KEY
        ][$key];

        unset(
            $_SESSION[
                self::FLASH_KEY
            ][$key]
        );

        return $value;
    }

    public static function hasFlash(
        string $key
    ): bool {
        self::start();

        return isset(
            $_SESSION[self::FLASH_KEY]
        )
        && is_array(
            $_SESSION[self::FLASH_KEY]
        )
        && array_key_exists(
            $key,
            $_SESSION[self::FLASH_KEY]
        );
    }

    public static function clearFlash(): void
    {
        self::start();

        unset(
            $_SESSION[self::FLASH_KEY]
        );
    }

    /**
     * Regenerate the session ID after authentication.
     */
    public static function regenerate(
        bool $deleteOldSession = true
    ): void {
        self::start();

        if (
            !session_regenerate_id(
                $deleteOldSession
            )
        ) {
            throw new RuntimeException(
                'Unable to regenerate the session ID.'
            );
        }
    }

    /**
     * Authenticate a user ID.
     */
    public static function login(
        int $userId
    ): void {
        self::start();

        self::regenerate(true);

        self::put(
            self::USER_ID_KEY,
            $userId
        );

        self::put(
            self::AUTHENTICATED_KEY,
            true
        );
    }

    /**
     * Is somebody authenticated?
     */
    public static function authenticated(): bool
    {
        self::start();

        $userId = self::get(
            self::USER_ID_KEY
        );

        return self::get(
            self::AUTHENTICATED_KEY,
            false
        ) === true
        && is_numeric($userId)
        && (int) $userId > 0;
    }

    /**
     * Current authenticated user ID.
     */
    public static function userId(): ?int
    {
        if (
            !self::authenticated()
        ) {
            return null;
        }

        return (int) self::get(
            self::USER_ID_KEY
        );
    }

    /**
     * Load the authenticated user.
     */
    public static function user(): ?array
    {
        $id = self::userId();

        if ($id === null) {
            return null;
        }

        $user = User::find(
            $id
        );

        /*
         * If the account was deleted/deactivated,
         * invalidate the current authentication.
         */
        if (
            $user === null
            || (int) (
                $user['is_active']
                ?? 0
            ) !== 1
        ) {
            self::forget(
                self::USER_ID_KEY
            );

            self::forget(
                self::AUTHENTICATED_KEY
            );

            return null;
        }

        return $user;
    }

    /**
     * Log out and destroy session.
     */
    public static function logout(): void
    {
        self::start();

        self::destroy();
    }

    /**
     * Completely destroy current session.
     */
    public static function destroy(): void
    {
        if (
            session_status()
            !== PHP_SESSION_ACTIVE
        ) {
            self::start();
        }

        $_SESSION = [];

        if (
            ini_get('session.use_cookies')
        ) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                [
                    'expires' => time() - 42000,
                    'path' =>
                        $params['path'] ?? '/',
                    'domain' =>
                        $params['domain'] ?? '',
                    'secure' =>
                        (bool) (
                            $params['secure']
                            ?? false
                        ),
                    'httponly' =>
                        (bool) (
                            $params['httponly']
                            ?? true
                        ),
                    'samesite' =>
                        $params['samesite']
                        ?? 'Lax',
                ]
            );
        }

        session_destroy();
    }

    /**
     * Save intended local URL.
     */
    public static function setIntendedUrl(
        string $url
    ): void {
        if (
            !str_starts_with(
                $url,
                '/'
            )
            || str_starts_with(
                $url,
                '//'
            )
        ) {
            $url = '/';
        }

        self::put(
            'intended_url',
            $url
        );
    }

    /**
     * Retrieve and clear intended local URL.
     */
    public static function pullIntendedUrl(
        string $default = '/'
    ): string {
        $url = self::pull(
            'intended_url',
            $default
        );

        if (
            !is_string($url)
            || !str_starts_with(
                $url,
                '/'
            )
            || str_starts_with(
                $url,
                '//'
            )
        ) {
            return $default;
        }

        return $url;
    }
}
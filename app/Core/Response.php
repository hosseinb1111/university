<?php

declare(strict_types=1);

namespace App\Core;

final class Response
{
    /**
     * Send a standard HTML response.
     */
    public static function send(
        string $content,
        int $status = 200,
        array $headers = []
    ): never {
        http_response_code(
            $status
        );

        self::sendHeaders(
            $headers
        );

        echo $content;

        exit;
    }

    /**
     * Send a plain-text response.
     */
    public static function text(
        string $content,
        int $status = 200,
        array $headers = []
    ): never {
        $headers = array_merge(
            [
                'Content-Type' =>
                    'text/plain; charset=UTF-8',

                'Cache-Control' =>
                    'public, max-age=3600',
            ],
            $headers
        );

        self::send(
            $content,
            $status,
            $headers
        );
    }

    /**
     * Send an XML response.
     */
    public static function xml(
        string $content,
        int $status = 200,
        array $headers = []
    ): never {
        $headers = array_merge(
            [
                'Content-Type' =>
                    'application/xml; charset=UTF-8',

                'Cache-Control' =>
                    'public, max-age=3600',
            ],
            $headers
        );

        self::send(
            $content,
            $status,
            $headers
        );
    }

    /**
     * Send a JSON response.
     *
     * @param mixed $data
     */
    public static function json(
        mixed $data,
        int $status = 200,
        array $headers = []
    ): never {
        $json = json_encode(
            $data,
            JSON_UNESCAPED_UNICODE
            | JSON_UNESCAPED_SLASHES
            | JSON_THROW_ON_ERROR
        );

        $headers = array_merge(
            [
                'Content-Type' =>
                    'application/json; charset=UTF-8',

                'Cache-Control' =>
                    'no-store',
            ],
            $headers
        );

        self::send(
            $json,
            $status,
            $headers
        );
    }

    /**
     * Redirect to an absolute or relative URL.
     */
    public static function redirect(
        string $url,
        int $status = 302
    ): never {
        $allowedStatuses = [
            301,
            302,
            303,
            307,
            308,
        ];

        if (
            !in_array(
                $status,
                $allowedStatuses,
                true
            )
        ) {
            $status = 302;
        }

        http_response_code(
            $status
        );

        header(
            'Location: '
            . $url,
            true,
            $status
        );

        exit;
    }

    /**
     * Redirect using a named route.
     *
     * @param array<string, scalar|null> $parameters
     */
    public static function redirectRoute(
        string $routeName,
        array $parameters = [],
        int $status = 302
    ): never {
        self::redirect(
            Router::route(
                $routeName,
                $parameters
            ),
            $status
        );
    }

    /**
     * Return a 404 response.
     */
    public static function notFound(
        string $message = 'صفحه مورد نظر پیدا نشد.'
    ): never {
        self::send(
            $message,
            404
        );
    }

    /**
     * Return a 403 response.
     */
    public static function forbidden(
        string $message = 'دسترسی به این بخش مجاز نیست.'
    ): never {
        self::send(
            $message,
            403
        );
    }

    /**
     * Return a 401 response.
     */
    public static function unauthorized(
        string $message = 'برای دسترسی به این بخش باید وارد حساب کاربری شوید.'
    ): never {
        self::send(
            $message,
            401
        );
    }

    /**
     * Return a 422 validation response.
     */
    public static function unprocessable(
        string $message = 'اطلاعات ارسال‌شده معتبر نیست.'
    ): never {
        self::send(
            $message,
            422
        );
    }

    /**
     * Return a 500 server-error response.
     */
    public static function serverError(
        string $message = 'خطای داخلی سرور رخ داده است.'
    ): never {
        self::send(
            $message,
            500
        );
    }

    /**
     * Send HTTP headers.
     *
     * @param array<string, string> $headers
     */
    private static function sendHeaders(
        array $headers
    ): void {
        foreach (
            $headers
            as $name => $value
        ) {
            header(
                $name
                . ': '
                . $value
            );
        }
    }
}
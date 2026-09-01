<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

final class Response
{
    /**
     * Send an HTTP response.
     */
    public static function send(
        string $content,
        int $status = 200,
        array $headers = []
    ): never {
        http_response_code(
            $status
        );

        foreach (
            $headers
            as $name => $value
        ) {
            header(
                $name . ': ' . $value
            );
        }

        echo $content;

        exit;
    }

    /**
     * Redirect to a URL.
     */
    public static function redirect(
        string $url,
        int $status = 302
    ): never {
        if (
            $status < 300
            || $status > 399
        ) {
            $status = 302;
        }

        header(
            'Location: '
            . $url,
            true,
            $status
        );

        exit;
    }

    /**
     * Redirect using a named application route.
     *
     * @param array<string, mixed> $parameters
     */
    public static function redirectRoute(
        string $routeName,
        array $parameters = [],
        int $status = 302
    ): never {
        $url =
            Router::route(
                $routeName,
                $parameters
            );

        self::redirect(
            $url,
            $status
        );
    }

    /**
     * Redirect back to the previous request.
     */
    public static function back(
        string $fallback = '/'
    ): never {
        $referer =
            $_SERVER['HTTP_REFERER']
            ?? '';

        if (
            !is_string($referer)
            || trim($referer) === ''
        ) {
            self::redirect(
                $fallback
            );
        }

        self::redirect(
            $referer
        );
    }

    /**
     * Render the public 404 page.
     */
    public static function notFound(
        string $message = 'صفحه مورد نظر پیدا نشد.'
    ): never {
        http_response_code(404);

        $content =
            View::render(
                'errors/404',
                [
                    'message' =>
                        $message,
                ]
            );

        echo View::renderIntoLayout(
            'layouts/app',
            'errors/404',
            [
                'title' =>
                    'صفحه پیدا نشد | صدرا',

                'description' =>
                    'صفحه مورد نظر در وب‌سایت موسسه آموزش عالی صدرالمتالهین پیدا نشد.',

                'message' =>
                    $message,
            ]
        );

        exit;
    }

    /**
     * Render the public 403 page.
     */
    public static function forbidden(
        string $message = 'دسترسی به این صفحه مجاز نیست.'
    ): never {
        http_response_code(403);

        echo View::renderIntoLayout(
            'layouts/app',
            'errors/403',
            [
                'title' =>
                    'دسترسی غیرمجاز | صدرا',

                'description' =>
                    'شما اجازه دسترسی به این صفحه را ندارید.',

                'message' =>
                    $message,
            ]
        );

        exit;
    }

    /**
     * Return a JSON response.
     *
     * @param mixed $data
     */
    public static function json(
        mixed $data,
        int $status = 200,
        array $headers = []
    ): never {
        http_response_code(
            $status
        );

        header(
            'Content-Type: application/json; charset=UTF-8'
        );

        foreach (
            $headers
            as $name => $value
        ) {
            header(
                $name . ': ' . $value
            );
        }

        try {
            $json =
                json_encode(
                    $data,
                    JSON_UNESCAPED_UNICODE
                    | JSON_UNESCAPED_SLASHES
                    | JSON_THROW_ON_ERROR
                );
        } catch (
            \JsonException $exception
        ) {
            throw new RuntimeException(
                'Unable to encode JSON response.',
                0,
                $exception
            );
        }

        echo $json;

        exit;
    }

    /**
     * Return an empty response.
     */
    public static function noContent(): never
    {
        http_response_code(204);

        exit;
    }

    /**
     * Return a plain-text error response.
     */
    public static function error(
        string $message,
        int $status = 500
    ): never {
        http_response_code(
            $status
        );

        echo View::render(
            'errors/404',
            [
                'message' =>
                    $message,
            ]
        );

        exit;
    }
}
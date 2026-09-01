<?php

declare(strict_types=1);

namespace App\Core;

use Closure;
use RuntimeException;

final class Router
{
    /**
     * Registered routes.
     *
     * @var array<int, array{
     *     method: string,
     *     path: string,
     *     handler: callable,
     *     name: string|null,
     *     middleware: array<int, mixed>
     * }>
     */
    private static array $routes = [];


    /**
     * Register a GET route.
     *
     * @param callable $handler
     * @param array<int, mixed> $middleware
     */
    public static function get(
        string $path,
        callable $handler,
        ?string $name = null,
        array $middleware = []
    ): void {
        self::add(
            'GET',
            $path,
            $handler,
            $name,
            $middleware
        );
    }


    /**
     * Register a POST route.
     *
     * @param callable $handler
     * @param array<int, mixed> $middleware
     */
    public static function post(
        string $path,
        callable $handler,
        ?string $name = null,
        array $middleware = []
    ): void {
        self::add(
            'POST',
            $path,
            $handler,
            $name,
            $middleware
        );
    }


    /**
     * Register a route.
     *
     * @param callable $handler
     * @param array<int, mixed> $middleware
     */
    private static function add(
        string $method,
        string $path,
        callable $handler,
        ?string $name,
        array $middleware
    ): void {
        $method =
            strtoupper(
                trim(
                    $method
                )
            );

        if (
            $method === ''
        ) {
            throw new RuntimeException(
                'Route HTTP method cannot be empty.'
            );
        }


        $path =
            self::normalizePath(
                $path
            );


        if (
            $name !== null
        ) {
            $name =
                trim(
                    $name
                );

            if (
                $name === ''
            ) {
                $name = null;
            }
        }


        foreach (
            self::$routes
            as $route
        ) {
            if (
                $route['method'] === $method
                && $route['path'] === $path
            ) {
                throw new RuntimeException(
                    sprintf(
                        'Route [%s %s] is already registered.',
                        $method,
                        $path
                    )
                );
            }


            if (
                $name !== null
                && $route['name'] === $name
            ) {
                throw new RuntimeException(
                    sprintf(
                        'Route name [%s] is already registered.',
                        $name
                    )
                );
            }
        }


        self::$routes[] = [
            'method' =>
                $method,

            'path' =>
                $path,

            'handler' =>
                $handler,

            'name' =>
                $name,

            'middleware' =>
                $middleware,
        ];
    }


    /**
     * Dispatch the current request.
     *
     * The returned route value is also emitted when it is a string.
     */
    public static function dispatch(): mixed
    {
        $method =
            strtoupper(
                (string) (
                    $_SERVER['REQUEST_METHOD']
                    ?? 'GET'
                )
            );


        $uri =
            (string) (
                $_SERVER['REQUEST_URI']
                ?? '/'
            );


        $path =
            parse_url(
                $uri,
                PHP_URL_PATH
            );


        if (
            !is_string($path)
            || $path === ''
        ) {
            $path = '/';
        }


        $path =
            self::normalizePath(
                $path
            );


        foreach (
            self::$routes
            as $route
        ) {
            if (
                $route['method']
                !== $method
            ) {
                continue;
            }


            $matches = [];


            if (
                !self::matches(
                    $route['path'],
                    $path,
                    $matches
                )
            ) {
                continue;
            }


            $result =
                self::runRoute(
                    $route,
                    $matches
                );


            self::emitResult(
                $result
            );


            return $result;
        }


        /*
         * ---------------------------------------------------------------
         * Unmatched route
         * ---------------------------------------------------------------
         *
         * English URLs get the English 404 page.
         *
         * Everything else continues to use the normal Persian 404.
         *
         * Examples:
         *
         * /english/whatever
         * /english/not-found
         * /english/something/random
         *
         * => English 404
         *
         * /whatever
         * /this-page-does-not-exist
         *
         * => Persian 404
         * ---------------------------------------------------------------
         */

        if (
            self::isEnglishPath(
                $path
            )
        ) {
            return self::englishNotFound();
        }


        /*
         * A POST to a GET route or GET to a POST route
         * currently results in a normal 404 response.
         */

        return Response::notFound(
            'صفحه مورد نظر پیدا نشد.'
        );
    }


    /**
     * Determine whether the request belongs to the English site.
     */
    private static function isEnglishPath(
        string $path
    ): bool {
        $path =
            self::normalizePath(
                $path
            );


        /*
         * Exact English homepage.
         */
        if (
            $path === '/english'
        ) {
            return true;
        }


        /*
         * Any nested English URL.
         *
         * We deliberately require the next character to be "/"
         * so that something unrelated such as "/englishman"
         * does not accidentally receive the English 404 page.
         */
        return str_starts_with(
            $path,
            '/english/'
        );
    }


    /**
     * Render the English 404 page.
     *
     * This is intentionally kept inside the router because this
     * method handles URLs that never matched a controller route.
     */
    private static function englishNotFound(): string
    {
        http_response_code(
            404
        );


        $message =
            'The page you are looking for could not be found.';


        $result =
            View::renderIntoLayout(
                'layouts/english',
                'english/404',
                [
                    'title' =>
                        'Page Not Found | Sadra Institute',

                    'description' =>
                        'The requested English page could not be found.',

                    'message' =>
                        $message,
                ]
            );


        self::emitResult(
            $result
        );


        return is_string($result)
            ? $result
            : '';
    }


    /**
     * Emit a route result when appropriate.
     */
    private static function emitResult(
        mixed $result
    ): void {
        if (
            is_string($result)
            && $result !== ''
        ) {
            echo $result;
        }
    }


    /**
     * Execute middleware and the route handler.
     *
     * @param array{
     *     method: string,
     *     path: string,
     *     handler: callable,
     *     name: string|null,
     *     middleware: array<int, mixed>
     * } $route
     *
     * @param array<string, string> $parameters
     */
    private static function runRoute(
        array $route,
        array $parameters
    ): mixed {
        $handler =
            $route['handler'];


        $middleware =
            $route['middleware'];


        $pipeline =
            static function () use (
                $handler,
                $parameters
            ): mixed {
                return self::invoke(
                    $handler,
                    $parameters
                );
            };


        /*
         * Middleware are wrapped in reverse order so they execute
         * in the same order in which they were registered.
         */
        foreach (
            array_reverse(
                $middleware
            ) as $middlewareItem
        ) {
            $next =
                $pipeline;


            $pipeline =
                static function () use (
                    $middlewareItem,
                    $next
                ): mixed {
                    return self::runMiddleware(
                        $middlewareItem,
                        $next
                    );
                };
        }


        return $pipeline();
    }


    /**
     * Execute a middleware item.
     *
     * Supported forms:
     *
     * - Class-string with handle()
     * - Object with handle()
     * - Callable middleware
     */
    private static function runMiddleware(
        mixed $middleware,
        Closure $next
    ): mixed {
        if (
            is_string($middleware)
            && class_exists($middleware)
        ) {
            $instance =
                new $middleware();


            if (
                !method_exists(
                    $instance,
                    'handle'
                )
            ) {
                throw new RuntimeException(
                    sprintf(
                        'Middleware [%s] must define handle().',
                        $middleware
                    )
                );
            }


            return $instance->handle(
                $next
            );
        }


        if (
            is_object($middleware)
            && method_exists(
                $middleware,
                'handle'
            )
        ) {
            return $middleware->handle(
                $next
            );
        }


        if (
            is_callable(
                $middleware
            )
        ) {
            return $middleware(
                $next
            );
        }


        throw new RuntimeException(
            'Invalid middleware definition.'
        );
    }


    /**
     * Invoke a route controller or closure.
     *
     * Route parameters are passed by name when possible.
     *
     * @param callable $handler
     * @param array<string, string> $parameters
     */
    private static function invoke(
        callable $handler,
        array $parameters
    ): mixed {
        if (
            is_array($handler)
            && count($handler) === 2
        ) {
            $reflection =
                new \ReflectionMethod(
                    $handler[0],
                    (string) $handler[1]
                );


            return self::invokeCallable(
                $reflection,
                $handler,
                $parameters
            );
        }


        if (
            $handler instanceof Closure
        ) {
            $reflection =
                new \ReflectionFunction(
                    $handler
                );


            return self::invokeCallable(
                $reflection,
                $handler,
                $parameters
            );
        }


        $reflection =
            new \ReflectionFunction(
                $handler
            );


        return self::invokeCallable(
            $reflection,
            $handler,
            $parameters
        );
    }


    /**
     * Invoke a callable according to its parameters.
     *
     * @param \ReflectionFunctionAbstract $reflection
     * @param callable $handler
     * @param array<string, string> $routeParameters
     */
    private static function invokeCallable(
        \ReflectionFunctionAbstract $reflection,
        callable $handler,
        array $routeParameters
    ): mixed {
        $arguments = [];


        foreach (
            $reflection->getParameters()
            as $parameter
        ) {
            $name =
                $parameter->getName();


            if (
                array_key_exists(
                    $name,
                    $routeParameters
                )
            ) {
                $arguments[] =
                    $routeParameters[$name];


                continue;
            }


            if (
                $parameter->isDefaultValueAvailable()
            ) {
                $arguments[] =
                    $parameter->getDefaultValue();


                continue;
            }


            if (
                $parameter->allowsNull()
            ) {
                $arguments[] =
                    null;


                continue;
            }


            throw new RuntimeException(
                sprintf(
                    'Missing route parameter [%s].',
                    $name
                )
            );
        }


        return $handler(
            ...$arguments
        );
    }


    /**
     * Build a URL for a named route.
     *
     * Examples:
     *
     * Router::route('home')
     *
     * Router::route(
     *     'admin.programs.edit',
     *     ['id' => 12]
     * )
     */
    public static function route(
        string $name,
        array $parameters = []
    ): string {
        $name =
            trim(
                $name
            );


        if (
            $name === ''
        ) {
            throw new RuntimeException(
                'Route name cannot be empty.'
            );
        }


        foreach (
            self::$routes
            as $route
        ) {
            if (
                $route['name']
                !== $name
            ) {
                continue;
            }


            $path =
                $route['path'];


            preg_match_all(
                '/\{([A-Za-z_][A-Za-z0-9_]*)\}/',
                $path,
                $matches
            );


            $parameterNames =
                $matches[1]
                ?? [];


            foreach (
                $parameterNames
                as $parameterName
            ) {
                if (
                    !array_key_exists(
                        $parameterName,
                        $parameters
                    )
                ) {
                    throw new RuntimeException(
                        sprintf(
                            'Missing parameter [%s] for route [%s].',
                            $parameterName,
                            $name
                        )
                    );
                }


                $value =
                    $parameters[$parameterName];


                if (
                    !is_scalar($value)
                    && $value !== null
                ) {
                    throw new RuntimeException(
                        sprintf(
                            'Invalid parameter [%s] for route [%s].',
                            $parameterName,
                            $name
                        )
                    );
                }


                $encodedValue =
                    rawurlencode(
                        (string) $value
                    );


                $path =
                    str_replace(
                        '{'
                        . $parameterName
                        . '}',
                        $encodedValue,
                        $path
                    );


                unset(
                    $parameters[$parameterName]
                );
            }


            if (
                $parameters !== []
            ) {
                $queryString =
                    http_build_query(
                        $parameters,
                        '',
                        '&',
                        PHP_QUERY_RFC3986
                    );


                if (
                    $queryString !== ''
                ) {
                    $path .=
                        '?'
                        . $queryString;
                }
            }


            return self::buildUrl(
                $path
            );
        }


        throw new RuntimeException(
            sprintf(
                'Route [%s] is not defined.',
                $name
            )
        );
    }


    /**
     * Check whether a named route exists.
     */
    public static function has(
        string $name
    ): bool {
        foreach (
            self::$routes
            as $route
        ) {
            if (
                $route['name'] === $name
            ) {
                return true;
            }
        }


        return false;
    }


    /**
     * Return all registered routes.
     *
     * @return array<int, array{
     *     method: string,
     *     path: string,
     *     handler: callable,
     *     name: string|null,
     *     middleware: array<int, mixed>
     * }>
     */
    public static function all(): array
    {
        return self::$routes;
    }


    /**
     * Match a route path against a request path.
     *
     * @param array<string, string> $parameters
     */
    private static function matches(
        string $routePath,
        string $requestPath,
        array &$parameters
    ): bool {
        $routeSegments =
            self::segments(
                $routePath
            );


        $requestSegments =
            self::segments(
                $requestPath
            );


        if (
            count($routeSegments)
            !== count($requestSegments)
        ) {
            return false;
        }


        $parameters = [];


        foreach (
            $routeSegments
            as $index => $routeSegment
        ) {
            $requestSegment =
                $requestSegments[$index];


            if (
                preg_match(
                    '/^\{([A-Za-z_][A-Za-z0-9_]*)\}$/',
                    $routeSegment,
                    $match
                )
            ) {
                $parameters[$match[1]] =
                    rawurldecode(
                        $requestSegment
                    );


                continue;
            }


            if (
                $routeSegment
                !== $requestSegment
            ) {
                return false;
            }
        }


        return true;
    }


    /**
     * Normalize route paths.
     */
    private static function normalizePath(
        string $path
    ): string {
        $path =
            trim(
                $path
            );


        if (
            $path === ''
            || $path === '/'
        ) {
            return '/';
        }


        $path =
            parse_url(
                $path,
                PHP_URL_PATH
            );


        if (
            !is_string($path)
            || $path === ''
        ) {
            $path = '/';
        }


        $path =
            '/'
            . trim(
                $path,
                '/'
            );


        return $path;
    }


    /**
     * Split a path into segments.
     *
     * @return array<int, string>
     */
    private static function segments(
        string $path
    ): array {
        $path =
            trim(
                $path,
                '/'
            );


        if (
            $path === ''
        ) {
            return [];
        }


        return explode(
            '/',
            $path
        );
    }


    /**
     * Build the public application URL.
     */
    private static function buildUrl(
        string $path
    ): string {
        $baseUrl =
            rtrim(
                (string) config(
                    'app.url',
                    ''
                ),
                '/'
            );


        if (
            $baseUrl === ''
        ) {
            return $path;
        }


        return $baseUrl
            . '/'
            . ltrim(
                $path,
                '/'
            );
    }
}
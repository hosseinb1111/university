<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Response;
use App\Core\Router;
use App\Core\Session;

final class RequireAuth
{
    /**
     * Handle an authenticated route.
     */
    public function handle(
        callable $next
    ): mixed {
        if (!Session::authenticated()) {
            $this->redirectToLogin();
        }

        /*
         * A session can exist while the user has been
         * deleted or deactivated.
         */
        $user = Session::user();

        if ($user === null) {
            Session::logout();

            Session::start();

            Session::flash(
                'error',
                'حساب کاربری شما فعال نیست یا دیگر وجود ندارد.'
            );

            Response::redirectRoute(
                'teacher.login'
            );
        }

        return $next();
    }

    /**
     * Redirect an unauthenticated visitor to login.
     */
    private function redirectToLogin(): never
    {
        $uri = parse_url(
            $_SERVER['REQUEST_URI'] ?? '/',
            PHP_URL_PATH
        );

        if (
            !is_string($uri)
            || $uri === ''
        ) {
            $uri = '/';
        }

        /*
         * Save the original destination.
         */
        Session::setIntendedUrl(
            $uri
        );

        Session::flash(
            'error',
            'برای مشاهده این صفحه ابتدا وارد شوید.'
        );

        Response::redirectRoute(
            'teacher.login'
        );
    }
}
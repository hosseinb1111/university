<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Response;
use App\Core\Session;
use RuntimeException;

final class RequireRole
{
    /**
     * All roles supported by the application.
     *
     * @var array<int, string>
     */
    private const VALID_ROLES = [
        'super_admin',
        'admin',
        'editor',
        'teacher',
    ];

    /**
     * Roles allowed to access this route.
     *
     * @var array<int, string>
     */
    private array $allowedRoles;

    /**
     * @param array<int, string> $allowedRoles
     */
    public function __construct(
        array $allowedRoles
    ) {
        if ($allowedRoles === []) {
            throw new RuntimeException(
                'RequireRole requires at least one allowed role.'
            );
        }

        $roles = [];

        foreach ($allowedRoles as $role) {
            if (!is_string($role) || $role === '') {
                throw new RuntimeException(
                    'Each role must be a non-empty string.'
                );
            }

            if (!in_array(
                $role,
                self::VALID_ROLES,
                true
            )) {
                throw new RuntimeException(
                    "Invalid role [{$role}]."
                );
            }

            $roles[] = $role;
        }

        $this->allowedRoles = array_values(
            array_unique($roles)
        );
    }

    /**
     * Run the authorization check.
     */
    public function handle(
        callable $next
    ): mixed {
        /*
         * Safety check.
         *
         * Normally RequireAuth should already have run.
         */
        if (!Session::authenticated()) {
            Response::forbidden();
        }

        $user = Session::user();

        if ($user === null) {
            Session::logout();

            Response::forbidden();
        }

        $role = $user['role'] ?? null;

        if (
            !is_string($role)
            || !in_array(
                $role,
                $this->allowedRoles,
                true
            )
        ) {
            Response::forbidden();
        }

        return $next();
    }

    /**
     * Return the roles allowed by this middleware.
     *
     * @return array<int, string>
     */
    public function allowedRoles(): array
    {
        return $this->allowedRoles;
    }
}
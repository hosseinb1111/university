<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class User
{
    /**
     * Authenticate a user.
     */
    public static function authenticate(
        string $username,
        string $password
    ): ?array {
        $user = Database::first(
            '
            SELECT *
            FROM users
            WHERE username = :username
            AND is_active = 1
            LIMIT 1
            ',
            [
                ':username' => $username,
            ]
        );

        if ($user === null) {
            return null;
        }

        if (
            !password_verify(
                $password,
                (string) $user['password']
            )
        ) {
            return null;
        }

        if (
            password_needs_rehash(
                (string) $user['password'],
                PASSWORD_DEFAULT
            )
        ) {
            self::updatePassword(
                (int) $user['id'],
                $password
            );
        }

        Database::execute(
            '
            UPDATE users
            SET last_login_at = CURRENT_TIMESTAMP
            WHERE id = :id
            ',
            [
                ':id' => (int) $user['id'],
            ]
        );

        return self::find(
            (int) $user['id']
        );
    }

    /**
     * Find user by ID.
     */
    public static function find(
        int $id
    ): ?array {
        return Database::first(
            '
            SELECT *
            FROM users
            WHERE id = :id
            LIMIT 1
            ',
            [
                ':id' => $id,
            ]
        );
    }

    /**
     * Find by username.
     */
    public static function findByUsername(
        string $username
    ): ?array {
        return Database::first(
            '
            SELECT *
            FROM users
            WHERE username = :username
            LIMIT 1
            ',
            [
                ':username' => $username,
            ]
        );
    }

    /**
     * Find by email.
     */
    public static function findByEmail(
        string $email
    ): ?array {
        return Database::first(
            '
            SELECT *
            FROM users
            WHERE email = :email
            LIMIT 1
            ',
            [
                ':email' => $email,
            ]
        );
    }

    /**
     * Paginate users.
     *
     * @return array{
     *     items: array<int, array<string, mixed>>,
     *     total: int,
     *     page: int,
     *     perPage: int,
     *     totalPages: int
     * }
     */
    public static function paginate(
        int $page = 1,
        int $perPage = 20
    ): array {
        $page = max(
            1,
            $page
        );

        $perPage = max(
            1,
            min(
                $perPage,
                100
            )
        );

        $offset = (
            $page - 1
        ) * $perPage;

        $totalRow = Database::first(
            '
            SELECT COUNT(*) AS total
            FROM users
            '
        );

        $total = (int) (
            $totalRow['total'] ?? 0
        );

        $items = Database::all(
            '
            SELECT
                id,
                username,
                email,
                first_name,
                last_name,
                role,
                is_active,
                last_login_at,
                created_at,
                updated_at

            FROM users

            ORDER BY
                created_at DESC,
                id DESC

            LIMIT ' . (int) $perPage . '

            OFFSET ' . (int) $offset
        );

        return [
            'items' =>
                $items,

            'total' =>
                $total,

            'page' =>
                $page,

            'perPage' =>
                $perPage,

            'totalPages' =>
                max(
                    1,
                    (int) ceil(
                        $total / $perPage
                    )
                ),
        ];
    }

    /**
     * Create a user.
     */
    public static function create(
        array $data
    ): int {
        $password = password_hash(
            (string) $data['password'],
            PASSWORD_DEFAULT
        );

        Database::execute(
            '
            INSERT INTO users (
                username,
                email,
                password,
                first_name,
                last_name,
                role,
                is_active
            )
            VALUES (
                :username,
                :email,
                :password,
                :first_name,
                :last_name,
                :role,
                :is_active
            )
            ',
            [
                ':username' =>
                    $data['username'],

                ':email' =>
                    $data['email']
                    ?? null,

                ':password' =>
                    $password,

                ':first_name' =>
                    $data['first_name']
                    ?? null,

                ':last_name' =>
                    $data['last_name']
                    ?? null,

                ':role' =>
                    $data['role'],

                ':is_active' =>
                    (int) (
                        $data['is_active']
                        ?? 1
                    ),
            ]
        );

        return Database::lastInsertId();
    }

    /**
     * Update user without changing password.
     */
    public static function update(
        int $id,
        array $data
    ): bool {
        return Database::execute(
            '
            UPDATE users

            SET
                username = :username,

                email = :email,

                first_name = :first_name,

                last_name = :last_name,

                role = :role,

                is_active = :is_active

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,

                ':username' =>
                    $data['username'],

                ':email' =>
                    $data['email']
                    ?? null,

                ':first_name' =>
                    $data['first_name']
                    ?? null,

                ':last_name' =>
                    $data['last_name']
                    ?? null,

                ':role' =>
                    $data['role'],

                ':is_active' =>
                    (int) (
                        $data['is_active']
                        ?? 1
                    ),
            ]
        ) > 0;
    }

    /**
     * Update password.
     */
    public static function updatePassword(
        int $id,
        string $password
    ): bool {
        return Database::execute(
            '
            UPDATE users

            SET password = :password

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,

                ':password' =>
                    password_hash(
                        $password,
                        PASSWORD_DEFAULT
                    ),
            ]
        ) > 0;
    }

    /**
     * Delete user.
     */
    public static function delete(
        int $id
    ): bool {
        return Database::execute(
            '
            DELETE FROM users
            WHERE id = :id
            ',
            [
                ':id' => $id,
            ]
        ) > 0;
    }

    /**
     * Check username uniqueness.
     */
    public static function usernameExists(
        string $username,
        ?int $ignoreId = null
    ): bool {
        $sql = '
            SELECT id
            FROM users
            WHERE username = :username
        ';

        $parameters = [
            ':username' =>
                $username,
        ];

        if ($ignoreId !== null) {
            $sql .= '
                AND id != :ignore_id
            ';

            $parameters[':ignore_id'] =
                $ignoreId;
        }

        $sql .= '
            LIMIT 1
        ';

        return Database::first(
            $sql,
            $parameters
        ) !== null;
    }

    /**
     * Check email uniqueness.
     */
    public static function emailExists(
        string $email,
        ?int $ignoreId = null
    ): bool {
        if ($email === '') {
            return false;
        }

        $sql = '
            SELECT id
            FROM users
            WHERE email = :email
        ';

        $parameters = [
            ':email' =>
                $email,
        ];

        if ($ignoreId !== null) {
            $sql .= '
                AND id != :ignore_id
            ';

            $parameters[':ignore_id'] =
                $ignoreId;
        }

        $sql .= '
            LIMIT 1
        ';

        return Database::first(
            $sql,
            $parameters
        ) !== null;
    }

    /**
     * Public-safe user data.
     *
     * @return array<string, mixed>
     */
    public static function publicData(
        array $user
    ): array {
        return [
            'id' =>
                $user['id'] ?? null,

            'username' =>
                $user['username'] ?? null,

            'first_name' =>
                $user['first_name'] ?? null,

            'last_name' =>
                $user['last_name'] ?? null,

            'role' =>
                $user['role'] ?? null,

            'email' =>
                $user['email'] ?? null,

            'is_active' =>
                $user['is_active'] ?? null,
        ];
    }
}
<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use RuntimeException;

final class People
{
    /**
     * Get all active people for public pages.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function active(): array
    {
        $statement = Database::query(
            '
            SELECT
                people.*,

                faculties.name AS faculty_name,

                faculties.slug AS faculty_slug

            FROM people

            LEFT JOIN faculties
                ON faculties.id = people.faculty_id

            WHERE people.is_active = 1

            ORDER BY
                people.sort_order ASC,
                people.last_name ASC,
                people.first_name ASC,
                people.id ASC
            '
        );

        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }

    /**
     * Get active people belonging to a faculty.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function byFaculty(
        int $facultyId
    ): array {
        $statement = Database::query(
            '
            SELECT
                people.*,

                faculties.name AS faculty_name,

                faculties.slug AS faculty_slug

            FROM people

            LEFT JOIN faculties
                ON faculties.id = people.faculty_id

            WHERE people.faculty_id = :faculty_id

            AND people.is_active = 1

            ORDER BY
                people.sort_order ASC,
                people.last_name ASC,
                people.first_name ASC,
                people.id ASC
            ',
            [
                ':faculty_id' =>
                    $facultyId,
            ]
        );

        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }

    /**
     * Find a person by ID.
     *
     * @return array<string, mixed>|null
     */
    public static function find(
        int $id
    ): ?array {
        $statement = Database::query(
            '
            SELECT
                people.*,

                faculties.name AS faculty_name,

                faculties.slug AS faculty_slug

            FROM people

            LEFT JOIN faculties
                ON faculties.id = people.faculty_id

            WHERE people.id = :id

            LIMIT 1
            ',
            [
                ':id' =>
                    $id,
            ]
        );

        $person = $statement->fetch(
            PDO::FETCH_ASSOC
        );

        return $person === false
            ? null
            : $person;
    }

    /**
     * Find an active person by ID for public pages.
     *
     * @return array<string, mixed>|null
     */
    public static function findActive(
        int $id
    ): ?array {
        $statement = Database::query(
            '
            SELECT
                people.*,

                faculties.name AS faculty_name,

                faculties.slug AS faculty_slug

            FROM people

            LEFT JOIN faculties
                ON faculties.id = people.faculty_id

            WHERE people.id = :id

            AND people.is_active = 1

            LIMIT 1
            ',
            [
                ':id' =>
                    $id,
            ]
        );

        $person = $statement->fetch(
            PDO::FETCH_ASSOC
        );

        return $person === false
            ? null
            : $person;
    }

    /**
     * Paginate people for the admin panel.
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

        $offset =
            ($page - 1)
            * $perPage;

        $pdo =
            Database::connection();

        $totalStatement =
            $pdo->query(
                '
                SELECT COUNT(*)
                FROM people
                '
            );

        $total =
            (int) $totalStatement->fetchColumn();

        $statement =
            $pdo->prepare(
                '
                SELECT
                    people.*,

                    faculties.name
                        AS faculty_name,

                    faculties.slug
                        AS faculty_slug

                FROM people

                LEFT JOIN faculties
                    ON faculties.id =
                       people.faculty_id

                ORDER BY
                    people.sort_order ASC,
                    people.last_name ASC,
                    people.first_name ASC,
                    people.id ASC

                LIMIT :limit
                OFFSET :offset
                '
            );

        $statement->bindValue(
            ':limit',
            $perPage,
            PDO::PARAM_INT
        );

        $statement->bindValue(
            ':offset',
            $offset,
            PDO::PARAM_INT
        );

        $statement->execute();

        return [
            'items' =>
                $statement->fetchAll(
                    PDO::FETCH_ASSOC
                ),

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
     * Create a person.
     *
     * @param array<string, mixed> $data
     */
    public static function create(
        array $data,
        ?int $userId = null
    ): int {
        /*
         * The current people table has no created_by or
         * updated_by columns, so $userId is intentionally
         * not stored here.
         */
        Database::query(
            '
            INSERT INTO people (
                user_id,
                faculty_id,
                first_name,
                last_name,
                position,
                email,
                phone,
                fax,
                image,
                biography,
                office_location,
                sort_order,
                is_active
            )
            VALUES (
                :user_id,
                :faculty_id,
                :first_name,
                :last_name,
                :position,
                :email,
                :phone,
                :fax,
                :image,
                :biography,
                :office_location,
                :sort_order,
                :is_active
            )
            ',
            [
                ':user_id' =>
                    $data['user_id']
                    ?? null,

                ':faculty_id' =>
                    $data['faculty_id']
                    ?? null,

                ':first_name' =>
                    $data['first_name'],

                ':last_name' =>
                    $data['last_name'],

                ':position' =>
                    $data['position']
                    ?? null,

                ':email' =>
                    $data['email']
                    ?? null,

                ':phone' =>
                    $data['phone']
                    ?? null,

                ':fax' =>
                    $data['fax']
                    ?? null,

                ':image' =>
                    $data['image']
                    ?? null,

                ':biography' =>
                    $data['biography']
                    ?? null,

                ':office_location' =>
                    $data['office_location']
                    ?? null,

                ':sort_order' =>
                    (int) (
                        $data['sort_order']
                        ?? 0
                    ),

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
     * Update a person.
     *
     * @param array<string, mixed> $data
     */
    public static function update(
        int $id,
        array $data,
        ?int $userId = null
    ): bool {
        return Database::execute(
            '
            UPDATE people

            SET
                user_id = :user_id,

                faculty_id = :faculty_id,

                first_name = :first_name,

                last_name = :last_name,

                position = :position,

                email = :email,

                phone = :phone,

                fax = :fax,

                image = :image,

                biography = :biography,

                office_location = :office_location,

                sort_order = :sort_order,

                is_active = :is_active

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,

                ':user_id' =>
                    $data['user_id']
                    ?? null,

                ':faculty_id' =>
                    $data['faculty_id']
                    ?? null,

                ':first_name' =>
                    $data['first_name'],

                ':last_name' =>
                    $data['last_name'],

                ':position' =>
                    $data['position']
                    ?? null,

                ':email' =>
                    $data['email']
                    ?? null,

                ':phone' =>
                    $data['phone']
                    ?? null,

                ':fax' =>
                    $data['fax']
                    ?? null,

                ':image' =>
                    $data['image']
                    ?? null,

                ':biography' =>
                    $data['biography']
                    ?? null,

                ':office_location' =>
                    $data['office_location']
                    ?? null,

                ':sort_order' =>
                    (int) (
                        $data['sort_order']
                        ?? 0
                    ),

                ':is_active' =>
                    (int) (
                        $data['is_active']
                        ?? 1
                    ),
            ]
        ) > 0;
    }

    /**
     * Delete a person.
     */
    public static function delete(
        int $id
    ): bool {
        return Database::execute(
            '
            DELETE FROM people
            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,
            ]
        ) > 0;
    }

    /**
     * Count active people.
     */
    public static function countActive(): int
    {
        $statement =
            Database::query(
                '
                SELECT COUNT(*)
                FROM people

                WHERE is_active = 1
                '
            );

        return (int) $statement->fetchColumn();
    }

    /**
     * Find people linked to a specific user account.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function byUser(
        int $userId
    ): array {
        $statement =
            Database::query(
                '
                SELECT
                    people.*,

                    faculties.name
                        AS faculty_name,

                    faculties.slug
                        AS faculty_slug

                FROM people

                LEFT JOIN faculties
                    ON faculties.id =
                       people.faculty_id

                WHERE people.user_id =
                      :user_id

                ORDER BY
                    people.sort_order ASC,
                    people.id ASC
                ',
                [
                    ':user_id' =>
                        $userId,
                ]
            );

        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }

    /**
     * Find a person linked to a user account.
     *
     * @return array<string, mixed>|null
     */
    public static function findByUserId(
        int $userId
    ): ?array {
        $statement =
            Database::query(
                '
                SELECT
                    people.*,

                    faculties.name
                        AS faculty_name,

                    faculties.slug
                        AS faculty_slug

                FROM people

                LEFT JOIN faculties
                    ON faculties.id =
                       people.faculty_id

                WHERE people.user_id =
                      :user_id

                LIMIT 1
                ',
                [
                    ':user_id' =>
                        $userId,
                ]
            );

        $person =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $person === false
            ? null
            : $person;
    }

    /**
     * Count people in a faculty.
     */
    public static function countByFaculty(
        int $facultyId
    ): int {
        $statement =
            Database::query(
                '
                SELECT COUNT(*)
                FROM people

                WHERE faculty_id =
                      :faculty_id

                AND is_active = 1
                ',
                [
                    ':faculty_id' =>
                        $facultyId,
                ]
            );

        return (int) $statement->fetchColumn();
    }

    /**
     * Search people by name, position, or faculty.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function search(
        string $query,
        int $limit = 50
    ): array {
        $query =
            trim($query);

        if (
            $query === ''
        ) {
            return [];
        }

        $limit =
            max(
                1,
                min(
                    $limit,
                    100
                )
            );

        $searchTerm =
            '%' . $query . '%';

        $statement =
            Database::connection()
                ->prepare(
                    '
                    SELECT
                        people.*,

                        faculties.name
                            AS faculty_name,

                        faculties.slug
                            AS faculty_slug

                    FROM people

                    LEFT JOIN faculties
                        ON faculties.id =
                           people.faculty_id

                    WHERE people.is_active = 1

                    AND (
                        people.first_name LIKE :query1

                        OR people.last_name LIKE :query2

                        OR people.position LIKE :query3

                        OR people.email LIKE :query4

                        OR faculties.name LIKE :query5
                    )

                    ORDER BY
                        people.sort_order ASC,
                        people.last_name ASC,
                        people.first_name ASC

                    LIMIT :limit
                    '
                );

        $statement->bindValue(
            ':query1',
            $searchTerm,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':query2',
            $searchTerm,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':query3',
            $searchTerm,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':query4',
            $searchTerm,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':query5',
            $searchTerm,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':limit',
            $limit,
            PDO::PARAM_INT
        );

        $statement->execute();

        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }
}
<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use RuntimeException;

final class Faculty
{
    /**
     * Get all active faculties for the public website.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function active(): array
    {
        $statement = Database::query(
            '
            SELECT
                faculties.*,

                dean.first_name AS dean_first_name,

                dean.last_name AS dean_last_name

            FROM faculties

            LEFT JOIN people AS dean
                ON dean.id = faculties.dean_person_id

            WHERE faculties.is_active = 1

            ORDER BY
                faculties.sort_order ASC,
                faculties.name ASC
            '
        );

        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }

    /**
     * Find an active faculty by slug.
     *
     * @return array<string, mixed>|null
     */
    public static function findActiveBySlug(
        string $slug
    ): ?array {
        $statement = Database::query(
            '
            SELECT
                faculties.*,

                dean.first_name AS dean_first_name,

                dean.last_name AS dean_last_name

            FROM faculties

            LEFT JOIN people AS dean
                ON dean.id = faculties.dean_person_id

            WHERE faculties.slug = :slug

            AND faculties.is_active = 1

            LIMIT 1
            ',
            [
                ':slug' =>
                    $slug,
            ]
        );

        $faculty = $statement->fetch(
            PDO::FETCH_ASSOC
        );

        return $faculty === false
            ? null
            : $faculty;
    }

    /**
     * Get faculties for the admin panel.
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
                FROM faculties
                '
            );

        $total =
            (int) $totalStatement->fetchColumn();

        $statement =
            $pdo->prepare(
                '
                SELECT
                    faculties.*,

                    dean.first_name
                        AS dean_first_name,

                    dean.last_name
                        AS dean_last_name

                FROM faculties

                LEFT JOIN people AS dean
                    ON dean.id =
                       faculties.dean_person_id

                ORDER BY
                    faculties.sort_order ASC,
                    faculties.name ASC,
                    faculties.id ASC

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
     * Find a faculty by ID.
     *
     * @return array<string, mixed>|null
     */
    public static function find(
        int $id
    ): ?array {
        $statement =
            Database::query(
                '
                SELECT
                    faculties.*,

                    dean.first_name
                        AS dean_first_name,

                    dean.last_name
                        AS dean_last_name

                FROM faculties

                LEFT JOIN people AS dean
                    ON dean.id =
                       faculties.dean_person_id

                WHERE faculties.id = :id

                LIMIT 1
                ',
                [
                    ':id' =>
                        $id,
                ]
            );

        $faculty =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $faculty === false
            ? null
            : $faculty;
    }

    /**
     * Create a faculty.
     *
     * @param array<string, mixed> $data
     */
    public static function create(
        array $data,
        int $userId
    ): int {
        /*
         * The current faculties table does not have
         * created_by / updated_by fields.
         */
        Database::query(
            '
            INSERT INTO faculties (
                slug,
                name,
                short_name,
                description,
                image,
                dean_person_id,
                email,
                phone,
                fax,
                address,
                sort_order,
                is_active
            )
            VALUES (
                :slug,
                :name,
                :short_name,
                :description,
                :image,
                :dean_person_id,
                :email,
                :phone,
                :fax,
                :address,
                :sort_order,
                :is_active
            )
            ',
            [
                ':slug' =>
                    $data['slug'],

                ':name' =>
                    $data['name'],

                ':short_name' =>
                    $data['short_name']
                    ?? null,

                ':description' =>
                    $data['description']
                    ?? null,

                ':image' =>
                    $data['image']
                    ?? null,

                ':dean_person_id' =>
                    $data['dean_person_id']
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

                ':address' =>
                    $data['address']
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
     * Update a faculty.
     *
     * @param array<string, mixed> $data
     */
    public static function update(
        int $id,
        array $data,
        int $userId
    ): bool {
        return Database::execute(
            '
            UPDATE faculties

            SET
                slug = :slug,

                name = :name,

                short_name = :short_name,

                description = :description,

                image = :image,

                dean_person_id = :dean_person_id,

                email = :email,

                phone = :phone,

                fax = :fax,

                address = :address,

                sort_order = :sort_order,

                is_active = :is_active

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,

                ':slug' =>
                    $data['slug'],

                ':name' =>
                    $data['name'],

                ':short_name' =>
                    $data['short_name']
                    ?? null,

                ':description' =>
                    $data['description']
                    ?? null,

                ':image' =>
                    $data['image']
                    ?? null,

                ':dean_person_id' =>
                    $data['dean_person_id']
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

                ':address' =>
                    $data['address']
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
     * Delete a faculty.
     *
     * Programs belonging to this faculty are deleted
     * by the database because programs.faculty_id uses
     * ON DELETE CASCADE.
     */
    public static function delete(
        int $id
    ): bool {
        return Database::execute(
            '
            DELETE FROM faculties
            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,
            ]
        ) > 0;
    }

    /**
     * Check whether a faculty slug exists.
     */
    public static function slugExists(
        string $slug,
        ?int $ignoreId = null
    ): bool {
        $sql = '
            SELECT id
            FROM faculties
            WHERE slug = :slug
        ';

        $parameters = [
            ':slug' =>
                $slug,
        ];

        if (
            $ignoreId !== null
        ) {
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
     * Generate a unique faculty slug.
     */
    public static function generateUniqueSlug(
        string $value,
        ?int $ignoreId = null
    ): string {
        $slug =
            self::slugify(
                $value
            );

        if (
            $slug === ''
        ) {
            $slug =
                'faculty';
        }

        $baseSlug =
            $slug;

        $counter = 2;

        while (
            self::slugExists(
                $slug,
                $ignoreId
            )
        ) {
            $slug =
                $baseSlug
                . '-'
                . $counter;

            $counter++;
        }

        return $slug;
    }

    /**
     * Convert text into a URL-friendly slug.
     */
    public static function slugify(
        string $value
    ): string {
        $value =
            trim(
                mb_strtolower(
                    $value,
                    'UTF-8'
                )
            );

        $value =
            preg_replace(
                '/[^\p{L}\p{N}]+/u',
                '-',
                $value
            )
            ?? '';

        return trim(
            $value,
            '-'
        );
    }

    /**
     * Get the number of active faculties.
     */
    public static function countActive(): int
    {
        $statement =
            Database::query(
                '
                SELECT COUNT(*)
                FROM faculties

                WHERE is_active = 1
                '
            );

        return (int) $statement->fetchColumn();
    }

    /**
     * Get one faculty by its exact slug regardless
     * of active state.
     *
     * Useful for admin operations.
     *
     * @return array<string, mixed>|null
     */
    public static function findBySlug(
        string $slug
    ): ?array {
        $statement =
            Database::query(
                '
                SELECT
                    faculties.*,

                    dean.first_name
                        AS dean_first_name,

                    dean.last_name
                        AS dean_last_name

                FROM faculties

                LEFT JOIN people AS dean
                    ON dean.id =
                       faculties.dean_person_id

                WHERE faculties.slug = :slug

                LIMIT 1
                ',
                [
                    ':slug' =>
                        $slug,
                ]
            );

        $faculty =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $faculty === false
            ? null
            : $faculty;
    }
}
<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use RuntimeException;

final class ResearchCenter
{
    /**
     * Get all active research centers for the public website.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function active(): array
    {
        $statement = Database::query(
            '
            SELECT
                research_centers.*

            FROM research_centers

            WHERE research_centers.is_active = 1

            ORDER BY
                research_centers.sort_order ASC,
                research_centers.name ASC,
                research_centers.id ASC
            '
        );

        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }

    /**
     * Find an active research center by slug.
     *
     * @return array<string, mixed>|null
     */
    public static function findActiveBySlug(
        string $slug
    ): ?array {
        $statement = Database::query(
            '
            SELECT
                research_centers.*

            FROM research_centers

            WHERE research_centers.slug = :slug

            AND research_centers.is_active = 1

            LIMIT 1
            ',
            [
                ':slug' =>
                    $slug,
            ]
        );

        $center =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $center === false
            ? null
            : $center;
    }

    /**
     * Get all research centers for the admin panel.
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
                FROM research_centers
                '
            );

        $total =
            (int) $totalStatement->fetchColumn();

        $statement =
            $pdo->prepare(
                '
                SELECT
                    research_centers.*

                FROM research_centers

                ORDER BY
                    research_centers.sort_order ASC,
                    research_centers.name ASC,
                    research_centers.id ASC

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
     * Find a research center by ID.
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
                    research_centers.*

                FROM research_centers

                WHERE research_centers.id = :id

                LIMIT 1
                ',
                [
                    ':id' =>
                        $id,
                ]
            );

        $center =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $center === false
            ? null
            : $center;
    }

    /**
     * Create a research center.
     *
     * @param array<string, mixed> $data
     */
    public static function create(
        array $data,
        ?int $userId = null
    ): int {
        /*
         * The research-center model uses only fields
         * belonging to the research_centers table.
         *
         * $userId is intentionally not persisted because
         * the current schema does not define created_by
         * or updated_by columns for this entity.
         */
        Database::query(
            '
            INSERT INTO research_centers (
                slug,
                name,
                description,
                email,
                phone,
                address,
                sort_order,
                is_active
            )
            VALUES (
                :slug,
                :name,
                :description,
                :email,
                :phone,
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

                ':description' =>
                    $data['description']
                    ?? null,

                ':email' =>
                    $data['email']
                    ?? null,

                ':phone' =>
                    $data['phone']
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
     * Update a research center.
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
            UPDATE research_centers

            SET
                slug = :slug,

                name = :name,

                description = :description,

                email = :email,

                phone = :phone,

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

                ':description' =>
                    $data['description']
                    ?? null,

                ':email' =>
                    $data['email']
                    ?? null,

                ':phone' =>
                    $data['phone']
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
     * Delete a research center.
     */
    public static function delete(
        int $id
    ): bool {
        return Database::execute(
            '
            DELETE FROM research_centers

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,
            ]
        ) > 0;
    }

    /**
     * Check whether a slug already exists.
     */
    public static function slugExists(
        string $slug,
        ?int $ignoreId = null
    ): bool {
        $sql = '
            SELECT id

            FROM research_centers

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
     * Generate a unique research-center slug.
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
                'research-center';
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
     * Count active research centers.
     */
    public static function countActive(): int
    {
        $statement =
            Database::query(
                '
                SELECT COUNT(*)

                FROM research_centers

                WHERE is_active = 1
                '
            );

        return (int) $statement->fetchColumn();
    }

    /**
     * Find a research center by slug regardless of
     * active status.
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
                    research_centers.*

                FROM research_centers

                WHERE research_centers.slug = :slug

                LIMIT 1
                ',
                [
                    ':slug' =>
                        $slug,
                ]
            );

        $center =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $center === false
            ? null
            : $center;
    }
}
<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class EnglishDocumentCategory
{
    /**
     * Get active English document categories.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function active(): array
    {
        $statement =
            Database::query(
                '
                SELECT
                    english_document_categories.*

                FROM english_document_categories

                WHERE english_document_categories.is_active = 1

                ORDER BY
                    english_document_categories.sort_order ASC,
                    english_document_categories.name ASC,
                    english_document_categories.id ASC
                '
            );

        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }


    /**
     * Get all English document categories.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function all(): array
    {
        $statement =
            Database::query(
                '
                SELECT
                    english_document_categories.*

                FROM english_document_categories

                ORDER BY
                    english_document_categories.sort_order ASC,
                    english_document_categories.name ASC,
                    english_document_categories.id ASC
                '
            );

        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }


    /**
     * Find an active English category by slug.
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
                    *

                FROM english_document_categories

                WHERE slug = :slug

                AND is_active = 1

                LIMIT 1
                ',
                [
                    ':slug' =>
                        trim($slug),
                ]
            );

        $category =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $category === false
            ? null
            : $category;
    }


    /**
     * Find category by ID.
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
                    *

                FROM english_document_categories

                WHERE id = :id

                LIMIT 1
                ',
                [
                    ':id' =>
                        $id,
                ]
            );

        $category =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $category === false
            ? null
            : $category;
    }


    /**
     * Paginate English document categories.
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
        $page =
            max(
                1,
                $page
            );

        $perPage =
            max(
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

        $total =
            (int) $pdo
                ->query(
                    '
                    SELECT COUNT(*)
                    FROM english_document_categories
                    '
                )
                ->fetchColumn();

        $statement =
            $pdo->prepare(
                '
                SELECT
                    *

                FROM english_document_categories

                ORDER BY
                    sort_order ASC,
                    name ASC,
                    id ASC

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
     * Create a category.
     *
     * @param array<string, mixed> $data
     */
    public static function create(
        array $data,
        ?int $userId = null
    ): int {
        Database::query(
            '
            INSERT INTO english_document_categories (
                parent_id,
                name,
                slug,
                description,
                sort_order,
                is_active
            )

            VALUES (
                :parent_id,
                :name,
                :slug,
                :description,
                :sort_order,
                :is_active
            )
            ',
            [
                ':parent_id' =>
                    $data['parent_id']
                    ?? null,

                ':name' =>
                    $data['name'],

                ':slug' =>
                    $data['slug'],

                ':description' =>
                    $data['description']
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
     * Update a category.
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
            UPDATE english_document_categories

            SET
                parent_id = :parent_id,

                name = :name,

                slug = :slug,

                description = :description,

                sort_order = :sort_order,

                is_active = :is_active

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,

                ':parent_id' =>
                    $data['parent_id']
                    ?? null,

                ':name' =>
                    $data['name'],

                ':slug' =>
                    $data['slug'],

                ':description' =>
                    $data['description']
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
     * Delete category.
     */
    public static function delete(
        int $id
    ): bool {
        return Database::execute(
            '
            DELETE FROM english_document_categories

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,
            ]
        ) > 0;
    }


    /**
     * Check whether slug exists.
     */
    public static function slugExists(
        string $slug,
        ?int $ignoreId = null
    ): bool {
        $sql = '
            SELECT id

            FROM english_document_categories

            WHERE slug = :slug
        ';

        $parameters = [
            ':slug' =>
                trim($slug),
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
     * Generate a unique category slug.
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
                'documents';
        }

        $baseSlug =
            $slug;

        $counter =
            2;

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
     * Slugify category name.
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
}
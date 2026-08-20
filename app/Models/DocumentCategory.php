<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class DocumentCategory
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function all(
        bool $activeOnly = false
    ): array {
        $sql = '
            SELECT
                id,
                parent_id,
                name,
                slug,
                description,
                sort_order,
                is_active,
                created_at,
                updated_at
            FROM document_categories
        ';

        $parameters = [];

        if ($activeOnly) {
            $sql .= '
                WHERE is_active = 1
            ';
        }

        $sql .= '
            ORDER BY
                sort_order ASC,
                name ASC
        ';

        return Database::all(
            $sql,
            $parameters
        );
    }

    public static function find(
        int $id
    ): ?array {
        return Database::first(
            '
            SELECT
                *
            FROM document_categories
            WHERE id = :id
            LIMIT 1
            ',
            [
                ':id' => $id,
            ]
        );
    }

    public static function findBySlug(
        string $slug
    ): ?array {
        return Database::first(
            '
            SELECT
                *
            FROM document_categories
            WHERE slug = :slug
            AND is_active = 1
            LIMIT 1
            ',
            [
                ':slug' => $slug,
            ]
        );
    }

    public static function create(
        array $data
    ): int {
        Database::execute(
            '
            INSERT INTO document_categories (
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
                    $data['parent_id'] ?? null,

                ':name' =>
                    $data['name'],

                ':slug' =>
                    $data['slug'],

                ':description' =>
                    $data['description'] ?? null,

                ':sort_order' =>
                    (int) (
                        $data['sort_order'] ?? 0
                    ),

                ':is_active' =>
                    (int) (
                        $data['is_active'] ?? 1
                    ),
            ]
        );

        return Database::lastInsertId();
    }

    public static function update(
        int $id,
        array $data
    ): bool {
        return Database::execute(
            '
            UPDATE document_categories
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
                ':id' => $id,

                ':parent_id' =>
                    $data['parent_id'] ?? null,

                ':name' =>
                    $data['name'],

                ':slug' =>
                    $data['slug'],

                ':description' =>
                    $data['description'] ?? null,

                ':sort_order' =>
                    (int) (
                        $data['sort_order'] ?? 0
                    ),

                ':is_active' =>
                    (int) (
                        $data['is_active'] ?? 1
                    ),
            ]
        ) > 0;
    }

    public static function delete(
        int $id
    ): bool {
        return Database::execute(
            '
            DELETE FROM document_categories
            WHERE id = :id
            ',
            [
                ':id' => $id,
            ]
        ) > 0;
    }

    public static function slugExists(
        string $slug,
        ?int $ignoreId = null
    ): bool {
        $sql = '
            SELECT id
            FROM document_categories
            WHERE slug = :slug
        ';

        $parameters = [
            ':slug' => $slug,
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

    public static function slugify(
        string $value
    ): string {
        $value = trim(
            mb_strtolower(
                $value,
                'UTF-8'
            )
        );

        $value = preg_replace(
            '/[^\p{L}\p{N}]+/u',
            '-',
            $value
        ) ?? '';

        return trim(
            $value,
            '-'
        );
    }

    public static function generateUniqueSlug(
        string $value,
        ?int $ignoreId = null
    ): string {
        $slug = self::slugify(
            $value
        );

        if ($slug === '') {
            $slug = 'documents';
        }

        $base = $slug;
        $counter = 2;

        while (
            self::slugExists(
                $slug,
                $ignoreId
            )
        ) {
            $slug =
                $base
                . '-'
                . $counter;

            $counter++;
        }

        return $slug;
    }
}
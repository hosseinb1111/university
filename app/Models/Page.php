<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class Page
{
    /**
     * Paginate pages for the admin.
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
                FROM pages
                '
            );

        $total =
            (int) $totalStatement->fetchColumn();

        $statement =
            $pdo->prepare(
                '
                SELECT
                    pages.*,

                    creator.username
                        AS creator_username,

                    creator.first_name
                        AS creator_first_name,

                    creator.last_name
                        AS creator_last_name,

                    parent.title
                        AS parent_title

                FROM pages

                LEFT JOIN users AS creator
                    ON creator.id =
                       pages.created_by

                LEFT JOIN pages AS parent
                    ON parent.id =
                       pages.parent_id

                ORDER BY
                    pages.updated_at DESC,
                    pages.id DESC

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
     * Find a page by ID.
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
                    pages.*

                FROM pages

                WHERE pages.id = :id

                LIMIT 1
                ',
                [
                    ':id' =>
                        $id,
                ]
            );

        $page =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $page === false
            ? null
            : $page;
    }

    /**
     * Find a published page by slug.
     *
     * @return array<string, mixed>|null
     */
    public static function findPublishedBySlug(
        string $slug
    ): ?array {
        $statement =
            Database::query(
                '
                SELECT
                    pages.*,

                    parent.title
                        AS parent_title,

                    parent.slug
                        AS parent_slug

                FROM pages

                LEFT JOIN pages AS parent
                    ON parent.id =
                       pages.parent_id

                WHERE pages.slug = :slug

                AND pages.status = :status

                AND (
                    pages.published_at IS NULL
                    OR pages.published_at <= NOW()
                )

                LIMIT 1
                ',
                [
                    ':slug' =>
                        $slug,

                    ':status' =>
                        'published',
                ]
            );

        $page =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $page === false
            ? null
            : $page;
    }

    /**
     * Get published pages for the XML sitemap.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function publishedForSitemap(): array
    {
        $statement =
            Database::query(
                '
                SELECT
                    id,
                    slug,
                    title,
                    updated_at,
                    published_at

                FROM pages

                WHERE status = :status

                AND slug IS NOT NULL

                AND slug != \'\'

                AND (
                    published_at IS NULL
                    OR published_at <= NOW()
                )

                ORDER BY
                    updated_at DESC,
                    id DESC
                ',
                [
                    ':status' =>
                        'published',
                ]
            );

        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }

    /**
     * Get pages that can be parents.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function parentOptions(
        ?int $ignoreId = null
    ): array {
        $sql = '
            SELECT
                id,
                parent_id,
                title,
                slug

            FROM pages

            WHERE status != :private_status
        ';

        $parameters = [
            ':private_status' =>
                'private',
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
            ORDER BY
                title ASC,
                id ASC
        ';

        return Database::all(
            $sql,
            $parameters
        );
    }

    /**
     * Create a page.
     *
     * @param array<string, mixed> $data
     */
    public static function create(
        array $data,
        int $userId
    ): int {
        $statement =
            Database::query(
                '
                INSERT INTO pages (
                    parent_id,
                    slug,
                    title,
                    excerpt,
                    content,
                    featured_image,
                    status,
                    seo_title,
                    seo_description,
                    seo_keywords,
                    published_at,
                    created_by,
                    updated_by
                )
                VALUES (
                    :parent_id,
                    :slug,
                    :title,
                    :excerpt,
                    :content,
                    :featured_image,
                    :status,
                    :seo_title,
                    :seo_description,
                    :seo_keywords,
                    :published_at,
                    :created_by,
                    :updated_by
                )
                ',
                [
                    ':parent_id' =>
                        $data['parent_id']
                        ?? null,

                    ':slug' =>
                        $data['slug'],

                    ':title' =>
                        $data['title'],

                    ':excerpt' =>
                        $data['excerpt']
                        ?? null,

                    ':content' =>
                        $data['content']
                        ?? null,

                    ':featured_image' =>
                        $data['featured_image']
                        ?? null,

                    ':status' =>
                        $data['status']
                        ?? 'draft',

                    ':seo_title' =>
                        $data['seo_title']
                        ?? null,

                    ':seo_description' =>
                        $data['seo_description']
                        ?? null,

                    ':seo_keywords' =>
                        $data['seo_keywords']
                        ?? null,

                    ':published_at' =>
                        $data['published_at']
                        ?? null,

                    ':created_by' =>
                        $userId,

                    ':updated_by' =>
                        $userId,
                ]
            );

        return Database::lastInsertId();
    }

    /**
     * Update a page.
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
            UPDATE pages

            SET
                parent_id = :parent_id,

                slug = :slug,

                title = :title,

                excerpt = :excerpt,

                content = :content,

                featured_image = :featured_image,

                status = :status,

                seo_title = :seo_title,

                seo_description = :seo_description,

                seo_keywords = :seo_keywords,

                published_at = :published_at,

                updated_by = :updated_by

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,

                ':parent_id' =>
                    $data['parent_id']
                    ?? null,

                ':slug' =>
                    $data['slug'],

                ':title' =>
                    $data['title'],

                ':excerpt' =>
                    $data['excerpt']
                    ?? null,

                ':content' =>
                    $data['content']
                    ?? null,

                ':featured_image' =>
                    $data['featured_image']
                    ?? null,

                ':status' =>
                    $data['status']
                    ?? 'draft',

                ':seo_title' =>
                    $data['seo_title']
                    ?? null,

                ':seo_description' =>
                    $data['seo_description']
                    ?? null,

                ':seo_keywords' =>
                    $data['seo_keywords']
                    ?? null,

                ':published_at' =>
                    $data['published_at']
                    ?? null,

                ':updated_by' =>
                    $userId,
            ]
        ) > 0;
    }

    /**
     * Delete a page.
     */
    public static function delete(
        int $id
    ): bool {
        return Database::execute(
            '
            DELETE FROM pages

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

            FROM pages

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
     * Generate a unique slug.
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
            $slug = 'page';
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
     * Convert text to a URL-friendly slug.
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
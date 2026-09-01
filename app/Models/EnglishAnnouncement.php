<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use RuntimeException;

final class EnglishAnnouncement
{
    /**
     * Get paginated English announcements for the admin panel.
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

                    FROM english_announcements
                    '
                )
                ->fetchColumn();


        $statement =
            $pdo->prepare(
                '
                SELECT
                    english_announcements.*,

                    creator.username
                        AS created_by_username,

                    creator.first_name
                        AS created_by_first_name,

                    creator.last_name
                        AS created_by_last_name

                FROM english_announcements

                LEFT JOIN users AS creator
                    ON creator.id =
                       english_announcements.created_by

                ORDER BY
                    english_announcements.priority DESC,
                    english_announcements.created_at DESC,
                    english_announcements.id DESC

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
     * Get paginated published English announcements.
     *
     * @return array{
     *     items: array<int, array<string, mixed>>,
     *     total: int,
     *     page: int,
     *     perPage: int,
     *     totalPages: int
     * }
     */
    public static function paginatePublished(
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


        $countStatement =
            $pdo->prepare(
                '
                SELECT COUNT(*)

                FROM english_announcements

                WHERE status = :status

                AND (
                    published_at IS NULL
                    OR published_at <= NOW()
                )
                '
            );


        $countStatement->bindValue(
            ':status',
            'published',
            PDO::PARAM_STR
        );

        $countStatement->execute();


        $total =
            (int) $countStatement->fetchColumn();


        $statement =
            $pdo->prepare(
                '
                SELECT
                    english_announcements.*

                FROM english_announcements

                WHERE status = :status

                AND (
                    published_at IS NULL
                    OR published_at <= NOW()
                )

                ORDER BY
                    priority DESC,

                    published_at DESC,

                    created_at DESC,

                    id DESC

                LIMIT :limit

                OFFSET :offset
                '
            );


        $statement->bindValue(
            ':status',
            'published',
            PDO::PARAM_STR
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
     * Find an English announcement by ID.
     *
     * @return array<string, mixed>|null
     */
    public static function find(
        int $id
    ): ?array {
        $statement =
            Database::query(
                '
                SELECT *

                FROM english_announcements

                WHERE id = :id

                LIMIT 1
                ',
                [
                    ':id' =>
                        $id,
                ]
            );


        $result =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );


        return $result === false
            ? null
            : $result;
    }


    /**
     * Find a published English announcement by slug.
     *
     * @return array<string, mixed>|null
     */
    public static function findPublishedBySlug(
        string $slug
    ): ?array {
        $slug =
            trim(
                $slug
            );

        if (
            $slug === ''
        ) {
            return null;
        }


        $statement =
            Database::query(
                '
                SELECT *

                FROM english_announcements

                WHERE slug = :slug

                AND status = :status

                AND (
                    published_at IS NULL
                    OR published_at <= NOW()
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


        $result =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );


        return $result === false
            ? null
            : $result;
    }


    /**
     * Get latest published English announcements.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function latestPublished(
        int $limit = 5
    ): array {
        $limit =
            max(
                1,
                min(
                    $limit,
                    100
                )
            );


        $statement =
            Database::connection()
                ->prepare(
                    '
                    SELECT *

                    FROM english_announcements

                    WHERE status = :status

                    AND (
                        published_at IS NULL
                        OR published_at <= NOW()
                    )

                    ORDER BY
                        priority DESC,

                        published_at DESC,

                        created_at DESC,

                        id DESC

                    LIMIT :limit
                    '
                );


        $statement->bindValue(
            ':status',
            'published',
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


    /**
     * Compatibility alias.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function latest(
        int $limit = 10
    ): array {
        return self::latestPublished(
            $limit
        );
    }


    /**
     * Get published English announcements for sitemap.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function allPublishedForSitemap(): array
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

                FROM english_announcements

                WHERE status = :status

                AND slug IS NOT NULL

                AND slug != ""

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
     * Create an English announcement.
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
                INSERT INTO english_announcements (
                    slug,
                    title,
                    excerpt,
                    content,
                    featured_image,
                    status,
                    priority,
                    published_at,
                    created_by,
                    updated_by
                )

                VALUES (
                    :slug,
                    :title,
                    :excerpt,
                    :content,
                    :featured_image,
                    :status,
                    :priority,
                    :published_at,
                    :created_by,
                    :updated_by
                )
                ',
                [
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

                    ':priority' =>
                        (int) (
                            $data['priority']
                            ?? 0
                        ),

                    ':published_at' =>
                        $data['published_at']
                        ?? null,

                    ':created_by' =>
                        $userId,

                    ':updated_by' =>
                        $userId,
                ]
            );


        if (
            !(
                $statement
                instanceof \PDOStatement
            )
        ) {
            throw new RuntimeException(
                'Failed creating English announcement.'
            );
        }


        return Database::lastInsertId();
    }


    /**
     * Update an English announcement.
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
            UPDATE english_announcements

            SET
                slug = :slug,

                title = :title,

                excerpt = :excerpt,

                content = :content,

                featured_image = :featured_image,

                status = :status,

                priority = :priority,

                published_at = :published_at,

                updated_by = :updated_by

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,

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

                ':priority' =>
                    (int) (
                        $data['priority']
                        ?? 0
                    ),

                ':published_at' =>
                    $data['published_at']
                    ?? null,

                ':updated_by' =>
                    $userId,
            ]
        ) > 0;
    }


    /**
     * Publish an English announcement.
     */
    public static function publish(
        int $id,
        ?int $userId = null
    ): bool {
        $parameters = [
            ':status' =>
                'published',

            ':id' =>
                $id,
        ];


        $updatedBySql =
            '';


        if (
            $userId !== null
        ) {
            $updatedBySql =
                ',
                    updated_by = :updated_by
                ';

            $parameters[':updated_by'] =
                $userId;
        }


        return Database::execute(
            '
            UPDATE english_announcements

            SET
                status = :status,

                published_at = CASE
                    WHEN published_at IS NULL
                        THEN NOW()

                    ELSE published_at
                END

                ' . $updatedBySql . '

            WHERE id = :id
            ',
            $parameters
        ) > 0;
    }


    /**
     * Archive an English announcement.
     */
    public static function archive(
        int $id,
        ?int $userId = null
    ): bool {
        $parameters = [
            ':status' =>
                'archived',

            ':id' =>
                $id,
        ];


        $updatedBySql =
            '';


        if (
            $userId !== null
        ) {
            $updatedBySql =
                ',
                    updated_by = :updated_by
                ';

            $parameters[':updated_by'] =
                $userId;
        }


        return Database::execute(
            '
            UPDATE english_announcements

            SET
                status = :status

                ' . $updatedBySql . '

            WHERE id = :id
            ',
            $parameters
        ) > 0;
    }


    /**
     * Delete an English announcement.
     */
    public static function delete(
        int $id
    ): bool {
        return Database::execute(
            '
            DELETE FROM english_announcements

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,
            ]
        ) > 0;
    }


    /**
     * Count announcements by status.
     */
    public static function countByStatus(
        string $status
    ): int {
        $statement =
            Database::query(
                '
                SELECT COUNT(*)

                FROM english_announcements

                WHERE status = :status
                ',
                [
                    ':status' =>
                        $status,
                ]
            );


        return (int) $statement->fetchColumn();
    }


    /**
     * Count currently published English announcements.
     */
    public static function countPublished(): int
    {
        $statement =
            Database::query(
                '
                SELECT COUNT(*)

                FROM english_announcements

                WHERE status = :status

                AND (
                    published_at IS NULL
                    OR published_at <= NOW()
                )
                ',
                [
                    ':status' =>
                        'published',
                ]
            );


        return (int) $statement->fetchColumn();
    }


    /**
     * Check whether a slug already exists.
     */
    public static function slugExists(
        string $slug,
        ?int $ignoreId = null
    ): bool {
        $slug =
            trim(
                $slug
            );


        if (
            $slug === ''
        ) {
            return false;
        }


        $sql = '
            SELECT id

            FROM english_announcements

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
     * Generate a unique English announcement slug.
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
                'announcement';
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
}
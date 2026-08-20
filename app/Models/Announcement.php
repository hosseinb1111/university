<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use RuntimeException;

final class Announcement
{
    /**
     * Get paginated announcements for admin panel.
     *
     * @return array{
     *     items: array<int, array<string,mixed>>,
     *     total:int,
     *     page:int,
     *     perPage:int,
     *     totalPages:int
     * }
     */
    public static function paginate(
        int $page = 1,
        int $perPage = 20
    ): array {

        $page = max(1, $page);

        $perPage = max(
            1,
            min($perPage, 100)
        );

        $offset =
            ($page - 1) * $perPage;


        $pdo =
            Database::connection();


        $total =
            (int) $pdo
                ->query(
                    'SELECT COUNT(*) FROM announcements'
                )
                ->fetchColumn();


        $statement =
            $pdo->prepare(
                '
                SELECT
                    announcements.*,

                    creator.username
                        AS created_by_username,

                    creator.first_name
                        AS created_by_first_name,

                    creator.last_name
                        AS created_by_last_name

                FROM announcements

                LEFT JOIN users AS creator
                    ON creator.id = announcements.created_by

                ORDER BY
                    announcements.priority DESC,
                    announcements.created_at DESC,
                    announcements.id DESC

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
     * Find announcement by ID.
     */
    public static function find(
        int $id
    ): ?array {

        $statement =
            Database::query(
                '
                SELECT *

                FROM announcements

                WHERE id = :id

                LIMIT 1
                ',
                [
                    ':id'=>$id
                ]
            );


        $result =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );


        return $result ?: null;
    }




    /**
     * Find published announcement by slug.
     */
    public static function findPublishedBySlug(
        string $slug
    ): ?array {


        $statement =
            Database::query(
                '
                SELECT *

                FROM announcements

                WHERE slug = :slug

                AND status = "published"

                AND (
                    published_at IS NULL
                    OR published_at <= NOW()
                )

                AND (
                    expires_at IS NULL
                    OR expires_at > NOW()
                )

                LIMIT 1
                ',
                [
                    ':slug'=>$slug
                ]
            );


        $result =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );


        return $result ?: null;
    }




    /**
     * Homepage latest published announcements.
     *
     * THIS FIXES:
     * Announcement::latestPublished()
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

                    FROM announcements

                    WHERE status = "published"

                    AND (
                        published_at IS NULL
                        OR published_at <= NOW()
                    )

                    AND (
                        expires_at IS NULL
                        OR expires_at > NOW()
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
     * Alias for compatibility.
     */
    public static function latest(
        int $limit = 10
    ): array {

        return self::latestPublished(
            $limit
        );
    }





    /**
     * Sitemap announcements.
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

                FROM announcements

                WHERE status = "published"

                AND slug IS NOT NULL

                AND slug != ""

                ORDER BY
                    updated_at DESC,
                    id DESC
                '
            );


        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }






    /**
     * Create announcement.
     */
    public static function create(
        array $data,
        int $userId
    ): int {


        $statement =
            Database::query(
                '
                INSERT INTO announcements
                (
                    title,
                    slug,
                    excerpt,
                    content,
                    featured_image,
                    status,
                    priority,
                    published_at,
                    expires_at,
                    created_by,
                    updated_by
                )

                VALUES
                (
                    :title,
                    :slug,
                    :excerpt,
                    :content,
                    :featured_image,
                    :status,
                    :priority,
                    :published_at,
                    :expires_at,
                    :created_by,
                    :updated_by
                )
                ',
                [

                    ':title'=>$data['title'],

                    ':slug'=>$data['slug'],

                    ':excerpt'=>$data['excerpt'] ?? null,

                    ':content'=>$data['content'] ?? null,

                    ':featured_image'=>$data['featured_image'] ?? null,

                    ':status'=>$data['status'] ?? 'draft',

                    ':priority'=>(int)($data['priority'] ?? 0),

                    ':published_at'=>$data['published_at'] ?? null,

                    ':expires_at'=>$data['expires_at'] ?? null,

                    ':created_by'=>$userId,

                    ':updated_by'=>$userId
                ]
            );


        if (!$statement) {

            throw new RuntimeException(
                'Failed creating announcement'
            );
        }


        return Database::lastInsertId();
    }





    /**
     * Count by status.
     */
    public static function countByStatus(
        string $status
    ): int {


        $statement =
            Database::query(
                '
                SELECT COUNT(*)

                FROM announcements

                WHERE status=:status
                ',
                [
                    ':status'=>$status
                ]
            );


        return (int)$statement->fetchColumn();
    }






    /**
     * Convert title to slug.
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
<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class Media
{
    /**
     * Paginate media.
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
        int $perPage = 24
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

        $totalStatement =
            $pdo->query(
                '
                SELECT COUNT(*)
                FROM media
                '
            );

        $total =
            (int) $totalStatement->fetchColumn();

        $statement =
            $pdo->prepare(
                '
                SELECT
                    media.*,

                    users.username
                        AS uploader_username,

                    users.first_name
                        AS uploader_first_name,

                    users.last_name
                        AS uploader_last_name

                FROM media

                LEFT JOIN users
                    ON users.id =
                       media.uploaded_by

                ORDER BY
                    media.created_at DESC,
                    media.id DESC

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
     * Find media by ID.
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
                FROM media
                WHERE id = :id
                LIMIT 1
                ',
                [
                    ':id' =>
                        $id,
                ]
            );

        $media =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $media === false
            ? null
            : $media;
    }

    /**
     * Create a media record.
     */
    public static function create(
        array $data,
        ?int $userId
    ): int {
        $statement =
            Database::query(
                '
                INSERT INTO media (
                    uploaded_by,
                    file_name,
                    original_name,
                    file_path,
                    mime_type,
                    file_size,
                    alt_text,
                    width,
                    height,
                    storage_disk
                )
                VALUES (
                    :uploaded_by,
                    :file_name,
                    :original_name,
                    :file_path,
                    :mime_type,
                    :file_size,
                    :alt_text,
                    :width,
                    :height,
                    :storage_disk
                )
                ',
                [
                    ':uploaded_by' =>
                        $userId,

                    ':file_name' =>
                        $data['file_name'],

                    ':original_name' =>
                        $data['original_name'],

                    ':file_path' =>
                        $data['file_path'],

                    ':mime_type' =>
                        $data['mime_type'],

                    ':file_size' =>
                        $data['file_size'],

                    ':alt_text' =>
                        $data['alt_text']
                        ?? null,

                    ':width' =>
                        $data['width']
                        ?? null,

                    ':height' =>
                        $data['height']
                        ?? null,

                    ':storage_disk' =>
                        $data['storage_disk']
                        ?? 'local',
                ]
            );

        return Database::lastInsertId();
    }

    /**
     * Delete a media record.
     */
    public static function delete(
        int $id
    ): bool {
        return Database::execute(
            '
            DELETE FROM media
            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,
            ]
        ) > 0;
    }

    /**
     * Update alt text.
     */
    public static function updateAltText(
        int $id,
        ?string $altText
    ): bool {
        return Database::execute(
            '
            UPDATE media

            SET
                alt_text = :alt_text

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,

                ':alt_text' =>
                    $altText,
            ]
        ) > 0;
    }

    /**
     * Get all images.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function images(
        int $limit = 100
    ): array {
        $limit =
            max(
                1,
                min(
                    $limit,
                    500
                )
            );

        $statement =
            Database::connection()
                ->prepare(
                    '
                    SELECT *
                    FROM media

                    WHERE mime_type IN (
                        :jpeg,
                        :png,
                        :webp
                    )

                    ORDER BY
                        created_at DESC,
                        id DESC

                    LIMIT :limit
                    '
                );

        $statement->bindValue(
            ':jpeg',
            'image/jpeg',
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':png',
            'image/png',
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':webp',
            'image/webp',
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
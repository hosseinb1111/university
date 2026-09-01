<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class EnglishDocument
{
    /**
     * Paginate English documents for the admin panel.
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
                    FROM english_documents
                    '
                )
                ->fetchColumn();

        $statement =
            $pdo->prepare(
                '
                SELECT
                    english_documents.*,

                    english_document_categories.name
                        AS category_name,

                    english_document_categories.slug
                        AS category_slug,

                    creator.username
                        AS creator_username,

                    creator.first_name
                        AS creator_first_name,

                    creator.last_name
                        AS creator_last_name

                FROM english_documents

                INNER JOIN english_document_categories
                    ON english_document_categories.id =
                       english_documents.category_id

                LEFT JOIN users AS creator
                    ON creator.id =
                       english_documents.created_by

                ORDER BY
                    english_documents.created_at DESC,
                    english_documents.id DESC

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
     * Find an English document by ID.
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
                    english_documents.*,

                    english_document_categories.name
                        AS category_name,

                    english_document_categories.slug
                        AS category_slug

                FROM english_documents

                INNER JOIN english_document_categories
                    ON english_document_categories.id =
                       english_documents.category_id

                WHERE english_documents.id = :id

                LIMIT 1
                ',
                [
                    ':id' =>
                        $id,
                ]
            );

        $document =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $document === false
            ? null
            : $document;
    }


    /**
     * Get active English document categories.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function categories(): array
    {
        return EnglishDocumentCategory::active();
    }


    /**
     * Find active English category by slug.
     *
     * @return array<string, mixed>|null
     */
    public static function findCategoryBySlug(
        string $slug
    ): ?array {
        return EnglishDocumentCategory::findBySlug(
            $slug
        );
    }


    /**
     * Create an English document.
     *
     * @param array<string, mixed> $data
     */
    public static function create(
        array $data,
        int $userId
    ): int {
        Database::query(
            '
            INSERT INTO english_documents (
                category_id,
                title,
                description,
                file_path,
                file_name,
                mime_type,
                file_size,
                download_count,
                is_active,
                published_at,
                created_by,
                updated_by
            )

            VALUES (
                :category_id,
                :title,
                :description,
                :file_path,
                :file_name,
                :mime_type,
                :file_size,
                0,
                :is_active,
                :published_at,
                :created_by,
                :updated_by
            )
            ',
            [
                ':category_id' =>
                    $data['category_id'],

                ':title' =>
                    $data['title'],

                ':description' =>
                    $data['description']
                    ?? null,

                ':file_path' =>
                    $data['file_path'],

                ':file_name' =>
                    $data['file_name'],

                ':mime_type' =>
                    $data['mime_type']
                    ?? null,

                ':file_size' =>
                    $data['file_size']
                    ?? null,

                ':is_active' =>
                    (int) (
                        $data['is_active']
                        ?? 1
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

        return Database::lastInsertId();
    }


    /**
     * Update English document metadata.
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
            UPDATE english_documents

            SET
                category_id = :category_id,

                title = :title,

                description = :description,

                is_active = :is_active,

                published_at = :published_at,

                updated_by = :updated_by

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,

                ':category_id' =>
                    $data['category_id'],

                ':title' =>
                    $data['title'],

                ':description' =>
                    $data['description']
                    ?? null,

                ':is_active' =>
                    (int) (
                        $data['is_active']
                        ?? 1
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
     * Replace the stored English document file.
     *
     * @param array<string, mixed> $file
     */
    public static function replaceFile(
        int $id,
        array $file,
        int $userId
    ): bool {
        return Database::execute(
            '
            UPDATE english_documents

            SET
                file_path = :file_path,

                file_name = :file_name,

                mime_type = :mime_type,

                file_size = :file_size,

                updated_by = :updated_by

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,

                ':file_path' =>
                    $file['file_path'],

                ':file_name' =>
                    $file['file_name'],

                ':mime_type' =>
                    $file['mime_type']
                    ?? null,

                ':file_size' =>
                    $file['file_size']
                    ?? null,

                ':updated_by' =>
                    $userId,
            ]
        ) > 0;
    }


    /**
     * Delete an English document.
     */
    public static function delete(
        int $id
    ): bool {
        return Database::execute(
            '
            DELETE FROM english_documents

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,
            ]
        ) > 0;
    }


    /**
     * Get active English documents in a category.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function byCategory(
        int $categoryId
    ): array {
        $statement =
            Database::query(
                '
                SELECT
                    english_documents.*,

                    english_document_categories.name
                        AS category_name,

                    english_document_categories.slug
                        AS category_slug

                FROM english_documents

                INNER JOIN english_document_categories
                    ON english_document_categories.id =
                       english_documents.category_id

                WHERE english_documents.category_id =
                      :category_id

                AND english_documents.is_active = 1

                AND (
                    english_documents.published_at IS NULL

                    OR english_documents.published_at <= NOW()
                )

                ORDER BY
                    english_documents.published_at DESC,
                    english_documents.created_at DESC,
                    english_documents.id DESC
                ',
                [
                    ':category_id' =>
                        $categoryId,
                ]
            );

        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }


    /**
     * Get latest active English documents.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function latest(
        int $limit = 10
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
                    SELECT
                        english_documents.*,

                        english_document_categories.name
                            AS category_name,

                        english_document_categories.slug
                            AS category_slug

                    FROM english_documents

                    INNER JOIN english_document_categories
                        ON english_document_categories.id =
                           english_documents.category_id

                    WHERE english_documents.is_active = 1

                    AND (
                        english_documents.published_at IS NULL

                        OR english_documents.published_at <= NOW()
                    )

                    ORDER BY
                        english_documents.published_at DESC,
                        english_documents.created_at DESC,
                        english_documents.id DESC

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
     * Increment English document download count.
     */
    public static function incrementDownloadCount(
        int $id
    ): void {
        Database::execute(
            '
            UPDATE english_documents

            SET
                download_count =
                    download_count + 1

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,
            ]
        );
    }
}
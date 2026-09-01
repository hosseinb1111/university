<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use RuntimeException;

final class EnglishHomepageService
{
    /**
     * Paginate English homepage services.
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

                    FROM english_homepage_services
                    '
                )
                ->fetchColumn();

        $statement =
            $pdo->prepare(
                '
                SELECT
                    english_homepage_services.*

                FROM english_homepage_services

                ORDER BY
                    english_homepage_services.sort_order ASC,
                    english_homepage_services.id DESC

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
     * Get active English homepage services.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function latest(
        int $limit = 12
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
                        id,
                        title,
                        url,
                        image,
                        sort_order,
                        is_active

                    FROM english_homepage_services

                    WHERE is_active = 1

                    ORDER BY
                        sort_order ASC,
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
     * Find one service by ID.
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

                FROM english_homepage_services

                WHERE id = :id

                LIMIT 1
                ',
                [
                    ':id' =>
                        $id,
                ]
            );

        $service =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $service === false
            ? null
            : $service;
    }

    /**
     * Create an English homepage service.
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
                INSERT INTO english_homepage_services (
                    title,
                    url,
                    image,
                    sort_order,
                    is_active,
                    created_by,
                    updated_by
                )

                VALUES (
                    :title,
                    :url,
                    :image,
                    :sort_order,
                    :is_active,
                    :created_by,
                    :updated_by
                )
                ',
                [
                    ':title' =>
                        $data['title']
                        ?? '',

                    ':url' =>
                        $data['url']
                        ?? '',

                    ':image' =>
                        $data['image']
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
                'Failed creating English homepage service.'
            );
        }

        return Database::lastInsertId();
    }

    /**
     * Update an English homepage service.
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
            UPDATE english_homepage_services

            SET
                title = :title,

                url = :url,

                image = :image,

                sort_order = :sort_order,

                is_active = :is_active,

                updated_by = :updated_by

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,

                ':title' =>
                    $data['title']
                    ?? '',

                ':url' =>
                    $data['url']
                    ?? '',

                ':image' =>
                    $data['image']
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

                ':updated_by' =>
                    $userId,
            ]
        ) > 0;
    }

    /**
     * Delete an English homepage service.
     */
    public static function delete(
        int $id
    ): bool {
        return Database::execute(
            '
            DELETE FROM english_homepage_services

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,
            ]
        ) > 0;
    }

    /**
     * Count English homepage services.
     */
    public static function count(): int
    {
        $statement =
            Database::query(
                '
                SELECT COUNT(*)

                FROM english_homepage_services
                '
            );

        return (int) $statement->fetchColumn();
    }
}
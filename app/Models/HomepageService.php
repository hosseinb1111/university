<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use RuntimeException;

final class HomepageService
{
    /**
     * Get paginated services for the admin panel.
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
                    FROM homepage_services
                    '
                )
                ->fetchColumn();


        $statement =
            $pdo->prepare(
                '
                SELECT
                    homepage_services.*,

                    creator.username
                        AS created_by_username,

                    creator.first_name
                        AS created_by_first_name,

                    creator.last_name
                        AS created_by_last_name

                FROM homepage_services

                LEFT JOIN users AS creator
                    ON creator.id =
                       homepage_services.created_by

                ORDER BY
                    homepage_services.sort_order ASC,
                    homepage_services.id DESC

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
     * Get active services for the homepage.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function latest(
        int $limit = 20
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

                    FROM homepage_services

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
                SELECT *
                FROM homepage_services

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
     * Create a new service.
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
                INSERT INTO homepage_services (
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


        /*
         * Use the global PDOStatement class explicitly.
         *
         * This avoids namespace resolution problems inside
         * App\Models.
         */
        if (
            !(
                $statement
                instanceof \PDOStatement
            )
        ) {
            throw new RuntimeException(
                'تعریف خدمت انجام نشد.'
            );
        }


        return Database::lastInsertId();
    }


    /**
     * Update an existing service.
     *
     * @param array<string, mixed> $data
     */
    public static function update(
        int $id,
        array $data,
        int $userId
    ): bool {
        $affected =
            Database::execute(
                '
                UPDATE homepage_services

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
            );


        return $affected > 0;
    }


    /**
     * Delete a service.
     */
    public static function delete(
        int $id
    ): bool {
        $affected =
            Database::execute(
                '
                DELETE FROM homepage_services

                WHERE id = :id
                ',
                [
                    ':id' =>
                        $id,
                ]
            );


        return $affected > 0;
    }
}
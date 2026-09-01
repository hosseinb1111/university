<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use RuntimeException;

final class HomepageSlide
{
    /**
     * Paginate slides for the admin panel.
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

        $totalStatement =
            $pdo->query(
                '
                SELECT COUNT(*)
                FROM homepage_slides
                '
            );

        $total =
            (int) $totalStatement->fetchColumn();

        $statement =
            $pdo->prepare(
                '
                SELECT
                    homepage_slides.*,

                    creator.username
                        AS creator_username,

                    updater.username
                        AS updater_username

                FROM homepage_slides

                LEFT JOIN users AS creator
                    ON creator.id =
                       homepage_slides.created_by

                LEFT JOIN users AS updater
                    ON updater.id =
                       homepage_slides.updated_by

                ORDER BY
                    homepage_slides.sort_order ASC,
                    homepage_slides.created_at DESC,
                    homepage_slides.id DESC

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
     * Get currently active slides.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function active(): array
    {
        $statement =
            Database::query(
                '
                SELECT
                    *

                FROM homepage_slides

                WHERE is_active = 1

                AND (
                    starts_at IS NULL
                    OR starts_at <= NOW()
                )

                AND (
                    ends_at IS NULL
                    OR ends_at >= NOW()
                )

                ORDER BY
                    sort_order ASC,
                    id ASC
                '
            );

        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }

    /**
     * Get the latest active slides for the homepage.
     *
     * This method exists for compatibility with:
     *
     * HomepageSlide::latest(10)
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
                    50
                )
            );

        $statement =
            Database::connection()
                ->prepare(
                    '
                    SELECT
                        *

                    FROM homepage_slides

                    WHERE is_active = 1

                    AND (
                        starts_at IS NULL
                        OR starts_at <= NOW()
                    )

                    AND (
                        ends_at IS NULL
                        OR ends_at >= NOW()
                    )

                    ORDER BY
                        sort_order ASC,
                        id ASC

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
     * Find slide by ID.
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

                FROM homepage_slides

                WHERE id = :id

                LIMIT 1
                ',
                [
                    ':id' =>
                        $id,
                ]
            );

        $slide =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $slide === false
            ? null
            : $slide;
    }

    /**
     * Create a slide.
     *
     * @param array<string, mixed> $data
     */
    public static function create(
        array $data,
        int $userId
    ): int {
        $pdo =
            Database::connection();

        $statement =
            $pdo->prepare(
                '
                INSERT INTO homepage_slides (
                    title,
                    subtitle,
                    description,
                    button_text,
                    button_url,
                    image,
                    mobile_image,
                    sort_order,
                    is_active,
                    starts_at,
                    ends_at,
                    created_by,
                    updated_by
                )

                VALUES (
                    :title,
                    :subtitle,
                    :description,
                    :button_text,
                    :button_url,
                    :image,
                    :mobile_image,
                    :sort_order,
                    :is_active,
                    :starts_at,
                    :ends_at,
                    :created_by,
                    :updated_by
                )
                '
            );

        $statement->execute(
            [
                ':title' =>
                    $data['title']
                    ?? '',

                ':subtitle' =>
                    $data['subtitle']
                    ?? null,

                ':description' =>
                    $data['description']
                    ?? null,

                ':button_text' =>
                    $data['button_text']
                    ?? null,

                ':button_url' =>
                    $data['button_url']
                    ?? null,

                ':image' =>
                    $data['image']
                    ?? null,

                ':mobile_image' =>
                    $data['mobile_image']
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

                ':starts_at' =>
                    $data['starts_at']
                    ?? null,

                ':ends_at' =>
                    $data['ends_at']
                    ?? null,

                ':created_by' =>
                    $userId,

                ':updated_by' =>
                    $userId,
            ]
        );

        return (int) $pdo->lastInsertId();
    }

    /**
     * Update a slide.
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
            UPDATE homepage_slides

            SET
                title = :title,

                subtitle = :subtitle,

                description = :description,

                button_text = :button_text,

                button_url = :button_url,

                image = :image,

                mobile_image = :mobile_image,

                sort_order = :sort_order,

                is_active = :is_active,

                starts_at = :starts_at,

                ends_at = :ends_at,

                updated_by = :updated_by

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,

                ':title' =>
                    $data['title']
                    ?? '',

                ':subtitle' =>
                    $data['subtitle']
                    ?? null,

                ':description' =>
                    $data['description']
                    ?? null,

                ':button_text' =>
                    $data['button_text']
                    ?? null,

                ':button_url' =>
                    $data['button_url']
                    ?? null,

                ':image' =>
                    $data['image']
                    ?? null,

                ':mobile_image' =>
                    $data['mobile_image']
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

                ':starts_at' =>
                    $data['starts_at']
                    ?? null,

                ':ends_at' =>
                    $data['ends_at']
                    ?? null,

                ':updated_by' =>
                    $userId,
            ]
        ) > 0;
    }

    /**
     * Delete a slide.
     */
    public static function delete(
        int $id
    ): bool {
        return Database::execute(
            '
            DELETE FROM homepage_slides

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,
            ]
        ) > 0;
    }

    /**
     * Convert a nullable form value to null.
     */
    public static function nullable(
        mixed $value
    ): ?string {
        if (
            !is_string($value)
        ) {
            return null;
        }

        $value =
            trim($value);

        return $value === ''
            ? null
            : $value;
    }
}
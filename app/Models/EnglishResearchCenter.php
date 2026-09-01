<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use RuntimeException;

final class EnglishResearchCenter
{
    /**
     * Get all active English research centers.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function active(): array
    {
        $statement =
            Database::query(
                '
                SELECT
                    english_research_centers.*,

                    director.first_name
                        AS director_first_name,

                    director.last_name
                        AS director_last_name

                FROM english_research_centers

                LEFT JOIN english_people AS director
                    ON director.id =
                       english_research_centers.director_person_id

                WHERE english_research_centers.is_active = 1

                ORDER BY
                    english_research_centers.sort_order ASC,
                    english_research_centers.name ASC,
                    english_research_centers.id ASC
                '
            );

        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }


    /**
     * Find an active English research center by slug.
     *
     * @return array<string, mixed>|null
     */
    public static function findActiveBySlug(
        string $slug
    ): ?array {
        $statement =
            Database::query(
                '
                SELECT
                    english_research_centers.*,

                    director.first_name
                        AS director_first_name,

                    director.last_name
                        AS director_last_name

                FROM english_research_centers

                LEFT JOIN english_people AS director
                    ON director.id =
                       english_research_centers.director_person_id

                WHERE english_research_centers.slug = :slug

                AND english_research_centers.is_active = 1

                LIMIT 1
                ',
                [
                    ':slug' =>
                        trim($slug),
                ]
            );

        $center =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $center === false
            ? null
            : $center;
    }


    /**
     * Paginate English research centers.
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
                    FROM english_research_centers
                    '
                )
                ->fetchColumn();

        $statement =
            $pdo->prepare(
                '
                SELECT
                    english_research_centers.*,

                    director.first_name
                        AS director_first_name,

                    director.last_name
                        AS director_last_name

                FROM english_research_centers

                LEFT JOIN english_people AS director
                    ON director.id =
                       english_research_centers.director_person_id

                ORDER BY
                    english_research_centers.sort_order ASC,
                    english_research_centers.name ASC,
                    english_research_centers.id ASC

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
     * Find English research center by ID.
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
                    english_research_centers.*,

                    director.first_name
                        AS director_first_name,

                    director.last_name
                        AS director_last_name

                FROM english_research_centers

                LEFT JOIN english_people AS director
                    ON director.id =
                       english_research_centers.director_person_id

                WHERE english_research_centers.id = :id

                LIMIT 1
                ',
                [
                    ':id' =>
                        $id,
                ]
            );

        $center =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $center === false
            ? null
            : $center;
    }


    /**
     * Create an English research center.
     *
     * @param array<string, mixed> $data
     */
    public static function create(
        array $data,
        ?int $userId = null
    ): int {
        $statement =
            Database::query(
                '
                INSERT INTO english_research_centers (
                    slug,
                    name,
                    short_name,
                    description,
                    image,
                    director_person_id,
                    email,
                    phone,
                    address,
                    website,
                    sort_order,
                    is_active
                )

                VALUES (
                    :slug,
                    :name,
                    :short_name,
                    :description,
                    :image,
                    :director_person_id,
                    :email,
                    :phone,
                    :address,
                    :website,
                    :sort_order,
                    :is_active
                )
                ',
                [
                    ':slug' =>
                        $data['slug'],

                    ':name' =>
                        $data['name'],

                    ':short_name' =>
                        $data['short_name']
                        ?? null,

                    ':description' =>
                        $data['description']
                        ?? null,

                    ':image' =>
                        $data['image']
                        ?? null,

                    ':director_person_id' =>
                        $data['director_person_id']
                        ?? null,

                    ':email' =>
                        $data['email']
                        ?? null,

                    ':phone' =>
                        $data['phone']
                        ?? null,

                    ':address' =>
                        $data['address']
                        ?? null,

                    ':website' =>
                        $data['website']
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

        if (
            !($statement instanceof \PDOStatement)
        ) {
            throw new RuntimeException(
                'Failed creating English research center.'
            );
        }

        return Database::lastInsertId();
    }


    /**
     * Update an English research center.
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
            UPDATE english_research_centers

            SET
                slug = :slug,

                name = :name,

                short_name = :short_name,

                description = :description,

                image = :image,

                director_person_id = :director_person_id,

                email = :email,

                phone = :phone,

                address = :address,

                website = :website,

                sort_order = :sort_order,

                is_active = :is_active

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,

                ':slug' =>
                    $data['slug'],

                ':name' =>
                    $data['name'],

                ':short_name' =>
                    $data['short_name']
                    ?? null,

                ':description' =>
                    $data['description']
                    ?? null,

                ':image' =>
                    $data['image']
                    ?? null,

                ':director_person_id' =>
                    $data['director_person_id']
                    ?? null,

                ':email' =>
                    $data['email']
                    ?? null,

                ':phone' =>
                    $data['phone']
                    ?? null,

                ':address' =>
                    $data['address']
                    ?? null,

                ':website' =>
                    $data['website']
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
     * Delete an English research center.
     */
    public static function delete(
        int $id
    ): bool {
        return Database::execute(
            '
            DELETE FROM english_research_centers

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,
            ]
        ) > 0;
    }


    /**
     * Check whether an English research-center slug exists.
     */
    public static function slugExists(
        string $slug,
        ?int $ignoreId = null
    ): bool {
        $sql = '
            SELECT id

            FROM english_research_centers

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
     * Generate a unique English research-center slug.
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
                'research-center';
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


    /**
     * Count active English research centers.
     */
    public static function countActive(): int
    {
        $statement =
            Database::query(
                '
                SELECT COUNT(*)

                FROM english_research_centers

                WHERE is_active = 1
                '
            );

        return (int) $statement->fetchColumn();
    }


    /**
     * Find by slug regardless of active state.
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
                    english_research_centers.*,

                    director.first_name
                        AS director_first_name,

                    director.last_name
                        AS director_last_name

                FROM english_research_centers

                LEFT JOIN english_people AS director
                    ON director.id =
                       english_research_centers.director_person_id

                WHERE english_research_centers.slug = :slug

                LIMIT 1
                ',
                [
                    ':slug' =>
                        trim($slug),
                ]
            );

        $center =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $center === false
            ? null
            : $center;
    }
}
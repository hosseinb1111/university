<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use RuntimeException;

final class EnglishFaculty
{
    /**
     * Get all active English faculties.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function active(): array
    {
        $statement =
            Database::query(
                '
                SELECT
                    english_faculties.*,

                    dean.first_name
                        AS dean_first_name,

                    dean.last_name
                        AS dean_last_name

                FROM english_faculties

                LEFT JOIN english_people AS dean
                    ON dean.id =
                       english_faculties.dean_person_id

                WHERE english_faculties.is_active = 1

                ORDER BY
                    english_faculties.sort_order ASC,
                    english_faculties.name ASC,
                    english_faculties.id ASC
                '
            );

        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }


    /**
     * Find an active English faculty by slug.
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
                    english_faculties.*,

                    dean.first_name
                        AS dean_first_name,

                    dean.last_name
                        AS dean_last_name

                FROM english_faculties

                LEFT JOIN english_people AS dean
                    ON dean.id =
                       english_faculties.dean_person_id

                WHERE english_faculties.slug = :slug

                AND english_faculties.is_active = 1

                LIMIT 1
                ',
                [
                    ':slug' =>
                        trim($slug),
                ]
            );

        $faculty =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $faculty === false
            ? null
            : $faculty;
    }


    /**
     * Paginate English faculties for the admin panel.
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
                    FROM english_faculties
                    '
                )
                ->fetchColumn();

        $statement =
            $pdo->prepare(
                '
                SELECT
                    english_faculties.*,

                    dean.first_name
                        AS dean_first_name,

                    dean.last_name
                        AS dean_last_name

                FROM english_faculties

                LEFT JOIN english_people AS dean
                    ON dean.id =
                       english_faculties.dean_person_id

                ORDER BY
                    english_faculties.sort_order ASC,
                    english_faculties.name ASC,
                    english_faculties.id ASC

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
     * Find an English faculty by ID.
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
                    english_faculties.*,

                    dean.first_name
                        AS dean_first_name,

                    dean.last_name
                        AS dean_last_name

                FROM english_faculties

                LEFT JOIN english_people AS dean
                    ON dean.id =
                       english_faculties.dean_person_id

                WHERE english_faculties.id = :id

                LIMIT 1
                ',
                [
                    ':id' =>
                        $id,
                ]
            );

        $faculty =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $faculty === false
            ? null
            : $faculty;
    }


    /**
     * Create an English faculty.
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
                INSERT INTO english_faculties (
                    slug,
                    name,
                    short_name,
                    description,
                    image,
                    dean_person_id,
                    email,
                    phone,
                    fax,
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
                    :dean_person_id,
                    :email,
                    :phone,
                    :fax,
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

                    ':dean_person_id' =>
                        $data['dean_person_id']
                        ?? null,

                    ':email' =>
                        $data['email']
                        ?? null,

                    ':phone' =>
                        $data['phone']
                        ?? null,

                    ':fax' =>
                        $data['fax']
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
                'Failed creating English faculty.'
            );
        }

        return Database::lastInsertId();
    }


    /**
     * Update an English faculty.
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
            UPDATE english_faculties

            SET
                slug = :slug,

                name = :name,

                short_name = :short_name,

                description = :description,

                image = :image,

                dean_person_id = :dean_person_id,

                email = :email,

                phone = :phone,

                fax = :fax,

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

                ':dean_person_id' =>
                    $data['dean_person_id']
                    ?? null,

                ':email' =>
                    $data['email']
                    ?? null,

                ':phone' =>
                    $data['phone']
                    ?? null,

                ':fax' =>
                    $data['fax']
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
     * Delete an English faculty.
     */
    public static function delete(
        int $id
    ): bool {
        return Database::execute(
            '
            DELETE FROM english_faculties

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,
            ]
        ) > 0;
    }


    /**
     * Check whether an English faculty slug exists.
     */
    public static function slugExists(
        string $slug,
        ?int $ignoreId = null
    ): bool {
        $sql = '
            SELECT id

            FROM english_faculties

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
     * Generate a unique English faculty slug.
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
                'faculty';
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
     * Count active English faculties.
     */
    public static function countActive(): int
    {
        $statement =
            Database::query(
                '
                SELECT COUNT(*)

                FROM english_faculties

                WHERE is_active = 1
                '
            );

        return (int) $statement->fetchColumn();
    }


    /**
     * Find an English faculty by slug regardless of active state.
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
                    english_faculties.*,

                    dean.first_name
                        AS dean_first_name,

                    dean.last_name
                        AS dean_last_name

                FROM english_faculties

                LEFT JOIN english_people AS dean
                    ON dean.id =
                       english_faculties.dean_person_id

                WHERE english_faculties.slug = :slug

                LIMIT 1
                ',
                [
                    ':slug' =>
                        trim($slug),
                ]
            );

        $faculty =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $faculty === false
            ? null
            : $faculty;
    }
}
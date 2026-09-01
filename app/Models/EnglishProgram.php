<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use RuntimeException;

final class EnglishProgram
{
    /**
     * Get all active English programs.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function active(): array
    {
        $statement =
            Database::query(
                '
                SELECT
                    english_programs.*,

                    english_faculties.name
                        AS faculty_name,

                    english_faculties.slug
                        AS faculty_slug

                FROM english_programs

                INNER JOIN english_faculties
                    ON english_faculties.id =
                       english_programs.faculty_id

                WHERE english_programs.is_active = 1

                AND english_faculties.is_active = 1

                ORDER BY
                    english_faculties.sort_order ASC,
                    english_programs.sort_order ASC,
                    english_programs.name ASC
                '
            );

        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }


    /**
     * Find a published English program by slug.
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
                    english_programs.*,

                    english_faculties.name
                        AS faculty_name,

                    english_faculties.slug
                        AS faculty_slug

                FROM english_programs

                INNER JOIN english_faculties
                    ON english_faculties.id =
                       english_programs.faculty_id

                WHERE english_programs.slug = :slug

                AND english_programs.is_active = 1

                AND english_faculties.is_active = 1

                LIMIT 1
                ',
                [
                    ':slug' =>
                        trim($slug),
                ]
            );

        $program =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $program === false
            ? null
            : $program;
    }


    /**
     * Paginate English programs.
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
                    FROM english_programs
                    '
                )
                ->fetchColumn();

        $statement =
            $pdo->prepare(
                '
                SELECT
                    english_programs.*,

                    english_faculties.name
                        AS faculty_name,

                    english_faculties.slug
                        AS faculty_slug

                FROM english_programs

                INNER JOIN english_faculties
                    ON english_faculties.id =
                       english_programs.faculty_id

                ORDER BY
                    english_faculties.sort_order ASC,
                    english_programs.sort_order ASC,
                    english_programs.updated_at DESC,
                    english_programs.id DESC

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
     * Find an English program by ID.
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
                    english_programs.*,

                    english_faculties.name
                        AS faculty_name,

                    english_faculties.slug
                        AS faculty_slug

                FROM english_programs

                INNER JOIN english_faculties
                    ON english_faculties.id =
                       english_programs.faculty_id

                WHERE english_programs.id = :id

                LIMIT 1
                ',
                [
                    ':id' =>
                        $id,
                ]
            );

        $program =
            $statement->fetch(
                PDO::FETCH_ASSOC
            );

        return $program === false
            ? null
            : $program;
    }


    /**
     * Create an English program.
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
                INSERT INTO english_programs (
                    faculty_id,
                    slug,
                    name,
                    degree,
                    field,
                    description,
                    duration,
                    admission_info,
                    curriculum,
                    sort_order,
                    is_active
                )

                VALUES (
                    :faculty_id,
                    :slug,
                    :name,
                    :degree,
                    :field,
                    :description,
                    :duration,
                    :admission_info,
                    :curriculum,
                    :sort_order,
                    :is_active
                )
                ',
                [
                    ':faculty_id' =>
                        (int) (
                            $data['faculty_id']
                            ?? 0
                        ),

                    ':slug' =>
                        $data['slug'],

                    ':name' =>
                        $data['name'],

                    ':degree' =>
                        $data['degree']
                        ?? null,

                    ':field' =>
                        $data['field']
                        ?? null,

                    ':description' =>
                        $data['description']
                        ?? null,

                    ':duration' =>
                        $data['duration']
                        ?? null,

                    ':admission_info' =>
                        $data['admission_info']
                        ?? null,

                    ':curriculum' =>
                        $data['curriculum']
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
                'Failed creating English program.'
            );
        }

        return Database::lastInsertId();
    }


    /**
     * Update an English program.
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
            UPDATE english_programs

            SET
                faculty_id = :faculty_id,

                slug = :slug,

                name = :name,

                degree = :degree,

                field = :field,

                description = :description,

                duration = :duration,

                admission_info = :admission_info,

                curriculum = :curriculum,

                sort_order = :sort_order,

                is_active = :is_active

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,

                ':faculty_id' =>
                    (int) (
                        $data['faculty_id']
                        ?? 0
                    ),

                ':slug' =>
                    $data['slug'],

                ':name' =>
                    $data['name'],

                ':degree' =>
                    $data['degree']
                    ?? null,

                ':field' =>
                    $data['field']
                    ?? null,

                ':description' =>
                    $data['description']
                    ?? null,

                ':duration' =>
                    $data['duration']
                    ?? null,

                ':admission_info' =>
                    $data['admission_info']
                    ?? null,

                ':curriculum' =>
                    $data['curriculum']
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
     * Delete an English program.
     */
    public static function delete(
        int $id
    ): bool {
        return Database::execute(
            '
            DELETE FROM english_programs

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,
            ]
        ) > 0;
    }


    /**
     * Check whether an English program slug exists.
     */
    public static function slugExists(
        string $slug,
        ?int $ignoreId = null
    ): bool {
        $sql = '
            SELECT id

            FROM english_programs

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
     * Generate a unique English program slug.
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
                'program';
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
     * Get English programs belonging to an English faculty.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function byFaculty(
        int $facultyId
    ): array {
        $statement =
            Database::query(
                '
                SELECT
                    english_programs.*,

                    english_faculties.name
                        AS faculty_name,

                    english_faculties.slug
                        AS faculty_slug

                FROM english_programs

                INNER JOIN english_faculties
                    ON english_faculties.id =
                       english_programs.faculty_id

                WHERE english_programs.faculty_id =
                      :faculty_id

                AND english_programs.is_active = 1

                AND english_faculties.is_active = 1

                ORDER BY
                    english_programs.sort_order ASC,
                    english_programs.name ASC
                ',
                [
                    ':faculty_id' =>
                        $facultyId,
                ]
            );

        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }


    /**
     * Count active English programs.
     */
    public static function countActive(): int
    {
        $statement =
            Database::query(
                '
                SELECT COUNT(*)

                FROM english_programs

                WHERE is_active = 1
                '
            );

        return (int) $statement->fetchColumn();
    }
}
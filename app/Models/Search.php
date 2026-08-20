<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class Search
{
    /**
     * Search all public website content.
     *
     * @return array{
     *     pages: array<int, array<string, mixed>>,
     *     announcements: array<int, array<string, mixed>>,
     *     programs: array<int, array<string, mixed>>,
     *     faculties: array<int, array<string, mixed>>,
     *     people: array<int, array<string, mixed>>,
     *     researchCenters: array<int, array<string, mixed>>
     * }
     */
    public static function all(
        string $query,
        int $limit = 10
    ): array {
        $query = trim($query);

        $limit = max(
            1,
            min(
                $limit,
                50
            )
        );

        if ($query === '') {
            return [
                'pages' => [],
                'announcements' => [],
                'programs' => [],
                'faculties' => [],
                'people' => [],
                'researchCenters' => [],
            ];
        }

        return [
            'pages' =>
                self::pages(
                    $query,
                    $limit
                ),

            'announcements' =>
                self::announcements(
                    $query,
                    $limit
                ),

            'programs' =>
                self::programs(
                    $query,
                    $limit
                ),

            'faculties' =>
                self::faculties(
                    $query,
                    $limit
                ),

            'people' =>
                self::people(
                    $query,
                    $limit
                ),

            'researchCenters' =>
                self::researchCenters(
                    $query,
                    $limit
                ),
        ];
    }

    /**
     * Search published pages.
     *
     * @return array<int, array<string, mixed>>
     */
    private static function pages(
        string $query,
        int $limit
    ): array {
        $term =
            '%' . $query . '%';

        $statement =
            Database::connection()->prepare(
                '
                SELECT
                    id,
                    slug,
                    title,
                    excerpt,
                    content,
                    featured_image,
                    published_at

                FROM pages

                WHERE status = :status

                AND (
                    title LIKE :title
                    OR excerpt LIKE :excerpt
                    OR content LIKE :content
                    OR seo_title LIKE :seo_title
                    OR seo_description LIKE :seo_description
                    OR seo_keywords LIKE :seo_keywords
                )

                AND (
                    published_at IS NULL
                    OR published_at <= NOW()
                )

                ORDER BY
                    published_at DESC,
                    updated_at DESC,
                    id DESC

                LIMIT :limit
                '
            );

        self::bindSearchParameters(
            $statement,
            $term,
            [
                'title',
                'excerpt',
                'content',
                'seo_title',
                'seo_description',
                'seo_keywords',
            ],
            'published',
            $limit
        );

        $statement->execute();

        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }

    /**
     * Search published announcements.
     *
     * @return array<int, array<string, mixed>>
     */
    private static function announcements(
        string $query,
        int $limit
    ): array {
        $term =
            '%' . $query . '%';

        $statement =
            Database::connection()->prepare(
                '
                SELECT
                    id,
                    slug,
                    title,
                    excerpt,
                    content,
                    featured_image,
                    priority,
                    published_at,
                    expires_at

                FROM announcements

                WHERE status = :status

                AND (
                    title LIKE :title
                    OR excerpt LIKE :excerpt
                    OR content LIKE :content
                )

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

        self::bindSearchParameters(
            $statement,
            $term,
            [
                'title',
                'excerpt',
                'content',
            ],
            'published',
            $limit
        );

        $statement->execute();

        return $statement->fetchAll(
            PDO::FETCH_ASSOC
        );
    }

    /**
     * Search active programs.
     *
     * @return array<int, array<string, mixed>>
     */
    private static function programs(
        string $query,
        int $limit
    ): array {
        $term =
            '%' . $query . '%';

        $statement =
            Database::connection()->prepare(
                '
                SELECT
                    programs.id,
                    programs.faculty_id,
                    programs.slug,
                    programs.name,
                    programs.degree,
                    programs.field,
                    programs.description,
                    programs.duration,

                    faculties.name AS faculty_name,
                    faculties.slug AS faculty_slug

                FROM programs

                INNER JOIN faculties
                    ON faculties.id =
                       programs.faculty_id

                WHERE programs.is_active = 1

                AND faculties.is_active = 1

                AND (
                    programs.name LIKE :name
                    OR programs.degree LIKE :degree
                    OR programs.field LIKE :field
                    OR programs.description LIKE :description
                    OR faculties.name LIKE :faculty_name
                )

                ORDER BY
                    faculties.sort_order ASC,
                    programs.sort_order ASC,
                    programs.name ASC

                LIMIT :limit
                '
            );

        $statement->bindValue(
            ':name',
            $term,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':degree',
            $term,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':field',
            $term,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':description',
            $term,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':faculty_name',
            $term,
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
     * Search active faculties.
     *
     * @return array<int, array<string, mixed>>
     */
    private static function faculties(
        string $query,
        int $limit
    ): array {
        $term =
            '%' . $query . '%';

        $statement =
            Database::connection()->prepare(
                '
                SELECT
                    id,
                    slug,
                    name,
                    short_name,
                    description,
                    image,
                    email,
                    phone,
                    address

                FROM faculties

                WHERE is_active = 1

                AND (
                    name LIKE :name
                    OR short_name LIKE :short_name
                    OR description LIKE :description
                    OR email LIKE :email
                )

                ORDER BY
                    sort_order ASC,
                    name ASC,
                    id ASC

                LIMIT :limit
                '
            );

        $statement->bindValue(
            ':name',
            $term,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':short_name',
            $term,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':description',
            $term,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':email',
            $term,
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
     * Search active people.
     *
     * @return array<int, array<string, mixed>>
     */
    private static function people(
        string $query,
        int $limit
    ): array {
        $term =
            '%' . $query . '%';

        $statement =
            Database::connection()->prepare(
                '
                SELECT
                    people.id,
                    people.faculty_id,
                    people.first_name,
                    people.last_name,
                    people.position,
                    people.email,
                    people.phone,
                    people.image,
                    people.biography,
                    people.office_location,

                    faculties.name AS faculty_name,
                    faculties.slug AS faculty_slug

                FROM people

                LEFT JOIN faculties
                    ON faculties.id =
                       people.faculty_id

                WHERE people.is_active = 1

                AND (
                    people.first_name LIKE :first_name
                    OR people.last_name LIKE :last_name
                    OR people.position LIKE :position
                    OR people.email LIKE :email
                    OR people.biography LIKE :biography
                    OR people.office_location LIKE :office_location
                    OR faculties.name LIKE :faculty_name
                )

                ORDER BY
                    people.sort_order ASC,
                    people.last_name ASC,
                    people.first_name ASC,
                    people.id ASC

                LIMIT :limit
                '
            );

        $statement->bindValue(
            ':first_name',
            $term,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':last_name',
            $term,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':position',
            $term,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':email',
            $term,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':biography',
            $term,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':office_location',
            $term,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':faculty_name',
            $term,
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
     * Search active research centers.
     *
     * @return array<int, array<string, mixed>>
     */
    private static function researchCenters(
        string $query,
        int $limit
    ): array {
        $term =
            '%' . $query . '%';

        $statement =
            Database::connection()->prepare(
                '
                SELECT
                    id,
                    slug,
                    name,
                    description,
                    email,
                    phone,
                    address

                FROM research_centers

                WHERE is_active = 1

                AND (
                    name LIKE :name
                    OR description LIKE :description
                    OR email LIKE :email
                    OR phone LIKE :phone
                    OR address LIKE :address
                )

                ORDER BY
                    sort_order ASC,
                    name ASC,
                    id ASC

                LIMIT :limit
                '
            );

        $statement->bindValue(
            ':name',
            $term,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':description',
            $term,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':email',
            $term,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':phone',
            $term,
            PDO::PARAM_STR
        );

        $statement->bindValue(
            ':address',
            $term,
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
     * Bind common search parameters.
     *
     * @param array<int, string> $columns
     */
    private static function bindSearchParameters(
        PDO $statement,
        string $term,
        array $columns,
        string $status,
        int $limit
    ): void {
        $statement->bindValue(
            ':status',
            $status,
            PDO::PARAM_STR
        );

        foreach (
            $columns
            as $column
        ) {
            $statement->bindValue(
                ':' . $column,
                $term,
                PDO::PARAM_STR
            );
        }

        $statement->bindValue(
            ':limit',
            $limit,
            PDO::PARAM_INT
        );
    }
}
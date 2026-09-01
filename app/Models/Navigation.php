<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class Navigation
{
    /**
     * Get active root-level main navigation items.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function roots(): array
    {
        return Database::all(
            '
            SELECT
                navigation_items.*,

                pages.title AS page_title,

                pages.slug AS page_slug

            FROM navigation_items

            LEFT JOIN pages
                ON pages.id =
                   navigation_items.page_id

            WHERE navigation_items.parent_id IS NULL

            AND navigation_items.display_location = :display_location

            AND navigation_items.is_active = 1

            ORDER BY
                navigation_items.sort_order ASC,
                navigation_items.id ASC
            ',
            [
                ':display_location' =>
                    'main',
            ]
        );
    }

    /**
     * Get active children of a main item.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function children(
        int $parentId
    ): array {
        return Database::all(
            '
            SELECT
                navigation_items.*,

                pages.title AS page_title,

                pages.slug AS page_slug

            FROM navigation_items

            LEFT JOIN pages
                ON pages.id =
                   navigation_items.page_id

            WHERE navigation_items.parent_id = :parent_id

            AND navigation_items.display_location = :display_location

            AND navigation_items.is_active = 1

            ORDER BY
                navigation_items.sort_order ASC,
                navigation_items.id ASC
            ',
            [
                ':parent_id' =>
                    $parentId,

                ':display_location' =>
                    'main',
            ]
        );
    }

    /**
     * Build public navigation tree.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function tree(): array
    {
        $items =
            Database::all(
                '
                SELECT
                    navigation_items.*,

                    pages.title AS page_title,

                    pages.slug AS page_slug

                FROM navigation_items

                LEFT JOIN pages
                    ON pages.id =
                       navigation_items.page_id

                WHERE navigation_items.display_location = :display_location

                AND navigation_items.is_active = 1

                ORDER BY
                    navigation_items.sort_order ASC,
                    navigation_items.id ASC
                ',
                [
                    ':display_location' =>
                        'main',
                ]
            );

        return self::buildTree(
            $items
        );
    }

    /**
     * Get homepage quick-service links.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function quickLinks(
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
                        navigation_items.*,

                        pages.title AS page_title,

                        pages.slug AS page_slug

                    FROM navigation_items

                    LEFT JOIN pages
                        ON pages.id =
                           navigation_items.page_id

                    WHERE navigation_items.parent_id IS NULL

                    AND navigation_items.display_location = :display_location

                    AND navigation_items.is_active = 1

                    ORDER BY
                        navigation_items.sort_order ASC,
                        navigation_items.id ASC

                    LIMIT :limit
                    '
                );

        $statement->bindValue(
            ':display_location',
            'quick',
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
     * Get all navigation items for admin.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function all(): array
    {
        return Database::all(
            '
            SELECT
                navigation_items.*,

                parent.title AS parent_title,

                pages.title AS page_title,

                pages.slug AS page_slug

            FROM navigation_items

            LEFT JOIN navigation_items AS parent
                ON parent.id =
                   navigation_items.parent_id

            LEFT JOIN pages
                ON pages.id =
                   navigation_items.page_id

            ORDER BY
                navigation_items.display_location ASC,
                navigation_items.sort_order ASC,
                navigation_items.id ASC
            '
        );
    }

    /**
     * Find navigation item by ID.
     *
     * @return array<string, mixed>|null
     */
    public static function find(
        int $id
    ): ?array {
        return Database::first(
            '
            SELECT
                navigation_items.*,

                parent.title AS parent_title,

                pages.title AS page_title,

                pages.slug AS page_slug

            FROM navigation_items

            LEFT JOIN navigation_items AS parent
                ON parent.id =
                   navigation_items.parent_id

            LEFT JOIN pages
                ON pages.id =
                   navigation_items.page_id

            WHERE navigation_items.id = :id

            LIMIT 1
            ',
            [
                ':id' =>
                    $id,
            ]
        );
    }

    /**
     * Get possible main-navigation parents.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function parentOptions(
        ?int $ignoreId = null
    ): array {
        $sql =
            '
            SELECT
                id,
                parent_id,
                title

            FROM navigation_items

            WHERE display_location = :display_location

            AND parent_id IS NULL
            ';

        $parameters = [
            ':display_location' =>
                'main',
        ];

        if (
            $ignoreId !== null
        ) {
            $sql .=
                '
                AND id != :ignore_id
                ';

            $parameters[':ignore_id'] =
                $ignoreId;
        }

        $sql .=
            '
            ORDER BY
                sort_order ASC,
                title ASC
            ';

        return Database::all(
            $sql,
            $parameters
        );
    }

    /**
     * Create navigation item.
     *
     * @param array<string, mixed> $data
     */
    public static function create(
        array $data
    ): int {
        $displayLocation =
            self::normalizeDisplayLocation(
                $data['display_location']
                ?? 'main'
            );

        $parentId =
            $data['parent_id']
            ?? null;

        if (
            $displayLocation === 'quick'
        ) {
            $parentId =
                null;
        }

        Database::execute(
            '
            INSERT INTO navigation_items (
                parent_id,
                display_location,
                page_id,
                title,
                description,
                url,
                target,
                sort_order,
                is_active
            )

            VALUES (
                :parent_id,
                :display_location,
                :page_id,
                :title,
                :description,
                :url,
                :target,
                :sort_order,
                :is_active
            )
            ',
            [
                ':parent_id' =>
                    $parentId,

                ':display_location' =>
                    $displayLocation,

                ':page_id' =>
                    $data['page_id']
                    ?? null,

                ':title' =>
                    $data['title'],

                ':description' =>
                    $data['description']
                    ?? null,

                ':url' =>
                    $data['url']
                    ?? null,

                ':target' =>
                    self::normalizeTarget(
                        $data['target']
                        ?? '_self'
                    ),

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

        return Database::lastInsertId();
    }

    /**
     * Update navigation item.
     *
     * @param array<string, mixed> $data
     */
    public static function update(
        int $id,
        array $data
    ): bool {
        $displayLocation =
            self::normalizeDisplayLocation(
                $data['display_location']
                ?? 'main'
            );

        $parentId =
            $data['parent_id']
            ?? null;

        if (
            $displayLocation === 'quick'
        ) {
            $parentId =
                null;
        }

        return Database::execute(
            '
            UPDATE navigation_items

            SET
                parent_id = :parent_id,

                display_location =
                    :display_location,

                page_id = :page_id,

                title = :title,

                description = :description,

                url = :url,

                target = :target,

                sort_order = :sort_order,

                is_active = :is_active

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,

                ':parent_id' =>
                    $parentId,

                ':display_location' =>
                    $displayLocation,

                ':page_id' =>
                    $data['page_id']
                    ?? null,

                ':title' =>
                    $data['title'],

                ':description' =>
                    $data['description']
                    ?? null,

                ':url' =>
                    $data['url']
                    ?? null,

                ':target' =>
                    self::normalizeTarget(
                        $data['target']
                        ?? '_self'
                    ),

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
     * Delete navigation item.
     */
    public static function delete(
        int $id
    ): bool {
        return Database::execute(
            '
            DELETE FROM navigation_items

            WHERE id = :id
            ',
            [
                ':id' =>
                    $id,
            ]
        ) > 0;
    }

    /**
     * Build nested navigation tree.
     *
     * @param array<int, array<string, mixed>> $items
     *
     * @return array<int, array<string, mixed>>
     */
    private static function buildTree(
        array $items,
        ?int $parentId = null
    ): array {
        $tree = [];

        foreach (
            $items
            as $item
        ) {
            $itemParentId =
                $item['parent_id'] === null
                    ? null
                    : (int) $item['parent_id'];

            if (
                $itemParentId !== $parentId
            ) {
                continue;
            }

            $item['children'] =
                self::buildTree(
                    $items,
                    (int) $item['id']
                );

            $tree[] =
                $item;
        }

        return $tree;
    }

    /**
     * Resolve final public URL.
     *
     * @param array<string, mixed> $item
     */
    public static function url(
        array $item
    ): string {
        if (
            !empty(
                $item['url']
            )
        ) {
            return (string) $item['url'];
        }

        if (
            !empty(
                $item['page_slug']
            )
        ) {
            return '/pages/'
                . rawurlencode(
                    (string) $item['page_slug']
                );
        }

        return '#';
    }

    /**
     * Normalize display location.
     */
    public static function normalizeDisplayLocation(
        mixed $value
    ): string {
        return $value === 'quick'
            ? 'quick'
            : 'main';
    }

    /**
     * Normalize link target.
     */
    public static function normalizeTarget(
        mixed $target
    ): string {
        return $target === '_blank'
            ? '_blank'
            : '_self';
    }

    /**
     * Validate parent cycle.
     */
    public static function wouldCreateCycle(
        int $itemId,
        ?int $parentId
    ): bool {
        if (
            $parentId === null
        ) {
            return false;
        }

        if (
            $itemId === $parentId
        ) {
            return true;
        }

        $visited = [];

        $current =
            $parentId;

        while (
            $current !== null
        ) {
            if (
                isset(
                    $visited[$current]
                )
            ) {
                return true;
            }

            $visited[$current] =
                true;

            if (
                $current === $itemId
            ) {
                return true;
            }

            $parent =
                Database::first(
                    '
                    SELECT
                        parent_id

                    FROM navigation_items

                    WHERE id = :id

                    LIMIT 1
                    ',
                    [
                        ':id' =>
                            $current,
                    ]
                );

            if (
                $parent === null
            ) {
                return false;
            }

            $current =
                $parent['parent_id'] === null
                    ? null
                    : (int) $parent['parent_id'];
        }

        return false;
    }
}
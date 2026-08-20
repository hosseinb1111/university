<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;
use RuntimeException;

final class Navigation
{
    /**
     * Get all active root-level navigation items.
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
                ON pages.id = navigation_items.page_id

            WHERE navigation_items.parent_id IS NULL

            AND navigation_items.is_active = 1

            ORDER BY
                navigation_items.sort_order ASC,
                navigation_items.id ASC
            '
        );
    }

    /**
     * Get active children of a navigation item.
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
                ON pages.id = navigation_items.page_id

            WHERE navigation_items.parent_id = :parent_id

            AND navigation_items.is_active = 1

            ORDER BY
                navigation_items.sort_order ASC,
                navigation_items.id ASC
            ',
            [
                ':parent_id' => $parentId,
            ]
        );
    }

    /**
     * Build the complete public navigation tree.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function tree(): array
    {
        $items = Database::all(
            '
            SELECT
                navigation_items.*,

                pages.title AS page_title,

                pages.slug AS page_slug

            FROM navigation_items

            LEFT JOIN pages
                ON pages.id = navigation_items.page_id

            WHERE navigation_items.is_active = 1

            ORDER BY
                navigation_items.sort_order ASC,
                navigation_items.id ASC
            '
        );

        return self::buildTree(
            $items
        );
    }

    /**
     * Get all navigation records for admin.
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
                ON parent.id = navigation_items.parent_id

            LEFT JOIN pages
                ON pages.id = navigation_items.page_id

            ORDER BY
                navigation_items.sort_order ASC,
                navigation_items.id ASC
            '
        );
    }

    /**
     * Find by ID.
     */
    public static function find(
        int $id
    ): ?array {
        return Database::first(
            '
            SELECT
                navigation_items.*,

                pages.title AS page_title,

                pages.slug AS page_slug

            FROM navigation_items

            LEFT JOIN pages
                ON pages.id = navigation_items.page_id

            WHERE navigation_items.id = :id

            LIMIT 1
            ',
            [
                ':id' => $id,
            ]
        );
    }

    /**
     * Get possible parent items.
     */
    public static function parentOptions(
        ?int $ignoreId = null
    ): array {
        $sql = '
            SELECT
                id,
                parent_id,
                title
            FROM navigation_items
        ';

        $parameters = [];

        if ($ignoreId !== null) {
            $sql .= '
                WHERE id != :ignore_id
            ';

            $parameters[':ignore_id'] =
                $ignoreId;
        }

        $sql .= '
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
     */
    public static function create(
        array $data
    ): int {
        $parentId = $data['parent_id']
            ?? null;

        $pageId = $data['page_id']
            ?? null;

        /*
         * A navigation item should not point to both
         * a page and a completely unrelated URL unless
         * explicitly desired.
         */
        Database::execute(
            '
            INSERT INTO navigation_items (
                parent_id,
                page_id,
                title,
                url,
                target,
                sort_order,
                is_active
            )
            VALUES (
                :parent_id,
                :page_id,
                :title,
                :url,
                :target,
                :sort_order,
                :is_active
            )
            ',
            [
                ':parent_id' =>
                    $parentId,

                ':page_id' =>
                    $pageId,

                ':title' =>
                    $data['title'],

                ':url' =>
                    $data['url'] ?? null,

                ':target' =>
                    $data['target']
                    ?? '_self',

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
     */
    public static function update(
        int $id,
        array $data
    ): bool {
        return Database::execute(
            '
            UPDATE navigation_items

            SET
                parent_id = :parent_id,

                page_id = :page_id,

                title = :title,

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
                    $data['parent_id']
                    ?? null,

                ':page_id' =>
                    $data['page_id']
                    ?? null,

                ':title' =>
                    $data['title'],

                ':url' =>
                    $data['url']
                    ?? null,

                ':target' =>
                    $data['target']
                    ?? '_self',

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
                ':id' => $id,
            ]
        ) > 0;
    }

    /**
     * Build a nested tree.
     *
     * @param array<int, array<string, mixed>> $items
     * @param int|null $parentId
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

            $tree[] = $item;
        }

        return $tree;
    }

    /**
     * Build the final public URL for a navigation item.
     */
    public static function url(
        array $item
    ): string {
        if (
            !empty($item['url'])
        ) {
            return (string) $item['url'];
        }

        if (
            !empty($item['page_slug'])
        ) {
            return '/pages/'
                . rawurlencode(
                    (string) $item['page_slug']
                );
        }

        return '#';
    }

    /**
     * Validate a navigation target.
     */
    public static function normalizeTarget(
        mixed $target
    ): string {
        return $target === '_blank'
            ? '_blank'
            : '_self';
    }

    /**
     * Validate whether a parent relationship is safe.
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

        $current = $parentId;

        while (
            $current !== null
        ) {
            if (
                isset(
                    $visited[$current]
                )
            ) {
                /*
                 * Existing corrupted cycle.
                 */
                return true;
            }

            $visited[$current] = true;

            if (
                $current === $itemId
            ) {
                return true;
            }

            $parent = Database::first(
                '
                SELECT parent_id
                FROM navigation_items
                WHERE id = :id
                LIMIT 1
                ',
                [
                    ':id' => $current,
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
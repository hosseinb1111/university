<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Models\Search;

final class SearchController
{
    /**
     * Public search page.
     */
    public function index(): string
    {
        $query = trim(
            (string) (
                $_GET['q']
                ?? ''
            )
        );

        $results = [
            'pages' => [],
            'announcements' => [],
            'programs' => [],
            'faculties' => [],
            'people' => [],
            'researchCenters' => [],
        ];

        $total = 0;

        /*
         * Only execute database searches when the
         * user has actually entered a query.
         */
        if ($query !== '') {
            $results = Search::all(
                $query,
                10
            );

            $total =
                $this->countResults(
                    $results
                );
        }

        return View::renderIntoLayout(
            'layouts/app',
            'search/index',
            [
                'title' =>
                    $query !== ''
                        ? 'جستجو برای «'
                            . $query
                            . '» | صدرا'
                        : 'جستجو | صدرا',

                'description' =>
                    'جستجو در صفحات، اطلاعیه‌ها، رشته‌ها، دانشکده‌ها، اعضای موسسه و پژوهشکده‌ها.',

                'query' =>
                    $query,

                'results' =>
                    $results,

                'total' =>
                    $total,
            ]
        );
    }

    /**
     * Count all search results.
     *
     * @param array<string, mixed> $results
     */
    private function countResults(
        array $results
    ): int {
        $total = 0;

        $keys = [
            'pages',
            'announcements',
            'programs',
            'faculties',
            'people',
            'researchCenters',
        ];

        foreach (
            $keys
            as $key
        ) {
            if (
                !isset(
                    $results[$key]
                )
            ) {
                continue;
            }

            if (
                !is_array(
                    $results[$key]
                )
            ) {
                continue;
            }

            $total += count(
                $results[$key]
            );
        }

        return $total;
    }
}
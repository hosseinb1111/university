<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Response;
use App\Core\View;
use App\Models\Announcement;
use App\Models\Faculty;
use App\Models\Page;
use App\Models\Program;
use App\Models\ResearchCenter;

final class SeoController
{
    /**
     * Generate sitemap.xml.
     */
    public function sitemap(): never
    {
        $baseUrl =
            rtrim(
                (string) config(
                    'app.url',
                    ''
                ),
                '/'
            );

        $urls = [];

        /*
        |--------------------------------------------------------------------------
        | Static public pages
        |--------------------------------------------------------------------------
        */

        $staticPaths = [
            '/',
            '/about',
            '/presidency',
            '/education',
            '/student-affairs',
            '/support',
            '/contact',
            '/announcements',
            '/faculties',
            '/programs',
            '/people',
            '/research-centers',
            '/documents',
            '/search',
            '/english',
            '/english/about',
            '/english/presidency',
            '/english/faculties',
            '/english/research',
            '/english/announcements',
            '/english/contact',
        ];

        foreach (
            $staticPaths
            as $path
        ) {
            $urls[] = [
                'loc' =>
                    $baseUrl . $path,

                'changefreq' =>
                    $this->changeFrequency(
                        $path
                    ),

                'priority' =>
                    $this->priority(
                        $path
                    ),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Published CMS pages
        |--------------------------------------------------------------------------
        */

        $pages =
            Page::publishedForSitemap();

        foreach (
            $pages
            as $page
        ) {
            $slug =
                trim(
                    (string) (
                        $page['slug']
                        ?? ''
                    )
                );

            if (
                $slug === ''
            ) {
                continue;
            }

            $urls[] = [
                'loc' =>
                    $baseUrl
                    . '/pages/'
                    . rawurlencode(
                        $slug
                    ),

                'lastmod' =>
                    $this->lastModified(
                        $page['updated_at']
                        ?? $page['published_at']
                        ?? null
                    ),

                'changefreq' =>
                    'weekly',

                'priority' =>
                    '0.7',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Announcements
        |--------------------------------------------------------------------------
        */

        $announcements =
            Announcement::allPublishedForSitemap();

        foreach (
            $announcements
            as $announcement
        ) {
            $slug =
                trim(
                    (string) (
                        $announcement['slug']
                        ?? ''
                    )
                );

            if (
                $slug === ''
            ) {
                continue;
            }

            $urls[] = [
                'loc' =>
                    $baseUrl
                    . '/announcements/'
                    . rawurlencode(
                        $slug
                    ),

                'lastmod' =>
                    $this->lastModified(
                        $announcement['updated_at']
                        ?? $announcement['published_at']
                        ?? null
                    ),

                'changefreq' =>
                    'daily',

                'priority' =>
                    '0.8',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Faculties
        |--------------------------------------------------------------------------
        */

        $faculties =
            Faculty::active();

        foreach (
            $faculties
            as $faculty
        ) {
            $slug =
                trim(
                    (string) (
                        $faculty['slug']
                        ?? ''
                    )
                );

            if (
                $slug === ''
            ) {
                continue;
            }

            $urls[] = [
                'loc' =>
                    $baseUrl
                    . '/faculties/'
                    . rawurlencode(
                        $slug
                    ),

                'lastmod' =>
                    $this->lastModified(
                        $faculty['updated_at']
                        ?? null
                    ),

                'changefreq' =>
                    'weekly',

                'priority' =>
                    '0.8',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Programs
        |--------------------------------------------------------------------------
        */

        $programs =
            Program::active();

        foreach (
            $programs
            as $program
        ) {
            $slug =
                trim(
                    (string) (
                        $program['slug']
                        ?? ''
                    )
                );

            if (
                $slug === ''
            ) {
                continue;
            }

            $urls[] = [
                'loc' =>
                    $baseUrl
                    . '/programs/'
                    . rawurlencode(
                        $slug
                    ),

                'lastmod' =>
                    $this->lastModified(
                        $program['updated_at']
                        ?? null
                    ),

                'changefreq' =>
                    'weekly',

                'priority' =>
                    '0.7',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Research centers
        |--------------------------------------------------------------------------
        */

        $researchCenters =
            ResearchCenter::active();

        foreach (
            $researchCenters
            as $center
        ) {
            $slug =
                trim(
                    (string) (
                        $center['slug']
                        ?? ''
                    )
                );

            if (
                $slug === ''
            ) {
                continue;
            }

            $urls[] = [
                'loc' =>
                    $baseUrl
                    . '/research-centers/'
                    . rawurlencode(
                        $slug
                    ),

                'lastmod' =>
                    $this->lastModified(
                        $center['updated_at']
                        ?? null
                    ),

                'changefreq' =>
                    'weekly',

                'priority' =>
                    '0.7',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Remove duplicate URLs
        |--------------------------------------------------------------------------
        */

        $unique = [];

        foreach (
            $urls
            as $url
        ) {
            $loc =
                (string) (
                    $url['loc']
                    ?? ''
                );

            if (
                $loc === ''
            ) {
                continue;
            }

            $unique[$loc] =
                $url;
        }

        /*
        |--------------------------------------------------------------------------
        | XML response
        |--------------------------------------------------------------------------
        */

        $xml =
            $this->buildSitemapXml(
                array_values(
                    $unique
                )
            );

        Response::xml(
            $xml
        );
    }

    /**
     * Generate robots.txt.
     */
    public function robots(): never
    {
        $baseUrl =
            rtrim(
                (string) config(
                    'app.url',
                    ''
                ),
                '/'
            );

        $sitemapUrl =
            $baseUrl
            . '/sitemap.xml';

        $content =
            implode(
                "\n",
                [
                    'User-agent: *',
                    'Allow: /',
                    'Disallow: /admin',
                    'Disallow: /teacher',
                    'Disallow: /storage/',
                    '',
                    'Sitemap: ' . $sitemapUrl,
                    '',
                ]
            );

        Response::text(
            $content
        );
    }

    /**
     * Build sitemap XML.
     *
     * @param array<int, array<string, string>> $urls
     */
    private function buildSitemapXml(
        array $urls
    ): string {
        $xml =
            '<?xml version="1.0" encoding="UTF-8"?>'
            . "\n"
            . '<urlset'
            . ' xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"'
            . '>'
            . "\n";

        foreach (
            $urls
            as $url
        ) {
            $xml .=
                "    <url>\n";

            $xml .=
                '        <loc>'
                . $this->xmlEscape(
                    (string) (
                        $url['loc']
                        ?? ''
                    )
                )
                . "</loc>\n";

            if (
                !empty(
                    $url['lastmod']
                )
            ) {
                $xml .=
                    '        <lastmod>'
                    . $this->xmlEscape(
                        (string) $url['lastmod']
                    )
                    . "</lastmod>\n";
            }

            if (
                !empty(
                    $url['changefreq']
                )
            ) {
                $xml .=
                    '        <changefreq>'
                    . $this->xmlEscape(
                        (string) $url['changefreq']
                    )
                    . "</changefreq>\n";
            }

            if (
                !empty(
                    $url['priority']
                )
            ) {
                $xml .=
                    '        <priority>'
                    . $this->xmlEscape(
                        (string) $url['priority']
                    )
                    . "</priority>\n";
            }

            $xml .=
                "    </url>\n";
        }

        $xml .=
            '</urlset>';

        return $xml;
    }

    /**
     * Determine sitemap change frequency.
     */
    private function changeFrequency(
        string $path
    ): string {
        return match ($path) {
            '/' =>
                'daily',

            '/announcements',
            '/search' =>
                'daily',

            default =>
                'weekly',
        };
    }

    /**
     * Determine sitemap priority.
     */
    private function priority(
        string $path
    ): string {
        return match ($path) {
            '/' =>
                '1.0',

            '/announcements',
            '/faculties',
            '/programs',
            '/research-centers' =>
                '0.9',

            '/about',
            '/presidency',
            '/education',
            '/student-affairs',
            '/support',
            '/contact' =>
                '0.8',

            default =>
                '0.6',
        };
    }

    /**
     * Normalize a database timestamp for sitemap XML.
     */
    private function lastModified(
        mixed $value
    ): ?string {
        if (
            !is_string(
                $value
            )
            || trim($value) === ''
        ) {
            return null;
        }

        $timestamp =
            strtotime(
                $value
            );

        if (
            $timestamp === false
        ) {
            return null;
        }

        return gmdate(
            'Y-m-d\TH:i:s\Z',
            $timestamp
        );
    }

    /**
     * Escape XML content.
     */
    private function xmlEscape(
        string $value
    ): string {
        return htmlspecialchars(
            $value,
            ENT_XML1 | ENT_QUOTES,
            'UTF-8'
        );
    }
}
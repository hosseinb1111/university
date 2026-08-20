<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Models\Announcement;
use App\Models\Faculty;
use App\Models\ResearchCenter;
use App\Models\Document;
use App\Models\HomepageSlide;
use App\Models\Navigation;

final class HomeController
{
    /**
     * Display homepage.
     */
    public function index(): void
    {
        $slides = [];

        $quickLinks = [];

        $announcements = [];

        $faculties = [];

        $researchCenters = [];

        $documents = [];


        try {
            $slides =
                $this->safeCall(
                    function (): array {
                        return HomepageSlide::latest(10);
                    }
                );


            $quickLinks =
                $this->safeCall(
                    function (): array {
                        return Navigation::quickLinks(10);
                    }
                );


            $announcements =
                $this->safeCall(
                    function (): array {
                        return Announcement::latest(10);
                    }
                );


            $faculties =
                $this->safeCall(
                    function (): array {
                        return Faculty::latest(10);
                    }
                );


            $researchCenters =
                $this->safeCall(
                    function (): array {
                        return ResearchCenter::latest(10);
                    }
                );


            $documents =
                $this->safeCall(
                    function (): array {
                        return Document::latest(10);
                    }
                );


        } catch (\Throwable $e) {

            error_log(
                'Homepage loading error: '
                . $e->getMessage()
            );
        }



        echo View::renderIntoLayout(
            'layouts/app',
            'home/index',
            [
                'slides' =>
                    $slides,

                'quickLinks' =>
                    $quickLinks,

                'announcements' =>
                    $announcements,

                'faculties' =>
                    $faculties,

                'researchCenters' =>
                    $researchCenters,

                'documents' =>
                    $documents,
            ]
        );
    }



    /**
     * Safely call optional homepage sections.
     */
    private function safeCall(
        callable $callback
    ): array {

        try {

            $result =
                $callback();


            return is_array($result)
                ? $result
                : [];


        } catch (\Throwable $e) {

            error_log(
                'Homepage section failed: '
                . $e->getMessage()
            );


            return [];
        }
    }
}
<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Models\Announcement;
use App\Models\Faculty;
use App\Models\People;
use App\Models\ResearchCenter;

final class EnglishController
{
    /**
     * English homepage.
     */
    public function index(): string
    {
        return View::renderIntoLayout(
            'layouts/english',
            'english/index',
            [
                'title' =>
                    'Sadra Institute of Higher Education',

                'description' =>
                    'Official website of Sadra Institute of Higher Education, Tehran.',

                'announcements' =>
                    Announcement::latestPublished(5),

                'faculties' =>
                    Faculty::active(),

                'researchCenters' =>
                    ResearchCenter::active(),
            ]
        );
    }

    /**
     * English about page.
     */
    public function about(): string
    {
        return View::renderIntoLayout(
            'layouts/english',
            'english/about',
            [
                'title' =>
                    'About Sadra Institute',

                'description' =>
                    'About Sadra Institute of Higher Education.',
            ]
        );
    }

    /**
     * English presidency page.
     */
    public function presidency(): string
    {
        $president = null;

        foreach (
            People::all(true)
            as $person
        ) {
            if (
                str_contains(
                    (string) (
                        $person['position']
                        ?? ''
                    ),
                    'رئیس موسسه'
                )
                || str_contains(
                    strtolower(
                        (string) (
                            $person['position']
                            ?? ''
                        )
                    ),
                    'president'
                )
            ) {
                $president = $person;

                break;
            }
        }

        return View::renderIntoLayout(
            'layouts/english',
            'english/presidency',
            [
                'title' =>
                    'Presidency | Sadra Institute',

                'description' =>
                    'Presidency of Sadra Institute of Higher Education.',

                'president' =>
                    $president,
            ]
        );
    }

    /**
     * English faculties page.
     */
    public function faculties(): string
    {
        return View::renderIntoLayout(
            'layouts/english',
            'english/faculties',
            [
                'title' =>
                    'Faculties | Sadra Institute',

                'description' =>
                    'Faculties and academic programs at Sadra Institute.',

                'faculties' =>
                    Faculty::active(),
            ]
        );
    }

    /**
     * English research page.
     */
    public function research(): string
    {
        return View::renderIntoLayout(
            'layouts/english',
            'english/research',
            [
                'title' =>
                    'Research | Sadra Institute',

                'description' =>
                    'Research centers and activities at Sadra Institute.',

                'researchCenters' =>
                    ResearchCenter::active(),
            ]
        );
    }

    /**
     * English announcements.
     */
    public function announcements(): string
    {
        return View::renderIntoLayout(
            'layouts/english',
            'english/announcements',
            [
                'title' =>
                    'Announcements | Sadra Institute',

                'description' =>
                    'Latest announcements from Sadra Institute.',

                'announcements' =>
                    Announcement::latest(20),
            ]
        );
    }

    /**
     * English contact page.
     */
    public function contact(): string
    {
        return View::renderIntoLayout(
            'layouts/english',
            'english/contact',
            [
                'title' =>
                    'Contact Us | Sadra Institute',

                'description' =>
                    'Contact information for Sadra Institute of Higher Education.',

                'contact' => [
                    'email' =>
                        config(
                            'app.contact.email',
                            'info@sadra.ac.ir'
                        ),

                    'phone' =>
                        config(
                            'app.contact.phone',
                            ''
                        ),

                    'fax' =>
                        config(
                            'app.contact.fax',
                            ''
                        ),

                    'address' =>
                        config(
                            'app.contact.address',
                            'Tehran, Iran'
                        ),
                ],
            ]
        );
    }
}
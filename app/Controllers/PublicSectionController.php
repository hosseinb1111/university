<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Models\People;

final class PublicSectionController
{
    /**
     * About the institution.
     */
    public function about(): string
    {
        return View::renderIntoLayout(
            'layouts/app',
            'sections/about',
            [
                'title' =>
                    'درباره موسسه | صدرا',

                'description' =>
                    'معرفی موسسه آموزش عالی صدرالمتالهین (صدرا).',

                'section' => [
                    'eyebrow' =>
                        'درباره موسسه',

                    'title' =>
                        'موسسه آموزش عالی صدرالمتالهین',

                    'intro' =>
                        'موسسه آموزش عالی صدرالمتالهین (صدرا) در تهران فعالیت می‌کند و در حوزه آموزش عالی، فعالیت‌های آموزشی و پژوهشی ارائه می‌دهد.',
                ],
            ]
        );
    }

    /**
     * Presidency.
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
            ) {
                $president = $person;
                break;
            }
        }

        return View::renderIntoLayout(
            'layouts/app',
            'sections/presidency',
            [
                'title' =>
                    'ریاست موسسه | صدرا',

                'description' =>
                    'اطلاعات ریاست موسسه آموزش عالی صدرالمتالهین.',

                'president' =>
                    $president,
            ]
        );
    }

    /**
     * Education and research.
     */
    public function education(): string
    {
        return View::renderIntoLayout(
            'layouts/app',
            'sections/education',
            [
                'title' =>
                    'آموزشی و پژوهشی | صدرا',

                'description' =>
                    'اطلاعات آموزشی، دانشکده‌ها، رشته‌ها و فعالیت‌های پژوهشی موسسه.',

                'faculties' =>
                    \App\Models\Faculty::active(),

                'researchCenters' =>
                    \App\Models\ResearchCenter::active(),
            ]
        );
    }

    /**
     * Student and cultural affairs.
     */
    public function studentAffairs(): string
    {
        return View::renderIntoLayout(
            'layouts/app',
            'sections/student-affairs',
            [
                'title' =>
                    'دانشجویی و فرهنگی | صدرا',

                'description' =>
                    'خدمات دانشجویی، فرهنگی و امور مرتبط با دانشجویان موسسه.',
            ]
        );
    }

    /**
     * Support and infrastructure.
     */
    public function support(): string
    {
        return View::renderIntoLayout(
            'layouts/app',
            'sections/support',
            [
                'title' =>
                    'پشتیبانی و عمرانی | صدرا',

                'description' =>
                    'اطلاعات بخش‌های پشتیبانی، اداری و عمرانی موسسه.',
            ]
        );
    }

    /**
     * Contact page.
     */
    public function contact(): string
    {
        return View::renderIntoLayout(
            'layouts/app',
            'sections/contact',
            [
                'title' =>
                    'تماس با ما | صدرا',

                'description' =>
                    'اطلاعات تماس موسسه آموزش عالی صدرالمتالهین.',

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
                            'تهران، ایران'
                        ),
                ],
            ]
        );
    }
}
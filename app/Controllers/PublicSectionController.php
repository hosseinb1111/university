<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Models\Faculty;
use App\Models\People;
use App\Models\ResearchCenter;
use App\Models\SiteSetting;

final class PublicSectionController
{
    /**
     * About the institution.
     */
    public function about(): string
    {
        $about = [
            'eyebrow' =>
                (string) SiteSetting::get(
                    'about.eyebrow',
                    'معرفی موسسه'
                ),

            'title' =>
                (string) SiteSetting::get(
                    'about.title',
                    'موسسه آموزش عالی صدرالمتالهین'
                ),

            'intro' =>
                (string) SiteSetting::get(
                    'about.intro',
                    'موسسه آموزش عالی صدرالمتالهین (صدرا)، یک مجموعه آموزش عالی با تمرکز بر آموزش، توسعه علمی و فعالیت‌های پژوهشی است.'
                ),

            'card_eyebrow' =>
                (string) SiteSetting::get(
                    'about.card.eyebrow',
                    'درباره ما'
                ),

            'card_title' =>
                (string) SiteSetting::get(
                    'about.card.title',
                    'معرفی موسسه'
                ),

            'card_text_1' =>
                (string) SiteSetting::get(
                    'about.card.text_1',
                    'این بخش برای ارائه معرفی رسمی موسسه، تاریخچه، ساختار و اطلاعات عمومی آن طراحی شده است.'
                ),

            'card_text_2' =>
                (string) SiteSetting::get(
                    'about.card.text_2',
                    'محتوای رسمی و قابل ویرایش می‌تواند از طریق پنل مدیریت به این بخش متصل شود.'
                ),

            'goals_eyebrow' =>
                (string) SiteSetting::get(
                    'about.goals.eyebrow',
                    'اهداف'
                ),

            'goals_title' =>
                (string) SiteSetting::get(
                    'about.goals.title',
                    'اهداف و رویکرد'
                ),

            'goals_text' =>
                (string) SiteSetting::get(
                    'about.goals.text',
                    'توسعه آموزش عالی، تقویت فعالیت‌های علمی و پژوهشی و فراهم کردن محیط مناسب برای رشد دانشجویان و اعضای هیئت علمی.'
                ),

            'structure_eyebrow' =>
                (string) SiteSetting::get(
                    'about.structure.eyebrow',
                    'ساختار'
                ),

            'structure_title' =>
                (string) SiteSetting::get(
                    'about.structure.title',
                    'ساختار دانشگاهی'
                ),

            'structure_text' =>
                (string) SiteSetting::get(
                    'about.structure.text',
                    'ساختار موسسه شامل بخش‌های آموزشی، پژوهشی، دانشجویی، اداری و پشتیبانی است.'
                ),

            'more_eyebrow' =>
                (string) SiteSetting::get(
                    'about.more.eyebrow',
                    'اطلاعات بیشتر'
                ),

            'more_title' =>
                (string) SiteSetting::get(
                    'about.more.title',
                    'مسیرهای دسترسی'
                ),
        ];

        return View::renderIntoLayout(
            'layouts/app',
            'sections/about',
            [
                'title' =>
                    $about['title']
                    . ' | صدرا',

                'description' =>
                    $about['intro'],

                'section' =>
                    $about,
            ]
        );
    }


    /**
     * Presidency.
     *
     * The currently selected president is stored in
     * site_settings as:
     *
     * institution.president_person_id
     *
     * The full list of active people is also supplied
     * to the view so the presidency page can display
     * multiple institutional people.
     */
    public function presidency(): string
    {
        /*
        |--------------------------------------------------------------------------
        | All active people
        |--------------------------------------------------------------------------
        |
        | This is the important part for multiple people.
        | The old implementation only loaded one person.
        |
        */

        $people =
            People::active();


        /*
        |--------------------------------------------------------------------------
        | Currently designated president
        |--------------------------------------------------------------------------
        |
        | Keep the existing president setting because other
        | parts of the site/admin may still depend on it.
        |
        */

        $president =
            null;


        $presidentId =
            SiteSetting::get(
                'institution.president_person_id'
            );


        if (
            $presidentId !== null
            && $presidentId !== ''
        ) {
            $president =
                People::findActive(
                    (int) $presidentId
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Backward-compatible fallback
        |--------------------------------------------------------------------------
        |
        | If no president has explicitly been selected in
        | the admin panel, look through the active people
        | for a person whose position identifies them as
        | the president.
        |
        */

        if (
            $president === null
        ) {
            foreach (
                $people as $person
            ) {
                $position =
                    trim(
                        (string) (
                            $person['position']
                            ?? ''
                        )
                    );


                if (
                    $this->isPresidentPosition(
                        $position
                    )
                ) {
                    $president =
                        $person;

                    break;
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Render
        |--------------------------------------------------------------------------
        |
        | Both variables are passed:
        |
        | $president
        |     The specifically designated president.
        |
        | $people
        |     Every active person, allowing the view to
        |     render multiple people.
        |
        */

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

                'people' =>
                    $people,
            ]
        );
    }


    /**
     * Determine whether a position identifies the president.
     */
    private function isPresidentPosition(
        string $position
    ): bool {
        if (
            $position === ''
        ) {
            return false;
        }


        $normalized =
            trim(
                $position
            );


        $titles = [
            'رئیس موسسه',
            'رئیس مؤسسه',
            'رییس موسسه',
            'رییس مؤسسه',
            'رئیس دانشگاه',
            'رییس دانشگاه',
            'رئیس',
            'رییس',
        ];


        foreach (
            $titles as $title
        ) {
            if (
                str_contains(
                    $normalized,
                    $title
                )
            ) {
                return true;
            }
        }


        return false;
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
                    Faculty::active(),

                'researchCenters' =>
                    ResearchCenter::active(),
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
        $contact = [
            'eyebrow' =>
                (string) SiteSetting::get(
                    'contact.eyebrow',
                    'ارتباط با موسسه'
                ),

            'title' =>
                (string) SiteSetting::get(
                    'contact.title',
                    'تماس با ما'
                ),

            'description' =>
                (string) SiteSetting::get(
                    'contact.description',
                    'اطلاعات رسمی تماس موسسه آموزش عالی صدرالمتالهین.'
                ),

            'email' =>
                (string) SiteSetting::get(
                    'contact.email',
                    'info@sadra.ac.ir'
                ),

            'phone' =>
                (string) SiteSetting::get(
                    'contact.phone',
                    ''
                ),

            'fax' =>
                (string) SiteSetting::get(
                    'contact.fax',
                    ''
                ),

            'address' =>
                (string) SiteSetting::get(
                    'contact.address',
                    'استان تهران، تهران، منطقه ۲۲، بزرگراه شهید خرازی، خروجی بلوار کاشان جنوب، میدان موج، بلوار علامه قزوینی، نبش، Iran'
                ),

            'map_eyebrow' =>
                (string) SiteSetting::get(
                    'contact.map.eyebrow',
                    'موقعیت موسسه'
                ),

            'map_title' =>
                (string) SiteSetting::get(
                    'contact.map.title',
                    'تهران، ایران'
                ),

            'map_description' =>
                (string) SiteSetting::get(
                    'contact.map.description',
                    'برای مشاهده موقعیت موسسه روی نقشه، از نقشه زیر استفاده کنید.'
                ),

            'map_embed' =>
                (string) SiteSetting::get(
                    'contact.map.embed',
                    ''
                ),
        ];


        return View::renderIntoLayout(
            'layouts/app',
            'sections/contact',
            [
                'title' =>
                    $contact['title']
                    . ' | صدرا',

                'description' =>
                    $contact['description'],

                'contact' =>
                    $contact,
            ]
        );
    }
}
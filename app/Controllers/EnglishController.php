<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Models\EnglishAnnouncement;
use App\Models\EnglishFaculty;
use App\Models\EnglishHomepageService;
use App\Models\EnglishHomepageSlide;
use App\Models\EnglishPeople;
use App\Models\EnglishProgram;
use App\Models\EnglishResearchCenter;
use App\Models\SiteSetting;

final class EnglishController
{
    /*
    |--------------------------------------------------------------------------
    | ENGLISH HOMEPAGE
    |--------------------------------------------------------------------------
    */

    /**
     * English homepage.
     */
    public function index(): string
    {
        /*
        |--------------------------------------------------------------------------
        | English homepage slides
        |--------------------------------------------------------------------------
        */

        $slides =
            $this->safeCall(
                static function (): array {
                    return EnglishHomepageSlide::latest(
                        10
                    );
                }
            );


        /*
        |--------------------------------------------------------------------------
        | English slider settings
        |--------------------------------------------------------------------------
        */

        $sliderSettings = [
            'autoplay' =>
                $this->getBoolSetting(
                    'english.slider.autoplay',
                    true
                ),

            'interval' =>
                max(
                    2000,
                    min(
                        30000,
                        $this->getIntSetting(
                            'english.slider.interval',
                            5000
                        )
                    )
                ),

            'show_arrows' =>
                $this->getBoolSetting(
                    'english.slider.show_arrows',
                    true
                ),

            'show_dots' =>
                $this->getBoolSetting(
                    'english.slider.show_dots',
                    true
                ),

            'background_mode' =>
                $this->validatedSetting(
                    'english.slider.background_mode',
                    [
                        'blur',
                        'dominant',
                        'solid',
                        'gradient',
                        'none',
                    ],
                    'blur'
                ),

            'background_color' =>
                $this->validatedColor(
                    SiteSetting::get(
                        'english.slider.background_color',
                        '#111827'
                    ),
                    '#111827'
                ),

            'gradient' =>
                $this->validatedSetting(
                    'english.slider.gradient',
                    [
                        'dark',
                        'ocean',
                        'purple',
                        'sunset',
                        'light',
                    ],
                    'dark'
                ),

            'image_fit' =>
                $this->validatedSetting(
                    'english.slider.image_fit',
                    [
                        'contain',
                        'cover',
                        'fill',
                    ],
                    'contain'
                ),

            'image_position' =>
                $this->validatedSetting(
                    'english.slider.image_position',
                    [
                        'center center',
                        'center top',
                        'center bottom',
                        'left center',
                        'right center',
                        'left top',
                        'right top',
                        'left bottom',
                        'right bottom',
                    ],
                    'center center'
                ),
        ];


        /*
        |--------------------------------------------------------------------------
        | Homepage hero fallback text
        |--------------------------------------------------------------------------
        */

        $heroEyebrow =
            $this->getSetting(
                'english.home.hero.eyebrow',
                'Sadra Institute of Higher Education'
            );


        $heroTitle =
            $this->getSetting(
                'english.home.hero.title',
                'Education, Research, and Innovation'
            );


        $heroDescription =
            $this->getSetting(
                'english.home.hero.description',
                'A higher education environment dedicated to academic excellence, research, innovation, and professional development.'
            );


        /*
        |--------------------------------------------------------------------------
        | Homepage quick access
        |--------------------------------------------------------------------------
        */

        $quickLinksEyebrow =
            $this->getSetting(
                'english.home.quick_links.eyebrow',
                'Quick Access'
            );


        $quickLinksTitle =
            $this->getSetting(
                'english.home.quick_links.title',
                'Services & Portals'
            );


        $quickLinksDescription =
            $this->getSetting(
                'english.home.quick_links.description',
                'Quick access to important services, portals, and resources.'
            );


        /*
        |--------------------------------------------------------------------------
        | English homepage services
        |--------------------------------------------------------------------------
        */

        $services =
            $this->safeCall(
                static function (): array {
                    return EnglishHomepageService::latest(
                        12
                    );
                }
            );


        /*
        |--------------------------------------------------------------------------
        | English homepage announcements
        |--------------------------------------------------------------------------
        */

        $announcements =
            $this->safeCall(
                static function (): array {
                    return EnglishAnnouncement::latestPublished(
                        6
                    );
                }
            );


        /*
        |--------------------------------------------------------------------------
        | English homepage faculties
        |--------------------------------------------------------------------------
        */

        $faculties =
            $this->safeCall(
                static function (): array {
                    return EnglishFaculty::active();
                }
            );


        /*
        |--------------------------------------------------------------------------
        | English homepage research centers
        |--------------------------------------------------------------------------
        */

        $researchCenters =
            $this->safeCall(
                static function (): array {
                    return EnglishResearchCenter::active();
                }
            );


        /*
        |--------------------------------------------------------------------------
        | English homepage people
        |--------------------------------------------------------------------------
        */

        $people =
            $this->safeCall(
                static function (): array {
                    return EnglishPeople::active();
                }
            );


        /*
        |--------------------------------------------------------------------------
        | Homepage section settings
        |--------------------------------------------------------------------------
        */

        $announcementsEyebrow =
            $this->getSetting(
                'english.home.announcements.eyebrow',
                'Latest News'
            );


        $announcementsTitle =
            $this->getSetting(
                'english.home.announcements.title',
                'Latest Announcements'
            );


        $facultiesEyebrow =
            $this->getSetting(
                'english.home.faculties.eyebrow',
                'Academics'
            );


        $facultiesTitle =
            $this->getSetting(
                'english.home.faculties.title',
                'Faculties'
            );


        $researchEyebrow =
            $this->getSetting(
                'english.home.research.eyebrow',
                'Research'
            );


        $researchTitle =
            $this->getSetting(
                'english.home.research.title',
                'Research Centers'
            );


        $aboutEyebrow =
            $this->getSetting(
                'english.home.about.eyebrow',
                'About Sadra'
            );


        $aboutTitle =
            $this->getSetting(
                'english.home.about.title',
                'A place for learning and discovery'
            );


        $aboutDescription =
            $this->getSetting(
                'english.home.about.description',
                'Sadra Institute of Higher Education provides an academic environment focused on education, research, innovation, and preparing students for professional careers.'
            );


        $contactEyebrow =
            $this->getSetting(
                'english.home.contact.eyebrow',
                'Get in touch'
            );


        $contactTitle =
            $this->getSetting(
                'english.home.contact.title',
                'We are here to help.'
            );


        $contactDescription =
            $this->getSetting(
                'english.home.contact.description',
                'For more information about Sadra Institute, academic programs, admissions, and services, contact us.'
            );


        $contactButton =
            $this->getSetting(
                'english.home.contact.button',
                'Contact Us'
            );


        /*
        |--------------------------------------------------------------------------
        | Render
        |--------------------------------------------------------------------------
        */

        return View::renderIntoLayout(
            'layouts/english',
            'english/index',
            [
                'title' =>
                    'Sadra Institute of Higher Education',

                'description' =>
                    'Official website of Sadra Institute of Higher Education, Tehran, Iran.',

                'slides' =>
                    $slides,

                'services' =>
                    $services,

                'sliderSettings' =>
                    $sliderSettings,

                'announcements' =>
                    $announcements,

                'faculties' =>
                    $faculties,

                'researchCenters' =>
                    $researchCenters,

                'people' =>
                    $people,

                'heroEyebrow' =>
                    $heroEyebrow,

                'heroTitle' =>
                    $heroTitle,

                'heroDescription' =>
                    $heroDescription,

                'quickLinksEyebrow' =>
                    $quickLinksEyebrow,

                'quickLinksTitle' =>
                    $quickLinksTitle,

                'quickLinksDescription' =>
                    $quickLinksDescription,

                'announcementsEyebrow' =>
                    $announcementsEyebrow,

                'announcementsTitle' =>
                    $announcementsTitle,

                'facultiesEyebrow' =>
                    $facultiesEyebrow,

                'facultiesTitle' =>
                    $facultiesTitle,

                'researchEyebrow' =>
                    $researchEyebrow,

                'researchTitle' =>
                    $researchTitle,

                'aboutEyebrow' =>
                    $aboutEyebrow,

                'aboutTitle' =>
                    $aboutTitle,

                'aboutDescription' =>
                    $aboutDescription,

                'contactEyebrow' =>
                    $contactEyebrow,

                'contactTitle' =>
                    $contactTitle,

                'contactDescription' =>
                    $contactDescription,

                'contactButton' =>
                    $contactButton,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ENGLISH ABOUT
    |--------------------------------------------------------------------------
    */

    /**
     * English about page.
     */
    public function about(): string
    {
        $eyebrow =
            $this->getSetting(
                'english.pages.about.eyebrow',
                'About'
            );


        $title =
            $this->getSetting(
                'english.pages.about.title',
                'Sadra Institute of Higher Education'
            );


        $description =
            $this->getSetting(
                'english.pages.about.description',
                'Sadra Institute of Higher Education is a higher education institution based in Tehran, Iran.'
            );


        return View::renderIntoLayout(
            'layouts/english',
            'english/about',
            [
                'title' =>
                    $title
                    . ' | Sadra Institute',

                'description' =>
                    $this->seoDescription(
                        $description
                    ),

                'eyebrow' =>
                    $eyebrow,

                'pageTitle' =>
                    $title,

                'pageDescription' =>
                    $description,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ENGLISH PRESIDENCY
    |--------------------------------------------------------------------------
    */

    /**
     * English presidency page.
     */
    public function presidency(): string
    {
        $president =
            null;


        $people =
            $this->safeCall(
                static function (): array {
                    return EnglishPeople::active();
                }
            );


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


        $eyebrow =
            $this->getSetting(
                'english.pages.presidency.eyebrow',
                'Leadership'
            );


        $title =
            $this->getSetting(
                'english.pages.presidency.title',
                'Office of the President'
            );


        $description =
            $this->getSetting(
                'english.pages.presidency.description',
                'Information about the leadership of Sadra Institute of Higher Education.'
            );


        return View::renderIntoLayout(
            'layouts/english',
            'english/presidency',
            [
                'title' =>
                    $title
                    . ' | Sadra Institute',

                'description' =>
                    $this->seoDescription(
                        $description
                    ),

                'eyebrow' =>
                    $eyebrow,

                'pageTitle' =>
                    $title,

                'pageDescription' =>
                    $description,

                'president' =>
                    $president,

                'people' =>
                    $people,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ENGLISH FACULTIES
    |--------------------------------------------------------------------------
    */

    /**
     * English faculties listing page.
     */
    public function faculties(): string
    {
        $faculties =
            $this->safeCall(
                static function (): array {
                    return EnglishFaculty::active();
                }
            );


        $eyebrow =
            $this->getSetting(
                'english.pages.faculties.eyebrow',
                'Academics'
            );


        $title =
            $this->getSetting(
                'english.pages.faculties.title',
                'Faculties'
            );


        $description =
            $this->getSetting(
                'english.pages.faculties.description',
                'Explore the academic faculties and educational structure of Sadra Institute.'
            );


        return View::renderIntoLayout(
            'layouts/english',
            'english/faculties',
            [
                'title' =>
                    $title
                    . ' | Sadra Institute',

                'description' =>
                    $this->seoDescription(
                        $description
                    ),

                'eyebrow' =>
                    $eyebrow,

                'pageTitle' =>
                    $title,

                'pageDescription' =>
                    $description,

                'faculties' =>
                    $faculties,
            ]
        );
    }


    /**
     * English faculty detail page.
     */
    public function faculty(
        string $slug
    ): string {
        $slug =
            trim(
                $slug
            );


        if (
            $slug === ''
        ) {
            return $this->englishNotFound(
                'The requested faculty could not be found.'
            );
        }


        $faculty =
            EnglishFaculty::findActiveBySlug(
                $slug
            );


        if (
            $faculty === null
        ) {
            return $this->englishNotFound(
                'The faculty you are looking for does not exist or is no longer available.'
            );
        }


        $facultyName =
            trim(
                (string) (
                    $faculty['name']
                    ?? ''
                )
            );


        if (
            $facultyName === ''
        ) {
            $facultyName =
                'Faculty';
        }


        $facultyDescription =
            trim(
                (string) (
                    $faculty['description']
                    ?? ''
                )
            );


        if (
            $facultyDescription === ''
        ) {
            $facultyDescription =
                'Faculty information at Sadra Institute of Higher Education.';
        }


        return View::renderIntoLayout(
            'layouts/english',
            'english/faculty',
            [
                'title' =>
                    $facultyName
                    . ' | Sadra Institute',

                'description' =>
                    $this->seoDescription(
                        $facultyDescription
                    ),

                'faculty' =>
                    $faculty,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ENGLISH PROGRAMS
    |--------------------------------------------------------------------------
    */

    /**
     * English programs listing page.
     */
    public function programs(): string
    {
        $faculties =
            $this->safeCall(
                static function (): array {
                    return EnglishFaculty::active();
                }
            );


        $programs =
            $this->safeCall(
                static function (): array {
                    return EnglishProgram::active();
                }
            );


        $eyebrow =
            $this->getSetting(
                'english.pages.programs.eyebrow',
                'Academics'
            );


        $title =
            $this->getSetting(
                'english.pages.programs.title',
                'Academic Programs'
            );


        $description =
            $this->getSetting(
                'english.pages.programs.description',
                'Explore the academic programs and fields of study offered by Sadra Institute of Higher Education.'
            );


        return View::renderIntoLayout(
            'layouts/english',
            'english/programs/index',
            [
                'title' =>
                    $title
                    . ' | Sadra Institute',

                'description' =>
                    $this->seoDescription(
                        $description
                    ),

                'eyebrow' =>
                    $eyebrow,

                'pageTitle' =>
                    $title,

                'pageDescription' =>
                    $description,

                'faculties' =>
                    $faculties,

                'programs' =>
                    $programs,
            ]
        );
    }


    /**
     * English program detail page.
     */
    public function program(
        string $slug
    ): string {
        $slug =
            trim(
                $slug
            );


        if (
            $slug === ''
        ) {
            return $this->englishNotFound(
                'The requested academic program could not be found.'
            );
        }


        $program =
            EnglishProgram::findPublishedBySlug(
                $slug
            );


        if (
            $program === null
        ) {
            return $this->englishNotFound(
                'The academic program you are looking for does not exist or is no longer available.'
            );
        }


        $programName =
            trim(
                (string) (
                    $program['name']
                    ?? ''
                )
            );


        if (
            $programName === ''
        ) {
            $programName =
                'Academic Program';
        }


        $description =
            trim(
                (string) (
                    $program['description']
                    ?? ''
                )
            );


        if (
            $description === ''
        ) {
            $description =
                'Academic program information at Sadra Institute of Higher Education.';
        }


        return View::renderIntoLayout(
            'layouts/english',
            'english/programs/show',
            [
                'title' =>
                    $programName
                    . ' | Sadra Institute',

                'description' =>
                    $this->seoDescription(
                        $description
                    ),

                'program' =>
                    $program,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ENGLISH RESEARCH
    |--------------------------------------------------------------------------
    */

    /**
     * English research page.
     */
    public function research(): string
    {
        $researchCenters =
            $this->safeCall(
                static function (): array {
                    return EnglishResearchCenter::active();
                }
            );


        $eyebrow =
            $this->getSetting(
                'english.pages.research.eyebrow',
                'Research'
            );


        $title =
            $this->getSetting(
                'english.pages.research.title',
                'Research Centers'
            );


        $description =
            $this->getSetting(
                'english.pages.research.description',
                'Research centers and scientific activities at Sadra Institute.'
            );


        return View::renderIntoLayout(
            'layouts/english',
            'english/research',
            [
                'title' =>
                    $title
                    . ' | Sadra Institute',

                'description' =>
                    $this->seoDescription(
                        $description
                    ),

                'eyebrow' =>
                    $eyebrow,

                'pageTitle' =>
                    $title,

                'pageDescription' =>
                    $description,

                'researchCenters' =>
                    $researchCenters,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ENGLISH ANNOUNCEMENTS
    |--------------------------------------------------------------------------
    */

    /**
     * English announcements listing page.
     */
    public function announcements(): string
    {
        $announcements =
            $this->safeCall(
                static function (): array {
                    return EnglishAnnouncement::latestPublished(
                        20
                    );
                }
            );


        $eyebrow =
            $this->getSetting(
                'english.pages.announcements.eyebrow',
                'News'
            );


        $title =
            $this->getSetting(
                'english.pages.announcements.title',
                'Announcements'
            );


        $description =
            $this->getSetting(
                'english.pages.announcements.description',
                'The latest official announcements from Sadra Institute.'
            );


        return View::renderIntoLayout(
            'layouts/english',
            'english/announcements',
            [
                'title' =>
                    $title
                    . ' | Sadra Institute',

                'description' =>
                    $this->seoDescription(
                        $description
                    ),

                'eyebrow' =>
                    $eyebrow,

                'pageTitle' =>
                    $title,

                'pageDescription' =>
                    $description,

                'announcements' =>
                    $announcements,
            ]
        );
    }


    /**
     * English announcement detail page.
     */
    public function announcement(
        string $slug
    ): string {
        $slug =
            trim(
                $slug
            );


        if (
            $slug === ''
        ) {
            return $this->englishNotFound(
                'The requested announcement could not be found.'
            );
        }


        $announcement =
            EnglishAnnouncement::findPublishedBySlug(
                $slug
            );


        if (
            $announcement === null
        ) {
            return $this->englishNotFound(
                'The announcement you are looking for does not exist or is no longer available.'
            );
        }


        $announcementTitle =
            trim(
                (string) (
                    $announcement['title']
                    ?? ''
                )
            );


        if (
            $announcementTitle === ''
        ) {
            $announcementTitle =
                'Announcement';
        }


        $excerpt =
            trim(
                (string) (
                    $announcement['excerpt']
                    ?? ''
                )
            );


        $description =
            $excerpt !== ''
                ? mb_strimwidth(
                    $excerpt,
                    0,
                    180,
                    '...',
                    'UTF-8'
                )
                : 'Official announcement from Sadra Institute of Higher Education.';


        return View::renderIntoLayout(
            'layouts/english',
            'english/announcements/show',
            [
                'title' =>
                    $announcementTitle
                    . ' | Sadra Institute',

                'description' =>
                    $description,

                'announcement' =>
                    $announcement,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ENGLISH CONTACT
    |--------------------------------------------------------------------------
    */

    /**
     * English contact page.
     *
     * Every contact value is read from the English
     * contact settings in SiteSetting.
     *
     * The Google Maps setting contains ONLY the iframe
     * src URL, never a complete iframe element.
     */
    public function contact(): string
    {
        /*
        |--------------------------------------------------------------------------
        | Page content
        |--------------------------------------------------------------------------
        */

        $eyebrow =
            $this->getSetting(
                'english.pages.contact.eyebrow',
                'Contact'
            );


        $title =
            $this->getSetting(
                'english.pages.contact.title',
                'Contact Us'
            );


        $description =
            $this->getSetting(
                'english.pages.contact.description',
                'Contact information for Sadra Institute of Higher Education.'
            );


        /*
        |--------------------------------------------------------------------------
        | Email
        |--------------------------------------------------------------------------
        */

        $email =
            $this->getSetting(
                'english.pages.contact.email',
                'info@sadra.ac.ir'
            );


        /*
        |--------------------------------------------------------------------------
        | Phone
        |--------------------------------------------------------------------------
        */

        $phone =
            $this->getSetting(
                'english.pages.contact.phone',
                ''
            );


        /*
        |--------------------------------------------------------------------------
        | Fax
        |--------------------------------------------------------------------------
        */

        $fax =
            $this->getSetting(
                'english.pages.contact.fax',
                ''
            );


        /*
        |--------------------------------------------------------------------------
        | Address
        |--------------------------------------------------------------------------
        */

        $address =
            $this->getSetting(
                'english.pages.contact.address',
                'Tehran, Iran'
            );


        /*
        |--------------------------------------------------------------------------
        | Google Maps Embed URL
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        |
        | This is the URL used as:
        |
        | <iframe src="...">
        |
        | The CMS should therefore contain something like:
        |
        | https://www.google.com/maps/embed?pb=...
        |
        | It should NOT contain:
        |
        | <iframe ...></iframe>
        |
        */

        $mapEmbedUrl =
            $this->getSetting(
                'english.pages.contact.map_embed_url',
                ''
            );


        /*
        |--------------------------------------------------------------------------
        | Render
        |--------------------------------------------------------------------------
        */

        return View::renderIntoLayout(
            'layouts/english',
            'english/contact',
            [
                'title' =>
                    $title
                    . ' | Sadra Institute',

                'description' =>
                    $this->seoDescription(
                        $description
                    ),

                'eyebrow' =>
                    $eyebrow,

                'pageTitle' =>
                    $title,

                'pageDescription' =>
                    $description,

                'contact' => [
                    'email' =>
                        $email,

                    'phone' =>
                        $phone,

                    'fax' =>
                        $fax,

                    'address' =>
                        $address,

                    'map_embed_url' =>
                        $mapEmbedUrl,
                ],
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ENGLISH 404
    |--------------------------------------------------------------------------
    */

    /**
     * Render a 404 page inside the English layout.
     */
    private function englishNotFound(
        string $message =
            'The page you are looking for could not be found.'
    ): string {
        http_response_code(
            404
        );


        return View::renderIntoLayout(
            'layouts/english',
            'english/404',
            [
                'title' =>
                    'Page Not Found | Sadra Institute',

                'description' =>
                    'The requested page could not be found.',

                'message' =>
                    $message,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PRESIDENT HELPER
    |--------------------------------------------------------------------------
    */

    /**
     * Determine whether a position identifies the institute president.
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
            mb_strtolower(
                trim(
                    $position
                ),
                'UTF-8'
            );


        $englishTitles = [
            'president',
            'institute president',
            'university president',
            'chancellor',
            'university chancellor',
            'institute chancellor',
        ];


        foreach (
            $englishTitles as $title
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


        /*
        |--------------------------------------------------------------------------
        | Legacy Persian positions
        |--------------------------------------------------------------------------
        */

        $persianTitles = [
            'رئیس موسسه',
            'رئیس مؤسسه',
            'رییس موسسه',
            'رییس مؤسسه',
            'رئیس دانشگاه',
            'رییس دانشگاه',
        ];


        foreach (
            $persianTitles as $title
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


    /*
    |--------------------------------------------------------------------------
    | SETTINGS HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Get a string site setting safely.
     */
    private function getSetting(
        string $key,
        string $default
    ): string {
        try {
            $value =
                SiteSetting::get(
                    $key,
                    $default
                );
        } catch (
            \Throwable $exception
        ) {
            error_log(
                'English site setting read failed ['
                . $key
                . ']: '
                . $exception->getMessage()
            );


            return $default;
        }


        if (
            !is_scalar(
                $value
            )
        ) {
            return $default;
        }


        $value =
            trim(
                (string) $value
            );


        return $value !== ''
            ? $value
            : $default;
    }


    /**
     * Get a boolean site setting safely.
     */
    private function getBoolSetting(
        string $key,
        bool $default
    ): bool {
        try {
            $value =
                SiteSetting::get(
                    $key,
                    $default
                );
        } catch (
            \Throwable $exception
        ) {
            error_log(
                'English boolean setting read failed ['
                . $key
                . ']: '
                . $exception->getMessage()
            );


            return $default;
        }


        if (
            is_bool(
                $value
            )
        ) {
            return $value;
        }


        if (
            is_int($value)
            || is_float($value)
        ) {
            return (int) $value === 1;
        }


        if (
            is_string(
                $value
            )
        ) {
            return in_array(
                strtolower(
                    trim(
                        $value
                    )
                ),
                [
                    '1',
                    'true',
                    'yes',
                    'on',
                ],
                true
            );
        }


        return $default;
    }


    /**
     * Get an integer site setting safely.
     */
    private function getIntSetting(
        string $key,
        int $default
    ): int {
        try {
            $value =
                SiteSetting::get(
                    $key,
                    $default
                );
        } catch (
            \Throwable $exception
        ) {
            error_log(
                'English integer setting read failed ['
                . $key
                . ']: '
                . $exception->getMessage()
            );


            return $default;
        }


        if (
            !is_numeric(
                $value
            )
        ) {
            return $default;
        }


        return (int) $value;
    }


    /**
     * Validate a setting against allowed values.
     *
     * @param array<int, string> $allowed
     */
    private function validatedSetting(
        string $key,
        array $allowed,
        string $default
    ): string {
        try {
            $value =
                trim(
                    (string) SiteSetting::get(
                        $key,
                        $default
                    )
                );
        } catch (
            \Throwable $exception
        ) {
            error_log(
                'English validated setting read failed ['
                . $key
                . ']: '
                . $exception->getMessage()
            );


            return $default;
        }


        return in_array(
            $value,
            $allowed,
            true
        )
            ? $value
            : $default;
    }


    /**
     * Validate a hexadecimal color.
     */
    private function validatedColor(
        mixed $value,
        string $default
    ): string {
        $value =
            strtoupper(
                trim(
                    (string) $value
                )
            );


        return preg_match(
            '/^#[0-9A-F]{6}$/i',
            $value
        ) === 1
            ? $value
            : $default;
    }


    /**
     * Build a safe SEO description.
     */
    private function seoDescription(
        string $value
    ): string {
        $value =
            trim(
                $value
            );


        if (
            $value === ''
        ) {
            return 'Sadra Institute of Higher Education.';
        }


        return mb_strimwidth(
            $value,
            0,
            180,
            '...',
            'UTF-8'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SAFE CALL
    |--------------------------------------------------------------------------
    */

    /**
     * Safely execute an optional section.
     *
     * @param callable(): mixed $callback
     *
     * @return array<int|string, mixed>
     */
    private function safeCall(
        callable $callback
    ): array {
        try {
            $result =
                $callback();


            return is_array(
                $result
            )
                ? $result
                : [];
        } catch (
            \Throwable $e
        ) {
            error_log(
                'English section failed: '
                . $e->getMessage()
            );


            return [];
        }
    }
}
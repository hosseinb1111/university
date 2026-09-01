<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Models\Announcement;
use App\Models\Faculty;
use App\Models\HomepageService;
use App\Models\ResearchCenter;
use App\Models\Document;
use App\Models\HomepageSlide;
use App\Models\SiteSetting;

final class HomeController
{
    /**
     * Display homepage.
     */
    public function index(): void
    {
        $slides = [];

        $sliderSettings = [];

        $quickLinks = [];

        $announcements = [];

        $faculties = [];

        $researchCenters = [];

        $documents = [];


        /*
        |--------------------------------------------------------------------------
        | Homepage slides
        |--------------------------------------------------------------------------
        */

        $slides =
            $this->safeCall(
                function (): array {
                    return HomepageSlide::latest(
                        10
                    );
                }
            );


        /*
        |--------------------------------------------------------------------------
        | Homepage slider settings
        |--------------------------------------------------------------------------
        */

        $sliderSettings = [
            'autoplay' =>
                SiteSetting::getBool(
                    'homepage.slider.autoplay',
                    true
                ),

            'interval' =>
                max(
                    2000,
                    min(
                        30000,
                        SiteSetting::getInt(
                            'homepage.slider.interval',
                            5000
                        )
                    )
                ),

            'show_arrows' =>
                SiteSetting::getBool(
                    'homepage.slider.show_arrows',
                    true
                ),

            'show_dots' =>
                SiteSetting::getBool(
                    'homepage.slider.show_dots',
                    true
                ),

            'background_mode' =>
                $this->validatedSetting(
                    'homepage.slider.background_mode',
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
                        'homepage.slider.background_color',
                        '#111827'
                    ),
                    '#111827'
                ),

            'gradient' =>
                $this->validatedSetting(
                    'homepage.slider.gradient',
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
                    'homepage.slider.image_fit',
                    [
                        'contain',
                        'cover',
                        'fill',
                    ],
                    'contain'
                ),

            'image_position' =>
                $this->validatedSetting(
                    'homepage.slider.image_position',
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
        | Homepage services
        |--------------------------------------------------------------------------
        */

        $quickLinks =
            $this->safeCall(
                function (): array {
                    return HomepageService::latest(
                        20
                    );
                }
            );


        /*
        |--------------------------------------------------------------------------
        | Announcements
        |--------------------------------------------------------------------------
        */

        $announcements =
            $this->safeCall(
                function (): array {
                    return Announcement::latest(
                        10
                    );
                }
            );


        /*
        |--------------------------------------------------------------------------
        | Faculties
        |--------------------------------------------------------------------------
        */

        $faculties =
            $this->safeCall(
                function (): array {
                    return Faculty::active();
                }
            );


        /*
        |--------------------------------------------------------------------------
        | Research centers
        |--------------------------------------------------------------------------
        */

        $researchCenters =
            $this->safeCall(
                function (): array {
                    return ResearchCenter::active();
                }
            );


        /*
        |--------------------------------------------------------------------------
        | Documents
        |--------------------------------------------------------------------------
        */

        $documents =
            $this->safeCall(
                function (): array {
                    return Document::latest(
                        10
                    );
                }
            );


        /*
        |--------------------------------------------------------------------------
        | Render
        |--------------------------------------------------------------------------
        */

        echo View::renderIntoLayout(
            'layouts/app',
            'home/index',
            [
                'slides' =>
                    $slides,

                'sliderSettings' =>
                    $sliderSettings,

                'quickLinks' =>
                    $quickLinks,

                'quickLinksEyebrow' =>
                    (string) SiteSetting::get(
                        'homepage.quick_links.eyebrow',
                        'دسترسی سریع'
                    ),

                'quickLinksTitle' =>
                    (string) SiteSetting::get(
                        'homepage.quick_links.title',
                        'سامانه‌ها و خدمات'
                    ),

                'quickLinksDescription' =>
                    (string) SiteSetting::get(
                        'homepage.quick_links.description',
                        'دسترسی سریع به سامانه‌ها و خدمات مهم موسسه'
                    ),

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
     * Validate a string against a whitelist.
     */
    private function validatedSetting(
        string $key,
        array $allowed,
        string $default
    ): string {
        $value =
            trim(
                (string) SiteSetting::get(
                    $key,
                    $default
                )
            );

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
        )
            ? $value
            : $default;
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

        } catch (
            \Throwable $e
        ) {
            error_log(
                'Homepage section failed: '
                . $e->getMessage()
            );

            return [];
        }
    }
}
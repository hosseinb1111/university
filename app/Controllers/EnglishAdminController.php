<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\SiteSetting;
use RuntimeException;

final class EnglishAdminController
{
    /*
    |--------------------------------------------------------------------------
    | ENGLISH ADMIN DASHBOARD
    |--------------------------------------------------------------------------
    */

    /**
     * English website administration dashboard.
     */
    public function index(): string
    {
        return View::renderIntoLayout(
            'layouts/admin',
            'admin/english/index',
            [
                'title' =>
                    'مدیریت سایت انگلیسی | صدرا',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ENGLISH HOMEPAGE
    |--------------------------------------------------------------------------
    */

    /**
     * Display English homepage settings.
     */
    public function home(): string
    {
        $flashForm =
            Session::getFlash(
                'english_home_form'
            );


        $settings = [
            'hero_eyebrow' =>
                $this->getSetting(
                    'english.home.hero.eyebrow',
                    'Sadra Institute of Higher Education'
                ),

            'hero_title' =>
                $this->getSetting(
                    'english.home.hero.title',
                    'Education, Research, and Innovation'
                ),

            'hero_description' =>
                $this->getSetting(
                    'english.home.hero.description',
                    'A higher education environment dedicated to academic excellence, research, innovation, and professional development.'
                ),

            'quick_links_eyebrow' =>
                $this->getSetting(
                    'english.home.quick_links.eyebrow',
                    'Quick Access'
                ),

            'quick_links_title' =>
                $this->getSetting(
                    'english.home.quick_links.title',
                    'Services & Portals'
                ),

            'quick_links_description' =>
                $this->getSetting(
                    'english.home.quick_links.description',
                    'Quick access to important services, portals, and resources.'
                ),

            'announcements_eyebrow' =>
                $this->getSetting(
                    'english.home.announcements.eyebrow',
                    'Latest News'
                ),

            'announcements_title' =>
                $this->getSetting(
                    'english.home.announcements.title',
                    'Latest Announcements'
                ),

            'faculties_eyebrow' =>
                $this->getSetting(
                    'english.home.faculties.eyebrow',
                    'Academics'
                ),

            'faculties_title' =>
                $this->getSetting(
                    'english.home.faculties.title',
                    'Faculties'
                ),

            'research_eyebrow' =>
                $this->getSetting(
                    'english.home.research.eyebrow',
                    'Research'
                ),

            'research_title' =>
                $this->getSetting(
                    'english.home.research.title',
                    'Research Centers'
                ),

            'about_eyebrow' =>
                $this->getSetting(
                    'english.home.about.eyebrow',
                    'About Sadra'
                ),

            'about_title' =>
                $this->getSetting(
                    'english.home.about.title',
                    'A place for learning and discovery'
                ),

            'about_description' =>
                $this->getSetting(
                    'english.home.about.description',
                    'Sadra Institute of Higher Education provides an academic environment focused on education, research, innovation, and preparing students for professional careers.'
                ),

            'contact_eyebrow' =>
                $this->getSetting(
                    'english.home.contact.eyebrow',
                    'Get in touch'
                ),

            'contact_title' =>
                $this->getSetting(
                    'english.home.contact.title',
                    'We are here to help.'
                ),

            'contact_description' =>
                $this->getSetting(
                    'english.home.contact.description',
                    'For more information about Sadra Institute, academic programs, admissions, and services, contact us.'
                ),

            'contact_button' =>
                $this->getSetting(
                    'english.home.contact.button',
                    'Contact Us'
                ),
        ];


        /*
         * Restore exactly what the administrator entered
         * after failed validation.
         */
        if (
            is_array($flashForm)
        ) {
            foreach (
                $settings as $key => $currentValue
            ) {
                if (
                    array_key_exists(
                        $key,
                        $flashForm
                    )
                ) {
                    $settings[$key] =
                        is_string(
                            $flashForm[$key]
                        )
                            ? trim(
                                $flashForm[$key]
                            )
                            : $currentValue;
                }
            }
        }


        return View::renderIntoLayout(
            'layouts/admin',
            'admin/english/home',
            [
                'title' =>
                    'صفحه اصلی انگلیسی | صدرا',

                'settings' =>
                    $settings,

                'success' =>
                    Session::getFlash(
                        'success'
                    ),

                'error' =>
                    Session::getFlash(
                        'error'
                    ),
            ]
        );
    }


    /**
     * Save English homepage settings.
     */
    public function updateHome(): never
    {
        Csrf::requireValid();


        $fields = [
            'hero_eyebrow' =>
                [
                    'setting' =>
                        'english.home.hero.eyebrow',

                    'max' =>
                        255,
                ],

            'hero_title' =>
                [
                    'setting' =>
                        'english.home.hero.title',

                    'max' =>
                        255,
                ],

            'hero_description' =>
                [
                    'setting' =>
                        'english.home.hero.description',

                    'max' =>
                        5000,
                ],

            'quick_links_eyebrow' =>
                [
                    'setting' =>
                        'english.home.quick_links.eyebrow',

                    'max' =>
                        255,
                ],

            'quick_links_title' =>
                [
                    'setting' =>
                        'english.home.quick_links.title',

                    'max' =>
                        255,
                ],

            'quick_links_description' =>
                [
                    'setting' =>
                        'english.home.quick_links.description',

                    'max' =>
                        5000,
                ],

            'announcements_eyebrow' =>
                [
                    'setting' =>
                        'english.home.announcements.eyebrow',

                    'max' =>
                        255,
                ],

            'announcements_title' =>
                [
                    'setting' =>
                        'english.home.announcements.title',

                    'max' =>
                        255,
                ],

            'faculties_eyebrow' =>
                [
                    'setting' =>
                        'english.home.faculties.eyebrow',

                    'max' =>
                        255,
                ],

            'faculties_title' =>
                [
                    'setting' =>
                        'english.home.faculties.title',

                    'max' =>
                        255,
                ],

            'research_eyebrow' =>
                [
                    'setting' =>
                        'english.home.research.eyebrow',

                    'max' =>
                        255,
                ],

            'research_title' =>
                [
                    'setting' =>
                        'english.home.research.title',

                    'max' =>
                        255,
                ],

            'about_eyebrow' =>
                [
                    'setting' =>
                        'english.home.about.eyebrow',

                    'max' =>
                        255,
                ],

            'about_title' =>
                [
                    'setting' =>
                        'english.home.about.title',

                    'max' =>
                        255,
                ],

            'about_description' =>
                [
                    'setting' =>
                        'english.home.about.description',

                    'max' =>
                        5000,
                ],

            'contact_eyebrow' =>
                [
                    'setting' =>
                        'english.home.contact.eyebrow',

                    'max' =>
                        255,
                ],

            'contact_title' =>
                [
                    'setting' =>
                        'english.home.contact.title',

                    'max' =>
                        255,
                ],

            'contact_description' =>
                [
                    'setting' =>
                        'english.home.contact.description',

                    'max' =>
                        5000,
                ],

            'contact_button' =>
                [
                    'setting' =>
                        'english.home.contact.button',

                    'max' =>
                        255,
                ],
        ];


        $values = [];

        $errors = [];


        foreach (
            $fields as $inputName => $definition
        ) {
            $value =
                $this->postString(
                    $inputName
                );


            $values[$inputName] =
                $value;


            $max =
                (int) (
                    $definition['max']
                    ?? 255
                );


            if (
                mb_strlen(
                    $value,
                    'UTF-8'
                ) > $max
            ) {
                $errors[$inputName] =
                    'این مقدار بیشتر از حد مجاز است.';
            }
        }


        if (
            $errors !== []
        ) {
            Session::flash(
                'error',
                'لطفاً خطاهای فرم را برطرف کنید.'
            );


            Session::flash(
                'english_home_form',
                $values
            );


            Response::redirectRoute(
                'admin.english.home'
            );
        }


        try {
            foreach (
                $fields as $inputName => $definition
            ) {
                $this->saveSetting(
                    (string) $definition['setting'],
                    $values[$inputName]
                );
            }
        } catch (
            \Throwable $exception
        ) {
            error_log(
                'English homepage settings update failed: '
                . $exception->getMessage()
            );


            Session::flash(
                'error',
                'ذخیره تنظیمات صفحه اصلی انگلیسی انجام نشد.'
            );


            Session::flash(
                'english_home_form',
                $values
            );


            Response::redirectRoute(
                'admin.english.home'
            );
        }


        Session::flash(
            'success',
            'تنظیمات صفحه اصلی انگلیسی با موفقیت ذخیره شد.'
        );


        Response::redirectRoute(
            'admin.english.home'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ENGLISH SLIDER
    |--------------------------------------------------------------------------
    */

    /**
     * Display English slider settings.
     */
    public function slider(): string
    {
        $settings = [
            'autoplay' =>
                $this->getBoolSetting(
                    'english.slider.autoplay',
                    true
                ),

            'interval' =>
                $this->getIntSetting(
                    'english.slider.interval',
                    5000
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
                $this->getSetting(
                    'english.slider.background_mode',
                    'blur'
                ),

            'background_color' =>
                $this->getSetting(
                    'english.slider.background_color',
                    '#111827'
                ),

            'gradient' =>
                $this->getSetting(
                    'english.slider.gradient',
                    'dark'
                ),

            'image_fit' =>
                $this->getSetting(
                    'english.slider.image_fit',
                    'contain'
                ),

            'image_position' =>
                $this->getSetting(
                    'english.slider.image_position',
                    'center center'
                ),
        ];


        return View::renderIntoLayout(
            'layouts/admin',
            'admin/english/slider',
            [
                'title' =>
                    'اسلایدر انگلیسی | صدرا',

                'settings' =>
                    $settings,

                'success' =>
                    Session::getFlash(
                        'success'
                    ),

                'error' =>
                    Session::getFlash(
                        'error'
                    ),
            ]
        );
    }


    /**
     * Save English slider settings.
     */
    public function updateSlider(): never
    {
        Csrf::requireValid();


        $autoplay =
            isset(
                $_POST['autoplay']
            );


        $showArrows =
            isset(
                $_POST['show_arrows']
            );


        $showDots =
            isset(
                $_POST['show_dots']
            );


        $interval =
            filter_var(
                $_POST['interval']
                ?? 5000,
                FILTER_VALIDATE_INT
            );


        if (
            $interval === false
        ) {
            $interval =
                5000;
        }


        $interval =
            max(
                2000,
                min(
                    30000,
                    (int) $interval
                )
            );


        $backgroundMode =
            $this->validatedPostSetting(
                'background_mode',
                [
                    'blur',
                    'dominant',
                    'solid',
                    'gradient',
                    'none',
                ],
                'blur'
            );


        $backgroundColor =
            $this->validatedColor(
                $_POST['background_color']
                ?? '#111827',
                '#111827'
            );


        $gradient =
            $this->validatedPostSetting(
                'gradient',
                [
                    'dark',
                    'ocean',
                    'purple',
                    'sunset',
                    'light',
                ],
                'dark'
            );


        $imageFit =
            $this->validatedPostSetting(
                'image_fit',
                [
                    'contain',
                    'cover',
                    'fill',
                ],
                'contain'
            );


        $imagePosition =
            $this->validatedPostSetting(
                'image_position',
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
            );


        try {
            $settings = [
                'english.slider.autoplay' =>
                    $autoplay
                        ? '1'
                        : '0',

                'english.slider.interval' =>
                    (string) $interval,

                'english.slider.show_arrows' =>
                    $showArrows
                        ? '1'
                        : '0',

                'english.slider.show_dots' =>
                    $showDots
                        ? '1'
                        : '0',

                'english.slider.background_mode' =>
                    $backgroundMode,

                'english.slider.background_color' =>
                    $backgroundColor,

                'english.slider.gradient' =>
                    $gradient,

                'english.slider.image_fit' =>
                    $imageFit,

                'english.slider.image_position' =>
                    $imagePosition,
            ];


            foreach (
                $settings as $key => $value
            ) {
                $this->saveSetting(
                    $key,
                    $value
                );
            }
        } catch (
            \Throwable $exception
        ) {
            error_log(
                'English slider settings update failed: '
                . $exception->getMessage()
            );


            Session::flash(
                'error',
                'ذخیره تنظیمات اسلایدر انگلیسی انجام نشد.'
            );


            Response::redirectRoute(
                'admin.english.slider'
            );
        }


        Session::flash(
            'success',
            'تنظیمات اسلایدر انگلیسی با موفقیت ذخیره شد.'
        );


        Response::redirectRoute(
            'admin.english.slider'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ENGLISH STATIC PAGES
    |--------------------------------------------------------------------------
    */

    /**
     * Display an English static-page editor.
     */
    public function page(
        string $page
    ): string {
        $page =
            $this->normalizePageKey(
                $page
            );


        if (
            !$this->isAllowedPage(
                $page
            )
        ) {
            Response::notFound(
                'صفحه مورد نظر پیدا نشد.'
            );
        }


        $settings =
            $this->pageSettings(
                $page
            );


        $form =
            Session::getFlash(
                'english_page_form'
            );


        /*
         * Restore the submitted data after validation failure.
         */
        if (
            is_array($form)
            && (
                ($form['page'] ?? null)
                === $page
            )
        ) {
            foreach (
                array_keys(
                    $settings
                ) as $field
            ) {
                if (
                    array_key_exists(
                        $field,
                        $form
                    )
                    && is_string(
                        $form[$field]
                    )
                ) {
                    $settings[$field] =
                        trim(
                            $form[$field]
                        );
                }
            }
        }


        return View::renderIntoLayout(
            'layouts/admin',
            'admin/english/page',
            [
                'title' =>
                    $this->pageLabel(
                        $page
                    )
                    . ' | مدیریت سایت انگلیسی',

                'page' =>
                    $page,

                'pageLabel' =>
                    $this->pageLabel(
                        $page
                    ),

                'settings' =>
                    $settings,

                'errors' =>
                    Session::getFlash(
                        'english_page_errors'
                    ) ?: [],

                'success' =>
                    Session::getFlash(
                        'success'
                    ),
            ]
        );
    }


    /**
     * Save an English static page.
     */
    public function updatePage(
        string $page
    ): never {
        Csrf::requireValid();


        $page =
            $this->normalizePageKey(
                $page
            );


        if (
            !$this->isAllowedPage(
                $page
            )
        ) {
            Response::notFound(
                'صفحه مورد نظر پیدا نشد.'
            );
        }


        /*
         * Common page fields.
         */
        $data = [
            'page' =>
                $page,

            'eyebrow' =>
                $this->postString(
                    'eyebrow'
                ),

            'title' =>
                $this->postString(
                    'title'
                ),

            'description' =>
                $this->postString(
                    'description'
                ),
        ];


        /*
         * Contact-only fields.
         *
         * These are intentionally included only for the
         * contact page so all the other static pages keep
         * their existing form structure.
         */
        if (
            $page === 'contact'
        ) {
            $data['email'] =
                $this->postString(
                    'email'
                );

            $data['phone'] =
                $this->postString(
                    'phone'
                );

            $data['fax'] =
                $this->postString(
                    'fax'
                );

            $data['address'] =
                $this->postString(
                    'address'
                );

            $data['map_embed_url'] =
                $this->postString(
                    'map_embed_url'
                );
        }


        $errors = [];


        /*
         * Common validation.
         */
        if (
            $data['eyebrow'] === ''
        ) {
            $errors['eyebrow'] =
                'برچسب بالای عنوان الزامی است.';
        }


        if (
            $data['title'] === ''
        ) {
            $errors['title'] =
                'عنوان صفحه الزامی است.';
        }


        if (
            $data['description'] === ''
        ) {
            $errors['description'] =
                'توضیحات صفحه الزامی است.';
        }


        if (
            mb_strlen(
                $data['eyebrow'],
                'UTF-8'
            ) > 255
        ) {
            $errors['eyebrow'] =
                'برچسب بالای عنوان نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.';
        }


        if (
            mb_strlen(
                $data['title'],
                'UTF-8'
            ) > 255
        ) {
            $errors['title'] =
                'عنوان صفحه نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.';
        }


        if (
            mb_strlen(
                $data['description'],
                'UTF-8'
            ) > 5000
        ) {
            $errors['description'] =
                'توضیحات صفحه بیش از حد طولانی است.';
        }


        /*
         * Contact validation.
         */
        if (
            $page === 'contact'
        ) {
            if (
                $data['email'] !== ''
                && filter_var(
                    $data['email'],
                    FILTER_VALIDATE_EMAIL
                ) === false
            ) {
                $errors['email'] =
                    'آدرس ایمیل معتبر نیست.';
            }


            if (
                mb_strlen(
                    $data['email'],
                    'UTF-8'
                ) > 255
            ) {
                $errors['email'] =
                    'ایمیل نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.';
            }


            if (
                mb_strlen(
                    $data['phone'],
                    'UTF-8'
                ) > 100
            ) {
                $errors['phone'] =
                    'شماره تلفن نمی‌تواند بیشتر از ۱۰۰ کاراکتر باشد.';
            }


            if (
                mb_strlen(
                    $data['fax'],
                    'UTF-8'
                ) > 100
            ) {
                $errors['fax'] =
                    'شماره فکس نمی‌تواند بیشتر از ۱۰۰ کاراکتر باشد.';
            }


            if (
                mb_strlen(
                    $data['address'],
                    'UTF-8'
                ) > 2000
            ) {
                $errors['address'] =
                    'آدرس بیش از حد طولانی است.';
            }


            if (
                mb_strlen(
                    $data['map_embed_url'],
                    'UTF-8'
                ) > 5000
            ) {
                $errors['map_embed_url'] =
                    'آدرس نقشه بیش از حد طولانی است.';
            }


            /*
             * We store only the Google Maps embed URL.
             *
             * The public contact page places this value into
             * the iframe src attribute.
             *
             * A full iframe tag is not expected here.
             */
            if (
                $data['map_embed_url'] !== ''
            ) {
                $parsed =
                    parse_url(
                        $data['map_embed_url']
                    );


                if (
                    !is_array(
                        $parsed
                    )
                ) {
                    $errors['map_embed_url'] =
                        'آدرس نقشه معتبر نیست.';
                } else {
                    $scheme =
                        strtolower(
                            (string) (
                                $parsed['scheme']
                                ?? ''
                            )
                        );


                    $host =
                        strtolower(
                            (string) (
                                $parsed['host']
                                ?? ''
                            )
                        );


                    if (
                        !in_array(
                            $scheme,
                            [
                                'https',
                                'http',
                            ],
                            true
                        )
                        || $host === ''
                    ) {
                        $errors['map_embed_url'] =
                            'آدرس نقشه معتبر نیست.';
                    }
                }
            }
        }


        if (
            $errors !== []
        ) {
            Session::flash(
                'english_page_errors',
                $errors
            );


            Session::flash(
                'english_page_form',
                $data
            );


            Response::redirectRoute(
                'admin.english.page',
                [
                    'page' =>
                        $page,
                ]
            );
        }


        $prefix =
            'english.pages.'
            . $page
            . '.';


        try {
            /*
             * Common fields.
             */
            $this->saveSetting(
                $prefix . 'eyebrow',
                $data['eyebrow']
            );


            $this->saveSetting(
                $prefix . 'title',
                $data['title']
            );


            $this->saveSetting(
                $prefix . 'description',
                $data['description']
            );


            /*
             * Contact-only settings.
             */
            if (
                $page === 'contact'
            ) {
                $this->saveSetting(
                    $prefix . 'email',
                    $data['email']
                );


                $this->saveSetting(
                    $prefix . 'phone',
                    $data['phone']
                );


                $this->saveSetting(
                    $prefix . 'fax',
                    $data['fax']
                );


                $this->saveSetting(
                    $prefix . 'address',
                    $data['address']
                );


                $this->saveSetting(
                    $prefix . 'map_embed_url',
                    $data['map_embed_url']
                );
            }
        } catch (
            \Throwable $exception
        ) {
            error_log(
                'English page update failed: '
                . $exception->getMessage()
            );


            Session::flash(
                'error',
                'ذخیره اطلاعات صفحه انجام نشد.'
            );


            Session::flash(
                'english_page_form',
                $data
            );


            Response::redirectRoute(
                'admin.english.page',
                [
                    'page' =>
                        $page,
                ]
            );
        }


        Session::flash(
            'success',
            'اطلاعات صفحه '
            . $this->pageLabel(
                $page
            )
            . ' با موفقیت ذخیره شد.'
        );


        Response::redirectRoute(
            'admin.english.page',
            [
                'page' =>
                    $page,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PAGE SETTINGS
    |--------------------------------------------------------------------------
    */

    /**
     * Return editable settings for an English page.
     *
     * Contact pages additionally expose:
     *
     * email
     * phone
     * fax
     * address
     * map_embed_url
     *
     * @return array<string, string>
     */
    private function pageSettings(
        string $page
    ): array {
        switch ($page) {
            case 'about':
                return [
                    'eyebrow' =>
                        $this->getSetting(
                            'english.pages.about.eyebrow',
                            'ABOUT SADRA'
                        ),

                    'title' =>
                        $this->getSetting(
                            'english.pages.about.title',
                            'A place for learning, research, and growth.'
                        ),

                    'description' =>
                        $this->getSetting(
                            'english.pages.about.description',
                            'Sadra Institute of Higher Education is an academic institution in Tehran committed to education, scientific development, research, and preparing students for meaningful professional careers.'
                        ),
                ];


            case 'presidency':
                return [
                    'eyebrow' =>
                        $this->getSetting(
                            'english.pages.presidency.eyebrow',
                            'LEADERSHIP'
                        ),

                    'title' =>
                        $this->getSetting(
                            'english.pages.presidency.title',
                            'Office of the President'
                        ),

                    'description' =>
                        $this->getSetting(
                            'english.pages.presidency.description',
                            'Information about the leadership of Sadra Institute of Higher Education.'
                        ),
                ];


            case 'faculties':
                return [
                    'eyebrow' =>
                        $this->getSetting(
                            'english.pages.faculties.eyebrow',
                            'ACADEMICS'
                        ),

                    'title' =>
                        $this->getSetting(
                            'english.pages.faculties.title',
                            'Faculties'
                        ),

                    'description' =>
                        $this->getSetting(
                            'english.pages.faculties.description',
                            'Explore the academic faculties and educational structure of Sadra Institute.'
                        ),
                ];


            case 'programs':
                return [
                    'eyebrow' =>
                        $this->getSetting(
                            'english.pages.programs.eyebrow',
                            'ACADEMICS'
                        ),

                    'title' =>
                        $this->getSetting(
                            'english.pages.programs.title',
                            'Academic Programs'
                        ),

                    'description' =>
                        $this->getSetting(
                            'english.pages.programs.description',
                            'Explore the academic programs and fields of study offered by Sadra Institute of Higher Education.'
                        ),
                ];


            case 'research':
                return [
                    'eyebrow' =>
                        $this->getSetting(
                            'english.pages.research.eyebrow',
                            'RESEARCH'
                        ),

                    'title' =>
                        $this->getSetting(
                            'english.pages.research.title',
                            'Research Centers'
                        ),

                    'description' =>
                        $this->getSetting(
                            'english.pages.research.description',
                            'Research centers and scientific activities at Sadra Institute.'
                        ),
                ];


            case 'announcements':
                return [
                    'eyebrow' =>
                        $this->getSetting(
                            'english.pages.announcements.eyebrow',
                            'NEWS'
                        ),

                    'title' =>
                        $this->getSetting(
                            'english.pages.announcements.title',
                            'Announcements'
                        ),

                    'description' =>
                        $this->getSetting(
                            'english.pages.announcements.description',
                            'The latest official announcements from Sadra Institute.'
                        ),
                ];


            case 'contact':
                return [
                    'eyebrow' =>
                        $this->getSetting(
                            'english.pages.contact.eyebrow',
                            'CONTACT'
                        ),

                    'title' =>
                        $this->getSetting(
                            'english.pages.contact.title',
                            'Contact Us'
                        ),

                    'description' =>
                        $this->getSetting(
                            'english.pages.contact.description',
                            'Contact information for Sadra Institute of Higher Education.'
                        ),

                    'email' =>
                        $this->getSetting(
                            'english.pages.contact.email',
                            'info@sadra.ac.ir'
                        ),

                    'phone' =>
                        $this->getSetting(
                            'english.pages.contact.phone',
                            ''
                        ),

                    'fax' =>
                        $this->getSetting(
                            'english.pages.contact.fax',
                            ''
                        ),

                    'address' =>
                        $this->getSetting(
                            'english.pages.contact.address',
                            'Tehran, Iran'
                        ),

                    'map_embed_url' =>
                        $this->getSetting(
                            'english.pages.contact.map_embed_url',
                            ''
                        ),
                ];


            default:
                return [
                    'eyebrow' =>
                        'PAGE',

                    'title' =>
                        'English Page',

                    'description' =>
                        'English page at Sadra Institute of Higher Education.',
                ];
        }
    }


    /*
    |--------------------------------------------------------------------------
    | PAGE HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Normalize a page key.
     */
    private function normalizePageKey(
        string $page
    ): string {
        return trim(
            strtolower(
                $page
            )
        );
    }


    /**
     * Determine whether page is editable.
     */
    private function isAllowedPage(
        string $page
    ): bool {
        return in_array(
            $page,
            [
                'about',
                'presidency',
                'faculties',
                'programs',
                'research',
                'announcements',
                'contact',
            ],
            true
        );
    }


    /**
     * Persian admin label.
     */
    private function pageLabel(
        string $page
    ): string {
        return match ($page) {
            'about' =>
                'درباره انگلیسی',

            'presidency' =>
                'ریاست انگلیسی',

            'faculties' =>
                'دانشکده‌های انگلیسی',

            'programs' =>
                'رشته‌های انگلیسی',

            'research' =>
                'پژوهش انگلیسی',

            'announcements' =>
                'اطلاعیه‌های انگلیسی',

            'contact' =>
                'تماس انگلیسی',

            default =>
                'صفحه انگلیسی',
        };
    }


    /*
    |--------------------------------------------------------------------------
    | INPUT HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Read a POST string.
     */
    private function postString(
        string $key
    ): string {
        $value =
            $_POST[$key]
            ?? '';


        if (
            !is_string(
                $value
            )
        ) {
            return '';
        }


        return trim(
            $value
        );
    }


    /**
     * Get a string setting safely.
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
                'English setting read failed [' .
                $key .
                ']: ' .
                $exception->getMessage()
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
     * Get a boolean setting.
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
                'English boolean setting read failed [' .
                $key .
                ']: ' .
                $exception->getMessage()
            );


            return $default;
        }


        if (
            is_bool($value)
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
            is_string($value)
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
     * Get an integer setting.
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
                'English integer setting read failed [' .
                $key .
                ']: ' .
                $exception->getMessage()
            );


            return $default;
        }


        return is_numeric(
            $value
        )
            ? (int) $value
            : $default;
    }


    /**
     * Save a site setting.
     */
    private function saveSetting(
        string $key,
        string $value
    ): void {
        if (
            method_exists(
                SiteSetting::class,
                'set'
            )
        ) {
            SiteSetting::set(
                $key,
                $value
            );


            return;
        }


        if (
            method_exists(
                SiteSetting::class,
                'updateOrCreate'
            )
        ) {
            SiteSetting::updateOrCreate(
                $key,
                $value
            );


            return;
        }


        if (
            method_exists(
                SiteSetting::class,
                'save'
            )
        ) {
            SiteSetting::save(
                $key,
                $value
            );


            return;
        }


        throw new RuntimeException(
            'SiteSetting model does not expose a supported save method.'
        );
    }


    /**
     * Validate a POST setting.
     *
     * @param array<int, string> $allowed
     */
    private function validatedPostSetting(
        string $key,
        array $allowed,
        string $default
    ): string {
        $value =
            $this->postString(
                $key
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
     * Validate hexadecimal color.
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
}


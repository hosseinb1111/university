<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\SiteSetting;
use Throwable;

final class SiteSettingController
{
    /**
     * Display site settings.
     */
    public function index(): string
    {
        $settings = [
            /*
            |--------------------------------------------------------------------------
            | Homepage
            |--------------------------------------------------------------------------
            */

            'quick_links_eyebrow' =>
                (string) SiteSetting::get(
                    'homepage.quick_links.eyebrow',
                    'دسترسی سریع'
                ),

            'quick_links_title' =>
                (string) SiteSetting::get(
                    'homepage.quick_links.title',
                    'سامانه‌ها و خدمات'
                ),

            'quick_links_description' =>
                (string) SiteSetting::get(
                    'homepage.quick_links.description',
                    'دسترسی سریع به سامانه‌ها و خدمات مهم موسسه'
                ),


            /*
            |--------------------------------------------------------------------------
            | About page
            |--------------------------------------------------------------------------
            */

            'about_eyebrow' =>
                (string) SiteSetting::get(
                    'about.eyebrow',
                    'معرفی موسسه'
                ),

            'about_title' =>
                (string) SiteSetting::get(
                    'about.title',
                    'موسسه آموزش عالی صدرالمتالهین'
                ),

            'about_intro' =>
                (string) SiteSetting::get(
                    'about.intro',
                    'موسسه آموزش عالی صدرالمتالهین (صدرا)، یک مجموعه آموزش عالی با تمرکز بر آموزش، توسعه علمی و فعالیت‌های پژوهشی است.'
                ),

            'about_card_eyebrow' =>
                (string) SiteSetting::get(
                    'about.card.eyebrow',
                    'درباره ما'
                ),

            'about_card_title' =>
                (string) SiteSetting::get(
                    'about.card.title',
                    'معرفی موسسه'
                ),

            'about_card_text_1' =>
                (string) SiteSetting::get(
                    'about.card.text_1',
                    'این بخش برای ارائه معرفی رسمی موسسه، تاریخچه، ساختار و اطلاعات عمومی آن طراحی شده است.'
                ),

            'about_card_text_2' =>
                (string) SiteSetting::get(
                    'about.card.text_2',
                    'محتوای رسمی و قابل ویرایش می‌تواند از طریق پنل مدیریت به این بخش متصل شود.'
                ),

            'about_goals_eyebrow' =>
                (string) SiteSetting::get(
                    'about.goals.eyebrow',
                    'اهداف'
                ),

            'about_goals_title' =>
                (string) SiteSetting::get(
                    'about.goals.title',
                    'اهداف و رویکرد'
                ),

            'about_goals_text' =>
                (string) SiteSetting::get(
                    'about.goals.text',
                    'توسعه آموزش عالی، تقویت فعالیت‌های علمی و پژوهشی و فراهم کردن محیط مناسب برای رشد دانشجویان و اعضای هیئت علمی.'
                ),

            'about_structure_eyebrow' =>
                (string) SiteSetting::get(
                    'about.structure.eyebrow',
                    'ساختار'
                ),

            'about_structure_title' =>
                (string) SiteSetting::get(
                    'about.structure.title',
                    'ساختار دانشگاهی'
                ),

            'about_structure_text' =>
                (string) SiteSetting::get(
                    'about.structure.text',
                    'ساختار موسسه شامل بخش‌های آموزشی، پژوهشی، دانشجویی، اداری و پشتیبانی است.'
                ),

            'about_more_eyebrow' =>
                (string) SiteSetting::get(
                    'about.more.eyebrow',
                    'اطلاعات بیشتر'
                ),

            'about_more_title' =>
                (string) SiteSetting::get(
                    'about.more.title',
                    'مسیرهای دسترسی'
                ),


            /*
            |--------------------------------------------------------------------------
            | Contact page
            |--------------------------------------------------------------------------
            */

            'contact_eyebrow' =>
                (string) SiteSetting::get(
                    'contact.eyebrow',
                    'ارتباط با موسسه'
                ),

            'contact_title' =>
                (string) SiteSetting::get(
                    'contact.title',
                    'تماس با ما'
                ),

            'contact_description' =>
                (string) SiteSetting::get(
                    'contact.description',
                    'اطلاعات رسمی تماس موسسه آموزش عالی صدرالمتالهین.'
                ),

            'contact_email' =>
                (string) SiteSetting::get(
                    'contact.email',
                    'info@sadra.ac.ir'
                ),

            'contact_phone' =>
                (string) SiteSetting::get(
                    'contact.phone',
                    ''
                ),

            'contact_fax' =>
                (string) SiteSetting::get(
                    'contact.fax',
                    ''
                ),

            'contact_address' =>
                (string) SiteSetting::get(
                    'contact.address',
                    'استان تهران، تهران، منطقه ۲۲، بزرگراه شهید خرازی، خروجی بلوار کاشان جنوب، میدان موج، بلوار علامه قزوینی، نبش، Iran'
                ),

            'contact_map_eyebrow' =>
                (string) SiteSetting::get(
                    'contact.map.eyebrow',
                    'موقعیت موسسه'
                ),

            'contact_map_title' =>
                (string) SiteSetting::get(
                    'contact.map.title',
                    'تهران، ایران'
                ),

            'contact_map_description' =>
                (string) SiteSetting::get(
                    'contact.map.description',
                    'برای مشاهده موقعیت موسسه روی نقشه، از نقشه زیر استفاده کنید.'
                ),

            'contact_map_embed' =>
                (string) SiteSetting::get(
                    'contact.map.embed',
                    'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1618.9576833727097!2d51.2223523119335!3d35.7528849!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f8de348aa089443%3A0xdd64a5cf4f64b69f!2sSadra%20Institute%20of%20Higher%20Education!5e0!3m2!1sen!2s!4v1787694850499!5m2!1sen!2s'
                ),
        ];


        /*
        |--------------------------------------------------------------------------
        | Restore submitted values after validation errors
        |--------------------------------------------------------------------------
        */

        $form =
            Session::getFlash(
                'site_settings_form'
            );

        $errors =
            Session::getFlash(
                'site_settings_errors'
            );


        if (
            is_array($form)
        ) {
            $settings =
                array_merge(
                    $settings,
                    $form
                );
        }


        return View::renderIntoLayout(
            'layouts/admin',
            'admin/settings/index',
            [
                'title' =>
                    'تنظیمات سایت | صدرا',

                'settings' =>
                    $settings,

                'errors' =>
                    is_array($errors)
                        ? $errors
                        : [],

                'success' =>
                    $this->successMessage(),
            ]
        );
    }


    /**
     * Update all site settings.
     */
    public function update(): never
    {
        Csrf::requireValid();


        /*
        |--------------------------------------------------------------------------
        | Homepage
        |--------------------------------------------------------------------------
        */

        $quickLinksEyebrow =
            $this->input(
                'quick_links_eyebrow'
            );

        $quickLinksTitle =
            $this->input(
                'quick_links_title'
            );

        $quickLinksDescription =
            $this->input(
                'quick_links_description'
            );


        /*
        |--------------------------------------------------------------------------
        | About page
        |--------------------------------------------------------------------------
        */

        $aboutEyebrow =
            $this->input(
                'about_eyebrow'
            );

        $aboutTitle =
            $this->input(
                'about_title'
            );

        $aboutIntro =
            $this->input(
                'about_intro'
            );

        $aboutCardEyebrow =
            $this->input(
                'about_card_eyebrow'
            );

        $aboutCardTitle =
            $this->input(
                'about_card_title'
            );

        $aboutCardText1 =
            $this->input(
                'about_card_text_1'
            );

        $aboutCardText2 =
            $this->input(
                'about_card_text_2'
            );

        $aboutGoalsEyebrow =
            $this->input(
                'about_goals_eyebrow'
            );

        $aboutGoalsTitle =
            $this->input(
                'about_goals_title'
            );

        $aboutGoalsText =
            $this->input(
                'about_goals_text'
            );

        $aboutStructureEyebrow =
            $this->input(
                'about_structure_eyebrow'
            );

        $aboutStructureTitle =
            $this->input(
                'about_structure_title'
            );

        $aboutStructureText =
            $this->input(
                'about_structure_text'
            );

        $aboutMoreEyebrow =
            $this->input(
                'about_more_eyebrow'
            );

        $aboutMoreTitle =
            $this->input(
                'about_more_title'
            );


        /*
        |--------------------------------------------------------------------------
        | Contact page
        |--------------------------------------------------------------------------
        */

        $contactEyebrow =
            $this->input(
                'contact_eyebrow'
            );

        $contactTitle =
            $this->input(
                'contact_title'
            );

        $contactDescription =
            $this->input(
                'contact_description'
            );

        $contactEmail =
            $this->input(
                'contact_email'
            );

        $contactPhone =
            $this->input(
                'contact_phone'
            );

        $contactFax =
            $this->input(
                'contact_fax'
            );

        $contactAddress =
            $this->input(
                'contact_address'
            );

        $contactMapEyebrow =
            $this->input(
                'contact_map_eyebrow'
            );

        $contactMapTitle =
            $this->input(
                'contact_map_title'
            );

        $contactMapDescription =
            $this->input(
                'contact_map_description'
            );

        $contactMapEmbed =
            $this->input(
                'contact_map_embed'
            );


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $errors = [];


        /*
        |--------------------------------------------------------------------------
        | Homepage validation
        |--------------------------------------------------------------------------
        */

        $this->required(
            $errors,
            'quick_links_eyebrow',
            $quickLinksEyebrow,
            'متن کوچک بخش سامانه‌ها و خدمات الزامی است.'
        );

        $this->required(
            $errors,
            'quick_links_title',
            $quickLinksTitle,
            'عنوان بخش سامانه‌ها و خدمات الزامی است.'
        );


        /*
        |--------------------------------------------------------------------------
        | About validation
        |--------------------------------------------------------------------------
        */

        $this->required(
            $errors,
            'about_eyebrow',
            $aboutEyebrow,
            'متن بالای صفحه درباره موسسه الزامی است.'
        );

        $this->required(
            $errors,
            'about_title',
            $aboutTitle,
            'عنوان صفحه درباره موسسه الزامی است.'
        );

        $this->required(
            $errors,
            'about_intro',
            $aboutIntro,
            'متن معرفی درباره موسسه الزامی است.'
        );

        $this->required(
            $errors,
            'about_card_title',
            $aboutCardTitle,
            'عنوان بخش معرفی موسسه الزامی است.'
        );

        $this->required(
            $errors,
            'about_goals_title',
            $aboutGoalsTitle,
            'عنوان بخش اهداف الزامی است.'
        );

        $this->required(
            $errors,
            'about_structure_title',
            $aboutStructureTitle,
            'عنوان بخش ساختار الزامی است.'
        );

        $this->required(
            $errors,
            'about_more_title',
            $aboutMoreTitle,
            'عنوان بخش اطلاعات بیشتر الزامی است.'
        );


        /*
        |--------------------------------------------------------------------------
        | Contact validation
        |--------------------------------------------------------------------------
        */

        $this->required(
            $errors,
            'contact_eyebrow',
            $contactEyebrow,
            'متن بالای صفحه تماس الزامی است.'
        );

        $this->required(
            $errors,
            'contact_title',
            $contactTitle,
            'عنوان صفحه تماس الزامی است.'
        );

        $this->required(
            $errors,
            'contact_description',
            $contactDescription,
            'توضیحات صفحه تماس الزامی است.'
        );

        $this->required(
            $errors,
            'contact_address',
            $contactAddress,
            'آدرس موسسه الزامی است.'
        );


        if (
            $contactEmail !== ''
            && filter_var(
                $contactEmail,
                FILTER_VALIDATE_EMAIL
            ) === false
        ) {
            $errors['contact_email'] =
                'ایمیل وارد شده معتبر نیست.';
        }


        /*
        |--------------------------------------------------------------------------
        | Length validation
        |--------------------------------------------------------------------------
        */

        $limits = [
            'quick_links_eyebrow' => [
                $quickLinksEyebrow,
                255,
            ],

            'quick_links_title' => [
                $quickLinksTitle,
                255,
            ],

            'quick_links_description' => [
                $quickLinksDescription,
                1000,
            ],

            'about_eyebrow' => [
                $aboutEyebrow,
                255,
            ],

            'about_title' => [
                $aboutTitle,
                255,
            ],

            'about_intro' => [
                $aboutIntro,
                3000,
            ],

            'about_card_eyebrow' => [
                $aboutCardEyebrow,
                255,
            ],

            'about_card_title' => [
                $aboutCardTitle,
                255,
            ],

            'about_card_text_1' => [
                $aboutCardText1,
                5000,
            ],

            'about_card_text_2' => [
                $aboutCardText2,
                5000,
            ],

            'about_goals_eyebrow' => [
                $aboutGoalsEyebrow,
                255,
            ],

            'about_goals_title' => [
                $aboutGoalsTitle,
                255,
            ],

            'about_goals_text' => [
                $aboutGoalsText,
                5000,
            ],

            'about_structure_eyebrow' => [
                $aboutStructureEyebrow,
                255,
            ],

            'about_structure_title' => [
                $aboutStructureTitle,
                255,
            ],

            'about_structure_text' => [
                $aboutStructureText,
                5000,
            ],

            'about_more_eyebrow' => [
                $aboutMoreEyebrow,
                255,
            ],

            'about_more_title' => [
                $aboutMoreTitle,
                255,
            ],

            'contact_eyebrow' => [
                $contactEyebrow,
                255,
            ],

            'contact_title' => [
                $contactTitle,
                255,
            ],

            'contact_description' => [
                $contactDescription,
                3000,
            ],

            'contact_email' => [
                $contactEmail,
                255,
            ],

            'contact_phone' => [
                $contactPhone,
                255,
            ],

            'contact_fax' => [
                $contactFax,
                255,
            ],

            'contact_address' => [
                $contactAddress,
                2000,
            ],

            'contact_map_eyebrow' => [
                $contactMapEyebrow,
                255,
            ],

            'contact_map_title' => [
                $contactMapTitle,
                255,
            ],

            'contact_map_description' => [
                $contactMapDescription,
                2000,
            ],

            'contact_map_embed' => [
                $contactMapEmbed,
                5000,
            ],
        ];


        foreach (
            $limits
            as $field => $rule
        ) {
            $value =
                (string) $rule[0];

            $limit =
                (int) $rule[1];

            if (
                mb_strlen(
                    $value,
                    'UTF-8'
                ) > $limit
            ) {
                $errors[$field] =
                    'مقدار این فیلد نمی‌تواند بیشتر از '
                    . $limit
                    . ' کاراکتر باشد.';
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Form data
        |--------------------------------------------------------------------------
        */

        $form = [
            'quick_links_eyebrow' =>
                $quickLinksEyebrow,

            'quick_links_title' =>
                $quickLinksTitle,

            'quick_links_description' =>
                $quickLinksDescription,

            'about_eyebrow' =>
                $aboutEyebrow,

            'about_title' =>
                $aboutTitle,

            'about_intro' =>
                $aboutIntro,

            'about_card_eyebrow' =>
                $aboutCardEyebrow,

            'about_card_title' =>
                $aboutCardTitle,

            'about_card_text_1' =>
                $aboutCardText1,

            'about_card_text_2' =>
                $aboutCardText2,

            'about_goals_eyebrow' =>
                $aboutGoalsEyebrow,

            'about_goals_title' =>
                $aboutGoalsTitle,

            'about_goals_text' =>
                $aboutGoalsText,

            'about_structure_eyebrow' =>
                $aboutStructureEyebrow,

            'about_structure_title' =>
                $aboutStructureTitle,

            'about_structure_text' =>
                $aboutStructureText,

            'about_more_eyebrow' =>
                $aboutMoreEyebrow,

            'about_more_title' =>
                $aboutMoreTitle,

            'contact_eyebrow' =>
                $contactEyebrow,

            'contact_title' =>
                $contactTitle,

            'contact_description' =>
                $contactDescription,

            'contact_email' =>
                $contactEmail,

            'contact_phone' =>
                $contactPhone,

            'contact_fax' =>
                $contactFax,

            'contact_address' =>
                $contactAddress,

            'contact_map_eyebrow' =>
                $contactMapEyebrow,

            'contact_map_title' =>
                $contactMapTitle,

            'contact_map_description' =>
                $contactMapDescription,

            'contact_map_embed' =>
                $contactMapEmbed,
        ];


        /*
        |--------------------------------------------------------------------------
        | Validation failed
        |--------------------------------------------------------------------------
        */

        if (
            $errors !== []
        ) {
            Session::flash(
                'site_settings_form',
                $form
            );

            Session::flash(
                'site_settings_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.settings'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Save all settings
        |--------------------------------------------------------------------------
        */

        try {

            $settingsToSave = [
                'homepage.quick_links.eyebrow' =>
                    $quickLinksEyebrow,

                'homepage.quick_links.title' =>
                    $quickLinksTitle,

                'homepage.quick_links.description' =>
                    $quickLinksDescription,

                'about.eyebrow' =>
                    $aboutEyebrow,

                'about.title' =>
                    $aboutTitle,

                'about.intro' =>
                    $aboutIntro,

                'about.card.eyebrow' =>
                    $aboutCardEyebrow,

                'about.card.title' =>
                    $aboutCardTitle,

                'about.card.text_1' =>
                    $aboutCardText1,

                'about.card.text_2' =>
                    $aboutCardText2,

                'about.goals.eyebrow' =>
                    $aboutGoalsEyebrow,

                'about.goals.title' =>
                    $aboutGoalsTitle,

                'about.goals.text' =>
                    $aboutGoalsText,

                'about.structure.eyebrow' =>
                    $aboutStructureEyebrow,

                'about.structure.title' =>
                    $aboutStructureTitle,

                'about.structure.text' =>
                    $aboutStructureText,

                'about.more.eyebrow' =>
                    $aboutMoreEyebrow,

                'about.more.title' =>
                    $aboutMoreTitle,

                'contact.eyebrow' =>
                    $contactEyebrow,

                'contact.title' =>
                    $contactTitle,

                'contact.description' =>
                    $contactDescription,

                'contact.email' =>
                    $contactEmail,

                'contact.phone' =>
                    $contactPhone,

                'contact.fax' =>
                    $contactFax,

                'contact.address' =>
                    $contactAddress,

                'contact.map.eyebrow' =>
                    $contactMapEyebrow,

                'contact.map.title' =>
                    $contactMapTitle,

                'contact.map.description' =>
                    $contactMapDescription,

                'contact.map.embed' =>
                    $contactMapEmbed,
            ];


            foreach (
                $settingsToSave
                as $key => $value
            ) {
                SiteSetting::set(
                    $key,
                    $value
                );
            }

        } catch (
            Throwable $e
        ) {

            error_log(
                'Site settings update failed: '
                . $e->getMessage()
            );

            Session::flash(
                'site_settings_form',
                $form
            );

            Session::flash(
                'site_settings_errors',
                [
                    'general' =>
                        'ذخیره تنظیمات انجام نشد. دوباره تلاش کنید.',
                ]
            );

            Response::redirectRoute(
                'admin.settings'
            );
        }


        Response::redirect(
            '/admin/settings?success=updated'
        );
    }


    /**
     * Get one POST input.
     */
    private function input(
        string $key
    ): string {
        return trim(
            (string) (
                $_POST[$key]
                ?? ''
            )
        );
    }


    /**
     * Required-field helper.
     *
     * @param array<string, string> $errors
     */
    private function required(
        array &$errors,
        string $field,
        string $value,
        string $message
    ): void {
        if (
            $value === ''
        ) {
            $errors[$field] =
                $message;
        }
    }


    /**
     * Get success message.
     */
    private function successMessage(): ?string
    {
        return match (
            (string) (
                $_GET['success']
                ?? ''
            )
        ) {
            'updated' =>
                'تنظیمات سایت با موفقیت ذخیره شد.',

            default =>
                null,
        };
    }
}
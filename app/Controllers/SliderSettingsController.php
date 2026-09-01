<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\HomepageSlide;
use App\Models\SiteSetting;
use Throwable;

final class SliderSettingsController
{
    /**
     * Allowed background modes.
     */
    private const BACKGROUND_MODES = [
        'blur',
        'dominant',
        'solid',
        'gradient',
        'none',
    ];

    /**
     * Allowed gradient presets.
     */
    private const GRADIENTS = [
        'dark',
        'ocean',
        'purple',
        'sunset',
        'light',
    ];

    /**
     * Allowed image fitting modes.
     */
    private const IMAGE_FITS = [
        'contain',
        'cover',
        'fill',
    ];

    /**
     * Allowed image positions.
     */
    private const IMAGE_POSITIONS = [
        'center center',
        'center top',
        'center bottom',
        'left center',
        'right center',
        'left top',
        'right top',
        'left bottom',
        'right bottom',
    ];


    /**
     * Display slider settings.
     */
    public function index(): string
    {
        $settings = [
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
                $this->getBackgroundMode(),

            'background_color' =>
                $this->getBackgroundColor(),

            'gradient' =>
                $this->getGradient(),

            'image_fit' =>
                $this->getImageFit(),

            'image_position' =>
                $this->getImagePosition(),
        ];


        /*
        |--------------------------------------------------------------------------
        | Restore submitted values after validation/database errors
        |--------------------------------------------------------------------------
        */

        $form =
            Session::getFlash(
                'slider_settings_form'
            );

        $errors =
            Session::getFlash(
                'slider_settings_errors'
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


        /*
        |--------------------------------------------------------------------------
        | Preview image
        |--------------------------------------------------------------------------
        */

        $previewImage = '';

        try {
            $slides =
                HomepageSlide::latest(
                    1
                );

            if (
                isset($slides[0])
                && is_array($slides[0])
            ) {
                $previewImage =
                    trim(
                        (string) (
                            $slides[0]['image']
                            ?? ''
                        )
                    );
            }
        } catch (
            Throwable $e
        ) {
            error_log(
                'Slider preview image failed: '
                . $e->getMessage()
            );
        }


        return View::renderIntoLayout(
            'layouts/admin',
            'admin/slider-settings/index',
            [
                'title' =>
                    'تنظیمات اسلایدر | صدرا',

                'settings' =>
                    $settings,

                'previewImage' =>
                    $previewImage,

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
     * Update slider settings.
     */
    public function update(): never
    {
        Csrf::requireValid();


        /*
        |--------------------------------------------------------------------------
        | Read values
        |--------------------------------------------------------------------------
        */

        $autoplay =
            isset(
                $_POST['autoplay']
            );

        $interval =
            (int) (
                $_POST['interval']
                ?? 5000
            );

        $showArrows =
            isset(
                $_POST['show_arrows']
            );

        $showDots =
            isset(
                $_POST['show_dots']
            );

        $backgroundMode =
            trim(
                (string) (
                    $_POST['background_mode']
                    ?? 'blur'
                )
            );

        $backgroundColor =
            strtoupper(
                trim(
                    (string) (
                        $_POST['background_color']
                        ?? '#111827'
                    )
                )
            );

        $gradient =
            trim(
                (string) (
                    $_POST['gradient']
                    ?? 'dark'
                )
            );

        $imageFit =
            trim(
                (string) (
                    $_POST['image_fit']
                    ?? 'contain'
                )
            );

        $imagePosition =
            trim(
                (string) (
                    $_POST['image_position']
                    ?? 'center center'
                )
            );


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $errors = [];


        if (
            $interval < 2000
            || $interval > 30000
        ) {
            $errors['interval'] =
                'مدت نمایش هر اسلاید باید بین ۲ تا ۳۰ ثانیه باشد.';
        }


        if (
            !in_array(
                $backgroundMode,
                self::BACKGROUND_MODES,
                true
            )
        ) {
            $errors['background_mode'] =
                'حالت پس‌زمینه معتبر نیست.';
        }


        if (
            !preg_match(
                '/^#[0-9A-F]{6}$/i',
                $backgroundColor
            )
        ) {
            $errors['background_color'] =
                'رنگ پس‌زمینه معتبر نیست.';
        }


        if (
            !in_array(
                $gradient,
                self::GRADIENTS,
                true
            )
        ) {
            $errors['gradient'] =
                'گرادیان انتخاب‌شده معتبر نیست.';
        }


        if (
            !in_array(
                $imageFit,
                self::IMAGE_FITS,
                true
            )
        ) {
            $errors['image_fit'] =
                'نحوه نمایش تصویر معتبر نیست.';
        }


        if (
            !in_array(
                $imagePosition,
                self::IMAGE_POSITIONS,
                true
            )
        ) {
            $errors['image_position'] =
                'موقعیت تصویر معتبر نیست.';
        }


        /*
        |--------------------------------------------------------------------------
        | Form values
        |--------------------------------------------------------------------------
        */

        $form = [
            'autoplay' =>
                $autoplay,

            'interval' =>
                $interval,

            'show_arrows' =>
                $showArrows,

            'show_dots' =>
                $showDots,

            'background_mode' =>
                $backgroundMode,

            'background_color' =>
                $backgroundColor,

            'gradient' =>
                $gradient,

            'image_fit' =>
                $imageFit,

            'image_position' =>
                $imagePosition,
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
                'slider_settings_form',
                $form
            );

            Session::flash(
                'slider_settings_errors',
                $errors
            );

            Response::redirectRoute(
                'admin.slider-settings'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Save settings
        |--------------------------------------------------------------------------
        */

        try {

            SiteSetting::set(
                'homepage.slider.autoplay',
                $autoplay
            );

            SiteSetting::set(
                'homepage.slider.interval',
                $interval
            );

            SiteSetting::set(
                'homepage.slider.show_arrows',
                $showArrows
            );

            SiteSetting::set(
                'homepage.slider.show_dots',
                $showDots
            );

            SiteSetting::set(
                'homepage.slider.background_mode',
                $backgroundMode
            );

            SiteSetting::set(
                'homepage.slider.background_color',
                $backgroundColor
            );

            SiteSetting::set(
                'homepage.slider.gradient',
                $gradient
            );

            SiteSetting::set(
                'homepage.slider.image_fit',
                $imageFit
            );

            SiteSetting::set(
                'homepage.slider.image_position',
                $imagePosition
            );

        } catch (
            Throwable $e
        ) {
            error_log(
                'Slider settings update failed: '
                . $e->getMessage()
            );

            Session::flash(
                'slider_settings_form',
                $form
            );

            Session::flash(
                'slider_settings_errors',
                [
                    'general' =>
                        'ذخیره تنظیمات اسلایدر انجام نشد. دوباره تلاش کنید.',
                ]
            );

            Response::redirectRoute(
                'admin.slider-settings'
            );
        }


        Response::redirect(
            '/admin/slider-settings?success=updated'
        );
    }


    /**
     * Get validated background mode.
     */
    private function getBackgroundMode(): string
    {
        $value =
            trim(
                (string) SiteSetting::get(
                    'homepage.slider.background_mode',
                    'blur'
                )
            );

        return in_array(
            $value,
            self::BACKGROUND_MODES,
            true
        )
            ? $value
            : 'blur';
    }


    /**
     * Get validated background color.
     */
    private function getBackgroundColor(): string
    {
        $value =
            strtoupper(
                trim(
                    (string) SiteSetting::get(
                        'homepage.slider.background_color',
                        '#111827'
                    )
                )
            );

        return preg_match(
            '/^#[0-9A-F]{6}$/i',
            $value
        )
            ? $value
            : '#111827';
    }


    /**
     * Get validated gradient preset.
     */
    private function getGradient(): string
    {
        $value =
            trim(
                (string) SiteSetting::get(
                    'homepage.slider.gradient',
                    'dark'
                )
            );

        return in_array(
            $value,
            self::GRADIENTS,
            true
        )
            ? $value
            : 'dark';
    }


    /**
     * Get validated image fit.
     */
    private function getImageFit(): string
    {
        $value =
            trim(
                (string) SiteSetting::get(
                    'homepage.slider.image_fit',
                    'contain'
                )
            );

        return in_array(
            $value,
            self::IMAGE_FITS,
            true
        )
            ? $value
            : 'contain';
    }


    /**
     * Get validated image position.
     */
    private function getImagePosition(): string
    {
        $value =
            trim(
                (string) SiteSetting::get(
                    'homepage.slider.image_position',
                    'center center'
                )
            );

        return in_array(
            $value,
            self::IMAGE_POSITIONS,
            true
        )
            ? $value
            : 'center center';
    }


    /**
     * Success message.
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
                'تنظیمات اسلایدر با موفقیت ذخیره شد.',

            default =>
                null,
        };
    }
}
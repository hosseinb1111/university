<?php

declare(strict_types=1);

/**
 * Sadra Application Configuration
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Application
    |--------------------------------------------------------------------------
    */

    'name' => env(
        'APP_NAME',
        'موسسه آموزش عالی صدرالمتالهین'
    ),

    'short_name' => env(
        'APP_SHORT_NAME',
        'صدرا'
    ),

    'environment' => env(
        'APP_ENV',
        'local'
    ),

    'debug' => filter_var(
        env(
            'APP_DEBUG',
            'true'
        ),
        FILTER_VALIDATE_BOOLEAN
    ),


    /*
    |--------------------------------------------------------------------------
    | URL
    |--------------------------------------------------------------------------
    */

    /*
     * IMPORTANT:
     *
     * When running:
     *
     * php -S localhost:8000 -t public
     *
     * the public folder is already the web root.
     *
     * DO NOT include /public
     */

    'url' => rtrim(
        env(
            'APP_URL',
            'http://localhost:8000'
        ),
        '/'
    ),



    /*
    |--------------------------------------------------------------------------
    | Localization
    |--------------------------------------------------------------------------
    */

    'locale' => 'fa',

    'fallback_locale' => 'en',

    'timezone' => 'Asia/Tehran',

    'direction' => 'rtl',



    /*
    |--------------------------------------------------------------------------
    | Session
    |--------------------------------------------------------------------------
    */

    'session' => [

        'name' => 'sadra_session',

        'lifetime' => 120,

        'secure' => false,

        'http_only' => true,

        'same_site' => 'Lax',

    ],



    /*
    |--------------------------------------------------------------------------
    | Security
    |--------------------------------------------------------------------------
    */

    'security' => [

        'password_algorithm' => PASSWORD_DEFAULT,

        'minimum_password_length' => 8,

        'csrf_token_bytes' => 32,

    ],



    /*
    |--------------------------------------------------------------------------
    | Assets
    |--------------------------------------------------------------------------
    */

    'assets' => [

        /*
         * Public folder is already root.
         */

        'path' => '/assets',

    ],



    /*
    |--------------------------------------------------------------------------
    | Uploads
    |--------------------------------------------------------------------------
    */

    'uploads' => [

        'directory' => 'storage/uploads',

        'max_file_size' => 10 * 1024 * 1024,

        'max_document_size' => 10 * 1024 * 1024,

        'max_image_size' => 5 * 1024 * 1024,


        'allowed_images' => [

            'image/jpeg',

            'image/png',

            'image/webp',

        ],


        'allowed_documents' => [

            'application/pdf',

            'application/msword',

            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',

            'application/vnd.ms-excel',

            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',

        ],


        'documents_directory'
            => 'storage/uploads/documents',


        'images_directory'
            => 'storage/uploads/images',


        'media_directory'
            => 'storage/uploads/media',

    ],



    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    'pagination' => [

        'default_per_page' => 12,

        'max_per_page' => 100,

    ],



    /*
    |--------------------------------------------------------------------------
    | SEO
    |--------------------------------------------------------------------------
    */

    'seo' => [

        'default_title'
            => 'موسسه آموزش عالی صدرالمتالهین (صدرا)',


        'default_description'
            => 'موسسه آموزش عالی صدرالمتالهین تهران',


        'default_keywords'
            => 'دانشگاه صدرا، موسسه آموزش عالی صدرا',


        'robots'
            => 'index,follow',

        'twitter_card'
            => 'summary',

    ],



    /*
    |--------------------------------------------------------------------------
    | External Services
    |--------------------------------------------------------------------------
    */

    'external_services' => [

        'webmail'
            => 'http://webmail.sadra.ac.ir/',


        'university_system'
            => 'http://samaneh.sadra.ac.ir/',


        'teacher_panel_legacy'
            => 'https://sadra.ac.ir/teacherpanel.php',

    ],



    /*
    |--------------------------------------------------------------------------
    | Contact
    |--------------------------------------------------------------------------
    */

    'contact' => [

        'email'
            => 'info@sadra.ac.ir',


        'phone'
            => '02140445580',


        'fax'
            => '02140445917',


        'address'
            => 'تهران، ایران',

    ],


];
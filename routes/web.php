<?php

declare(strict_types=1);

use App\Controllers\AnnouncementController;
use App\Controllers\DocumentController;
use App\Controllers\EnglishController;
use App\Controllers\FacultyController;
use App\Controllers\HomeController;
use App\Controllers\MediaController;
use App\Controllers\NavigationController;
use App\Controllers\PageController;
use App\Controllers\PeopleController;
use App\Controllers\ProgramController;
use App\Controllers\PublicSectionController;
use App\Controllers\ResearchCenterController;
use App\Controllers\SearchController;
use App\Controllers\SeoController;
use App\Controllers\TeacherController;
use App\Controllers\UserController;
use App\Controllers\HomepageSlideController;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Router;
use App\Core\Session;
use App\Core\View;

use App\Middleware\RequireAuth;
use App\Middleware\RequireRole;

use App\Models\User;


/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/

$homeController =
    new HomeController();

$teacherController =
    new TeacherController();

$userController =
    new UserController();

$announcementController =
    new AnnouncementController();

$pageController =
    new PageController();

$navigationController =
    new NavigationController();

$documentController =
    new DocumentController();

$mediaController =
    new MediaController();

$facultyController =
    new FacultyController();

$programController =
    new ProgramController();

$peopleController =
    new PeopleController();

$researchCenterController =
    new ResearchCenterController();

$publicSectionController =
    new PublicSectionController();

$searchController =
    new SearchController();

$seoController =
    new SeoController();

$englishController =
    new EnglishController();

$homepageSlideController =
    new HomepageSlideController();


/*
|--------------------------------------------------------------------------
| MIDDLEWARE
|--------------------------------------------------------------------------
*/

$teacherMiddleware = [
    RequireAuth::class,
];

$contentAdminMiddleware = [
    RequireAuth::class,

    new RequireRole([
        'super_admin',
        'admin',
        'editor',
    ]),
];

$userAdminMiddleware = [
    RequireAuth::class,

    new RequireRole([
        'super_admin',
        'admin',
    ]),
];


/*
|--------------------------------------------------------------------------
| PUBLIC HOME
|--------------------------------------------------------------------------
*/

Router::get(
    '/',
    [
        $homeController,
        'index',
    ],
    'home'
);


/*
|--------------------------------------------------------------------------
| PUBLIC INSTITUTIONAL SECTIONS
|--------------------------------------------------------------------------
*/

Router::get(
    '/about',
    [
        $publicSectionController,
        'about',
    ],
    'about'
);

Router::get(
    '/presidency',
    [
        $publicSectionController,
        'presidency',
    ],
    'presidency'
);

Router::get(
    '/education',
    [
        $publicSectionController,
        'education',
    ],
    'education'
);

Router::get(
    '/student-affairs',
    [
        $publicSectionController,
        'studentAffairs',
    ],
    'student-affairs'
);

Router::get(
    '/support',
    [
        $publicSectionController,
        'support',
    ],
    'support'
);

Router::get(
    '/contact',
    [
        $publicSectionController,
        'contact',
    ],
    'contact'
);


/*
|--------------------------------------------------------------------------
| PUBLIC SEARCH
|--------------------------------------------------------------------------
*/

Router::get(
    '/search',
    [
        $searchController,
        'index',
    ],
    'search'
);


/*
|--------------------------------------------------------------------------
| PUBLIC ANNOUNCEMENTS
|--------------------------------------------------------------------------
*/

Router::get(
    '/announcements',
    [
        $announcementController,
        'publicIndex',
    ],
    'announcements.index'
);

Router::get(
    '/announcements/{slug}',
    [
        $announcementController,
        'show',
    ],
    'announcement.show'
);


/*
|--------------------------------------------------------------------------
| PUBLIC CMS PAGES
|--------------------------------------------------------------------------
*/

Router::get(
    '/pages/{slug}',
    [
        $pageController,
        'show',
    ],
    'pages.show'
);


/*
|--------------------------------------------------------------------------
| PUBLIC FACULTIES
|--------------------------------------------------------------------------
*/

Router::get(
    '/faculties',
    [
        $facultyController,
        'publicIndex',
    ],
    'faculties.index'
);

Router::get(
    '/faculties/{slug}',
    [
        $facultyController,
        'show',
    ],
    'faculties.show'
);


/*
|--------------------------------------------------------------------------
| PUBLIC PROGRAMS
|--------------------------------------------------------------------------
*/

Router::get(
    '/programs',
    [
        $programController,
        'publicIndex',
    ],
    'programs.index'
);

Router::get(
    '/programs/{slug}',
    [
        $programController,
        'show',
    ],
    'programs.show'
);


/*
|--------------------------------------------------------------------------
| PUBLIC PEOPLE
|--------------------------------------------------------------------------
*/

Router::get(
    '/people',
    [
        $peopleController,
        'publicIndex',
    ],
    'people.index'
);

Router::get(
    '/people/{id}',
    [
        $peopleController,
        'show',
    ],
    'people.show'
);


/*
|--------------------------------------------------------------------------
| PUBLIC RESEARCH CENTERS
|--------------------------------------------------------------------------
*/

Router::get(
    '/research-centers',
    [
        $researchCenterController,
        'publicIndex',
    ],
    'research-centers.index'
);

Router::get(
    '/research-centers/{slug}',
    [
        $researchCenterController,
        'show',
    ],
    'research-centers.show'
);


/*
|--------------------------------------------------------------------------
| PUBLIC DOCUMENTS
|--------------------------------------------------------------------------
*/

Router::get(
    '/documents',
    [
        $documentController,
        'publicIndex',
    ],
    'documents.index'
);

Router::get(
    '/documents/{category}',
    [
        $documentController,
        'category',
    ],
    'documents.category'
);

Router::get(
    '/documents/{category}/{id}',
    [
        $documentController,
        'download',
    ],
    'documents.download'
);


/*
|--------------------------------------------------------------------------
| PUBLIC MEDIA
|--------------------------------------------------------------------------
*/

Router::get(
    '/media/{encodedPath}',
    [
        $mediaController,
        'serve',
    ],
    'media.serve'
);


/*
|--------------------------------------------------------------------------
| SEO / DISCOVERY
|--------------------------------------------------------------------------
*/

Router::get(
    '/sitemap.xml',
    [
        $seoController,
        'sitemap',
    ],
    'seo.sitemap'
);

Router::get(
    '/robots.txt',
    [
        $seoController,
        'robots',
    ],
    'seo.robots'
);


/*
|--------------------------------------------------------------------------
| ENGLISH SITE
|--------------------------------------------------------------------------
*/

Router::get(
    '/english',
    [
        $englishController,
        'index',
    ],
    'english.home'
);

Router::get(
    '/english/about',
    [
        $englishController,
        'about',
    ],
    'english.about'
);

Router::get(
    '/english/presidency',
    [
        $englishController,
        'presidency',
    ],
    'english.presidency'
);

Router::get(
    '/english/faculties',
    [
        $englishController,
        'faculties',
    ],
    'english.faculties'
);

Router::get(
    '/english/research',
    [
        $englishController,
        'research',
    ],
    'english.research'
);

Router::get(
    '/english/announcements',
    [
        $englishController,
        'announcements',
    ],
    'english.announcements'
);

Router::get(
    '/english/contact',
    [
        $englishController,
        'contact',
    ],
    'english.contact'
);


/*
|--------------------------------------------------------------------------
| TEACHER LOGIN
|--------------------------------------------------------------------------
*/

Router::get(
    '/teacher/login',
    static function (): string {
        if (
            Session::authenticated()
        ) {
            Response::redirectRoute(
                'teacher.dashboard'
            );
        }

        return View::renderIntoLayout(
            'layouts/app',
            'teacher/login',
            [
                'title' =>
                    'ورود اعضای هیئت علمی | صدرا',
            ]
        );
    },
    'teacher.login'
);

Router::post(
    '/teacher/login',
    static function (): never {
        Csrf::requireValid();

        $username =
            trim(
                (string) (
                    $_POST['username']
                    ?? ''
                )
            );

        $password =
            (string) (
                $_POST['password']
                ?? ''
            );

        if (
            $username === ''
            || $password === ''
        ) {
            Session::flash(
                'error',
                'لطفاً نام کاربری و رمز عبور را وارد کنید.'
            );

            Response::redirectRoute(
                'teacher.login'
            );
        }

        $user =
            User::authenticate(
                $username,
                $password
            );

        if (
            $user === null
        ) {
            Session::flash(
                'error',
                'نام کاربری یا رمز عبور صحیح نیست.'
            );

            Response::redirectRoute(
                'teacher.login'
            );
        }

        $role =
            (string) (
                $user['role']
                ?? ''
            );

        if (
            !in_array(
                $role,
                [
                    'teacher',
                    'admin',
                    'editor',
                    'super_admin',
                ],
                true
            )
        ) {
            Session::flash(
                'error',
                'این حساب اجازه ورود به سامانه را ندارد.'
            );

            Response::redirectRoute(
                'teacher.login'
            );
        }

        Session::login(
            (int) $user['id']
        );

        Csrf::regenerate();

        $intended =
            Session::pullIntendedUrl(
                Router::route(
                    'teacher.dashboard'
                )
            );

        Response::redirect(
            $intended
        );
    },
    'teacher.login.submit'
);


/*
|--------------------------------------------------------------------------
| PASSWORD RECOVERY
|--------------------------------------------------------------------------
*/

Router::get(
    '/teacher/forgot-password',
    static function (): string {
        return View::renderIntoLayout(
            'layouts/app',
            'teacher/forgot-password',
            [
                'title' =>
                    'بازیابی رمز عبور | صدرا',
            ]
        );
    },
    'teacher.password.request'
);

Router::post(
    '/teacher/forgot-password',
    static function (): never {
        Csrf::requireValid();

        $email =
            trim(
                (string) (
                    $_POST['email']
                    ?? ''
                )
            );

        if (
            filter_var(
                $email,
                FILTER_VALIDATE_EMAIL
            ) === false
        ) {
            Session::flash(
                'error',
                'لطفاً یک پست الکترونیکی معتبر وارد کنید.'
            );

            Response::redirectRoute(
                'teacher.password.request'
            );
        }

        /*
         * Password-reset email delivery will be implemented
         * by the password recovery service.
         *
         * We deliberately return the same response whether
         * the email belongs to an account or not.
         */
        Session::flash(
            'success',
            'اگر حسابی با این ایمیل وجود داشته باشد، لینک بازیابی ارسال خواهد شد.'
        );

        Response::redirectRoute(
            'teacher.password.request'
        );
    },
    'teacher.password.email'
);


/*
|--------------------------------------------------------------------------
| TEACHER PANEL
|--------------------------------------------------------------------------
*/

Router::get(
    '/teacher',
    [
        $teacherController,
        'dashboard',
    ],
    'teacher.root',
    $teacherMiddleware
);

Router::get(
    '/teacher/dashboard',
    [
        $teacherController,
        'dashboard',
    ],
    'teacher.dashboard',
    $teacherMiddleware
);

Router::get(
    '/teacher/profile',
    [
        $teacherController,
        'profile',
    ],
    'teacher.profile',
    $teacherMiddleware
);

Router::post(
    '/teacher/profile',
    [
        $teacherController,
        'updateProfile',
    ],
    'teacher.profile.update',
    $teacherMiddleware
);

Router::post(
    '/teacher/profile/password',
    [
        $teacherController,
        'changePassword',
    ],
    'teacher.password.update',
    $teacherMiddleware
);

Router::post(
    '/teacher/logout',
    [
        $teacherController,
        'logout',
    ],
    'teacher.logout',
    $teacherMiddleware
);


/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin',
    static function (): string {
        $user =
            Session::user();

        if (
            $user === null
        ) {
            Response::redirectRoute(
                'teacher.login'
            );
        }

        return View::renderIntoLayout(
            'layouts/admin',
            'admin/dashboard',
            [
                'title' =>
                    'داشبورد مدیریت | صدرا',

                'user' =>
                    User::publicData(
                        $user
                    ),
            ]
        );
    },
    'admin.dashboard',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ADMIN ANNOUNCEMENTS
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/announcements',
    [
        $announcementController,
        'index',
    ],
    'admin.announcements.index',
    $contentAdminMiddleware
);

Router::get(
    '/admin/announcements/create',
    [
        $announcementController,
        'create',
    ],
    'admin.announcements.create',
    $contentAdminMiddleware
);

Router::post(
    '/admin/announcements',
    [
        $announcementController,
        'store',
    ],
    'admin.announcements.store',
    $contentAdminMiddleware
);

Router::get(
    '/admin/announcements/{id}/edit',
    [
        $announcementController,
        'edit',
    ],
    'admin.announcements.edit',
    $contentAdminMiddleware
);

Router::post(
    '/admin/announcements/{id}',
    [
        $announcementController,
        'update',
    ],
    'admin.announcements.update',
    $contentAdminMiddleware
);

Router::post(
    '/admin/announcements/{id}/delete',
    [
        $announcementController,
        'delete',
    ],
    'admin.announcements.delete',
    $contentAdminMiddleware
);

Router::post(
    '/admin/announcements/{id}/publish',
    [
        $announcementController,
        'publish',
    ],
    'admin.announcements.publish',
    $contentAdminMiddleware
);

Router::post(
    '/admin/announcements/{id}/archive',
    [
        $announcementController,
        'archive',
    ],
    'admin.announcements.archive',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ADMIN PAGES
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/pages',
    [
        $pageController,
        'index',
    ],
    'admin.pages.index',
    $contentAdminMiddleware
);

Router::get(
    '/admin/pages/create',
    [
        $pageController,
        'create',
    ],
    'admin.pages.create',
    $contentAdminMiddleware
);

Router::post(
    '/admin/pages',
    [
        $pageController,
        'store',
    ],
    'admin.pages.store',
    $contentAdminMiddleware
);

Router::get(
    '/admin/pages/{id}/edit',
    [
        $pageController,
        'edit',
    ],
    'admin.pages.edit',
    $contentAdminMiddleware
);

Router::post(
    '/admin/pages/{id}',
    [
        $pageController,
        'update',
    ],
    'admin.pages.update',
    $contentAdminMiddleware
);

Router::post(
    '/admin/pages/{id}/delete',
    [
        $pageController,
        'delete',
    ],
    'admin.pages.delete',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ADMIN NAVIGATION
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/navigation',
    [
        $navigationController,
        'index',
    ],
    'admin.navigation.index',
    $contentAdminMiddleware
);

Router::get(
    '/admin/navigation/create',
    [
        $navigationController,
        'create',
    ],
    'admin.navigation.create',
    $contentAdminMiddleware
);

Router::post(
    '/admin/navigation',
    [
        $navigationController,
        'store',
    ],
    'admin.navigation.store',
    $contentAdminMiddleware
);

Router::get(
    '/admin/navigation/{id}/edit',
    [
        $navigationController,
        'edit',
    ],
    'admin.navigation.edit',
    $contentAdminMiddleware
);

Router::post(
    '/admin/navigation/{id}',
    [
        $navigationController,
        'update',
    ],
    'admin.navigation.update',
    $contentAdminMiddleware
);

Router::post(
    '/admin/navigation/{id}/delete',
    [
        $navigationController,
        'delete',
    ],
    'admin.navigation.delete',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ADMIN DOCUMENTS
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/documents',
    [
        $documentController,
        'index',
    ],
    'admin.documents.index',
    $contentAdminMiddleware
);

Router::get(
    '/admin/documents/create',
    [
        $documentController,
        'create',
    ],
    'admin.documents.create',
    $contentAdminMiddleware
);

Router::post(
    '/admin/documents',
    [
        $documentController,
        'store',
    ],
    'admin.documents.store',
    $contentAdminMiddleware
);

Router::get(
    '/admin/documents/{id}/edit',
    [
        $documentController,
        'edit',
    ],
    'admin.documents.edit',
    $contentAdminMiddleware
);

Router::post(
    '/admin/documents/{id}',
    [
        $documentController,
        'update',
    ],
    'admin.documents.update',
    $contentAdminMiddleware
);

Router::post(
    '/admin/documents/{id}/delete',
    [
        $documentController,
        'delete',
    ],
    'admin.documents.delete',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ADMIN MEDIA
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/media',
    [
        $mediaController,
        'index',
    ],
    'admin.media.index',
    $contentAdminMiddleware
);

Router::get(
    '/admin/media/create',
    [
        $mediaController,
        'create',
    ],
    'admin.media.create',
    $contentAdminMiddleware
);

Router::post(
    '/admin/media',
    [
        $mediaController,
        'store',
    ],
    'admin.media.store',
    $contentAdminMiddleware
);

Router::post(
    '/admin/media/{id}/delete',
    [
        $mediaController,
        'delete',
    ],
    'admin.media.delete',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ADMIN HOMEPAGE SLIDES
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/slides',
    [
        $homepageSlideController,
        'index',
    ],
    'admin.slides.index',
    $contentAdminMiddleware
);

Router::get(
    '/admin/slides/create',
    [
        $homepageSlideController,
        'create',
    ],
    'admin.slides.create',
    $contentAdminMiddleware
);

Router::post(
    '/admin/slides',
    [
        $homepageSlideController,
        'store',
    ],
    'admin.slides.store',
    $contentAdminMiddleware
);

Router::get(
    '/admin/slides/{id}/edit',
    [
        $homepageSlideController,
        'edit',
    ],
    'admin.slides.edit',
    $contentAdminMiddleware
);

Router::post(
    '/admin/slides/{id}',
    [
        $homepageSlideController,
        'update',
    ],
    'admin.slides.update',
    $contentAdminMiddleware
);

Router::post(
    '/admin/slides/{id}/delete',
    [
        $homepageSlideController,
        'delete',
    ],
    'admin.slides.delete',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ADMIN FACULTIES
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/faculties',
    [
        $facultyController,
        'index',
    ],
    'admin.faculties.index',
    $contentAdminMiddleware
);

Router::get(
    '/admin/faculties/create',
    [
        $facultyController,
        'create',
    ],
    'admin.faculties.create',
    $contentAdminMiddleware
);

Router::post(
    '/admin/faculties',
    [
        $facultyController,
        'store',
    ],
    'admin.faculties.store',
    $contentAdminMiddleware
);

Router::get(
    '/admin/faculties/{id}/edit',
    [
        $facultyController,
        'edit',
    ],
    'admin.faculties.edit',
    $contentAdminMiddleware
);

Router::post(
    '/admin/faculties/{id}',
    [
        $facultyController,
        'update',
    ],
    'admin.faculties.update',
    $contentAdminMiddleware
);

Router::post(
    '/admin/faculties/{id}/delete',
    [
        $facultyController,
        'delete',
    ],
    'admin.faculties.delete',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ADMIN PROGRAMS
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/programs',
    [
        $programController,
        'index',
    ],
    'admin.programs.index',
    $contentAdminMiddleware
);

Router::get(
    '/admin/programs/create',
    [
        $programController,
        'create',
    ],
    'admin.programs.create',
    $contentAdminMiddleware
);

Router::post(
    '/admin/programs',
    [
        $programController,
        'store',
    ],
    'admin.programs.store',
    $contentAdminMiddleware
);

Router::get(
    '/admin/programs/{id}/edit',
    [
        $programController,
        'edit',
    ],
    'admin.programs.edit',
    $contentAdminMiddleware
);

Router::post(
    '/admin/programs/{id}',
    [
        $programController,
        'update',
    ],
    'admin.programs.update',
    $contentAdminMiddleware
);

Router::post(
    '/admin/programs/{id}/delete',
    [
        $programController,
        'delete',
    ],
    'admin.programs.delete',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ADMIN PEOPLE
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/people',
    [
        $peopleController,
        'index',
    ],
    'admin.people.index',
    $contentAdminMiddleware
);

Router::get(
    '/admin/people/create',
    [
        $peopleController,
        'create',
    ],
    'admin.people.create',
    $contentAdminMiddleware
);

Router::post(
    '/admin/people',
    [
        $peopleController,
        'store',
    ],
    'admin.people.store',
    $contentAdminMiddleware
);

Router::get(
    '/admin/people/{id}/edit',
    [
        $peopleController,
        'edit',
    ],
    'admin.people.edit',
    $contentAdminMiddleware
);

Router::post(
    '/admin/people/{id}',
    [
        $peopleController,
        'update',
    ],
    'admin.people.update',
    $contentAdminMiddleware
);

Router::post(
    '/admin/people/{id}/delete',
    [
        $peopleController,
        'delete',
    ],
    'admin.people.delete',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ADMIN RESEARCH CENTERS
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/research-centers',
    [
        $researchCenterController,
        'index',
    ],
    'admin.research-centers.index',
    $contentAdminMiddleware
);

Router::get(
    '/admin/research-centers/create',
    [
        $researchCenterController,
        'create',
    ],
    'admin.research-centers.create',
    $contentAdminMiddleware
);

Router::post(
    '/admin/research-centers',
    [
        $researchCenterController,
        'store',
    ],
    'admin.research-centers.store',
    $contentAdminMiddleware
);

Router::get(
    '/admin/research-centers/{id}/edit',
    [
        $researchCenterController,
        'edit',
    ],
    'admin.research-centers.edit',
    $contentAdminMiddleware
);

Router::post(
    '/admin/research-centers/{id}',
    [
        $researchCenterController,
        'update',
    ],
    'admin.research-centers.update',
    $contentAdminMiddleware
);

Router::post(
    '/admin/research-centers/{id}/delete',
    [
        $researchCenterController,
        'delete',
    ],
    'admin.research-centers.delete',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ADMIN USERS
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/users',
    [
        $userController,
        'index',
    ],
    'admin.users.index',
    $userAdminMiddleware
);

Router::get(
    '/admin/users/create',
    [
        $userController,
        'create',
    ],
    'admin.users.create',
    $userAdminMiddleware
);

Router::post(
    '/admin/users',
    [
        $userController,
        'store',
    ],
    'admin.users.store',
    $userAdminMiddleware
);

Router::get(
    '/admin/users/{id}/edit',
    [
        $userController,
        'edit',
    ],
    'admin.users.edit',
    $userAdminMiddleware
);

Router::post(
    '/admin/users/{id}',
    [
        $userController,
        'update',
    ],
    'admin.users.update',
    $userAdminMiddleware
);

Router::post(
    '/admin/users/{id}/delete',
    [
        $userController,
        'delete',
    ],
    'admin.users.delete',
    $userAdminMiddleware
);
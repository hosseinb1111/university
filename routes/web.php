<?php

declare(strict_types=1);

use App\Controllers\AnnouncementController;
use App\Controllers\DocumentController;
use App\Controllers\EnglishAdminController;
use App\Controllers\EnglishAnnouncementController;
use App\Controllers\EnglishController;
use App\Controllers\EnglishFacultyController;
use App\Controllers\EnglishHomepageServiceController;
use App\Controllers\EnglishHomepageSlideController;
use App\Controllers\EnglishPeopleController;
use App\Controllers\EnglishProgramController;
use App\Controllers\EnglishResearchCenterController;
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
use App\Controllers\HomepageServiceController;
use App\Controllers\SliderSettingsController;
use App\Controllers\SiteSettingController;

use App\Core\Csrf;
use App\Core\Response;
use App\Core\Router;
use App\Core\Session;
use App\Core\View;

use App\Middleware\RequireAuth;
use App\Middleware\RequireRole;

use App\Models\Announcement;
use App\Models\Document;
use App\Models\Faculty;
use App\Models\HomepageService;
use App\Models\HomepageSlide;
use App\Models\Page;
use App\Models\People;
use App\Models\Program;
use App\Models\ResearchCenter;
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

$englishAdminController =
    new EnglishAdminController();

$englishAnnouncementController =
    new EnglishAnnouncementController();

$englishFacultyController =
    new EnglishFacultyController();

$englishProgramController =
    new EnglishProgramController();

$englishPeopleController =
    new EnglishPeopleController();

$englishResearchCenterController =
    new EnglishResearchCenterController();

$englishHomepageSlideController =
    new EnglishHomepageSlideController();

$englishHomepageServiceController =
    new EnglishHomepageServiceController();

$homepageSlideController =
    new HomepageSlideController();

$homepageServiceController =
    new HomepageServiceController();

$sliderSettingsController =
    new SliderSettingsController();

$siteSettingController =
    new SiteSettingController();


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
| ENGLISH PUBLIC SITE
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| English Home
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


/*
|--------------------------------------------------------------------------
| English About
|--------------------------------------------------------------------------
*/

Router::get(
    '/english/about',
    [
        $englishController,
        'about',
    ],
    'english.about'
);


/*
|--------------------------------------------------------------------------
| English Presidency
|--------------------------------------------------------------------------
*/

Router::get(
    '/english/presidency',
    [
        $englishController,
        'presidency',
    ],
    'english.presidency'
);


/*
|--------------------------------------------------------------------------
| English Faculties
|--------------------------------------------------------------------------
|
| IMPORTANT:
|
| Public English faculty pages intentionally use EnglishController.
| EnglishFacultyController is the ADMIN controller.
|
*/

Router::get(
    '/english/faculties',
    [
        $englishController,
        'faculties',
    ],
    'english.faculties'
);


/*
|--------------------------------------------------------------------------
| English Faculty Details
|--------------------------------------------------------------------------
*/

Router::get(
    '/english/faculties/{slug}',
    [
        $englishController,
        'faculty',
    ],
    'english.faculty.show'
);


/*
|--------------------------------------------------------------------------
| English Programs
|--------------------------------------------------------------------------
*/

Router::get(
    '/english/programs',
    [
        $englishController,
        'programs',
    ],
    'english.programs'
);


/*
|--------------------------------------------------------------------------
| English Program Details
|--------------------------------------------------------------------------
*/

Router::get(
    '/english/programs/{slug}',
    [
        $englishController,
        'program',
    ],
    'english.program.show'
);


/*
|--------------------------------------------------------------------------
| English Research
|--------------------------------------------------------------------------
*/

Router::get(
    '/english/research',
    [
        $englishController,
        'research',
    ],
    'english.research'
);


/*
|--------------------------------------------------------------------------
| English Announcements
|--------------------------------------------------------------------------
*/

Router::get(
    '/english/announcements',
    [
        $englishController,
        'announcements',
    ],
    'english.announcements'
);


/*
|--------------------------------------------------------------------------
| English Announcement Details
|--------------------------------------------------------------------------
*/

Router::get(
    '/english/announcements/{slug}',
    [
        $englishController,
        'announcement',
    ],
    'english.announcement.show'
);


/*
|--------------------------------------------------------------------------
| English Contact
|--------------------------------------------------------------------------
*/

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


        /*
        |--------------------------------------------------------------------------
        | Dashboard statistics
        |--------------------------------------------------------------------------
        */

        $stats = [
            'announcements' =>
                0,

            'pages' =>
                0,

            'documents' =>
                0,

            'faculties' =>
                0,

            'programs' =>
                0,

            'people' =>
                0,

            'researchCenters' =>
                0,

            'slides' =>
                0,

            'services' =>
                0,
        ];


        /*
        |--------------------------------------------------------------------------
        | Announcements
        |--------------------------------------------------------------------------
        */

        try {

            if (
                method_exists(
                    Announcement::class,
                    'count'
                )
            ) {

                $stats['announcements'] =
                    (int) Announcement::count();

            } elseif (
                method_exists(
                    Announcement::class,
                    'paginate'
                )
            ) {

                $result =
                    Announcement::paginate(
                        1,
                        1
                    );

                if (
                    is_array($result)
                ) {

                    $stats['announcements'] =
                        (int) (
                            $result['total']
                            ?? 0
                        );
                }
            }

        } catch (
            \Throwable $e
        ) {

            error_log(
                'Dashboard announcements count failed: '
                . $e->getMessage()
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Pages
        |--------------------------------------------------------------------------
        */

        try {

            if (
                method_exists(
                    Page::class,
                    'count'
                )
            ) {

                $stats['pages'] =
                    (int) Page::count();

            } elseif (
                method_exists(
                    Page::class,
                    'paginate'
                )
            ) {

                $result =
                    Page::paginate(
                        1,
                        1
                    );

                if (
                    is_array($result)
                ) {

                    $stats['pages'] =
                        (int) (
                            $result['total']
                            ?? 0
                        );
                }
            }

        } catch (
            \Throwable $e
        ) {

            error_log(
                'Dashboard pages count failed: '
                . $e->getMessage()
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Documents
        |--------------------------------------------------------------------------
        */

        try {

            if (
                method_exists(
                    Document::class,
                    'count'
                )
            ) {

                $stats['documents'] =
                    (int) Document::count();

            } elseif (
                method_exists(
                    Document::class,
                    'paginate'
                )
            ) {

                $result =
                    Document::paginate(
                        1,
                        1
                    );

                if (
                    is_array($result)
                ) {

                    $stats['documents'] =
                        (int) (
                            $result['total']
                            ?? 0
                        );
                }
            }

        } catch (
            \Throwable $e
        ) {

            error_log(
                'Dashboard documents count failed: '
                . $e->getMessage()
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Faculties
        |--------------------------------------------------------------------------
        */

        try {

            if (
                method_exists(
                    Faculty::class,
                    'countActive'
                )
            ) {

                $stats['faculties'] =
                    (int) Faculty::countActive();

            } elseif (
                method_exists(
                    Faculty::class,
                    'active'
                )
            ) {

                $result =
                    Faculty::active();

                if (
                    is_array($result)
                ) {

                    $stats['faculties'] =
                        count($result);
                }
            }

        } catch (
            \Throwable $e
        ) {

            error_log(
                'Dashboard faculties count failed: '
                . $e->getMessage()
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Programs
        |--------------------------------------------------------------------------
        */

        try {

            if (
                method_exists(
                    Program::class,
                    'countActive'
                )
            ) {

                $stats['programs'] =
                    (int) Program::countActive();

            } elseif (
                method_exists(
                    Program::class,
                    'active'
                )
            ) {

                $result =
                    Program::active();

                if (
                    is_array($result)
                ) {

                    $stats['programs'] =
                        count($result);
                }
            }

        } catch (
            \Throwable $e
        ) {

            error_log(
                'Dashboard programs count failed: '
                . $e->getMessage()
            );
        }


        /*
        |--------------------------------------------------------------------------
        | People
        |--------------------------------------------------------------------------
        */

        try {

            if (
                method_exists(
                    People::class,
                    'countActive'
                )
            ) {

                $stats['people'] =
                    (int) People::countActive();

            } elseif (
                method_exists(
                    People::class,
                    'active'
                )
            ) {

                $result =
                    People::active();

                if (
                    is_array($result)
                ) {

                    $stats['people'] =
                        count($result);
                }
            }

        } catch (
            \Throwable $e
        ) {

            error_log(
                'Dashboard people count failed: '
                . $e->getMessage()
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Research Centers
        |--------------------------------------------------------------------------
        */

        try {

            if (
                method_exists(
                    ResearchCenter::class,
                    'countActive'
                )
            ) {

                $stats['researchCenters'] =
                    (int) ResearchCenter::countActive();

            } elseif (
                method_exists(
                    ResearchCenter::class,
                    'active'
                )
            ) {

                $result =
                    ResearchCenter::active();

                if (
                    is_array($result)
                ) {

                    $stats['researchCenters'] =
                        count($result);
                }
            }

        } catch (
            \Throwable $e
        ) {

            error_log(
                'Dashboard research centers count failed: '
                . $e->getMessage()
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Homepage Slides
        |--------------------------------------------------------------------------
        */

        try {

            if (
                method_exists(
                    HomepageSlide::class,
                    'count'
                )
            ) {

                $stats['slides'] =
                    (int) HomepageSlide::count();

            } elseif (
                method_exists(
                    HomepageSlide::class,
                    'latest'
                )
            ) {

                $result =
                    HomepageSlide::latest(
                        1000
                    );

                if (
                    is_array($result)
                ) {

                    $stats['slides'] =
                        count($result);
                }
            }

        } catch (
            \Throwable $e
        ) {

            error_log(
                'Dashboard slides count failed: '
                . $e->getMessage()
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Homepage Services
        |--------------------------------------------------------------------------
        */

        try {

            if (
                method_exists(
                    HomepageService::class,
                    'count'
                )
            ) {

                $stats['services'] =
                    (int) HomepageService::count();

            } elseif (
                method_exists(
                    HomepageService::class,
                    'latest'
                )
            ) {

                $result =
                    HomepageService::latest(
                        1000
                    );

                if (
                    is_array($result)
                ) {

                    $stats['services'] =
                        count($result);
                }
            }

        } catch (
            \Throwable $e
        ) {

            error_log(
                'Dashboard services count failed: '
                . $e->getMessage()
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

                'stats' =>
                    $stats,
            ]
        );
    },
    'admin.dashboard',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ENGLISH ADMIN
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/english',
    [
        $englishAdminController,
        'index',
    ],
    'admin.english',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ENGLISH ADMIN HOMEPAGE
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/english/home',
    [
        $englishAdminController,
        'home',
    ],
    'admin.english.home',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/home',
    [
        $englishAdminController,
        'updateHome',
    ],
    'admin.english.home.update',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ENGLISH ADMIN SLIDER
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/english/slider',
    [
        $englishAdminController,
        'slider',
    ],
    'admin.english.slider',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/slider',
    [
        $englishAdminController,
        'updateSlider',
    ],
    'admin.english.slider.update',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ENGLISH ADMIN HOMEPAGE SLIDES
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/english/slides',
    [
        $englishHomepageSlideController,
        'index',
    ],
    'admin.english.slides.index',
    $contentAdminMiddleware
);

Router::get(
    '/admin/english/slides/create',
    [
        $englishHomepageSlideController,
        'create',
    ],
    'admin.english.slides.create',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/slides',
    [
        $englishHomepageSlideController,
        'store',
    ],
    'admin.english.slides.store',
    $contentAdminMiddleware
);

Router::get(
    '/admin/english/slides/{id}/edit',
    [
        $englishHomepageSlideController,
        'edit',
    ],
    'admin.english.slides.edit',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/slides/{id}',
    [
        $englishHomepageSlideController,
        'update',
    ],
    'admin.english.slides.update',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/slides/{id}/delete',
    [
        $englishHomepageSlideController,
        'delete',
    ],
    'admin.english.slides.delete',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ENGLISH ADMIN HOMEPAGE SERVICES
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/english/services',
    [
        $englishHomepageServiceController,
        'index',
    ],
    'admin.english.services.index',
    $contentAdminMiddleware
);

Router::get(
    '/admin/english/services/create',
    [
        $englishHomepageServiceController,
        'create',
    ],
    'admin.english.services.create',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/services',
    [
        $englishHomepageServiceController,
        'store',
    ],
    'admin.english.services.store',
    $contentAdminMiddleware
);

Router::get(
    '/admin/english/services/{id}/edit',
    [
        $englishHomepageServiceController,
        'edit',
    ],
    'admin.english.services.edit',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/services/{id}',
    [
        $englishHomepageServiceController,
        'update',
    ],
    'admin.english.services.update',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/services/{id}/delete',
    [
        $englishHomepageServiceController,
        'delete',
    ],
    'admin.english.services.delete',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ENGLISH ADMIN STATIC PAGES
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/english/pages/{page}',
    [
        $englishAdminController,
        'page',
    ],
    'admin.english.page',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/pages/{page}',
    [
        $englishAdminController,
        'updatePage',
    ],
    'admin.english.page.update',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ENGLISH ADMIN ANNOUNCEMENTS
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/english/announcements',
    [
        $englishAnnouncementController,
        'index',
    ],
    'admin.english.announcements.index',
    $contentAdminMiddleware
);

Router::get(
    '/admin/english/announcements/create',
    [
        $englishAnnouncementController,
        'create',
    ],
    'admin.english.announcements.create',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/announcements',
    [
        $englishAnnouncementController,
        'store',
    ],
    'admin.english.announcements.store',
    $contentAdminMiddleware
);

Router::get(
    '/admin/english/announcements/{id}/edit',
    [
        $englishAnnouncementController,
        'edit',
    ],
    'admin.english.announcements.edit',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/announcements/{id}',
    [
        $englishAnnouncementController,
        'update',
    ],
    'admin.english.announcements.update',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/announcements/{id}/delete',
    [
        $englishAnnouncementController,
        'delete',
    ],
    'admin.english.announcements.delete',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/announcements/{id}/publish',
    [
        $englishAnnouncementController,
        'publish',
    ],
    'admin.english.announcements.publish',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/announcements/{id}/archive',
    [
        $englishAnnouncementController,
        'archive',
    ],
    'admin.english.announcements.archive',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ENGLISH ADMIN FACULTIES
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/english/faculties',
    [
        $englishFacultyController,
        'index',
    ],
    'admin.english.faculties.index',
    $contentAdminMiddleware
);

Router::get(
    '/admin/english/faculties/create',
    [
        $englishFacultyController,
        'create',
    ],
    'admin.english.faculties.create',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/faculties',
    [
        $englishFacultyController,
        'store',
    ],
    'admin.english.faculties.store',
    $contentAdminMiddleware
);

Router::get(
    '/admin/english/faculties/{id}/edit',
    [
        $englishFacultyController,
        'edit',
    ],
    'admin.english.faculties.edit',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/faculties/{id}',
    [
        $englishFacultyController,
        'update',
    ],
    'admin.english.faculties.update',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/faculties/{id}/delete',
    [
        $englishFacultyController,
        'delete',
    ],
    'admin.english.faculties.delete',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ENGLISH ADMIN PROGRAMS
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/english/programs',
    [
        $englishProgramController,
        'index',
    ],
    'admin.english.programs.index',
    $contentAdminMiddleware
);

Router::get(
    '/admin/english/programs/create',
    [
        $englishProgramController,
        'create',
    ],
    'admin.english.programs.create',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/programs',
    [
        $englishProgramController,
        'store',
    ],
    'admin.english.programs.store',
    $contentAdminMiddleware
);

Router::get(
    '/admin/english/programs/{id}/edit',
    [
        $englishProgramController,
        'edit',
    ],
    'admin.english.programs.edit',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/programs/{id}',
    [
        $englishProgramController,
        'update',
    ],
    'admin.english.programs.update',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/programs/{id}/delete',
    [
        $englishProgramController,
        'delete',
    ],
    'admin.english.programs.delete',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ENGLISH ADMIN PEOPLE
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/english/people',
    [
        $englishPeopleController,
        'index',
    ],
    'admin.english.people.index',
    $contentAdminMiddleware
);

Router::get(
    '/admin/english/people/create',
    [
        $englishPeopleController,
        'create',
    ],
    'admin.english.people.create',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/people',
    [
        $englishPeopleController,
        'store',
    ],
    'admin.english.people.store',
    $contentAdminMiddleware
);

Router::get(
    '/admin/english/people/{id}/edit',
    [
        $englishPeopleController,
        'edit',
    ],
    'admin.english.people.edit',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/people/{id}',
    [
        $englishPeopleController,
        'update',
    ],
    'admin.english.people.update',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/people/{id}/delete',
    [
        $englishPeopleController,
        'delete',
    ],
    'admin.english.people.delete',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ENGLISH ADMIN RESEARCH CENTERS
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/english/research-centers',
    [
        $englishResearchCenterController,
        'index',
    ],
    'admin.english.research-centers.index',
    $contentAdminMiddleware
);

Router::get(
    '/admin/english/research-centers/create',
    [
        $englishResearchCenterController,
        'create',
    ],
    'admin.english.research-centers.create',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/research-centers',
    [
        $englishResearchCenterController,
        'store',
    ],
    'admin.english.research-centers.store',
    $contentAdminMiddleware
);

Router::get(
    '/admin/english/research-centers/{id}/edit',
    [
        $englishResearchCenterController,
        'edit',
    ],
    'admin.english.research-centers.edit',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/research-centers/{id}',
    [
        $englishResearchCenterController,
        'update',
    ],
    'admin.english.research-centers.update',
    $contentAdminMiddleware
);

Router::post(
    '/admin/english/research-centers/{id}/delete',
    [
        $englishResearchCenterController,
        'delete',
    ],
    'admin.english.research-centers.delete',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ADMIN SETTINGS
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/settings',
    [
        $siteSettingController,
        'index',
    ],
    'admin.settings',
    $contentAdminMiddleware
);

Router::post(
    '/admin/settings',
    [
        $siteSettingController,
        'update',
    ],
    'admin.settings.update',
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
| ADMIN HOMEPAGE SLIDER SETTINGS
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/slider-settings',
    [
        $sliderSettingsController,
        'index',
    ],
    'admin.slider-settings',
    $contentAdminMiddleware
);

Router::post(
    '/admin/slider-settings',
    [
        $sliderSettingsController,
        'update',
    ],
    'admin.slider-settings.update',
    $contentAdminMiddleware
);


/*
|--------------------------------------------------------------------------
| ADMIN HOMEPAGE SERVICES
|--------------------------------------------------------------------------
*/

Router::get(
    '/admin/services',
    [
        $homepageServiceController,
        'index',
    ],
    'admin.services.index',
    $contentAdminMiddleware
);

Router::get(
    '/admin/services/create',
    [
        $homepageServiceController,
        'create',
    ],
    'admin.services.create',
    $contentAdminMiddleware
);

Router::post(
    '/admin/services',
    [
        $homepageServiceController,
        'store',
    ],
    'admin.services.store',
    $contentAdminMiddleware
);

Router::get(
    '/admin/services/{id}/edit',
    [
        $homepageServiceController,
        'edit',
    ],
    'admin.services.edit',
    $contentAdminMiddleware
);

Router::post(
    '/admin/services/{id}',
    [
        $homepageServiceController,
        'update',
    ],
    'admin.services.update',
    $contentAdminMiddleware
);

Router::post(
    '/admin/services/{id}/delete',
    [
        $homepageServiceController,
        'delete',
    ],
    'admin.services.delete',
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
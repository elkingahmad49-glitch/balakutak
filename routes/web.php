<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PostController as FrontPostController;
use App\Http\Controllers\Frontend\LecturerController as FrontLecturerController;
use App\Http\Controllers\Frontend\EventController as FrontEventController;
use App\Http\Controllers\Frontend\GalleryController as FrontGalleryController;
use App\Http\Controllers\Frontend\PageController as FrontFrontPageController;
use App\Http\Controllers\Frontend\FrontPageController as FrontInfoPageController;
use App\Http\Controllers\Frontend\DocumentController as FrontDocumentController;
use App\Http\Controllers\Frontend\FaqController as FrontFaqController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\LecturerController;
use App\Http\Controllers\Admin\CurriculumController;
use App\Http\Controllers\Admin\AcademicCalendarController;
use App\Http\Controllers\Admin\AcademicServiceController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\InfographicController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ResearchServiceController;
use App\Http\Controllers\Admin\SponsorController;
use App\Http\Controllers\Admin\FaqController;

/* |-------------------------------------------------------------------------- | Admin Panel Routes (Protected) |-------------------------------------------------------------------------- */
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', \App\Http\Middleware\AdminLocale::class])->group(function () {

    Route::get('/', [DashboardController::class , 'index'])->name('dashboard');
    Route::get('/stats', [DashboardController::class , 'stats'])->name('stats');

    // Posts / Articles
    Route::post('posts/import', [PostController::class , 'import'])->name('posts.import');
    Route::delete('posts/mass-destroy', [PostController::class , 'massDestroy'])->name('posts.mass-destroy');
    Route::resource('posts', PostController::class);
    Route::patch('posts/{post}/toggle-status', [PostController::class , 'toggleStatus'])->name('posts.toggle-status');

    // Pages
    Route::get('builder-pages', [PageController::class , 'builderIndex'])->name('pages.builder-index');
    Route::get('pages/{page}/builder', [PageController::class , 'builder'])->name('pages.builder');
    Route::post('pages/{page}/builder', [PageController::class , 'saveBuilder'])->name('pages.save-builder');
    Route::resource('pages', PageController::class);

    // Categories & Tags
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);

    // Announcements
    Route::resource('announcements', AnnouncementController::class);

    // Events & Agenda
    Route::resource('events', EventController::class);

    // Lecturers
    Route::post('lecturers/import', [LecturerController::class , 'import'])->name('lecturers.import');
    Route::get('lecturers/template', [LecturerController::class , 'downloadTemplate'])->name('lecturers.template');
    Route::resource('lecturers', LecturerController::class);

    // Curriculum
    Route::post('curriculums/import', [CurriculumController::class , 'import'])->name('curriculums.import');
    Route::get('curriculums/template', [CurriculumController::class , 'downloadTemplate'])->name('curriculums.template');
    Route::resource('curriculums', CurriculumController::class);

    // Academic Calendar
    Route::resource('academic-calendars', AcademicCalendarController::class);

    // Academic Services
    Route::resource('academic-services', AcademicServiceController::class);

    // Research & Community Services
    Route::resource('research-services', ResearchServiceController::class);

    // Documents
    Route::resource('documents', DocumentController::class);
    Route::get('documents/{document}/download', [DocumentController::class , 'download'])->name('documents.download');

    // FAQs
    Route::resource('faqs', FaqController::class);

    // Gallery
    Route::delete('gallery/mass-destroy', [GalleryController::class , 'massDestroy'])->name('gallery.mass-destroy');
    Route::resource('gallery', GalleryController::class);

    // Sliders / Banners
    Route::resource('sliders', SliderController::class);
    Route::patch('sliders/reorder', [SliderController::class , 'reorder'])->name('sliders.reorder');
    Route::patch('sliders/{slider}/toggle-status', [SliderController::class, 'toggleStatus'])->name('sliders.toggleStatus');

    // Partners / Mitra Kerjasama
    Route::patch('partners/{partner}/toggle-status', [PartnerController::class , 'toggleStatus'])->name('partners.toggle-status');
    Route::resource('partners', PartnerController::class);

    // Testimonials
    Route::resource('testimonials', TestimonialController::class);
    Route::patch('testimonials/{testimonial}/toggle-status', [TestimonialController::class , 'toggleStatus'])->name('testimonials.toggle-status');

    // Sponsors
    Route::patch('sponsors/{sponsor}/toggle-status', [SponsorController::class , 'toggleStatus'])->name('sponsors.toggle-status');
    Route::resource('sponsors', SponsorController::class);

    // Menu Builder
    Route::resource('menus', MenuController::class);
    Route::post('menus/{menu}/items', [MenuController::class , 'saveItems'])->name('menus.save-items');

    // Media Library
    Route::get('media', [MediaController::class, 'index'])->name('media.index');
    Route::post('media/upload', [MediaController::class, 'upload'])->name('media.upload');
    Route::get('media/picker', [MediaController::class, 'picker'])->name('media.picker');
    Route::get('media/json/{id}', [MediaController::class, 'json'])->name('media.json');
    Route::get('media/json-by-path', [MediaController::class, 'jsonByPath'])->name('media.json-by-path');
    Route::resource('media', MediaController::class)->parameters([
        'media' => 'media'
    ]);
    Route::get('media/folders', [MediaController::class, 'folder'])->name('media.folder');

    // Infographics
    Route::resource('infographics', InfographicController::class);
    Route::post('infographics/{infographic}/activate', [InfographicController::class , 'activate'])->name('infographics.activate');

    // Settings
    Route::get('settings', [SettingController::class , 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class , 'update'])->name('settings.update');
    Route::get('settings/{group}', [SettingController::class , 'group'])->name('settings.group');

    // Users
    Route::resource('users', UserController::class);

    // Contact Messages
    Route::get('contact-messages', [ContactMessageController::class , 'index'])->name('contact-messages.index');
    Route::get('contact-messages/{message}', [ContactMessageController::class , 'show'])->name('contact-messages.show');
    Route::post('contact-messages/{message}/reply', [ContactMessageController::class , 'reply'])->name('contact-messages.reply');
    Route::delete('contact-messages/{message}', [ContactMessageController::class , 'destroy'])->name('contact-messages.destroy');

    // Backup Management
    Route::middleware(['role:Super Admin'])->group(function () {
            Route::get('backups', [BackupController::class , 'index'])->name('backups.index');
            Route::post('backups', [BackupController::class , 'create'])->name('backups.create');
            Route::get('backups/{filename}/download', [BackupController::class , 'download'])->name('backups.download');
            Route::delete('backups/{filename}', [BackupController::class , 'destroy'])->name('backups.destroy');
            Route::patch('backups/schedule', [BackupController::class , 'updateSchedule'])->name('backups.schedule');
            Route::delete('backups', [BackupController::class , 'destroyOld'])->name('backups.clean');
        }
        );

        // Language Switcher
        Route::get('language/{locale}', function ($locale) {
            if (!in_array($locale, ['en', 'id'])) {
                abort(400);
            }
            session(['admin_locale' => $locale]);
            return redirect()->back();
        }
        )->name('language.switch');

        // System Guide
        Route::get('guide', function () {
            return view('admin.guide.index');
        })->name('guide');

        // Impersonate Routes
        Route::impersonate();
    });

Route::group([
    'prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    /* |-------------------------------------------------------------------------- | Frontend Public Routes |-------------------------------------------------------------------------- */
    Route::get('/', [HomeController::class , 'index'])->name('home');
    Route::get('/tentang', [FrontInfoPageController::class , 'about'])->name('about');
    Route::get('/akademik', [FrontInfoPageController::class , 'academic'])->name('academic');
    Route::get('/penelitian', [FrontInfoPageController::class , 'research'])->name('research');
    Route::get('/pengabdian', [FrontInfoPageController::class , 'community'])->name('community');
    Route::get('/penelitian/{slug}', [FrontInfoPageController::class, 'showResearch'])->name('research.show');
    Route::get('/dosen', [FrontLecturerController::class , 'index'])->name('lecturers.index');
    Route::get('/dosen/{lecturer}', [FrontLecturerController::class , 'show'])->name('lecturers.show');
    Route::get('/galeri', [FrontGalleryController::class , 'index'])->name('gallery.index');
    Route::get('/agenda', [FrontEventController::class , 'index'])->name('events.index');
    Route::get('/agenda/{slug}', [FrontEventController::class , 'show'])->name('events.show');
    Route::get('/berita', [FrontPostController::class , 'index'])->name('posts.index');
    Route::get('/berita/{slug}', [FrontPostController::class , 'show'])->name('posts.show');
    Route::get('/kategori/{slug}', [FrontPostController::class , 'category'])->name('posts.category');
    Route::get('/tag/{slug}', [FrontPostController::class , 'tag'])->name('posts.tag');
    Route::get('/kontak', [ContactController::class , 'index'])->name('contact.index');
    Route::post('/kontak', [ContactController::class , 'store'])->name('contact.store');
    Route::get('/cari', [FrontInfoPageController::class , 'search'])->name('search');
    // Sitemap & Robots
    Route::get('/sitemap.xml', [HomeController::class , 'sitemap'])->name('sitemap');
    Route::get('/robots.txt', [HomeController::class , 'robots'])->name('robots');

    // Announcements
    Route::get('/pengumuman/{slug}', [HomeController::class , 'showAnnouncement'])->name('announcements.show');

    // Documents
    Route::get('/dokumen', [FrontDocumentController::class, 'index'])->name('documents');
    Route::get('/dokumen/{id}/download', [DocumentController::class , 'publicDownload'])->name('documents.public-download');

    // FAQs
    Route::get('/faqs', [FrontFaqController::class, 'index'])->name('faqs.index');

    // Captcha Route
    Route::get('/captcha', [\App\Http\Controllers\CaptchaController::class, 'generate'])->name('captcha.generate');

    // Auth routes (Breeze)
    require __DIR__ . '/auth.php';

    // Curriculum
    Route::get('/kurikulum', [\App\Http\Controllers\Frontend\CurriculumController::class, 'index'])->name('curriculum');

    // Academic Calendar
    Route::get('/kalender-akademik', [\App\Http\Controllers\Frontend\AcademicCalendarController::class, 'index'])->name('calendar');

    // Academic Services
    Route::get('/layanan-akademik', [\App\Http\Controllers\Frontend\AcademicServiceController::class, 'index'])->name('academic-services');

    // Static Pages (Catch-all for anything without a dedicated prefix)
    Route::get('/{slug}', [FrontFrontPageController::class , 'show'])->name('pages.show');
});

// Auth routes moved to localization group

/* |-------------------------------------------------------------------------- | API Routes - referenced via api.php |-------------------------------------------------------------------------- */

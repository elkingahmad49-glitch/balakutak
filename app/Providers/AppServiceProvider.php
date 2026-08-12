<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function boot(): void
    {
        \Illuminate\Pagination\Paginator::useBootstrap();

        \Illuminate\Support\Facades\Blade::directive('safeHtml', function ($expression) {
            return "<?php echo \App\Helpers\HtmlHelper::fixHtmlTags($expression); ?>";
        });

        \Illuminate\Support\Facades\View::composer(
            ['admin.settings.*', 'admin.infographics.*'],
            function ($view) {
                $view->with('groups', [
                    'general' => 'Umum',
                    'contact' => 'Kontak',
                    'social' => 'Media Sosial',
                    'seo' => 'SEO',
                    'appearance' => 'Tema',
                    'academic' => 'Akademik',
                    'infographics' => 'Info Grafis',
                    'sponsor' => 'Sponsor',
                ]);
            }
        );

        // Share menus with frontend views
        \Illuminate\Support\Facades\View::composer(
            ['layouts.frontend', 'frontend.partials.*'],
            function ($view) {
            // Eager load only active items
            $menus = \App\Models\Menu::with(['items' => function ($q) {
                    $q->orderBy('order');
                }
                    , 'items.children' => function ($q) {
                $q->orderBy('order');
            }
            ])->where('is_active', true)->get()->keyBy('location');

            $view->with('sharedMenus', $menus);
        }
        );

        Event::listen(BuildingMenu::class , function (BuildingMenu $event) {
            if (app('impersonate')->isImpersonating()) {
                $event->menu->add([
                    'text' => 'BACK TO ADMIN',
                    'url' => route('admin.impersonate.leave'),
                    'icon' => 'fas fa-user-secret',
                    'icon_color' => 'white',
                    'topnav_right' => true,
                    'classes' => 'bg-danger text-white px-3 mr-3 rounded-pill shadow-sm font-weight-bold d-flex align-items-center',
                ]);
            }
        });

        // Set AdminLTE Logo dynamically
        try {
            $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
            // Set Logo Image
            if (isset($settings['site_logo']) && !empty($settings['site_logo'])) {
                config(['adminlte.logo_img' => 'storage/' . $settings['site_logo']]);
            }

            if (isset($settings['site_abbreviation']) && !empty($settings['site_abbreviation'])) {
                config(['adminlte.logo' => '<b>' . $settings['site_abbreviation'] . '</b>']);
            }
            else {
                config(['adminlte.logo' => '<b>Admin</b> Prodi']);
            }
        }
        catch (\Exception $e) {
            // Ignore if DB not ready
            config(['adminlte.logo' => '<b>Admin</b> Prodi']);
        }
    }
}

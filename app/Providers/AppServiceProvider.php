<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Blade;
use App\Helpers\ImageHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $getSettings = Setting::pluck('value', 'key')->toArray();
            $view->with('getSettings', $getSettings);
        });
        
        // Registrar Blade directives para WebP
        Blade::directive('webpPicture', function ($expression) {
            return "<?php echo App\Helpers\ImageHelper::webpPicture({$expression}); ?>";
        });
        
        Blade::directive('webpUrl', function ($expression) {
            return "<?php echo App\Helpers\ImageHelper::webpUrl({$expression}); ?>";
        });
        
        Blade::directive('webpSrcset', function ($expression) {
            return "<?php echo App\Helpers\ImageHelper::webpSrcset({$expression}); ?>";
        });
        
        // Blade directive para formatar telefone (remover caracteres especiais)
        Blade::directive('formatPhone', function ($expression) {
            return "<?php echo str_replace(['(', ')', '.', ' ', '-'], '', {$expression}); ?>";
        });
    }
}

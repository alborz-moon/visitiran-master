<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
        Blade::directive('lang', function ($lang) {
            return "<?php if($lang == 'ar') echo 'عربی'; else if($lang == 'fa') echo 'فارسی'; else if($lang == 'fr') echo 'فرانسه'; else if($lang == 'en') echo 'انگلیسی'; else if($lang == 'tr') echo 'ترکیه'; else if($lang == 'gr') echo 'آلمانی'; ?>";

        });

        Blade::directive('level_description', function ($level) {
            return "<?php if($level == 'national') echo 'ملی'; else if($level == 'state') echo 'استانی'; else if($level == 'local') echo 'محلی'; else if($level == 'pro') echo 'تخصصی'; ?>";
        });
    }
}

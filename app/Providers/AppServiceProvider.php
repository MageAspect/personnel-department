<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('avatar', function ($path = null) {
            return "<?php echo \"background-image: url('\" . (" . $path . " ?:  '/img/user/user-plug.svg') . \"')\" ?>";
        });

        Validator::extend('numericArray', function ($attribute, $array) {
            foreach ($array as $value) {
                if (!is_int($value)) {
                    return false;
                }
            }
            return true;
        });
    }
}

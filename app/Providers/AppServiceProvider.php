<?php

namespace App\Providers;

use App\Personnel\Department\DepartmentsStore;
use App\Personnel\Users\UsersStore;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Request;
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
        $this->app->bind(UsersStore::class, function () {
            return new UsersStore(Request::user());
        });
        $this->app->bind(DepartmentsStore::class, function () {
            return new DepartmentsStore(Request::user());
        });
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

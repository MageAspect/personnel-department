<?php

namespace App\Providers;

use App\Models\CareerJournal;
use App\Models\Department;
use App\Personnel\Department\DepartmentStore;
use App\Personnel\Users\Journal\CareerJournalStore;
use App\Personnel\Users\UserStore;
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
        $this->app->bind(UserStore::class, function () {
            return new UserStore(Request::user(), new CareerJournalStore(new CareerJournal()));
        });
        $this->app->bind(DepartmentStore::class, function () {
            return new DepartmentStore(Request::user(), $this->app->make(UserStore::class), new Department());
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

<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::factory()->count(1)->admin()->create();
         User::factory(14)->create();

         Department::factory(9)->create();

         $email = User::query()->first()->email;
         echo "\nДоступы админа: $email, пароль password \n\n";
    }
}

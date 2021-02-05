<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Lawyer;
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
        User::factory(5)->create();
        Client::factory(20)->create();
        Lawyer::factory(5)->create();
    }
}

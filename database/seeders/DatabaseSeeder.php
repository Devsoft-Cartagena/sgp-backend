<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Adviser;
use App\Models\Client;
use App\Models\Credit;
use App\Models\Lawyer;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {

        $this->call([
            UserAdminSeeder::class,
            SupplierSeeder::class,
            TypeTransactionSeeder::class,
            CreditTypesSeeder::class,
            PayrollSeeder::class
        ]);

        if (config('app.env') == 'local') {
            User::factory(10)->create();
            Adviser::factory(10)->create();
            Client::factory(20)->create();
            Lawyer::factory(5)->create();
            Supplier::factory(3)->create();
            Account::factory(6)->create();
            Credit::factory(10)->create();
            Transaction::factory(20)->create();
        }
    }
}

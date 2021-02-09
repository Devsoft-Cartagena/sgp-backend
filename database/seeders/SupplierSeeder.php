<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Supplier::create([
            'name' => 'Oficina'
        ]);

        Supplier::create([
            'name' => 'Otro'
        ]);

        Supplier::create([
            'name' => 'No Aplica'
        ]);
    }
}

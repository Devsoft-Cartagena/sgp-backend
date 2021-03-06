<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldStatusInCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('credits', function (Blueprint $table) {
            $table->char('status', 1)->default('P')->comment('A: Activo, F: Finalizado, P: Pendiente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('credits', function (Blueprint $table) {
            $table->removeColumn('status');
        });
    }
}

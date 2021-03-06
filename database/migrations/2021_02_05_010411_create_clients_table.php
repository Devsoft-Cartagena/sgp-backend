<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('document_type', 50)->default('cc');
            $table->string('document_number', 50)->unique();
            $table->string('name', 150)->comment('Nombre Completo');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('sign')->nullable();
            $table->json('client_type')->comment('Tipos de usuario');
            $table->char('status', 1)->default('A')->comment('A: Activo, I: Inactivo');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
}

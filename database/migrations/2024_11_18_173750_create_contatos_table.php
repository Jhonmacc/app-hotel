<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('contatos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_hospede');
        $table->string('email');
        $table->string('numero')->nullable();
        $table->string('tipo');
        $table->timestamps();

        $table->foreign('id_hospede')->references('id')->on('hospedes')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contatos');
    }
};

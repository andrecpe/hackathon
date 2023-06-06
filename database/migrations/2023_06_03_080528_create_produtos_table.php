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
        Schema::create('dbo.Produto', function (Blueprint $table) {
            $table->integer('CO_PRODUTO')->primary();
            $table->string('NO_PRODUTO', 200);
            $table->decimal('PC_TAXA_JUROS', 10, 9);
            $table->smallInteger('NU_MINIMO_MESES');
            $table->smallInteger('NU_MAXIMO_MESES')->nullable();
            $table->decimal('VR_MINIMO', 18, 2);
            $table->decimal('VR_MAXIMO', 18, 2)->nullable();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};

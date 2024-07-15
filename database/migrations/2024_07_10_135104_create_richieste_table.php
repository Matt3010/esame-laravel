<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('richieste', function (Blueprint $table) {
            $table->id('RichiestaID');
            $table->string('CognomeNomeRichiedente');
            $table->timestamp('DataInserimentoRichiesta');
            $table->float('Importo');
            $table->integer('NumeroRate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('richieste');
    }
};

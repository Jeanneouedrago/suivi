<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('role_requests', function (Blueprint $table) {
        $table->id();
        $table->string('name'); 
        $table->string('role_demande'); // fournisseur, admin etc.
        $table->text('justification')->nullable();
        $table->string('piece_jointe'); // chemin vers le fichier joint
        $table->enum('statut', ['en_attente', 'accepté', 'refusé'])->default('en_attente');
        $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_requests');
    }
};

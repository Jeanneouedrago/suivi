<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('colis', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('volume');
            $table->string('taille');
            $table->enum('statut', ['en_transit', 'livre', 'arrive']);
            $table->date('date_depart');
            $table->date('date_arrivee');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('colis');
    }
};


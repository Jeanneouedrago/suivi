<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colis extends Model
{
    protected $fillable = [
        'reference', 
        'volume', 
        'taille', 
        'statut', 
        'date_depart',
        'date_arrivee'
    ];
}



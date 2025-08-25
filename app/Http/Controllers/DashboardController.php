<?php

namespace App\Http\Controllers;

use App\Models\Colis;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
public function index()
{
    $colis = \App\Models\Colis::all();

    // Statuts pour le graphique
    $statuts = \App\Models\Colis::selectRaw('statut, COUNT(*) as count')
        ->groupBy('statut')
        ->get();

    // Colis par mois pour le graphique
    $parMois = \App\Models\Colis::selectRaw('MONTH(date_arrivee) as mois, COUNT(*) as count')
        ->groupBy('mois')
        ->get();

    return view('dashboard', compact('colis', 'statuts', 'parMois'));
}
}

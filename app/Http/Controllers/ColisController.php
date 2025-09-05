<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colis;

class ColisController extends Controller
{

    public function index()
    {
        // Récupère tous les colis depuis la base
        $colis = Colis::all();

        // Envoie les données à la vue
        return view('colis.index', compact('colis'));
    }



    public function create()
    {
        return view('colis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference' => 'required|string|max:255|unique:colis',
            'volume'    => 'required|string|max:255',
            'taille'    => 'required|string|max:255',
            'statut'    => 'required|string',
            'date_depart' => 'required|date',
            'date_arrivee' => 'required|date',
        ]);

        Colis::create($validated);

        return redirect()->route('colis.create')->with('success', 'Colis enregistré avec succès');
    }




    public function search(Request $request)
    {
    $reference = $request->input('reference');
    $colis = Colis::where('reference', $reference)->first();

    if ($colis) {
        return redirect()->route('colis.show', $colis->id);
    } else {
        return back()->with('error', 'Colis introuvable');
    }
    }




   public function show($id)
    {
        // Récupérer le colis
        $colis = Colis::findOrFail($id);

        // Historique fictif (à remplacer par tes données réelles)
        //$historique = [
            //['etat' => 'Enregistré', 'date' => '2025-08-01'],
            //['etat' => 'En transit', 'date' => '2025-08-05'],
            //['etat' => 'Livré', 'date' => '2025-08-10'],
        //];

        // Notifications fictives (à remplacer par tes données réelles)
       // $notifications = [
           // ['message' => 'Votre colis est parti de l’entrepôt', 'date' => '2025-08-05'],
           // ['message' => 'Votre colis est arrivé à destination', 'date' => '2025-08-10'],
       // ];

        //return view('colis-show', compact('colis', 'historique', 'notifications'));
    }

}

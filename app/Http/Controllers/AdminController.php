<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleRequest;
use App\Notifications\RoleDemandeNotification;
use App\Models\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\RoleRequestController;

class AdminController extends Controller
{
   public function dashboard()
{
    if (auth()->user()->role !== 'admin') {
        abort(403, 'Accès refusé');
    }

    // Récupération stats colis
    $statuts = \App\Models\Colis::selectRaw('statut, COUNT(*) as count')
        ->groupBy('statut')
        ->get();

    $parMois = \App\Models\Colis::selectRaw('MONTH(date_arrivee) as mois, COUNT(*) as count')
        ->groupBy('mois')
        ->get();

    // Récupération demandes de rôle
    $requests = \App\Models\RoleRequest::with('user')
        ->get();
        

    return view('dashboardadmin', compact('statuts', 'parMois', 'requests'));
}




    public function accepter($id)
{
    $demande = RoleRequest::findOrFail($id);
    $demande->update(['statut' => 'accepté']);
    $demande->user->update(['role' => $demande->role_demande]);

    return back()->with('success', 'Rôle accepté');
}

public function refuser($id)
{
    $demande = RoleRequest::findOrFail($id);
    $demande->update(['statut' => 'refusé']);

    return back()->with('error', 'Demande refusée');
}

    public function roleRequests()
    {
        // Récupère tous les utilisateurs qui ont demandé un rôle
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Accès refusé');
        }
        // Récupération des demandes de rôle
        $requests = User::whereNotNull('role.request')->get();

        // Envoie à la vue
        return view('admin.role.requests', compact('requests'));
    }


}


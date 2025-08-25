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

    
        // Logique pour récupérer les données nécessaires au dashboard admin
        //$statuts = ['en_attente', 'accepté', 'refusé'];
        //$parMois = RoleRequest::selectRaw('MONTH(created_at) as mois, COUNT(*) as total')
            //->groupBy('mois')
           // ->get();
        //$demande = RoleRequest::all();
        //$demandes = $demande->isEmpty() ? 'Aucune demande de rôle' : $demande;

        //return view('dashboardadmin', compact('statuts', 'parMois', 'demandes'));
    //}

    // Autres méthodes pour gérer les demandes de rôle, accepter ou refuser des demandes, etc.
    //public function demandes()
//{
    //$demandes = RoleRequest::where('statut', 'en_attente')->get();
    //return view('admin.dashboard', compact('demandes', 'statuts', 'parMois'));
//}

    public function accepter($id)
{
    $demande = RoleRequest::findOrFail($id);
    $demande->update(['statut' => 'accepté']);
    $demande->user->update(['role' => $demande->role_demande]);

    // Notification
    //$demande->user->notify(new RoleDemandeNotification('acceptée'));

    return back()->with('success', 'Rôle accepté');
}

public function refuser($id)
{
    $demande = RoleRequest::findOrFail($id);
    $demande->update(['statut' => 'refusé']);

    // Notification
    //$demande->user->notify(new RoleDemandeNotification('refusée'));

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


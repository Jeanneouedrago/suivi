<?php

namespace App\Http\Controllers;

use App\Models\RoleRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleRequestController extends Controller
{
    // Afficher les demandes
  public function index()
{
    // On récupère toutes les demandes de rôle
    $requests = RoleRequest::all();

    // On passe la variable à la vue
    return view('role.request', compact('requests'));
}


    // Enregistrer une demande
    public function store(Request $request)
{
    
    $validated = $request->validate([
        'name' => 'required|string',
        'role_demande' => 'required|string',
        'justification' => 'nullable|string',
        'Piece justificatif' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
    ]);

$user = auth()->user();
    $validated['user_id'] = $user->id; 
    //dd($validated);// Associer l'utilisateur connecté
    RoleRequest::create($validated);


    return redirect()->back()->with('success', 'Demande envoyée avec succès.');
}

    // Accepter une demande
    public function accept($id)
{
    $demande = RoleRequest::findOrFail($id);
    if ($demande->statut != 'accepté'){
        $demande->update(['statut' => 'accepté']);
        $demande->user->update(['role' => $demande->role_demande]);
         return back()->with('success', 'Rôle accepté');
    } else {
        return back()->with('error', 'Cette demande a déjà été traitée.');
    }

}

public function refuse($id)
{
    $demande = RoleRequest::findOrFail($id);
    if ($demande->statut != 'refusé'){
        $demande->update(['statut' => 'refusé']);
        $demande->user->update(['role' => $demande->role_demande]);
         return back()->with('success', 'Rôle refusé');
    } else {
        return back()->with('error', 'Cette demande a déjà été traitée.');
    }
}
}

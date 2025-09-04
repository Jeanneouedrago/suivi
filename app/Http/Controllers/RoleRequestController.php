<?php

namespace App\Http\Controllers;

use App\Models\RoleRequest;
use Illuminate\Support\Facades\Storage;
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




public function store(Request $request)
    {
    $validate=$request->validate([
        'name' => 'required|string|max:255',
        'role_demande' => 'required|string|max:255',
        'justification' => 'required|string',
        'piece_jointe' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);
    $user = auth()->user();
    $validate['user_id'] = $user->id; 

    $filename = time() . '_' . $request->file('piece_jointe')->getClientOriginalName();
    $path = $request->file('piece_jointe')->storeAs('pieces_jointes', $filename, 'public');
   //dd($validate, $path);

    RoleRequest::create([
        'name' => $request->name,
        'role_demande' => $request->role_demande,
        'justification' => $request->justification,
        'user_id' => auth()->id(),
        'piece_jointe' => $path,
    ]);

    return redirect()->back()->with('success', 'Votre demande a bien été envoyée.');
    }







    // Enregistrer une demande
    //public function store(Request $request)
//{
    
    /* $validated = $request->validate([
        'name' => 'required|string',
        'role_demande' => 'required|string',
        'justification' => 'nullable|string',
        'Piece justificatif' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
    ]);
 */
/* $user = auth()->user();
    $validated['user_id'] = $user->id; 
    //dd($validated);// Associer l'utilisateur connecté
    RoleRequest::create($validated);


    return redirect()->back()->with('success', 'Demande envoyée avec succès.');
} */

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


public function download($id)
{
    $roleRequest = RoleRequest::findOrFail($id);

    if ($roleRequest->piece_jointe && Storage::disk('public')->exists($roleRequest->piece_jointe)) {
        return Storage::disk('public')->download($roleRequest->piece_jointe);
    }

    return redirect()->back()->with('error', 'Le fichier n’existe pas.');
}

}

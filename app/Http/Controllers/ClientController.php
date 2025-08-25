<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colis = \App\Models\Colis::all();
        $statuts = \App\Models\Colis::selectRaw('statut, COUNT(*) as count')
            ->groupBy('statut')
            ->get();
        $parMois = \App\Models\Colis::selectRaw('MONTH(date_arrivee) as mois, COUNT(*) as count')
        ->groupBy('mois')
        ->get();
        return view('dashboard', compact('colis', 'statuts', 'parMois'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

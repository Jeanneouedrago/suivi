@extends('layouts.admin')

    @section('title', 'Dashboard Consignataire')

    @section('content')

    


    <!-- Contenu principal -->
    <main class="flex-1 p-8">
        <!-- Bienvenue + bouton changer de rôle -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-xl font-semibold">Bienvenue {{ Auth::user()->name }}</h2>
            <p>Vous êtes connecté en tant que <strong>{{ Auth::user()->role }}</strong>.</p>
        </div>


        <!-- Section Tableau -->
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-2xl font-semibold mb-4">Liste des colis</h2>

            <!-- Barre de recherche -->
            <form method="GET" action="#" class="mb-4 flex">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Rechercher un colis..."
                    class="border p-2 flex-1 rounded-l">
                <button type="submit" class="bg-cyan-500 text-white px-4 rounded-r">Rechercher</button>
            </form>

            <!-- Tableau -->
            <table class="w-full border-collapse border">
                <thead>
                    <tr class="bg-cyan-100">
                        <th class="border p-2">Référence</th>
                        <th class="border p-2">Volume</th>
                        <th class="border p-2">Taille</th>
                        <th class="border p-2">Statut</th>
                        <th class="border p-2">Date de départ</th>
                        <th class="border p-2">Date d’arrivée</th>
                    </tr>
                </thead>
                <tbody>
                   @forelse($colis as $c)
                        <tr>
                            <td class="border p-2">{{ $c->reference }}</td>
                            <td class="border p-2">{{ $c->volume }}</td>
                            <td class="border p-2">{{ $c->taille }}</td>
                            <td class="border p-2">{{ $c->statut }}</td>
                            <td class="border p-2">{{ $c->date_depart }}</td>
                            <td class="border p-2">{{ $c->date_arrivee }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center p-2">Aucun colis trouvé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
    
@endsection
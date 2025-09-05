@extends('layouts.admin')

    @section('title')
        @if(Auth::user()->role === 'admin')
            Dashboard Admin
        @elseif(Auth::user()->role === 'fournisseur')
            Dashboard Fournisseur
        @elseif(Auth::user()->role === 'consignataire')
            Dashboard Consignataire
        @else
            Dashboard Client
        @endif
    @endsection

    @section('content')

    
    <!-- Contenu principal -->
    <main class="flex-1 p-8">
        <!-- Bienvenue + bouton changer de rôle -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-xl font-semibold">Bienvenue {{ Auth::user()->name }}</h2>
            <p>Vous êtes connecté en tant que <strong>{{ Auth::user()->role }}</strong>.</p>
        </div>

        <!-- Section Graphiques -->
        <div class="grid grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-xl font-semibold mb-2">Répartition des statuts</h2>
                <canvas id="statutChart"></canvas>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-xl font-semibold mb-2">Nombre de colis par mois</h2>
                <canvas id="moisChart"></canvas>
            </div>
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
    

    <script>
        // Graphique Répartition des statuts
        new Chart(document.getElementById('statutChart'), {
            type: 'pie',
            data: {
                labels: @json($statuts->pluck('statut')),
                datasets: [{
                    data: @json($statuts->pluck('count')),
                    backgroundColor: ['#22c55e', '#f59e0b', '#ef4444', '#3b82f6'],
                }]
            },
            options: { plugins: { legend: { position: 'bottom' } } }
        });

        // Graphique Colis par mois
        new Chart(document.getElementById('moisChart'), {
            type: 'bar',
            data: {
                labels: @json($parMois->pluck('mois')),
                datasets: [{
                    label: "Nombre de colis",
                    data: @json($parMois->pluck('count')),
                    backgroundColor: '#06b6d4'
                }]
            },
            options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
        });
    </script>
@endsection

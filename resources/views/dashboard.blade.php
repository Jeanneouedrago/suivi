@extends('layouts.admin')

    @section('title', 'Dashboard Client')

    @section('content')


    <div class="flex flex-1">
        

        <!-- Contenu principal -->
        <main class="flex-1 p-6">
            <!-- Bienvenue + bouton changer de rôle -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <h2 class="text-lg font-semibold mb-3 md:mb-0">
                    Bienvenue {{ Auth::user()->name }}
                </h2>
                <a href="{{ route('changer.role') }}" 
                   class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition text-sm">
                    Changer de rôle 👤
                </a>
            </div>

            <!-- Section Graphiques -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-white p-3 rounded shadow text-sm">
                    <h2 class="text-lg font-semibold mb-2">Répartition des statuts</h2>
                    <canvas id="statutChart" style="max-height:200px;"></canvas>
                </div>
                <div class="bg-white p-3 rounded shadow text-sm">
                    <h2 class="text-lg font-semibold mb-2">Nombre de colis par mois</h2>
                    <canvas id="moisChart" style="max-height:200px;"></canvas>
                </div>
            </div>

            <!-- Section Tableau -->
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-lg font-semibold mb-3">Liste des colis</h2>

                <!-- Barre de recherche -->
                <form method="GET" action="#" class="mb-4 flex">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Rechercher un colis..."
                           class="border p-2 flex-1 rounded-l text-sm">
                    <button type="submit" class="bg-cyan-500 text-white px-4 rounded-r text-sm">Rechercher</button>
                </form>

                <!-- Tableau -->
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border text-sm">
                        <thead>
                            <tr class="bg-cyan-100 text-gray-700">
                                <th class="border p-2">Référence</th>
                                <th class="border p-2">Statut</th>
                                <th class="border p-2">Volume</th>
                                <th class="border p-2">Date depart</th>
                                <th class="border p-2">Date d’arrivée</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($colis as $c)
                                <tr>
                                    <td class="border p-2">{{ $c->reference }}</td>
                                    <td class="border p-2">{{ $c->statut }}</td>
                                    <td class="border p-2">{{ $c->volume }}</td>
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
            </div>
        </main>
    </div>


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

        // Notifications badge dynamique
        function updateBellCount() {
            fetch("{{ url('/notifications/unread-count') }}")
                .then(response => response.json())
                .then(data => {
                    const notifCount = document.getElementById('notif-count');
                    if (data.count > 0) {
                        notifCount.textContent = data.count;
                        notifCount.classList.remove('hidden');
                    } else {
                        notifCount.classList.add('hidden');
                    }
                });
        }
        setInterval(updateBellCount, 5000);
        updateBellCount();
    </script>
@endsection
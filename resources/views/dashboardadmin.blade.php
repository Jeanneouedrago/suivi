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
    <main class="flex-1 flex flex-col">
        <!-- Bienvenue en haut -->
        <div class="w-full bg-white p-6 rounded shadow mb-6">
            <h2 class="text-2xl font-bold">
                Bienvenue {{ Auth::user() ? Auth::user()->name : '' }}
            </h2>
            <p>Vous êtes connecté en tant que <strong>{{ Auth::user()->role }}</strong>.</p>
        </div>

        <!-- Graphiques au centre -->
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

        <!-- Gestion des demandes de rôle en bas -->
        <main class="flex-1 flex flex-col items-center justify-center p-6">
        <h2 class="text-2xl font-bold mb-4">Gestion de demande de rôle</h2>
        <div class="overflow-x-auto w-full max-w-4xl">
            <table class="table-auto border-collapse border border-gray-400 w-full text-center bg-white shadow-md rounded-lg">
                <thead class="bg-gray-300">
                    <tr>
                        <th class="border border-gray-400 px-4 py-2">Nom</th>
                        <th class="border border-gray-400 px-4 py-2">Rôle demandé</th>
                        <th class="border border-gray-400 px-4 py-2">Statut</th>
                        <th class="border border-gray-400 px-4 py-2">Justification</th>
                        <th class="border border-gray-400 px-4 py-2">Pièce jointe</th>
                        <th class="border border-gray-400 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                        <tr>
                            <td class="border px-4 py-2">{{ $req->name }}</td>
                            <td class="border px-4 py-2">{{ $req->role_demande }}</td>
                            <td class="border px-4 py-2">{{ $req->statut }}</td>
                            <td class="border px-4 py-2">{{ $req->justification }}</td>
                      <td>
                        @if($req->piece_jointe)
                            <a href="{{ route('role-requests.download', $req->id) }}" class="btn btn-sm btn-info">
                                Télécharger
                            </a>
                        @else
                            <span class="text-muted">Aucun fichier</span>
                        @endif
                    </td>
    
                            <td class="border px-4 py-2 space-x-2">
                                <form action="{{ route('role.accept', $req->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="bg-green-500 text-white px-3 py-1 rounded">Accepter</button>
                                </form>
                                <form action="{{ route('role.refuse', $req->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="bg-red-500 text-white px-3 py-1 rounded">Refuser</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4">Aucune demande trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
            }
              //options: { plugins: { legend: { position: 'bottom' } } }
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
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: '{{ session('error') }}',
                    timer: 5000,
                    showConfirmButton: true
                });
            @endif
        });
    </script>
    
@endsection
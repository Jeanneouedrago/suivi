@extends('layouts.admin')

    @section('title')
        @if(Auth::user()->role === 'admin')
            Dashboard Admin Colis
        @elseif(Auth::user()->role === 'fournisseur')
            Dashboard Fournisseur Colis
        @elseif(Auth::user()->role === 'consignataire')
            Dashboard Consignataire Colis
        @else
            Dashboard Client Colis
        @endif
    @endsection

    @section('content')

     <!-- Contenu principal -->
    <main class="flex-1 flex justify-center items-center p-6">
        <div class="w-full max-w-4xl">
            <h1 class="text-2xl font-bold mb-4 text-center">Liste des Colis</h1>

            @if($colis->isEmpty())
                <p class="text-gray-500 text-center">Aucun colis trouvé.</p>
            @else
                <table class="min-w-full bg-white border border-gray-200 shadow rounded-lg">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="py-2 px-4 border-b">ID</th>
                            <th class="py-2 px-4 border-b">Référence</th>
                            <th class="py-2 px-4 border-b">Volume</th>
                            <th class="py-2 px-4 border-b">Taille</th>
                            <th class="py-2 px-4 border-b">Statut</th>
                            <th class="py-2 px-4 border-b">Date de départ</th>
                            <th class="py-2 px-4 border-b">Date d’arrivée</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($colis as $item)
                            <tr class="hover:bg-gray-100 text-center">
                                <td class="py-2 px-4 border-b">{{ $item->id }}</td>
                                <td class="py-2 px-4 border-b">{{ $item->reference }}</td>
                                <td class="py-2 px-4 border-b">{{ $item->volume }}</td>
                                <td class="py-2 px-4 border-b">{{ $item->taille }}</td>
                                <td class="py-2 px-4 border-b">{{ $item->statut }}</td>
                                <td class="py-2 px-4 border-b">{{ $item->date_depart }}</td>
                                <td class="py-2 px-4 border-b">{{ $item->date_arrivee }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </main>
</div>

@endsection
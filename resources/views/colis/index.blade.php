<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion colis</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>

    <style>
        footer { 
            background: black; 
            color: white; 
            padding: 10px; 
            position: fixed; 
            bottom: 0; 
            width: 100%; 
            left: 19%;
            text-align: center; 
        }
    </style>

</head>
<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-cyan-300 text-black p-6 flex-shrink-0" x-data="{ openColis: false }">
        <h1 class="text-3xl font-bold text-pink-600 mb-8">TransitFlow</h1>
            <nav class="space-y-4">
        <!-- Dashboard -->
            <a href="{{ route('fournisseur.dashboard') }}" class="flex items-center gap-3 text-lg font-semibold hover:underline">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h5a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h5a1 1 0 001-1V10"></path>
            </svg>
            Dashboard
            </a>
        <!-- Gestion des colis déroulant -->
        <div>
            <button @click="openColis = !openColis" class="flex items-center gap-3 text-lg font-semibold hover:underline w-full">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="7" width="18" height="13" rx="2" stroke-linecap="round" stroke-linejoin="round"></rect>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 3v4M8 3v4"></path>
                </svg>
                Gestion des colis
                <svg :class="{'rotate-180': openColis}" class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="openColis" x-transition class="pl-8 mt-2 space-y-2">
                 <a href="{{ route('colis.create') }}" class="block text-base hover:underline">Ajouter des colis</a>
                <a href="{{ route('colis.index') }}" class="block text-base hover:underline">Liste des colis</a>
            </div>
        </div>
        <!-- Notifications -->
            <a href="{{ route('notifications.create') }}" class="flex items-center gap-3 text-lg font-semibold hover:underline">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            Notifications
            </a>
        <!-- Déconnexion -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-3 text-lg font-semibold hover:underline w-full text-left">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-4 0v-1m4-8V5a2 2 0 10-4 0v1"></path>
                </svg>
                Déconnexion
            </button>
        </form>

        <!-- Profil -->
        <div style="margin-top: 2rem;">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 text-lg font-semibold hover:underline">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="8" r="4" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 20c0-2.21 3.58-4 6-4s6 1.79 6 4" />
                </svg>
                    Mon Profil
            </a>
        </div>
        </nav>
    </aside>

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

<footer>
    Copyright©2025 | Tous droits réservés
</footer>

</body>
</html>

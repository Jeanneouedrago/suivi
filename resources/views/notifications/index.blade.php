<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Notifications - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-cyan-300 text-black p-6 flex-shrink-0" x-data="{ openColis: false }">
        <h1 class="text-3xl font-bold text-pink-600 mb-8">TransitFlow</h1>
        <nav class="space-y-4">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-lg font-semibold hover:underline">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h5a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h5a1 1 0 001-1V10"></path>
                </svg>
                Dashboard
            </a>

            <!-- Gestion des colis -->
            <div>
                <button @click="openColis = !openColis" class="flex items-center gap-3 text-lg font-semibold hover:underline w-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="7" width="18" height="13" rx="2"></rect>
                        <path d="M16 3v4M8 3v4"></path>
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
                    <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                Notifications
            </a>

            <!-- Déconnexion -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 text-lg font-semibold hover:underline w-full text-left">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-4 0v-1m4-8V5a2 2 0 10-4 0v1"></path>
                    </svg>
                    Déconnexion
                </button>
            </form>

            <!-- Profil -->
            <div class="mt-8">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 text-lg font-semibold hover:underline">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="4" />
                        <path d="M6 20c0-2.21 3.58-4 6-4s6 1.79 6 4" />
                    </svg>
                    Mon Profil
                </a>
            </div>
        </nav>
    </aside>

    <!-- Contenu principal -->
    <main class="flex-1 p-8">
        <h2 class="text-2xl font-bold mb-6">🔔 Mes Notifications</h2>

        @forelse($notifications as $notification)
            <div class="bg-white shadow-md rounded-lg p-4 mb-4 border {{ $notification->is_read ? 'border-gray-200' : 'border-blue-400' }}">
                <h3 class="text-lg font-semibold {{ $notification->is_read ? 'text-gray-700' : 'text-blue-600' }}">
                    {{ $notification->title }}
                </h3>
                <p class="text-gray-600">{{ $notification->message }}</p>
                <div class="mt-2 flex justify-between items-center">
                    <a href="{{ route('notifications.showMap', $notification->id) }}" class="text-sm text-indigo-600 hover:underline">
                        📍 Voir la localisation
                    </a>
                    @if(!$notification->is_read)
                        <a href="{{ route('notifications.read', $notification->id) }}" 
                           class="px-3 py-1 bg-green-500 text-white text-sm rounded hover:bg-green-600">
                            ✓ Marquer comme lue
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-gray-100 text-center p-6 rounded-lg shadow">
                🚫 Aucune notification disponible.
            </div>
        @endforelse
    </main>
</body>
</html>

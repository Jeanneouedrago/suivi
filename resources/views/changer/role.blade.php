<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changer de role</title>
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
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-lg font-semibold hover:underline">
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
                <a href="#" class="block text-base hover:underline">Liste des colis</a>
            </div>
        </div>
        <!-- Notifications -->
            <a href="#" class="flex items-center gap-3 text-lg font-semibold hover:underline">
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

 <!-- Contenu centré -->
    <div class="flex flex-1 justify-center items-center p-6">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-300">
                    {{ session('success') }}
                </div>
            @endif
            <h2 class="text-xl font-bold mb-4 text-center">Changer de rôle</h2>
            <form action="{{ route('role-request.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nom complet -->
                <div class="mb-4">
                    <label class="block font-semibold">Nom complet</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" 
                           class="w-full border p-2 rounded" required>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block font-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
                           class="w-full border p-2 rounded" required>
                </div>

                <!-- Téléphone -->
                <div class="mb-4">
                    <label class="block font-semibold">Téléphone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" 
                           class="w-full border p-2 rounded">
                </div>

                <!-- Adresse + Pays/Ville -->
                <div class="flex space-x-4 mb-4">
                    <div class="w-1/2">
                        <label class="block font-semibold">Adresse</label>
                        <input type="text" name="address" value="{{ old('address') }}" 
                               class="w-full border p-2 rounded">
                    </div>
                    <div class="w-1/2">
                        <label class="block font-semibold">Pays / Ville</label>
                        <input type="text" name="country_city" value="{{ old('country_city') }}" 
                               class="w-full border p-2 rounded">
                    </div>
                </div>

                <!-- Rôle souhaité -->
                <div class="mb-4">
                    <label class="block font-semibold">Rôle souhaité</label>
                    <div class="flex space-x-6 mt-2">
                        <label class="flex items-center">
                            <input type="radio" name="role_demande" value="fournisseur" class="mr-2" required>
                            Fournisseur
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="role_demande" value="consignataire" class="mr-2">
                            Consignataire
                        </label>
                    </div>
                </div>

                <!-- Justification -->
                <div class="mb-4">
                    <label class="block font-semibold">Justification</label>
                    <textarea name="justification" class="w-full border p-2 rounded" 
                              placeholder="Explique pourquoi tu veux ce rôle..." rows="3"></textarea>
                </div>

                <!-- Pièce jointe -->
                <div class="mb-4">
                    <label class="block font-semibold">Pièce justificatif</label>
                    <input type="file" name="piece_jointe" class="w-full border p-2 rounded" required>
                </div>

                <!-- Bouton -->
                <div class="text-center">
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Envoyer
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>
</body>

<footer>
    Copyright©2025 | Tous droits réservés
</footer>

</html>
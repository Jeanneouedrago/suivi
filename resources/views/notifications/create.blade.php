<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Notifications</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <style>
        footer { 
            background: black; 
            color: white; 
            padding: 10px; 
            position: fixed; 
            bottom: 0; 
            width: 100%; 
            left: 16rem; /* largeur sidebar */
            text-align: center; 
        }
        /* Bouton Envoyer */
        .btn-envoyer {
            @apply bg-blue-600 text-white font-bold py-2 px-4 rounded w-full transition;
        }
        .btn-envoyer:hover {
            background-color: red;
        }
    </style>
</head>
<body class="bg-gray-100 flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-cyan-300 text-black p-6 flex-shrink-0" x-data="{ openColis: false }">
        <h1 class="text-3xl font-bold text-pink-600 mb-8">TransitFlow</h1>
        <nav class="space-y-4">
            <!-- Dashboard -->
            <a href="{{ route('fournisseur.dashboard') }}" class="flex items-center gap-3 text-lg font-semibold hover:underline">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M4 10v10h16V10"></path>
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
                        <path d="M19 9l-7 7-7-7"></path>
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
                    <path d="M15 17h5l-1.4-1.4A2 2 0 0118 14V11a6 6 0 00-4-5.7V5a2 2 0 10-4 0v.3A6 6 0 006 11v3a2 2 0 01-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1"></path>
                </svg>
                Notifications
            </a>

            <!-- Déconnexion -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 text-lg font-semibold hover:underline w-full text-left">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 16l4-4-4-4m4 4H7m6 4v1a2 2 0 11-4 0v-1m4-8V5a2 2 0 10-4 0v1"></path>
                    </svg>
                    Déconnexion
                </button>
            </form>

            <!-- Profil -->
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 text-lg font-semibold hover:underline mt-6">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M6 20c0-2.2 3.6-4 6-4s6 1.8 6 4"></path>
                </svg>
                Mon Profil
            </a>
        </nav>
    </aside>

    <!-- Contenu principal centré -->
    <main class="flex-1 flex items-center justify-center p-6">
        <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-lg">
            <h2 class="text-2xl font-bold mb-4 text-center">Envoyer une Notification</h2>
            <div id="message"></div>
            <form id="notificationForm" class="space-y-4">
                @csrf
                <div>
                    <label class="block font-medium">Client</label>
                    <select name="receiver_id" class="w-full border rounded p-2" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-medium">Colis</label>
                    <select name="colis_id" class="w-full border rounded p-2" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach($colis as $c)
                            <option value="{{ $c->id }}">{{ $c->reference }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-medium">Titre</label>
                    <input type="text" name="title" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Message</label>
                    <textarea name="message" class="w-full border rounded p-2" rows="4" required></textarea>
                </div>
                <div>
                    <label class="block font-medium">Localisation du colis</label>
                    <div id="map" class="rounded border" style="height: 300px;"></div>
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                    <button type="button" id="locateBtn" class="mt-2 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">📍 Me localiser</button>
                </div>
               <div class="text-center">
                    <button type="submit" class="bg-cyan-500 text-white px-4 py-2 rounded hover:bg-cyan-600">
                        Envoyer
                    </button>
                </div>
            </form>
        </div>
    </main>

   <footer>
        Copyright©2025 | Tous droits réservés
    </footer>

    <!-- Leaflet + jQuery -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    var map = L.map('map').setView([12.2383, -1.5616], 6);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    var marker;

    map.on('click', function(e) {
        var lat = e.latlng.lat, lng = e.latlng.lng;
        $('#latitude').val(lat); $('#longitude').val(lng);
        if (marker) map.removeLayer(marker);
        marker = L.marker([lat, lng]).addTo(map).bindPopup("Position choisie").openPopup();
    });

    function locateUser() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(pos) {
                var lat = pos.coords.latitude, lng = pos.coords.longitude;
                map.setView([lat, lng], 14);
                if (marker) map.removeLayer(marker);
                marker = L.marker([lat, lng]).addTo(map).bindPopup("Votre position").openPopup();
                $('#latitude').val(lat); $('#longitude').val(lng);
            });
        }
    }
    $('#locateBtn').click(locateUser);
    locateUser();

    $('#notificationForm').submit(function(e){
        e.preventDefault();
        $.post("{{ route('notifications.store') }}", $(this).serialize(), function(){
            $('#message').html('<div class="p-2 bg-green-200 text-green-800 rounded">Notification envoyée !</div>');
            $('#notificationForm')[0].reset();
            if (marker) map.removeLayer(marker);
        }).fail(function(){
            alert("Erreur lors de l'envoi !");
        });
    });
    </script>
</body>
</html>

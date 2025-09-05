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
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Localisation du Colis : {{ $notification->colis->reference }}</h2>
    <div id="map" style="height: 400px;"></div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
var map = L.map('map').setView([{{ $notification->latitude ?? 0 }}, {{ $notification->longitude ?? 0 }}], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

@if($notification->latitude && $notification->longitude)
    L.marker([{{ $notification->latitude }}, {{ $notification->longitude }}]).addTo(map)
        .bindPopup("Colis : {{ $notification->colis->reference }}").openPopup();
@endif
</script>
@endsection
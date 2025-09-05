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
@endsection
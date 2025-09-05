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
                    <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" 
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
@endsection
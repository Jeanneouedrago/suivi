<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion colis</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">
    <!-- Bande bleue -->
    <div class="bg-cyan-400 w-1/5"></div>

    <!-- Contenu -->
    <div class="flex-1 p-8">
        <div class="flex justify-between items-start">
            <!-- Détails du colis -->
            <div class="border p-4 w-1/2">
                <h2 class="text-xl font-bold mb-4">Détails du colis</h2>
                <p><strong>Nom :</strong> {{ $colis->nom}}</p>
                <p><strong>Référence :</strong> {{ $colis->reference }}</p>
                <p><strong>Volume :</strong> {{ $colis->volume }}</p>
                <p><strong>Taille :</strong> {{ $colis->taille }}</p>
                <p><strong>Statut :</strong> {{ $colis->statut }}</p>
            </div>
        </div>
    </div>

</body>

 
        <footer class="mt-8 text-center text-sm text-white bg-black py-2">
            Copyright©2025 | Tous droits réservés
        </footer>
        
</html>

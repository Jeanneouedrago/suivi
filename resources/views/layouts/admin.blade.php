<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-color: #f8f9fa;
            color: #1c1c1c;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            position: fixed;
            width: 250px;
            top: 0;
            left: 0;
            padding-top: 1rem;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 2px 10px;
        }

        .sidebar a:hover {
            background-color: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }

        .sidebar a.active {
            background-color: rgba(255,255,255,0.2);
            border-left: 4px solid #fff;
        }

        .main-content {
            margin-left: 250px;
            padding: 2rem;
            min-height: 100vh;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 2rem;
            padding: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .user-info {
            padding: 1rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: auto;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }

        .role-badge {
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 12px;
            background: rgba(255,255,255,0.2);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
        }
        
        /* Bouton Envoyer */
        .btn-envoyer {
            @apply bg-blue-600 text-white font-bold py-2 px-4 rounded w-full transition;
        }
        .btn-envoyer:hover {
            background-color: red;
        }
        
        footer { 
            background: black; 
            color: white; 
            padding: 10px; 
            position: fixed; 
            bottom: 0; 
            width: 100%; 
            left: 16.4%;
            text-align: center; 
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="logo">
            @if(Auth::user()->role === 'admin')
                Admin
            @elseif(Auth::user()->role === 'fournisseur')
                Fournisseur
            @elseif(Auth::user()->role === 'consignataire')
                Consignataire
            @else
                Client
            @endif
        </div>

        <!-- Navigation selon le rôle -->
        @if(Auth::user()->role === 'admin')
            <!-- Navigation Admin -->
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-users-cog me-2"></i>
                Dashboard
            </a>
            <!-- <a href="#" class="{{ request()->routeIs('superadmin.stats.*') ? 'active' : '' }}">
                <i class="fas fa-chart-line me-2"></i>
                Gerer les demandes
            </a> -->
            <a href="{{ route('colis.index') }}" class="{{ request()->routeIs('colis.*') ? 'active' : '' }}">
                <i class="fas fa-chart-line me-2"></i>
                Liste des colis
            </a>
            <!-- <a href="#" class="{{ request()->routeIs('superadmin.stats.*') ? 'active' : '' }}">
                <i class="fas fa-chart-line me-2"></i>
                Gerer les demandes
            </a> -->
        

        @elseif(Auth::user()->role === 'fournisseur')
            <!-- Navigation Fournisseur -->
            <a href="{{ route('fournisseur.dashboard') }}" class="{{ request()->routeIs('fournisseur.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i>
                Dashboard
            </a>
            <a href="{{ route('colis.index') }}" class="{{ request()->routeIs('colis.*') ? 'active' : '' }}">
                <i class="fas fa-building me-2"></i>
                Gestion colis
            </a>
            <a href="{{ route('notifications.create') }}" class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                <i class="fas fa-user-graduate me-2"></i>
                Notification
            </a>
            

        @elseif(Auth::user()->role === 'consignataire')
            <!-- Navigation Consignataire -->
            <a href="{{ route('consignataire.dashboard') }}" class="{{ request()->routeIs('consignataire.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i>
                Dashboard
            </a>
            <a href="{{ route('colis.index') }}" class="{{ request()->routeIs('colis.*') ? 'active' : '' }}">
                <i class="fas fa-briefcase me-2"></i>
                Liste des colis
            </a>
            <a href="{{ route('notifications.create') }}" class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                <i class="fas fa-plus me-2"></i>
                Notification
            </a>
           
            

        @else
            <!-- Navigation Client -->
            <a href="{{ route('client.dashboard') }}" class="{{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i>
                Dashboard
            </a>
            <a href="{{ route('colis.index') }}" class="{{ request()->routeIs('colis.*') ? 'active' : '' }}">
                <i class="fas fa-search me-2"></i>
                Mes colis
            </a>
            <a href="{{ route('notifications.create') }}" class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                <i class="fas fa-paper-plane me-2"></i>
                Mes notifications
            </a>
            
            
        @endif

        <!-- Section commune -->
        <div style="margin-top: 2rem;">
            <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="fas fa-user-cog me-2"></i>
                Paramètres
            </a>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt me-2"></i>
                Déconnexion
            </a>
        </div>

        <!-- Informations utilisateur -->
        <div class="user-info">
            <div class="d-flex align-items-center">
                <div class="user-avatar">
                    <span class="fw-bold">{{ strtoupper(substr(Auth::user()->nom, 0, 1) . substr(Auth::user()->prenom, 0, 1)) }}</span>
                </div>
                <div>
                    <div class="fw-bold">{{ Auth::user()->nom }} {{ Auth::user()->prenom }}</div>
                    <div class="small">{{ Auth::user()->email }}</div>
                    <div class="role-badge">
                        @if(Auth::user()->role === 'admin')
                            Admin
                        @elseif(Auth::user()->role === 'fournisseur')
                            Fournisseur
                        @elseif(Auth::user()->role === 'consignataire')
                            Consignataire
                        @else
                            Client
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <div class="main-content">
        @yield('content')
    </div>
    
    <footer>
        Copyright©2025 | Tous droits réservés
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
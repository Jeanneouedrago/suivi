<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            <a href="#" class="{{ request()->routeIs('superadmin.*') ? 'active' : '' }}">
                <i class="fas fa-users-cog me-2"></i>
                Gérer les utilisateurs
            </a>
            <a href="#" class="{{ request()->routeIs('superadmin.stats.*') ? 'active' : '' }}">
                <i class="fas fa-chart-line me-2"></i>
                Gerer les demandes
            </a>
        

        @elseif(Auth::user()->role === 'fournisseur')
            <!-- Navigation Fournisseur -->
            <a href="#" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i>
                Dashboard
            </a>
            <a href="#" class="{{ request()->routeIs('admin.entreprises.*') ? 'active' : '' }}">
                <i class="fas fa-building me-2"></i>
                Gestion colis
            </a>
            <a href="#" class="{{ request()->routeIs('admin.etudiants.*') ? 'active' : '' }}">
                <i class="fas fa-user-graduate me-2"></i>
                Notification
            </a>
            

        @elseif(Auth::user()->role === 'consignataire')
            <!-- Navigation Consignataire -->
            <a href="#" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i>
                Dashboard
            </a>
            <a href="#" class="{{ request()->routeIs('stages.*') ? 'active' : '' }}">
                <i class="fas fa-briefcase me-2"></i>
                Liste des colis
            </a>
            <a href="#" class="{{ request()->routeIs('stages.create') ? 'active' : '' }}">
                <i class="fas fa-plus me-2"></i>
                Notification
            </a>
           
            

        @else
            <!-- Navigation Client -->
            <a href="#" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i>
                Dashboard
            </a>
            <a href="#" class="{{ request()->routeIs('stages.*') ? 'active' : '' }}">
                <i class="fas fa-search me-2"></i>
                Mes colis
            </a>
            <a href="#" class="{{ request()->routeIs('candidatures.mes-candidatures') ? 'active' : '' }}">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
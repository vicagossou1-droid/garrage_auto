<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestion du Garage')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .sidebar {
            background-color: #fff;
            border-right: 1px solid #dee2e6;
            padding: 20px;
            min-height: 100vh;
        }

        .sidebar a {
            display: block;
            padding: 10px 15px;
            margin-bottom: 5px;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #e9ecef;
        }

        .sidebar a.active {
            background-color: #0d6efd;
            color: white;
        }

        .content {
            padding: 20px;
        }

        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-group-custom {
            display: flex;
            gap: 5px;
        }

        .alert {
            border-radius: 5px;
        }

        h1,
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
    </style>
    @yield('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('accueil') }}">
                <i class="bi bi-tools"></i> Gestion du Garage
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="bi bi-graph-up"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('vehicules.index') }}">Véhicules</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('techniciens.index') }}">Techniciens</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reparations.index') }}">Réparations</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <strong><i class="bi bi-check-circle"></i> Succès!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <strong><i class="bi bi-exclamation-triangle"></i> Erreur!</strong> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-light py-4 mt-5 border-top">
        <div class="container text-center">
            <p class="text-muted mb-0">© 2026 Gestion du Garage. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>
@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="hero-section bg-gradient p-5 rounded-lg mb-5" style="background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%); color: black; animation: slideUp 0.6s ease;">
    <div class="container text-center py-5">
        <h1 class="display-3 fw-bold mb-4" style="animation: fadeIn 0.8s ease; color: black;">
            <i class="bi bi-tools-alt"></i> Bienvenue chez AKVA-Auto
        </h1>
        <p class="lead mb-4" style="font-size: 1.3rem; color: black;">
            Votre partenaire de confiance pour l'entretien et la réparation de votre véhicule
        </p>
        <div class="d-flex justify-content-center gap-3">
            @if (auth()->check())
            @if (auth()->user()->type_utilisateur === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-lg">
                <i class="bi bi-speedometer2"></i> Dashboard Admin
            </a>
            @elseif (auth()->user()->type_utilisateur === 'technicien')
            <a href="{{ route('technicien.dashboard') }}" class="btn btn-light btn-lg">
                <i class="bi bi-wrench"></i> Mon Tableau de Bord
            </a>
            @else
            <a href="{{ route('client.dashboard') }}" class="btn btn-light btn-lg">
                <i class="bi bi-person-circle"></i> Mon Espace
            </a>
            @endif
            @else
            <a href="{{ route('login') }}" class="btn btn-light btn-lg">
                <i class="bi bi-box-arrow-in-right"></i> Se Connecter
            </a>
            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
                <i class="bi bi-person-plus"></i> S'Inscrire
            </a>
            @endif
        </div>
    </div>
</div>

<!-- Services Section -->
<div class="services-section mb-5">
    <h2 class="text-center mb-5 fw-bold">Nos Services</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card text-center shadow-lg h-100">
                <div class="card-body p-5">
                    <i class="bi bi-wrench display-4 text-primary mb-3"></i>
                    <h5 class="card-title">Réparation</h5>
                    <p class="card-text">Réparations complètes et efficaces par nos techniciens expérimentés.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-lg h-100">
                <div class="card-body p-5">
                    <i class="bi bi-gear display-4 text-primary mb-3"></i>
                    <h5 class="card-title">Entretien</h5>
                    <p class="card-text">Entretien régulier pour prolonger la durée de vie de votre véhicule.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-lg h-100">
                <div class="card-body p-5">
                    <i class="bi bi-speedometer2 display-4 text-primary mb-3"></i>
                    <h5 class="card-title">Diagnostic</h5>
                    <p class="card-text">Diagnostic complet avec équipement moderne pour identifier les problèmes.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Why Us Section -->
<div class="why-us-section mb-5 p-5 bg-light rounded">
    <h2 class="text-center mb-5 fw-bold">Pourquoi nous choisir ?</h2>
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="d-flex">
                <div class="me-3">
                    <i class="bi bi-check-circle-fill text-success display-5"></i>
                </div>
                <div>
                    <h5>Experts Qualifiés</h5>
                    <p>Notre équipe de techniciens est formée et expérimentée dans tous les types de réparations.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="d-flex">
                <div class="me-3">
                    <i class="bi bi-check-circle-fill text-success display-5"></i>
                </div>
                <div>
                    <h5>Prix Compétitifs</h5>
                    <p>Nous offrons les meilleurs prix sans compromettre la qualité du travail.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="d-flex">
                <div class="me-3">
                    <i class="bi bi-check-circle-fill text-success display-5"></i>
                </div>
                <div>
                    <h5>Transparence</h5>
                    <p>Devis détaillés et explications claires avant chaque intervention.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="d-flex">
                <div class="me-3">
                    <i class="bi bi-check-circle-fill text-success display-5"></i>
                </div>
                <div>
                    <h5>Service Rapide</h5>
                    <p>Délais courts pour les réparations sans sacrifier la qualité.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tips Section -->
@if ($conseils->count() > 0)
<div class="tips-section mb-5">
    <h2 class="text-center mb-5 fw-bold">Conseils & Astuces</h2>
    <div class="row g-4">
        @foreach ($conseils as $conseil)
        <div class="col-md-4">
            <div class="card h-100 shadow">
                @if ($conseil->image)
                <img src="{{ asset('storage/' . $conseil->image) }}" class="card-img-top" alt="{{ $conseil->titre }}">
                @else
                <div class="bg-primary text-white p-5 text-center">
                    <i class="bi bi-lightbulb display-4"></i>
                </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $conseil->titre }}</h5>
                    <p class="card-text">{{ substr(strip_tags($conseil->contenu), 0, 100) }}...</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Testimonials Section -->
@if ($avis->count() > 0)
<div class="testimonials-section mb-5">
    <h2 class="text-center mb-5 fw-bold">Avis de nos Clients</h2>
    <div class="row g-4">
        @foreach ($avis as $avis)
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="card-title mb-0">{{ $avis->client->utilisateur->nom_complet ?? 'Client' }}</h5>
                            <small class="text-muted">{{ $avis->date_avis->diffForHumans() }}</small>
                        </div>
                        <span class="badge bg-warning">
                            @for ($i = 1; $i <= $avis->note; $i++)
                                <i class="bi bi-star-fill"></i>
                                @endfor
                        </span>
                    </div>
                    <p class="card-text">{{ $avis->commentaire }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Contact Section -->
<div class="contact-section mb-5 p-5 bg-gradient rounded" style="background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%); color: black;">
    <div class="text-center">
        <h2 class="fw-bold mb-4" style="color: black;">Nous Contacter</h2>
        <div class="row">
            <div class="col-md-4 mb-3">
                <i class="bi bi-telephone display-5 mb-3" style="color: black;"></i>
                <p><a href="tel:+22896849538" class="text-dark" style="text-decoration: none; color: black;">+228 96 84 95 38</a></p>
            </div>
            <div class="col-md-4 mb-3">
                <i class="bi bi-envelope display-5 mb-3" style="color: black;"></i>
                <p><a href="mailto:akvaservice.tg@gmail.com" class="text-dark" style="text-decoration: none; color: black;">akvaservice.tg@gmail.com</a></p>
            </div>
            <div class="col-md-4 mb-3">
                @if (auth()->check() && auth()->user()->type_utilisateur === 'client')
                <a href="{{ route('contact') }}" class="btn btn-dark btn-lg">
                    <i class="bi bi-chat-dots"></i> Envoyer un message
                </a>
                @else
                <a href="{{ route('register') }}" class="btn btn-outline-dark btn-lg">
                    <i class="bi bi-person-plus"></i> S'inscrire pour contacter
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .card {
        cursor: pointer;
    }

    .card:hover {
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2) !important;
    }
</style>
@endsection
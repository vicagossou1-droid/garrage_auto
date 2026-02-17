@extends('app')

@section('title', 'Accueil - Gestion du Garage')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="mb-4" style="color: black;">Bienvenue dans la gestion du garage</h1>
        <p class="lead mb-4">Système complet de gestion des véhicules, techniciens et réparations</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-center h-100" style="transition: transform 0.2s;">
            <div class="card-body">
                <i class="bi bi-graph-up" style="font-size: 3rem; color: #6f42c1; margin-bottom: 15px;"></i>
                <h5 class="card-title">Dashboard</h5>
                <p class="card-text text-muted">Voir les statistiques et graphiques</p>
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Accéder</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center h-100" style="transition: transform 0.2s;">
            <div class="card-body">
                <i class="bi bi-car-front" style="font-size: 3rem; color: #0d6efd; margin-bottom: 15px;"></i>
                <h5 class="card-title">Véhicules</h5>
                <p class="card-text text-muted">Gérez tous les véhicules du garage</p>
                <a href="{{ route('vehicules.index') }}" class="btn btn-primary">Accéder</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center h-100" style="transition: transform 0.2s;">
            <div class="card-body">
                <i class="bi bi-person-badge" style="font-size: 3rem; color: #28a745; margin-bottom: 15px;"></i>
                <h5 class="card-title">Techniciens</h5>
                <p class="card-text text-muted">Gérez l'équipe de techniciens</p>
                <a href="{{ route('techniciens.index') }}" class="btn btn-success">Accéder</a>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-center h-100" style="transition: transform 0.2s;">
            <div class="card-body">
                <i class="bi bi-tools" style="font-size: 3rem; color: #ffc107; margin-bottom: 15px;"></i>
                <h5 class="card-title">Réparations</h5>
                <p class="card-text text-muted">Suivi des réparations effectuées</p>
                <a href="{{ route('reparations.index') }}" class="btn btn-warning">Accéder</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-12">
        <div class="alert alert-info">
            <h4 class="alert-heading"><i class="bi bi-info-circle"></i> À propos</h4>
            <p>
                Cette application vous permet de gérer complètement votre garage de réparation automobile.
                Vous pouvez enregistrer les véhicules, gérer votre équipe de techniciens, et suivre
                toutes les réparations effectuées. Consultez le dashboard pour voir les statistiques
                et les performances du garage.
            </p>
        </div>
    </div>
</div>
@endsection
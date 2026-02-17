@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Nous Contacter</h3>
                </div>
                <div class="card-body p-5">
                    <p class="text-muted mb-4">
                        Avez-vous des questions ou besoin de nos services ? Remplissez le formulaire ci-dessous et nous vous répondrons dans les plus brefs délais.
                    </p>

                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom Complet</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="tel" class="form-control" id="telephone" name="telephone">
                        </div>

                        <div class="mb-3">
                            <label for="sujet" class="form-label">Sujet</label>
                            <input type="text" class="form-control" id="sujet" name="sujet" required>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-send"></i> Envoyer le message
                        </button>
                    </form>
                </div>
            </div>

            <!-- Info Section -->
            <div class="row g-4 mt-5">
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="bi bi-telephone display-5 text-primary mb-3"></i>
                            <h5>Téléphone</h5>
                            <p><a href="tel:+22896849538">+228 96 84 95 38</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="bi bi-envelope display-5 text-primary mb-3"></i>
                            <h5>Email</h5>
                            <p><a href="mailto:akvaservice.tg@gmail.com">akvaservice.tg@gmail.com</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="bi bi-geo-alt display-5 text-primary mb-3"></i>
                            <h5>Localisation</h5>
                            <p>Togo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
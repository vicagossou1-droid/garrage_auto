<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ReparationController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\TechnicienController;
use App\Http\Controllers\Admin\ReparationAssignmentController;
use App\Http\Controllers\Admin\VehiculeController;
use App\Http\Controllers\Client\ClientDashboardController;
use App\Http\Controllers\Technicien\TechnicienDashboardController;

// Routes publiques
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact', [HomeController::class, 'contact'])->middleware('client')->name('contact');
Route::post('/contact', [HomeController::class, 'storeContact'])->middleware('client')->name('contact.store');

// Routes d'authentification
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Redirection intelligente du dashboard
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->type_utilisateur === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->type_utilisateur === 'technicien') {
        return redirect()->route('technicien.dashboard');
    } else {
        return redirect()->route('client.dashboard');
    }
})->middleware('auth')->name('dashboard');

// Routes Admin (Admin uniquement)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // CRUD Réparations
    Route::resource('reparations', ReparationController::class);
    Route::get('/reparations/{reparation}/assign', [ReparationAssignmentController::class, 'showAssign'])->name('reparations.assign');
    Route::post('/reparations/{reparation}/assign', [ReparationAssignmentController::class, 'assign'])->name('reparations.assign.store');
    Route::delete('/reparations/{reparation}/unassign/{technicienId}', [ReparationAssignmentController::class, 'unassign'])->name('reparations.unassign');

    // CRUD Clients
    Route::resource('clients', ClientController::class);

    // CRUD Techniciens
    Route::resource('techniciens', TechnicienController::class);

    // CRUD Véhicules
    Route::resource('vehicules', VehiculeController::class);
});

// Routes Technicien (Techniciens uniquement)
Route::middleware(['auth', 'technicien'])->prefix('technicien')->name('technicien.')->group(function () {
    Route::get('/dashboard', [TechnicienDashboardController::class, 'index'])->name('dashboard');
    Route::get('/interventions', [TechnicienDashboardController::class, 'showAllInterventions'])->name('interventions');
    Route::get('/reparations-assignees', [TechnicienDashboardController::class, 'showAssignedRepairs'])->name('reparations-assignees');
    Route::post('/reparations/{reparation}/start', [TechnicienDashboardController::class, 'startRepair'])->name('reparations.start');
    Route::post('/reparations/{reparation}/complete', [TechnicienDashboardController::class, 'completeRepair'])->name('reparations.complete');
    Route::put('/interventions/{intervention}/duration', [TechnicienDashboardController::class, 'updateDuration'])->name('interventions.updateDuration');
});

// Routes Client (Clients uniquement)
Route::middleware(['auth', 'client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');

    // Routes spécifiques (avant les routes paramétrées)
    Route::get('/vehicules/create', [ClientDashboardController::class, 'createVehicule'])->name('vehicules.create');

    // Routes paramétrées
    Route::get('/reparations/{reparation}', [ClientDashboardController::class, 'showReparation'])->name('reparations.show');
    Route::get('/vehicules/{vehicule}', [ClientDashboardController::class, 'showVehicule'])->name('vehicules.show');
    Route::get('/vehicules/{vehicule}/edit', [ClientDashboardController::class, 'editVehicule'])->name('vehicules.edit');
    Route::put('/vehicules/{vehicule}', [ClientDashboardController::class, 'updateVehicule'])->name('vehicules.update');
    Route::post('/vehicules', [ClientDashboardController::class, 'storeVehicule'])->name('vehicules.store');
});

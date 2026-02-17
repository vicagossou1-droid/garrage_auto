<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicule;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class VehiculeController extends Controller
{
    /**
     * Display a listing of vehicles.
     */
    public function index(): View
    {
        $vehicules = Vehicule::with('client')
            ->paginate(15);

        return view('admin.vehicules.index', compact('vehicules'));
    }

    /**
     * Show the form for creating a new vehicle.
     */
    public function create(): View
    {
        $clients = Client::with('utilisateur')->get();
        return view('admin.vehicules.create', compact('clients'));
    }

    /**
     * Store a newly created vehicle in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'marque' => 'required|string',
            'modele' => 'required|string',
            'plaque_immatriculation' => 'required|unique:vehicules',
            'couleur' => 'nullable|string',
            'annee' => 'nullable|integer',
            'kilometrage' => 'nullable|integer',
            'energie' => 'nullable|string',
        ]);

        Vehicule::create($validated);

        return redirect()->route('admin.vehicules.index')
            ->with('success', 'Véhicule créé avec succès');
    }

    /**
     * Display the specified vehicle.
     */
    public function show(Vehicule $vehicule): View
    {
        $vehicule->load('client', 'reparations');
        return view('admin.vehicules.show', compact('vehicule'));
    }

    /**
     * Show the form for editing the specified vehicle.
     */
    public function edit(Vehicule $vehicule): View
    {
        $clients = Client::with('utilisateur')->get();
        return view('admin.vehicules.edit', compact('vehicule', 'clients'));
    }

    /**
     * Update the specified vehicle in storage.
     */
    public function update(Request $request, Vehicule $vehicule): RedirectResponse
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'marque' => 'required|string',
            'modele' => 'required|string',
            'plaque_immatriculation' => 'required|unique:vehicules,plaque_immatriculation,' . $vehicule->id,
            'couleur' => 'nullable|string',
            'annee' => 'nullable|integer',
            'kilometrage' => 'nullable|integer',
            'energie' => 'nullable|string',
        ]);

        $vehicule->update($validated);

        return redirect()->route('admin.vehicules.show', $vehicule)
            ->with('success', 'Véhicule mis à jour avec succès');
    }

    /**
     * Remove the specified vehicle from storage.
     */
    public function destroy(Vehicule $vehicule): RedirectResponse
    {
        $vehicule->delete();

        return redirect()->route('admin.vehicules.index')
            ->with('success', 'Véhicule supprimé avec succès');
    }
}

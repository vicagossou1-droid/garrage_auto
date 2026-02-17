<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Utilisateur;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ClientController extends Controller
{
    /**
     * Display a listing of clients.
     */
    public function index(): View
    {
        $clients = Client::with('utilisateur')
            ->paginate(15);

        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new client.
     */
    public function create(): View
    {
        return view('admin.clients.create');
    }

    /**
     * Store a newly created client in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:utilisateurs',
            'telephone' => 'nullable|string',
            'adresse' => 'nullable|string',
            'ville' => 'nullable|string',
            'code_postal' => 'nullable|string',
            'marque' => 'required|string',
            'modele' => 'required|string',
            'plaque_immatriculation' => 'required|string|unique:vehicules',
            'couleur' => 'nullable|string',
            'annee' => 'required|integer',
            'kilometrage' => 'required|integer',
            'type_carrosserie' => 'nullable|string',
            'energie' => 'required|string',
            'numero_chassis' => 'nullable|string',
        ]);

        $utilisateur = Utilisateur::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'] ?? '',
            'password' => bcrypt('client123'),
            'type_utilisateur' => 'client',
            'statut' => 'actif',
        ]);

        $client = Client::create([
            'utilisateur_id' => $utilisateur->id,
            'adresse' => $validated['adresse'] ?? '',
            'ville' => $validated['ville'] ?? '',
            'code_postal' => $validated['code_postal'] ?? '',
        ]);

        // Create vehicle (now mandatory)
        Vehicule::create([
            'client_id' => $client->id,
            'marque' => $validated['marque'],
            'modele' => $validated['modele'],
            'plaque_immatriculation' => $validated['plaque_immatriculation'],
            'couleur' => $validated['couleur'] ?? '',
            'annee' => $validated['annee'],
            'kilometrage' => $validated['kilometrage'],
            'type_carrosserie' => $validated['type_carrosserie'] ?? '',
            'energie' => $validated['energie'],
            'numero_chassis' => $validated['numero_chassis'] ?? '',
        ]);

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client créé avec succès');
    }

    /**
     * Display the specified client.
     */
    public function show(Client $client): View
    {
        $client->load('utilisateur', 'vehicules', 'reparations');
        return view('admin.clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit(Client $client): View
    {
        $client->load('utilisateur');
        return view('admin.clients.edit', compact('client'));
    }

    /**
     * Update the specified client in storage.
     */
    public function update(Request $request, Client $client): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:utilisateurs,email,' . $client->utilisateur_id,
            'telephone' => 'nullable|string',
            'adresse' => 'nullable|string',
            'ville' => 'nullable|string',
        ]);

        $client->utilisateur->update([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'] ?? '',
        ]);

        $client->update([
            'adresse' => $validated['adresse'] ?? '',
            'ville' => $validated['ville'] ?? '',
        ]);

        return redirect()->route('admin.clients.show', $client)
            ->with('success', 'Client mis à jour avec succès');
    }

    /**
     * Remove the specified client from storage.
     */
    public function destroy(Client $client): RedirectResponse
    {
        $client->utilisateur->delete();
        $client->delete();

        return redirect()->route('admin.clients.index')
            ->with('success', 'Client supprimé avec succès');
    }
}

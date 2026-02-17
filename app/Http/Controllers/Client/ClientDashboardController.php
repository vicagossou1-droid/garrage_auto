<?php

namespace App\Http\Controllers\Client;

use App\Models\Client;
use App\Models\Reparation;
use App\Models\Vehicule;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClientDashboardController extends Controller
{
    /**
     * Display the client dashboard.
     */
    public function index(): View
    {
        $utilisateur = Auth::user();
        $client = Client::where('utilisateur_id', $utilisateur->id)->first();

        $statistiques = [
            'vehicules' => $client->vehicules()->count(),
            'reparations_en_cours' => $client->reparations()->where('statut', 'en_cours')->count(),
            'reparations_terminees' => $client->reparations()->where('statut', 'termine')->count(),
        ];

        $reparations = $client->reparations()
            ->with('vehicule', 'devis')
            ->orderBy('date_depot', 'desc')
            ->paginate(10);

        $vehicules = $client->vehicules()->paginate(10);

        return view('client.dashboard', compact('statistiques', 'reparations', 'vehicules'));
    }

    /**
     * Display repair details.
     */
    public function showReparation(Reparation $reparation): View
    {
        $utilisateur = Auth::user();
        $client = Client::where('utilisateur_id', $utilisateur->id)->first();

        // Vérifier que la réparation appartient au client
        if ($reparation->client_id !== $client->id) {
            abort(403, 'Accès non autorisé');
        }

        $reparation->load('vehicule', 'devis', 'interventions.technicien.utilisateur', 'recu');

        return view('client.reparation-details', compact('reparation'));
    }

    /**
     * Display vehicle details.
     */
    public function showVehicule(Vehicule $vehicule): View
    {
        $utilisateur = Auth::user();
        $client = Client::where('utilisateur_id', $utilisateur->id)->first();

        // Vérifier que le véhicule appartient au client
        if ($vehicule->client_id !== $client->id) {
            abort(403, 'Accès non autorisé');
        }

        $vehicule->load('reparations');
        $reparations = $vehicule->reparations()
            ->orderBy('date_depot', 'desc')
            ->paginate(10);

        return view('client.vehicule-details', compact('vehicule', 'reparations'));
    }

    /**
     * Show form to edit a vehicle.
     */
    public function editVehicule(Vehicule $vehicule): View
    {
        $utilisateur = Auth::user();
        $client = Client::where('utilisateur_id', $utilisateur->id)->first();

        // Vérifier que le véhicule appartient au client
        if ($vehicule->client_id !== $client->id) {
            abort(403, 'Accès non autorisé');
        }

        return view('client.vehicule-edit', compact('vehicule'));
    }

    /**
     * Update a vehicle.
     */
    public function updateVehicule(Vehicule $vehicule): \Illuminate\Http\RedirectResponse
    {
        $utilisateur = Auth::user();
        $client = Client::where('utilisateur_id', $utilisateur->id)->first();

        // Vérifier que le véhicule appartient au client
        if ($vehicule->client_id !== $client->id) {
            abort(403, 'Accès non autorisé');
        }

        $validated = request()->validate([
            'marque' => 'required|string',
            'modele' => 'required|string',
            'annee' => 'required|integer|min:1900|max:' . date('Y'),
            'couleur' => 'nullable|string',
            'kilometrage' => 'required|integer|min:0',
            'energie' => 'required|string',
            'plaque_immatriculation' => 'required|string|unique:vehicules,plaque_immatriculation,' . $vehicule->id,
            'numero_vin' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if (request()->hasFile('image')) {
            // Delete old image if exists
            if ($vehicule->image) {
                Storage::disk('public')->delete($vehicule->image);
            }
            $validated['image'] = request()->file('image')->store('vehicules', 'public');
        }

        $vehicule->update($validated);

        return redirect()->route('client.vehicules.show', $vehicule)
            ->with('success', 'Véhicule mis à jour avec succès');
    }

    /**
     * Show form to create a new vehicle.
     */
    public function createVehicule(): View
    {
        return view('client.vehicule-create');
    }

    /**
     * Store a new vehicle.
     */
    public function storeVehicule(): \Illuminate\Http\RedirectResponse
    {
        $utilisateur = Auth::user();
        $client = Client::where('utilisateur_id', $utilisateur->id)->first();

        $validated = request()->validate([
            'marque' => 'required|string',
            'modele' => 'required|string',
            'annee' => 'required|integer|min:1900|max:' . date('Y'),
            'couleur' => 'nullable|string',
            'kilometrage' => 'required|integer|min:0',
            'energie' => 'required|string',
            'plaque_immatriculation' => 'required|string|unique:vehicules,plaque_immatriculation',
            'numero_vin' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if (request()->hasFile('image')) {
            $validated['image'] = request()->file('image')->store('vehicules', 'public');
        }

        $validated['client_id'] = $client->id;

        $vehicule = Vehicule::create($validated);

        return redirect()->route('client.vehicules.show', $vehicule)
            ->with('success', 'Véhicule ajouté avec succès');
    }
}

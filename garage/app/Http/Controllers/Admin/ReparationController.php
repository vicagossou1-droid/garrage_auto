<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reparation;
use App\Models\Vehicule;
use App\Models\Technicien;
use App\Models\InterventionTechnicien;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ReparationController extends Controller
{
    /**
     * Display a listing of repairs.
     */
    public function index(Request $request): View
    {
        $query = Reparation::with('vehicule', 'client');

        // Filter by status if provided
        if ($request->has('statut') && !empty($request->statut)) {
            $query->where('statut', $request->statut);
        }

        $reparations = $query->orderBy('date_depot', 'desc')
            ->paginate(15);

        return view('admin.reparations.index', compact('reparations'));
    }

    /**
     * Show the form for creating a new repair.
     */
    public function create(): View
    {
        $vehicules = Vehicule::with('client')->get();
        $techniciens = Technicien::with('utilisateur')->where('statut', '!=', 'conge')->get();
        return view('admin.reparations.create', compact('vehicules', 'techniciens'));
    }

    /**
     * Store a newly created repair in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'description_panne' => 'required|string',
            'estimation_cout' => 'nullable|numeric',
            'date_fin_prevue' => 'nullable|date',
            'technicien_id' => 'required|exists:techniciens,id',
        ]);

        // Get client_id from vehicule
        $vehicule = Vehicule::findOrFail($validated['vehicule_id']);
        $validated['client_id'] = $vehicule->client_id;

        $technicien_id = $validated['technicien_id'];
        unset($validated['technicien_id']);

        $reparation = Reparation::create($validated);

        // If technician is selected, create intervention
        if ($technicien_id) {
            InterventionTechnicien::create([
                'reparation_id' => $reparation->id,
                'technicien_id' => $technicien_id,
            ]);
        }

        return redirect()->route('admin.reparations.index')
            ->with('success', 'Réparation créée avec succès');
    }

    /**
     * Display the specified repair.
     */
    public function show(Reparation $reparation): View
    {
        $reparation->load('vehicule', 'client', 'interventions.technicien');
        return view('admin.reparations.show', compact('reparation'));
    }

    /**
     * Show the form for editing the specified repair.
     */
    public function edit(Reparation $reparation): View
    {
        $vehicules = Vehicule::with('client')->get();
        $techniciens = Technicien::with('utilisateur')->where('statut', '!=', 'conge')->get();
        $current_technicien = $reparation->interventions()->first()?->technicien_id;
        return view('admin.reparations.edit', compact('reparation', 'vehicules', 'techniciens', 'current_technicien'));
    }

    /**
     * Update the specified repair in storage.
     */
    public function update(Request $request, Reparation $reparation): RedirectResponse
    {
        $validated = $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'description_panne' => 'required|string',
            'statut' => 'required|in:en_attente,en_cours,termine,livree,annulee',
            'estimation_cout' => 'nullable|numeric',
            'cout_final' => 'nullable|numeric',
            'date_fin_prevue' => 'nullable|date',
            'date_fin_reelle' => 'nullable|date',
            'technicien_id' => 'required|exists:techniciens,id',
        ]);

        $technicien_id = $validated['technicien_id'];
        unset($validated['technicien_id']);

        $reparation->update($validated);

        // Update intervention if technician is specified
        if ($technicien_id) {
            $intervention = $reparation->interventions()->first();
            if ($intervention !== null) {
                $intervention->update(['technicien_id' => $technicien_id]);
            } else {
                InterventionTechnicien::create([
                    'reparation_id' => $reparation->id,
                    'technicien_id' => $technicien_id,
                ]);
            }
        } else {
            // Remove intervention if no technician is specified
            $reparation->interventions()->delete();
        }

        return redirect()->route('admin.reparations.show', $reparation)
            ->with('success', 'Réparation mise à jour avec succès');
    }

    /**
     * Remove the specified repair from storage.
     */
    public function destroy(Reparation $reparation): RedirectResponse
    {
        $reparation->delete();

        return redirect()->route('admin.reparations.index')
            ->with('success', 'Réparation supprimée avec succès');
    }
}

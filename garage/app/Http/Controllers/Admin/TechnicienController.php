<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Technicien;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TechnicienController extends Controller
{
    /**
     * Display a listing of technicians.
     */
    public function index(): View
    {
        $techniciens = Technicien::with('utilisateur')
            ->paginate(15);

        return view('admin.techniciens.index', compact('techniciens'));
    }

    /**
     * Show the form for creating a new technician.
     */
    public function create(): View
    {
        return view('admin.techniciens.create');
    }

    /**
     * Store a newly created technician in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:utilisateurs',
            'telephone' => 'nullable|string',
            'specialite' => 'required|string',
            'taux_horaire' => 'nullable|numeric',
        ]);

        $utilisateur = \App\Models\Utilisateur::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'] ?? '',
            'password' => bcrypt('technicien123'),
            'type_utilisateur' => 'technicien',
            'statut' => 'actif',
        ]);

        Technicien::create([
            'utilisateur_id' => $utilisateur->id,
            'specialite' => $validated['specialite'] ?? '',
            'taux_horaire' => $validated['taux_horaire'] ?? 0,
        ]);

        return redirect()->route('admin.techniciens.index')
            ->with('success', 'Technicien créé avec succès');
    }

    /**
     * Display the specified technician.
     */
    public function show(Technicien $technicien): View
    {
        $technicien->load('utilisateur', 'interventions');
        return view('admin.techniciens.show', compact('technicien'));
    }

    /**
     * Show the form for editing the specified technician.
     */
    public function edit(Technicien $technicien): View
    {
        $technicien->load('utilisateur');
        return view('admin.techniciens.edit', compact('technicien'));
    }

    /**
     * Update the specified technician in storage.
     */
    public function update(Request $request, Technicien $technicien): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:utilisateurs,email,' . $technicien->utilisateur_id,
            'telephone' => 'nullable|string',
            'specialite' => 'nullable|string',
            'taux_horaire' => 'nullable|numeric',
        ]);

        $technicien->utilisateur->update([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'] ?? '',
        ]);

        $technicien->update([
            'specialite' => $validated['specialite'] ?? '',
            'taux_horaire' => $validated['taux_horaire'] ?? 0,
        ]);

        return redirect()->route('admin.techniciens.show', $technicien)
            ->with('success', 'Technicien mis à jour avec succès');
    }

    /**
     * Remove the specified technician from storage.
     */
    public function destroy(Technicien $technicien): RedirectResponse
    {
        $technicien->utilisateur->delete();
        $technicien->delete();

        return redirect()->route('admin.techniciens.index')
            ->with('success', 'Technicien supprimé avec succès');
    }
}

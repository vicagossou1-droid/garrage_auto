<?php

namespace App\Http\Controllers\Technicien;

use App\Models\Technicien;
use App\Models\InterventionTechnicien;
use App\Models\Reparation;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TechnicienDashboardController extends Controller
{
    /**
     * Display the technician dashboard.
     */
    public function index(): View
    {
        $utilisateur = Auth::user();
        $technicien = Technicien::where('utilisateur_id', $utilisateur->id)->first();

        $statistiques = [
            'interventions_total' => InterventionTechnicien::where('technicien_id', $technicien->id)
                ->whereHas('reparation', function ($query) {
                    $query->whereIn('statut', ['en_cours', 'termine']);
                })
                ->count(),
            'heures_travaillees' => InterventionTechnicien::where('technicien_id', $technicien->id)
                ->whereHas('reparation', function ($query) {
                    $query->whereIn('statut', ['en_cours', 'termine']);
                })
                ->sum('duree_minutes') / 60,
            'reparations_assignees' => InterventionTechnicien::where('technicien_id', $technicien->id)
                ->whereHas('reparation', function ($query) {
                    $query->where('statut', 'en_cours');
                })
                ->count(),
        ];

        $interventions = InterventionTechnicien::where('technicien_id', $technicien->id)
            ->whereHas('reparation', function ($query) {
                $query->whereIn('statut', ['en_cours', 'termine']);
            })
            ->with('reparation.vehicule', 'reparation.client')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('technicien.dashboard', compact('statistiques', 'interventions', 'technicien'));
    }

    /**
     * Display all interventions for the technician.
     */
    public function showAllInterventions(): View
    {
        $utilisateur = Auth::user();
        $technicien = Technicien::where('utilisateur_id', $utilisateur->id)->first();

        $interventions = InterventionTechnicien::where('technicien_id', $technicien->id)
            ->whereHas('reparation', function ($query) {
                $query->whereIn('statut', ['en_cours', 'termine']);
            })
            ->with('reparation.vehicule', 'reparation.client')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('technicien.interventions', compact('interventions', 'technicien'));
    }

    /**
     * Display assigned repairs for the technician.
     */
    public function showAssignedRepairs(): View
    {
        $utilisateur = Auth::user();
        $technicien = Technicien::where('utilisateur_id', $utilisateur->id)->first();

        $reparations = InterventionTechnicien::where('technicien_id', $technicien->id)
            ->whereHas('reparation', function ($query) {
                $query->whereIn('statut', ['en_cours', 'termine']);
            })
            ->with('reparation.vehicule', 'reparation.client')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('technicien.reparations-assignees', compact('reparations', 'technicien'));
    }

    /**
     * Start a repair and change its status to 'en_cours'.
     */
    public function startRepair(Reparation $reparation): RedirectResponse
    {
        $utilisateur = Auth::user();
        $technicien = Technicien::where('utilisateur_id', $utilisateur->id)->first();

        // Verify that the repair is assigned to this technician
        $isAssigned = InterventionTechnicien::where('reparation_id', $reparation->id)
            ->where('technicien_id', $technicien->id)
            ->exists();

        if (!$isAssigned) {
            return redirect()->back()->with('error', 'Cette réparation ne vous est pas assignée.');
        }

        // Update the repair status to 'en_cours'
        $reparation->update(['statut' => 'en_cours']);

        return redirect()->back()->with('success', 'Réparation démarrée avec succès.');
    }

    /**
     * Complete a repair and change its status to 'termine'.
     */
    public function completeRepair(Reparation $reparation): RedirectResponse
    {
        $utilisateur = Auth::user();
        $technicien = Technicien::where('utilisateur_id', $utilisateur->id)->first();

        // Verify that the repair is assigned to this technician
        $isAssigned = InterventionTechnicien::where('reparation_id', $reparation->id)
            ->where('technicien_id', $technicien->id)
            ->exists();

        if (!$isAssigned) {
            return redirect()->back()->with('error', 'Cette réparation ne vous est pas assignée.');
        }

        // Update the repair status to 'termine'
        $reparation->update(['statut' => 'termine']);

        return redirect()->back()->with('success', 'Réparation marquée comme terminée.');
    }

    /**
     * Update the duration of an intervention.
     */
    public function updateDuration(Request $request, InterventionTechnicien $intervention): RedirectResponse
    {
        $utilisateur = Auth::user();
        $technicien = Technicien::where('utilisateur_id', $utilisateur->id)->first();

        // Verify that the intervention belongs to this technician
        if ($intervention->technicien_id !== $technicien->id) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas modifier cette intervention.');
        }

        $validated = $request->validate([
            'heures' => 'required|integer|min:0',
            'minutes' => 'required|integer|min:0|max:59',
            'cout_intervention' => 'nullable|numeric|min:0',
        ]);

        // Convert hours and minutes to total minutes
        $totalMinutes = ($validated['heures'] * 60) + $validated['minutes'];

        // Update the intervention
        $intervention->update([
            'duree_minutes' => $totalMinutes,
            'cout_intervention' => $validated['cout_intervention'] ?? $intervention->cout_intervention,
        ]);

        return redirect()->back()->with('success', 'Durée mise à jour avec succès.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reparation;
use App\Models\Technicien;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ReparationAssignmentController extends Controller
{
    /**
     * Show form to assign technicians to a repair.
     */
    public function showAssign(Reparation $reparation): View
    {
        // Charger les techniciens avec leurs spécialités
        $techniciens = Technicien::with('utilisateur')
            ->where('utilisateur_id', '!=', null)
            ->get();

        return view('admin.reparations.assign', compact('reparation', 'techniciens'));
    }

    /**
     * Assign technicians to a repair.
     */
    public function assign(Request $request, Reparation $reparation): RedirectResponse
    {
        $validated = $request->validate([
            'technicien_id' => 'required|exists:techniciens,id',
        ]);

        // Créer ou mettre à jour l'intervention
        $intervention = $reparation->interventions()->updateOrCreate(
            ['technicien_id' => $validated['technicien_id']],
            []
        );

        return redirect()->route('admin.reparations.show', $reparation)
            ->with('success', 'Technicien affecté avec succès à cette réparation');
    }

    /**
     * Unassign a technician from a repair.
     */
    public function unassign(Reparation $reparation, int $technicienId): RedirectResponse
    {
        $reparation->interventions()
            ->where('technicien_id', $technicienId)
            ->delete();

        return redirect()->route('admin.reparations.show', $reparation)
            ->with('success', 'Technicien retiré de cette réparation');
    }
}

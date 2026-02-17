<?php

namespace App\Http\Controllers;

use App\Models\Conseil;
use App\Models\AvisClient;
use App\Models\MessageContact;
use Illuminate\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index(): View
    {
        $conseils = Conseil::where('statut', 'publie')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $avis = AvisClient::with('client')
            ->orderBy('date_avis', 'desc')
            ->take(5)
            ->get();

        $noteMoyenne = AvisClient::avg('note');

        return view('home', compact('conseils', 'avis', 'noteMoyenne'));
    }

    /**
     * Show the contact form.
     */
    public function contact(): View
    {
        return view('contact');
    }

    /**
     * Store contact message.
     */
    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'telephone' => 'nullable|string',
            'sujet' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        MessageContact::create($validated);

        return redirect()->back()->with('success', 'Votre message a été envoyé avec succès. Nous vous répondrons bientôt.');
    }
}

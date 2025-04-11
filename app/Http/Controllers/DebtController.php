<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\User;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all(); // Récupère tous les utilisateurs
        $debts = Debt::with('activity', 'account')->where('user_id', auth()->id())->orderByDesc('id')->get();
        return view('user.debt.index',compact('users','debts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'creditor' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'remaining_amount' => 'required|numeric|min:0|lte:amount',
            'loan_date' => 'required|date|before_or_equal:today',
            'due_date' => 'required|date|after_or_equal:loan_date',
            'status' => 'required|in:unpaid,partially_paid,paid',
            'description' => 'nullable|string|max:1000',
        ]);
    
        try {
            // Création de la dette
            $debt = new Debt();
            $debt->user_id = auth()->id();
            $debt->creditor = $validated['creditor'];
            $debt->amount = $validated['amount'];
            $debt->remaining_amount = $validated['remaining_amount'];
            $debt->loan_date = $validated['loan_date'];
            $debt->due_date = $validated['due_date'];
            $debt->status = $validated['status'];
            $debt->description = $validated['description'];
            $debt->save();
    
            // Redirection avec message de succès
            return redirect()->route('debts.index')->with('success', 'Debt created successfully.');
    
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create debt. Please try again.']);
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            // Récupérer la dette avec l'ID
            $debt = Debt::findOrFail($id);
    
            // Retourner la vue avec la dette
            return view('debts.show', compact('debt'));
    
        } catch (\Exception $e) {
            // En cas d'erreur
            return back()->withErrors(['error' => 'Failed to retrieve debt details. Please try again.']);
        }
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Debt $debt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation des données
        $validated = $request->validate([
            'creditor' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'remaining_amount' => 'required|numeric|min:0|lte:amount',
            'loan_date' => 'required|date|before_or_equal:today',
            'due_date' => 'required|date|after_or_equal:loan_date',
            'status' => 'required|in:unpaid,partially_paid,paid',
            'description' => 'nullable|string|max:1000',
        ]);
    
        try {
            // Trouver la dette existante
            $debt = Debt::findOrFail($id);
    
            // Mettre à jour les attributs
            $debt->creditor = $validated['creditor'];
            $debt->amount = $validated['amount'];
            $debt->remaining_amount = $validated['remaining_amount'];
            $debt->loan_date = $validated['loan_date'];
            $debt->due_date = $validated['due_date'];
            $debt->status = $validated['status']; // Mise à jour du statut
            $debt->description = $validated['description']; // Mise à jour de la description
    
            // Sauvegarder les changements
            $debt->save();
    
            // Retourner à la page des dettes avec un message de succès
            return redirect()->route('debts.index')->with('success', 'Debt updated successfully.');
    
        } catch (\Exception $e) {
            // En cas d'erreur
            return back()->withErrors(['error' => 'Failed to update debt. Please try again.']);
        }
    }
      //
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Trouver la dette à supprimer
            $debt = Debt::findOrFail($id);
    
            // Supprimer la dette
            $debt->delete();
    
            // Retourner à la page des dettes avec un message de succès
            return redirect()->route('debts.index')->with('success', 'Debt deleted successfully.');
    
        } catch (\Exception $e) {
            // En cas d'erreur
            return back()->withErrors(['error' => 'Failed to delete debt. Please try again.']);
        }
    }
    
}

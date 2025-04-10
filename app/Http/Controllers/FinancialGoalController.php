<?php

namespace App\Http\Controllers;

use App\Models\FinancialGoal;
use App\Models\User;
use Illuminate\Http\Request;

class FinancialGoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all(); // Récupère tous les utilisateurs
        $goals = FinancialGoal::query()->orderByDesc('id')->get();


        return view('user.financial_goal.index', compact('users', 'goals'));
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
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0.01',
            'current_amount' => 'required|numeric|min:0',
            'deadline' => 'required|date|after_or_equal:today',
            'status' => 'required|in:in_progress,achieved,not_achieved',
            'description' => 'nullable|string|max:1000',
        ]);

        try {
            // Enregistrer l'objectif financier
            $financialGoal = new FinancialGoal();
            $financialGoal->user_id = auth()->id();  // L'utilisateur authentifié
            $financialGoal->name = $validated['name'];
            $financialGoal->target_amount = $validated['target_amount'];
            $financialGoal->current_amount = $validated['current_amount'];
            $financialGoal->deadline = $validated['deadline'];
            $financialGoal->status = $validated['status'];
            $financialGoal->description = $validated['description'];
            $financialGoal->save();

            // Retourne à la page des objectifs financiers avec un message de succès
            return redirect()->route('financial_goals.index')->with('success', 'Financial goal created successfully.');

        } catch (\Exception $e) {
            // En cas d'erreur, retourner à la page précédente avec un message d'erreur
            return back()->withErrors(['error' => 'Failed to create financial goal. Please try again.']);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Récupérer l'objectif financier par son ID
        $goal = FinancialGoal::findOrFail($id);
    
        // Retourner la vue avec les données
        return view('financial_goals.show', compact('goal'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FinancialGoal $financialGoal)
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
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0.01',
            'current_amount' => 'required|numeric|min:0',
            'deadline' => 'required|date|after_or_equal:today',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:in_progress,achieved,not_achieved', // Validation du statut
        ]);
    
        try {
            // Trouver l'objectif financier
            $goal = FinancialGoal::findOrFail($id);
    
            // Mettre à jour les attributs
            $goal->name = $validated['name'];
            $goal->target_amount = $validated['target_amount'];
            $goal->current_amount = $validated['current_amount'];
            $goal->deadline = $validated['deadline'];
            $goal->description = $validated['description'];
            $goal->status = $validated['status']; // Mise à jour du statut
    
            // Sauvegarder les changements
            $goal->save();
    
            // Retourner à la page des objectifs financiers avec un message de succès
            return redirect()->route('financial_goals.index')->with('success', 'Goal updated successfully.');
    
        } catch (\Exception $e) {
            // En cas d'erreur
            return back()->withErrors(['error' => 'Failed to update goal. Please try again.']);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        try {
            $goal = FinancialGoal::findOrFail($id);
            $goal->delete();
    
            return redirect()->route('financial_goals.index')->with('success', 'Financial goal deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete the financial goal. Please try again.']);
        }
    }
    
}

<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            // Récupère les budgets de l'utilisateur connecté avec leur activité liée
            $budgets = Budget::with('activity')
                ->where('id_user', auth()->id())
                ->orderByDesc('id')
                ->get();
    
            // Récupère les activités de l'utilisateur (pour le formulaire de création)
            $activities = Activity::where('user_id', auth()->id())->get();
    
            return view('user.budget.index', compact('budgets', 'activities'));
    

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
        'id_activity' => 'required|exists:activities,id',
        'amount' => 'required|numeric|min:0.01',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'description' => 'nullable|string|max:1000',
    ]);

    try {
        // Création du budget
        $budget = new Budget();
        $budget->id_user = auth()->id(); // ID de l'utilisateur connecté
        $budget->id_activity = $validated['id_activity'];
        $budget->amount = $validated['amount'];
        $budget->start_date = $validated['start_date'];
        $budget->end_date = $validated['end_date'];
        $budget->description = $validated['description'] ?? null;
        $budget->save();

        return redirect()->route('budgets.index')->with('success', 'Budget created successfully.');
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Failed to create budget. Please try again.']);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(Budget $budget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget)
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
            'id_activity' => 'required|exists:activities,id',
            'amount' => 'required|numeric|min:0.01',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string|max:1000',
        ]);
    
        try {
            // Recherche du budget
            $budget = Budget::findOrFail($id);
    
            // Mise à jour des champs
            $budget->id_activity = $validated['id_activity'];
            $budget->amount = $validated['amount'];
            $budget->start_date = $validated['start_date'];
            $budget->end_date = $validated['end_date'];
            $budget->description = $validated['description'] ?? null;
            $budget->save();
    
            return redirect()->route('budgets.index')->with('success', 'Budget updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update budget. Please try again.']);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $budget = Budget::findOrFail($id);
            $budget->delete();
    
            return redirect()->route('budgets.index')->with('success', 'Budget deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete budget. Please try again.']);
        }
    }
    
}

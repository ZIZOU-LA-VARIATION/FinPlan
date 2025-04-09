<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Http\Requests\StoreInvestmentRequest;
use App\Http\Requests\UpdateInvestmentRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class InvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupère les utilisateurs pour les afficher dans un select
        $users = User::all(); // Récupère tous les utilisateurs

        // Utilise paginate() pour la pagination des investissements
        $investments = Investment::query()->orderByDesc('id')->get();


        // Retourne la vue avec les utilisateurs et les investissements
        return view('user.investment.index', compact('users', 'investments'));
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
    // Méthode pour enregistrer l'investissement


    // Validation des données
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:stock,bond,mutual fund,cryptocurrency',
            'investment_date' => 'required|date|before_or_equal:today',
            'status' => 'required|in:on_hold,pending,paid,lost',
            'current_value' => 'required|numeric|min:0',
        ]);
    
        try {
            // Enregistrer l'investissement
            $investment = new Investment();
            $investment->id_user = $validated['id_user'];
            $investment->name = $validated['name'];
            $investment->amount = $validated['amount'];
            $investment->type = $validated['type'];
            $investment->investment_date = $validated['investment_date'];
            $investment->status = $validated['status'];
            $investment->current_value = $validated['current_value'];
            $investment->save();
    
            // Retourne à la page des investissements avec un message de succès
            return redirect()->route('investments.index')->with('success', 'Investment created successfully.');
    
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create investment. Please try again.']);
        }
    }
    



    /**
     * Display the specified resource.
     */
    public function show(Investment $investment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Investment $investment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:stock,bond,mutual fund,cryptocurrency',
            'investment_date' => 'required|date',
            'status' => 'required|in:on_hold,pending,paid,lost',
            'current_value' => 'required|numeric|min:0',
        ]);
    
        $investment = Investment::findOrFail($id);
        $investment->update($request->all());
    
        return redirect()->back()->with('success', 'Investment updated successfully!');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $investment = Investment::findOrFail($id);
            $investment->delete();
    
            return redirect()->back()->with('success', 'Investment deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete the investment.');
        }
    }
    
}

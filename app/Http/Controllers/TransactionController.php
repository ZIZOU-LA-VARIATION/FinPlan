<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Activity;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with('activity', 'account')->where('id_user', auth()->id())->orderByDesc('id')->get();
        $activities = Activity::all();
        $accounts = Account::all();
    
        return view('user.transaction.index', compact('transactions', 'activities', 'accounts'));
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
            'id_account' => 'required|exists:accounts,id',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string|max:1000',
        ]);
    
        try {
            // Création de la transaction
            $transaction = new Transaction();
            $transaction->id_user = auth()->id(); // ID de l'utilisateur connecté
            $transaction->id_activity = $validated['id_activity'];
            $transaction->id_account = $validated['id_account'];
            $transaction->date = $validated['date'];
            $transaction->amount = $validated['amount'];
            $transaction->type = $validated['type'];
            $transaction->description = $validated['description'];
            $transaction->save();
    
            return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
    
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create transaction. Please try again.']);
        }
    }
    

    /**
     * Display the specified resource.
     */
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
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
            'id_account' => 'required|exists:accounts,id',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'description' => 'nullable|string|max:1000',
        ]);
    
        try {
            // Récupération de la transaction existante
            $transaction = Transaction::findOrFail($id);
    
            // Vérifier que la transaction appartient bien à l'utilisateur connecté
            if ($transaction->id_user !== auth()->id()) {
                return back()->withErrors(['error' => 'Unauthorized action.']);
            }
    
            // Mise à jour des champs
            $transaction->id_activity = $validated['id_activity'];
            $transaction->id_account = $validated['id_account'];
            $transaction->date = $validated['date'];
            $transaction->amount = $validated['amount'];
            $transaction->type = $validated['type'];
            $transaction->description = $validated['description'];
            $transaction->save();
    
            return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update transaction. Please try again.']);
        }
    }
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            $transaction->delete();
    
            return redirect()->back()->with('success', 'Transaction deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting transaction: ' . $e->getMessage());
        }
    }
    
}

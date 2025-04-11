<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use Illuminate\Http\Request;
use App\Enums\AccountType;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;



class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = Account::with('activity', 'account')->where('id_user', auth()->id())->orderByDesc('id')->get();
        $accountTypes = AccountType::cases();
        return view('user.account.index',compact('accounts','accountTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $accountTypes = AccountType::cases();
    //     return view('user.account.index', compact('accountTypes'));
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validation des données du formulaire
            $validated = $request->validate([
                'name' => 'required|string|max:85|min:3',
                'initial_balance' => 'required|numeric|min:0',
                'bank_name' => 'required|string|max:255',
                'account_type' => 'required|in:' . implode(',', array_column(AccountType::cases(), 'value')),
            ]);


            // Attribution de l'ID de l'utilisateur authentifié

            // Création du compte bancaire
            $account = new Account();
            $account->name = $validated['name'];
            $account->bank_name = $validated['bank_name'];
            $account->initial_balance = $validated['initial_balance'];
            $account->account_type = $validated['account_type'];
            $account->id_user = Auth::id(); // Récupère l'ID de l'utilisateur authentifié
            $account->save();

            // Redirection avec message de succès
            return redirect()->back()->with('success', 'Compte créé avec succès.');
        } catch (Exception $e) {
            // Journalisation de l'erreur
            Log::error('Erreur lors de la création du compte : ' . $e->getMessage());

            // Redirection avec message d'erreur
            return back()->withErrors(['msg' => 'Une erreur est survenue lors de la création du compte. Veuillez réessayer.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        return view('user.account.show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        $accountTypes = AccountType::cases();

        return view('user.account.edit',compact('account','accountTypes'));
    }



    // Met à jour les informations du compte dans la base de données
    public function update(Request $request, Account $account)
    {
        // Validation des données du formulaire
        $validated = $request->validate([
            'name' => 'required|string|max:85|min:3',
            'initial_balance' => 'required|numeric|min:0',
            'bank_name' => 'required|string|max:255',
            'account_type' => 'required|in:' . implode(',', array_column(AccountType::cases(), 'value')),
        ]);

        // Mise à jour des informations du compte
        $account->update([
            'name' => $validated['name'],
            'bank_name' => $validated['bank_name'],
            'initial_balance' => $validated['initial_balance'],
            'account_type' => $validated['account_type'],
            'user_id' => Auth::id(), // Associe le compte à l'utilisateur authentifié
        ]);

        // Redirection avec message de succès
        return redirect()->route('accounts.index')->with('success', 'Compte mis à jour avec succès.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
    
        // Supprimer le compte
        $account->delete();
    
        return redirect()->route('accounts.index')->with('success', 'Compte supprimé avec succès.');
    }
}

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
        $account = Account::query()->orderByDesc('id');
        $accountTypes = AccountType::cases();
        return view('user.account.index',compact('account','accountTypes'));
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
                'name' => 'required|string|max:85',
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        //
    }
}

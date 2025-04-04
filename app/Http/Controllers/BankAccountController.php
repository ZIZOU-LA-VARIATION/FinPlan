<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankAccountController extends Controller
{
    // 🔹 Liste des comptes bancaires
    public function index()
    {
        try {
            $bankAccounts = BankAccount::where('id_user', Auth::id())->get();
            return response()->json($bankAccounts, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch bank accounts', 'message' => $e->getMessage()], 500);
        }
    }

    // 🔹 Ajout d'un compte bancaire
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'initial_balance' => 'required|numeric',
                'bank_name' => 'nullable|string|max:255',
            ]);

            $bankAccount = BankAccount::create([
                'id_user' => Auth::id(),
                'name' => $request->name,
                'initial_balance' => $request->initial_balance,
                'current_balance' => $request->initial_balance,
                'bank_name' => $request->bank_name,
            ]);

            return response()->json(['message' => 'Bank account created successfully', 'account' => $bankAccount], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create bank account', 'message' => $e->getMessage()], 500);
        }
    }

    // 🔹 Affichage d'un compte spécifique
    public function show($id)
    {
        try {
            $bankAccount = BankAccount::where('id_user', Auth::id())->findOrFail($id);
            return response()->json($bankAccount, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Bank account not found', 'message' => $e->getMessage()], 404);
        }
    }

    // 🔹 Mise à jour d'un compte bancaire
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'bank_name' => 'nullable|string|max:255',
            ]);

            $bankAccount = BankAccount::where('id_user', Auth::id())->findOrFail($id);
            $bankAccount->update($request->all());

            return response()->json(['message' => 'Bank account updated successfully', 'account' => $bankAccount], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update bank account', 'message' => $e->getMessage()], 500);
        }
    }

    // 🔹 Suppression d'un compte bancaire
    public function destroy($id)
    {
        try {
            $bankAccount = BankAccount::where('id_user', Auth::id())->findOrFail($id);
            $bankAccount->delete();

            return response()->json(['message' => 'Bank account deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete bank account', 'message' => $e->getMessage()], 500);
        }
    }
}

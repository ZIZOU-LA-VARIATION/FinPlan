<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Récupération des factures de l'utilisateur connecté avec l'activité liée
        $invoices = Invoice::with('activity')
            ->where('id_user', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        // Récupération des activités pour le formulaire (création, édition)
        $activities = Activity::where('user_id', auth()->id())->get();

        return view('user.invoice.index', compact('invoices', 'activities'));

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
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'due_date' => 'required|date',
            'status' => 'required|in:unpaid,paid',
            'description' => 'nullable|string|max:1000',
        ]);
    
        try {
            // Création de la facture
            $invoice = new Invoice();
            $invoice->id_user = auth()->id(); // ID de l'utilisateur connecté
            $invoice->id_activity = $validated['id_activity'];
            $invoice->title = $validated['title'];
            $invoice->amount = $validated['amount'];
            $invoice->due_date = $validated['due_date'];
            $invoice->status = $validated['status'];
            $invoice->description = $validated['description'] ?? null;
            $invoice->save();
    
            return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create invoice. Please try again.']);
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
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
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'due_date' => 'required|date',
            'status' => 'required|in:unpaid,paid',
            'description' => 'nullable|string|max:1000',
        ]);
    
        try {
            // Récupération de la facture
            $invoice = Invoice::findOrFail($id);
            
            // Mise à jour des informations de la facture
            $invoice->id_activity = $validated['id_activity'];
            $invoice->title = $validated['title'];
            $invoice->amount = $validated['amount'];
            $invoice->due_date = $validated['due_date'];
            $invoice->status = $validated['status'];
            $invoice->description = $validated['description'] ?? null;
            
            // Sauvegarde des modifications
            $invoice->save();
    
            return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update invoice. Please try again.']);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Récupération de la facture à supprimer
            $invoice = Invoice::findOrFail($id);
    
            // Suppression de la facture
            $invoice->delete();
    
            return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete invoice. Please try again.']);
        }
    }
    
}

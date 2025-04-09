<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Saving;
use Illuminate\Http\Request;


class SavingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $savings = Saving::query()->orderByDesc('id')->get();
        $savings = Saving::where('id_user', Auth::id())->paginate(10);

        return view('user.saving.index', compact('savings'));
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
        $validated = $request->validate([
            'name' => 'required|string|max:55',
            'target_amount' => 'required|numeric|min:0',
            'deadline' => 'required|date|after:today',
            'goal' => 'nullable|string|max:255',
        ]);
        // Création
        $saving = new Saving();
        $saving->id_user = Auth::id();
        $saving->name = $validated['name'];
        $saving->target_amount = $validated['target_amount'];
        $saving->current_amount = 0;
        $saving->deadline = $validated['deadline'];
        $saving->goal = $validated['goal'] ?? null;
        $saving->save();

        return redirect()->route('savings.index')->with('success', 'Saving goal created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Saving $saving)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:55',
            'target_amount' => 'required|numeric|min:0',
            'current_amount' => 'nullable|numeric|min:0',
            'deadline' => 'required|date',
            'goal' => 'nullable|string|max:255',
        ]);
    
        $saving->update($validated);
    
        return redirect()->route('savings.index')->with('success', 'Saving updated successfully.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $saving = Saving::findOrFail($id);
            $saving->delete();
    
            return redirect()->route('savings.index')->with('success', 'Saving goal deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('savings.index')->with('error', 'Failed to delete the saving goal.');
        }
    }
    
}

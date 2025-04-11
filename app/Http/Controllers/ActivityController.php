<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all(); // Récupère tous les utilisateurs
        $activities =Activity::query()->orderByDesc('id')->get();
        return view('user.activity.index',compact('users','activities'));
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
        ]);
    
        try {
            $activity = new Activity();
            $activity->name = $validated['name'];
            $activity->user_id = auth()->id(); // ou $request->user()->id
    
            $activity->save();
    
            return redirect()->route('activities.index')->with('success', 'Activity created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create activity. Please try again.']);
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $activity = Activity::findOrFail($id);
        return view('activities.show', compact('activity'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:55',
        ]);
    
        try {
            $activity = Activity::findOrFail($id);
            $activity->name = $validated['name'];
            $activity->save();
    
            return redirect()->route('activities.index')->with('success', 'Activity updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update activity.']);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */public function destroy($id)
{
    try {
        $activity = Activity::findOrFail($id);
        $activity->delete();

        return redirect()->route('activities.index')->with('success', 'Activity deleted successfully.');
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Failed to delete activity.']);
    }
}

}

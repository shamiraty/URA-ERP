<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rank;

class RankController extends Controller
{
    // Display the form with the list of ranks
    public function create()
    {
        $ranks = Rank::all();
        return view('ranks.create', compact('ranks'));
    }

    // Store a new rank
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Rank::create([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('ranks.create')->with('success', 'Rank added successfully!');
    }

    // Show the form for editing a specific rank
    public function edit($id)
    {
        $rank = Rank::findOrFail($id);
        return response()->json($rank);
    }

    // Update a specific rank
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $rank = Rank::findOrFail($id);
        $rank->update([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('ranks.create')->with('success', 'Rank updated successfully!');
    }

    // Delete a specific rank
    public function destroy($id)
    {
        $rank = Rank::findOrFail($id);
        $rank->delete();

        return response()->json(['success' => true, 'message' => 'Rank deleted successfully!']);
    }
}

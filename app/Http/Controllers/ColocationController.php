<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Http\Request;
use App\Models\Membership;

class ColocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('colocations.create');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $colocation = Colocation::create([
        'name' => $request->name,
        'description' => $request->description,
        'status' => 'active',
    ]);

    Membership::create([
        'user_id' => auth()->id(),
        'colocation_id' => $colocation->id,
        'role' => 'owner',
        'joined_at' => now(),
    ]);

    return redirect()->route('dashboard')->with('success', 'Colocation créée avec succès !');
}

    /**
     * Display the specified resource.
     */
    // الكود الصحيح لـ ColocationController.php
        public function show(Colocation $colocation)
{
    $membership = auth()->user()->memberships()->where('colocation_id', $colocation->id)->first();

    if (!$membership) {
        abort(403, 'Action non autorisée.');
    }

    $members = $colocation->memberships()->with('user')->whereNull('left_at')->get();
    
    $categories = \App\Models\Category::all(); 

    return view('colocations.show', compact('colocation', 'members', 'membership', 'categories'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Colocation $colocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Colocation $colocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Colocation $colocation)
    {
        //
    }
}

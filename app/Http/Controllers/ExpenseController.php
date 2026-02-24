<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Models\Colocation;

class ExpenseController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request, Colocation $colocation)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0.1',
        'category_id' => 'required|exists:categories,id', 
        'spent_at' => 'required|date',
    ]);

    $colocation->expenses()->create([
        'user_id' => auth()->id(),
        'category_id' => $request->category_id, 
        'title' => $request->title,
        'amount' => $request->amount,
        'spent_at' => $request->spent_at,
    ]);

    return back()->with('success', 'Dépense ajoutée !');
}

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        //
    }
}

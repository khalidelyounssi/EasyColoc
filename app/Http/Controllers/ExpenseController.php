<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Colocation;
use App\Models\Settlement;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function store(Request $request, Colocation $colocation)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'paid_by' => 'required|exists:users,id', 
            'spent_at' => 'required|date',
        ]);

        $expense = $colocation->expenses()->create([
            'title' => $request->title,
            'amount' => $request->amount,
            'category_id' => $request->category_id,
            'spent_at' => $request->spent_at,
            'user_id' => $request->paid_by, 
        ]);

        $members = $colocation->memberships()->whereNull('left_at')->get();
        
        if ($members->count() > 1) {
            $shareAmount = $request->amount / $members->count();

            foreach ($members as $member) {
                if ($member->user_id != $request->paid_by) {
                    Settlement::create([
                        'sender_id' => $member->user_id,  
                        'receiver_id' => $request->paid_by, 
                        'expense_id' => $expense->id,
                        'amount' => $shareAmount,
                        'status' => 'pending',
                        'colocation_id' => $colocation->id,
                    ]);
                }
            }
        }

        return back()->with('success', 'Dépense ajoutée avec succès !');
    }
}
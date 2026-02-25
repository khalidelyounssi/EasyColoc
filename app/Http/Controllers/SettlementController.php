<?php

namespace App\Http\Controllers;

use App\Models\Colocation; 
use App\Models\User;
use App\Models\Settlement;
use Illuminate\Http\Request;

class SettlementController extends Controller
{
    public function payAllBetween(Colocation $colocation, User $receiver)
    {
        Settlement::whereHas('expense', function($query) use ($colocation) {
                $query->where('colocation_id', $colocation->id);
            })
            ->where('sender_id', auth()->id())
            ->where('receiver_id', $receiver->id)
            ->where('status', 'pending')
            ->update(['status' => 'paid', 'paid_at' => now()]);

        return back()->with('success', 'Comptes réglés !');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Colocation; 
use App\Models\User;
use App\Models\Settlement;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function kickMember(Colocation $colocation, User $user)
    {
        $currentMembership = auth()->user()->memberships()->where('colocation_id', $colocation->id)->first();
        
        if (!$currentMembership || $currentMembership->role !== 'owner') {
            abort(403, 'Seul le owner peut faire cela.');
        }

        $owner = $colocation->memberships()->where('role', 'owner')->first()->user;

        Settlement::whereHas('expense', function($q) use ($colocation) {
                $q->where('colocation_id', $colocation->id);
            })
            ->where('sender_id', $user->id)
            ->where('status', 'pending')
            ->update(['sender_id' => $owner->id]);

        Settlement::whereHas('expense', function($q) use ($colocation) {
                $q->where('colocation_id', $colocation->id);
            })
            ->where('receiver_id', $user->id)
            ->where('status', 'pending')
            ->update(['receiver_id' => $owner->id]);

        $colocation->memberships()->where('user_id', $user->id)->update(['left_at' => now()]);

        return back()->with('success', 'Membre retiré et dettes transférées.');
    }
}
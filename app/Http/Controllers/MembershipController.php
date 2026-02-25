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
    $currentMembership = auth()->user()->memberships()
        ->where('colocation_id', $colocation->id)
        ->first();

    if (!$currentMembership || $currentMembership->role !== 'owner') {
        abort(403);
    }

    $owner = $colocation->memberships()->where('role', 'owner')->first()->user;

    $this->transferDebts($colocation, $user->id, $owner->id);

    $colocation->memberships()
        ->where('user_id', $user->id)
        ->update([
            'left_at' => now() 
        ]);

    return back()->with('success', 'Membre exclu et dettes transférées.');
}

    
    public function leave(Colocation $colocation)
    {
        $userId = auth()->id();
        $membership = auth()->user()->memberships()
            ->where('colocation_id', $colocation->id)
            ->first();

        if (!$membership) abort(404);

        if ($membership->role === 'owner') {
            return back()->with('error', 'Vous devez nommer un nouveau owner avant de quitter.');
        }

        $owner = $colocation->memberships()->where('role', 'owner')->first()->user;

        $this->transferDebts($colocation, $userId, $owner->id);

        $membership->update(['left_at' => now()]);

        return redirect()->route('dashboard')->with('success', 'Vous avez quitté la colocation.');
    }

    
    private function transferDebts(Colocation $colocation, $memberId, $ownerId)
    {
        Settlement::whereHas('expense', function($q) use ($colocation) {
                $q->where('colocation_id', $colocation->id);
            })
            ->where('sender_id', $memberId)
            ->where('status', 'pending')
            ->update(['sender_id' => $ownerId]);

        Settlement::whereHas('expense', function($q) use ($colocation) {
                $q->where('colocation_id', $colocation->id);
            })
            ->where('receiver_id', $memberId)
            ->where('status', 'pending')
            ->update(['receiver_id' => $ownerId]);
    }
}
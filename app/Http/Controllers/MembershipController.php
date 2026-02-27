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

    

public function leave(Request $request, Colocation $colocation)
{
    $user = auth()->user();
    
    $membership = $user->memberships()->where('colocation_id', $colocation->id)->first();

    $otherMembersCount = $colocation->memberships()->whereNull('left_at')->where('user_id', '!=', $user->id)->count();

    if ($membership->role === 'owner' && $otherMembersCount > 0) {
        return back()->with('error', "En tant qu'Owner, vous ne pouvez pas quitter la colocation. Transférez d'abord la propriété à un autre membre."); //
    }

    $ownerMembership = $colocation->memberships()->where('role', 'owner')->first();
    $owner = $ownerMembership->user;

    $pendingDebts = Settlement::where('colocation_id', $colocation->id)
        ->where('sender_id', $user->id)
        ->where('status', 'pending');

    if ($pendingDebts->exists()) {
        $pendingDebts->update(['sender_id' => $owner->id]);
        $user->decrement('reputation_score'); 
        $message = "Dettes transférées à l'owner. Réputation -1.";
    } else {
        $user->increment('reputation_score'); 
        $message = "Merci ! Réputation +1.";
    }

    $membership->update(['left_at' => now()]);

    return redirect()->route('dashboard')->with('success', $message);
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
    public function transfer(Colocation $colocation, User $user)
{
    $currentOwner = $colocation->memberships()
        ->where('user_id', auth()->id())
        ->where('role', 'owner')
        ->firstOrFail();

    $newOwner = $colocation->memberships()
        ->where('user_id', $user->id)
        ->firstOrFail();

    $currentOwner->update(['role' => 'member']);
    $newOwner->update(['role' => 'owner']);

    return back()->with('success', 'Propriété transférée avec succès à ' . $user->name);
}
}
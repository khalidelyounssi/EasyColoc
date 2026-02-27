<?php

namespace App\Http\Controllers;

use App\Mail\InvitationMail;
use App\Models\Invitation;
use App\Models\Colocation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Membership;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    public function store(Request $request, Colocation $colocation)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $token = Str::random(32);

        $invitation = Invitation::create([
            'email' => $request->email,
            'token' => $token,
            'colocation_id' => $colocation->id,
            'status' => 'pending',
        ]);

        Mail::to($invitation->email)->send(new InvitationMail($colocation, $invitation->token));

        return back()->with('success', 'Invitation envoyée ! Le lien redirige vers l\'inscription.');
    }

    public function accept($token)
    {
        $invitation = Invitation::where('token', $token)
            ->where('status', 'pending')
            ->firstOrFail();

        if (auth()->user()->email !== $invitation->email) {
            return redirect()->route('dashboard')->with('error', 'Cet email ne correspond pas à l\'invitation.');
        }

        $alreadyMember = Membership::where('user_id', auth()->id())
            ->where('colocation_id', $invitation->colocation_id)
            ->exists();

        if (!$alreadyMember) {
            Membership::create([
                'user_id' => auth()->id(),
                'colocation_id' => $invitation->colocation_id,
                'role' => 'member',
                'joined_at' => now(),
            ]);
        }

        $invitation->update(['status' => 'accepted']);
        
        return redirect()->route('dashboard')->with('success', 'Bienvenue dans votre nouvelle colocation !');
    }

    public function reject($token)
    {
        $invitation = Invitation::where('token', $token)
            ->where('status', 'pending')
            ->firstOrFail();

        $invitation->update(['status' => 'rejected']);

        return redirect()->route('dashboard')->with('success', 'Invitation refusée.');
    }
}
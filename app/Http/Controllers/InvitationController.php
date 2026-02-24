<?php
namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Colocation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Membership;

class InvitationController extends Controller
{
    public function store(Request $request, Colocation $colocation)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $token = Str::random(32);

        Invitation::create([
            'email' => $request->email,
            'token' => $token,
            'colocation_id' => $colocation->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Invitation envoyée avec succès !');
    }
    public function accept($token)
{
    $invitation = Invitation::where('token', $token)
        ->where('status', 'pending')
        ->firstOrFail();

    Membership::create([
        'user_id' => auth()->id(),
        'colocation_id' => $invitation->colocation_id,
        'role' => 'member',
        'joined_at' => now(),
    ]);

    $invitation->update(['status' => 'accepted']);

    return redirect()->route('dashboard')->with('success', 'Vous avez rejoint la colocation !');
}
}
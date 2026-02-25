<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $activeColocations = $user->memberships()
            ->whereNull('left_at') 
            ->with('colocation')
            ->get(); 

        $historyColocations = $user->memberships()
            ->whereNotNull('left_at')
            ->with('colocation')
            ->get();

        $pendingInvitations = Invitation::where('email', $user->email)
            ->where('status', 'pending')
            ->with('colocation')
            ->get();

        return view('dashboard', compact('activeColocations', 'historyColocations', 'pendingInvitations'));
    }
}
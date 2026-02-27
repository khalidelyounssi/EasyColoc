<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Colocation;
use App\Models\Expense;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    
    public function index()
{
    if (!auth()->user()->is_admin) {
        abort(403);
    }

    $stats = [
        'total_users' => User::count(),
        'total_colocations' => Colocation::count(),
        'total_expenses' => Expense::sum('amount'),
        'banned_users' => User::where('is_banned', true)->count(),
    ];

    $users = User::latest()->paginate(10);

    return view('admin.dashboard', compact('stats', 'users'));
}

    
    public function toggleBan(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas vous bannir vous-même.');
        }

        $user->update([
            'is_banned' => !$user->is_banned
        ]);

        $status = $user->is_banned ? 'banni' : 'débanni';

        return back()->with('success', "L'utilisateur {$user->name} a été {$status} avec succès.");
    }
}
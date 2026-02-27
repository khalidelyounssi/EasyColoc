<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 1. جلب السكنات النشطة (التي لم يغادرها المستخدم بعد)
        $activeColocations = $user->memberships()
            ->whereNull('left_at') 
            ->with('colocation')
            ->get(); 

        // 2. جلب تاريخ السكنات (التي غادرها المستخدم)
        $historyColocations = $user->memberships()
            ->whereNotNull('left_at')
            ->with('colocation')
            ->get();

        // 3. جلب الدعوات المعلقة بناءً على البريد الإلكتروني للمستخدم الحالي
        $pendingInvitations = Invitation::where('email', $user->email)
            ->where('status', 'pending')
            ->with('colocation')
            ->get();

        // إرسال البيانات للـ Dashboard
        return view('dashboard', compact(
            'activeColocations', 
            'historyColocations', 
            'pendingInvitations'
        ));
    }
}
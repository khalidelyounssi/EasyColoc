<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Expense;
use App\Models\Membership;
use App\Models\Category;
use App\Models\Settlement;
use App\Models\User;
use Illuminate\Http\Request;

class ColocationController extends Controller
{
    public function create()
    {
        return view('colocations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $colocation = Colocation::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 'active',
        ]);

        Membership::create([
            'user_id' => auth()->id(),
            'colocation_id' => $colocation->id,
            'role' => 'owner',
            'joined_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Colocation créée !');
    }

    // أضفنا Request $request هنا لاستقبال بيانات الفلتر
public function show(Request $request, Colocation $colocation)
{
    $membership = auth()->user()->memberships()
        ->where('colocation_id', $colocation->id)
        ->first();

    if (!$membership) {
        abort(403);
    }

    $isActive = is_null($membership->left_at);

    $members = $colocation->memberships()
        ->with('user')
        ->whereNull('left_at')
        ->get();
        
    $categories = Category::all();

    // --- بداية التعديل: الفلترة حسب الشهر ---
    $selectedMonth = $request->query('month'); // جلب الشهر من الرابط (URL)

    $expensesQuery = Expense::where('colocation_id', $colocation->id);

    // إذا اختار المستخدم شهراً معيناً، نقوم بتصفية النتائج
    if ($selectedMonth) {
        $expensesQuery->whereRaw("DATE_FORMAT(spent_at, '%Y-%m') = ?", [$selectedMonth]);
    }

    $expenseIds = $expensesQuery->pluck('id');
    $expenses = $expensesQuery->with('user')->orderBy('spent_at', 'desc')->get();

    // جلب قائمة الشهور المتوفرة لعرضها في القائمة المنسدلة (Dropdown)
    $availableMonths = Expense::where('colocation_id', $colocation->id)
        ->selectRaw("DATE_FORMAT(spent_at, '%Y-%m') as month")
        ->distinct()
        ->orderBy('month', 'desc')
        ->pluck('month');
    // --- نهاية التعديل ---

    // ... السطر 84 و 85 ...
$rawSettlements = Settlement::whereIn('expense_id', $expenseIds)
    ->where('status', 'pending')
    // التصحيح: يجب وضع فاصلة بين الأسماء داخل selectRaw
    ->selectRaw('sender_id, receiver_id, SUM(amount) as total')
    // التصحيح: يجب تمرير كل حقل كعنصر مستقل في مصفوفة
    ->groupBy('sender_id', 'receiver_id')
    ->get();

    $balances = [];
    foreach ($rawSettlements as $s) {
        $balances[$s->sender_id] = ($balances[$s->sender_id] ?? 0) - $s->total;
        $balances[$s->receiver_id] = ($balances[$s->receiver_id] ?? 0) + $s->total;
    }

    $summary = [];
    $users = User::whereIn('id', array_keys($balances))->get()->keyBy('id');

    $debtors = [];
    $creditors = [];
    foreach ($balances as $userId => $amount) {
        if ($amount < -0.01) $debtors[$userId] = abs($amount);
        elseif ($amount > 0.01) $creditors[$userId] = $amount;
    }

    foreach ($debtors as $dId => $dAmount) {
        foreach ($creditors as $cId => $cAmount) {
            if ($dAmount <= 0) break;
            if ($cAmount <= 0) continue;

            $pay = min($dAmount, $cAmount);
            $summary[] = (object)[
                'sender_id' => $dId,
                'receiver_id' => $cId,
                'total' => $pay,
                'sender' => $users[$dId],
                'receiver' => $users[$cId],
            ];
            $dAmount -= $pay;
            $creditors[$cId] -= $pay;
        }
    }

    // أضفنا المتغيرات الجديدة للـ View
    return view('colocations.show', compact(
        'colocation', 'members', 'membership', 'categories', 
        'summary', 'isActive', 'expenses', 'availableMonths', 'selectedMonth'
    ));
}
}
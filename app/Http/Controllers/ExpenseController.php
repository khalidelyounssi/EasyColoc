<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Colocation;
use App\Models\Settlement;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function store(Request $request, Colocation $colocation)
    {
        // 1. التحقق من البيانات مع إضافة الحقل الجديد
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'paid_by' => 'required|exists:users,id', // الشخص الذي دفع فعلياً
            'spent_at' => 'required|date',
        ]);

        // 2. إنشاء المصروف وربطه بالشخص الذي دفع (paid_by)
        $expense = $colocation->expenses()->create([
            'title' => $request->title,
            'amount' => $request->amount,
            'category_id' => $request->category_id,
            'spent_at' => $request->spent_at,
            'user_id' => $request->paid_by, // هنا نضع المؤدي المختار وليس auth()->id()
        ]);

        // 3. جلب جميع الأعضاء الحاليين (يشمل الـ Owner تلقائياً)
        $members = $colocation->memberships()->whereNull('left_at')->get();
        
        if ($members->count() > 1) {
            $shareAmount = $request->amount / $members->count(); // نصيب كل فرد

            foreach ($members as $member) {
                // إذا لم يكن هذا العضو هو من دفع، ننشئ له ديناً (Settlement)
                if ($member->user_id != $request->paid_by) {
                    Settlement::create([
                        'sender_id' => $member->user_id,    // المدين (اللي عليه الفلوس)
                        'receiver_id' => $request->paid_by, // الدائن (اللي خلص عليهم)
                        'expense_id' => $expense->id,
                        'amount' => $shareAmount,
                        'status' => 'pending',
                    ]);
                }
            }
        }

        return back()->with('success', 'Dépense ajoutée avec succès !');
    }
}
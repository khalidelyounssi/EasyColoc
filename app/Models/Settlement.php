<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    // السماح بإدخال الحقول المطلوبة في جدول التسويات
    protected $fillable = [
        'sender_id', 
        'receiver_id', 
        'expense_id', 
        'amount', 
        'status',
        'colocation_id'
    ];

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
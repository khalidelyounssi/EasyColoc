<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
protected $fillable = [
    'title', 
    'amount', 
    'category_id', 
    'user_id',        // الشخص الذي دفع (المؤدي)
    'colocation_id', 
    'spent_at'
];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function colocation() {
        return $this->belongsTo(Colocation::class);
    }
}
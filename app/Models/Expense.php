<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'user_id',
        'colocation_id',
        'category_id',
        'title',
        'amount',
        'spent_at',
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
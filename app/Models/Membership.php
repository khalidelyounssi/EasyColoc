<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = [
    'user_id', 
    'colocation_id', 
    'role', 
    'joined_at', 
    'left_at' 
];
    protected $casts = [
    'joined_at' => 'datetime',
    'left_at' => 'datetime',
];

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_banned', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

   
    protected static function booted(): void
    {
        static::created(function (User $user) {
            if (static::count() === 1) {
                $user->is_admin = true;
                $user->saveQuietly(); 
            }
        });
    }

    public function memberships() {
        return $this->hasMany(Membership::class);
    }

    public function expenses() {
        return $this->hasMany(Expense::class, 'payer_id');
    }

    public function settlementsSent() {
        return $this->hasMany(Settlement::class, 'sender_id');
    }
}
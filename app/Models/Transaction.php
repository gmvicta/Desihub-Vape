<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'loyalty_id', 'points', 'type'];

    public function loyalty()
    {
        return $this->belongsTo(UserLoyaltyPoints::class, 'loyalty_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Statments extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'balance',
        'recepient_balance',
        'recepiant_id',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recepiant()
    {
        return $this->belongsTo(User::class, 'recepiant_id');
    }
}

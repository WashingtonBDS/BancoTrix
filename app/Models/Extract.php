<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Extract extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'id_account',
        'balance',
        'transfer_transactions',
        'payment_transactions'
    ];


    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}

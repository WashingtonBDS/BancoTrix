<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'id_account',
        'to_account_number',
        'from_ticket_code',
        'value',
        'account_received'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}

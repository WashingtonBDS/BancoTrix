<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GenerateTicket extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'id_account',
        'ticket_generator',
        'value',
        'account_number_generator',
        'ticket_expiration'
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

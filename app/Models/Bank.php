<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bank extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [

        'user_password',
        'balance',
        'account_number',

    ];
    protected $table = [
        'banks'
    ];

    public function agency(){
        return $this->hasOne(Agency::class);
    }
}

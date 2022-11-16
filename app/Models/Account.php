<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'id_agency',
        'user_id',
        'user_password',
        'balance',
        'account_number',

    ];
    protected $hidden = [
        'user_password'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function extract(){
        return $this->hasOne(Extract::class);
    }
    public function transfer(){
        return $this->hasOne(Transfer::class);
    }
    public function payment(){
        return $this->hasOne(Payment::class);
    }

    public function ticketGenerator(){
        return $this->hasOne(ticketGenerator::class);
    }
}

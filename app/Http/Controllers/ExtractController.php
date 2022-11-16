<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transfer;
use Illuminate\Http\Request;

class ExtractController extends Controller
{
    public function extractUser(Account $account)
    {

        //$transfers = Transfer::all("to_account_number");
        //dd($transfers);
        $account = auth()->user()->account->account_number;
       //dd($account);
        $transfer = Transfer::where("to_account_number", $account)->first();

        dd($transfer->all());

        //$payments = Payment::all();

        return response()->json(['data' => [
            'Transfer' => $transfer,
            //'payment' => $payments,
        ]]);
    }
}

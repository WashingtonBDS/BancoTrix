<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Account;
use App\Models\Transfer;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function transferUser(Request $request)
    {
        try{
        $enteringAccount = Account::where("account_number", $request->from_account_number)->first();
        //dd($enteringAccount);
        $leavingAccount = Account::where("account_number", $request['to_account_number'])->first();

        if(!$leavingAccount)
        {
            throw new Exception('There is no proxy user', 400);

        }
        //dd($leavingAccount);
        if($leavingAccount->balance < $request['value'])
        {
            throw new \Exception('Insufficient funds', 400);
        }
        //dd('att ok');
        $account = auth()->user()->account;
        //dd($account);
        $leavingAccount->balance = $leavingAccount->balance - $request->value;
        $leavingAccount->save();

        $enteringAccount->balance = $enteringAccount->balance + $request->value;
        $enteringAccount->save();
        //dd($enteringAccount->balance);

        $transfers = Transfer::create([
            'id_account' => $account->id,
            'to_account_number' => $request->to_account_number,
            'from_account_number' => $request->from_account_number,
            'value' => $request->value,
        ]);

        return response()->json(['data' => [
            'Transfers successful' => $transfers
            ]]);
        }catch(\Exception $e){
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], 400);
        }

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pix;
use App\Models\Account;
use Exception;
use Illuminate\Http\Request;

class PixController extends Controller
{
    public function pixUser(Request $request)
    {
        try
        {
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
            $pix = Pix::create([
                'id_account'=>$account->id,
                'from_account_number'=>$request->from_account_number,
                'to_account_number'=>$request->to_account_number,
                'value'=>$request->value
            ]);
            return response()->json(['data'=>"Pixes Success",$pix]);
        }catch(Exception $e){
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], 400);
        }
    }
}

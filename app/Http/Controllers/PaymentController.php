<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Account;
use App\Models\GenerateTicket;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function ticket(Request $request)
    {

        //$account_number = auth()->user()->account->account_number;
        $account = auth()->user()->account;

        $generator = GenerateTicket::create([
            'id_account' => $account->id,
            'ticket_generator' => rand(1000, 99999999),
            'value' => $request->value,
            'account_number_generator' => $account->account_number,
            'ticket_expiration' => $request->ticket_expiration
        ]);
        // dd($generator);
        return response()->json($generator);
    }

    public function index(Request $request)
    {
        try {
            $ticketAccount = GenerateTicket::where("ticket_generator", $request->from_ticket_code)->first();
            //dd($ticketAccount);
            //dd($ticketAccount->ticket_expiration);
            $enteringAccount = Account::where("account_number", $ticketAccount->account_number_generator)->first();
            //dd($enteringAccount);
            $leavingAccount = Account::where("account_number", $request['to_account_number'])->first();

            if (!$leavingAccount) throw new Exception('There is no proxy user', 400);
            //dd($leavingAccount);
            $dateToday = Carbon::now()->format('Y-m-d');
            //dd($dateToday);
            if($ticketAccount->ticket_expiration > $dateToday) throw new Exception('Ticket expiration', 400);
            //dd($dateToday);
            if ($ticketAccount->ticket_generator != $request['from_ticket_code']) throw new Exception('Ticket code not found',400) ;
            //dd($ticketAccount->ticket_generator);
            if ($leavingAccount->balance < $request['value']) throw new \Exception('Insufficient funds', 400);
            //dd('att ok');

            $account = auth()->user()->account;
            //dd($account);
            $leavingAccount->balance = $leavingAccount->balance - $request->value;
            $leavingAccount->save();
            //dd($leavingAccount->balance);
            $enteringAccount->balance = $enteringAccount->balance + $request['value'];
            //dd($enteringAccount->balance);
            $enteringAccount->save();

            $payments = Payment::create([
                'id_account' => $account->id,
                'to_account_number' => $request->to_account_number,
                'from_ticket_code' => $request->from_ticket_code,
                'value' => $request->value,
                'account_received' => $enteringAccount->account_number,
            ]);

            return response()->json(['data' => [
                'Payments successful' => $payments
            ]]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ], 400);
        }
    }
}

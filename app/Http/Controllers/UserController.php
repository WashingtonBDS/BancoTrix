<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Account;
use App\Models\Address;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;
    protected $address;
    private $account;


    public function __construct(User $user, Address $address, Account $account)
    {
        $this->user = $user;
        $this->useraddress = $address;
        $this->account = $account;
    }

    public function register(Request $request)
    {

        $user = $this->user->create([
            'name' => $request->name,
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
            'email' => $request->email,
            'password' => bcrypt($request->password),

        ]);

        $address = $this->useraddress->create([
            'user_address' => $user->id,
            'address' => $request->address,
            'number' => $request->number,
            'city' => $request->city
        ]);

        $account = $this->account->create([
            'id_agency' => 1,
            'user_id' => $user->id,
            'user_password' => $request->account_password,
            'balance' => 1000,
            'account_number' => rand(1000, 9999)

        ]);


        return response()->json(['data' => [
            'user' => $user,
            'useraddress' => $address,
            'account' => $account
        ]]);
    }


    public function details(

    )
    {

        return response()->json([
            'user' => auth()->user(),
            'account' => auth()->user()->account], 200);
    }
}

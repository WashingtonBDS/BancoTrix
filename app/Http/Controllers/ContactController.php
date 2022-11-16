<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Notifications\NewContact;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    public function index()
    {
        return view(view:'site.contact.index');
    }
    public function form(Request $resquest)
    {
        $contact=Contact::create($resquest->all());
        Notification::route('channel', ['email'.config(key:'mail.from.address'),
        ])->notify(new NewContact($contact));
        ddd($contact);
    }
}

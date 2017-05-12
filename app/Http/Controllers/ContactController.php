<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\User;
use Auth;

class ContactController extends Controller
{

    /**
     * Constructor
     *
     * @return  void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Add user to contact
     * 
     * @param  int $user_id
     * @return \Illuminate\Http\Response
     */
    public function new($user_id)
    {
    	if(!User::find($user_id) || $user_id === Auth::user()->id || Auth::user()->hasContact($user_id)) {
    		return response('Not valid user', 406);
    	}

    	$contact = new Contact();
    	$contact->belongs_to = Auth::user()->id;
    	$contact->saved_user = $user_id;
    	$contact->save();

    	return view('layouts.contact', compact('contact'));
    }

    public function delete($user_id)
    {
        $contact = Contact::where(['saved_user' => $user_id, 'belongs_to' => Auth::user()->id]);
        $contact->delete();

        return response('Contact removed', 200);
    }

}

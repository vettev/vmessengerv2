<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Auth;
use App\Contact;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the welcome page\
     * 
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        if(Auth::user())
            return redirect()->route('home');
        else
        return view('welcome');
    }

    /**
     * Method for authenticate pusher private requests
     * 
     * @param  Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function pusherAuth(Request $request)
    {
        if(Auth::user())
        {
            $pusher = App::make('pusher');
            $channelName = $request->channel_name;
            $socketId = $request->socket_id;
            
            return $pusher->socket_auth($channelName, $socketId);
        }
    }

    /**
     * Logout user
     * 
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('welcome');
    }
}

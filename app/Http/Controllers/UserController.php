<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Contact;
use Auth;

class UserController extends Controller
{

	/**
	 * Search for users
	 * 
	 * @param  Request $request
	 * @return \Illuminate\Http\Response
	 * 
	 */
    public function search(Request $request)
    {
        $users = User::where('name', 'like', "%{$request->condition}%")
        ->orWhere('city', 'like', "%{$request->condition}%")
        ->get();

		return view('layouts.search-results', compact('users'));
    }

    /**
     * Edit user profile
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('user.edit');
    }

    /**
     * Save changes in user profile
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'avatar' => 'image|mimes:jpeg,png,gif,svg,jpg|max:2048'
            ]);
        $user = Auth::user();

        if($request->hasFile('avatar') && $request->avatar->isValid()) {
            $fileName = "avatar-".Auth::user()->id.".".$request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(base_path() . '/public/storage/avatars/', $fileName);
            $user->avatar = $request->file('avatar')->getClientOriginalExtension();
        }
        $day = $request->b_day;
        $month = $request->b_month;
        $year = $request->b_year;
        $birthdate = \DateTime::createFromFormat('j-n-Y', $day.'-'.$month.'-'.$year);
        $user->name = $request->name;
        $user->city = $request->city;
        $user->birthdate = $birthdate;
        $user->update();

        return response('User edition successfull', 200);
    }

    /**
     * Show user profile
     * 
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('user.profile', compact('user'));
    }
}

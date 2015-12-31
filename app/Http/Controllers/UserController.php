<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Hash;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    // check authentication for viewing user pages using middleware
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('username')->get();
        foreach ($users as $user) {
            $user->numberOfArticles = $user->articles()->count();
        }
        return view('users.index', compact('users'));
    }



    /**
     * Display the specified user.
     *
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        $user = User::where('username', $username)->get()->first();
        $user->articles = $user->articles()->get();
        $user->numberOfArticles = $user->articles->count();
        foreach ($user->articles as $article) {
            $article->votes = $article->votes()->where('vote_value', 1)->count()
                                - $article->votes()->where('vote_value', -1)->count();
        }
        return view('users.show', compact('user'));
    }


    /**
     * to verify and show password reset page
     *
     * @param  string  username
     * @return \Illuminate\Http\Response
     */
    public function edit($username)
    {
        $user = User::where('username', $username)->get()->first();

        if(is_null($user)) {
            abort(404);
        }
        if($user->id != Auth::user()->id){
            abort(401);
        }

        return view('users.edit', compact('user'));
    }


    /**
     * to update user's password in DB
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $username
     * @return \Illuminate\Http\Response
     */
    public function update($username, Request $input)
    {
        $this->validate($input, ['old_password' => 'required',
                                 'password' => 'required|confirmed|min:4']);

        $user = User::where('username', $username)->get()->first();

        if(is_null($user)) {
            abort(404);
        }
        if($user->id != Auth::user()->id){
            abort(401);
        }

        if(!Hash::check($input->old_password, $user->password)) {
            return redirect('users/'.$username.'/resetpassword')
                    ->withErrors('The old password you entered is invalid!');
        }

        $user->password = bcrypt($input->password);

        $user->update();
        session()->flash('flash_message', 'Password updated!');

        return redirect('users/'.$username);
    }


    /**
     * to delete user account
     *
     * @param  string $username
     * @return \Illuminate\Http\Response
     */
    public function destroy($username)
    {
        $user = User::where('username', $username)->get()->first();

        if(is_null($user)) {
            abort(404);
        }
        if($user->id != Auth::user()->id){
            abort(401);
        }

        $user->delete();
        Auth::logout();

        session()->flash('flash_message', 'User account and all associated data deleted!');
        return redirect('/articles');
    }
}

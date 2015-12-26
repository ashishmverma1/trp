<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    // check authentication for create/edit pages using middleware
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
        $users = User::all();
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
        return view('users.show', compact('user'));
    }
}

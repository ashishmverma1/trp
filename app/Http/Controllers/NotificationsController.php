<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Notification;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class NotificationsController extends Controller
{
    // check authentication for viewing comment pages using middleware
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Auth::user()->notifications()->orderBy('updated_at', 'DESC')->get();
        return view('notifications.index', compact('notifications'));
    }


    /**
     * Return number of new notifications for current user.
     *
     * @return \Illuminate\Http\Response
     */
    public function check()
    {
        $numberOfNewNotifications = Auth::user()->notifications()->where('read', false)->count();
        return response($numberOfNewNotifications);
    }


    /**
     * Display the specified notification.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notification = Notification::find($id);

        // set to read if unread
        if (!$notification->read){
            $notification->timestamps = false;
            $notification->read = true;
            $notification->save();
            $notification->timestamps = true;
        }

        return redirect('articles/'.$notification->article_id);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

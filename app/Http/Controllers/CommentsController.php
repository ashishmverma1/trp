<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Comment;
use App\Notification;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    // check authentication for storing comment
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Store a newly created comment in storage.
     *
     * @param  \Illuminate\Http\Request  $input
     * @return \Illuminate\Http\Response
     */
    public function store(Request $input)
    {
        $this->validate($input, ['body' => 'required']);
        $newComment = new Comment($input->all());
        Auth::user()->articles()->save($newComment);

        // create a new notification for comment
        Notification::newNotification($newComment->article()->get()->first()->user_id,
                                        $newComment->article_id,
                                        'comment');

        return redirect('articles/'.$newComment->article_id);
    }


    /**
     * Remove the specified comment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);

        if(is_null($comment)) {
            abort(404);
        }
        if($comment->user_id != Auth::user()->id){
            abort(401);
        }

        $comment->delete();
        session()->flash('flash_message', 'Comment deleted!');

        return redirect('articles/'.$comment->article_id);
    }
}

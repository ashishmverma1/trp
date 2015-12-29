<?php

namespace App;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'article_id',
        'type',
        'read'
    ];


    public function user()
    {
        return $this->belongsTo('App\User');
    }


    public function article()
    {
        return $this->belongsTo('App\Article');
    }

    static public function newNotification($user_id, $article_id, $type)
    {
        if(Auth::user()->id != $user_id) {  // Notify only if activity on user's article by others
            $notification = Notification::where('user_id', $user_id)
                                        ->where('article_id', $article_id)
                                        ->where('type', $type)
                                        ->get()->first();

            if(is_null($notification)) {
                $notification = new Notification;
            }

            $notification->user_id = $user_id;
            $notification->article_id = $article_id;
            $notification->type = $type;
            $notification->read = false;
            $notification->save();
        }

        // delete all read notifications older than 7 days
        $sevenDaysAgo = Carbon::now()->subDays(7)->toDateTimeString();
        Notification::where('updated_at', '<=', $sevenDaysAgo)
                    ->where('read', 1)
                    ->delete();
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'vote_value',
        'article_id',
        'user_id'
    ];


    public function user()
    {
        return $this->belongsTo('App\User');
    }


    public function article()
    {
        return $this->belongsTo('App\Article');
    }
}

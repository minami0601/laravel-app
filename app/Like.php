<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    //Like.phpに下記を追記
    //いいねしているユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }

     //いいねしている投稿
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function like_exist($id, $movie_id)
    {
        $exist = Like::where('user_id', $id)->where('movie_id', $movie_id)->get();
        if (!$exist->isEmpty()) {
            return true;
        } else {
        
            return false;
        }
    }

}

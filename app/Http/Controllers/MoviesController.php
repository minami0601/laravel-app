<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Query\Builder;
use App\User; 
use App\Movie; 
use App\Like; 

class MoviesController extends Controller
{
    public function index()
    {
        $data = [];
        // ユーザの投稿の一覧を作成日時の降順で取得
        //withCount('テーブル名')とすることで、リレーションの数も取得できます。
        $movies = Movie::withCount('likes')->orderBy('created_at', 'desc')->paginate(10);
        $like_model = new Like;

        $data = [
                'movies' => $movies,
                'like_model'=>$like_model,
            ];

        return view('movies.index', $data);
    }
    public function create()
    {
        $user = \Auth::user();
        $movies = $user->movies()->orderBy('id', 'desc')->paginate(9);
        
        $data=[
            'user' => $user,
            'movies' => $movies,
        ];
        
        return view('movies.create', $data);
    }
    public function store(Request $request)
    {

        $this->validate($request,[
            'url' => 'required|max:11',
            'comment' => 'max:36',
        ]);

        $request->user()->movies()->create([
            'url' => $request->url,
            'comment' => $request->comment,
        ]);

        return back()->with('flash_message', '投稿が完了しました');
    }
    public function destroy($id)
    {
        $movie = Movie::find($id);

        if (\Auth::id() == $movie->user_id) {
            $movie->delete();
        }
        return back()->with('flash_danger', '動画を削除しました');
    }
    
    //likeの処理
    public function ajaxlike(Request $request)
    {
        $id = Auth::id();

        $movie_id = $request->movie_id;
        $like = new Like;
        $movie = Movie::findOrFail($movie_id);

        // 空でない（既にいいねしている）なら
        if ($like->like_exist($id, $movie_id)) {
            //likesテーブルのレコードを削除
            $like = Like::where('movie_id', $movie_id)->where('user_id', $id)->delete();
        } else {
            //空（まだ「いいね」していない）ならlikesテーブルに新しいレコードを作成する
            $like = new Like;
            $like->movie_id = $request->movie_id;
            $like->user_id = Auth::user()->id;
            $like->save();
        }

        //loadCountとすればリレーションの数を○○_countという形で取得できる（今回の場合はいいねの総数）
        // $movieLikesCount = $movie->loadCount('likes')->likes_count;
        $movieLikesCount = Movie::withCount('likes')->findOrFail($movie_id)->likes_count;

        //一つの変数にajaxに渡す値をまとめる
        //今回ぐらい少ない時は別にまとめなくてもいいけど一応。笑
        $json = [
            'movieLikesCount' => $movieLikesCount,
        ];
        //下記の記述でajaxに引数の値を返す
        return response()->json($json);
    }
}

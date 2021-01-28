<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        $posts = DB::table('posts')
            ->join('profiles', 'posts.user_id', '=', 'profiles.id')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
            ->select('posts.id', 'posts.user_id AS post_userid', 'posts.tweettitle', 'posts.tweetcontent', 'posts.tweetimage', 'posts.created_at', 'profiles.description AS profilename', 'profiles.image AS profileimage', 'users.name AS username', DB::raw('AVG(IFNULL(ratings.rating, 0)) AS rating'))
            ->groupBy('posts.id')
            ->orderBy('rating', 'desc')
            ->orderBy('posts.created_at', 'desc')
            ->get();

        return view('welcome')->with('posts', $posts);
    }
}

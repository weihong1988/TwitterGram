<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Keyword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use DonatelloZa\RakePlus\RakePlus;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'tweet_title' => 'required',
            'tweet_text' => 'required_without:tweet_img',
            'tweet_img' => 'image',
        ]);        
        
        $user = Auth::user();
        $post = new Post();

        if (empty(request('tweet_img')))
            $imagePath = null;
        else
            $imagePath = request('tweet_img')->store('uploads', 'public');        

        $post->user_id = $user->id;
        $post->tweettitle = request('tweet_title');
        $post->tweetcontent = request('tweet_text');
        $post->tweetimage = $imagePath;
        $post->save();

        $rake = RakePlus::create($post->tweettitle, 'en_US');
        $phrase_scores = $rake->sortByScore('desc')->scores();

        foreach($phrase_scores as $key => $value) 
        {
            $keyword = new Keyword();

            $keyword->user_id = $user->id;
            $keyword->post_id = $post->id;

            $keyword->keyword = $key;
            $keyword->score = $value;

            $keyword->save();
        }

        if (!empty(request('tweet_text')))
        {
            $rake = RakePlus::create(request('tweet_text'), 'en_US');
            $phrase_scores = $rake->sortByScore('desc')->scores();

            foreach($phrase_scores as $key => $value) 
            {
                $keyword = new Keyword();

                $keyword->user_id = $user->id;
                $keyword->post_id = $post->id;

                $keyword->keyword = $key;
                $keyword->score = $value;

                $keyword->save();
            }
        }

        $userprofile = DB::table('profiles')->where('user_id', '=', $user->id)->first();
        $profilepic = base64_encode(Storage::get('public/' . $userprofile->image));

        if (!empty(request('tweet_img')))
            $tweetimg = base64_encode($request->file('tweet_img')->get());
        else
            $tweetimg = "";

        return response()->json([
            'id' => $post->id,
            'profilepic' => $profilepic,
            'profilename' => $userprofile->description,
            'tweet_title' => request('tweet_title'),
            'tweet_text' => request('tweet_text'),
            'tweet_img' => $tweetimg,
            'tweet_created_at' => date('M j, Y', time() + 8 * 3600),
            'username' => $user->name
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($postID)
    {
        $post = DB::table('posts')
                ->join('profiles', 'posts.user_id', '=', 'profiles.id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->select('posts.id', 'posts.user_id AS post_userid', 'posts.tweettitle', 'posts.tweetcontent', 'posts.tweetimage', 'posts.created_at', 'profiles.description AS profilename', 'profiles.image AS profileimage', 'users.name AS username')
                ->where('posts.id', '>', $postID)
                ->oldest('posts.id')
                ->first();

        if (empty($post))
        {
            return response()->json([
                'message' => 'OK'
            ]);
        }
        else
        {
            $profilepic = base64_encode(Storage::get('public/' . $post->profileimage));

            if (!empty($post->tweetimage))
                $tweetimg = base64_encode(Storage::get('public/' . $post->tweetimage));
            else
                $tweetimg = "";

            return response()->json([
                'id' => $post->id,
                'profilepic' => $profilepic,
                'profilename' => $post->profilename,
                'tweet_title' => $post->tweettitle,
                'tweet_text' => $post->tweetcontent,
                'tweet_img' => $tweetimg,
                'tweet_created_at' => date('M j, Y', strtotime($post->created_at) + 8 * 3600),
                'username' => $post->username
            ]);
        }
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $data = request()->validate([
            'tweet_title' => 'required',
            'tweet_img' => 'image',
        ]);

        $user = Auth::user();

        if (!empty(request('tweet_img')))
        {
            $imagePath = request('tweet_img')->store('uploads', 'public');
            $post->tweetimage = $imagePath;
        }   

        $post->tweettitle = request('tweet_title');
        $post->tweetcontent = request('tweet_text');
        $post->save();

        $userprofile = DB::table('profiles')->where('user_id', '=', $user->id)->first();
        $profilepic = base64_encode(Storage::get('public/' . $userprofile->image));

        if (!empty($post->tweetimage))
            $tweetimg = base64_encode(Storage::get('public/' . $post->tweetimage));
        else
            $tweetimg = "";

        return response()->json([
            'id' => $post->id,
            'profilepic' => $profilepic,
            'profilename' => $userprofile->description,
            'tweet_title' => request('tweet_title'),
            'tweet_text' => request('tweet_text'),
            'tweet_img' => $tweetimg,
            'tweet_created_at' => date('M j, Y', strtotime($post->created_at) + 8 * 3600),
            'username' => $user->name
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $postdata = Post::where('id', '=', $post->id)->first();

        if ($postdata == null)
            return response()->json(['error' => 'id not found in DB'], 422);
        else
        {
            if (!empty($postdata->image))
                Storage::delete($postdata->image);

            DB::table('posts')->where('id', '=', $post->id)->delete();

            return response()->json([
                'post' => $post->id,
                'action' => 'deleted'
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Follower;
use App\Models\Profile;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check() == false)
            return redirect('/');
        else
        {
            $ratings_user_id = DB::table('ratings')
                ->select('user_id', DB::raw('AVG(rating) as average'))
                ->groupBy('user_id')
                ->orderBy('average', 'desc')
                ->take(5)
                ->get();

            $tags = array();
            $i = 0;

            foreach ($ratings_user_id as $ratings_user)
            {
                $keyword = DB::table('keywords')
                    ->select('keyword', DB::raw('SUM(score) as score'))
                    ->where('user_id', '=', $ratings_user->user_id)
                    ->groupBy('keyword')
                    ->orderBy('score', 'desc')
                    ->take(10)
                    ->get();

                if (!$keyword->isEmpty())
                {
                    $userprofile = DB::table('profiles')
                        ->join('users', 'profiles.user_id', '=', 'users.id')
                        ->select('profiles.user_id AS id', 'profiles.description AS profilename', 'profiles.image AS profileimage', 'users.name AS username')
                        ->where('profiles.user_id', '=', $ratings_user->user_id)
                        ->first();

                    $tags[$i] = new \stdClass;
                    $tags[$i]->profile = $userprofile;
                    
                    $j = 0;

                    foreach ($keyword as $word)
                    {
                        $tags[$i]->keyword[$j] = $word->keyword;
                        $tags[$i]->weight[$j] = $word->score;

                        $j++;
                    }

                    $i++;
                }
            }

            $user = Auth::user();
            $profile = Profile::where('user_id', $user->id)->first();

            $friends = DB::table('followers')
                ->select('friend_id')
                ->where('user_id', '=', $user->id)
                ->get();

            $following = array();
            $i = 0;
            foreach ($friends as $friend)
            {
                $following[$i] = $friend->friend_id;
                $i++;
            }
            
            return view('friend', [
                'user' => $user,
                'profile' => $profile,
                'following' => $following,
                'tag_cloud' => $tags,
            ]);
        }
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
        $data = request()->validate([
            'friend_id' => 'required|integer',
        ]);

        $user = Auth::user();

        $follower = new Follower();

        $follower->user_id = $user->id;
        $follower->friend_id = request('friend_id');
        $follower->save();

        return response()->json([
            'message' => 'OK'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Follower  $follower
     * @return \Illuminate\Http\Response
     */
    public function show(Follower $follower)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Follower  $follower
     * @return \Illuminate\Http\Response
     */
    public function edit(Follower $follower)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Follower  $follower
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Follower $follower)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Follower  $follower
     * @return \Illuminate\Http\Response
     */
    public function destroy(Follower $follower)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\Post;

use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function create()
    {
        return view('createProfile');
    }

    public function index()
    {
        if(Auth::check() == false)
            return redirect('/');
        else
        {
            $user = Auth::user();
            $profile = Profile::where('user_id', $user->id)->first();

            $friends = DB::table('followers')
                ->join('profiles', 'followers.friend_id', '=', 'profiles.user_id')
                ->join('users', 'followers.friend_id', '=', 'users.id')
                ->select('followers.id AS id', 'followers.friend_id AS friend_id', 'profiles.description AS profilename', 'profiles.image AS profileimage', 'users.name AS username')
                ->where('followers.user_id', '=', $user->id)
                ->get();

            $friends_posts = DB::table('followers')
                ->join('posts', 'followers.friend_id', '=', 'posts.user_id')
                ->join('profiles', 'followers.friend_id', '=', 'profiles.user_id')
                ->join('users', 'followers.friend_id', '=', 'users.id')
                ->leftJoin('ratings', function ($join) use ($user)
                    {
                        $join->on('posts.id', '=', 'ratings.post_id');
                        $join->on('ratings.user_id', '=', DB::raw($user->id));
                    })
                ->select('posts.id', 'posts.user_id AS post_userid', 'posts.tweettitle', 'posts.tweetcontent', 'posts.tweetimage', 'posts.created_at AS time', 'profiles.description AS profilename', 'profiles.image AS profileimage', 'users.name AS username', 'ratings.rating')
                ->where('followers.user_id', '=', $user->id);

            $all_posts = DB::table('posts')
                ->join('profiles', 'posts.user_id', '=', 'profiles.user_id')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->leftJoin('ratings', function($join) use ($user)
                    {
                        $join->on('posts.id', '=', 'ratings.post_id');
                        $join->on('ratings.user_id', '=', DB::raw($user->id));
                    })
                ->select('posts.id', 'posts.user_id AS post_userid', 'posts.tweettitle', 'posts.tweetcontent', 'posts.tweetimage', 'posts.created_at AS time', 'profiles.description AS profilename', 'profiles.image AS profileimage', 'users.name AS username', 'ratings.rating')
                ->where('posts.user_id', '=', $user->id)
                ->union($friends_posts)
                ->orderBy('time', 'desc')
                ->get();

            if (empty($all_posts))
                $latest = 0;
            else
                $latest = $all_posts[0]->id;

            return view('profile', [
                'user' => $user,
                'profile' => $profile,
                'following' =>$friends,
                'posts' => $all_posts,
                'latest' => $latest
            ]);
        }
    }

    public function store() 
    {
        $data = request()->validate([
            'description' => 'required',
            'profilepic' => ['required', 'image'],
        ]);

        // store the image in uploads, under public
        $imagePath = request('profilepic')->store('uploads', 'public');

        // create a new profile, and save it
        $user = Auth::user();
        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->description = request('description');
        $profile->image = $imagePath;

        if (request('referral') == 'letmein')
            $profile->isadmin = true;
        else
            $profile->isadmin = false;

        $saved = $profile->save();

        // if it saved, we send them to the profile page
        if ($saved)
            return redirect('/profile');
    }

    public function update()
    {
        $data = request()->validate([
            'description' => 'required',
            'profilepic' => 'image',
        ]);    // Load the existing profile

        $user = Auth::user();    //this is empty and returning null
        $profile = Profile::where('user_id', $user->id)->first();

        if(empty($profile))
        {
            $profile = new Profile();
            $profile->user_id = $user->id;
        }    
        
        $profile->description = request('description');    // Save the new profile pic... if there is one in the request()!

        if (request()->has('profilepic')) 
        {
            $imagePath = request('profilepic')->store('uploads', 'public');
            $profile->image = $imagePath;
        }    // Now, save it all into the database

        $updated = $profile->save();

        if ($updated) 
        {
            return redirect('/profile');
        }
    }

    public function edit()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();
        return view('editProfile', [
            'profile' => $profile
        ]);
    }
}

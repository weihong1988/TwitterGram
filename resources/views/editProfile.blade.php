@extends('layouts.app')@section('content')
   <div class="container">
       <div class="row">
           <div class="col-4"></div>
           <div class="col-4">
                <h1 style="margin-left: -15px;">Edit Profile</h1>
                <form action="{{ route('profile.update', $profile->user_id)}}" enctype="multipart/form-data" method="post">
                   @csrf
                   @if ($profile == null)
                       <div>where my profile</div>
                   @endif
                   <div class="form-group row">
                       <label for="description">Description</label>
                       <input class="form-control" type="text" name="description" id="description"
                           value="{{ $profile->description }}">
                   </div>
                   <div class="form-group row">
                       <label for="profilepic">Profile picture &nbsp;&nbsp;</label>
                       <input type="file" name="profilepic" id="profilepic">
                   </div>
                   <div class="form-group row">
                       <button type="submit" class="btn btn-primary">Update profile</button>
                   </div>
               </form>
           </div>
           <div class="col-4"></div>
       </div>
   </div>
@endsection
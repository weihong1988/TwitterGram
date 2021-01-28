@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <h1 style="margin-left: -15px;">Create Profile</h1>
                <form action="{{ route('profile.store') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group row">
                        <label for="description">Profile Description</label>
                        <input class="form-control" type="text" name="description" id="description">
                    </div>
                    <div class="form-group row">
                        <label for="description">Admin Referral Code</label>
                        <input class="form-control" type="text" name="referral" id="referral">
                    </div>

                    <div class="form-group row">
                        <label for="profilepic">Profile Picture &nbsp;&nbsp;</label>
                        <input type="file" name="profilepic" id="profilepic">
                    </div>

                    <div class="form-group row">
                        <button type="submit" class="btn btn-primary">Create profile</button>
                    </div>
                </form>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
@endsection




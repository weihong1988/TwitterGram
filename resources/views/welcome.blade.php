@extends('layouts.app')@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="container">
                    <div style="margin: 25px 0px 75px 50px;">
                        <h1>Happening now</h1>
                        <br>
                        <h3>Join BadTwitter today. The privacy experts.</h3>
                    </div>
                    <img src={{ url('/images/lock.png') }} height="400px" style="display: block; margin-left: auto; margin-right: auto;" />
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
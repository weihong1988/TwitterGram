@extends('layouts.app')@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="container">
                    <!-- Home title for Twitter -->
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <h3 style="font-weight: bold">Trending Now</h3>
                            <hr>
                        </div>
                    </div>

                    <div class="row pt-5" id="tweets">
                        @if (count($posts) == 0)
                            <h4 style="margin-left: 40px;">No tweets today.</h4>
                        @else
                            @foreach($posts as $post)
                            <div class="col-12" id="tweetdiv_{{ $post->id }}">
                                <div class="row">
                                    <div class="col-md-2">
                                        <img class="rounded-circle" width="50" src="/storage/{{ $post->profileimage }}">
                                    </div>
                                    <div class="col-md-10">
                                        <span style="font-weight: bold; font-style: italic;">{{ $post->profilename }}</span>
                                        &nbsp;&nbsp;
                                        <span style="font-style: italic;">{{ '@' . $post->username }}</span>
                                        <span style="margin-left: 10px;">{{ date('M j, Y', strtotime($post->created_at) + 8 * 3600) }}</span>

                                        <p id="tweettitle_{{ $post->id }}"
                                            style="font-weight: bold; text-decoration-line: underline; margin-top: 10px; margin-bottom: 0px">
                                            {{ $post->tweettitle }}</p>

                                        @if (!empty($post->tweetcontent))
                                        <p id="tweettext_{{ $post->id }}">{{ $post->tweetcontent }}</p>
                                        @endif

                                        @if (!empty($post->tweetimage))
                                        <img src="/storage/{{$post->tweetimage}}" height="200"
                                            class="rounded mx-auto d-block">
                                        @endif

                                        <div style="margin-top: 5px;">User Ratings: {{ round($post->rating, 1) }} / 5</div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
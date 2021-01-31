@extends('layouts.app')@section('content')

<script>
    function GenerateTweet(dataObject)
    {
        var HTMLstring;

        HTMLstring = '<div class="col-12" style="display:none; " id="tweetdiv_' + dataObject.id + '"><div class="row">';

        // Profile
        HTMLstring += '<div class="col-md-2">';
        HTMLstring += '<img class="rounded-circle" width="50" src="data:image/png;base64, ' + dataObject.profilepic + '">';
        HTMLstring += '</div>';

        // Tweet
        HTMLstring += '<div class="col-md-10">';
        HTMLstring += '<span style="font-weight: bold; font-style: italic;">' + dataObject.profilename + '</span> &nbsp;&nbsp;';
        HTMLstring += '<span style="font-style: italic;">@' + dataObject.username + '</span>';
        HTMLstring += '<span style="margin-left: 10px;">' + dataObject.tweet_created_at + '</span>';

        // Title
        HTMLstring += '<p id="tweettitle_' + dataObject.id + '" style="font-weight: bold; text-decoration-line: underline; margin-top: 10px; margin-bottom: 0px">' + dataObject.tweet_title + '</p>';

        // Content
        if (dataObject.tweet_text != null)
            HTMLstring += '<p id="tweettext_' + dataObject.id + '">' + dataObject.tweet_text + '</p>';

        // Picture
        if (dataObject.tweet_img != "")
            HTMLstring += '<img class="rounded mx-auto d-block" height="200" src="data:image/png;base64, ' + dataObject.tweet_img + '">';

        // Rating
        HTMLstring += '<div style="float: left; margin-top: 10px;">Your Rating: &nbsp;&nbsp;</div>';
        HTMLstring += '<div id="ratingdiv_' + dataObject.id + '" style="float: left; margin-top: 10px;"><select id="rating_' + dataObject.id + '"class="tweetrating" data-field-name="rating_' + dataObject.id + '">';
        HTMLstring += '<option value=""></option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option>';
        HTMLstring += '</select></div>';

        // Edit / delete
        HTMLstring += '<div style="float: right; margin-top: 10px;">';
        HTMLstring += '<img class="edittweet" id="edit_' + dataObject.id + '" src={{ url('/images/pencil.svg') }} height="20"/>';
        HTMLstring += '&nbsp;&nbsp;';
        HTMLstring += '<img class="deletetweet" id="delete_' + dataObject.id + '" src={{ url('/images/bin.svg') }} height="20"/>';
        HTMLstring += '</div>';
        
        HTMLstring += '</div>';
        HTMLstring += '</div><hr></div>';

        return HTMLstring;
    }

    $(document).ready(function($)
    {
        var LatestTweetID = {{ $latest->id }};

        function FixBarRating(domselector)
        {
            $(domselector).barrating(
            {
                theme: 'fontawesome-stars',
                onSelect: function(value, text, event) 
                {
                    var ElementID = this.$elem.data().fieldName
                    var PostID = ElementID.substring(ElementID.indexOf("_") + 1);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax(
                    {
                        url: '/rating',
                        type: 'POST',
                        data: 
                        {
                            tweet_id: PostID,
                            rating: value
                        },
                        dataType: 'json',
                        success: function(data)
                        {
                            $('#ratingdiv_' + PostID).append('<div id="rating_saved" style="font-style: italic;">Thanks for rating!</div>');
                            setTimeout(function ()
                            {
                                $('#rating_saved').fadeOut(function()
                                {
                                    $(this).remove();
                                });
                            }, 1000);
                        },
                        error: function (errormsg) 
                        {
                            alert(errormsg.responseText);
                        },
                        cache: false
                    });
                }
            });
        }

        $("#TweetSubmit").submit(function(e) 
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            e.preventDefault();    
            var formData = new FormData(this);

            $.ajax({
                url: '/post',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (data) 
                {
                    LatestTweetID = data.id;

                    var newtweet = GenerateTweet(data);
                    $('#tweets').prepend(newtweet);

                    FixBarRating('#rating_' + data.id);

                    $('#submit_tweet_title').val('');
                    $('#submit_tweet_text').val('');
                    $('#submit_tweet_img').val('');

                    $('#tweetdiv_' + data.id).slideDown("slow");
                },
                error: function (errormsg) 
                {
                    alert(errormsg.responseText);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });

        $("#PostTweetButton").click(function() 
        {
            $("#TweetSubmit").submit();
        });

        $('body').on('click', '.deletetweet', function(e)
        {
            var ElementID = $(this).attr('id');
            var PostID = ElementID.substring(ElementID.indexOf("_") + 1);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            e.preventDefault();    

            $.ajax({
                url: '/post/' + PostID,
                type: 'DELETE',
                success: function (data) 
                {
                    $('#tweetdiv_' + PostID).fadeOut(1500, function() { $(this).remove(); });
                },
                error: function (errormsg) 
                {
                    $('#tweetdiv_' + PostID).fadeOut(1500, function() { $(this).remove(); });
                    //alert(errormsg.responseText);
                },
                cache: false
            });
        });

        $('body').on('click', '.edittweet', function(e)
        {
            var ElementID = $(this).attr('id');
            var PostID = ElementID.substring(ElementID.indexOf("_") + 1);

            $('#EditTweetID').val(PostID);
            $("#EditTweetTitle").val($('#tweettitle_' + PostID).text());
            $("#EditTweetDesc").val($('#tweettext_' + PostID).text());
            $('#EditTweetImg').val('');

            jQuery('#formModal').modal('show');
        });

        $("#EditTweetButton").click(function() 
        {
            $("#EditTweetForm").submit();
        });

        $("#EditTweetForm").submit(function(e) 
        {
            var PostID = $('#EditTweetID').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: '/post/' + PostID,
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (data) 
                {
                    var replacetweet = GenerateTweet(data);
                    $('#tweetdiv_' + PostID).replaceWith(replacetweet);

                    FixBarRating('#rating_' + data.id);

                    jQuery('#formModal').modal('hide');

                    $('#tweetdiv_' + PostID).fadeIn(3000);
                },
                error: function (errormsg) 
                {
                    alert(errormsg.responseText);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });

        FixBarRating('.tweetrating');

        const xhrUpdateTimer = setInterval(function() 
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax(
            {
                url: '/post/' + LatestTweetID,
                type: 'GET',
                dataType: 'json',
                success: function(data)
                {
                    if ('id' in data)
                    {
                        LatestTweetID = data.id;

                        var newtweet = GenerateTweet(data);
                        $('#tweets').prepend(newtweet);

                        FixBarRating('#rating_' + data.id);

                        $('#tweetdiv_' + data.id).slideDown("slow");
                    }
                },
                error: function (errormsg) 
                {
                    //alert(errormsg.responseText);
                },
                cache: false
            });
        }, 5000);
    });

</script>

<div class="col-md-2" style="position: fixed; height: 400px; margin-left: 20px; overflow-y: scroll;">
    <h4 style="text-align: center; font-weight: bold;">Following</h4>
    @foreach($following as $friend)
    <div class="row" id="following_{{ $friend->friend_id }}" style="margin-top: 20px;">
        <img class="rounded-circle" width="50" src="/storage/{{ $friend->profileimage }}">
        <div style="display: inline-block; padding: 10px 25px;">
            <p style="margin-bottom: 0px;">{{ '@' . $friend->username }}</p>
        </div>
    </div>
    @endforeach
</div>

<div class="col-md-2" style="position: fixed; height: 100px; top: calc(100vh - 100px); margin-left: 20px;">
    <img class="rounded-circle" width="50" src="/storage/{{ $profile->image }}">
    <div style="display: inline-block;">
        <p style="font-weight: bold; margin-bottom: 0px;">{{ $profile->description }}</p>
        <p style="margin-bottom: 0px;">{{ '@' . $user->name }}</p>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="container">
                    <!-- Home title for Twitter -->
                    <div class="row justify-content-center">
                        <div class="col-md-12 mt-1">
                            <h3 style="font-weight: bold">Home</h3>
                            <hr>
                        </div>
                    </div>

                    <!-- Twitter Post -->
                    <div class="row justify-content-center">
                        <!-- Profile Pic -->
                        <div class="col-md-2">
                            <img class="rounded-circle" width="70" src="/storage/{{ $profile->image }}">
                            <p style="font-weight: bold;">{{ $profile->description }}</p>
                        </div>
                        <div class="col-md-10">
                            <form id="TweetSubmit" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input class="form-control" type="text" id="submit_tweet_title" name="tweet_title"
                                        style="font-size: 14pt; width: 100%;" placeholder="Title">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" id="submit_tweet_text" name="tweet_text" rows="3"
                                        style="font-size: 14pt;" placeholder="What's happening?"></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="image-upload" style="text-align: left; float: left;">
                                        Upload a picture: &nbsp;&nbsp;
                                        <label for="submit_tweet_img">
                                            <img src={{ url('/images/file-picture.svg') }} height="30" />
                                        </label>

                                        <input id="submit_tweet_img" name="tweet_img" type="file" />
                                    </div>
                                    <div style="text-align: right; float: right;" class="animate__animated animate__heartBeat animate__infinite">
                                        <a id="PostTweetButton" class="TweetButton">Tweet</a>
                                    </div>
                                </div>
                            </form>
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
                                        <span style="margin-left: 10px;">{{ date('M j, Y', strtotime($post->time) + 8 * 3600) }}</span>

                                        <p id="tweettitle_{{ $post->id }}" style="font-weight: bold; text-decoration-line: underline; margin-top: 10px; margin-bottom: 0px">{{ $post->tweettitle }}</p>

                                        @if (!empty($post->tweetcontent))
                                        <p id="tweettext_{{ $post->id }}">{{ $post->tweetcontent }}</p>
                                        @endif

                                        @if (!empty($post->tweetimage))
                                        <img src="/storage/{{$post->tweetimage}}" height="200"
                                            class="rounded mx-auto d-block">
                                        @endif

                                        <div style="float: left; margin-top: 10px;">Your Rating: &nbsp;&nbsp;</div>
                                        <div id="ratingdiv_{{ $post->id }}" style="float: left; margin-top: 10px;">
                                            <select id="rating_{{ $post->id }}" class="tweetrating" data-field-name="rating_{{ $post->id }}">
                                                <option value=""></option>
                                                @if ($post->rating == 1)
                                                    <option value="1" selected>1</option>
                                                @else
                                                    <option value="1">1</option>
                                                @endif
                                                @if ($post->rating == 2)
                                                    <option value="2" selected>2</option>
                                                @else
                                                    <option value="2">2</option>
                                                @endif
                                                @if ($post->rating == 3)
                                                    <option value="3" selected>3</option>
                                                @else
                                                    <option value="3">3</option>
                                                @endif
                                                @if ($post->rating == 4)
                                                    <option value="4" selected>4</option>
                                                @else
                                                    <option value="4">4</option>
                                                @endif
                                                @if ($post->rating == 5)
                                                    <option value="5" selected>5</option>
                                                @else
                                                    <option value="5">5</option>
                                                @endif
                                            </select>
                                        </div>

                                        @if ($user->id == $post->post_userid || $profile->isadmin == true)
                                        <div style="float: right; margin-top: 10px;">
                                            <img class="edittweet" id="edit_{{ $post->id }}"
                                                src={{ url('/images/pencil.svg') }} height="20" />
                                            &nbsp;&nbsp;
                                            <img class="deletetweet" id="delete_{{ $post->id }}"
                                                src={{ url('/images/bin.svg') }} height="20" />
                                        </div>
                                        @endif
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

<div class="modal fade" id="formModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="formModalLabel">Edit Tweet</h4>
            </div>
            <div class="modal-body">
                <form id="EditTweetForm" name="EditTweetForm" class="form-horizontal" method="post"
                    enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <input type="hidden" id="EditTweetID" name="EditTweetID" value="">
                    <div class="form-group">
                        <label for="EditTweetTitle">Tweet Title</label>
                        <input class="form-control" type="text" id="EditTweetTitle" name="tweet_title"
                            style="font-size: 14pt; width: 100%;">
                        </textarea>
                    </div>

                    <div class="form-group">
                        <label for="EditTweetDesc">Tweet Message</label>
                        <textarea class="form-control" id="EditTweetDesc" name="tweet_text" rows="3"
                            style="font-size: 14pt; width: 100%;">
                        </textarea>
                    </div>

                    <div class="form-group">
                        <div class="image-upload" style="text-align: left; float: left;">
                            Change tweet picture: &nbsp;&nbsp;
                            <label for="EditTweetImg">
                                <img src={{ url('/images/file-picture.svg') }} height="30" />
                            </label>

                            <input id="EditTweetImg" name="tweet_img" type="file" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="EditTweetButton" value="edit">Save changes
                </button>
                <input type="hidden" id="todo_id" name="todo_id" value="0">
            </div>
        </div>
    </div>
</div>

@endsection
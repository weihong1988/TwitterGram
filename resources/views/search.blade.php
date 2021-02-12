@extends('layouts.app')@section('content')

<script>
$(document).ready(function($)
{
    @php
        $i = 0;

        foreach ($tag_cloud as $tagusers)
        {
            echo "var tag_cloud_$i = [\n";

            for ($j=0; $j<count($tagusers->keyword); $j++)
            {
                $keyword_string = $tagusers->keyword[$j];
                $keyword_weight = $tagusers->weight[$j];

                echo "{text: \"$keyword_string\", weight: $keyword_weight},\n";
            }

            echo "];\n";

            echo "$('#wordcloud_$i').jQCloud(tag_cloud_$i,\n";
            echo "{\n";
            echo "width: 400,\n";
            echo "height: 150,\n";
            echo "shape: 'rectangular',\n";
            echo "center: { x: 0.3, y: 0.5 }\n";
            echo "});\n";

            $i++;
        }
    @endphp

    $(".FollowButton").click(function() 
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var ElementID = event.target.id;
        var FriendID = ElementID.substring(ElementID.indexOf("_") + 1);

        var formData = new FormData();    
        formData.append('friend_id', FriendID);

        $.ajax({
            url: '/follower',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (data) 
            {
                $("#" + ElementID).text("Added");
                $("#" + ElementID).removeClass().addClass("AddedButton");
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

    $("#SearchButton").click(function() 
    {
        $("#DiscoverFriends").submit();
    });
});

</script>

<!-- My profile -->
<div class="col-md-2 card" style="position: fixed; height: 100px; top: calc(100vh - 120px); margin-left: 25px;">
    <div class="row" style="margin-top: 20px; margin-left: 5px;">
        <img class="rounded-circle" width="50" height="50" src="/storage/{{ $profile->image }}">
        <div style="display: inline-block; padding-left: 10px;">
            <p style="font-weight: bold; margin-bottom: 0px;">{{ $profile->description }}</p>
            <p style="margin-bottom: 0px;">{{ '@' . $user->name }}</p>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 card">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 mt-1">
                        <h3 style="font-weight: bold">Discover friends</h3>
                        <hr>
                    </div>
                </div>

                <!-- Search Form -->
                <div class="row justify-content-center">
                    <div class="col-md-12 pb-3">
                        <form id="DiscoverFriends" action="{{ route('follower.search') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input class="form-control" type="text" id="search_tag" name="search_tag"
                                    style="font-size: 14pt; width: 100%;" value="{{ $search_phrase }}">
                            </div>
                            <div class="form-group">
                                <div style="text-align: right; float: right;">
                                    <a id="SearchButton" class="TweetButton">Find!</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8 card">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 mt-1">
                        <h3 style="font-weight: bold">Users found</h3>
                        <hr>
                    </div>
                </div>

                <div class="row pt-5" id="tag_cloud_users">
                    @if (count($tag_cloud) == 0)
                        <h4 style="margin-left: 40px;">No interesting users found.</h4>
                    @else
                        @foreach($tag_cloud as $tag_users)
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <img class="rounded-circle" width="50" height="50" src="/storage/{{ $tag_users->profile->profileimage }}">
                                    <p style="font-style: italic;">{{ '@' . $tag_users->profile->username }}</p>
                                </div>
                                <div class="col-md-7">
                                    <p style="font-weight: bold; font-style: italic;">{{ $tag_users->profile->profilename }}</p>
                                    <div id="wordcloud_{{ $loop->index }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    @if ($tag_users->profile->id != $user->id)
                                        @if (in_array($tag_users->profile->id, $following))
                                            <a class="AddedButton">Added</a>
                                        @else
                                            <a id="followbutton_{{ $tag_users->profile->id }}" class="FollowButton">Follow</a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>   
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
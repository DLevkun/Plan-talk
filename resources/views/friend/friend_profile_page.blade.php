@extends('layouts.app')

@section('header')
    <div class="profile-img">
        <img src="{{asset($user->user_image)}}" alt="profile_image">
        @include('inc.forms.delete_update_buttons')
    </div>
    <div class="user_info row">
        <div class="user_name col">
            <h3>
                {{$user->full_name}}
            </h3>
            <h4 class="mb-3"><i> &commat;{{$user->nickname}}</i></h4>
        </div>
        <div class="user_descrip col-9">
            <h3>
                Description
            </h3>
            <p class="fs-4 new-line">
                <i>@if(!$user->description)No description
                    @else{{$user->description}}@endif</i>
            </p>
        </div>
    </div>
    <hr>
@endsection

@section('content')
    @include('inc.menu')
    <div class="col-9">
        <h3>POSTS</h3>
        @foreach($posts as $post)
            <h2>
                {{$post->title}}
                <img src="{{asset('img/comment_icon.png')}}" id="show-comment">
            </h2>
            <p>
                <small class="secondary-time">last updated {{$post->updated_at}}</small>
            </p>

            <p class="new-line">{{$post->post_description}}</p>

            @if(isset($post->post_image))
                <img src="{{$post->post_image}}" alt="post_image" width="500">
            @endif

            <p><a href="{{route('categoryPosts', $post->category->id)}}" class="category-tag"><b>#{{$post->category->title}}</b></a></p>
            <div class="like">
                <img src="{{asset('/img/like.png')}}" alt="like" id="like-btn" data-id="{{$post->id}}">
                <p id="likes-number">{{$post->likes}}</p>
            </div>
            <div class="hidden" id="comment-form">
                @foreach($post->comments as $comment)
                    <div class="row">
                        <div class="col-1">
                            <img src="{{$comment->user->user_image}}" alt="user_image" width="70">
                        </div>
                        <div class="col-11">
                            <h4>{{$comment->user->full_name}}</h4>
                            <p>{{$comment->text}}</p>
                        </div>
                    </div>
                    <p class="secondary-time mb-4">posted at {{$comment->created_at}}</p>
                @endforeach

                <form action="{{route('comment', $post->id)}}" method="post" class="mb-3">
                    @csrf
                    @method('post')
                    <textarea class="form-control" name="comment" cols="30" rows="3" placeholder="Comment the post"></textarea>
                    <input type="submit" name="submit" value="Comment" class="btn btn-outline-warning mt-3">
                </form>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/home.js')}}" defer></script>
@endsection

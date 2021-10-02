@extends('layouts.app')

@section('content')
    @include('inc.menu')
    <div class="col-9">
        <h1 class="mb-3">@lang('posts.in_category') '{{$title}}'</h1>
        @foreach($categoryPosts as $post)
            <h2>
                {{$post->title}}
                <img src="{{asset('img/comment_icon.png')}}" id="show-comment">
            </h2>
            <p>
                <small class="secondary-time">@lang('posts.last_update') {{$post->updated_at}}</small>
            </p>

            <p class="new-line">{{$post->post_description}}</p>

            @if(isset($post->post_image))
                <img src="{{$post->post_image}}" alt="post_image" width="500">
            @endif
            <div class="like mb-5">
                <img src="{{asset('/img/like.png')}}" alt="like" id="like-btn" data-id="{{$post->id}}">
                <p id="likes-number">{{$post->likes}}</p>
            </div>
            @include('inc.comments')
        @endforeach
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/home.js')}}" defer></script>
@endsection

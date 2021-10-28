@extends('layouts.app')

@section('content')
    @include('inc.menu')
    <div class="col-9">
        <h1 class="mb-3">@lang('posts.in_category') '{{$title}}'</h1>
        @foreach($categoryPosts as $post)
            <h2>
                <a href="{{route('posts.show', $post->id)}}" class="post-title">{{$post->title}}</a>

                @if($post->user_id === Auth::user()->id)
                    <a href="{{route('posts.edit', $post->id)}}">
                        <img src="{{asset('img/edit.png')}}" alt="edit" class="edit-icon">
                    </a>
                @endif
                <img src="{{asset('img/comment_icon.png')}}" id="show-comment">
            </h2>
            <p>
                <small class="secondary-time">@lang('posts.last_update') {{$post->updated_at}}</small>
            </p>
            <p class="new-line">{{$post->post_description}}</p>
            @if(isset($post->post_image) and $post->post_image != "")
                <img src="{{$post->post_image}}" alt="post_image" width="500">
            @endif
            <p><a href="{{route('categoryPosts', $post->category->id)}}" class="category-tag"><b>#{{$post->category->title}}</b></a></p>

            @if($post->user_id === Auth::user()->id)
                @include('inc.forms.delete_post_button')
            @endif
            @include('inc.comments')
        @endforeach
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/home.js')}}" defer></script>
@endsection

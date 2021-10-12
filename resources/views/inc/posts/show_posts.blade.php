@php
    //Session::put('page', $_GET['page'] ?? 1);
@endphp
@foreach($posts as $post)
    <h2>
        {{$post->title}}
        @if($myPage)
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
    @if(isset($post->post_image))
        <img src="{{$post->post_image}}" alt="post_image" width="500">
    @endif
    <p><a href="{{route('categoryPosts', $post->category->id)}}" class="category-tag"><b>#{{$post->category->title}}</b></a></p>

    <div class="like">
        <img src="{{asset('/img/like.png')}}" alt="like" id="like-btn" data-id="{{$post->id}}">
        <p id="likes-number">{{$post->likes}}</p>
    </div>

    @if($myPage)
        @include('inc.forms.delete_post_button')
    @endif
    @include('inc.comments')
@endforeach
@include('inc.posts.post_links')

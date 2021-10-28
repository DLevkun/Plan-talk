<h2>
    <a href="{{route('posts.show', $post->id)}}" class="post-title">{{$post->title}}</a>
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
@if(isset($post->post_image) and $post->post_image != "")
    <img src="{{$post->post_image}}" alt="post_image" width="500">
@endif
<p><a href="{{route('categoryPosts', $post->category->id)}}" class="category-tag"><b>#{{$post->category->title}}</b></a></p>

@if($myPage)
    @include('inc.forms.delete_post_button')
@endif
@include('inc.comments')

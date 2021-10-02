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
        <div class="row mb-4">
            <p class="secondary-time col-4">@lang('posts.comment_posted_at') {{$comment->created_at}}</p>
            @if($comment->user->id == Auth::user()->id)
                <a class="col-2" href="{{route('deleteComment', $comment->id)}}">@lang('posts.comment_delete')</a>
            @endif
        </div>
    @endforeach

    <form action="{{route('comment', $post->id)}}" method="post" class="mb-3">
        @csrf
        @method('post')
        <textarea class="form-control" name="comment" cols="30" rows="3" placeholder="@lang('posts.placeholder_comment')"></textarea>
        <input type="submit" name="submit" value="@lang('posts.comment')" class="btn btn-outline-warning mt-3">
    </form>
</div>

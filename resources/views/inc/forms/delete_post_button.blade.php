<form action="{{route('posts.destroy', $post->id)}}" method="post" class="mb-5">
    @csrf
    @method('delete')
    <input type="submit" id="delete" name="delete" value="@lang('posts.delete')" class="btn btn-outline-danger">
</form>

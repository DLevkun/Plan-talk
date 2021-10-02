@if(!empty($myFriends->whereIn('id', $user->id)->all()))
    <form action="{{route('friends.destroy', $user->id)}}" method="post" class="mt-3">
        @csrf
        @method('delete')
        <input type="submit" name="submit" class="btn btn-outline-danger" value="@lang('home.unfollow')">
    </form>
@else
    <form action="{{route('friends.follow', $user->id)}}" method="post" class="mt-3">
        @csrf
        @method('patch')
        <input type="submit" name="submit" class="btn btn-outline-success" value="@lang('home.follow')">
    </form>
@endif

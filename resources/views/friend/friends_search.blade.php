@extends('layouts.app')

@section('content')
    @include('inc.menu')
    <div class="col-9">
        <h1>@lang('friends.people')</h1>
        <form action="{{route('friends.search')}}" method="post" class="search-field mb-3">
            @csrf
            @method('post')
            <input type="text" name="search_field" class="form-control" placeholder="@lang('friends.search_placeholder')" value="{{$search}}">
            <input type="submit" name="submit" class="btn btn-info" value="@lang('friends.search')">
        </form>
        @if($friends->isEmpty())
            <h1>@lang('friends.no_matching')</h1>
        @else
            @foreach($friends as $user)
                <div class="row mb-4">
                    <div class="col-2">
                        <img src="{{$user->user_image}}" alt="user_image" width="100">
                    </div>
                    <div class="col-10">
                        <h2><a href="{{route('friends.show', $user->id)}}">{{$user->full_name}}</a></h2>
                        <p><i>&commat;{{$user->nickname}}</i></p>
                        @if(!empty($myFriends->whereIn('id', $user->id)->all()))
                            <form action="{{route('destroySearch', $user->id)}}"  method="post" class="mt-3">
                                @csrf
                                @method('delete')
                                <input type="submit" name="submit" class="btn btn-outline-danger" value="@lang('home.unfollow')">
                            </form>
                        @else
                            <form action="{{route('followSearch', $user->id)}}" method="post" class="mt-3">
                                @csrf
                                @method('patch')
                                <input type="submit" name="submit" class="btn btn-outline-success" value="@lang('home.follow')">
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection

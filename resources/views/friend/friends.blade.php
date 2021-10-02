@extends('layouts.app')

@section('content')
    @include('inc.menu')
    <div class="col-9">
        <h1>@lang('friends.my_friends')</h1>
        <form action="{{route('friends.search')}}" method="post" class="search-field mb-3">
            @csrf
            @method('post')
            <input type="text" name="search_field" class="form-control" placeholder="@lang('friends.search_placeholder')" value="{{old('search_field', '')}}">
            <input type="submit" name="submit" class="btn btn-info" value="@lang('friends.search')">
        </form>
        @include('inc.messages')
        @foreach($friends as $friend)
            <div class="row mb-4">
                <div class="col-2">
                    <img src="{{$friend->user_image}}" alt="user_image" width="100">
                </div>
                <div class="col-10">
                    <h2><a href="{{route('friends.show', $friend->id)}}">{{$friend->full_name}}</a></h2>
                    <p><i>&commat;{{$friend->nickname}}</i></p>
                    <form action="{{route('friends.destroy', $friend->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <input type="submit" name="submit" class="btn btn-outline-danger" value="@lang('home.unfollow')">
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection

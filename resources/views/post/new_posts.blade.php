@extends('layouts.app')

@section('content')
    @include('inc.menu')
    <div class="col-9">
        @if(empty($posts))
            <h1>No notifications</h1>
        @else
            @foreach($posts as $post)
                <h1><b>{{$post->user->full_name}}</b></h1>
                @include('inc.posts.one_post')
            @endforeach
        @endif
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/home.js')}}" defer></script>
@endsection

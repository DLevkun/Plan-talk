@extends('layouts.app')

@section('content')
    @include('inc.menu')
    <div class="col-9">
        @include('inc.posts.one_post')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/home.js')}}" defer></script>
@endsection

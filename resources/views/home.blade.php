@extends('layouts.app')

@section('header')
        <div class="profile-img">
            <img src="{{asset($user->user_image)}}" alt="profile_image">
            @if($isAdmin)
                <p class="center mt-3"> <b> @lang('home.admin') </b> </p>
            @endif
            @if($myPage)
                @include('inc.forms.upload_photo_form')
            @else
                @include('inc.forms.delete_update_buttons')
            @endif
        </div>
        <div class="user_info row">
            <div class="user_name col">
                <h3>
                    {{$user->full_name}}
                    @if($myPage)
                        <img class="edit-icon" id="edit-name-btn" src="{{asset('img/edit.png')}}" alt="edit">
                    @endif
                </h3>
                @if($user->nickname)
                    <h4 class="mb-3"><i> &commat;{{$user->nickname}}</i></h4>
                @endif
                @if($myPage)
                    @include('inc.forms.edit_user_info_form')
                @endif
            </div>
            <div class="user_descrip col-6">
                <h3>
                    @lang('home.description')
                    @if($myPage)
                        <img class="edit-icon" id="edit-btn" src="{{asset('img/edit.png')}}" alt="edit">
                    @endif
                </h3>
                <p class="fs-4 new-line">
                    <i>@if(!$user->description)@lang('home.no_description')
                        @else{{$user->description}}@endif</i>
                </p>
                @if($myPage)
                    @include('inc.forms.edit_user_description_form')
                @endif
            </div>
            <div class="col">
                @if(!$myPage)
                    <h2>
                        <a href="{{route('goals.show', $user->id)}}">View goals</a>
                    </h2>
                @endif
            </div>
        </div>
        <hr>
@endsection

@section('content')
        @include('inc.menu')
            <div class="col-9">
                <h1>@lang('home.posts')</h1>
                @if($myPage)
                    @include('inc.posts.create_post_form')
                @endif
                @foreach($posts as $post)
                    @include('inc.posts.one_post')
                @endforeach
                @include('inc.posts.post_links')
            </div>
@endsection

@section('scripts')
    <script src="{{asset('js/home.js')}}" defer></script>
    <script src="http://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"
            defer>
    </script>
@endsection

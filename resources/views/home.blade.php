@extends('layouts.app')

@section('header')
        <div class="profile-img">
            <img src="{{asset($user->user_image)}}" alt="profile_image">
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
                <h4 class="mb-3"><i> &commat;{{$user->nickname}}</i></h4>
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
                <h3>@lang('home.posts')</h3>
                @if($myPage)
                    @include('inc.forms.create_post_form')
                @endif
                @include('inc.posts.posts')
            </div>
@endsection

@section('scripts')
    <script src="{{asset('js/home.js')}}" defer></script>
{{--    <script--}}
{{--    src="https://code.jquery.com/jquery-3.6.0.min.js"--}}
{{--    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="--}}
{{--    crossorigin="anonymous"></script>--}}
    <script src="{{asset('/js/like.js')}}" defer>
    </script>
@endsection

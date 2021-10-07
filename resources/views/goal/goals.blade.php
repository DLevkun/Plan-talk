@extends('layouts.app')

@php
    //Session::put('page', $_GET['page'] ?? 1);
@endphp

@section('content')
    @include('inc.menu')
    <div class="col-9">
        <h1>
            @lang('goals.goals')
            <img id="create-goal-btn" src="{{asset('img/plus_icon.png')}}" alt="plus" class="edit-icon">
        </h1>
        @include('inc.goals.create_goal')
        @include('inc.progress_bar')
        @include('inc.goals.show_goals')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/goals.js')}}" defer></script>
@endsection

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
        <form method="post" action="{{route('goals.store')}}" class="mb-3">
            @csrf
            <div class="hidden" id="goal-form">
                <div class="mb-3">
                    <label for="title" class="form-label">@lang('home.title')</label>
                    <input type="text" class="form-control" placeholder="@lang('posts.placeholder_title')" name="title">
                </div>
                <div class="mb-3">
                    <label for="goal_description" class="form-label">@lang('home.description')</label>
                    <textarea class="form-control" name="goal_description" placeholder="@lang('goals.placeholder_descrip')" cols="30" rows="5"></textarea>
                </div>
                <div class="mb-3">
                    <select name="category_id" class="form-select">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->title}}</option>
                        @endforeach
                    </select>
                </div>
                <input type="submit" name="submit" class="btn btn-success mb-4" value="@lang('home.save')">
                </div>
            @include('inc.messages')
            @if(session('goal_success'))
                <div class="alert alert-success">
                    {{session('goal_success')}}
                </div>
            @endif
        </form>

        @include('inc.progress_bar')
        @include('inc.goals.show_goals')
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/goals.js')}}" defer></script>
@endsection

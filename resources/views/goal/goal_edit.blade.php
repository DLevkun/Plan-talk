@extends('layouts.app')

@section('content')
    @include('inc.menu')
        <div class="col-9">
            <h1 class="mb-2">@lang('goals.edit_goal')</h1>
            @include('inc.messages')
            <form action="{{route('goals.update', $goal->id)}}" method="post">
                @csrf
                @method('patch')

                <div class="mb-3">
                    <label for="title" class="form-label">@lang('home.title')</label>
                    <input type="text" name="title" class="form-control" value="{{old('title') ?? $goal->title}}">
                </div>
                <div class="mb-3">
                    <label for="goal_description" class="form-label">@lang('home.description')</label>
                    <textarea class="form-control" name="goal_description" cols="30" rows="10">{{old('goal_description') ?? $goal->goal_description}}</textarea>
                </div>
                <div class="mb-3">
                    <label for="is_done">@lang('goals.done')</label>
                    <input name="is_done" class="form-check-input ml-1" type="checkbox" {{(old('is_done') ?? $goal->is_done) ? 'checked' : ''}}>
                </div>
                <div class="mb-3">
                    <select name="category_id" class="form-select">
                        @foreach($categories as $category)
                            <option {{($goal->category_id == $category->id) ? 'selected' : ''}} value="{{$category->id}}">{{$category->title}}</option>
                        @endforeach
                    </select>
                </div>
                <input type="submit" id="saveGoal" name="submit" class="btn btn-success" value="@lang('home.save')">
            </form>
        </div>
@endsection

@extends('layouts.app')

@section('content')
    @include('inc.menu')
    <div class="col-9">
        <h1>Create group</h1>
        @include('inc.messages')
        <form action="{{route('groups.store')}}" method="post">
            @csrf
            @method('post')

            <div class="mb-3">
                <label for="title" class="form-label">@lang('home.title')</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{old('title')}}">
            </div>
            <div class="mb-3">
                <label for="group_description" class="form-label">@lang('home.description')</label>
                <textarea class="form-control" name="group_description" cols="30" rows="10">{{old('group_description')}}</textarea>
            </div>
            <div class="mb-3">
                <select name="category_id" class="form-select">
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->title}}</option>
                    @endforeach
                </select>
            </div>
            <input type="submit" name="submit" class="btn btn-success" value="@lang('home.save')">
        </form>
    </div>
@endsection()

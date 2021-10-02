@extends('layouts.app')

@section('content')
    @include('inc.menu')
        <div class="col-9">
            <h1>@lang('posts.edit_post')</h1>
            @include('inc.messages')
            <form action="{{route('posts.update', $post->id)}}" enctype="multipart/form-data" method="post">
                @csrf
                @method('patch')

                <div class="mb-3">
                    <label for="title" class="form-label">@lang('posts.title')</label>
                    <input type="text" name="title" class="form-control" value="{{old('title') ?? $post->title}}">
                </div>
                <div class="mb-3">
                    <label for="post_description" class="form-label">@lang('posts.description')</label>
                    <textarea name="post_description" class="form-control" cols="30" rows="10">{{old('post_description') ?? $post->post_description}}</textarea>
                </div>
                <div class="mb-3">
                    <select name="category_id" class="form-select">
                        @foreach($categories as $category)
                            <option {{($post->category_id == $category->id) ? 'selected' : ''}} value="{{$category->id}}">{{$category->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="post-image mb-3">
                    <label for="post_img" class="form-label">@lang('posts.choose_image')</label>
                    <input type="file" name="post_img" class="form-control" value="{{$post->post_image}}">
                </div>
                <input type="submit" name="submit" class="btn btn-success" value="@lang('home.save')">
            </form>
        </div>
@endsection

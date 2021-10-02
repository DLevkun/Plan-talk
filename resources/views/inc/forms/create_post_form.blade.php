<form method="post" action="{{route('posts.store')}}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label">@lang('home.title')</label>
        <input type="text" name="title" placeholder="@lang('posts.placeholder_title')" value="{{old('title')}}" class="form-control @error('title') is-invalid @enderror">
    </div>
    <div class="mb-3">
        <label for="post_description" class="form-label">@lang('home.description')</label>
        <textarea class="add-post form-control" name="post_description" cols="30" rows="5" placeholder="@lang('posts.placeholder_descrip')" class="@error('post_description') is-invalid @enderror">{{old('post_description')}}</textarea>
    </div>
    <div class="mb-3">
        <select name="category_id" class="post-form-select form-select">
            @foreach($categories as $category)
                <option {{(old('category') == $category->id) ? 'selected' : ''}} value="{{$category->id}}">{{$category->title}}</option>
            @endforeach
        </select>
    </div>
    <div class="post-image mb-3">
        <label for="post_img" class="form-label">@lang('posts.choose_image')</label>
        <input type="file" name="post_img" class="form-control">
    </div>
    <input type="submit" name="submit" value="@lang('posts.share')" class="btn btn-info mb-4">
    @error('title')
    @include('inc.messages')
    @enderror
    @if(session('post_success'))
        <div class="alert alert-success">
            {{session('post_success')}}
        </div>
    @endif
</form>

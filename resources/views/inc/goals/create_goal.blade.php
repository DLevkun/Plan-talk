<form method="post" action="{{route('goals.store')}}" class="mb-3">
    @csrf
    <div class="hidden" id="goal-form">
        <div class="mb-3">
            <label for="title" class="form-label">@lang('home.title')</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" placeholder="@lang('posts.placeholder_title')" name="title">
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
        <input type="submit" name="submit" id="addGoal" class="btn btn-success mb-4" value="@lang('home.save')">
    </div>
    @include('inc.messages')
    @if(session('goal_success'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&#10008</span>
            </button>
            {{session('goal_success')}}
        </div>
    @endif
</form>

@if(empty($goals->all()))
    <h1>@lang('goals.no_goals')</h1>
@else
    @foreach($goals as $goal)
    <h2>{{$goal->title}}</h2>
    <p>
        <small class="secondary-time">@lang('posts.last_update') {{$goal->updated_at}}</small>
    </p>
    @if($goal->is_done)
        <h3 class="done">@lang('goals.done')</h3>
    @endif
    <p>
        {{$goal->goal_description}}
    </p>
    <p><b>{{$goal->category->title}}</b></p>
    <div class="row mb-5">
        <div class="col-2">
            <a href="{{route('goals.edit', $goal->id)}}" class="btn btn-warning">@lang('goals.edit')</a>
        </div>
        <form class="col-1" action="{{route('goals.destroy', $goal->id)}}" method="post">
            @csrf
            @method('delete')
            <input type="submit" name="delete" class="btn btn-danger" value="@lang('goals.delete')">
        </form>
    </div>
@endforeach
    @include('inc.goals.goals_links')
@endif

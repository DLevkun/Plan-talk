<h1>
    {{$group->title}}
    @if($isAll and $isAdmin)
        <form action="{{route('groups.destroy', $group->id)}}" method="post" style="display:inline;">
            @csrf
            @method('delete')
            <button class="btn btn-outline-danger" style="font-size:15px;">@lang('goals.delete')</button>
        </form>
    @endif
</h1>
<p>
    {{$group->group_description}}
</p>
<p><b>{{$group->category->title}}</b></p>

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
<p style="font-size:18px;">
    <i> {{$group->group_description ?? 'No description'}} </i>
</p>
<p><b>{{$group->category->title}}</b></p>

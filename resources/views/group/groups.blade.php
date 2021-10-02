@extends('layouts.app')

@section('content')
    @include('inc.menu')
    <div class="col-9">
        <h1>
            @if($isAll)
                @lang('groups.all_groups')
            @else
                @lang('groups.my_groups')
                <a href="{{route('groups.index')}}">@lang('groups.view_all')</a>
            @endif
        </h1>
        @foreach($groups as $group)
            <div class="mb-5">
                @include('inc.groups.group_info')
                @if($isAll)
                    <form action="{{route('subscribe.edit', $group->id)}}" method="post">
                        @csrf
                        @method('post')
                        <button class="btn btn-success">@lang('groups.subscribe')</button>
                    </form>
                @else
                    <form action="{{route('subscribe.destroy', $group->id)}}" method="post" class="mb-4">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger">@lang('groups.unsubscribe')</button>
                    </form>
                @endif
            </div>
        @endforeach
        @include('inc.groups.group_links')
    </div>
@endsection

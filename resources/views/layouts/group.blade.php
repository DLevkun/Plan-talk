@extends('layouts.app')

@section('content')
    @include('inc.menu')
    <div class="col-9">
        <h1>@yield('title')</h1>
        @foreach($groups as $group)
            <div class="mb-5">
                <h1>{{$group->title}}</h1>
                <p>
                    {{$group->group_description}}
                </p>
                <p><b>{{$group->category->title}}</b></p>
                @yield('buttons')
            </div>
        @endforeach
    </div>
@endsection

@extends('layouts.app')


@section('content')
    @include('inc.menu')
    <div class="col-9">
        <h1>ALL GROUPS</h1>
        @foreach($groups as $group)
            @if(empty($userGroups->whereIn('id', $group->id)->all()))
                <div class="mb-5">
                    @include('inc.groups.group_info')
                    <form action="{{route('subscribe.edit', ['page' => $_GET['page'] ?? 1,'id' => $group->id])}}" method="post">
                        @csrf
                        @method('post')
                        <button class="btn btn-success">Subscribe</button>
                    </form>
                </div>
            @endif
        @endforeach
        @if($groups->total() > $groups->count())
            <br>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    {{ $groups->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection


@extends('layouts.app')

@section('content')
    @include('inc.menu')
        <div class="col-9" id="goals">
            @include('inc.goals.show_goals')
        </div>
@endsection

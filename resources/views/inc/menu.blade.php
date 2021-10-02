
<div class="col-3">
    <h3>@lang('home.menu')</h3>
    <p> <a href="{{route('home')}}" class="menu-btn btn btn-primary"> @lang('home.home_page') </a> </p>
    <p> <a href="{{route('goals.index')}}" class="menu-btn btn btn-outline-primary"> @lang('home.goals') </a> </p>
    <p> <a href="{{route('groups.show', Auth::user()->id)}}" class="menu-btn btn btn-outline-primary"> @lang('home.groups') </a> </p>
    <p> <a href="{{route('friends.index')}}" class="menu-btn btn btn-outline-primary"> @lang('home.my_friends') </a> </p>
</div>

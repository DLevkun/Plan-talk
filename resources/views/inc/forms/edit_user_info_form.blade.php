<form method="post" action="{{route('editUserInfo')}}" class="mb-3">
    @csrf
    <div class="hidden" id="user-info">
        <div class="mb-3">
            <label for="full_name" class="form-label">@lang('home.full_name')</label>
            <input class="form-control @error('full_name') is-invalid @enderror" type="text" name="full_name" value="{{$user->full_name}}">
        </div>
        <div class="mb-3">
            <label for="nickname" class="form-label">@lang('home.nickname')</label>
            <input class="form-control @error('nickname') is-invalid @enderror" type="text" name="nickname" value="{{$user->nickname}}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">@lang('home.email')</label>
            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" value="{{$user->email}}">
        </div>
        <input type="submit" name="submit" value="@lang('home.save')" class="btn btn-outline-success mb-3">
    </div>
    @error('full_name')
        @include('inc.messages')
    @enderror
</form>
@if(session('userinfo_success'))
    <div class="alert alert-success">
        {{session('userinfo_success')}}
    </div>
@endif

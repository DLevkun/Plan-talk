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
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&#10008</span>
            </button>
            {{$message}}
        </div>
    @enderror
    @error('nickname')
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&#10008</span>
        </button>
        {{$message}}
    </div>
    @enderror
    @error('email')
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&#10008</span>
        </button>
        {{$message}}
    </div>
    @enderror
</form>
@if(session('userinfo_success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&#10008</span>
        </button>
        {{session('userinfo_success')}}
    </div>
@endif

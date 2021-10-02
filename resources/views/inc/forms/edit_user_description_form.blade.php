<form method="post" action="{{route('editDescription')}}">
    @csrf
    <div class="hidden" id="description-info">
        <div class="mb-3">
            <label for="description" class="form-label">@lang('home.description')</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" cols="30" rows="5">{{trim($user->description)}}
            </textarea>
        </div>
        <input type="submit" name="submit" value="@lang('home.save')" class= "btn btn-outline-success mb-3">
    </div>
    @error('description')
        @include('inc.messages')
    @enderror
</form>
@if(session('description_success'))
    <div class="alert alert-success">
        {{session('description_success')}}
    </div>
@endif

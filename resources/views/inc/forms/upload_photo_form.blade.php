<form action="{{route('uploadFile')}}" method="post" class="input-group" enctype="multipart/form-data">
    @csrf
    <label for="inputFile" class="input-group-text">@lang('home.upload_photo')</label>
    <input type="file" class="form-control" id="inputFile" name="profile_img">
    <input type="submit" name="submit" class="btn btn-success" value="@lang('home.upload')">
</form>

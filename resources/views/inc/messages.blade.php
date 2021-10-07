@if(!empty($errors->all()))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&#10008</span>
        </button>
        @foreach($errors->all() as $error)
        <p>{{$error}} </p>
        @endforeach
    </div>
@endif



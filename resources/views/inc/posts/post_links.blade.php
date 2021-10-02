@if($posts->total() > $posts->count())
    <br>
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{ $posts->links() }}
        </div>
    </div>
@endif

@if($goals->total() > $goals->count())
    <br>
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{ $goals->links() }}
        </div>
    </div>
@endif

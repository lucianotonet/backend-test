@include('flash::message')

@if( session()->has('errors') )
    <div class="alert alert-danger alert-important" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Whoops, something went wrong!
    </div>
@endif

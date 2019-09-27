



@if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif

@if ( $errors->count() > 0 )
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    <ul>
        @foreach( $errors->all() as $msg )
        <li>{{ $msg }}</li>
        @endforeach
    </ul>
</div>
@endif




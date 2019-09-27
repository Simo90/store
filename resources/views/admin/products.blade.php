@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $header_title }}</div>

                <div class="card-body">
                    <div class="row">

                        @foreach( $products as $p )
                        <div class="col-sm-6 col-md-3" style="margin-bottom:30px;">
                            <div class="thumbnail" style="border:1px #D2D2D2 solid;">
                                <a href="{{ url( 'product/'.$p->id ) }}">
                                    <img src="{{ url( '/storage/'.$p->image ) }}" class="img-fluid">
                                </a>
                                <div class="caption" style="padding:10px;">
                                    <h3>
                                        <a href="{{ url( 'product/'.$p->id ) }}">
                                            {{ $p->title }}
                                        </a>
                                    </h3>
                                    <div>{{ $p->user->name }}</div>
                                    <div>Reviews number: {{ $p->reviews->count() }}</div>
                                    <p>
                                        <a href="{{ url( config('app.admincp').'/products/'.$p->id.'/edit' ) }}" class="btn btn-primary" role="button">Edit</a> 
                                        <a href="#" class="btn btn-danger js_delete" id="{{ $p->id }}" role="button">Delete</a> 

                                        <form method="POST" action="{{ url( config('app.admincp').'/products/'.$p->id ) }}" class="js_form_{{ $p->id }}">
                                            {{ csrf_field() }}
                                            @method('DELETE')
                                        </form>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection



@section('javascript')
<script>
$(".js_delete").click(function() {
    
    var id = $(this).attr('id');
    
    if ( confirm("Are you sure ?") ){
        $('.js_form_'+id).submit();
    }
})
</script>
@endsection
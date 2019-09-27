@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $header_title }}</div>

                <div class="card-body">

                    @include('admin.admin_msg')


                    <div>
                        <form method="POST" action="{{ url( config('app.admincp') . '/products' ) }}" accept-charset="UTF-8" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Title" name="title">
                            </div>
                            
                            <div class="form-group">
                                <label for="exampleInputFile">Image</label>
                                <input type="file" class="form-control" id="exampleInputFile" name="image">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Text</label>
                                <textarea class="form-control" id="exampleInputPassword1" name="description"></textarea>
                            </div>

                            <button type="submit" class="btn btn-default btn-success">Submit</button>

                            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

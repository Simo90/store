@extends('layouts.app')

@section('content')
<div class="container" id="myApp">

    <h1>@{{ header_title }}</h1>

    <div class="row justify-content-center" >
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="float-left">
                        @{{ header_title }}
                    </div>
                    <div class="float-right" style="height: 38px;">
                        @auth()
                        <p>

                            @canany(['update', 'delete'], $product)
                            <small>
                                You are the owner of the product,
                                you can:
                            </small>
                            @endcanany

                            @can('update',$product)
                            <a href="{{ url( config('app.admincp').'/products/'.$product->id.'/edit' ) }}"
                                class="btn btn-primary" role="button">Edit</a>
                            <a href="#" class="btn btn-danger js_delete" id="{{ $product->id }}"
                                role="button">Delete</a>
                            @endcan

                            @can('delete',$product)
                            <form method="POST"
                                action="{{ url( config('app.admincp').'/products/'.$product->id ) }}"
                                class="js_form_{{ $product->id }}">
                                {{ csrf_field() }}
                                @method('DELETE')
                            </form>
                            @endcan

                        </p>
                        @endauth
                    </div>
                </div>

                <div class="card-body">
                    <div><img src="{{ url( '/storage/'.$product->image ) }}" class="img-fluid" ></div>
                    <div style="margin-top:30px;">
                        @{{ description }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Reviews (@{{ reviews_total }}): <small style="color:#FF0000;">(Anyone can CRUD)</small></div>

                <div class="card-body">
                    
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" @click="edit=false,emptyForm()">Add New Review</button>
                    
                    <div>
                        <div v-for="review in reviews" :id="'r_' + review.id" style="border-bottom:1px #ccc solid;padding:10px;position:relative;margin-top:10px;">

                            <h2>@{{ review.name }}</h2>
                            <p>@{{ review.text }}</p>

                                <div style="position: absolute;bottom:10px;right:0;">
                                    <a href="#" @click="edit=true,editReview(review)">Edit</a> - 
                                    <a href="#" onclick="return false" @click="deleteReview(review)">Delete</a>
                                </div>

                        </div>
                    </fiv>

                </div>
            </div>
        </div>


        <div class="modal" tabindex="-1" role="dialog" id="exampleModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    
                    <form @submit.prevent="validateForm('formReview')" data-vv-scope="formReview">
                        <div class="modal-header">
                            <h5 class="modal-title">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
        
                        <div class="modal-body">
                            
                            <div :class="{ 'form-group':true, 'has-error':errors.has('formReview.name') }">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Name" name="name" v-model="review.name" v-validate="'required|min:5'">
        
                                <label class="control-label" v-show="errors.has('formReview.name')">@{{ errors.first('formReview.name') }}</label>
                                
                            </div>
                
                            <div :class="{ 'form-group':true, 'has-error':errors.has('formReview.text') }">
                                <label>Text</label>
                                <textarea class="form-control" name="text" v-model="review.text" v-validate="'required|min:5'"></textarea>
        
                                <label class="control-label" v-show="errors.has('formReview.text')">@{{ errors.first('formReview.text') }}</label>
        
                            </div>
                        </div>
        
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-primary" @click="updateReview" v-if="edit" type="submit">Save changes</button>
                            
                            <button type="button" class="btn btn-primary" @click="addReview" v-else="edit" type="submit">Add your review</button>
                            
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection


@section('javascript')
<script src="{{ asset('js/vue.js') }}"></script>
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/vee-validate.js') }}"></script>

<script>
    Vue.use(VeeValidate);
    window.Laravel = {!! json_encode([
        'csrfToken'     => csrf_token(),
        'url'           => url('/'),
        'product_id'    => $product->id,
        'header_title'  => $header_title,
        'description'   => $product->description
    ]) !!};
</script>

<script src="{{ asset('js/product.js') }}"></script>

<script>
    $(".js_delete").click(function () {

        var id = $(this).attr('id');

        if (confirm("Are you sure ?")) {
            $('.js_form_' + id).submit();
        }
    })

</script>


@endsection
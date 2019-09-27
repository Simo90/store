@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" id="myApp">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $header_title }}</div> 
                <div class="card-body">
                    <div v-infinite-scroll="loadMore" infinite-scroll-disabled="busy" >
                        <div class="row">
                            <div class="col-sm-6 col-md-3" v-for="post in posts" style="margin-bottom:30px;">
                                <div class="thumbnail" style="border:1px #D2D2D2 solid;">
                                    <a :href="'/product/' + post.id">
                                        <img :src="'/storage/' + post.image" class="img-fluid">
                                    </a>
                                    <div class="caption" style="padding:10px;">
                                        <h3>
                                            <a :href="'/product/' + post.id">
                                                @{{post.id}} - @{{post.title}}
                                            </a>
                                        </h3>
                                        <div>@{{post.user.name}}</div>
                                        <div>Reviews number: @{{post.reviews.length}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('js/vue.js') }}"></script>
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="https://unpkg.com/vue-infinite-scroll@2.0.2/vue-infinite-scroll.js"></script>
<script>
    window.Laravel = {!!json_encode([
        'csrfToken' => csrf_token(),
        'url' => url('/'),
    ]) !!};
</script>
<script src="{{ asset('js/home.js') }}"></script>
@endsection

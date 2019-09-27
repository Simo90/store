

var app = new Vue({

    el: "#myApp",
    data: {
        posts: [],
        busy: false,
        page: 0,
    },
    methods: {
        loadMore() {
            
            this.busy = true;
            axios.post( window.Laravel.url + '/api/products', {
                page: this.page
            })
            .then(response => {
                this.busy = false;

                if ( response.data.length == 0 ){
                    this.busy = true;
                }
                else{
                    this.posts = this.posts.concat( response.data );
                    this.page = this.page + 1;
                }
            });
        }
    },
    created() {
        this.loadMore();
    }
});
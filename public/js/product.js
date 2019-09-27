

var app = new Vue({

    el: '#myApp',
    data: {
        header_title : window.Laravel.header_title,
        description : window.Laravel.description,
        reviews: [],
        reviews_total : 0,
        review: {
            product_id : window.Laravel.product_id,
            id   : '',
            name : '',
            text : ''
        },
        edit: false,
    },
    methods: {
        getReviews: function () {
            axios.get( window.Laravel.url + '/product/'+window.Laravel.product_id+'/getReviews' )
            .then( response => {
                console.log( 'success : ', response );
                this.reviews = response.data;
                this.reviews_total = this.reviews.length;
            })
            .catch( error => {
                console.log( 'error : ', error );
            })
        },
        emptyForm: function ( ) {
            this.review = {
                product_id : window.Laravel.product_id,
                id      : 0,
                name    : '',
                text    : ''
            };
        },
        addReview: function () { 
            
            axios.post( window.Laravel.url + '/review', this.review )
            .then( response => {
                
                if ( response.data.etat ){
                    
                    this.review.id = response.data.id;
                    this.reviews.unshift(this.review); // add new info to top
                    // this.reviews.push(this.review);  // add new info to bottom
                    
                    this.reviews_total = this.reviews_total + 1;

                    this.emptyForm();
                }
            })
            .catch( error => {
                console.log( 'error : ', error );
            })
        },
        editReview: function ( review ) {

            $('#exampleModal').modal('show');

            this.edit  = true;
            this.review  = review;
        },
        updateReview: function () {

            axios.put( window.Laravel.url + '/review/' + this.review.id, this.review )
            .then( response => {
                console.log( 'success : ', response.data );
                if ( response.data.etat ){
                    
                    this.review = {
                        id   : '',
                        name   : '',
                        text    : ''
                    };
                    this.edit  = false;

                    $('#exampleModal').modal('hide');
                }
            })
            .catch( error => {
                console.log( 'error : ', error );
            })
        },
        deleteReview: function ( review ) {

            if ( confirm("Are you sure ?") ){

                axios.delete( window.Laravel.url + '/review/'+review.id )
                .then( response => {
                    console.log( 'success : ', response.data );
                    
                    if ( response.data.etat ){
                    
                        $('#r_'+review.id).css({ 'background':'#3490dc', 'color':'#fff' }).slideUp(600);
                        this.reviews_total = this.reviews_total - 1;

                        // var key = this.reviews.indexOf(review);
                        // this.reviews.splice( key, 1 );
                        
                    }
                })
                .catch( error => {
                    console.log( 'error : ', error );
                })
            }
        },
        validateForm(scope){
            this.$validator.validateAll(scope).then((result) => {

                if (result){
                    if ( this.edit  == true ){
                        this.updateReview();
                    }else{
                        this.addReview();
                    }
                }
            });
        }
    },
    mounted:function(){
        this.getReviews();
    }
});
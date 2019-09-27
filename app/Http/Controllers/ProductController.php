<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Product, App\User;
use Auth;
use Session;

class ProductController extends Controller
{

    public function homePage(){
        
        return view('home', [
            'header_title' => 'All Products',
        ]);
    }

    public function apiProducts( Request $request ){
        
        $page_num = (int)$request->page + 1;
        $productsNumber = config('app.products_number');

        $result = Product::with('user', 'reviews')->orderBy('id','DESC')->paginate( $productsNumber, ['*'], 'page', $page_num);

        $t = @json_decode(json_encode($result), true);

        return Response()->json( $t['data'] );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.products', [
            'header_title' => 'My Products',
            'products' => User::find( Auth::user()->id )->products()->latest()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product_add', [
            'header_title' => 'Add New Product'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( ProductRequest $request)
    {

        $array = [
            'title'     => $request->input('title'),
            'user_id'   => Auth::user()->id,
            'description' => $request->input('description')
        ];

        if ( $request->hasFile('image') ){

            $file = $request->file('image');
            $name = rand(100,999).'_'.time().'.'.$file->getClientOriginalExtension();
            $request->image->storeAs('public/image', $name );
            
            $array['image'] = 'image/' . $name;
        }

        Product::create( array_filter($array) );
        
        Session::flash('message', 'Success message!'); 
        Session::flash('alert-class', 'alert-success'); 

        return redirect( $_SERVER['HTTP_REFERER'] );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {

        $product = Product::find($id);

        return view('product', [
            'header_title' => 'Edit Product: ' . $product->title,
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        
        // "update", method in ProductPolicy
        // check if auth can update this product
        $this->authorize('update',$product);
        
        return view('admin.product_edit', [
            'header_title' => 'Edit Product: ' . $product->title,
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {

        // "update", method in ProductPolicy
        // check if auth can update this product
        $this->authorize('update',$product);

        $array = [
            'title'     => $request->input('title'),
            'description' => $request->input('description')
        ];

        if ( $request->hasFile('image') ){

            // Delete old image from the server
            if ( $product->image!='' && file_exists( public_path() . '/storage/' . $product->image ) ){
                
                unlink(public_path() . '/storage/' . $product->image);
            }

            // store the new image
            $file = $request->file('image');
            $name = rand(100,999).'_'.time().'.'.$file->getClientOriginalExtension();
            $request->image->storeAs( 'public/image', $name );
            
            $array['image'] = 'image/' . $name;
        }

        $product->update( array_filter($array) );

        Session::flash('message', 'تم التعديل بنجاح'); 
        Session::flash('alert-class', 'alert-success'); 
        
        return redirect( $_SERVER['HTTP_REFERER'] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {

        // "delete", method in ProductPolicy
        // check if auth can delete this product
        $this->authorize('delete',$product);

        if ( $product->image!='' && file_exists( public_path() . '/storage/' . $product->image ) ){
                
            unlink(public_path() . '/storage/' . $product->image);
        }

        $product->reviews()->delete();
        $product->delete();

        return redirect( url( config('app.admincp').'/products') );
    }



    public function getReviews( $id )
    {
        return Product::find($id)->reviews()->latest()->get();
    }
}





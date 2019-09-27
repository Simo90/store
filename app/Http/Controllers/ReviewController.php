<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    public function store(Request $request)
    {
        $review = Review::create([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'text' => $request->text,
        ]);
        
        return Response()->json( [ 'etat'=>true, 'id'=>$review->id ] );
    }

    public function update(Request $request, Review $review)
    {
        $review->update([
            'name' => $request->name,
            'text' => $request->text,
        ]);

        return Response()->json( [ 'etat'=>true ] );
    }

    public function destroy(Review $review)
    {
        
        $review->delete();
        
        return Response()->json( [ 'etat'=>true ] );
    }
}

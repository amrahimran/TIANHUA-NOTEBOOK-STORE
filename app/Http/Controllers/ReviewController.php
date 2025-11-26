<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Add a new review
    // public function store(Request $request, $productId)
    // {
    //     $request->validate([
    //         'comment' => 'required|string|max:500',
    //         'rating'  => 'required|integer|min:1|max:5',
    //     ]);

    //     Review::create([
    //         'user_id'    => Auth::id(),
    //         'product_id' => $productId,
    //         'comment'    => $request->comment,
    //         'rating'     => $request->rating,
    //     ]);

    //     return redirect()->back()->with('success', 'Review added!');
    // }

//     public function store(Request $request, $productId)
// {
//     $request->validate([
//         'comment' => 'required|string|max:500',
//         'rating'  => 'required|integer|min:1|max:5',
//     ]);

//     // Check if product exists
//     $product = Products::where('id', $productId)->first();
//     if (!$product) {
//         return response()->json(['message' => 'Product not found'], 404);
//     }

//     $review = Review::create([
//         'user_id'    => Auth::id(),
//         'product_id' => $productId,
//         'comment'    => $request->comment,
//         'rating'     => $request->rating,
//     ]);

//     return response()->json([
//         'success' => true,
//         'message' => 'Review added successfully',
//         'data' => $review
//     ]);
// }

public function store(Request $request, $productId)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
            'rating'  => 'required|integer|min:1|max:5',
        ]);

        // Check if product exists
        $product = Products::where('id', $productId)->first();
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Ensure comment is stored as plain string (prevents injection)
        $safeComment = (string) $request->comment;

        // Optional: escape leading $ to prevent MongoDB operators
        $safeComment = preg_replace('/^\$/', '&#36;', $safeComment);

        $review = Review::create([
            'user_id'    => Auth::id(),
            'product_id' => $productId,
            'comment'    => $safeComment,
            'rating'     => $request->rating,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review added successfully',
            'data' => $review
        ]);
    }

    // Delete a review
    public function destroy($id)
    {
        $review = Review::find($id);

        // Review not found
        if (!$review) {
            return response()->json(['error' => 'Review not found'], 404);
        }

        // Prevent deleting other's reviews
        if ($review->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Delete review
        $review->delete();

        return response()->json(['success' => true, 'message' => 'Review deleted']);
    }

}

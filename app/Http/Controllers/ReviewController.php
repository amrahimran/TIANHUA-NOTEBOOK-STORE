<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
            'rating'  => 'required|integer|min:1|max:5',
        ]);

        // Check if product exists
        $product = Products::where('id', $productId)->first();
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }

        // Ensure comment is stored as plain string (prevents injection)
        $safeComment = preg_replace('/^\$/', '&#36;', (string) $request->comment);

        // Save review to MongoDB
        Review::create([
            'user_id'    => Auth::id(),
            'product_id' => $productId,
            'comment'    => $safeComment,
            'rating'     => $request->rating,
        ]);

        // Redirect back to the product page with a success message
        return redirect()->back()->with('success', 'Review added successfully');
    }


    // Delete a review
    public function destroy($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return redirect()->back()->with('error', 'Review not found');
        }

        if ($review->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully');
    }


}

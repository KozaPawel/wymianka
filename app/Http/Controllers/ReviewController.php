<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $messages = [
            'rating' => 'Należy wybrać jedną z ocen',
        ];
        
        Review::create($request->validate([
            'trade_id' => 'required|int',
            'rating' => 'required|int|min:1|max:5',
            'summary' => 'nullable|string',
            'by_user_id' => 'required|int',
            'user_id' => 'required|int',
        ], $messages));

        return redirect()->back()
            ->with('success', 'Wystawiono ocenę');
    }

    public function destroy(Review $review)
    {
        $review->deleteOrFail();

        return redirect()->back()
            ->with('success', 'Usunięto opinie');
    }
}

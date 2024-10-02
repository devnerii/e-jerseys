<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {

        $request->validate([
            'stars' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $productId,
            'stars' => $request->stars,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Avaliação adicionada com sucesso!');
    }
}

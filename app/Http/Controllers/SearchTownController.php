<?php

namespace App\Http\Controllers;

use App\Models\Town;
use Illuminate\Http\Request;

class SearchTownController extends Controller
{
    public function __invoke(Request $request)
    {
        $filters = $request->only([
            'towns',
        ]);

        $towns = Town::orderBy('search')
            ->filter($filters)
            ->paginate(20)
            ->take(20);

        return response()->json($towns);
    }
}

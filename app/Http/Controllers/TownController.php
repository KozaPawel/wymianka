<?php

namespace App\Http\Controllers;

use App\Models\Town;
use Illuminate\Http\Request;

class TownController extends Controller
{
    public function __invoke(Request $request)
    {
        $filters = $request->only([
            'towns',
        ]);

        $towns = Town::mostRecent()
            ->filter($filters)
            ->paginate(10)
            ->take(10);

        return response()->json($towns);
    }
}

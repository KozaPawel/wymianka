<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        Category::create($request->validate([
            'name' => 'required|string',
        ]));

        return redirect()->back()
            ->with('success', 'Dodano nową kategorię');
    }

    public function destroy(Category $category)
    {
        $category->deleteOrFail();

        return redirect()->back()
            ->with('success', 'Usunięto kategorię');
    }
}

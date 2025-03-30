<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Category $category)
    {
        return view('categories.index')->with(['categories' => $category->get()]);
    }

    public function create(Category $category)
    {
        return view('categories.create')->with(['categories' => $category->get()]);
    }

    public function store(Request $request)
    {
        $valadated = $request->validate([
            'title' =>'required|string|max:255',
        ]);

        Category::create([
            'title' => $validated['title']
        ]);

        return redirect()->route('categories.index')->with('success','保存されました!');
    }

    public function show(Category $category)
    {
       $category->load('decks');
       return view('categories.show', compact('category'));
    }
}
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

    public function show(Category $category)
    {
       $category->load('decks');
       return view('categories.show', compact('category'));
    }
}
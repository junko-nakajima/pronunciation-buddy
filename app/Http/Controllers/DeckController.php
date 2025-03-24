<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use Illuminate\Http\Request;
use App\Models\Category;

class DeckController extends Controller
{
    public function index(Deck $deck)
    {
        return view('decks.index')->with(['decks' =>$deck->get()]);
    }

    public function show(Deck $deck)
    {
        return view('decks.show')->with(['deck' => $deck]);
    }
    public function create(Category $category)
    {
        return view('decks.create')->with(['categories' => $category->get()]);
    }

    public function store(Request $request, Deck $post)
    {
        $input = $request['deck'];
        $deck->fill($input)->save();
        return redirect('/decks/' . $deck->id);
    }

    public function edit(Deck $deck)
    {
    return view('decks.edit')->with(['deck' => $deck]);
    }

    public function update(DeckRequest $request, Deck $deck)
    {
    $input_deck = $request['deck'];
    $deck->fill($input_deck)->save();

    return redirect('/decks/' . $deck->id);
    }

    public function delete(Deck $deck)
    {
        $deck->delete();
        return redirect('/');
    } 
    //
}

<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class DeckController extends Controller
{
    public function index(Deck $deck)
    {
        $decks = Deck::with('category')->get();
        $groupedDecks = $decks->groupBy(function($deck) {
            return $deck->category ? $deck->category->name : 'Uncategorized';
        });
        return view('decks.index')->with(['groupedDecks' =>$groupedDecks]);
    }

    public function show(Deck $deck)
    {
        $words = $deck->words;
        return view('words.index', [
            'deck' => $deck,
            'words' => $words,
        ]);
    }
    public function create(Category $category)
    {
        return view('decks.create')->with(['categories' => $category->get()]);
    }

    public function store(Request $request, Deck $deck)
    {
        $input = $request['deck'];
        $input['user_id'] = Auth::id();
        $deck->fill($input)->save();
        return redirect('/decks/' . $deck->id)->with('success','保存されました!');
    }

    public function edit(Deck $deck)
    {
    return view('decks.edit')->with(['deck' => $deck]);
    }

    public function update(Request $request, Deck $deck)
    {
        $input_deck = $request['deck'];
        $deck->fill($input_deck)->save();

    return redirect('/words/' . $deck->id);
    }

    public function delete(Deck $deck)
    {
         $deck->delete();

        return redirect('/decks/' . $deck->category_id)->with('success','アイテムが削除されました!');
    } 
    //
}

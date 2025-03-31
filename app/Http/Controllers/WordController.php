<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;
use App\Models\Deck;
use Illuminate\Support\Facades\Auth;

class WordController extends Controller
{
    public function index()
    {
        $words = Word::with('deck')->get();
        return view('words.index')->with(['words' => $words]);
    }
    
    public function create(Deck $deck)
    {
        return view('words.create')->with(['deck' => $deck]);
    }

    public function store(Request $request, Word $word)
    {
        // 単語をスペースで分割
        $input = $request['word'];
        $deckId       = $input['deck_id'];
        $wordsString  = $input['word'];     
        $meaningsString = $input['meaning'];
        $userId = Auth::id();
        $wordsArray = explode(' ', $wordsString);
        $meaningsArray = explode(' ', $meaningsString);
        $count = count($wordsArray);
        for($i = 0; $i < $count; $i++){
            $data = [
                'deck_id' => $deckId,
                 'user_id' => $userId,
                 'word' => $wordsArray[$i],
                 'meaning' => $meaningsArray[$i],
                ];
            $word = new \App\Models\Word();
            $word->fill($data)->save();
        }
             
        return redirect('decks/' . $deckId)->with('success','単語カードが作成されました!');
    }
    
    public function delete(Word $word)
    {
        $deck = $word->deck;
        $words = $deck->words;
        $word->delete();
        return view('words.index', [
            'deck' => $deck,
            'words' => $words,
        ]);
    }

    public function edit(Word $word)
    {
    return view('words.edit')->with(['word' => $word]);
    }

    public function show(Word $word)
    {
        return view('words.show')->with(['word' => $word]);
    }

    public function update(Request $request, Word $word)
    {
        $input_word = $request['word'];
        $deck = $word->deck;
        $word->fill($input_word)->save();
        $words = $deck->words;
        return view('words.index', [
            'deck' => $deck,
            'words' => $words,
        ]);
    }
    //
}

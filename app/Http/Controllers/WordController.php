<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    public function index(Word $word)
    {
        return view('words.index')->with(['words' => $word->get()]);
    }
    
    public function create()
    {
        return view('words.create');
    }
    
    public function delete(Word $word)
    {
        $word->delete();
        return redirect('/');
    }

    public function show(Word $word)
    {
        return view('words.show')->with(['word' => $word]);
    }

    public function update(WordRequest $request, Word $word)
    {
        $input_word = $request['word'];
        $word->fill($input_word)->save();

        return redirect('/words/' . $word->id);
    }
    //
}

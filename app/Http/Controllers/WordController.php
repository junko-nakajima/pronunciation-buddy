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
    public function delete(Word $word)
    {
        $word->delete();
        return redirect('/');
    }
    //
}

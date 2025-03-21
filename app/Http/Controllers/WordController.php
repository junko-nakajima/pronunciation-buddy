<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    public function lists(Word $word)
    {
        return view('words.lists')->with(['words' => $word->get()]);
    }
    //
}

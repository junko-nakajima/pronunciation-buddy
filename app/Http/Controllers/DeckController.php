<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use Illuminate\Http\Request;

class DeckController extends Controller
{
    public function index(Deck $deck)
    {
        return $deck->get();
    }

    //
}

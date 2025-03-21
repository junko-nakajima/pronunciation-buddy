<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use Illuminate\Http\Request;

class AttemptController extends Controller
{
    public function index(Attempt $attempt)
    {
        return view('attempt.index')->with(['attempts' => $attempt->get()]);
    }
    //
}

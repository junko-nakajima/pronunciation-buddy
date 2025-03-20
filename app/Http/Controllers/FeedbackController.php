<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(Feedback $feedback)
    {
        return $feedback->get();
    }
    //
}

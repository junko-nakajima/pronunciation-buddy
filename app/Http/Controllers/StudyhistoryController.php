<?php

namespace App\Http\Controllers;

use App\Models\Studyhistory;
use Illuminate\Http\Request;

class StudyhistoryController extends Controller
{
    public function index(Studyhistory $studyhistory)
    {
        return $studyhistory->get();
    }
    //
}

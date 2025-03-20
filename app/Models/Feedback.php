<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    public function attempt()
    {
        return $this->belongsTo(Attempt::class);
    }

    public function studyhistory()
    {
        return $this->belongsTo(Studyhistory::class);
    }
    
}

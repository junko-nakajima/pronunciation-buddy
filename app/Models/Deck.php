<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    use HasFactory;

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function words()
    {
        return $this->hasMany(Word::class);
    }

    public function studyhistories()
    {
        return $this->hasMany(Studyhistory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

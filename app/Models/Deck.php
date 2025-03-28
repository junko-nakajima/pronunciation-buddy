<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deck extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id','title'];

    public function category()
    {
        return $this->belongsTo(Category::class);
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

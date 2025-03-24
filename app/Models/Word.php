<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Word extends Model
{
    use HasFactory;

    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }

    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }

    use SoftDeletes;

}

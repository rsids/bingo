<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }
    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}

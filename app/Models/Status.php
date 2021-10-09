<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kblais\Uuid\Uuid;

class Status extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'status'
    ];

    public function mangas(){
        return $this->hasMany(Manga::class);
    }
}

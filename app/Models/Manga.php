<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kblais\Uuid\Uuid;

class Manga extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'titre',
        'rating',
        'comment'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function status(){
        return $this->hasOne(Status::class, 'status_id');
    }
}

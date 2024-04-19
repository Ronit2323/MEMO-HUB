<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'note_id',
        'comment_body',

    ];
    public function note()
    {
        return $this->belongsTo(Note::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

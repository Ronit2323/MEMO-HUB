<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class faculty extends Model
{
    use HasFactory;
    protected $fillable = [
        'faculty_name'

    ];
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'faculty_subject');
    }
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}

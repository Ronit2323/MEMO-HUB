<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_name'
    ];
    public function faculties()
    {
        return $this->belongsToMany(Faculty::class, 'faculty_subject');
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}

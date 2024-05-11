<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\DatabaseNotification;
use App\Models\Note;
use Illuminate\Database\Eloquent\Relations\HasMany;





class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'userType',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function moderator()
    {
        return $this->hasOne(Moderator::class, 'user_id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function notifications()
    {
        return $this->hasMany(DatabaseNotification::class);
    }
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
    public function favoriteNotes()
    {
        return $this->hasMany(Favorite::class, 'user_id');
    }
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function hasActiveSubscription()
    {
        return $this->payments()->exists();
    }
}

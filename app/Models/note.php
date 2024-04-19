<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewReviewNotification;

class note extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'user_id',
        'subject_id',
        'faculty_id',
        'category_id',
        'file',
        'summary',
        'tags',
        'status',
        'moderator_id',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
    public function moderators()
    {
        return $this->belongsToMany(Moderator::class)->withPivot('review');
    }
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
    public function likesDislikes()
    {
        return $this->hasMany(LikesDislikes::class);
    }
    public function likesCount()
    {
        return $this->likesDislikes()->where('liked', true)->count();
    }
    // app/Models/note.php

    public function refreshLikesDislikesCount()
    {
        $this->loadCount('likesDislikes');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    // public function dislikesCount()
    // {
    //     return $this->likesDislikes()->where('liked', false)->count();
    // }
    public function isLikedByUser(User $user)
    {
        return $this->likesDislikes()->where('user_id', $user->id)->where('liked', true)->exists();
    }

    public function notifyUserAboutReview()
    {
        // Ensure the 'user' relationship is loaded before trying to access it
        $this->load('user');

        // Check if 'user' relationship is loaded and $this->user is not null before notifying
        if ($this->relationLoaded('user') && $this->user) {
            Notification::send($this->user, new NewReviewNotification($this->id));
        }
    }
    public function getPreviewImageUrl()
    {
        // Assuming 'file' contains the PDF file name
        $pdfFileName = $this->file;
        $previewFileName = pathinfo($pdfFileName, PATHINFO_FILENAME) . '_preview.jpg';

        // Return the URL for the preview image
        return asset('storage/note/previews/' . $previewFileName);
    }
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    public function favoritedByUser(User $user)
    {
        return $this->favorites()->where('user_id', $user->id)->exists();
    }
    public function notificationStatuses()
    {
        return $this->hasMany(NotificationStatus::class, 'note_id');
    }
}

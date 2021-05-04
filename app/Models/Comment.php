<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasOne(CommentAnswer::class)
            ->join('users', 'users.id', '=', 'comment_answers.user_id')
            ->select('comment_answers.description', 'comment_answers.id',  'users.image as image_user', 'users.name');
    }
}

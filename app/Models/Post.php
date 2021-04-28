<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'user_id', 'category_id', 'description', 'date', 'hour', 'featured', 'status', 'url', 'image'
    ];

    public function rules($id = '')
    {
        return [
            'title' => "required|min:3|max:250, unique:posts, title, {$id}, id",
            'url' => "required|min:3|max:100, unique:posts, url, {$id}, id",
            'category_id' => 'required',
            'description' => 'required|min:50|max:6000',
            'date' => 'required|date',
            'hour' => 'required',
            'status' => 'required|in:A,R',
            'image' => 'image',
        ];
    }
}

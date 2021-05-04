<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url', 'description', 'image'];


    public function rules($id = '')
    {
        return [
            'name' => 'required|min:3|max:100',
            'url' => "required|min:3|max:100|unique:categories,url,{$id},id",
            'description' => 'required|min:3|max:300',
            'image' => 'image'

        ];
    }

    public function categories()
    {
        return $this->hasMany(Post::class);
    }


}

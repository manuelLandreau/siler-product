<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'post_count'];

    public $timestamps = false;

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'slug',
        'content',
        'description',
        'details',
        'amazon_url',
        'small_image_url',
        'medium_image_url',
        'large_image_url',
        'image_set',
        'image_set_large',
        'price',
        'created',
    ];

    protected $with = ['user', 'category'];

    const CREATED_AT = 'created';

    public $timestamps = false;

    protected $dates = [self::CREATED_AT];

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        self::creating(function (Post $post) {
            $post->{self::CREATED_AT} = new Carbon();
            $post->category()->increment('post_count');
        });

        self::deleting(function (Post $post) {
            $post->category()->decrement('post_count');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

<?php

use App\Models\Post;
use Siler\Container;
use Siler\Http\Response;
use Siler\Twig;
use function Siler\Http\redirect;
use function Siler\Http\setsession;

$db = Container\get('db');
$slug = array_get($params, 'slug');

// Fetching post
$post = Post::where('slug', $slug)->first();

if ($post === null) {
    Response\html(Twig\render('errors/error404.twig'));
    die();
} else {
    $small = explode('\n', $post->image_set);
    $large = explode('\n', $post->image_set_large);
    $post->image_set_array = array_splice($small, 1, sizeof($small));
    $post->image_set_large_array = array_splice($large, 1, sizeof($large));
}

// Return response
Response\html(Twig\render('post.twig', compact('post')));

die();

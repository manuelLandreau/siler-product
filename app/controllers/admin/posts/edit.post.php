<?php

use App\Models\Post;
use Illuminate\Support\Str;
use Kocal\Validator\Validator;
use Siler\Container;
use function Siler\Http\redirect;
use function Siler\Http\Request\header;
use function Siler\Http\setsession;

$postId = array_get($params, 'id');
$post = Post::find($postId);

if ($post === null) {
    setsession('errorAlert', 'Post does not exist.');
    redirect('/admin');
    die();
}

$validator = new Validator([
    '_csrf' => 'required|in:' . Container\get('csrf-token'),
    'data' => 'required|array',
    'data.Post' => 'required|array',
    'data.Post.name' => 'required|string',
    'data.Post.slug' => 'required|string',
    'data.Post.user_id' => 'required|integer|min:1',
    'data.Post.category_id' => 'required|integer|min:1',
    'data.Post.content' => 'required|string',
], 'en');

$validator->validate($_POST);

if ($validator->fails()) {
    setsession('requestData', $_POST);
    setsession('validationErrors', $validator->errors());
    redirect(header('Referer', '/admin'));
} else {
    $slug = array_get($_POST, 'data.Post.slug');

    if (empty($slug)) {
        $slug = Str::slug($_POST['data']['Post']['name']);
    }

    $post->fill([
        'name' => $_POST['data']['Post']['name'],
        'slug' => $slug,
        'user_id' => $_POST['data']['Post']['user_id'],
        'category_id' => $_POST['data']['Post']['category_id'],
        'content' => $_POST['data']['Post']['content'],
    ]);
    $post->save();
    setsession('requestData', null);
    setsession('successAlert', "Post {$post->id} has been successfully updated.");
    redirect('/admin');
}

die();

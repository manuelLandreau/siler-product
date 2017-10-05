<?php

use App\Models\Post;
use App\Services\AWSService;
use Illuminate\Support\Str;
use Kocal\Validator\Validator;
use Siler\Container;
use function Siler\Http\redirect;
use function Siler\Http\Request\header;
use function Siler\Http\setsession;

$validator = new Validator([
    '_csrf' => 'required|in:' . Container\get('csrf-token'),
    'data' => 'required|array',
    'data.Post' => 'required|array',
    'data.Post.asin' => 'required|string',
    'data.Post.slug' => 'nullable|string',
    'data.Post.amazon_url' => 'nullable|string',
    'data.Post.user_id' => 'required|integer|min:1',
    'data.Post.category_id' => 'required|integer|min:1',
], 'en');

$validator->validate($_POST);

if ($validator->fails()) {
    setsession('requestData', $_POST);
    setsession('validationErrors', $validator->errors());
    redirect(header('Referer', '/admin'));
} else {
    $AWSArticle = AWSService::getProductInfo($_POST['data']['Post']['asin']);

    $slug = array_get($_POST, 'data.Post.slug');

    if (empty($slug)) {
        $slug = Str::slug($AWSArticle['title']);
    }

    $post = Post::create([
        'user_id' => $_POST['data']['Post']['user_id'],
        'category_id' => $_POST['data']['Post']['category_id'],
        'asin' => $_POST['data']['Post']['asin'],
        'amazon_url' => $_POST['data']['Post']['amazon_url'],
        'slug' => $slug,
        'name' => $AWSArticle['title'],
        'content' => $AWSArticle['content'],
        'description' => $AWSArticle['description'],
        'details' => $AWSArticle['details'],
        'price' => $AWSArticle['price'],
        'small_image_url' => $AWSArticle['small_image'],
        'medium_image_url' => $AWSArticle['medium_image'],
        'large_image_url' => $AWSArticle['large_image'],
        'image_set' => $AWSArticle['image_set'],
        'image_set_large' => $AWSArticle['image_set_large'],
    ]);
    setsession('requestData', null);
    require_once __DIR__ . '/../../../services/sitemapGenerator.php';

    setsession('successAlert', "Post {$post->id} has been successfully created.");
    redirect('/admin');
}

die();

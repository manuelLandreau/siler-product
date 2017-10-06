<?php

use App\Models\Category;
use Kilte\Pagination\Pagination;
use Siler\Http\Response;
use Siler\Twig;
use function Siler\Http\redirect;
use function Siler\Http\setsession;

$slug = array_get($params, 'slug');

// Fetching category
$category = Category::where('slug', $slug)->first();

if ($category === null) {
    setsession('errorAlert', 'This category does not exists.');
    redirect('/');

    return;
}

// Fetching its posts
$posts = $category->posts()->paginate(5);

// Creating pagination
$pagination = new Pagination($posts->total(), $posts->currentPage(), $posts->perPage());

// Return response
Response\html(
    Twig\render('category.twig', compact('category', 'posts', 'pagination'))
);

die();

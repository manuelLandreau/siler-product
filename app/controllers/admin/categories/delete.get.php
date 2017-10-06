<?php

use App\Models\Category;
use Siler\Container;
use Siler\Http;
use function Siler\Http\Request\get;
use function Siler\Http\Request\header;

$referer = header('Referer', '/admin/categories');

if (get('_csrf') === Container\get('csrf-token')) {
    $categoryId = array_get($params, 'id');
    $category = Category::find($categoryId);

    if($category && $category->delete()) {
        Http\setsession('successAlert', 'The category has been successfully deleted.');
    } else {
        Http\setsession('errorAlert', 'Something happens during category deletion.');
    }
}

Http\redirect($referer);

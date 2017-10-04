<?php

use App\Models\Category;
use Illuminate\Support\Str;
use Kocal\Validator\Validator;
use Siler\Container;
use function Siler\Http\redirect;
use function Siler\Http\Request\header;
use function Siler\Http\setsession;

$categoryId = array_get($params, 'id');
$category = Category::find($categoryId);

if ($category === null) {
    setsession('errorAlert', 'Category does not exist.');
    redirect('/admin/categories');
    die();
}

$validator = new Validator([
    '_csrf' => 'required|in:' . Container\get('csrf-token'),
    'data' => 'required|array',
    'data.Category' => 'required|array',
    'data.Category.name' => 'required|string',
    'data.Category.slug' => 'required|string',
], 'en');

$validator->validate($_POST);

if ($validator->fails()) {
    setsession('requestData', $_POST);
    setsession('validationErrors', $validator->errors());
    redirect(header('Referer', '/admin/categories'));
} else {
    $slug = array_get($_POST, 'data.Category.slug');

    if (empty($slug)) {
        $slug = Str::slug($_POST['data']['Category']['name']);
    }

    $category->fill([
        'name' => $_POST['data']['Category']['name'],
        'slug' => $slug,
    ]);
    $category->save();
    setsession('requestData', null);
    setsession('successAlert', "Category {$category->id} has been successfully updated.");
    redirect('/admin/categories');
}

die();

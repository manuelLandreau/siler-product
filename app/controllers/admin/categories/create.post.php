<?php

use App\Models\Category;
use Illuminate\Support\Str;
use Kocal\Validator\Validator;
use Siler\Container;
use function Siler\Http\redirect;
use function Siler\Http\Request\header;
use function Siler\Http\setsession;

$validator = new Validator([
    '_csrf' => 'required|in:' . Container\get('csrf-token'),
    'data' => 'required|array',
    'data.Category' => 'required|array',
    'data.Category.name' => 'required|string',
    'data.Category.slug' => 'nullable|string',
], 'en');

$validator->validate($_POST);

if ($validator->fails()) {
    setsession('requestData', $_POST);
    setsession('validationErrors', $validator->errors());
    redirect(header('Referer', '/admin'));
} else {
    $slug = array_get($_POST, 'data.Category.slug');

    if (empty($slug)) {
        $slug = Str::slug($_POST['data']['Category']['name']);
    }

    $category = Category::create([
        'name' => $_POST['data']['Category']['name'],
        'slug' => $slug
    ]);
    setsession('requestData', null);
    setsession('successAlert', "Category {$category->name} has been successfully created.");
    redirect('/admin');
}

die();

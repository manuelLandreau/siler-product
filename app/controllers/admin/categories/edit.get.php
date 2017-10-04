<?php

use App\Models\Category;
use App\Models\User;
use Siler\Http\Response;
use Siler\Twig;
use function Siler\Http\redirect;
use function Siler\Http\setsession;

$categoryId = array_get($params, 'id');
$category = Category::find($categoryId);

if ($category === null) {
    setsession('errorAlert', 'Category does not exist.');
    redirect('/admin');
    die();
}

setsession('requestData', $_POST);

Response\html(
    Twig\render('admin/categories/edit.twig', compact('category'))
);


die();

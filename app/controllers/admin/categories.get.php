<?php
require_once __DIR__ . '/guard.php';

use App\Models\Category;
use Kilte\Pagination\Pagination;
use Siler\Http\Response;
use Siler\Twig;

$categories = Category::orderBy('created', 'DESC')->paginate(20);
$pagination = new Pagination($categories->total(), $categories->currentPage(), $categories->perPage());

Response\html(
    Twig\render('admin/categories.twig', compact('categories', 'pagination'))
);

die();

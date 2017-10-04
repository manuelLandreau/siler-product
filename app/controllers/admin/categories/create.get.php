<?php

use Siler\Http\Response;
use Siler\Twig;

Response\html(
    Twig\render('admin/categories/create.twig')
);

die();

<?php

use samdark\sitemap\Sitemap;
use samdark\sitemap\Index;

// create sitemap
$sitemap = new Sitemap(__DIR__ . '/sitemap.xml');

// add some URLs
foreach (\App\Models\Post::all() as $post) {
    $sitemap->addItem('http://example.com/' . $post->slug, time());
}
foreach (\App\Models\Category::all() as $category) {
    $sitemap->addItem('http://example.com/' . $category->slug, time());
}
//$sitemap->addItem('http://example.com/mylink2', time());
//$sitemap->addItem('http://example.com/mylink3', time(), Sitemap::HOURLY);
//$sitemap->addItem('http://example.com/mylink4', time(), Sitemap::DAILY, 0.3);

// write it
$sitemap->write();

// get URLs of sitemaps written
$sitemapFileUrls = $sitemap->getSitemapUrls('http://example.com/');

// create sitemap for static files
$staticSitemap = new Sitemap(__DIR__ . '/../../public/sitemap_static.xml');

// write it
$staticSitemap->write();

// get URLs of sitemaps written
$staticSitemapUrls = $staticSitemap->getSitemapUrls('http://example.com/');

// create sitemap index file
$index = new Index(__DIR__ . '/sitemap_index.xml');

// write it
$index->write();
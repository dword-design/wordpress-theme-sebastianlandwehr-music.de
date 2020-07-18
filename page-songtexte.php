<?php

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$context['songtexte'] = Timber::get_posts([
    'post_type' => 'songtext',
    'orderby' => 'title',
    'order' => 'ASC',
    'posts_per_page' => -1
]);
Timber::render(['page-songtexte.html.twig'], $context);
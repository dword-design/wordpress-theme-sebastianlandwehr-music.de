<?php

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
Timber::render(array('page-' . $post->post_name . '.html.twig', 'page.html.twig'), $context);
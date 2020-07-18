<?php

$cds = [
    ['type' => 'solo', 'label' => 'Solo'],
    ['type' => 'band', 'label' => 'Mit Bands'],
    ['type' => 'gast', 'label' => 'Als Gastmusiker']
];

$cds = array_map(function ($entry) {
    $entry['cds'] = Timber::get_posts(['post_type' => 'cd', 'meta_key' => 'type', 'meta_value' => $entry['type'], 'posts_per_page' => -1]);
    return $entry;
}, $cds);

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$context['cds'] = $cds;
Timber::render(['page-musik.html.twig'], $context);
<?php

$page = get_query_var('page');
if (empty($page)) {
    $page = 1;
}

global $paged;
if (!isset($paged) || !$paged){
    $paged = $page;
}

$context = Timber::get_context();
$context['teaserPost'] = new TimberPost(get_page_by_path('teaser')->ID);
$context['homePost'] = new TimberPost(get_page_by_path('home')->ID);

//query_posts(['posts_per_page' => 5, 'paged' => $paged]);
//$context['news'] = Timber::get_posts();
//$context['pagination'] = Timber::get_pagination();

Timber::render(['front-page.html.twig'], $context);

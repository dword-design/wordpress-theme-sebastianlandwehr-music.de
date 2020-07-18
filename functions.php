<?php

use Dzango\Twig\Extension\Truncate;
use Urodoz\Truncate\Bridge\Twig\TruncateExtension;
use Urodoz\Truncate\TruncateService;
use Symfony\Component\Yaml\Yaml;

global $socialMedia;

$socialMedia = [
    'facebook' => 'Facebook',
    'twitter' => 'Twitter',
    'youtube' => 'Youtube',
    'soundcloud' => 'SoundCloud',
    'spotify' => 'Spotify',
    'amazon' => 'Amazon',
    'google-play' => 'Google Play',
    'itunes' => 'iTunes'
];

function register_menu() {
    register_nav_menu('menu',__('Menu'));
}
add_action('init', 'register_menu');
add_theme_support('post-thumbnails');

add_image_size('fullscreen', 1920, 99999);

function theme_scripts() {
    wp_enqueue_script('index.js', get_template_directory_uri() . '/dist/index.js', true);
    wp_localize_script('index.js', 'variables', array('ajaxUrl' => admin_url('admin-ajax.php')));
}

add_action('wp_enqueue_scripts', 'theme_scripts');

add_action('admin_init', 'theme_settings_init');

function theme_settings_init() {

    global $socialMedia;

    add_settings_section(
        'social_media_section',
        'Social Media',
        function() {},
        'general'
    );

    foreach ($socialMedia as $name => $label) {
        add_settings_field(
            'social_media_'.$name,
            $label,
            function () use ($name) {
                echo '<input type="text" size="60" name="social_media_'.$name.'" value="'.get_option('social_media_'.$name).'">';
            },
            'general',
            'social_media_section'
        );
        register_setting('general', 'social_media_'.$name);
    }
}

add_filter('body_class','theme_body_classes');
function theme_body_classes($classes) {

    $classes[] = 'no-js';
    if (is_front_page()) {
        $classes[] = 'menu-bar--slim';
    }

    return $classes;
}

add_filter('timber/context', 'theme_add_to_context');
function theme_add_to_context($data){

    global $socialMedia;
    $twigSocialMedia = [];
    foreach ($socialMedia as $name => $label) {
        $twigSocialMedia[] = [
            'name' => $name,
            'label' => $label,
            'url' => get_option('social_media_'.$name)
        ];
    }

    $data['menu'] = new TimberMenu();
    $data['socialMedia'] = $twigSocialMedia;
    $data['teaserUrl'] = esc_url(home_url('/'));
    $data['homeUrl'] = get_permalink(get_page_by_path('home'));
    $data['impressumUrl'] = get_permalink(get_page_by_path('impressum'));
    $data['datenschutzUrl'] = get_permalink(get_page_by_path('datenschutz'));

    return $data;
}

add_filter('facebook_text', 'wpautop');
add_filter('facebook_text', 'detectHashtags');
add_filter('facebook_text', 'detectPageLinks');
add_filter('facebook_text', 'make_clickable');
add_filter('facebook_text', 'openLinksInNewTab');

function detectHashTags($string) {
    return preg_replace('/#(\w*[0-9a-zA-Z]+\w*[0-9a-zA-Z])/', '<a target="_blank" href="https://www.facebook.com/hashtag/$1">#$1</a>', $string);
}

function detectPageLinks($string) {
    return preg_replace('/@\[(\d*):\d*:(.*)\]/', '<a target="_blank" href="https://www.facebook.com/$1">$2</a>', $string);
}

function openLinksInNewTab($content){
    $pattern = '/<a(.*?)?href=[\'"]?[\'"]?(.*?)?>/i';

    $content = preg_replace_callback($pattern, function($m){
        $tpl = array_shift($m);
        $hrf = isset($m[1]) ? $m[1] : null;

        if ( preg_match('/target=[\'"]?(.*?)[\'"]?/i', $tpl) ) {
            return $tpl;
        }

        if ( trim($hrf) && 0 === strpos($hrf, '#') ) {
            return $tpl; // anchor links
        }

        return preg_replace_callback('/href=/i', function($m2){
            return sprintf('target="_blank" %s', array_shift($m2));
        }, $tpl);

    }, $content);

    return $content;
}

add_action('wp_ajax_facebook_news', 'facebook_news');
add_action('wp_ajax_nopriv_facebook_news', 'facebook_news');

/*$config = DwordDesign\Cli\Config::load();
$fb = new Facebook\Facebook([
    'app_id' => $config->facebook_app_id,
    'app_secret' => $config->facebook_app_secret,
    'default_graph_version' => 'v2.9',
    'default_access_token' => $config->facebook_app_id . '|' . $config->facebook_app_secret
]);

function facebook_news() {
    global $fb;

    try {
        $url = '/SebastianLandwehrMusic/feed?fields=id,type,created_time,message,link,source,name,parent_id,attachments,object_id,description&limit=10';
        if (isset($_POST['next'])) {
            $url .= '&after=' . $_POST['next'];
        }

        $facebookResponse = $fb->get($url);
        $feedEdge = $facebookResponse->getGraphEdge();
        $next = $feedEdge->getMetadata()['paging']['cursors']['after'];
        Timber::render('components/ajax-news.html.twig', ['posts' => $feedEdge->asArray(), 'next' => $next]);

    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook-Fehler: ' . $e->getMessage();
    }

    die();
}

function facebook_event_picture_url($eventId) {
    global $fb;

    $facebookResponse = $fb->get('/' . $eventId . '?fields=cover{source}');
    return  $facebookResponse->getDecodedBody()['cover']['source'];
}
*/

function oembed_code($url) {
    $args = ['width' => 1000];
    $code = video_embed_privacy_translate($url, $url, $args);
    return ($code != $url) ? $code : wp_oembed_get($url, $args);
}

function truncate_keep_html($text, $length = 100) {
    $truncateService = new TruncateService();
    return $truncateService->truncate($text, $length);
}

function twig_extensions($twig) {
    $twig->addFilter(new Twig_SimpleFilter('oembed_code', 'oembed_code'));
    $twig->addFilter(new Twig_SimpleFilter('truncate_keep_html', 'truncate_keep_html'));
    //$twig->addFunction(new Twig_SimpleFunction('facebook_event_picture_url', 'facebook_event_picture_url'));
    return $twig;
}

add_filter('get_twig', 'twig_extensions');

<?php

require get_theme_file_path('/includes/search-route.php');

function university_custom_rest() {
    register_rest_field('post', 'author_name', array(
        'get_callback' => function() {return get_the_author();}
    ));
    register_rest_field('post', 'author_name', array(
        'get_callback' => function() {return get_the_author();}
    ));
}

add_action('rest_api_init', 'university_custom_rest');

/////////////////////////////////////////////////////////
    // Generate Page Banner Function
/////////////////////////////////////////////////////////
function pageBanner($args = NULL) {
    // all php logic here
    if (!$args['title']) {
        $args['title'] = get_the_title();
    }

    if (!$args['subtitle']) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }

    if (!$args['photo']) {
        if (get_field('page_banner_bg_image') AND !is_archive() AND !is_home()) {
            $args['photo'] = get_field('page_banner_bg_image')['sizes']['pageBanner'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }
    ?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>);"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
            <div class="page-banner__intro">
            <p><?php echo $args['subtitle']; ?></p>
        </div>
    </div>  
</div>

<?php
}

/////////////////////////////////////////////////////////
    // END PAGE BANNER FUNCTION
/////////////////////////////////////////////////////////

function university_files() {

    // Setup for serving bundled css and js files
    
    wp_enqueue_style('custom_google_fonts', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font_awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    
    if (strstr($_SERVER['SERVER_NAME'], 'fictional-university.local')) {
        wp_enqueue_script('main-university-js', 'http://localhost:3000/bundled.js', NULL, '1.0', true);
    } else {
        wp_enqueue_script('our-vendors-js', get_theme_file_uri('/bundled-assets/vendors~scripts.8c97d901916ad616a264.js'), NULL, '1.0', true);
        wp_enqueue_script('main-university-js', get_theme_file_uri('/bundled-assets/scripts.bc49dbb23afb98cfc0f7.js'), NULL, '1.0', true);
        wp_enqueue_style('our-main-styles', get_theme_file_uri('/bundled-assets/styles.bc49dbb23afb98cfc0f7.css'));
    }
    
    wp_localize_script('main-university-js', 'universityData', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest') // Create verification for user to edit Database //
    ));
}

add_action('wp_enqueue_scripts', 'university_files');

function university_features() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
    // register_nav_menu('headerMenuLocation', 'Header Menu Location');
    // register_nav_menu('footerLocation1', 'Footer Location 1');
    // register_nav_menu('footerLocation2', 'Footer Location 2');
}

add_action('after_setup_theme', 'university_features');

function university_adjust_queries($query) {
    //Program Post Query
    if(!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()) {
        $query->set('posts_per_page', -1); // -1 displays all
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
    }
    
    // Event Post Query
    // $query->set('posts_per_page', '1');  // This affects EVERYTHING on the website, including admin dashboard! 8O
    if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
            'key' => 'event_date',
            'compare' => '>=',
            'value' => $today,
            'type' => 'numeric'
            )
          ));
    }
}

add_action('pre_get_posts', 'university_adjust_queries');

/////////////////////////////////////////////////////////
    // Subcriber Account redirect to home page
/////////////////////////////////////////////////////////

add_action('admin_init', 'redirectSubsToFrontend');

function redirectSubsToFrontend() {
$ourCurrentUser = wp_get_current_user();

    if(count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
        wp_redirect(site_url('/'));
        exit;
    }
}

/////////////////////////////////////////////////////////
    // Remove admin bar for subscribers //
/////////////////////////////////////////////////////////

add_action('wp_loaded', 'noSubsAdminBar');

function noSubsAdminBar() {
$ourCurrentUser = wp_get_current_user();

    if(count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
        show_admin_bar(false);
    }
}

/////////////////////////////////////////////////////////
    // Customize login screen //
/////////////////////////////////////////////////////////

add_filter('login_headerurl', 'ourHeaderUrl'); // change wordpress logo link destination //
add_filter('login_headertitle', 'ourLoginTitle'); // change wordpress logo text //

function ourLoginTitle() {
    return get_bloginfo('name');
}

function ourHeaderUrl() {
    return esc_url(site_url('/'));
}

function universityLoginStyles() {
    wp_enqueue_style('our-main-styles', get_theme_file_uri('/bundled-assets/styles.bc49dbb23afb98cfc0f7.css'));
    wp_enqueue_style('custom_google_fonts', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
}

add_action('login_enqueue_scripts', 'universityLoginStyles');

?>
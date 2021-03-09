<?php

function university_post_types() {
    register_post_type('event', array(    // https://developer.wordpress.org/reference/functions/register_post_type/
        'show_in_rest' => true,
        'supports' => array(
            'title', 'editor', 'excerpt' // Need to include editor if you want to use rest_api and modern block editor.
        ),
        'rewrite' => array(
            'slug' => 'events',
        ),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Events',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name' => 'Event'
        ),
        'menu_icon' => 'dashicons-calendar'
    ));
}

add_action('init', 'university_post_types');

?>
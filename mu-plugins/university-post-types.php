<?php

function university_post_types() {
    // Note Post Type
    register_post_type('note', array(
        'show_in_rest' => true,
        'supports' => array(
            'title', 'editor'
        ),
        'public' => false,
        'show_ui' => true, // forces it to show in admin dashboard
        'labels' => array(
            'name' => 'Notes',
            'add_new_item' => 'Add New Note',
            'edit_item' => 'Edit Note',
            'all_items' => 'All Notes',
            'singular_name' => 'Note'
        ),
        'menu_icon' => 'dashicons-welcome-write-blog'
    ));

    //Professor Post Type
    register_post_type('professor', array(
        'show_in_rest' => true,
        'supports' => array(
            'title', 'editor', 'thumbnail'
        ),
        'public' => true,
        'labels' => array(
            'name' => 'Professors',
            'add_new_item' => 'Add New Professor',
            'edit_item' => 'Edit Professor',
            'all_items' => 'All Professors',
            'singular_name' => 'Professors'
        ),
        'menu_icon' => 'dashicons-welcome-learn-more'
    ));

    //Program Post Type
    register_post_type('program', array(
        'show_in_rest' => true,
        'supports' => array('title'),
        'rewrite' => array(
            'slug' => 'programs'
        ),
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Programs',
            'add_new_item' => 'Add New Program',
            'edit_item' => 'Edit Program',
            'all_items' => 'All Programs',
            'singular_name' => 'Program'
        ),
        'menu_icon' => 'dashicons-awards'
    ));

    //Event Post Type
    register_post_type('event', array(    // https://developer.wordpress.org/reference/functions/register_post_type/
        'capability_type' => 'event', // for making unique user role access
        'map_meta_cap' => true, // for making unique user role access
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
<?php

//CHECK FOR ARCHIVE TEMPLATES IN THEME FOLDER AND PROVIDE DEFAULT PLUGIN TEMPLATES
function bookswp_archive_templates( $archive_template ) {
    global $post;
    if ( is_archive() ) {
        if( ! file_exists(get_stylesheet_directory() . '/archive.php')) { $archive_template = dirname(__FILE__) . '/archive.php'; }
    }
    return $archive_template;
}
add_filter( 'archive_template', 'bookswp_archive_templates' ) ;
/*
//CHECK FOR SINGLE TEMPLATES IN THEME FOLDER AND PROVIDE DEFAULT PLUGIN TEMPLATES
function bookswp_single_templates($single_template) {
    global $post;
    if ($post->post_type == 'book') {
        if( ! file_exists(get_stylesheet_directory() . '/single-book.php')) { $single_template = dirname(__FILE__) . '/single-book.php'; }
    } elseif ($post->post_type == 'contributor') {
        if( ! file_exists(get_stylesheet_directory() . '/single-contributor.php')) { $single_template = dirname(__FILE__) . '/single-contributor.php'; }
    }
    return $single_template;
}
add_filter( 'single_template', 'bookswp_single_templates' );
*/
//CHECK FOR SPECIAL PAGE TEMPLATES IN THEME FOLDER AND PROVIDE DEFAULT PLUGIN TEMPLATES
function bookswp_specialpage_templates($page_template) {
    global $post;
    if ( is_page( 'new-releases' ) ) {
        if( ! file_exists(get_stylesheet_directory() . '/page-new-releases.php')) { $page_template = dirname(__FILE__) . '/page-new-releases.php'; }
    } elseif ( is_page( 'upcoming-titles' ) ) {
        if( ! file_exists(get_stylesheet_directory() . '/page-upcoming-titles.php')) { $page_template = dirname(__FILE__) . '/page-upcoming-titles.php'; }
    }
    return $page_template;
}
add_filter( 'page_template', 'bookswp_specialpage_templates' );
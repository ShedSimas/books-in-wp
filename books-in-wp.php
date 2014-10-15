<?php
/*
Plugin Name: Books to WP
Plugin URI: http://www.oncapublishing.com/projects/books-in-wp
Description: Creates custom post types and taxonomies for book publishers.
Version: 0.9
Author: Shed Simas
Author URI: http://shedsimas.com
License: GPL2

    Copyright 2014  SHED SIMAS / ONÇA PUBLISHING  (email : shed@oncapublishing.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*=====================*/
/* SETUP with SuperCPT */
/*=====================*/


require_once plugin_dir_path( __FILE__ ) . 'super-cpt/super-cpt.php';

add_action( 'plugins_loaded', 'bookswp_setup' );
function bookswp_setup() {
    if ( ! class_exists ( 'Super_Custom_Post_Type' ) )
        return;
    
    //BOOK POST TYPE
    $books = new Super_Custom_Post_Type( 'book' );
    $books->supports( 'title', 'editor', 'thumbnail' );
    $books->taxonomies( array( 'post_tag' ) );
    $books->set_icon( 'book' );
    
    //BOOK METADATA
    $books->add_meta_box( array(
        'id' => 'book_meta',
        'context' => 'side',
        'fields' => array(
            'isbn-13' => array( 'label'=> 'ISBN-13 (no dashes)', 'maxlength' => '13', 'placeholder' => '978...',  'pattern' => '\d{13}'),
            'contributors' => array( 'type' => 'select', 'data' => 'contributor', 'multiple' => 'multiple', 'column' => true ),
            'series' => array( 'type' => 'select', 'data' => 'series', 'column' => true ),
            'number-in-series' => array( ),
            'price' => array( 'maxlength'=> '6', 'placeholder'=> '00.00', ),
            'currency' => array( 'type' => 'select', 'options' => array ( '$ CAD', '$ USD', '£ GBP', ), ),
	        'format' => array( 'label'=> 'Formats', 'type' => 'select', 'options' => array ( 'Hardcover', 'Paperback', 'Mass market paper', 'Ebook', ), 'column' => true),
            'width' => array ( 'label'=> 'Width (inches)', 'placeholder' => '6', 'pattern' => '(([1-9](\d+)?)|0)(\.(\d+))?' ),
            'height' => array ( 'label'=> 'Height (inches)', 'placeholder' => '9', 'pattern' => '(([1-9](\d+)?)|0)(\.(\d+))?' ),
            'page-count' => array ('placeholder' => '256', 'pattern' => '[1-9](\d+)?' ),
	        'publication-date' => array( 'type'	=> 'date', ),
	        'availability' => array( 'type'	=> 'select', 'options' => array ( 'Not yet published', 'Accepting pre-orders', 'In stock', 'Print on demand', 'Out of stock', 'Out of print', ), ),
            'ages' => array( ),
	        ),
    ) );
    $books->add_meta_box( array(
        'id' => 'reviews',
        'context' => 'normal',
        'fields' => array(
            'review-field' => array( 'label'=> false, 'type' => 'wysiwyg',  ),
	        ),
    ) );
    
    //GENRES TAXONOMY FOR BOOKS CPT
    $genres = new Super_Custom_Taxonomy ( 'genre' );
    $genres->hierarchical( true );
    connect_types_and_taxes( $books, $genres );
    
    //CONTRIBUTOR POST TYPE
    $contributors = new Super_Custom_Post_Type( 'contributor' );
    $contributors->supports( 'title', 'editor', 'thumbnail' );
    $contributors->set_icon( 'group' );
    
    //CONTRIBUTOR METADATA
    $contributors->add_meta_box( array(
        'id' => 'contributor-meta',
        'context' => 'side',
        'fields' => array(
            'website' => array( 'type' => 'url', 'placeholder' => 'http://...', ),
            'facebook' => array( 'label' => 'Facebook URL','type' => 'url', 'placeholder' => 'https://www.facebook.com/...', ),
            'twitter' => array( 'label'=> 'Twitter Handle', 'placeholder' => 'Username without @', 'maxlength' => '15', 'pattern' => '(?!@)(.*)' ),
	        ),
    ) );
    
    //ROLES TAXONOMY FOR CONTRIBUTOR CPT
    $roles = new Super_Custom_Taxonomy ( 'role' );
    $roles->hierarchical( true );
    connect_types_and_taxes( $contributors, $roles );
    
    //ALPHA TAXONOMY FOR BOOK AND CONTRIBUTOR CPTS
    $AZ_book = new Super_Custom_Taxonomy ( 'AZ_book' );
    $AZ_book->hierarchical( false );
    $AZ_book->show_ui ( false );
    connect_types_and_taxes( $books, $AZ_book );
    
    $AZ_contributor = new Super_Custom_Taxonomy ( 'AZ_contributor' );
    $AZ_contributor->hierarchical( false );
    $AZ_contributor->show_ui ( false );
    connect_types_and_taxes( $contributors, $AZ_contributor );
    
    //SERIES POST TYPE
    $series = new Super_Custom_Post_Type( 'series', 'Series', 'Series' );
    $series->supports( 'title', 'editor', 'thumbnail' );
    $series->set_icon( 'umbrella' );
    $series->taxonomies( array( 'post_tag', 'genre' ) );
    
    //SERIES METADATA
    $series->add_meta_box( array(
        'id' => 'series-meta',
        'context' => 'side',
        'fields' => array(
            'contributors' => array( 'type' => 'select', 'data' => 'contributor', 'multiple' => 'multiple', 'column' => true ),
            ),
    ) );
    
}

//CHANGE BOOK PUB DATE SAVE FORMAT
function format_pub_date( $value ) {
    $date = date('Ymd', strtotime ($value) );
    return $date;
};
add_filter( 'scpt_plugin_book_meta_save_publication-date', 'format_pub_date' );
remove_filter( 'scpt_plugin_book_meta_save_publication-date', 'format_pub_date' );


/*===================*/
/* VISIBILITY TOGGLE */
/*===================*/

function bookswp_toggle() {
    // register your script location, dependencies and version
    wp_register_script('bookswp_toggle_script',
                       plugins_url( '', __FILE__ ) . '/includes/toggle.js',
                       array('jquery'),
                      '1.0',
                      true );
    // enqueue the script
    wp_enqueue_script('bookswp_toggle_script');
}
add_action('wp_enqueue_scripts', 'bookswp_toggle');


/*======================*/
/* ALPHABETICAL INDECES */
/*======================*/

//AUTOSAVE BOOK ALPHA
function alphaindex_save_AZ_book( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	return;
	$letter = '';
	// If this isn't a 'book' post, don't update it.
	if ( isset( $_POST['post_type'] ) && ( 'book' != $_POST['post_type'] ) )
	return;
	// Check permissions
	if ( !current_user_can( 'edit_post', $post_id ) )
	return;
	// OK, we're authenticated: we need to find and save the data
	$taxonomy = 'AZ_book';
	if ( isset( $_POST['post_type'] ) ) {
		// Get the title of the post
		$title = strtolower( $_POST['post_title'] );
		
		// The next few lines remove A, An, or The from the start of the title
		$splitTitle = explode(" ", $title);
		$blacklist = array("an","a","the");
		$splitTitle[0] = str_replace($blacklist,"",strtolower($splitTitle[0]));
		$title = implode("", $splitTitle);
		
		// Get the first letter of the title
		$letter = substr( $title, 0, 1 );
		
		// Set to 0-9 if it's a number
        if ( ctype_alnum( $letter ) == false ) { $letter = 'other'; }
		if ( is_numeric( $letter ) ) { $letter = 'number'; }
    }
	//set term as first letter of post title, lower case
	wp_set_post_terms( $post_id, $letter, $taxonomy );
}
add_action( 'save_post', 'alphaindex_save_AZ_book' );

//AUTOSAVE CONTRIBUTOR ALPHA
function alphaindex_save_AZ_contributor( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	return;
	$letter = '';
	// If this isn't a 'contributor' post, don't update it.
	if ( isset( $_POST['post_type'] ) && ( 'contributor' != $_POST['post_type'] ) )
	return;
	// Check permissions
	if ( !current_user_can( 'edit_post', $post_id ) )
	return;
	// OK, we're authenticated: we need to find and save the data
	$taxonomy = 'AZ_contributor';
	if ( isset( $_POST['post_type'] ) ) {
		// Get the title of the post
		$title = strtolower( $_POST['post_title'] );
		
		// The next few lines remove A, An, or The from the start of the title
		$splitTitle = explode(" ", $title);
		$title = end ($splitTitle);
		
		// Get the first letter of the title
		$letter = substr( $title, 0, 1 );
	}
	//set term as first letter of post title, lower case
	wp_set_post_terms( $post_id, $letter, $taxonomy );
}
add_action( 'save_post', 'alphaindex_save_AZ_contributor' );

//ADD ALL LETTERS, PLUS "NUMBER" AND "OTHER" TO BOOK ALPHA
function get_default_book_alpha() {
    $alpha = array('0' => array( 'name' => '#', 'slug' => 'number' ),'1' => array( 'name' => 'a' ),'2' => array( 'name' => 'b' ),'3' => array( 'name' => 'c' ),'4' => array( 'name' => 'd' ),'5' => array( 'name' => 'e' ),'6' => array( 'name' => 'f' ),'7' => array( 'name' => 'g' ),'8' => array( 'name' => 'h' ),'9' => array( 'name' => 'i' ),'10' => array( 'name' => 'j' ),'11' => array( 'name' => 'k' ),'12' => array( 'name' => 'l' ),'13' => array( 'name' => 'm' ),'14' => array( 'name' => 'n' ),'15' => array( 'name' => 'o' ),'16' => array( 'name' => 'p' ),'17' => array( 'name' => 'q' ),'18' => array( 'name' => 'r' ),'19' => array( 'name' => 's' ),'20' => array( 'name' => 't' ),'21' => array( 'name' => 'u' ),'22' => array( 'name' => 'v' ),'23' => array( 'name' => 'w' ),'24' => array( 'name' => 'x' ),'25' => array( 'name' => 'y' ),'26' => array( 'name' => 'z' ), '27' => array( 'name' => '?', 'slug' => 'other' ) );
    return $alpha;
}
function set_AZ_book_default_terms() {
    // see if we already have populated any terms
    $alpha = get_terms( 'AZ_book', array( 'hide_empty' => 0 ) );
    //if no terms then lets add our terms
    $alphas = get_default_book_alpha();
    foreach( $alphas as $alpha ){
        if( !term_exists( $alpha['name'], 'AZ_book' ) ){
            wp_insert_term( $alpha['name'], 'AZ_book', array( 'slug' => $alpha['slug'] ) );
        }
    }

}
add_action( 'registered_taxonomy', 'set_AZ_book_default_terms');

//ADD LETTERS ONLY TO CONTRIBUTOR ALPHA
function get_default_contributor_alpha() {
    $alpha = array('0' => array( 'name' => 'a' ),'1' => array( 'name' => 'b' ),'2' => array( 'name' => 'c' ),'3' => array( 'name' => 'd' ),'4' => array( 'name' => 'e' ),'5' => array( 'name' => 'f' ),'6' => array( 'name' => 'g' ),'7' => array( 'name' => 'h' ),'8' => array( 'name' => 'i' ),'9' => array( 'name' => 'j' ),'10' => array( 'name' => 'k' ),'11' => array( 'name' => 'l' ),'12' => array( 'name' => 'm' ),'13' => array( 'name' => 'n' ),'14' => array( 'name' => 'o' ),'15' => array( 'name' => 'p' ),'16' => array( 'name' => 'q' ),'17' => array( 'name' => 'r' ),'18' => array( 'name' => 's' ),'19' => array( 'name' => 't' ),'20' => array( 'name' => 'u' ),'21' => array( 'name' => 'v' ),'22' => array( 'name' => 'w' ),'23' => array( 'name' => 'x' ),'24' => array( 'name' => 'y' ),'25' => array( 'name' => 'z' ) );
    return $alpha;
}
function set_AZ_contributor_default_terms() {
    // see if we already have populated any terms
    $alpha = get_terms( 'AZ_contributor', array( 'hide_empty' => 0 ) );
    //if no terms then lets add our terms
    $alphas = get_default_contributor_alpha();
    foreach( $alphas as $alpha ){
        if( !term_exists( $alpha['name'], 'AZ_contributor' ) ){
            wp_insert_term( $alpha['name'], 'AZ_contributor', array( 'slug' => $alpha['slug'] ) );
        }
    }

}
add_action( 'registered_taxonomy', 'set_AZ_contributor_default_terms');

//SORT BOOKS AND CONTRIBUTORS ALPHABETICALLY
function alphaindex_queries( $query ) {
	/* Sort book and contributor alpha  */
	if ( ! is_admin() && ( is_post_type_archive( 'book' ) || is_tax( 'AZ_book' ) ) && $query->is_main_query() ) {
		$query->set('orderby', 'name');
		$query->set('order', 'ASC');
	} elseif ( ! is_admin() && ( is_post_type_archive( 'contributor' ) || is_tax( 'AZ_contributor' ) ) && $query->is_main_query() ) {
		$query->set('orderby', 'name');
		$query->set('order', 'ASC');
	}
}
add_action( 'pre_get_posts', 'alphaindex_queries' );


/*========================*/
/* SPECIAL BROWSING PAGES */
/*========================*/

//ADD SPECIAL PAGES
function add_bookswp_pages() {
    //New Releases
    $newexists = get_page_by_path( 'new-releases' );
    $newreleases = array(
        'post_content'   => 'This page does not display content and is only used to hold the New Releases display. Any content you enter here will be ignored, but you can set all the other page options: the Excerpt, Categories, Tags, Featured image, and so on. <h1>! Important !</h1> Do not change thus slug for this page ("new-releases") or it will break the connection to the plugin page template.',
        'post_name'      => 'new-releases',
        'post_title'     => 'New Releases',
        'post_status'    => 'publish',
        'post_type'      => 'page',
        'ping_status'    => 'closed',
        'comment_status' => 'closed',
    );
    if ( empty($newexists) ) {
    wp_insert_post( $newreleases );
    };
    
    //Upcoming Titles
    $upcomingexists = get_page_by_path( 'upcoming-titles' );
    $upcomingtitles = array(
        'post_content'   => 'This page does not display content and is only used to hold the Upcoming Titles display. Any content you enter here will be ignored, but you can set all the other page options: the Excerpt, Categories, Tags, Featured image, and so on. <h1>! Important !</h1> Do not change thus slug for this page ("upcoming-titles") or it will break the connection to the plugin page template.',
        'post_name'      => 'upcoming-titles',
        'post_title'     => 'Upcoming Titles',
        'post_status'    => 'publish',
        'post_type'      => 'page',
        'ping_status'    => 'closed',
        'comment_status' => 'closed',
    );
    if ( empty( $upcomingexists ) ) {
    wp_insert_post( $upcomingtitles );
    };
}
register_activation_hook( __FILE__, 'add_bookswp_pages' );

//BROWSE LISTING
function bookswp_browse_list( $post_type ) {
    if ( $post_type == 'book' ) {
        $alpha = get_categories( $args = array( 'taxonomy' => 'AZ_book', 'hide_empty' => 0 ) );
        $tax = get_categories( $args = array( 'taxonomy' => 'genre' ) );
    } elseif ( $post_type == 'contributor' ) {
        $alpha = get_categories( $args = array( 'taxonomy' => 'AZ_contributor', 'hide_empty' => 0 ) );
        $tax = get_categories( $args = array( 'taxonomy' => 'role' ) );
    } else { return; }
        
    global $wp;
    $current_url = home_url( $wp->request );
    $taxpage = get_post_type_archive_link( $post_type );
    
    echo '<ul class="clear browse-tax" id="browse-top">';
    echo '<li class="cat-item';
    if ( $current_url == $taxpage ) echo ' current-cat';
    echo '"><a href="' . $taxpage . '">All ' . $post_type . 's</a></li>';
    foreach ( $tax as $tax ) {
        echo '<li class="cat-item';
        if ( $current_url == get_term_link( $tax ) ) echo ' current-cat';
        echo '"><a href="' . get_term_link( $tax ) . '">' . $tax->name . '</a></li>';
    };
    echo '</ul>';
    
    echo '<ul class="clear browse-tax">';
    foreach ( $alpha as $alpha ) {
        echo '<li class="cat-item';
        if ( $alpha->category_count == 0 ) {
            echo ' blank-cat sc">' . $alpha->name . '</li>';
        } else {
        if ( $current_url == get_term_link( $alpha ) ) echo ' current-cat';
        echo '"><a href="' . get_term_link( $alpha ) . '">' . $alpha->name . '</a></li>';
        };
    };
    echo '</ul>';
}


/*=====================*/
/* ADDITIONAL FEATURES */
/*=====================*/

// EXCERPT AND FEATURED IMAGE TITLES FOR BOOKS
add_action( 'admin_init',  'edit_book_meta_titles' );
function edit_book_meta_titles() {
    remove_meta_box( 'postimagediv', 'book', 'side' );
    add_meta_box('postimagediv', __('Book Cover (Featured Image)'), 'post_thumbnail_meta_box', 'book', 'side', 'high');
	add_meta_box('postexcerpt', __('Short Description (Excerpt)'), 'post_excerpt_meta_box', 'book', 'normal', 'default');
}

//BOOK SUBTITLE
require_once plugin_dir_path( __FILE__ ) . 'WP-Subtitle-master/hc-subtitle.php';


// EXCERPT AND FEATURED IMAGE TITLES FOR SERIES
add_action( 'admin_init',  'edit_series_meta_titles' );
function edit_series_meta_titles() {
    remove_meta_box( 'postimagediv', 'series', 'side' );
    add_meta_box('postimagediv', __('Series Cover (Featured Image)'), 'post_thumbnail_meta_box', 'series', 'side', 'high');
	add_meta_box('postexcerpt', __('Short Description (Excerpt)'), 'post_excerpt_meta_box', 'series', 'normal', 'default');
}

// EXCERPT AND FEATURED IMAGE TITLES FOR CONTRIBUTORS
add_action( 'admin_init',  'edit_contr_meta_titles' );
function edit_contr_meta_titles() {
    remove_meta_box( 'postimagediv', 'contributor', 'side' );
    remove_meta_box( 'pageparentdiv' , 'contributor', 'side' );
    add_meta_box('postimagediv', __('Author Photo (Featured Image)'), 'post_thumbnail_meta_box', 'contributor', 'side', 'high');
	add_meta_box('postexcerpt', __('Short Bio (Excerpt)'), 'post_excerpt_meta_box', 'contributor', 'normal', 'default');
}
/*
* Gets the excerpt of a specific post ID or object
* @param - $post - object/int - the ID or object of the post to get the excerpt of
* @param - $length - int - the length of the excerpt in words
* @param - $tags - string - the allowed HTML tags. These will not be stripped out
* @param - $extra - string - text to append to the end of the excerpt
*/
function get_short_desc($post_id) {
    global $post;  
    $save_post = $post;
    $post = get_post($post_id);
    $output = get_the_excerpt();
    $post = $save_post;
    return $output;
};


/*===============================*/
/* ESTABLISH MENUS, WIDGETS, ETC */
/*===============================*/

//ADD BOOK & CONTRIBUTOR ARCHIES TO MENU OPTIONS
require_once plugin_dir_path( __FILE__ ) . 'Custom-Post-Types-Menu-Links/custom-post-type-archive-menu-links.php';

//Filter the nav_menu_css_class with our custom function 
add_filter('nav_menu_css_class', 'current_type_nav_class', 10, 2);
function current_type_nav_class($classes, $item) {
    // Get post_type for this post
    $post_type = get_query_var('post_type');

    // Go to Menus and add a menu class named: {custom-post-type}-menu-item
    // This adds a 'current_page_parent' class to the parent menu item
    if( in_array( $post_type.'-menu-item', $classes ) )
        array_push($classes, 'current_page_parent');

    return $classes;
}

//PREPARE DISPLAY FUNCTIONS
require_once plugin_dir_path( __FILE__ ) . 'includes/display-functions.php';

//ADD WIDGETS
require_once plugin_dir_path( __FILE__ ) . 'widgets/bookswp-widgets.php';

//ADD ADMIN OPTIONS PAGE
require_once plugin_dir_path( __FILE__ ) . 'includes/admin.php';

//ADD TEMPLATES
require_once plugin_dir_path( __FILE__ ) . 'templates/template-check.php';
?>
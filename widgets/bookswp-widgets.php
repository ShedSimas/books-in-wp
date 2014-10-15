<?php
/* Widgets and widget functions for Books in WP plugin */


//BROWSE LISTING
function bookswp_browse_widget( $post_type ) {
    if ( $post_type == 'book' ) {
        $tax = get_categories( $args = array( 'taxonomy' => 'genre' ) );
    } elseif ( $post_type == 'contributor' ) {
        $tax = get_categories( $args = array( 'taxonomy' => 'role' ) );
    } else { return; }
        
    global $wp;
    $current_url = home_url( $wp->request );
    
    echo '<ul class="clear widget-tax">';
    foreach ( $tax as $tax ) {
        echo '<li class="cat-item';
        if ( $current_url == get_term_link( $tax ) ) echo ' current-cat';
        echo '"><a href="' . get_term_link( $tax ) . '">' . $tax->name . '</a></li>';
    };
    echo '</ul>';
}

//FEATURE BOOK DISPLAY
function bookswp_feature_display() {

    global $post;
    
    the_title();
    book_subtitle( ': ' );
    echo '</a></h2>';
    if ( has_post_thumbnail() ) {
        echo '<div class="thumb-holder"><a href="' . get_the_permalink() . '">';
        the_post_thumbnail();
        echo '</a></div>';
    }; ?>

    <div class="feature-meta">
        <?php the_contr_names('<h3 class="contr-names">', '</h3>'); ?>
        <ul class="float-book-meta clear no-bullet">
            <?php the_series(); ?>
            <?php the_isbn(); ?>
            <?php the_pub_date(); ?>
            <?php the_genres(); ?>
        </ul>
    </div><!-- .entry-meta -->

	<div class="feature-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
<?php
}

include 'bookswp-tax-widget.php';
include 'bookswp-featured-widget.php';
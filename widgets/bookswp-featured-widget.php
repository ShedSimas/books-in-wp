<?php
/* Book Genre List widget for Books in WP plugin */

class bookswp_featured_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'bookswp_featured_widget', 

// Widget name will appear in UI
__('Featured Books', 'bookswp_featured_widget_domain'), 

// Widget description
array( 'description' => __( 'Displays cover and basic meta for recent releases and upcoming titles', 'bookswp_featured_widget_domain' ), ) 
);
}

function widget( $args, $instance ) {
    extract( $args );
    $title = apply_filters('widget_title', $instance['title'] );
    //This is the variable of the checkbox
    $titledisplay = $instance['titledisplay'] ? 'true' : 'false';
    $recent = $instance['recent'] ? 'true' : 'false';
    $upcoming = $instance['upcoming'] ? 'true' : 'false';
    $showposts = apply_filters('showposts', $instance['showposts'] );

    echo $before_widget;

        if('on' == $instance['titledisplay'] ) {
            echo $before_title . $title . $after_title;
        }
        
        global $post;
        $today = date('Ymd', strtotime("now") );
        $tomorrow = date('Ymd', strtotime("+1 day") );
        $pastseason = date('Ymd', strtotime("-6 Months") );
        $nextseason = date('Ymd', strtotime("+6 Months") );
        
        if('on' == $instance['recent'] ) {
            $date_1 = $pastseason;
            if('on' == $instance['upcoming'] ) { $date_2 = $nextseason; } else { $date_2 = $today; }
        } else {
            if('on' == $instance['upcoming'] ) { $date_1 = $tomorrow; $date_2 = $nextseason; }
        }

        $args = array(
            'post_type'	    => 'book',
            'posts_per_page'    => $showposts,
            'orderby' => 'rand',
            'meta_query'		=> array(
                array(
                    'key' => 'publication-date',
                    'type'=> 'DATE',
                    'value' => array( $date_1, $date_2 ),
                    'compare' => 'BETWEEN'
                )
           )
        );
            
        $feature_query = new WP_Query( $args );
		if ( $feature_query->have_posts() ) :
			while ( $feature_query->have_posts() ) : $feature_query->the_post();
    
                if('on' != $instance['titledisplay'] ) {
                    echo '<h2 class="widget-title"><a href="' . get_the_permalink() . '">';
                } else {
                    echo '<h2 class="feature-title"><a href="' . get_the_permalink() . '">';
                };
                bookswp_feature_display();

			endwhile;
		else : ?>

            <section class="no-results not-found">
                <div class="widget-text">
                    <p>We have no featured books. Please check out our <a href="<?php echo get_post_type_archive_link( 'book' ); ?>">complete list of titles</a> instead.</p>
                </div><!-- .page-content -->
            </section><!-- .no-results -->

        <?php endif;
    
    echo $after_widget;
}

function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    //The update for the variable of the checkbox
    $instance['titledisplay'] = $new_instance['titledisplay'];
    $instance['recent'] = $new_instance['recent'];
    $instance['upcoming'] = $new_instance['upcoming'];
    $instance['showposts'] = strip_tags($new_instance['showposts']);
    return $instance;
}

function form( $instance ) {
    $defaults = array( 'title' => __('Featured book', 'wptheme'), 'titledisplay' => 'on', 'recent' => 'on', 'upcoming' => 'off', 'showposts' => '1' );
    $instance = wp_parse_args( (array) $instance, $defaults ); 
    ?>
    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>">Title</label>
        <input class="widefat"  id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
    </p>
<!-- The input (checkbox) -->
    <p>
        <input class="checkbox" type="checkbox" <?php checked($instance['titledisplay'], 'on'); ?> id="<?php echo $this->get_field_id('titledisplay'); ?>" name="<?php echo $this->get_field_name('titledisplay'); ?>" /> 
        <label for="<?php echo $this->get_field_id('titledisplay'); ?>">Uncheck to hide the widget title</label>
    </p>
    <p>
        <input class="checkbox" type="checkbox" <?php checked($instance['recent'], 'on'); ?> id="<?php echo $this->get_field_id('recent'); ?>" name="<?php echo $this->get_field_name('recent'); ?>" /> 
        <label for="<?php echo $this->get_field_id('recent'); ?>">Include recent releases</label>
    </p>
    <p>
        <input class="checkbox" type="checkbox" <?php checked($instance['upcoming'], 'on'); ?> id="<?php echo $this->get_field_id('upcoming'); ?>" name="<?php echo $this->get_field_name('upcoming'); ?>" /> 
        <label for="<?php echo $this->get_field_id('upcoming'); ?>">Include upcoming releases</label>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('showposts'); ?>">Show how many posts?</label>
        <input class="widefat"  id="<?php echo $this->get_field_id('showposts'); ?>" name="<?php echo $this->get_field_name('showposts'); ?>" type="text" value="<?php echo esc_attr( $instance['showposts'] ); ?>" />
    </p>
<?php
}
}

// Register and load the widget
function bookswp_featured_load_widget() {
	register_widget( 'bookswp_featured_widget' );
}
add_action( 'widgets_init', 'bookswp_featured_load_widget' );
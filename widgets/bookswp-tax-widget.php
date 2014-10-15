<?php
/* Book Genre List widget for Books in WP plugin */

// Creating the widget 
class bookswp_tax_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'bookswp_tax_widget', 

// Widget name will appear in UI
__('Genres or Roles', 'bookswp_tax_widget_domain'), 

// Widget description
array( 'description' => __( 'Displays a list of book genres or contributor roles.', 'bookswp_tax_widget_domain' ), ) 
);
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'taxselect' ] ) ) {
$taxselect = $instance[ 'taxselect' ];
}
else {
$taxselect = '';
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'taxselect' ); ?>"><?php _e( 'Book genres or contributor roles?' ); ?></label>
    <select class="widefat" id="<?php echo $this->get_field_id( 'taxselect' ); ?>" name="<?php echo $this->get_field_name( 'taxselect' ); ?>">
        <option value="">Select one</option>
        <option value='book'<?php echo ($taxselect=='book')?'selected':''; ?>>Book genres</option>
        <option value='contributor'<?php echo ($taxselect=='contributor')?'selected':''; ?>>Contributor roles</option>
    </select>
</p>

<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['taxselect'] = ( ! empty( $new_instance['taxselect'] ) ) ? strip_tags( $new_instance['taxselect'] ) : '';
return $instance;
}
    
// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
//Load options
$taxselect = $instance[ 'taxselect' ];
    
// before and after widget arguments are defined by themes
echo $args['before_widget'];
echo $args['before_title'];
    if ( $taxselect == 'book' ) {
        echo 'Genres';
    } elseif ( $taxselect == 'contributor' ) {
        echo 'Roles';
    } else {
        return;
    };
echo $args['after_title'];

// This is where you run the code and display the output
bookswp_browse_widget( $taxselect );

echo $args['after_widget'];
}
} // Class bookswp_tax_widget ends here

// Register and load the widget
function bookswp_tax_load_widget() {
	register_widget( 'bookswp_tax_widget' );
}
add_action( 'widgets_init', 'bookswp_tax_load_widget' );
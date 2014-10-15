<?php
/* Admin options for Books in WP plugin */


//ADMIN OPTIONS
add_action('admin_init', 'bookswp_options_init' );
add_action('admin_menu', 'bookswp_options_add_page');

// Init plugin options to white list our options
function bookswp_options_init(){
	register_setting( 'bookswp_options_options', 'bookswp_descs', 'bookswp_options_validate' );
}

// Add menu page
function bookswp_options_add_page() {
	add_options_page('Books in WP Options', 'Books in WP Options', 'manage_options', 'bookswp_options', 'bookswp_options_do_page');
}

// Draw the menu page itself
function bookswp_options_do_page() {
	?>
	<div class="wrap">
		<h1>Books in WP Options</h1>
        <p>These descriptions can be added to the post type archive pages, similar to the term description on category archives. The New Releases and Upcoming Titles show the description in a similar way.</p>
		<form method="post" action="options.php">
			<?php settings_fields('bookswp_options_options'); ?>
			<?php $options = get_option('bookswp_descs'); ?>
			<table class="form-table">
				<tr valign="top"><th scope="row">Book Description</th>
					<td><input type="text" class="widefat" name="bookswp_descs[book_desc]" value="<?php echo $options['book_desc']; ?>" /></td>
				</tr>
				<tr valign="top"><th scope="row">New Releases Description</th>
					<td><input type="text" class="widefat" name="bookswp_descs[recent_desc]" value="<?php echo $options['recent_desc']; ?>" /></td>
				</tr>
				<tr valign="top"><th scope="row">Upcoming Titles Description</th>
					<td><input type="text" class="widefat" name="bookswp_descs[upcoming_desc]" value="<?php echo $options['upcoming_desc']; ?>" /></td>
				</tr>
				<tr valign="top"><th scope="row">Contributor Description</th>
					<td><input type="text" class="widefat" name="bookswp_descs[contr_desc]" value="<?php echo $options['contr_desc']; ?>" /></td>
				</tr>
				<tr valign="top"><th scope="row">Series Description</th>
					<td><input type="text" class="widefat" name="bookswp_descs[series_desc]" value="<?php echo $options['series_desc']; ?>" /></td>
				</tr>
			</table>
			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>
        <?php include plugin_dir_path( __FILE__ ) . 'instructions.php'; ?>
	</div>
	<?php	
}

// Sanitize and validate input. Accepts an array, return a sanitized array.
function bookswp_options_validate($input) {
	// Say our second option must be safe text with no HTML tags
	$input['book_desc'] =  wp_filter_nohtml_kses($input['book_desc']);
	$input['recent_desc'] =  wp_filter_nohtml_kses($input['recent_desc']);
	$input['upcoming_desc'] =  wp_filter_nohtml_kses($input['upcoming_desc']);
	$input['contr_desc'] =  wp_filter_nohtml_kses($input['contr_desc']);
	$input['series_desc'] =  wp_filter_nohtml_kses($input['series_desc']);
	
	return $input;
}
<?php
/**
 * The template for displaying the new releases page.
 *
 * @package Jaguar
 */

get_header(); ?>

	<div id="primary" class="content-area small-12 medium-8 columns">
		<main id="main" class="site-main" role="main">

        <?php
        
        $date_1 = date('Ymd', strtotime("-6 Months") );
        $date_2 = date('Ymd', strtotime("now") );
        
        $args = array(
            'post_type'	    => 'book',
            'orderby' => 'meta_value',
            'order' => 'desc',
            'meta_query'		=> array(
                array(
                    'key' => 'publication-date',
                    'type'=> 'DATE',
                    'value' => array( $date_1, $date_2 ),
                    'compare' => 'BETWEEN'
                )
           )
        );
            
        $new_releases = new WP_Query( $args ); ?>
		<?php if ( $new_releases->have_posts() ) :  ?>

			<header class="page-header">
				<h1 class="page-title"><?php $page = get_page_by_path( 'new-releases' ); echo get_the_title($page->ID); ?></h1>
                <?php $descriptions = get_option( 'bookswp_descs' );
                if ( $descriptions['recent_desc'] != "" ) { echo '<div class="taxonomy-description"><p>' . $descriptions['recent_desc'] . '</p></div>'; }; ?>
			</header><!-- .page-header -->
            
			<?php /* Start the Loop */ ?>
			<?php while ( $new_releases->have_posts() ) : $new_releases->the_post(); ?>


				<?php
                //$bookpub = get_scpt_formatted_meta( 'publication-date', $post->ID );
                //if ( ( $bookpub >= $season ) && ( $bookpub <= $today ) ) {
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'content', 'search' );
                //};
				?>

			<?php endwhile; ?>
            
		<?php else : ?>

            <section class="no-results not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php _e( 'No new releases' ); ?></h1>
                </header><!-- .page-header -->
                <div class="page-content">
                    <p>We have not published any books recently. Please check out our <a href="<?php echo get_post_type_archive_link( 'book' ); ?>">complete list of titles</a> instead.</p>
                </div><!-- .page-content -->
            </section><!-- .no-results -->

        <?php endif; ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

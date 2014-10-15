<?php
/**
 * The template for displaying the upcoming titles page.
 *
 * @package Jaguar
 */

get_header(); ?>

	<div id="primary" class="content-area small-12 medium-8 columns">
		<main id="main" class="site-main" role="main">

        <?php
        
        $date_1 = date('Y-m-d', strtotime("+1 day") );
        $date_2 = date('Y-m-d', strtotime("+6 months") );

        $args = array(
            'post_type'	    => 'book',
            'orderby' => 'meta_value',
            'order' => 'asc',
            'meta_query'		=> array(
                array(
                    'key' => 'publication-date',
                    'type'=> 'DATE',
                    'value' => array( $date_1, $date_2 ),
                    'compare' => 'BETWEEN'
                )
           )
        );
            
        $upcoming_titles = new WP_Query( $args ); ?>
		<?php if ( $upcoming_titles->have_posts() ) :  ?>

			<header class="page-header">
				<h1 class="page-title"><?php $page = get_page_by_path( 'upcoming-titles' ); echo get_the_title($page->ID); ?></h1>
                <?php $descriptions = get_option( 'bookswp_descs' );
                if ( $descriptions['upcoming_desc'] != "" ) { echo '<div class="taxonomy-description"><p>' . $descriptions['upcoming_desc'] . '</p></div>'; }; ?>
			</header><!-- .page-header -->
            
			<?php /* Start the Loop */ ?>
			<?php while ( $upcoming_titles->have_posts() ) : $upcoming_titles->the_post(); ?>


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
                    <h1 class="page-title"><?php _e( 'No upcoming titles' ); ?></h1>
                </header><!-- .page-header -->
                <div class="page-content">
                    <p>We have no books set to release in the coming months. Please check out our <a href="<?php echo get_post_type_archive_link( 'book' ); ?>">complete list of titles</a>, or <a href="<?php echo get_permalink( get_page_by_path( 'submission-guidelines' )); ?>">submit a manuscript</a> for our consideration.</p>
                </div><!-- .page-content -->
            </section><!-- .no-results -->

        <?php endif; ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

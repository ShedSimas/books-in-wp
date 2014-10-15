<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Jaguar
 */

get_header(); ?>

	<div id="primary" class="content-area small-12 medium-8 columns">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
						if ( is_category() ) :
							single_cat_title();

						elseif ( is_tag() ) :
							single_tag_title();

						elseif ( is_author() ) :
							printf( __( 'Author: %s' ), '<span class="vcard">' . get_the_author() . '</span>' );

						elseif ( is_day() ) :
							printf( __( 'Day: %s' ), '<span>' . get_the_date() . '</span>' );

						elseif ( is_month() ) :
							printf( __( 'Month: %s' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format' ) ) . '</span>' );

						elseif ( is_year() ) :
							printf( __( 'Year: %s' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format' ) ) . '</span>' );

						elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
							_e( 'Asides' );

						elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
							_e( 'Galleries' );

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							_e( 'Images' );

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							_e( 'Videos' );

						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							_e( 'Quotes' );

						elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
							_e( 'Links' );

						elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
							_e( 'Statuses' );

						elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
							_e( 'Audios' );

						elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
							_e( 'Chats' );

						elseif ( is_tax( 'role' ) ) :
							echo single_term_title() . 's';

						elseif ( is_tax( 'genre' ) ) :
							echo single_term_title();

						elseif ( is_tax( 'AZ_book' ) ) :
							echo single_term_title( '&ldquo;' ) . '&rdquo; books';

						elseif ( is_tax( 'AZ_contributor' ) ) :
							echo single_term_title( '&ldquo;' ) . '&rdquo; contributors';

						elseif ( is_post_type_archive( 'book' ) ) :
							_e( 'Books');

						elseif ( is_post_type_archive( 'contributor' ) ) :
							_e( 'Contributors');

						elseif ( is_post_type_archive( 'series' ) ) :
							_e( 'Series');

						else :
							_e( 'Archives' );

						endif;
					?>
				</h1>
                
				<?php
					// Show an optional term description.
					$term_description = term_description();
                    $descriptions = get_option( 'bookswp_descs' );
					if ( ! empty( $term_description ) ) {
						printf( '<div class="taxonomy-description">%s</div>', $term_description );
                    } elseif ( is_post_type_archive( 'book' ) || is_tax( 'AZ_book' ) ) {
                        if ( $descriptions['book_desc'] != "" ) { echo '<div class="taxonomy-description"><p>' . $descriptions['book_desc'] . '</p></div>'; };
                    } elseif ( is_post_type_archive( 'contributor' ) || is_tax( 'AZ_contributor' ) ) {
                        if ( $descriptions['contr_desc'] != "" ) { echo '<div class="taxonomy-description"><p>' . $descriptions['contr_desc'] . '</p></div>'; };
                    } elseif ( is_post_type_archive( 'series' ) ) {
                        if ( $descriptions['series_desc'] != "" ) { echo '<div class="taxonomy-description"><p>' . $descriptions['series_desc'] . '</p></div>'; };
                    }
				?>
			</header><!-- .page-header -->
            
            <?php
                if ( is_post_type_archive( 'book' ) ||is_tax( 'AZ_book' ) || is_tax( 'genre' ) ) {
                        bookswp_browse_list( 'book' );
                } elseif ( is_post_type_archive( 'contributor' ) || is_tax( 'AZ_contributor' ) || is_tax( 'role' ) ) {
                        bookswp_browse_list( 'contributor' );
                }
                    
            ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', 'search' );
				?>

			<?php endwhile; ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

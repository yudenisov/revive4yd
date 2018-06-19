<?php
/**
 * The template for displaying all page with a Blog Style.
 * Template Name: Blog (Standard Layout)
 *
 * @package revive
 */

get_header(); ?>

	<div id="primary" class="content-areas <?php do_action('revive_primary-width') ?>">
		<main id="main" class="site-main" role="main">
		<?php wp_reset_query(); 
			  wp_reset_postdata();
			  $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
			  $cat = get_post_meta( get_the_ID(), 'choose-category', true );
			$qa = array (
				'post_type'              => 'post',
				'offset'				 => 0,
				'ignore_sticky_posts'    => false,
				'paged' 				 => $paged,
				'cat'  					 => $cat, //POSSIBLE SOURCE of ERROR when $cat = all_c
	
			);
		
		// The Query
		$recent_articles = new WP_Query( $qa );
		if ( $recent_articles->have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( $recent_articles->have_posts() ) : $recent_articles->the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 */
					get_template_part('framework/layouts/content', 'grid');  
					
				?>

			<?php endwhile; ?>
			<?php revive_pagination_queried( $recent_articles ); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

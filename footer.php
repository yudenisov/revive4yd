<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package revive
 */
?>

		</div><!-- #content -->
	
	</div><!--.mega-container-->
	
	<nav id="site-navigation" class="main-navigation" role="navigation">
		<div class="container">
			<?php wp_nav_menu( array( 'theme_location' => 'bottom' ) ); ?>
		</div>
	</nav><!-- #site-navigation -->

	<?php get_sidebar('footer'); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
<!-- Added -->
<?php include_once("bottom_analytics.php"); ?>
<!-- /Added -->
		<div class="site-info container">
			<?php if ( !get_theme_mod('revive_link_remove') ) : ?>
			<?php printf( __( 'Theme Designed by %1$s.', 'revive' ), '<a href="'.esc_url("https://inkhive.com/").'" rel="designer">InkHive Themes</a>' ); ?>
			<?php endif; ?>
			<span class="sep"></span>
			<?php echo ( get_theme_mod('revive_footer_text') == '' ) ? ('&copy; '.date('Y').' '.get_bloginfo('name').__('. All Rights Reserved. ','revive')) : get_theme_mod('revive_footer_text'); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
	
</div><!-- #page -->

<script><?php echo get_theme_mod('revive_analytics'); ?></script>
<?php wp_footer(); ?>

</body>
</html>
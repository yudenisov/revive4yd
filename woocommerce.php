<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package revive
 */

get_header(); ?>

	<div id="primary-mono" class="content-area <?php do_action('revive_primary-width') ?> page">
		<main id="main" class="site-main" role="main">

                <?php woocommerce_content(); ?>

                <!-- Insert Additional contact field -->
                <?php
                $root = $_SERVER['DOCUMENT_ROOT'];
                $contact_field = $root."/contact_field.inc";
                if (file_exists($contact_field))
                    include_once($contact_field);

                ?>
                <!-- /Insert Additional contact field -->


		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

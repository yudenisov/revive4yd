<?php
/*
 * @package revive, Copyright Rohit Tripathi, rohitink.com
 * This file contains Custom Theme Related Functions.
 */
 
/*
** Walkers for Navigation menus
*/ 


/*
 * Pagination Function. Implements core paginate_links function.
 */
function revive_pagination() {
	global $wp_query;
	$big = 12345678;
	$page_format = paginate_links( array(
	    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	    'format' => '?paged=%#%',
	    'current' => max( 1, get_query_var('paged') ),
	    'total' => $wp_query->max_num_pages,
	    'type'  => 'array'
	) );
	if( is_array($page_format) ) {
	            $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
	            echo '<div class="pagination"><div><ul>';
	            echo '<li><span>'. $paged . __(' of ','revive') . $wp_query->max_num_pages .'</span></li>';
	            foreach ( $page_format as $page ) {
	                    echo "<li>$page</li>";
	            }
	           echo '</ul></div></div>';
	 }
}

//Quick Fixes for Custom Post Types.
function revive_pagination_queried( $query ) {
	$big = 12345678;
	$page_format = paginate_links( array(
	    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	    'format' => '?paged=%#%',
	    'current' => max( 1, get_query_var('paged') ),
	    'total' => $query->max_num_pages,
	    'type'  => 'array'
	) );
	if( is_array($page_format) ) {
	            $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
	            echo '<div class="pagination"><div><ul>';
	            echo '<li><span>'. $paged . ' of ' . $query->max_num_pages .'</span></li>';
	            foreach ( $page_format as $page ) {
	                    echo "<li>$page</li>";
	            }
	           echo '</ul></div></div>';
	 }
}

/*
** Favicon and Apple Touch Icon
*/
function revive_header_icons() {
	if ( get_theme_mod('revive_apple_icon') ) 	
		echo "<link rel='apple-touch-icon' href='".get_theme_mod('revive_apple_icon')."'>";
}
add_action('wp_head', 'revive_header_icons');


/*
** Customizer Controls 
*/
if (class_exists('WP_Customize_Control')) {
	class WP_Customize_Category_Control extends WP_Customize_Control {
        /**
         * Render the control's content.
         */
        public function render_content() {
            $dropdown = wp_dropdown_categories(
                array(
                    'name'              => '_customize-dropdown-categories-' . $this->id,
                    'echo'              => 0,
                    'show_option_none'  => __( '&mdash; Select &mdash;', 'revive' ),
                    'option_none_value' => '0',
                    'selected'          => $this->value(),
                )
            );
 
            $dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );
 
            printf(
                '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $dropdown
            );
        }
    }
}  

if (class_exists('WP_Customize_Control')) {
	class WP_Customize_Upgrade_Control extends WP_Customize_Control {
        /**
         * Render the control's content.
         */
        public function render_content() {
             printf(
                '<label class="customize-control-upgrade"><span class="customize-control-title">%s</span> %s</label>',
                $this->label,
                $this->description
            );
        }
    }
}
  
/*
** Function to check if Sidebar is enabled on Current Page 
*/
function revive_load_sidebar() {
	wp_reset_postdata();
	$load_sidebar = true;
	if ( get_theme_mod('revive_disable_sidebar') ) :
		$load_sidebar = false;
	elseif( get_theme_mod('revive_disable_sidebar_home') && is_home() )	:
		$load_sidebar = false;
	elseif( get_theme_mod('revive_disable_sidebar_front') && is_front_page() ) :
		$load_sidebar = false;
	elseif( get_theme_mod('revive_disable_sidebar_archive') && is_archive() ) :
		$load_sidebar = false;	
	elseif ( get_post_meta( get_the_ID(), 'enable-full-width', true ) )	:
		$load_sidebar = false;
	endif;
	
	return  $load_sidebar;
}

/*
**	Determining Sidebar and Primary Width
*/
function revive_primary_class() {
	$sw = get_theme_mod('revive_sidebar_width',4);
	$class = "col-md-".(12-$sw);
	
	if ( !revive_load_sidebar() ) 
		$class = "col-md-12";
	
	echo $class;
}
add_action('revive_primary-width', 'revive_primary_class');

function revive_secondary_class() {
	$sw = get_theme_mod('revive_sidebar_width',4);
	$class = "col-md-".$sw;
	if ( !revive_load_sidebar() ) 
		$class = 'hidden';
		
	echo $class;
}
add_action('revive_secondary-width', 'revive_secondary_class');


/*
**	Helper Function to Convert Colors
*/
function revive_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);
   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return implode(",", $rgb); // returns the rgb values separated by commas
   //return $rgb; // returns an array with the rgb values
}
function revive_fade($color, $val) {
	return "rgba(".revive_hex2rgb($color).",". $val.")";
}


/*
** Function to Get Theme Layout 
*/
function revive_get_blog_layout(){
	$ldir = 'framework/layouts/content';
	if (get_theme_mod('revive_blog_layout') ) :
		get_template_part( $ldir , get_theme_mod('revive_blog_layout') );
	else :
		get_template_part( $ldir ,'grid');	
	endif;	
}
add_action('revive_blog_layout', 'revive_get_blog_layout');

/*
** Function to Deal with Elements of Inequal Heights, Enclose them in a bootstrap row.
*/
function revive_open_div_row() {
	echo "<div class='row grid-row col-md-12'>";
}
function revive_close_div_row() {
	echo "</div><!--.grid-row-->";
}


function revive_before_article() {

	global $revive_post_count;
	$array_2_3_4 = array('grid_2_column',
							'grid_3_column',
							'grid_4_column',						
							'templates/template-blog-grid3c.php',
							'templates/template-blog-grid2c.php', 
							'templates/template-blog-grid4c.php',
						);
	//wp_reset_postdata();	- Don't Reset any Data, because we are not using get_post_meta	
	//See what the get_queried_object_id() function does. Though, the Query is reset in template files.			
	//For 2,3,4 Column Posts
	 $page_template = get_post_meta( get_queried_object_id(), '_wp_page_template', true );
	if ( in_array( get_theme_mod('revive_blog_layout'), $array_2_3_4 ) || in_array( $page_template, $array_2_3_4 ) ) : 
			 if ( $revive_post_count  == 0 ) {
			  	revive_open_div_row();
			  }
	endif;	  	
}
add_action('revive_before-article', 'revive_before_article');

/* Pre and Post Article Hooking */
function revive_after_article() {
	global $revive_post_count;
	//echo $revive_post_count;
	wp_reset_postdata();
	$template = get_post_meta( get_the_id(), '_wp_page_template', true );
	//For 3 Column Posts
	if (   ( get_theme_mod('revive_blog_layout') == 'grid_3_column' ) 
 		|| ( $template == 'templates/template-blog-grid3c.php' ) ):
		
		

		global $wp_query;
		if (($wp_query->current_post +1) == ($wp_query->post_count)) :
			 	revive_close_div_row();
		else :
			if ( ( $revive_post_count ) == 2 ) {
			 	revive_close_div_row();
				$revive_post_count = 0;
				}
			else {
				$revive_post_count++;
			}
		endif;		
		
	//For 2 Column Posts
	elseif ( ( get_theme_mod('revive_blog_layout') == 'grid_2_column' )
		|| ( $template == 'templates/template-blog-grid2c.php' ) ):
		
		
		
		global $wp_query;
		if (($wp_query->current_post +1) == ($wp_query->post_count)) :
			 	revive_close_div_row();
			 	$revive_post_count = 0;
		else :
			if ( ( $revive_post_count ) == 1 ) {
			 	revive_close_div_row();
				$revive_post_count = 0;
				}
			else {
				$revive_post_count++;
			}
		endif;		
	
	elseif ( ( get_theme_mod('revive_blog_layout') == 'grid_4_column' )
		|| ( $template == 'templates/template-blog-grid4c.php' ) ):
		
		
		
		global $wp_query;
		if (($wp_query->current_post +1) == ($wp_query->post_count)) :
			 	revive_close_div_row();
		else :
			if ( ( $revive_post_count ) == 3 ) {
			 	revive_close_div_row();
				$revive_post_count = 0;
				}
			else {
				$revive_post_count++;
			}
		endif;		
	endif;
	
}
add_action('revive_after-article', 'revive_after_article');

/*
** Function to check if Component is Enabled.
*/
function revive_is_enabled( $component ) {
	
	wp_reset_postdata();
	$return_val = false;
	
	switch ($component) {
		
		case 'slider' :
		
			if ( ( get_theme_mod('revive_main_slider_enable' ) && is_home() )
				||( get_post_meta( get_the_ID(), 'enable-slider', true ) ) ) :
					$return_val = true;
			endif;
			break;
		
		case 'fa2' :
		
			if ( ( get_theme_mod('revive_fa2_enable') && is_home() )
				|| ( get_post_meta( get_the_ID(), 'enable-fa2', true ) ) ) :
					$return_val = true;
				endif;
				break;
		
		case 'box' :
		
			 if ( ( get_theme_mod('revive_box_enable') && is_home() )
			 	|| ( get_post_meta( get_the_ID(), 'enable-box', true ) ) ) : 
			 		$return_val = true;
			 	endif;
			 	break;	
			 	
		case 'triangle' :
			
			 if ( ( get_theme_mod('revive_slbox_enable') && is_home() )
			 	|| ( get_post_meta( get_the_ID(), 'enable-slbox', true ) ) ) : 
			 		$return_val = true;
			 	endif;
			 	break;	
			 	
		case 'categories' :
			
			 if ( ( get_theme_mod('revive_fcats_enable') && is_home() )
			 	|| ( get_post_meta( get_the_ID(), 'enable-fcats', true ) ) ) : 
			 		$return_val = true;
			 	endif;
			 	break;		 	
					 		 		
									
	}//endswitch
	
	return $return_val;
	
}

/*
**	Hook Just before content. To Display Featured Content and Slider.
*/
function revive_display_fc() {
	
		if  ( revive_is_enabled( 'slider' ) )
			get_template_part('slider', 'nivo' );
			
		if  ( revive_is_enabled( 'box' ) )	
			get_template_part('featured', 'area1');	
			
		if  ( revive_is_enabled( 'fa2' ) )	
			get_template_part('featured', 'area2'); 
			
		if  ( revive_is_enabled( 'triangle' ) )	
			get_template_part('featured', 'triangle'); 	
			
		if  ( revive_is_enabled( 'categories' ) )	
			get_template_part('featured', 'categories'); 		
		
}
add_action('revive_after-mega-container', 'revive_display_fc');

/*
** ProtoPress Render Slider
*/
function revive_render_slider() {
	$revive_slider = array(
		'pager' => get_theme_mod('revive_slider_pager', true ),
		'animSpeed' => get_theme_mod('revive_slider_speed', 500 ),
		'pauseTime' => get_theme_mod('revive_slider_pause', 5000 ),
		'autoplay' => !get_theme_mod('revive_slider_autoplay', true ),
		'random' => get_theme_mod('revive_slider_random', false ),
		'effect' => get_theme_mod('revive_slider_effect', 'random' )
	);
	wp_localize_script( 'revive-custom-js', 'slider_object', $revive_slider );
}
add_action('wp_enqueue_scripts', 'revive_render_slider', 20);

/*
** Load Custom Widgets
*/
require get_template_directory() . '/framework/widgets/recent-posts.php';
require get_template_directory() . '/framework/widgets/video.php';
require get_template_directory() . '/framework/widgets/featured-posts.php';

/**
 * Include Meta Boxes.
 */
require get_template_directory() . '/framework/metaboxes/page-attributes.php';
require get_template_directory() . '/framework/metaboxes/display-options.php';

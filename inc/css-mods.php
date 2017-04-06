<?php
/* 
**   Custom Modifcations in CSS depending on user settings.
*/

function revive_custom_css_mods() {

	echo "<style id='custom-css-mods'>";
	
	//If Highlighting Nav active item is disabled
	if ( get_theme_mod('revive_disable_active_nav') ) :
		echo "#site-navigation ul .current_page_item > a, #site-navigation ul .current-menu-item > a, #site-navigation ul .current_page_ancestor > a { border:none; background: inherit; }"; 
	endif;
	
	//If Title and Desc is set to Show Below the Logo
	if (  get_theme_mod('revive_branding_below_logo') ) :
		
		echo "#masthead #text-title-desc { display: block; clear: both; } ";
		
	endif;
	
	//If Logo is Centered
	if ( get_theme_mod('revive_center_logo',true) ) :
		
		echo "#masthead #text-title-desc, #masthead #site-logo { float: none; } .site-branding { text-align: center; } #text-title-desc { display: inline-block; }";
		
	endif;
	
	//Exception: When Logo is Centered, and Title Not Set to display in next line.
	if ( get_theme_mod('revive_center_logo') && !get_theme_mod('revive_branding_below_logo') ) :
		echo ".site-branding #text-title-desc { text-align: left; }";
	endif;
	
	//Exception: When Logo is centered, but there is no logo.
	if ( get_theme_mod('revive_center_logo') && !get_theme_mod('revive_logo') ) :
		echo ".site-branding #text-title-desc { text-align: center; }";
	endif;
	
	//Exception: IMage transform origin should be left on Left Alignment, i.e. Default
	if ( !get_theme_mod('revive_center_logo') ) :
		echo "#masthead #site-logo img { transform-origin: left; }";
	endif;	
	
	
	if ( get_theme_mod('revive_title_font') ) :
		echo ".title-font, h1, h2, .section-title { font-family: ".get_theme_mod('revive_title_font','Lato')."; }";
	endif;
	
	if ( get_theme_mod('revive_body_font') ) :
		echo "body { font-family: ".get_theme_mod('revive_body_font','Lato')."; }";
	endif;
	
	if ( get_theme_mod('revive_site_titlecolor') ) :
		echo "#masthead h1.site-title a { color: ".get_theme_mod('revive_site_titlecolor', '#FFF')."; }";
	endif;
	
	
	if ( get_theme_mod('revive_header_desccolor','#777') ) :
		echo "#masthead h2.site-description { color: ".get_theme_mod('revive_header_desccolor','#FFF')."; }";
	endif;
	
	wp_reset_postdata();	
	if ( get_post_meta( get_the_ID(), 'hide-title', true ) ):
		echo "#primary-mono h1.entry-title { display: none; }";
	endif;	
		
	if ( get_theme_mod('revive_sidebar_loc') == 'left' ) :
		echo "#secondary { float: left; }#primary,#primary-mono { float: right; }";
	endif;	
	
	if ( get_theme_mod('revive_site_layout') == 'boxed' ) :
		echo "#page { max-width: 1170px; margin: 20px auto; }";
	endif;
	
	if ( get_theme_mod('revive_custom_css') ) :
		echo  get_theme_mod('revive_custom_css');
	endif;
	
	
	if ( get_theme_mod('revive_hide_title_tagline') ) :
		echo "#masthead .site-branding #text-title-desc { display: none; }";
	endif;
	
	if ( get_theme_mod('revive_logo_resize') ) :
		$val = get_theme_mod('revive_logo_resize')/100;
		echo "#masthead #site-logo img { transform: scale(".$val."); -webkit-transform: scale(".$val."); -moz-transform: scale(".$val."); -ms-transform: scale(".$val."); }";
		endif;
	
	//THE ACCENTE`
	if ( get_theme_mod('revive_accent') ) :
		$a = get_theme_mod('revive_accent');
		?>
			a, a:hover,
			#secondary h1.widget-title,
			#footer-sidebar .footer-column h1.widget-title,
			#secondary .widget_recent_entries ul li:before, #secondary .widget_recent_comments ul li:before, #secondary .widget_categories ul li:before, #secondary .widget_pages ul li:before, #secondary .widget_archive ul li:before, #secondary .widget_meta ul li:before, #secondary .widget_nav_menu ul li:before,
			#footer-sidebar .footer-column .widget_recent_entries ul li:before, #footer-sidebar .footer-column .widget_recent_comments ul li:before, #footer-sidebar .footer-column .widget_categories ul li:before, #footer-sidebar .footer-column .widget_pages ul li:before, #footer-sidebar .footer-column .widget_archive ul li:before, #footer-sidebar .footer-column .widget_meta ul li:before, #footer-sidebar .footer-column .widget_nav_menu ul li:before,
			#primary-mono .entry-meta .author a
			 {
				color: <?php echo $a; ?>;
			}

			.featured-2 .popular-articles .titledesc a,
			.grid .hvr-underline-from-center:before,
			#secondary h1.widget-title:after,
			#secondary .widget_tag_cloud .tagcloud a,
			#footer-sidebar .footer-column .widget_tag_cloud .tagcloud a,
			#primary-mono h1.entry-title:after,
			.section-title:after,
			#featured-area-1 .imgcontainer .postdate,
			#featured-categories .cat-name span,
			#site-navigation ul li:hover a,
			#site-navigation ul li ul.sub-menu, #site-navigation ul li ul.children,
			#site-navigation ul .current_page_item > a, #site-navigation ul .current-menu-item > a, #site-navigation ul .current_page_ancestor > a,
			#primary-mono .entry-meta .postdate,
			#social-icons .social-icon:hover,
			.revive .postdate
			 {
				background: <?php echo $a; ?>;
			}
			#site-navigation,
			#site-navigation ul li ul.sub-menu a:hover, #site-navigation ul li ul.children a:hover {
				background: <?php echo revive_fade( $a , 0.9 ); ?>;
			}
			.nav-arrows a a {
				box-shadow: 0px 0px 1px <?php echo $a; ?>;
			}
			
			#featured-triangle .imgcontainer .popimage,
			#search-icon #searchicon,
			#social-icons .social-icon,
			#social-icons .social-icon:before
			{
				border-color: <?php echo $a; ?>;
			}
			
			
			.grid .featured-thumb,
			#featured-triangle .imgcontainer .postdate,
			#primary-mono .entry-meta .postdate:after  {
				border-top-color: <?php echo $a; ?>;
			}
			#featured-triangle .imgcontainer .postdate,
			#primary-mono .entry-meta .postdate:after  {
				border-right-color: <?php echo $a; ?>;
			}
			#featured-area-1 .imgcontainer .postdate:after,
			#featured-triangle .imgcontainer .postdate  {
				border-left-color: <?php echo $a; ?>;
			}
			#featured-area-1 .imgcontainer .postdate:after {
				border-bottom-color: <?php echo $a; ?>;
			}
			.photos_2_column .out-thumb
			{
				border-bottom-color: <?php echo revive_fade( $a, 0.7 ); ?>;
			}
			
			.pagination ul > li > a:hover,
			#secondary .widget a:hover,
			#footer-sidebar .footer-column .widget a:hover,
			#primary-mono .entry-meta a:hover,
			#primary-mono .entry-footer a:hover ,
			#primary-mono .nav-links a:hover,
			#primary-mono .entry-content a:hover,
			#masthead h1.site-title a:hover{
				color: <?php echo $a; ?>;
			}
			#respond [class^="comment-form"] label {
				background: <?php echo $a; ?>;
				border-bottom-color: <?php echo $a; ?>;
			}
			#respond .form-submit input[type=submit] {
				color: <?php echo $a; ?>;
			}
	
	<?php
		$hex = get_theme_mod('revive_accent');
		$rgb = revive_hex2rgb($hex);
		$rgb = explode(',', $rgb);
		
		echo ".widget_tag_cloud .tagcloud a, #primary-mono .entry-meta .postdate,
			#featured-area-1 .imgcontainer .postdate,
			#featured-categories .cat-name span,
			#site-navigation ul li:hover a,
			#site-navigation ul li ul.sub-menu, #site-navigation ul li ul.children,
			#site-navigation ul .current_page_item > a, #site-navigation ul .current-menu-item > a, #site-navigation ul .current_page_ancestor > a,
			#primary-mono .entry-meta .postdate,
			#social-icons .social-icon:hover,
			.revive .postdate { ";
		
		if ( $rgb[0] + $rgb[1] + $rgb[2] > 382 ) {
		    echo "color: #222 !important;";
		} else {
		    echo  "color: #fff !important;";
		}
		
		echo "}";
		
	endif;	

	echo "</style>";
}

add_action('wp_head', 'revive_custom_css_mods');
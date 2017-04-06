<?php
/**
 * revive Theme Customizer
 *
 * @package revive
 */
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function revive_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	//Basic Theme Settings
	$wp_customize->add_section( 'revive_basic_settings' , array(
	    'title'      => __( 'Basic Settings', 'revive' ),
	    'priority'   => 30,
	) );
	
	
	$wp_customize->add_setting( 'revive_apple_icon' , array(
	    'default'     => '',
	    'sanitize_callback' => 'esc_url_raw',
	) );
	
	$wp_customize->add_control(
	    new WP_Customize_Image_Control(
	        $wp_customize,
	        'revive_apple_icon',
	        array(
	            'label' => 'Upload Apple Touch Icon',
	            'section' => 'revive_basic_settings',
	            'settings' => 'revive_apple_icon',
	            'priority' => 5,
	        )
		)
	);
	
	$wp_customize->add_setting( 'revive_disable_featimg' , array(
	    'default'     => false,
	    'sanitize_callback' => 'revive_sanitize_checkbox',
	) );
	
	$wp_customize->add_control(	   
        'revive_disable_featimg',
        array(
            'label' => 'Disable Featured Images on Posts.',
            'description' => 'This will Remove the Featured Images from Showing up on Individual Posts, however, it will not remove it from homepage and other elements.',
            'section' => 'revive_basic_settings',
            'settings' => 'revive_disable_featimg',
            'priority' => 5,
            'type' => 'checkbox',
        )
	);
	
	$wp_customize->add_setting( 'revive_disable_nextprev' , array(
	    'default'     => true,
	    'sanitize_callback' => 'revive_sanitize_checkbox',
	) );
	
	
	
	$wp_customize->add_control(	   
        'revive_disable_nextprev',
        array(
            'label' => 'Disable Next/Prev Posts on Single Posts.',
            'description' => 'This will Remove the the link to next and previous posts on all posts.',
            'section' => 'revive_basic_settings',
            'settings' => 'revive_disable_nextprev',
            'priority' => 5,
            'type' => 'checkbox',
        )
	);
	
	//Logo Settings
	$wp_customize->add_section( 'title_tagline' , array(
	    'title'      => __( 'Title, Tagline & Logo', 'revive' ),
	    'priority'   => 30,
	) );
	
	$wp_customize->add_setting( 'revive_logo' , array(
	    'default'     => '',
	    'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control(
	    new WP_Customize_Image_Control(
	        $wp_customize,
	        'revive_logo',
	        array(
	            'label' => __('Upload Logo','revive'),
	            'section' => 'title_tagline',
	            'settings' => 'revive_logo',
	            'priority' => 5,
	        )
		)
	);
	
	$wp_customize->add_setting( 'revive_logo_resize' , array(
	    'default'     => 100,
	    'sanitize_callback' => 'revive_sanitize_positive_number',
	) );
	$wp_customize->add_control(
	        'revive_logo_resize',
	        array(
	            'label' => __('Resize & Adjust Logo','revive'),
	            'section' => 'title_tagline',
	            'settings' => 'revive_logo_resize',
	            'priority' => 6,
	            'type' => 'range',
	            'active_callback' => 'revive_logo_enabled',
	            'input_attrs' => array(
			        'min'   => 30,
			        'max'   => 200,
			        'step'  => 5,
			    ),
	        )
	);
	
	function revive_logo_enabled($control) {
		$option = $control->manager->get_setting('revive_logo');
		return $option->value() == true;
	}
	
	
	
	//Replace Header Text Color with, separate colors for Title and Description
	//Override revive_site_titlecolor
	$wp_customize->remove_control('display_header_text');
	$wp_customize->remove_setting('header_textcolor');
	$wp_customize->add_setting('revive_site_titlecolor', array(
	    'default'     => '#FFF',
	    'sanitize_callback' => 'sanitize_hex_color',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize, 
		'revive_site_titlecolor', array(
			'label' => __('Site Title Color','revive'),
			'section' => 'colors',
			'settings' => 'revive_site_titlecolor',
			'type' => 'color'
		) ) 
	);
	
	$wp_customize->add_setting('revive_header_desccolor', array(
	    'default'     => '#FFF',
	    'sanitize_callback' => 'sanitize_hex_color',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize, 
		'revive_header_desccolor', array(
			'label' => __('Site Tagline Color','revive'),
			'section' => 'colors',
			'settings' => 'revive_header_desccolor',
			'type' => 'color'
		) ) 
	);
	
	//Settings for Nav Area
	$wp_customize->add_setting( 'revive_disable_active_nav' , array(
	    'default'     => true,
	    'sanitize_callback' => 'revive_sanitize_checkbox',
	) );
	
	$wp_customize->add_control(
	'revive_disable_active_nav', array(
		'label' => __('Disable Highlighting of Current Active Item on the Menu.','revive'),
		'section' => 'nav',
		'settings' => 'revive_disable_active_nav',
		'type' => 'checkbox'
	) );
	
	//Settings for Header Image
	$wp_customize->add_setting( 'revive_himg_style' , array(
	    'default'     => true,
	    'sanitize_callback' => 'revive_sanitize_himg_style'
	) );
	
	/* Sanitization Function */
	function revive_sanitize_himg_style( $input ) {
		if (in_array( $input, array('contain','cover') ) )
			return $input;
		else
			return '';	
	}
	
	$wp_customize->add_control(
	'revive_himg_style', array(
		'label' => __('Header Image Arrangement','revive'),
		'section' => 'header_image',
		'settings' => 'revive_himg_style',
		'type' => 'select',
		'choices' => array(
				'contain' => __('Contain','revive'),
				'cover' => __('Cover Completely','revive'),
				)
	) );
	
	$wp_customize->add_setting( 'revive_himg_align' , array(
	    'default'     => true,
	    'sanitize_callback' => 'revive_sanitize_himg_align'
	) );
	
	/* Sanitization Function */
	function revive_sanitize_himg_align( $input ) {
		if (in_array( $input, array('center','left','right') ) )
			return $input;
		else
			return '';	
	}
	
	$wp_customize->add_control(
	'revive_himg_align', array(
		'label' => __('Header Image Alignment','revive'),
		'section' => 'header_image',
		'settings' => 'revive_himg_align',
		'type' => 'select',
		'choices' => array(
				'center' => __('Center','revive'),
				'left' => __('Left','revive'),
				'right' => __('Right','revive'),
			)
		
	) );
	
	$wp_customize->add_setting( 'revive_himg_repeat' , array(
	    'default'     => true,
	    'sanitize_callback' => 'revive_sanitize_checkbox'
	) );
	
	$wp_customize->add_control(
	'revive_himg_repeat', array(
		'label' => __('Repeat Header Image','revive'),
		'section' => 'header_image',
		'settings' => 'revive_himg_repeat',
		'type' => 'checkbox',
	) );
	
	
	//Settings For Logo Area
	
	$wp_customize->add_setting(
		'revive_hide_title_tagline',
		array( 'sanitize_callback' => 'revive_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'revive_hide_title_tagline', array(
		    'settings' => 'revive_hide_title_tagline',
		    'label'    => __( 'Hide Title and Tagline.', 'revive' ),
		    'section'  => 'title_tagline',
		    'type'     => 'checkbox',
		)
	);
	
	$wp_customize->add_setting(
		'revive_branding_below_logo',
		array( 'sanitize_callback' => 'revive_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'revive_branding_below_logo', array(
		    'settings' => 'revive_branding_below_logo',
		    'label'    => __( 'Display Site Title and Tagline Below the Logo.', 'revive' ),
		    'section'  => 'title_tagline',
		    'type'     => 'checkbox',
		    'active_callback' => 'revive_title_visible'
		)
	);
	
	function revive_title_visible( $control ) {
		$option = $control->manager->get_setting('revive_hide_title_tagline');
	    return $option->value() == false ;
	}
	
	$wp_customize->add_setting(
		'revive_center_logo',
		array( 
			'sanitize_callback' => 'revive_sanitize_checkbox',
			'default' => true )
	);
	
	$wp_customize->add_control(
			'revive_center_logo', array(
		    'settings' => 'revive_center_logo',
		    'label'    => __( 'Center Align.', 'revive' ),
		    'section'  => 'title_tagline',
		    'type'     => 'checkbox',
		)
	);
	
	
	
	// SLIDER PANEL
	$wp_customize->add_panel( 'revive_slider_panel', array(
	    'priority'       => 35,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	    'title'          => 'Main Slider',
	) );
	
	$wp_customize->add_section(
	    'revive_sec_slider_options',
	    array(
	        'title'     => 'Enable/Disable',
	        'priority'  => 0,
	        'panel'     => 'revive_slider_panel'
	    )
	);
	
	
	$wp_customize->add_setting(
		'revive_main_slider_enable',
		array( 'sanitize_callback' => 'revive_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'revive_main_slider_enable', array(
		    'settings' => 'revive_main_slider_enable',
		    'label'    => __( 'Enable Slider.', 'revive' ),
		    'section'  => 'revive_sec_slider_options',
		    'type'     => 'checkbox',
		)
	);
	
	$wp_customize->add_setting(
		'revive_main_slider_count',
			array(
				'default' => '0',
				'sanitize_callback' => 'revive_sanitize_positive_number'
			)
	);
	
	// Select How Many Slides the User wants, and Reload the Page.
	$wp_customize->add_control(
			'revive_main_slider_count', array(
		    'settings' => 'revive_main_slider_count',
		    'label'    => __( 'No. of Slides(Min:0, Max: 10)' ,'revive'),
		    'section'  => 'revive_sec_slider_options',
		    'type'     => 'number',
		    'description' => __('Save the Settings, and Reload this page to Configure the Slides.','revive'),
		    
		)
	);
		
	
	if ( get_theme_mod('revive_main_slider_count') > 0 ) :
		$slides = get_theme_mod('revive_main_slider_count');
		
		for ( $i = 1 ; $i <= $slides ; $i++ ) :
			
			//Create the settings Once, and Loop through it.
			
			$wp_customize->add_setting(
				'revive_slide_img'.$i,
				array( 'sanitize_callback' => 'esc_url_raw' )
			);
			
			$wp_customize->add_control(
			    new WP_Customize_Image_Control(
			        $wp_customize,
			        'revive_slide_img'.$i,
			        array(
			            'label' => '',
			            'section' => 'revive_slide_sec'.$i,
			            'settings' => 'revive_slide_img'.$i,			       
			        )
				)
			);
			
			
			$wp_customize->add_section(
			    'revive_slide_sec'.$i,
			    array(
			        'title'     => 'Slide '.$i,
			        'priority'  => $i,
			        'panel'     => 'revive_slider_panel'
			    )
			);
			
			$wp_customize->add_setting(
				'revive_slide_title'.$i,
				array( 'sanitize_callback' => 'sanitize_text_field' )
			);
			
			$wp_customize->add_control(
					'revive_slide_title'.$i, array(
				    'settings' => 'revive_slide_title'.$i,
				    'label'    => __( 'Slide Title','revive' ),
				    'section'  => 'revive_slide_sec'.$i,
				    'type'     => 'text',
				)
			);
			
			$wp_customize->add_setting(
				'revive_slide_desc'.$i,
				array( 'sanitize_callback' => 'sanitize_text_field' )
			);
			
			$wp_customize->add_control(
					'revive_slide_desc'.$i, array(
				    'settings' => 'revive_slide_desc'.$i,
				    'label'    => __( 'Slide Description','revive' ),
				    'section'  => 'revive_slide_sec'.$i,
				    'type'     => 'text',
				)
			);
			
			
			
			$wp_customize->add_setting(
				'revive_slide_CTA_button'.$i,
				array( 'sanitize_callback' => 'sanitize_text_field' )
			);
			
			$wp_customize->add_control(
					'revive_slide_CTA_button'.$i, array(
				    'settings' => 'revive_slide_CTA_button'.$i,
				    'label'    => __( 'Custom Call to Action Button Text(Optional)','revive' ),
				    'section'  => 'revive_slide_sec'.$i,
				    'type'     => 'text',
				)
			);
			
			$wp_customize->add_setting(
				'revive_slide_url'.$i,
				array( 'sanitize_callback' => 'esc_url_raw' )
			);
			
			$wp_customize->add_control(
					'revive_slide_url'.$i, array(
				    'settings' => 'revive_slide_url'.$i,
				    'label'    => __( 'Target URL','revive' ),
				    'section'  => 'revive_slide_sec'.$i,
				    'type'     => 'url',
				)
			);
			
		endfor;
	
	
	endif;
	
	//Slider Config
	$wp_customize->add_section(
	    'revive_slider_config',
	    array(
	        'title'     => __('Configure Slider','revive'),
	        'priority'  => 0,
	        'panel'     => 'revive_slider_panel'
	    )
	);
	
	$wp_customize->add_setting(
		'revive_slider_pause',
			array(
				'default' => 5000,
				'sanitize_callback' => 'revive_sanitize_positive_number'
			)
	);
	
	$wp_customize->add_control(
			'revive_slider_pause', array(
		    'settings' => 'revive_slider_pause',
		    'label'    => __( 'Time Between Each Slide.' ,'revive'),
		    'section'  => 'revive_slider_config',
		    'type'     => 'number',
		    'description' => __('Value in Milliseconds. Default: 5000.','revive'),
		    
		)
	);
	
	$wp_customize->add_setting(
		'revive_slider_speed',
			array(
				'default' => 500,
				'sanitize_callback' => 'revive_sanitize_positive_number'
			)
	);
	
	$wp_customize->add_control(
			'revive_slider_speed', array(
		    'settings' => 'revive_slider_speed',
		    'label'    => __( 'Animation Speed.' ,'revive'),
		    'section'  => 'revive_slider_config',
		    'type'     => 'number',
		    'description' => __('Value in Milliseconds. Default: 500.','revive'),
		    
		)
	);
	
	$wp_customize->add_setting(
		'revive_slider_random',
			array(
				'default' => false,
				'sanitize_callback' => 'revive_sanitize_checkbox'
			)
	);
	
	$wp_customize->add_control(
			'revive_slider_random', array(
		    'settings' => 'revive_slider_random',
		    'label'    => __( 'Start Slider from Random Slide.' ,'revive'),
		    'section'  => 'revive_slider_config',
		    'type'     => 'checkbox',		    
		)
	);
	
	$wp_customize->add_setting(
		'revive_slider_pager',
			array(
				'default' => true,
				'sanitize_callback' => 'revive_sanitize_checkbox'
			)
	);
	
	$wp_customize->add_control(
			'revive_slider_pager', array(
		    'settings' => 'revive_slider_pager',
		    'label'    => __( 'Enable Pager.' ,'revive'),
		    'section'  => 'revive_slider_config',
		    'type'     => 'checkbox',
		    'description' => __('Pager is the Circles at the bottom, which represent current slide.','revive'),		    
		)
	);
	
	$wp_customize->add_setting(
		'revive_slider_autoplay',
			array(
				'default' => true, //Because, in nivo its Force Manual Transitions.
				'sanitize_callback' => 'revive_sanitize_checkbox'
			)
	);
	
	$wp_customize->add_control(
			'revive_slider_autoplay', array(
		    'settings' => 'revive_slider_autoplay',
		    'label'    => __( 'Enable Autoplay.' ,'revive'),
		    'section'  => 'revive_slider_config',
		    'type'     => 'checkbox',
		)
	);
	
	$wp_customize->add_setting(
		'revive_slider_effect',
			array(
				'default' => 'random',
				'sanitize_callback' => 'revive_sanitize_text'
			)
	);
	
	$earray=array('random','sliceDown','sliceDownLeft','sliceUp','sliceUpLeft','sliceUpDown',
		'sliceUpDownLeft','fold','fade','slideInRight','slideInLeft','boxRandom','boxRain','boxRainReverse','boxRainGrow','boxRainGrowReverse');
		$earray = array_combine($earray, $earray);
	
	$wp_customize->add_control(
			'revive_slider_effect', array(
		    'settings' => 'revive_slider_effect',
		    'label'    => __( 'Slider Animation Effect.' ,'revive'),
		    'section'  => 'revive_slider_config',
		    'type'     => 'select',
		    'choices' => $earray,
	) );

	
	// CREATE THE FCA PANEL
	$wp_customize->add_panel( 'revive_fca_panel', array(
	    'priority'       => 40,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	    'title'          => 'Featured Content Areas',
	    'description'    => '',
	) );
	
	
	//FEATURED AREA 1
	$wp_customize->add_section(
	    'revive_fc_boxes',
	    array(
	        'title'     => 'Featured Area 1',
	        'priority'  => 10,
	        'panel'     => 'revive_fca_panel'
	    )
	);
	
	$wp_customize->add_setting(
		'revive_box_enable',
		array( 'sanitize_callback' => 'revive_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'revive_box_enable', array(
		    'settings' => 'revive_box_enable',
		    'label'    => __( 'Enable Featured Area 1.', 'revive' ),
		    'section'  => 'revive_fc_boxes',
		    'type'     => 'checkbox',
		)
	);
	
 
	$wp_customize->add_setting(
		'revive_box_title',
		array( 'sanitize_callback' => 'sanitize_text_field' )
	);
	
	$wp_customize->add_control(
			'revive_box_title', array(
		    'settings' => 'revive_box_title',
		    'label'    => __( 'Title for the Boxes','revive' ),
		    'section'  => 'revive_fc_boxes',
		    'type'     => 'text',
		)
	);
 
 	$wp_customize->add_setting(
	    'revive_box_cat',
	    array( 'sanitize_callback' => 'revive_sanitize_category' )
	);
	
	$wp_customize->add_control(
	    new WP_Customize_Category_Control(
	        $wp_customize,
	        'revive_box_cat',
	        array(
	            'label'    => 'Category For Square Boxes.',
	            'settings' => 'revive_box_cat',
	            'section'  => 'revive_fc_boxes'
	        )
	    )
	);
	
	//FEATURED AREA 2
	$wp_customize->add_section(
	    'revive_fc_fa2',
	    array(
	        'title'     => 'Featured Area 2',
	        'priority'  => 10,
	        'panel'     => 'revive_fca_panel'
	    )
	);
	
	$wp_customize->add_setting(
		'revive_fa2_enable',
		array( 'sanitize_callback' => 'revive_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'revive_fa2_enable', array(
		    'settings' => 'revive_fa2_enable',
		    'label'    => __( 'Enable Featured Area 1.', 'revive' ),
		    'section'  => 'revive_fc_fa2',
		    'type'     => 'checkbox',
		)
	);
	
 
	$wp_customize->add_setting(
		'revive_fa2_title',
		array( 'sanitize_callback' => 'sanitize_text_field' )
	);
	
	$wp_customize->add_control(
			'revive_fa2_title', array(
		    'settings' => 'revive_fa2_title',
		    'label'    => __( 'Title for the fa2','revive' ),
		    'section'  => 'revive_fc_fa2',
		    'type'     => 'text',
		)
	);
 
 	$wp_customize->add_setting(
	    'revive_fa2_cat',
	    array( 'sanitize_callback' => 'revive_sanitize_category' )
	);
	
	$wp_customize->add_control(
	    new WP_Customize_Category_Control(
	        $wp_customize,
	        'revive_fa2_cat',
	        array(
	            'label'    => 'Category For Square fa2.',
	            'settings' => 'revive_fa2_cat',
	            'section'  => 'revive_fc_fa2'
	        )
	    )
	);
	
	
	//FEATURED CATEGORIES
	$wp_customize->add_section(
	    'revive_fcats_boxes',
	    array(
	        'title'     => 'Featured Categories',
	        'priority'  => 10,
	        'panel'     => 'revive_fca_panel'
	    )
	);
	
	$wp_customize->add_setting(
		'revive_fcats_enable',
		array( 'sanitize_callback' => 'revive_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'revive_fcats_enable', array(
		    'settings' => 'revive_fcats_enable',
		    'label'    => __( 'Enable Featured Categories', 'revive' ),
		    'section'  => 'revive_fcats_boxes',
		    'type'     => 'checkbox',
		)
	);
	
 
	$wp_customize->add_setting(
		'revive_fcats_title',
		array( 'sanitize_callback' => 'sanitize_text_field' )
	);
	
	$wp_customize->add_control(
			'revive_fcats_title', array(
		    'settings' => 'revive_fcats_title',
		    'label'    => __( 'Title','revive' ),
		    'section'  => 'revive_fcats_boxes',
		    'type'     => 'text',
		)
	);
 
 	$wp_customize->add_setting(
	    'revive_fcats_cat',
	    array( 'sanitize_callback' => 'revive_sanitize_category' )
	);
	
	$wp_customize->add_control(
	    new WP_Customize_Category_Control(
	        $wp_customize,
	        'revive_fcats_cat',
	        array(
	            'label'    => 'Category 1',
	            'settings' => 'revive_fcats_cat',
	            'section'  => 'revive_fcats_boxes'
	        )
	    )
	);
	
	$wp_customize->add_setting(
	    'revive_fcats_cat2',
	    array( 'sanitize_callback' => 'revive_sanitize_category' )
	);
	
	$wp_customize->add_control(
	    new WP_Customize_Category_Control(
	        $wp_customize,
	        'revive_fcats_cat2',
	        array(
	            'label'    => 'Category 2',
	            'settings' => 'revive_fcats_cat2',
	            'section'  => 'revive_fcats_boxes'
	        )
	    )
	);
	
	//FEATURED TRIANGLE
	$wp_customize->add_section(
	    'revive_sl_boxes',
	    array(
	        'title'     => 'Featured Sliding Boxes',
	        'priority'  => 10,
	        'panel'     => 'revive_fca_panel'
	    )
	);
	
	$wp_customize->add_setting(
		'revive_slbox_enable',
		array( 'sanitize_callback' => 'revive_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'revive_slbox_enable', array(
		    'settings' => 'revive_slbox_enable',
		    'label'    => __( 'Enable.', 'revive' ),
		    'section'  => 'revive_sl_boxes',
		    'type'     => 'checkbox',
		)
	);
	
 
	$wp_customize->add_setting(
		'revive_slbox_title',
		array( 'sanitize_callback' => 'sanitize_text_field' )
	);
	
	$wp_customize->add_control(
			'revive_slbox_title', array(
		    'settings' => 'revive_slbox_title',
		    'label'    => __( 'Title for the Boxes','revive' ),
		    'section'  => 'revive_sl_boxes',
		    'type'     => 'text',
		)
	);
 
 	$wp_customize->add_setting(
	    'revive_slbox_cat',
	    array( 'sanitize_callback' => 'revive_sanitize_category' )
	);
	
	$wp_customize->add_control(
	    new WP_Customize_Category_Control(
	        $wp_customize,
	        'revive_slbox_cat',
	        array(
	            'label'    => 'Category For Square Boxes.',
	            'settings' => 'revive_slbox_cat',
	            'section'  => 'revive_sl_boxes'
	        )
	    )
	);
	
	
	
	
	
	
	
	// Layout and Design
	$wp_customize->add_panel( 'revive_design_panel', array(
	    'priority'       => 40,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '',
	    'title'          => __('Design & Layout','revive'),
	) );
	
	$wp_customize->add_section(
	    'revive_design_options',
	    array(
	        'title'     => __('Blog Layout','revive'),
	        'priority'  => 0,
	        'panel'     => 'revive_design_panel'
	    )
	);
	
	
	$wp_customize->add_setting(
		'revive_blog_layout',
		array( 'sanitize_callback' => 'revive_sanitize_blog_layout' )
	);
	
	function revive_sanitize_blog_layout( $input ) {
		if ( in_array($input, array('grid','grid_2_column','grid_3_column','grid_4_column','revive') ) )
			return $input;
		else 
			return '';	
	}
	
	$wp_customize->add_control(
		'revive_blog_layout',array(
				'label' => __('Select Layout','revive'),
				'settings' => 'revive_blog_layout',
				'section'  => 'revive_design_options',
				'type' => 'select',
				'choices' => array(
						'grid' => __('Basic Blog Layout','revive'),
						'revive' => __('Revive Default Layout','revive'),
						'grid_2_column' => __('Grid - 2 Column','revive'),
						'grid_3_column' => __('Grid - 3 Column','revive'),
						'grid_4_column' => __('Grid - 4 Column','revive'),
					)
			)
	);
	
	//SIDEBAR
	$wp_customize->add_section(
	    'revive_sidebar_options',
	    array(
	        'title'     => __('Sidebar Layout','revive'),
	        'priority'  => 0,
	        'panel'     => 'revive_design_panel'
	    )
	);
	
	$wp_customize->add_setting(
		'revive_disable_sidebar',
		array( 'sanitize_callback' => 'revive_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'revive_disable_sidebar', array(
		    'settings' => 'revive_disable_sidebar',
		    'label'    => __( 'Disable Sidebar Everywhere.','revive' ),
		    'section'  => 'revive_sidebar_options',
		    'type'     => 'checkbox',
		    'default'  => false
		)
	);
	
	$wp_customize->add_setting(
		'revive_disable_sidebar_home',
		array( 'sanitize_callback' => 'revive_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'revive_disable_sidebar_home', array(
		    'settings' => 'revive_disable_sidebar_home',
		    'label'    => __( 'Disable Sidebar on Home/Blog.','revive' ),
		    'section'  => 'revive_sidebar_options',
		    'type'     => 'checkbox',
		    'active_callback' => 'revive_show_sidebar_options',
		    'default'  => false
		)
	);
	
	$wp_customize->add_setting(
		'revive_disable_sidebar_archive',
		array( 'sanitize_callback' => 'revive_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'revive_disable_sidebar_archive', array(
		    'settings' => 'revive_disable_sidebar_archive',
		    'label'    => __( 'Disable Sidebar on Archive/Category/Tag Pages.','revive' ),
		    'section'  => 'revive_sidebar_options',
		    'type'     => 'checkbox',
		    'active_callback' => 'revive_show_sidebar_options',
		    'default'  => false
		)
	);
	
	$wp_customize->add_setting(
		'revive_disable_sidebar_front',
		array( 'sanitize_callback' => 'revive_sanitize_checkbox' )
	);
	
	$wp_customize->add_control(
			'revive_disable_sidebar_front', array(
		    'settings' => 'revive_disable_sidebar_front',
		    'label'    => __( 'Disable Sidebar on Front Page.','revive' ),
		    'section'  => 'revive_sidebar_options',
		    'type'     => 'checkbox',
		    'active_callback' => 'revive_show_sidebar_options',
		    'default'  => false
		)
	);
	
	
	$wp_customize->add_setting(
		'revive_sidebar_width',
		array(
			'default' => 4,
		    'sanitize_callback' => 'revive_sanitize_positive_number' )
	);
	
	$wp_customize->add_control(
			'revive_sidebar_width', array(
		    'settings' => 'revive_sidebar_width',
		    'label'    => __( 'Sidebar Width','revive' ),
		    'description' => __('Min: 25%, Default: 33%, Max: 40%','revive'),
		    'section'  => 'revive_sidebar_options',
		    'type'     => 'range',
		    'active_callback' => 'revive_show_sidebar_options',
		    'input_attrs' => array(
		        'min'   => 3,
		        'max'   => 5,
		        'step'  => 1,
		        'class' => 'revive-width-range',
		        'style' => 'color: #0a0',
		    ),
		)
	);
	
	/* Active Callback Function */
	function revive_show_sidebar_options($control) {
	   
	    $option = $control->manager->get_setting('revive_disable_sidebar');
	    return $option->value() == false ;
	    
	}
	
	class Revive_Custom_CSS_Control extends WP_Customize_Control {
	    public $type = 'textarea';
	 
	    public function render_content() {
	        ?>
	            <label>
	                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	                <textarea rows="8" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
	            </label>
	        <?php
	    }
	}
	$wp_customize->add_setting(
		'revive_sidebar_loc',
		array(
			'default' => 'right',
		    'sanitize_callback' => 'revive_sanitize_sidebar_loc' )
	);
	
	$wp_customize->add_control(
			'revive_sidebar_loc', array(
		    'settings' => 'revive_sidebar_loc',
		    'label'    => __( 'Sidebar Location','revive' ),
		    'section'  => 'revive_sidebar_options',
		    'type'     => 'select',
		    'active_callback' => 'revive_show_sidebar_options',
		    'choices' => array(
		        'left'   => "Left",
		        'right'   => "Right",
		    ),
		)
	);
	
	/* sanitization */
	function revive_sanitize_sidebar_loc( $input ) {
		if (in_array($input, array('left','right') ) ) :
			return $input;
		else :
			return '';
		endif;		
	}
	
	$wp_customize-> add_section(
    'revive_custom_codes',
    array(
    	'title'			=> __('Custom CSS','revive'),
    	'description'	=> __('Enter your Custom CSS to Modify design.','revive'),
    	'priority'		=> 11,
    	'panel'			=> 'revive_design_panel'
    	)
    );
    
	$wp_customize->add_setting(
	'revive_custom_css',
	array(
		'default'		=> '',
		'sanitize_callback'	=> 'revive_sanitize_text'
		)
	);
	
	$wp_customize->add_control(
	    new Revive_Custom_CSS_Control(
	        $wp_customize,
	        'revive_custom_css',
	        array(
	            'section' => 'revive_custom_codes',
	            'settings' => 'revive_custom_css'
	        )
	    )
	);
	
	class Revive_Custom_JS_Control extends WP_Customize_Control {
	    public $type = 'textarea';
	 
	    public function render_content() {
	        ?>
	            <label>
	                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	                <textarea rows="8" style="width:100%;background: #222; color: #eee;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
	            </label>
	        <?php
	    }
	}
	
	$wp_customize-> add_section(
    'revive_custom_codes_js',
    array(
    	'title'			=> __('Custom JS','revive'),
    	'description'	=> __('Enter your Custom JS Code. It will be Included in Head of the Site. Do NOT Include &lt;script&gt; and &lt;/script&gt; tags.','revive'),
    	'priority'		=> 11,
    	'panel'			=> 'revive_design_panel'
    	)
    );
    
	$wp_customize->add_setting(
	'revive_custom_js',
	array(
		'default'		=> '',
		'sanitize_callback'	=> 'revive_sanitize_text'
		)
	);
	
	$wp_customize->add_control(
	    new Revive_Custom_JS_Control(
	        $wp_customize,
	        'revive_custom_js',
	        array(
	            'section' => 'revive_custom_codes_js',
	            'settings' => 'revive_custom_js'
	        )
	    )
	);
	
	function revive_sanitize_text( $input ) {
	    return wp_kses_post( force_balance_tags( $input ) );
	}
	
	$wp_customize-> add_section(
    'revive_custom_footer',
    array(
    	'title'			=> __('Footer Credit Link','revive'),
    	'description'	=> __('Enter your Own Copyright Text.','revive'),
    	'priority'		=> 11,
    	'panel'			=> 'revive_design_panel'
    	)
    );
    
	$wp_customize->add_setting(
	'revive_footer_text',
	array(
		'default'		=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
		)
	);
	
	$wp_customize->add_control(	 
	       'revive_footer_text',
	        array(
	            'section' => 'revive_custom_footer',
	            'settings' => 'revive_footer_text',
	            'type' => 'text'
	        )
	);
	
	$wp_customize->add_setting(
	'revive_link_remove',
	array(
		'default'		=> false,
		'sanitize_callback'	=> 'revive_sanitize_checkbox'
		)
	);
	
	$wp_customize->add_control(	 
	       'revive_link_remove',
	        array(
	            'section' => 'revive_custom_footer',
	            'label' => __('Remove Footer Theme Credit Link.','revive'),
	            'settings' => 'revive_link_remove',
	            'type' => 'checkbox'
	        )
	);
	
	//Skin and Accent Section
	$wp_customize-> add_section(
    'revive_skin_sec',
    array(
    	'title'			=> __('Choose Skin','revive'),
    	'description'	=> __('Select from Dark or Light','revive'),
    	'priority'		=> 10,
    	'panel'			=> 'revive_design_panel'
    	)
    );
    
	$wp_customize->add_setting(
	'revive_skin',
	array(
		'default'		=> 'light',
		'sanitize_callback'	=> 'sanitize_skin_field'
		)
	);
	
	$wp_customize->add_control(	 
	       'revive_skin',
	        array(
	            'section' => 'revive_skin_sec',
	            'settings' => 'revive_skin',
	            'type' => 'select',
	            'choices' => array(
	            				'light' => __('Light','revive'),
	            				'dark' => __('Dark','revive'),	
	            				)           				
	        )
	);	
	
	function sanitize_skin_field($input) {
		if ( in_array($input, array('light','dark') ) )
			return $input;
		else 
			return '';	
	}
	
	$wp_customize->add_setting('revive_accent', array(
	    'default'     => '#e10d0d',
	    'sanitize_callback' => 'sanitize_hex_color',
	));
	
	$wp_customize->add_control(new WP_Customize_Color_Control( 
		$wp_customize, 
		'revive_accent', array(
			'label' => __('Theme Accent','revive'),
			'section' => 'colors',
			'settings' => 'revive_accent',
			'type' => 'color',
			'priority' => 1
		) ) 
	);
	
	
	
	//TYPOGRAPHY	
	
	$wp_customize->add_section(
	    'revive_typo_options',
	    array(
	        'title'     => __('Google Web Fonts','revive'),
	        'priority'  => 41,
	        'description' => __('Fonts are Sorted in Order of Popularity. Defaults: Raleway, Khula.','revive')
	    )
	);
	
	/**
	 * A class to create a dropdown for all google fonts
	 */
	 class Google_Font_Dropdown_Custom_Control extends WP_Customize_Control
	 {
	    private $fonts = false;
	
	    public function __construct($manager, $id, $args = array(), $options = array())
	    {
	        $this->fonts = $this->get_fonts();
	        parent::__construct( $manager, $id, $args );
	    }

	    /**
	     * Render the content of the category dropdown
	     *
	     * @return HTML
	     */
	    public function render_content()
	    {
	        if(!empty($this->fonts))
	        {
	            ?>
	                <label>
	                    <span class="customize-category-select-control" style="font-weight: bold; display: block; padding: 5px 0px;"><?php echo esc_html( $this->label ); ?><br /></span>
	                    
	                    <select <?php $this->link(); ?>>
	                        <?php
	                            foreach ( $this->fonts as $k => $v )
	                            {
	                               printf('<option value="%s" %s>%s</option>', $v->family, selected($this->value(), $k, false), $v->family);
	                            }
	                        ?>
	                    </select>
	                </label>
	            <?php
	        }
	    }
	
	    /**
	     * Get the google fonts from the API or in the cache
	     *
	     * @param  integer $amount
	     *
	     * @return String
	     */
	    public function get_fonts( $amount = 'all' )
	    {
	        $fontFile = get_template_directory().'/inc/cache/google-web-fonts.txt';
	
	        //Total time the file will be cached in seconds, set to a week
	        $cachetime = 86400 * 30;
	
	        if(file_exists($fontFile) && $cachetime < filemtime($fontFile))
	        {
	            $content = json_decode(file_get_contents($fontFile));
	           
	        } else {
	
	            $googleApi = 'https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key=AIzaSyCnUNuE7iJyG-tuhk24EmaLZSC6yn3IjhQ';
	
	            $fontContent = wp_remote_get( $googleApi, array('sslverify'   => false) );
	
	            $fp = fopen($fontFile, 'w');
	            fwrite($fp, $fontContent['body']);
	            fclose($fp);
	
	            $content = json_decode($fontContent['body']);
	            
	        }
	
	        if($amount == 'all')
	        {
	            return $content->items;
	        } else {
	            return array_slice($content->items, 0, $amount);
	        }
	        
	    }
	 }
	
	
	
	$wp_customize->add_setting(
		'revive_title_font' ,array('default' => 'Raleway')
	);
	
	$wp_customize->add_control( new Google_Font_Dropdown_Custom_Control(
		$wp_customize,
		'revive_title_font',array(
				'label' => __('Title Font','revive'),
				'settings' => 'revive_title_font',
				'section'  => 'revive_typo_options',
			)
		)
	);
	
	
$wp_customize->add_setting(
		'revive_body_font'
	);
	
	$wp_customize->add_control(
		new Google_Font_Dropdown_Custom_Control(
		$wp_customize,
		'revive_body_font',array(
				'label' => __('Body Font','revive'),
				'settings' => 'revive_body_font',
				'section'  => 'revive_typo_options'
			)
		)	
	);

	
	// Social Icons
	$wp_customize->add_section('revive_social_section', array(
			'title' => __('Social Icons','revive'),
			'priority' => 44 ,
	));
	
	$social_networks = array( //Redefinied in Sanitization Function.
					'none' => __('-','protpress'),
					'facebook' => __('Facebook','revive'),
					'twitter' => __('Twitter','revive'),
					'google-plus' => __('Google Plus','revive'),
					'instagram' => __('Instagram','revive'),
					'rss' => __('RSS Feeds','revive'),
					'vine' => __('Vine','revive'),
					'vimeo-square' => __('Vimeo','revive'),
					'youtube' => __('Youtube','revive'),
					'flickr' => __('Flickr','revive'),
					'android' => __('Android','revive'),
					'apple' => __('Apple','revive'),
					'dribbble' => __('Dribbble','revive'),
					'foursquare' => __('FourSquare','revive'),
					'git' => __('Git','revive'),
					'linkedin' => __('Linked In','revive'),
					'paypal' => __('PayPal','revive'),
					'pinterest-p' => __('Pinterest','revive'),
					'reddit' => __('Reddit','revive'),
					'skype' => __('Skype','revive'),
					'soundcloud' => __('SoundCloud','revive'),
					'tumblr' => __('Tumblr','revive'),
					'windows' => __('Windows','revive'),
					'wordpress' => __('WordPress','revive'),
					'yelp' => __('Yelp','revive'),
					'vk' => __('VK.com','revive'),
				);
				
	$social_count = count($social_networks);
				
	for ($x = 1 ; $x <= 10 ; $x++) :
			
		$wp_customize->add_setting(
			'revive_social_'.$x, array(
				'sanitize_callback' => 'revive_sanitize_social',
				'default' => 'none'
			));

		$wp_customize->add_control( 'revive_social_'.$x, array(
					'settings' => 'revive_social_'.$x,
					'label' => __('Icon ','revive').$x,
					'section' => 'revive_social_section',
					'type' => 'select',
					'choices' => $social_networks,			
		));
		
		$wp_customize->add_setting(
			'revive_social_url'.$x, array(
				'sanitize_callback' => 'esc_url_raw'
			));

		$wp_customize->add_control( 'revive_social_url'.$x, array(
					'settings' => 'revive_social_url'.$x,
					'description' => __('Icon ','revive').$x.__(' Url','revive'),
					'section' => 'revive_social_section',
					'type' => 'url',
					'choices' => $social_networks,			
		));
		
	endfor;
	
	function revive_sanitize_social( $input ) {
		$social_networks = array(
					'none' ,
					'facebook',
					'twitter',
					'google-plus',
					'instagram',
					'rss',
					'vine',
					'vimeo-square',
					'youtube',
					'flickr',
					'android',
					'apple',
					'dribbble',
					'foursquare',
					'git',
					'linkedin',
					'paypal',
					'pinterest-p',
					'reddit',
					'skype',
					'soundcloud',
					'tumblr',
					'windows',
					'wordpress',
					'yelp',
					'vk'
				);
		if ( in_array($input, $social_networks) )
			return $input;
		else
			return '';	
	}
	
	// Advertisement
	
	class Revive_Custom_Ads_Control extends WP_Customize_Control {
	    public $type = 'textarea';
	 
	    public function render_content() {
	        ?>
	            <label>
	                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	                <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
	                <textarea rows="10" style="width:100%;" <?php $this->link(); ?>><?php echo $this->value(); ?></textarea>
	            </label>
	        <?php
	    }
	}
	
	$wp_customize->add_section('revive_ads', array(
			'title' => __('Advertisement','revive'),
			'priority' => 44 ,
	));
	
	$wp_customize->add_setting(
	'revive_topad',
	array(
		'default'		=> '',
		'sanitize_callback'	=> 'revive_sanitize_ads'
		)
	);
	
	$wp_customize->add_control(
	    new Revive_Custom_Ads_Control(
	        $wp_customize,
	        'revive_topad',
	        array(
	            'section' => 'revive_ads',
	            'settings' => 'revive_topad',
	            'label'   => __('Top Ad','revive'),
	            'description' => __('Enter your Responsive Adsense Code. For Other Ads use 468x60px Banner.','revive')
	        )
	    )
	);
	
	function revive_sanitize_ads( $input ) {
		  global $allowedposttags;
	      $custom_allowedtags["script"] = array();
	      $custom_allowedtags = array_merge($custom_allowedtags, $allowedposttags);
	      $output = wp_kses( $input, $custom_allowedtags);
	      return $output;
	}
	
	//Analytics
	$wp_customize-> add_section(
    'revive_analytics_js',
    array(
    	'title'			=> __('Google Analytics','revive'),
    	'description'	=> __('Enter your Analytics Code. It will be Included in Footer of the Site. Do NOT Include &lt;script&gt; and &lt;/script&gt; tags.','revive'),
    	'priority'		=> 45,
    	)
    );
    
	$wp_customize->add_setting(
	'revive_analytics',
	array(
		'default'		=> '',
		'sanitize_callback'	=> 'revive_sanitize_text'
		)
	);
	
	$wp_customize->add_control(
	    new Revive_Custom_JS_Control(
	        $wp_customize,
	        'revive_analytics',
	        array(
	            'section' => 'revive_analytics_js',
	            'settings' => 'revive_analytics'
	        )
	    )
	);	
	
	
	/* Sanitization Functions Common to Multiple Settings go Here, Specific Sanitization Functions are defined along with add_setting() */
	function revive_sanitize_checkbox( $input ) {
	    if ( $input == 1 ) {
	        return 1;
	    } else {
	        return '';
	    }
	}
	
	function revive_sanitize_positive_number( $input ) {
		if ( ($input >= 0) && is_numeric($input) )
			return $input;
		else
			return '';	
	}
	
	function revive_sanitize_category( $input ) {
		if ( term_exists(get_cat_name( $input ), 'category') )
			return $input;
		else 
			return '';	
	}
	
	
}
add_action( 'customize_register', 'revive_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function revive_customize_preview_js() {
	wp_enqueue_script( 'revive_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'revive_customize_preview_js' );

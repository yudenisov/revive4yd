<?php
/*
Plugin Name: Facebook Like Box
*/
?>
<?php
$fb_defaults = array(
			'title' => 'Facebook',
			'url' => 'http://www.facebook.com/facebook',
			'width' => '292',
			'height' => '245',
			'colorscheme' => 'light',
			'show_faces' => 'true',
			'stream' => 'false',
			'header' => 'false',
			'border' => 'dbdbdb'
);

		
class ihFacebook extends WP_Widget { 
	function __construct(){
        $widget_options = array('description' => 'Facebook Like Box social widget. Enables Facebook Page owners to attract and gain Likes from their own website.' );
        $control_options = array( 'width' => 440 );
		$this->WP_Widget('ih_Facebook', 'ProtoPress Responsive Facebook Like Box', $widget_options, $control_options);
    }

     function widget($args, $instance){
        global $wpdb;
        extract( $args );
        if (isset($instance['title'])) :
	        $title = apply_filters('widget_title', $instance['title']);
	        $url = $instance['url'];
	        $width = $instance['width'];
	        $height = $instance['height'];
	        $colorscheme = $instance['colorscheme'];
	        $show_faces = $instance['show_faces'] == 'true' ? 'true' : 'false';
	        $stream = $instance['stream'] == 'true' ? 'true' : 'false';
	        $header = $instance['header'] == 'true' ? 'true' : 'false';
	        $border = $instance['border'];
	    else :
	    	$title = apply_filters('widget_title', 'Facebook');
	        $url = 'http://www.facebook.com/facebook';
	        $width = '250';
	        $height ='250';
	        $colorscheme = 'light';
	        $show_faces = 'true';
	        $stream = 'false';
	        $header = 'false';
	        $border = 'dbdbdb';
	    endif;    
	    	    
        ?>
       <?php echo $args['before_widget']?>
        <?php  if ( $title ) {  ?><?php echo $args['before_title']?><?php echo $title?><?php echo $args['after_title']?><?php }  ?>
            
			<div class="lb-container">
            <div class="fb-like-box" data-href="<?php echo $url?>" data-width="<?php echo $width?>" data-height="<?php echo $height?>" data-colorscheme="<?php echo $colorscheme?>" data-show-faces="<?php echo $show_faces?>" data-stream="<?php echo $stream?>" data-header="<?php echo $header?>" data-border-color="<?php echo $border?>"></div>
			</div>
            
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) {return;}
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
            
            jQuery(window).bind("load resize", function(){    
			  var container_width = jQuery('.lb-container').width();    
			    jQuery('.lb-container').html('<div class="fb-like-box" ' + 
			    'data-href="<?php echo $url?>"' +
			    ' data-width="' + container_width + '" data-height="<?php echo $height?>" data-show-faces="<?php echo $show_faces?>" ' +
			    'data-stream="<?php echo $stream?>" data-border-color="<?php echo $border?>" data-colorscheme="<?php echo $colorscheme?>" data-header="<?php echo $header?>"></div>');
			    FB.XFBML.parse( );    
			}); 
			</script>
            
          <?php echo $args['after_widget']?>
     <?php
    }


    function update($new_instance, $old_instance){
    	$instance = $old_instance;
    	$instance['title'] = strip_tags($new_instance['title']);
        $instance['url'] = strip_tags($new_instance['url']);
        $instance['width'] = strip_tags($new_instance['width']);
        $instance['height'] = strip_tags($new_instance['height']);
        $instance['colorscheme'] = strip_tags($new_instance['colorscheme']);
        $instance['show_faces'] = strip_tags($new_instance['show_faces']);
        $instance['stream'] = strip_tags($new_instance['stream']);
        $instance['header'] = strip_tags($new_instance['header']);
        $instance['border'] = strip_tags($new_instance['border']);
        return $instance;
    }
    
    function form($instance){
		global $fb_defaults;
        $instance=wp_parse_args( (array)$instance, $fb_defaults);
        ?>
        
            <div class="tt-widget">
                <table width="100%">
                    <tr>
                        <td class="tt-widget-label" width="30%"><label for="<?php echo $this->get_field_id('title')?>">Title:</label></td>
                        <td class="tt-widget-content" width="70%"><input class="widefat" id="<?php echo $this->get_field_id('title')?>" name="<?php echo $this->get_field_name('title')?>" type="text" value="<?php echo esc_attr($instance['title'])?>" /></td>
                    </tr>
                    
                    <tr>
                        <td class="tt-widget-label"><label for="<?php echo $this->get_field_id('url')?>">Facebook Page URL:</label></td>
                        <td class="tt-widget-content"><input class="widefat" id="<?php echo $this->get_field_id('url')?>" name="<?php echo $this->get_field_name('url')?>" type="text" value="<?php echo esc_attr($instance['url'])?>" /></td>
                    </tr>
                    
                    <tr>
                        <td class="tt-widget-label">Sizes:</td>
                        <td class="tt-widget-content">
                            Height: <input type="text" style="width: 50px;" name="<?php echo $this->get_field_name('height')?>" value="<?php echo esc_attr($instance['height'])?>" /> px.
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="tt-widget-label">Color Scheme:</td>
                        <td class="tt-widget-content">
                            <select name="<?php echo $this->get_field_name('colorscheme')?>">
                                <option value="light" <?php selected('light', $instance['colorscheme']); ?> >Light</option>
                                <option value="dark"  <?php selected('dark', $instance['colorscheme']); ?>>Dark</option>
                             </select>      
                             &nbsp; &nbsp; Border Color: <input type="text" style="width: 50px;" name="<?php echo $this->get_field_name('border')?>" value="<?php echo esc_attr($instance['border'])?>" /> <em>e.g: #ffffff</em>                      
                        </td>
                    </tr>

                    <tr>
                        <td class="tt-widget-label">Misc Options:</td>
                        <td class="tt-widget-content">
                            <input type="checkbox" name="<?php echo $this->get_field_name('show_faces')?>"  <?php checked('true', $instance['show_faces']); ?> value="true" />  Show faces
                            <br /><input type="checkbox" name="<?php echo $this->get_field_name('stream')?>"  <?php checked('true', $instance['stream']); ?> value="true" />  Show stream
                            <br /><input type="checkbox" name="<?php echo $this->get_field_name('header')?>"  <?php checked('true', $instance['header']); ?> value="true" />  Show  header
                        </td>
                    </tr>
                    
                </table>
            </div>
            
        <?php 
    }
} 
add_action('widgets_init', create_function('', 'return register_widget("ihFacebook");'));
?>
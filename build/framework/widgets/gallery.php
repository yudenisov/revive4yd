<?php
//Original Copyright for this widget goes to DesignWall.com
class white_recent_flickr_Widget extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     **/
	function white_recent_flickr_Widget() {
		$widget_ops = array( 'classname' => 'white-photo', 'description' => __('Displays the Thumbnails from posts of selected Category.','white') );
		$this->WP_Widget( 'white-photo', __('ProtoPress Post Thumbnails Gallery','white'), $widget_ops );
	}

    /**
     * Outputs the HTML for this widget.
     *
     * @param array  An array of standard parameters for widgets in this theme
     * @param array  An array of settings for this widget instance
     * @return void Echoes it's output
     **/
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		$instance = wp_parse_args( (array) $instance, array( 
				'title' => htmlentities(__('<span class="title-blue">flick</span><span class="title-red">r</span> widget','white')), 
				'column' => 2, 
				'row' => 2 ) 
		);
		extract($instance);

		echo $before_widget;
		echo '<h1 class="widget-title"><span>';
		echo html_entity_decode($title);
		echo '</span></h1>';

		$number = $row;

		$posts = get_posts( array(
			'numberposts'		=>	$number,
			'category'			=>	$category,
			'post_status'		=>	'publish')
		);

		if( !empty($posts) ){
			echo '<ul class="post_thumbs_widget">';
			$i = 0;
			foreach ($posts as $post) { $i++;
				$class = '';

				if( $i == 1 ){
					$class .= ' first';
				}else if( $i == $number ){
					$class .= ' last';
				}
				if( $i % 2 == 0 ){
					$class .= ' even';
				}else{
					$class .= ' odd';
				}
				if( $i % $column == 0) {
					$class .= ' end-row';
				}

				$attachment_ID = get_post_thumbnail_id($post->ID);
				$image = wp_get_attachment_image_src($attachment_ID, 'thumbnail' );
				if( $image[0] ){
					echo '<li class="'.$class.'"><a title="'.$post->post_title.'" href="'.get_permalink($post->ID).'"><img src="'.$image[0].'" title="'.$post->post_title.'" /></a></li>';
				}
			}
			echo '</ul>';
		}

		echo $after_widget;
	}

    /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     *
     * @param array  An array of new settings as submitted by the admin
     * @param array  An array of the previous settings
     * @return array The validated and (if necessary) amended settings
     **/
	function update( $new_instance, $old_instance ) {
		if ( current_user_can('unfiltered_html') )
			$new_instance['title'] =  $new_instance['title'];
		else
			$new_instance['title'] = trim( stripslashes( wp_filter_post_kses( addslashes($new_instance['title']) ) ) ); // wp_filter_post_kses() expects slashed

		return $new_instance;
	}

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @param array  An array of the current settings for this widget
     * @return void Echoes it's output
     **/
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 
			'title' => __('Photo','white'), 
			'row' => 2, 
			'category'	=> 0
			) 
		);
		$title = esc_html($instance['title']);
		?> 
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget title', 'white') ?></label>
		<textarea class="widefat" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>"><?php echo trim( $instance['title'] ); ?></textarea>	
		</p>
		
		<p><label for="<?php echo $this->get_field_id('row'); ?>"><?php  _e('Number of Posts','white'); ?></label>
		<input class="widefat" type="text" name="<?php echo $this->get_field_name('row'); ?>" id="<?php echo $this->get_field_id('row') ?>" value="<?php echo $instance['row'] ?>"	>	</p>
		
		<p><label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Widget Category','white') ?></label>
			<select name="<?php echo $this->get_field_name('category'); ?>" id="<?php echo $this->get_field_id('category'); ?>">
			<?php 
			$categories = $this->get_categories_select();
			foreach ( $categories as $key => $category ) {
				echo '<option '.selected($key, $instance['category']).' value="'.$key.'">'.$category.'</option>';
			}  
			?>
			</select>
		</p>
	<?php
	}

	/**
	 * Get categories option for select box
	 * @param  string $type Post type to retrive categories
	 * @return array array of value-pair( ID - Name ) of all categories
	 */
	function get_categories_select(){
		$option = array();
		
		$categories = get_categories(array(
			'hide_empty'               => 0,
		) );

		foreach ($categories as $cat) {
			$option[$cat->term_id] = $cat->name;
		}

		return $option;
	}

	/**
	 * Get all authors in your page
	 * @return array return an array of value-pair( ID - Name ) of all author
	 */
	function get_list_author(){
		$auhor = array();
		$users = get_users();
		foreach ($users as $user) {
			$author[$user->ID] = $user->user_login;
		}
		return $author;
	}
}
add_action( 'widgets_init', create_function( '', "register_widget('white_recent_flickr_Widget');" ) );
<?php
/*
Plugin Name: Video Feed Box
*/
?>
<?php
    
    $video_defaults = array(
        'title' => 'Video',
        'videos' => array(
			array(
				'title' => 'Amazing nature scenery', 
				'url' => 'http://www.youtube.com/watch?v=6v2L2UGZJAM', 
				'type' => 'youtube', 
				'id' => '6v2L2UGZJAM'
			)
		)
    );



    

class InkHiveVideoFeed extends WP_Widget 
{
    function __construct(){
        
        $widget_options = array('description' => 'Video Feed Box widget. Display Videos From YouTube in a Native Style. (by InkHive.com)' );
        $control_options = array();
        parent::__construct('InkHiveVideoFeed', 'ProtoPress Videos', $widget_options, $control_options);
    }

    function widget($args, $instance){
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $videos = $instance['videos'];
   
        if(is_array($videos)) {
            ?>
			<?php echo $args['before_widget']?>
			<?php  if ( $title ) {  ?><?php echo $args['before_title']?><?php echo $title?><?php echo $args['after_title']?><?php } 
				foreach ($videos as $video) {?><div class='sidebar-video'>
				<span class="video-title"><a href='<?php echo $video['url']; ?>' rel='nofollow' target='_blank'><?php echo $video['title']; ?></a></span>
			<?php
				switch( $video['type'] ) {
					case 'youtube':
					echo '<div class="video-image"><a href="http://www.youtube.com/watch?v='.$video['id'].'" target="_blank" alt="'.$video['id'].'" src="youtube" class="video popup"><img src="http://img.youtube.com/vi/'.$video['id'].'/mqdefault.jpg"/></a></div>';
				}?>
				</div>
				<?php }
            ?>
           <?php echo $args['after_widget']?>
            <?php
        }
    }

    function update($new_instance, $old_instance) 
    {				
    	$instance = $old_instance;
    	$instance['title'] = strip_tags($new_instance['title']);
		$instance['videos']=array();
		foreach ($new_instance['videos'] as $video) {
			if (preg_match('/youtube/', $video['url'])) {
				$video['type']='youtube';
				$video['id']=preg_replace('/(.*)(v=)(.*)/', '$3', $video['url']);
			}
			$instance['videos'][]=$video;
		}
        return $instance;
    }
    
     function form($instance){
		global $video_defaults;
		$instance = wp_parse_args( (array) $instance, $video_defaults );
        $get_videos = $instance['videos'];
		$get_this_id = preg_replace("/[^0-9]/", '', $this->get_field_id('this_id_videos'));
        $get_this_id = !$get_this_id ? 'this_id_videos___i__' : 'this_id_videos_' . $get_this_id;
        ?>
        
        <script type="text/javascript">
		
			jQuery('.video-ttl').live('focusin', function() {
				jQuery(this).parents('.video-element').addClass('active').siblings().removeClass('active');
				jQuery('.video-ttl').removeClass('field');
				jQuery(this).addClass('field');
			});
		
			jQuery('.add-video').die();
			jQuery('.add-video').live('click', function() {
				var new_video_id = 10000+Math.floor(Math.random()*100000);
				jQuery(this).before(
					jQuery('<div>', {
						'class':'video-element'
					}).append(
						jQuery('<input>', {
							'class':'video-ttl widefat',
							'type':'text',
							'value':'title',
							'name':'<?php echo $this->get_field_name('videos')?>['+new_video_id+'][title]'
						})
					).append(
						jQuery('<input>', {
							'class':'widefat',
							'type':'text',
							'value':'url',
							'name':'<?php echo $this->get_field_name('videos')?>['+new_video_id+'][url]'
						})
					).append(
						jQuery('<a>', {
							'class':'button delete_video'
						}).text('Delete')
					)
				);
				jQuery(this).prev('.video-element').find('.video-ttl').focus();
			});
			jQuery('.delete_video').live('click', function() {
				jQuery(this).parents('.video-element').remove();
			});
		</script>
		<style>
			.video-element.active {
				height:100px;
			}
			.video-element {
				border: 1px solid #DFDFDF;
				margin-bottom: 20px;
				padding: 10px;
				height:23px;
				line-height:23px;
				overflow:hidden;
			}
			.video-element input {
				margin-bottom:12px;
			}
			.video-ttl {
				cursor:pointer;
				border:none !important;
				background:none !important;
			}
			.video-ttl.field {
				cursor:text;
				border:1px solid #DFDFDF !important;
				background:#fff !important;
			}
			.add-video {
				cursor:pointer;
			}
		</style>
        <div style="margin-bottom: 20px;">
			<p><label for="<?php echo $this->get_field_id('title')?>">Title:</label><input class="widefat" id="<?php echo $this->get_field_id('title')?>" name="<?php echo $this->get_field_name('title')?>" type="text" value="<?php echo esc_attr($instance['title'])?>" /></p>
			
        </div>
		<div class="videos_<?php echo $get_this_id?>">
        <?php
            if(is_array($get_videos)) {
                foreach($get_videos as $video_id=>$video_source) {
                    ?>
                    <div class="tt-clearfix video-element">
							
						<input class='video-ttl widefat' name="<?php echo $this->get_field_name('videos')?>[<?php echo $video_id ?>][title]" type="text" value="<?php echo $video_source['title']?>" />
						<input class="widefat" name="<?php echo $this->get_field_name('videos')?>[<?php echo $video_id ?>][url]" type="text" value="<?php echo $video_source['url']?>" />
							
						<a class="button delete_video">Delete</a>
							
                    </div>
                    <?php
                }
            }
        ?>
					<div class="tt-clearfix video-element add-video">
							Add new...
                    </div>
		</div>
        <?php
    }
} 
add_action('widgets_init', create_function('', 'return register_widget("InkHiveVideoFeed");'));
?>
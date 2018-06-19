<div id="featured-triangle">
<div class="container">
	<div class="popular-articles col-md-12">
		<div class="section-title">
			<?php echo get_theme_mod('revive_slbox_title','Popular Articles'); ?>
		</div>	
		
		<?php /* Start the Loop */ $count=0; ?>
				<?php
		    		$args = array( 'posts_per_page' => 4, 'category' => get_theme_mod('revive_slbox_cat'), 'ignore_sticky_posts' => true );
					$lastposts = get_posts( $args );
					foreach ( $lastposts as $post ) :
					  setup_postdata( $post ); ?>
				
				    <div class="col-md-3 col-sm-6 col-xs-6 imgcontainer">
				    	<div class="popimage">
				        <?php if (has_post_thumbnail()) : ?>	
								<a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_post_thumbnail('revive-poster-thumb'); ?></a>
						<?php else : ?>
								<a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><img src="<?php echo get_template_directory_uri()."/assets/images/placeholder2.jpg"; ?>"></a>
						<?php endif; ?>
							<div class="postdate">
				            	<span class="day"><?php the_time('j'); ?></span>
				            	<span class="month"><?php the_time('M'); ?></span>
				            </div>
				    	</div>	
				    	
				    	<div class="titledesc">
			            	<h2><a href="<?php the_permalink() ?>"><?php echo the_title(); ?></a></h2>
						</div>
				        
				    </div>
				    
				<?php $count++;
				if ($count == 4) break;
				 endforeach; ?>
		
	</div>

</div><!--.container-->
</div>
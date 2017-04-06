<div id="featured-categories">
<div class="container">
<?php if ( get_theme_mod('revive_fcats_enable') && is_home() ) : ?>
	<div class="popular-articles col-md-12">
		<div class="section-title">
			<?php echo get_theme_mod('revive_fcats_title','Popular Articles'); ?>
		</div>	
		
		<div class="cat1 row">
			<div class="cat-name col-md-3 col-sm-6 col-xs-12">
				<span><?php echo get_cat_name(get_theme_mod('revive_fcats_cat')); ?></span>
			</div>
			<?php /* Start the Loop */ $count=0; ?>
				<?php
		    		$args = array( 'posts_per_page' => 3, 'category' => get_theme_mod('revive_fcats_cat'), 'ignore_sticky_posts' => true );
					$lastposts = get_posts( $args );
					foreach ( $lastposts as $post ) :
					  setup_postdata( $post ); ?>
				
				    <div class="col-md-3 col-sm-6 col-xs-12 imgcontainer">
				    	<div class="popimage">
				        <?php if (has_post_thumbnail()) : ?>	
								<a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_post_thumbnail('revive-pop-thumb'); ?></a>
						<?php else : ?>
								<a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><img src="<?php echo get_template_directory_uri()."/assets/images/placeholder2.jpg"; ?>"></a>
						<?php endif; ?>
							
				            <div class="titledesc">
			            		<h2><a href="<?php the_permalink() ?>"><?php echo the_title(); ?></a></h2>
							</div>
				    	</div>	
				    	
				    	
				        
				    </div>
			    
				<?php $count++;
				if ($count == 4) break;
				 endforeach; ?>
		</div>
		<div class="cat2 row">	
			<div class="cat-name col-md-3 col-sm-6 col-xs-12">
				<span><?php echo get_cat_name(get_theme_mod('revive_fcats_cat')); ?></span>
			</div> 
			<?php /* Start the Loop */ $count=0; ?>
				<?php
		    		$args = array( 'posts_per_page' => 3, 'category' => get_theme_mod('revive_fcats_cat2'), 'ignore_sticky_posts' => true );
					$lastposts = get_posts( $args );
					foreach ( $lastposts as $post ) :
					  setup_postdata( $post ); ?>
				
				    <div class="col-md-3 col-sm-6 col-xs-12 imgcontainer">
				    	<div class="popimage">
				        <?php if (has_post_thumbnail()) : ?>	
								<a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_post_thumbnail('revive-pop-thumb'); ?></a>
						<?php else : ?>
								<a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><img src="<?php echo get_template_directory_uri()."/assets/images/placeholder2.jpg"; ?>"></a>
						<?php endif; ?>
							<div class="titledesc">
			            		<h2><a href="<?php the_permalink() ?>"><?php echo the_title(); ?></a></h2>
							</div>
				    	</div>	
				    	
				    	
				        
				    </div>
				    
				<?php $count++;
				if ($count == 4) break;
				 endforeach; ?>
		</div>		 
		
	</div>

<?php endif; ?>
</div><!--.container-->
</div>
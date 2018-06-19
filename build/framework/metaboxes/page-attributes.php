<?php
// -- Page related Meta Boxes
// -- Derived from the core MetaBoxes file.
if ( is_admin()) :
function revive_remove_pageattr_box() {
	remove_meta_box( 'pageparentdiv', 'page', 'side' );
	add_meta_box('pageparentdivnew', 'Configure Page', 'revive_page_attributes_meta_box', 'page', 'side', 'high');
}
add_action( 'admin_menu', 'revive_remove_pageattr_box' );
endif;

/**
 * Display page attributes form fields.
 *
 * @since 2.7.0
 *
 * @param object $post
 */
function revive_page_attributes_meta_box( $post ) {

	wp_nonce_field( basename( __FILE__ ), 'revive_nonce' );
    $revive_stored_meta_attr = get_post_meta( $post->ID );

	$post_type_object = get_post_type_object($post->post_type);
	if ( $post_type_object->hierarchical ) {
		$dropdown_args = array(
			'post_type'        => $post->post_type,
			'exclude_tree'     => $post->ID,
			'selected'         => $post->post_parent,
			'name'             => 'parent_id',
			'show_option_none' => __('(no parent)'),
			'sort_column'      => 'menu_order, post_title',
			'echo'             => 0,
		);

		/**
		 * Filter the arguments used to generate a Pages drop-down element.
		 *
		 * @since 3.3.0
		 *
		 * @see wp_dropdown_pages()
		 *
		 * @param array   $dropdown_args Array of arguments used to generate the pages drop-down.
		 * @param WP_Post $post          The current WP_Post object.
		 */
		$dropdown_args = apply_filters( 'page_attributes_dropdown_pages_args', $dropdown_args, $post );
		$pages = wp_dropdown_pages( $dropdown_args );
		if ( ! empty($pages) ) {
?>
<p><strong><?php _e('Parent') ?></strong></p>
<label class="screen-reader-text" for="parent_id"><?php _e('Parent') ?></label>
<?php echo $pages; ?>
<?php
		} // end empty pages check
	} // end hierarchical check.
	if ( 'page' == $post->post_type && 0 != count( get_page_templates( $post ) ) ) {
		$template = !empty($post->page_template) ? $post->page_template : false;
		?>
<p><strong><?php _e('Template') ?></strong></p>
<label class="screen-reader-text" for="page_template"><?php _e('Page Template') ?></label><select name="page_template" id="page_template">
<?php
/**
 * Filter the title of the default page template displayed in the drop-down.
 *
 * @since 4.1.0
 *
 * @param string $label   The display value for the default page template title.
 * @param string $context Where the option label is displayed. Possible values
 *                        include 'meta-box' or 'quick-edit'.
 */
$default_title = apply_filters( 'default_page_template_title',  __( 'Default Template' ), 'meta-box' );
?> 
<option value="default"><?php echo esc_html( $default_title ); ?></option>
<?php page_template_dropdown($template); ?>
</select>
<?php
	} 

/* The New Category Select Tool */
	?>
	
<script>
	jQuery(document).ready( function() {
		var template = jQuery('#page_template :selected').val();
		if ( template.indexOf('templates/template-blog') == 0)  {
				jQuery("#choose-cat-label").show();
			} else {
				jQuery("#choose-cat-label").hide();
			}
		
		jQuery("#page_template").change( function() {
			var template_new = jQuery('#page_template :selected').val();
			if ( template_new.indexOf('templates/template-blog') == 0)  {
				jQuery("#choose-cat-label").show();
			} else {
				jQuery("#choose-cat-label").css('display','none');
			}
		});
	});
</script>		
<label id="choose-cat-label" for="choose-category">	
<p style="margin-bottom: 2px"><strong><?php _e('Choose Category') ?></strong></p>
<p style="margin-top: 1px; font-style: italic; font-size: 12px;"><?php _e('Choose a Category for the Posts to be displayed. (Optional)') ?></p>
<?php $categories = get_categories(); ?>
<select name="choose-category" id="choose-category">
		<option value="all_c" <?php if ( isset ( $revive_stored_meta_attr['choose-category'] ) ) selected( $revive_stored_meta_attr['choose-category'][0], 'all_c' ); ?> > <?php _e('All Categories (Default)'); ?></option>
	<?php foreach  ( $categories as $c ) : ?>
		<option value="<?php echo $c->cat_ID; ?>" <?php if ( isset ( $revive_stored_meta_attr['choose-category'] ) ) selected( $revive_stored_meta_attr['choose-category'][0], $c->cat_ID ); ?> > <?php echo $c->name; ?></option>
	<?php endforeach; ?>	
</select>
</label>
	
<?php

}

function revive_meta_save_attr( $post_id ) {
	// Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'revive_nonce' ] ) && wp_verify_nonce( $_POST[ 'revive_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    
    // Checks for input and saves if needed
	if( isset( $_POST[ 'choose-category' ] ) ) {
	    update_post_meta( $post_id, 'choose-category', $_POST[ 'choose-category' ] );
	}
    
}
add_action('save_post', 'revive_meta_save_attr');
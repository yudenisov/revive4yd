<?php
/**
 * Adds a meta box to the post editing screen
 */
function revive_custom_meta() {
    add_meta_box( 'revive_meta', __( 'Display Options', 'revive' ), 'revive_meta_callback', 'page','side','high' );
}
add_action( 'add_meta_boxes', 'revive_custom_meta' );

/**
 * Outputs the content of the meta box
 */
 
function revive_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'revive_nonce' );
    $revive_stored_meta = get_post_meta( $post->ID );
    ?>
    
    <p>
	    <div class="revive-row-content">
	        <label for="enable-slider">
	            <input type="checkbox" name="enable-slider" id="enable-slider" value="yes" <?php if ( isset ( $revive_stored_meta['enable-slider'] ) ) checked( $revive_stored_meta['enable-slider'][0], 'yes' ); ?> />
	            <?php _e( 'Enable Slider', 'revive' )?>
	        </label>
	        <br />
	        
	        <label for="enable-box">
	            <input type="checkbox" name="enable-box" id="enable-box" value="yes" <?php if ( isset ( $revive_stored_meta['enable-box'] ) ) checked( $revive_stored_meta['enable-box'][0], 'yes' ); ?> />
	            <?php _e( 'Enable Featured Boxes', 'revive' )?>
	        </label>
	        <br />
	        
	        <label for="enable-fa2">
	            <input type="checkbox" name="enable-fa2" id="enable-fa2" value="yes" <?php if ( isset ( $revive_stored_meta['enable-fa2'] ) ) checked( $revive_stored_meta['enable-fa2'][0], 'yes' ); ?> />
	            <?php _e( 'Enable Featured Area 2', 'revive' )?>
	        </label>
	        <br />
	        
	        <label for="enable-slbox">
	            <input type="checkbox" name="enable-slbox" id="enable-slbox" value="yes" <?php if ( isset ( $revive_stored_meta['enable-slbox'] ) ) checked( $revive_stored_meta['enable-slbox'][0], 'yes' ); ?> />
	            <?php _e( 'Enable Sliding Boxes', 'revive' )?>
	        </label>
	        <br />
	        
	        <label for="enable-fcats">
	            <input type="checkbox" name="enable-fcats" id="enable-fcats" value="yes" <?php if ( isset ( $revive_stored_meta['enable-fcats'] ) ) checked( $revive_stored_meta['enable-fcats'][0], 'yes' ); ?> />
	            <?php _e( 'Enable Featured Categories', 'revive' )?>
	        </label>
	        <br />
	        
	        
	        
	        <label for="hide-title">
	            <input type="checkbox" name="hide-title" id="hide-title" value="yes" <?php if ( isset ( $revive_stored_meta['hide-title'] ) ) checked( $revive_stored_meta['hide-title'][0], 'yes' ); ?> />
	            <?php _e( 'Hide Page Title', 'revive' )?>
	        </label>
	        <br />
	        <label for="enable-full-width">
	            <input type="checkbox" name="enable-full-width" id="enable-full-width" value="yes" <?php if ( isset ( $revive_stored_meta['enable-full-width'] ) ) checked( $revive_stored_meta['enable-full-width'][0], 'yes' ); ?> />
	            <?php _e( 'Enable Full Width', 'revive' )?>
	        </label>
	    </div>
	</p>
 
    <?php
}


/**
 * Saves the custom meta input
 */
function revive_meta_save( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'revive_nonce' ] ) && wp_verify_nonce( $_POST[ 'revive_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'meta-text' ] ) ) {
        update_post_meta( $post_id, 'meta-text', sanitize_text_field( $_POST[ 'meta-text' ] ) );
    }
    
    // Checks for input and saves
	if( isset( $_POST[ 'enable-slider' ] ) ) {
	    update_post_meta( $post_id, 'enable-slider', 'yes' );
	} else {
	    update_post_meta( $post_id, 'enable-slider', '' );
	}
	
	// Checks for input and saves
	if( isset( $_POST[ 'enable-box' ] ) ) {
	    update_post_meta( $post_id, 'enable-box', 'yes' );
	} else {
	    update_post_meta( $post_id, 'enable-box', '' );
	}
	
	// Checks for input and saves
	if( isset( $_POST[ 'enable-fa2' ] ) ) {
	    update_post_meta( $post_id, 'enable-fa2', 'yes' );
	} else {
	    update_post_meta( $post_id, 'enable-fa2', '' );
	}
	
	// Checks for input and saves
	if( isset( $_POST[ 'enable-fcats' ] ) ) {
	    update_post_meta( $post_id, 'enable-fcats', 'yes' );
	} else {
	    update_post_meta( $post_id, 'enable-fcats', '' );
	}
	
	// Checks for input and saves
	if( isset( $_POST[ 'enable-slbox' ] ) ) {
	    update_post_meta( $post_id, 'enable-slbox', 'yes' );
	} else {
	    update_post_meta( $post_id, 'enable-slbox', '' );
	}
	 
	// Checks for input and saves
	if( isset( $_POST[ 'hide-title' ] ) ) {
	    update_post_meta( $post_id, 'hide-title', 'yes' );
	} else {
	    update_post_meta( $post_id, 'hide-title', '' );
	}
	
	// Checks for input and saves
	if( isset( $_POST[ 'enable-full-width' ] ) ) {
	    update_post_meta( $post_id, 'enable-full-width', 'yes' );
	} else {
	    update_post_meta( $post_id, 'enable-full-width', '' );
	}
 
}
add_action( 'save_post', 'revive_meta_save' );
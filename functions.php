<?php 
add_filter('acf/upload_prefilter/name=select_file', 'property_directory', 10, 3 );
add_filter('acf/upload_prefilter/name=pricevariant_dfile_choosefile', 'property_directory', 10, 3 );

function property_directory($errors, $file, $field) {
    // Only allow editors and admins, change capability as you see fit
    if( !current_user_can('edit_pages') ) {
        $errors[] = 'Only Editors and Administrators may upload attachments';
    }
    
    // This filter changes directory just for item being uploaded
    add_filter('upload_dir', 'gist_acf_upload_dir');
    
}

// Custom upload directory
function gist_acf_upload_dir($param) {
    
    // Set to whatever directory you want the ACF file field to upload to
    $custom_dir = '/uploads/restricted_directory';
    $param['path'] = WP_CONTENT_DIR . $custom_dir;
    $param['url'] = WP_CONTENT_URL . $custom_dir;
    return $param;    
}

add_filter('acf/upload_prefilter', 'restrict_upload_directory', 10, 3);

function restrict_upload_directory($errors, $file, $field) {


	if ($field['name'] === 'choosefile') {
        // Define your restricted directory
        $restricted_directory = '/wp-content/uploads/restricted_directory';
          add_filter('upload_dir', 'gist_acf_upload_dir');
        // Check if the upload directory matches the restricted directory
        if (strpos($file['type'], $restricted_directory) === false) {
            // If it doesn't match, add an error
            $errors[] = 'File must be uploaded to ' . $restricted_directory;
        }
    }


}

add_action( 'wp', 'check_cookie_and_redirect_custom_post_type' );
function check_cookie_and_redirect_custom_post_type() {
    // Check if it's a single post of your custom post type
    if ( is_singular() && 'produkte' === get_post_type() ) {
        // Check if the cookie is not set
        if ( ! isset( $_SESSION['mtloggedin'] ) ) {
            // Redirect to another page
            $_SESSION['mtloggedin'] = 1;
            wp_redirect( home_url( '/restricted-login' ) );
            exit();
        }else{
        }
    }
}
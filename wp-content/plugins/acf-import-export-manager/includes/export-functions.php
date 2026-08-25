<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'admin_init', 'acf_dm_handle_export' );
add_action( 'wp_ajax_acf_dm_get_posts_for_type', 'acf_dm_ajax_get_posts_for_type' );
add_action( 'wp_ajax_acf_dm_get_field_groups_for_post_type', 'acf_dm_ajax_get_field_groups_for_post_type' );

/**
 * Handle initial export process.
 */
function acf_dm_handle_export() {
    // Verify nonce and user capabilities
    if ( ! isset( $_POST['acf_dm_export_submit'] ) || ! wp_verify_nonce( $_POST['acf_dm_export_nonce_field'], 'acf_dm_export_nonce' ) ) {
        return;
    }

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'You do not have sufficient permissions to perform this action.', 'acf-data-manager' ) );
    }

    // Sanitize input data
    $export_post_type = isset( $_POST['acf_dm_export_post_type'] ) ? sanitize_text_field( $_POST['acf_dm_export_post_type'] ) : '';
    $export_type      = isset( $_POST['acf_dm_export_type'] ) ? sanitize_text_field( $_POST['acf_dm_export_type'] ) : '';
    $export_format    = isset( $_POST['acf_dm_export_format'] ) ? sanitize_text_field( $_POST['acf_dm_export_format'] ) : 'json';

    if ( empty( $export_post_type ) ) {
        acf_dm_add_admin_notice( __( 'Please select a post type to export.', 'acf-data-manager' ), 'error' );
        return;
    }

    $export_data    = array();
    $filename       = 'acf-export-';
    $content_type   = '';
    $file_extension = '';

    try {
        if ( 'all_options' === $export_post_type ) {
            $export_data = acf_dm_get_all_option_acf_fields();
            $filename   .= 'all-options';
        } else {
            switch ( $export_type ) {
                case 'all_posts':
                    $export_data = acf_dm_get_all_post_type_acf_fields( $export_post_type );
                    $filename   .= 'all-' . sanitize_title( $export_post_type ) . 's';
                    break;
                    
                case 'single_post':
                    $post_id = isset( $_POST['acf_dm_selected_post_export'] ) ? absint( $_POST['acf_dm_selected_post_export'] ) : 0;
                    if ( $post_id ) {
                        $post_data = acf_dm_get_post_acf_fields( $post_id );
                        if ( $post_data ) {
                            $export_data[ $export_post_type . '_' . $post_id ] = array(
                                'post_id'    => $post_id,
                                'post_title' => get_the_title( $post_id ),
                                'post_slug'  => get_post_field( 'post_name', $post_id ),
                                'post_type'  => $export_post_type,
                                'acf_fields' => $post_data
                            );
                        }
                        $filename .= 'single-' . sanitize_title( $export_post_type ) . '-' . get_post_field( 'post_name', $post_id );
                    } else {
                        acf_dm_add_admin_notice( __( 'Please select a post to export.', 'acf-data-manager' ), 'error' );
                        return;
                    }
                    break;
                    
                case 'single_field_group':
                    $post_id = isset( $_POST['acf_dm_selected_post_export'] ) ? absint( $_POST['acf_dm_selected_post_export'] ) : 0;
                    $field_group_key = isset( $_POST['acf_dm_selected_field_group_export'] ) ? sanitize_text_field( $_POST['acf_dm_selected_field_group_export'] ) : '';
                    
                    if ( $post_id && $field_group_key ) {
                        $acf_fields = acf_dm_get_single_field_group_acf_fields( $post_id, $field_group_key );
                        if ( empty( $acf_fields ) ) {
                            acf_dm_add_admin_notice( __( 'No fields found in the selected field group.', 'acf-data-manager' ), 'error' );
                            return;
                        }
                        
                        $post_title_slug = sanitize_title( get_the_title( $post_id ) );
                        $field_group = acf_get_field_group( $field_group_key );
                        $field_group_title_slug = $field_group ? sanitize_title( $field_group['title'] ) : 'unknown';
                        
                        $filename .= 'fg-' . $field_group_title_slug . '-from-' . $post_title_slug;
                        $export_data[ $export_post_type . '_' . $post_id ] = array(
                            'post_id'    => $post_id,
                            'post_title' => get_the_title( $post_id ),
                            'post_slug'  => get_post_field( 'post_name', $post_id ),
                            'post_type'  => $export_post_type,
                            'acf_fields' => $acf_fields
                        );
                    } else {
                        acf_dm_add_admin_notice( __( 'Please select a post and a field group to export.', 'acf-data-manager' ), 'error' );
                        return;
                    }
                    break;
                    
                default:
                    acf_dm_add_admin_notice( __( 'Invalid export type selected.', 'acf-data-manager' ), 'error' );
                    return;
            }
        }

        if ( empty( $export_data ) ) {
            acf_dm_add_admin_notice( __( 'No data found for the selected export options.', 'acf-data-manager' ), 'error' );
            return;
        }

        // Prepare output based on format
        if ( 'json' === $export_format ) {
            $output_content = wp_json_encode( $export_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
            $content_type   = 'application/json';
            $file_extension = 'json';
        } else { // XML
            $output_content = acf_dm_array_to_xml( $export_data );
            $content_type   = 'text/xml';
            $file_extension = 'xml';
        }

        // Send headers and output
        nocache_headers();
        header( 'Content-Description: File Transfer' );
        header( 'Content-Type: ' . $content_type );
        header( 'Content-Disposition: attachment; filename="' . $filename . '-' . date( 'YmdHis' ) . '.' . $file_extension . '"' );
        header( 'Expires: 0' );
        header( 'Cache-Control: must-revalidate' );
        header( 'Pragma: public' );
        header( 'Content-Length: ' . strlen( $output_content ) );
        
        echo $output_content;
        exit;
        
    } catch ( Exception $e ) {
        acf_dm_add_admin_notice( sprintf( __( 'Export failed: %s', 'acf-data-manager' ), $e->getMessage() ), 'error' );
        return;
    }
}

/**
 * Helper function to add admin notices.
 */
function acf_dm_add_admin_notice( $message, $type = 'success' ) {
    add_action( 'admin_notices', function() use ( $message, $type ) {
        printf(
            '<div class="notice notice-%s is-dismissible"><p>%s</p></div>',
            esc_attr( $type ),
            esc_html( $message )
        );
    });
}

/**
 * AJAX handler to get posts for a given post type.
 */
function acf_dm_ajax_get_posts_for_type() {
    check_ajax_referer( 'acf_dm_nonce', '_wpnonce' );

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( __( 'You do not have sufficient permissions to perform this action.', 'acf-data-manager' ) );
    }

    $post_type = isset( $_POST['post_type'] ) ? sanitize_text_field( $_POST['post_type'] ) : '';
    if ( empty( $post_type ) ) {
        wp_send_json_error( __( 'Post type parameter is required.', 'acf-data-manager' ) );
    }

    $posts = get_posts( array(
        'post_type'      => $post_type,
        'posts_per_page' => -1,
        'post_status'    => 'any',
        'orderby'        => 'title',
        'order'          => 'ASC',
    ) );

    $options = array();
    foreach ( $posts as $post ) {
        $options[] = array(
            'id'    => $post->ID,
            'title' => $post->post_title . ' (ID: ' . $post->ID . ')',
        );
    }

    wp_send_json_success( $options );
}

/**
 * AJAX handler to get field groups for a given post type.
 */
function acf_dm_ajax_get_field_groups_for_post_type() {
    check_ajax_referer( 'acf_dm_nonce', '_wpnonce' );

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( __( 'You do not have sufficient permissions to perform this action.', 'acf-data-manager' ) );
    }

    $post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;
    if ( ! $post_id ) {
        wp_send_json_error( __( 'Post ID parameter is required.', 'acf-data-manager' ) );
    }

    $field_groups = array();
    if ( function_exists( 'acf_get_field_groups' ) ) {
        $groups = acf_get_field_groups( array( 'post_id' => $post_id ) );
        foreach ( $groups as $group ) {
            $field_groups[$group['key']] = $group['title'];
        }
    }

    wp_send_json_success( $field_groups );
}

/**
 * Helper function to get ACF fields for a specific post/page.
 *
 * @param int $post_id The ID of the post.
 * @return array The ACF field data.
 */
function acf_dm_get_post_acf_fields( $post_id ) {
    $data = array();
    // Get all ACF fields for the post, including custom post types
    $fields = get_fields( $post_id );
    if ( $fields ) {
        foreach ( $fields as $field_name => $field_value ) {
            $field_object = get_field_object( $field_name, $post_id );
            if ( $field_object ) {
                $data[ $field_name ] = array(
                    'label' => $field_object['label'],
                    'value' => $field_value,
                );
            }
        }
    }
    return $data;
}

/**
 * Helper function to get all ACF fields for a given post type.
 *
 * @param string $post_type The post type slug.
 * @return array An array of all ACF data for the post type.
 */
function acf_dm_get_all_post_type_acf_fields( $post_type ) {
    $all_posts_data = array();
    $posts = get_posts( array(
        'post_type'      => $post_type,
        'posts_per_page' => -1,
        'post_status'    => 'any',
    ) );
    foreach ( $posts as $post ) {
        $acf_data = acf_dm_get_post_acf_fields( $post->ID );
        if ( ! empty( $acf_data ) ) {
            $all_posts_data[ $post_type . '_' . $post->ID ] = array(
                'post_id'    => $post->ID,
                'post_title' => $post->post_title,
                'post_slug'  => $post->post_name,
                'post_type'  => $post_type,
                'acf_fields' => $acf_data,
            );
        }
    }
    return $all_posts_data;
}

/**
 * Helper function to get a single field group's ACF fields from a post.
 *
 * @param int    $post_id The ID of the post.
 * @param string $field_group_key The key of the field group.
 * @return array The ACF field data for the specified group.
 */
function acf_dm_get_single_field_group_acf_fields( $post_id, $field_group_key ) {
    $data = array();
    if ( function_exists( 'acf_get_fields' ) ) {
        $fields = acf_get_fields( $field_group_key );
        foreach ( $fields as $field ) {
            $field_value = get_field( $field['name'], $post_id );
            $data[ $field['name'] ] = array(
                'label' => $field['label'],
                'value' => $field_value,
            );
        }
    }
    return $data;
}

/**
 * Helper function to get ACF fields from all option pages.

 * Converts an associative array to XML.
 * This is a recursive implementation that handles nested arrays correctly for SimpleXMLElement.
 * IMPORTANT: JSON is generally more robust for complex data like repeaters.
 *
 * @param array $array The data to convert.
 * @param SimpleXMLElement|null $xml The XML object to append to (for recursion).
 * @return string The XML string.
 */
function acf_dm_array_to_xml( $array, $xml = null ) {
    if ( $xml === null ) {
        $xml = new SimpleXMLElement( '<acf_export/>' );
    }

    foreach ( $array as $key => $value ) {
        // Handle numeric keys (for repeater rows, etc.)
        if ( is_numeric( $key ) ) {
            $key = 'row'; // Use 'row' or 'item' for repeater rows. Must be consistent with import.
        }
        // Ensure key is a valid XML tag name (no spaces, special chars, etc.)
        $key = preg_replace( '/[^a-zA-Z0-9_]/', '', $key );
        if ( empty( $key ) ) {
            $key = 'unknown_key'; // Fallback for invalid keys
        }

        if ( is_array( $value ) ) {
            // Check if it's an associative array (object in XML) or indexed array (multiple child elements)
            $is_associative = array_keys( $value ) !== range( 0, count( $value ) - 1 );

            if ( $is_associative || count($value) === 0 ) {
                 // Treat as an object/structure
                acf_dm_array_to_xml( $value, $xml->addChild( $key ) );
            } else {
                // Treat as a list of elements, add multiple children with the same key name
                foreach ($value as $item) {
                     acf_dm_array_to_xml( $item, $xml->addChild( $key ) );
                }
            }
        } else {
            $xml->addChild( $key, htmlspecialchars( $value ) );
        }
    }
    return $xml->asXML();
}

/**
 * Helper function to get ACF fields from all option pages.
 *
 * @return array The ACF field data for all option pages.
 */
function acf_dm_get_all_option_acf_fields() {
    $data = array();
    if ( function_exists( 'acf_get_fields' ) ) {
        $field_groups = acf_get_field_groups();
        foreach ( $field_groups as $group ) {
            if ( isset( $group['location'][0][0]['param'] ) && 'options_page' === $group['location'][0][0]['param'] ) {
                $fields = acf_get_fields( $group['key'] );
                foreach ( $fields as $field ) {
                    $field_value = get_field( $field['name'], 'option' );
                    $data[ $field['name'] ] = array(
                        'label' => $field['label'],
                        'value' => $field_value,
                    );
                }
            }
        }
    }
    return $data;
}
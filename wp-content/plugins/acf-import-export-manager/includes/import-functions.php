<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
//add_action( 'admin_init', 'acf_dm_ajax_process_import_file' );
add_action( 'wp_ajax_acf_dm_process_import_file', 'acf_dm_ajax_process_import_file' );
add_action( 'wp_ajax_acf_dm_perform_mapped_import', 'acf_dm_ajax_perform_mapped_import' );


/**
 * AJAX handler for processing the uploaded import file (first step).
 * Parses the file and determines if mapping is needed.
 */
function acf_dm_ajax_process_import_file() {
    check_ajax_referer( 'acf_dm_import_nonce', 'acf_dm_import_nonce_field' );

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( array( 'message' => __( 'You do not have sufficient permissions to perform this action.', 'acf-data-manager' ) ) );
    }

    if ( empty( $_FILES['acf_dm_import_file']['name'] ) ) {
        wp_send_json_error( array( 'message' => __( 'Please select a file to import.', 'acf-data-manager' ) ) );
    }

    $file      = $_FILES['acf_dm_import_file'];
    $file_type = wp_check_filetype( $file['name'], array( 'xml' => 'text/xml', 'json' => 'application/json' ) );

    if ( ! in_array( $file_type['type'], array( 'text/xml', 'application/json' ) ) ) {
        wp_send_json_error( array( 'message' => __( 'Invalid file type. Please upload an XML or JSON file.', 'acf-data-manager' ) ) );
    }

    $file_contents = file_get_contents( $file['tmp_name'] );
    if ( empty( $file_contents ) ) {
        wp_send_json_error( array( 'message' => __( 'The uploaded file is empty.', 'acf-data-manager' ) ) );
    }

    $imported_data = array();
    if ( 'text/xml' === $file_type['type'] ) {
        $imported_data = acf_dm_xml_to_array( $file_contents );
    } elseif ( 'application/json' === $file_type['type'] ) {
        $imported_data = json_decode( $file_contents, true );
    }

    if ( empty( $imported_data ) ) {
        wp_send_json_error( array( 'message' => __( 'Could not parse the imported file. Please check its format.', 'acf-data-manager' ) ) );
    }

    $is_all_export = false;
    $items_to_map = array();

    if(isset($imported_data['post_id']) && isset($imported_data['post_type']) && isset($imported_data['post_slug'])) {
        // Check if the imported data is structured as a single post export
        $is_all_export = true;
        $items_to_map[] = array(
            'source_id'    => $imported_data['post_id'],
            'source_title' => $imported_data['post_title'],
            'source_slug'  => $imported_data['post_slug'],
            'source_type'  => $imported_data['post_type'],
            'acf_fields'   => $imported_data['acf_fields']
        );
    } else {
        // Check if the imported data is structured as an 'all posts' export
        foreach ( $imported_data as $key => $item_data ) {
            // Check if the key indicates a post type and if it has post_slug and post_type data
            if ( isset( $item_data['post_slug'] ) && isset( $item_data['post_type'] ) && str_ends_with($key, (string)$item_data['post_id']) ) {
                $is_all_export = true;
                $items_to_map[] = array(
                    'source_id'    => $item_data['post_id'],
                    'source_title' => $item_data['post_title'],
                    'source_slug'  => $item_data['post_slug'],
                    'source_type'  => $item_data['post_type'],
                    'acf_fields'   => $item_data['acf_fields']
                );
            } else {
                // If any item doesn't match this structure, it's a single export
                $is_all_export = false;
                break;
            }
        }
    }

    if ( $is_all_export ) {
        $mapping_html = acf_dm_generate_mapping_table( $items_to_map );
        wp_send_json_success( array(
            'is_all_export'      => true,
            'mapping_html'       => $mapping_html,
            'file_contents_data' => $imported_data
        ) );
    } else {
        // Not an 'all posts' export, proceed with direct import
        wp_send_json_success( array(
            'is_all_export' => false,
            'message'       => __( 'Proceeding with direct import.', 'acf-data-manager' )
        ) );
    }
}

/**
 * Generates the HTML for the mapping table.
 *
 * @param array $items_to_map Array of source items from the export file.
 * @return string HTML for the mapping table.
 */
function acf_dm_generate_mapping_table( $items_to_map ) {
    ob_start();
    ?>
    <table>
        <thead>
            <tr>
                <th><?php _e( 'Source Item (from file)', 'acf-data-manager' ); ?></th>
                <th><?php _e( 'Action', 'acf-data-manager' ); ?></th>
                <th><?php _e( 'Target Item (on this site)', 'acf-data-manager' ); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $items_to_map as $item ) :
                $source_id    = esc_attr( $item['source_id'] );
                $source_title = esc_html( $item['source_title'] );
                $source_slug  = esc_html( $item['source_slug'] );
                $source_type  = esc_attr( $item['source_type'] );

                $current_posts_args = array(
                    'post_type'      => $source_type,
                    'posts_per_page' => -1,
                    'post_status'    => 'any',
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                    'suppress_filters' => true,
                );
                $current_posts = get_posts( $current_posts_args );

                $auto_selected_id = 0;
                $existing_post_by_slug = get_page_by_path( $source_slug, OBJECT, $source_type );
                if ( $existing_post_by_slug ) {
                    $auto_selected_id = $existing_post_by_slug->ID;
                }
            ?>
                <tr class="acf-dm-mapping-row" data-source-id="<?php echo $source_id; ?>" data-source-type="<?php echo $source_type; ?>">
                    <td>
                        <strong><?php echo ucfirst( $source_type ); ?>:</strong> <?php echo $source_title; ?><br>
                        <small>(Slug: <?php echo $source_slug; ?>, Source ID: <?php echo $source_id; ?>)</small>
                    </td>
                    <td>
                        <select class="acf-dm-action-select">
                            <option><?php _e( 'Please select', 'acf-data-manager' ); ?></option>
                            <option value="map_existing" <?php selected( $auto_selected_id != 0 ); ?>><?php _e( 'Map to Existing', 'acf-data-manager' ); ?></option>
                            <option value="create_new"><?php _e( 'Create New', 'acf-data-manager' ); ?></option>
                            <option value="skip"><?php _e( 'Skip', 'acf-data-manager' ); ?></option>
                        </select>
                    </td>
                    <td>
                        <div class="acf-dm-target-select-wrapper" style="<?php echo ($auto_selected_id != 0) ? 'display: block;' : 'display: none;'; ?>">
                            <select class="acf-dm-target-select">
                                <option value=""><?php _e( 'Select Existing ' . ucfirst( $source_type ), 'acf-data-manager' ); ?></option>
                                <?php foreach ( $current_posts as $p ) : ?>
                                    <option value="<?php echo esc_attr( $p->ID ); ?>" <?php selected( $p->ID, $auto_selected_id ); ?>>
                                        <?php echo esc_html( $p->post_title ); ?> (ID: <?php echo $p->ID; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="acf-dm-new-title-wrapper" style="display: none;">
                            <input type="text" class="acf-dm-new-title-input" placeholder="<?php _e( 'Enter New ' . ucfirst( $source_type ) . ' Title', 'acf-data-manager' ); ?>" value="<?php echo $source_title; ?>">
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
    return ob_get_clean();
}

/**
 * AJAX handler for performing the final mapped import.
 */
function acf_dm_ajax_perform_mapped_import() {
    check_ajax_referer( 'acf_dm_mapping_nonce', 'acf_dm_mapping_nonce_field' );

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( array( 'message' => __( 'You do not have sufficient permissions to perform this action.', 'acf-data-manager' ) ) );
    }

    $mapping_data_json = isset( $_POST['acf_dm_mapping_data'] ) ? wp_unslash( $_POST['acf_dm_mapping_data'] ) : '[]';
    $imported_file_contents_json = isset( $_POST['acf_dm_import_file_contents'] ) ? wp_unslash( $_POST['acf_dm_import_file_contents'] ) : '{}';
    $import_overwrite = isset( $_POST['acf_dm_mapping_overwrite'] ) && $_POST['acf_dm_mapping_overwrite'] === '1';

    $mappings = json_decode( $mapping_data_json, true );
    $full_imported_data = json_decode( $imported_file_contents_json, true );

    if ( empty( $mappings ) || empty( $full_imported_data ) ) {
        wp_send_json_error( array( 'message' => __( 'Invalid mapping data or imported file contents provided.', 'acf-data-manager' ) ) );
    }

    $import_count = 0;
    $errors = array();

    foreach ( $mappings as $mapping ) {
        $source_id   = $mapping['source_id'];
        $source_type = $mapping['source_type'];
        $target_id   = intval( $mapping['target_id'] );
        $action      = $mapping['action'];
        $new_title   = sanitize_text_field( $mapping['new_title'] );

        $data_key = $source_type . '_' . $source_id;
        $item_data = isset( $full_imported_data[ $data_key ] ) ? $full_imported_data[ $data_key ] : null;

        if ( ! $item_data ) {
            $errors[] = sprintf( __( 'Could not find ACF data for source %s (ID: %s). Skipping.', 'acf-data-manager' ), $source_type, $source_id );
            continue;
        }

        $target_post_id = 0;

        switch ( $action ) {
            case 'map_existing':
                if ( $target_id && get_post_status( $target_id ) ) {
                    if ( get_post_type( $target_id ) === $source_type ) {
                        $target_post_id = $target_id;
                    } else {
                        $errors[] = sprintf( __( 'Mapped target (ID: %d) is a %s, but source is a %s. Skipping import for source ID %s.', 'acf-data-manager' ), $target_id, get_post_type($target_id), $source_type, $source_id );
                        continue 2;
                    }
                } else {
                    $errors[] = sprintf( __( 'Selected target %s (ID: %d) does not exist or is invalid. Skipping import for source ID %s.', 'acf-data-manager' ), $source_type, $target_id, $source_id );
                    continue 2;
                }
                break;
            case 'create_new':
                if ( ! empty( $new_title ) ) {
                    $new_post_args = array(
                        'post_title'   => $new_title,
                        'post_type'    => $source_type,
                        'post_status'  => 'publish',
                    );
                    $new_post_id = wp_insert_post( $new_post_args, true );

                    if ( ! is_wp_error( $new_post_id ) ) {
                        $target_post_id = $new_post_id;
                        wp_update_post( array(
                            'ID'        => $new_post_id,
                            'post_name' => $item_data['post_slug'],
                        ) );
                    } else {
                        $errors[] = sprintf( __( 'Failed to create new %s "%s": %s. Skipping import for source ID %s.', 'acf-data-manager' ), $source_type, $new_title, $new_post_id->get_error_message(), $source_id );
                        continue 2;
                    }
                } else {
                    $errors[] = sprintf( __( 'New %s title cannot be empty for source ID %s. Skipping.', 'acf-data-manager' ), $source_type, $source_id );
                    continue 2;
                }
                break;
            case 'skip':
                continue 2;
            default:
                $errors[] = sprintf( __( 'Invalid action "%s" for source ID %s. Skipping.', 'acf-data-manager' ), $action, $source_id );
                continue 2;
        }

        if ( $target_post_id ) {
            $acf_fields = isset($item_data['acf_fields']) ? $item_data['acf_fields'] : $item_data;
            foreach ( $acf_fields as $field_name => $field_info ) {
                if ( isset( $field_info['value'] ) ) {
                    $field_value = $field_info['value'];
                    if ( $import_overwrite || ! get_field( $field_name, $target_post_id, false ) ) {
                        $updated = update_field( $field_name, $field_value, $target_post_id );
                        if ( $updated ) {
                            $import_count++;
                        }
                    }
                }
            }
        }
    }

    $response = array( 'message' => sprintf( _n( '%d field imported successfully.', '%d fields imported successfully.', $import_count, 'acf-data-manager' ), $import_count ) );
    if ( ! empty( $errors ) ) {
        $response['errors'] = $errors;
    }

    wp_send_json_success( $response );
}

/**
 * Convert XML to array
 *
 * @param string $xml XML string to convert
 * @return array Converted array or empty array on failure
 */
function acf_dm_xml_to_array($xml) {
    if (empty($xml)) {
        return array();
    }

    libxml_use_internal_errors(true);
    $obj = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
    
    if (false === $obj) {
        return array();
    }

    $json = wp_json_encode($obj);
    if (false === $json) {
        return array();
    }

    return json_decode($json, true);
}
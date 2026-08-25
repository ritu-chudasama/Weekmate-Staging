<?php
/**
 * ACF Data Manager - Admin Menu Functions
 *
 * @package     ACF Data Manager
 * @version     1.0.0
 * @author      Your Name
 * @copyright   Copyright (c) Your Company
 * @license     GPL-2.0+
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add admin menu item for ACF Data Manager
 *
 * @return void
 */
function acf_dm_add_admin_menu() {
    add_management_page(
        esc_html__('ACF Data Manager', 'acf-data-manager'),
        esc_html__('ACF Data Manager', 'acf-data-manager'),
        'manage_options',
        'acf-data-manager',
        'acf_dm_render_admin_page'
    );
}
add_action('admin_menu', 'acf_dm_add_admin_menu');

/**
 * Render the admin page content
 *
 * @return void
 */
function acf_dm_render_admin_page() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        wp_die(esc_html__('You do not have sufficient permissions to access this page.', 'acf-data-manager'));
    }

    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('ACF Data Manager', 'acf-data-manager'); ?></h1>

        <h2 class="nav-tab-wrapper">
            <a href="#export" class="nav-tab nav-tab-active"><?php echo esc_html__('Export', 'acf-data-manager'); ?></a>
            <a href="#import" class="nav-tab"><?php echo esc_html__('Import', 'acf-data-manager'); ?></a>
        </h2>

        <div id="export" class="tab-content current">
            <h3><?php echo esc_html__('Export ACF Fields', 'acf-data-manager'); ?></h3>
            <form method="post" action="">
                <?php wp_nonce_field('acf_dm_export_nonce', 'acf_dm_export_nonce_field'); ?>

                <div class="acf-dm-export-options">
                    <h4><?php echo esc_html__('Select Post Type:', 'acf-data-manager'); ?></h4>
                    <select name="acf_dm_export_post_type" id="acf_dm_export_post_type">
                        <option value=""><?php echo esc_html__('Select Post Type', 'acf-data-manager'); ?></option>
                        <?php
                        $post_types = get_post_types(array('public' => true), 'objects');
                        foreach ($post_types as $post_type) {
                            if ($post_type->name !== 'attachment') {
                                echo '<option value="' . esc_attr($post_type->name) . '">' . 
                                     esc_html($post_type->labels->singular_name) . '</option>';
                            }
                        }
                        ?>
                        <option value="all_options"><?php echo esc_html__('All Option Pages', 'acf-data-manager'); ?></option>
                    </select>
                </div>
                
                <div class="acf-dm-export-radios" style="display:none;">
                    <h4><?php echo esc_html__('Export Options:', 'acf-data-manager'); ?></h4>
                    <label>
                        <input type="radio" name="acf_dm_export_type" value="all_posts">
                        <?php echo esc_html__('All Posts', 'acf-data-manager'); ?>
                    </label><br>
                    <label>
                        <input type="radio" name="acf_dm_export_type" value="single_post">
                        <?php echo esc_html__('Single Post', 'acf-data-manager'); ?>
                    </label>
                    <div id="acf_dm_single_post_dropdown" style="display:none;"></div><br>
                    <label>
                        <input type="radio" name="acf_dm_export_type" value="single_field_group">
                        <?php echo esc_html__('Single Field Group', 'acf-data-manager'); ?>
                    </label>
                    <div id="acf_dm_posts_options" style="display:none;"></div>
                    <div id="acf_dm_single_field_group_options" style="display:none;"></div>
                </div>

                <h4><?php echo esc_html__('Export Format:', 'acf-data-manager'); ?></h4>
                <p>
                    <label>
                        <input type="radio" name="acf_dm_export_format" value="json" checked>
                        <?php echo esc_html__('JSON', 'acf-data-manager'); ?>
                    </label>
                    <label>
                        <input type="radio" name="acf_dm_export_format" value="xml">
                        <?php echo esc_html__('XML', 'acf-data-manager'); ?>
                    </label>
                </p>

                <p class="submit">
                    <input type="submit" name="acf_dm_export_submit" id="acf-dm-export-submit" 
                           class="button button-primary" 
                           value="<?php echo esc_attr__('Export Data', 'acf-data-manager'); ?>">
                </p>
            </form>
        </div>

        <div id="import" class="tab-content">
            <h3><?php echo esc_html__('Import ACF Fields', 'acf-data-manager'); ?></h3>
            <form id="acf-dm-upload-form" method="post" enctype="multipart/form-data" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php 
                wp_nonce_field('acf_dm_import_nonce', 'acf_dm_import_nonce_field'); 
                ?>
                <input type="hidden" name="action" value="acf_dm_handle_import">

                <div class="acf-dm-import-options">
                    <h4><?php echo esc_html__('Target Post Type:', 'acf-data-manager'); ?></h4>
                    <select name="acf_dm_import_post_type" id="acf_dm_import_post_type">
                        <option value=""><?php echo esc_html__('Select Post Type', 'acf-data-manager'); ?></option>
                        <?php
                        $post_types = get_post_types(array('public' => true), 'objects');
                        foreach ($post_types as $post_type) {
                            if ($post_type->name !== 'attachment') {
                                echo '<option value="' . esc_attr($post_type->name) . '">' . 
                                     esc_html($post_type->labels->singular_name) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <h4><?php echo esc_html__('Import File:', 'acf-data-manager'); ?></h4>
                <p>
                    <input type="file" name="acf_dm_import_file" id="acf_dm_import_file" 
                           accept=".json,.xml,application/json,text/xml" required>
                    <small><?php 
                        echo esc_html__('Allowed formats: JSON, XML. Maximum size: ', 'acf-data-manager') . 
                             esc_html(size_format(wp_max_upload_size())); 
                    ?></small>
                </p>
                <p>
                    <label>
                        <input type="checkbox" name="acf_dm_import_overwrite" value="1">
                        <?php echo esc_html__('Overwrite existing ACF fields with the same name?', 'acf-data-manager'); ?>
                    </label>
                </p>
                <p class="submit">
                    <input type="submit" name="acf_dm_import_submit" id="acf-dm-import-submit" 
                           class="button button-primary" 
                           value="<?php echo esc_attr__('Upload and Import', 'acf-data-manager'); ?>">
                </p>
            </form>

            <div id="acf-dm-import-loading" style="display:none;">
                <p><strong><?php echo esc_html__('Processing file...', 'acf-data-manager'); ?></strong></p>
            </div>
            
            <div id="acf-dm-mapping-container" style="display:none;">
                <h3><?php echo esc_html__('Import Mapping Required', 'acf-data-manager'); ?></h3>
                <p><?php echo esc_html__('The imported file contains multiple items. Please map them to existing posts or create new ones.', 'acf-data-manager'); ?></p>
                <form id="acf-dm-mapping-form" method="post">
                    <?php wp_nonce_field('acf_dm_mapping_nonce', 'acf_dm_mapping_nonce_field'); ?>
                    <input type="hidden" name="acf_dm_import_file_contents" id="acf-dm-import-file-contents-input" value="">
                    <input type="hidden" name="acf_dm_mapping_overwrite" id="acf-dm-mapping-overwrite-input" value="0">
                    <div id="acf-dm-mapping-table-wrapper"></div>
                    <p class="submit">
                        <input type="submit" name="acf_dm_mapping_submit" class="button button-primary" 
                               value="<?php echo esc_attr__('Perform Import', 'acf-data-manager'); ?>">
                    </p>
                </form>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Enqueue admin scripts and styles
 *
 * @param string $hook_suffix Current admin page hook
 * @return void
 */
function acf_dm_enqueue_admin_scripts($hook_suffix) {
    if ('tools_page_acf-data-manager' !== $hook_suffix) {
        return;
    }

    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    wp_enqueue_style(
        'acf-dm-admin-css', 
        ACF_DM_URL . 'assets/css/admin.css', 
        array(), 
        ACF_DM_VERSION
    );
    
    wp_enqueue_script(
        'acf-dm-admin-js', 
        ACF_DM_URL . 'assets/js/admin.js', 
        array('jquery'),
        ACF_DM_VERSION, 
        array('in_footer' => true)
    );
    
    wp_localize_script('acf-dm-admin-js', 'acf_dm_obj', array(
        'ajaxurl' => esc_url(admin_url('admin-ajax.php')),
        '_nonce' => wp_create_nonce('acf_dm_nonce'),
        'maxUploadSize' => wp_max_upload_size(),
        'fileTypeError' => esc_html__('Invalid file type. Please upload a JSON or XML file.', 'acf-data-manager'),
        'fileSizeError' => esc_html__('File size exceeds maximum allowed limit.', 'acf-data-manager'),
        'fileRequiredText' => esc_html__('Please select a file to import.', 'acf-data-manager'),
        'loadingText' => esc_html__('Loading...', 'acf-data-manager'),
        'selectPostText' => esc_html__('Select a Post', 'acf-data-manager'),
        'selectFieldGroupText' => esc_html__('Select Field Group', 'acf-data-manager'),
        'noPostsText' => esc_html__('No posts found.', 'acf-data-manager'),
        'noFieldGroupsText' => esc_html__('No field groups found.', 'acf-data-manager'),
        'fieldGroupText' => esc_html__('Field Group:', 'acf-data-manager'),
        'errorText' => esc_html__('An error occurred. Please try again.', 'acf-data-manager'),
        'confirmImportText' => esc_html__('Are you sure you want to perform the import with the current mappings? This action cannot be undone.', 'acf-data-manager'),
        'postTypeRequiredText' => esc_html__('Please select posttype', 'acf-data-manager')
    ));
}
add_action('admin_enqueue_scripts', 'acf_dm_enqueue_admin_scripts');
/**
 * ACF Data Manager - Admin JavaScript
 *
 * @package     ACF Data Manager
 * @version     1.0.0
 * @author      Elsner Technologies Pvt. Ltd.
 * @copyright   Copyright (c) Elsner Technologies Pvt. Ltd. 2025
 * @license     GPL-2.0+
 */

jQuery(document).ready(function($) {
    'use strict';

    /**
     * Initialize admin interface
     */
    function initAdminInterface() {
        // Simple tab switching for the admin page
        $('.nav-tab-wrapper a').on('click', function(e) {
            e.preventDefault();
            $('.nav-tab').removeClass('nav-tab-active');
            $(this).addClass('nav-tab-active');
            $('.tab-content').hide();
            $($(this).attr('href')).show();
        });

        // Show the export tab by default
        $('#export').show();
        $('#import').hide();
    }

    /**
     * Initialize export form logic
     */
    function initExportForm() {
        $('#acf_dm_export_post_type').on('change', function() {
            var postType = $(this).val();
            if (postType === '' || postType === 'all_options') {
                $('.acf-dm-export-radios').hide();
                $('#acf-dm-export-submit').prop('disabled', postType === '');
            } else {
                $('.acf-dm-export-radios').show();
                // Reset and hide dynamic dropdowns
                $('#acf_dm_single_post_dropdown').hide().empty();
                $('#acf_dm_single_field_group_options').hide().empty();
                $('#acf-dm-export-submit').prop('disabled', true);
            }
        });

        $('input[name="acf_dm_export_type"]').on('change', function() {
            var exportType = $(this).val();
            var postType = $('#acf_dm_export_post_type').val();
            $('#acf-dm-export-submit').prop('disabled', false);

            $('#acf_dm_single_post_dropdown').hide();
            $('#acf_dm_single_field_group_options').hide();

            $('select[name="acf_dm_selected_post_export"]').remove();
            
            if (exportType === 'single_post') {
                $('#acf-dm-export-submit').prop('disabled', true);
                $('#acf_dm_single_post_dropdown').show();
                populatePostsDropdown(postType, '#acf_dm_single_post_dropdown');
            } else if (exportType === 'single_field_group') {
                $('#acf-dm-export-submit').prop('disabled', true);
                $('#acf_dm_posts_options').show();
                populatePostsDropdown(postType, '#acf_dm_posts_options');
            }
        });

        $(document).on('change', 'select[name="acf_dm_selected_post_export"]', function() {
            var exportType = $('input[name="acf_dm_export_type"]:checked').val();
            if (exportType === 'single_field_group') {
                var postType = $('#acf_dm_export_post_type').val();
                var postId = $(this).val();
                $('#acf-dm-export-submit').prop('disabled', false);
                populateFieldGroupOptions(postType, postId, '#acf_dm_single_field_group_options');
            }
        });
    }

    /**
     * Populate posts dropdown via AJAX
     * @param {string} postType - The post type to query
     * @param {string} containerId - The container to populate
     */
    function populatePostsDropdown(postType, containerId) {
        var $container = $(containerId);
        $container.html('<p>' + acf_dm_obj.loadingText + '</p>');

        $.ajax({
            url: acf_dm_obj.ajaxurl,
            type: 'POST',
            data: {
                action: 'acf_dm_get_posts_for_type',
                post_type: postType,
                _wpnonce: acf_dm_obj._nonce
            },
            success: function(response) {
                if (response.success && response.data && response.data.length > 0) {
                    var select = '<select name="acf_dm_selected_post_export" id="acf_dm_selected_post_export">';
                    select += '<option value="">' + acf_dm_obj.selectPostText + '</option>';
                    $.each(response.data, function(index, post) {
                        if (post.id && post.title) {
                            select += '<option value="' + esc_attr(post.id) + '">' + esc_html(post.title) + '</option>';
                        }
                    });
                    select += '</select>';
                    $container.html(select);
                    $container.find('select').on('change', function() {
                        $('#acf-dm-export-submit').prop('disabled', $(this).val() === '');
                    });
                } else {
                    $container.html('<p>' + acf_dm_obj.noPostsText + '</p>');
                }
            },
            error: function(xhr, status, error) {
                $container.html('<p class="error">' + acf_dm_obj.errorText + '</p>');
                console.error('AJAX Error:', status, error);
            }
        });
    }

    /**
     * Populate field group options via AJAX
     * @param {string} postType - The post type
     * @param {string} postId - The post ID
     * @param {string} containerId - The container to populate
     */
    function populateFieldGroupOptions(postType, postId, containerId) {
        var $container = $(containerId);
        $container.html('<p>' + acf_dm_obj.loadingText + '</p>');

        $.ajax({
            url: acf_dm_obj.ajaxurl,
            type: 'POST',
            data: {
                action: 'acf_dm_get_field_groups_for_post_type',
                post_type: postType,
                post_id: postId,
                _wpnonce: acf_dm_obj._nonce,
            },
            success: function(response) {
                debugger;
                if (response.success && response.data && Object.keys(response.data).length > 0) {
                    $('#acf_dm_single_field_group_options').show();

                    var fieldGroupSelect = '<select name="acf_dm_selected_field_group_export" id="acf_dm_selected_field_group_export">';
                    fieldGroupSelect += '<option value="">' + acf_dm_obj.selectFieldGroupText + '</option>';
                    $.each(response.data, function(key, title) {
                        if (key && title) {
                            fieldGroupSelect += '<option value="' + esc_attr(key) + '">' + esc_html(title) + '</option>';
                        }
                    });
                    fieldGroupSelect += '</select>';
                    $container.html('<p>' + acf_dm_obj.fieldGroupText + '</p>' + fieldGroupSelect);
                } else {
                    $container.html('<p>' + acf_dm_obj.noFieldGroupsText + '</p>');
                }
            },
            error: function(xhr, status, error) {
                $container.html('<p class="error">' + acf_dm_obj.errorText + '</p>');
                console.error('AJAX Error:', status, error);
            }
        });
    }

    /**
     * Initialize import form logic
     */
    function initImportForm() {
        $('#acf-dm-upload-form').on('submit', function(e) {
            e.preventDefault();

            var postTypeSelect = $('#acf_dm_import_post_type');
            if(postTypeSelect.val() === '') {
                alert(acf_dm_obj.postTypeRequiredText);
                return;
            }
            

            // Basic client-side validation
            var fileInput = $('#acf_dm_import_file')[0];
            if (!fileInput.files || !fileInput.files[0]) {
                alert(acf_dm_obj.fileRequiredText);
                return;
            }

            var file = fileInput.files[0];
            if (file.size > acf_dm_obj.maxUploadSize) {
                alert(acf_dm_obj.fileSizeError);
                return;
            }

            var validTypes = ['application/json', 'text/xml'];
            if (validTypes.indexOf(file.type) === -1) {
                alert(acf_dm_obj.fileTypeError);
                return;
            }

            var formData = new FormData(this);
            formData.append('action', 'acf_dm_process_import_file');
            formData.append('acf_dm_import_nonce_field', $('input[name="acf_dm_import_nonce_field"]').val());

            $('#acf-dm-import-loading').show();
            $('#acf-dm-upload-form').hide();
            $('#acf-dm-mapping-container').hide();

            $.ajax({
                url: acf_dm_obj.ajaxurl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#acf-dm-import-loading').hide();
                    if (response.success) {
                        if (response.data.is_all_export) {
                            // Show mapping interface
                            $('#acf-dm-mapping-table-wrapper').html(response.data.mapping_html);
                            $('#acf-dm-import-file-contents-input').val(JSON.stringify(response.data.file_contents_data));
                            $('#acf-dm-mapping-overwrite-input').val($('input[name="acf_dm_import_overwrite"]').is(':checked') ? '1' : '0');
                            $('#acf-dm-mapping-container').show();
                        } else {
                            // It's a single item, proceed with direct import
                            var directImportFormData = new FormData($('#acf-dm-upload-form')[0]);
                            directImportFormData.append('acf_dm_import_submit', '1');

                            $.ajax({
                                url: acf_dm_obj.ajaxurl,
                                type: 'POST',
                                data: directImportFormData,
                                processData: false,
                                contentType: false,
                                success: function(directResponse) {
                                    $('#acf-dm-upload-form').show();
                                    if (directResponse.success) {
                                        location.reload();
                                    } else {
                                        alert(directResponse.data.message || acf_dm_obj.errorText);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    $('#acf-dm-upload-form').show();
                                    console.error("Direct import AJAX error:", status, error);
                                    alert(acf_dm_obj.errorText);
                                }
                            });
                        }
                    } else {
                        $('#acf-dm-upload-form').show();
                        alert(response.data.message || acf_dm_obj.errorText);
                    }
                },
                error: function(xhr, status, error) {
                    $('#acf-dm-import-loading').hide();
                    $('#acf-dm-upload-form').show();
                    console.error("AJAX error:", status, error);
                    alert(acf_dm_obj.errorText);
                }
            });
        });

        // Handle mapping form submission
        $('#acf-dm-mapping-form').on('submit', function(e) {
            e.preventDefault();
            if (confirm(acf_dm_obj.confirmImportText)) {
                var formData = new FormData(this);
                formData.append('action', 'acf_dm_perform_mapped_import');
                formData.append('acf_dm_mapping_nonce_field', $('input[name="acf_dm_mapping_nonce_field"]').val());

                var mappings = [];
                $('.acf-dm-mapping-row').each(function() {
                    var $row = $(this);
                    var action = $row.find('.acf-dm-action-select').val();
                    var targetId = $row.find('.acf-dm-target-select').val();
                    var newTitle = $row.find('.acf-dm-new-title-input').val();
                    var sourceId = $row.data('source-id');
                    var sourceType = $row.data('source-type');

                    if (action === 'map_existing' && targetId) {
                        mappings.push({ 
                            source_id: sourceId, 
                            source_type: sourceType, 
                            action: action, 
                            target_id: targetId 
                        });
                    } else if (action === 'create_new' && newTitle) {
                        mappings.push({ 
                            source_id: sourceId, 
                            source_type: sourceType, 
                            action: action, 
                            new_title: newTitle 
                        });
                    } else if (action === 'skip') {
                        mappings.push({ 
                            source_id: sourceId, 
                            source_type: sourceType, 
                            action: action 
                        });
                    }
                });

                formData.append('acf_dm_mapping_data', JSON.stringify(mappings));

                $('#acf-dm-mapping-container').hide();
                $('#acf-dm-import-loading').show();

                $.ajax({
                    url: acf_dm_obj.ajaxurl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.data.message || acf_dm_obj.errorText);
                            location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Mapping AJAX error:", status, error);
                        alert(acf_dm_obj.errorText);
                    }
                });
            }
        });

        // Dynamic mapping table logic
        $(document).on('change', '.acf-dm-action-select', function() {
            var action = $(this).val();
            var $row = $(this).closest('.acf-dm-mapping-row');
            $row.find('.acf-dm-target-select-wrapper, .acf-dm-new-title-wrapper').hide();
            if (action === 'map_existing') {
                $row.find('.acf-dm-target-select-wrapper').show();
            } else if (action === 'create_new') {
                $row.find('.acf-dm-new-title-wrapper').show();
            }
        });
    }

    /**
     * Helper function to escape HTML
     */
    function esc_html(text) {
        return $('<div>').text(text).html();
    }

    /**
     * Helper function to escape attributes
     */
    function esc_attr(text) {
        return $('<div>').text(text).html().replace(/"/g, '&quot;');
    }

    // Initialize everything
    initAdminInterface();
    initExportForm();
    initImportForm();
});
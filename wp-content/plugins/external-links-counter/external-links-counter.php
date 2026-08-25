<?php
/**
 * Plugin Name: External Links Counter
 * Plugin URI: https://linkpublishers.com/
 * Description: Displays the count of external links in each post and page within the WordPress admin. Sends email notification to admin when posts/pages with external links are created. All external links are treated as nofollow by default.
 * Version: 1.3.0
 * Author: Link Publishers
 * Author URI: https://linkpublishers.com/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: external-links-counter
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class External_Links_Counter {
    
    private $site_host;
    
    public function __construct() {
        $this->site_host = parse_url(home_url(), PHP_URL_HOST);
        
        // Add custom column to posts list
        add_filter('manage_posts_columns', array($this, 'add_external_links_column'));
        add_action('manage_posts_custom_column', array($this, 'display_external_links_count'), 10, 2);
        
        // Add custom column to pages list
        add_filter('manage_pages_columns', array($this, 'add_external_links_column'));
        add_action('manage_pages_custom_column', array($this, 'display_external_links_count'), 10, 2);
        
        // Make the column sortable for posts and pages
        add_filter('manage_edit-post_sortable_columns', array($this, 'make_column_sortable'));
        add_filter('manage_edit-page_sortable_columns', array($this, 'make_column_sortable'));
        add_action('pre_get_posts', array($this, 'sort_by_external_links'));
        
        // Add admin styles
        add_action('admin_head', array($this, 'admin_styles'));
        
        // Add detail page
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        // Add link to view details in row actions (posts and pages)
        add_filter('post_row_actions', array($this, 'add_row_action'), 10, 2);
        add_filter('page_row_actions', array($this, 'add_row_action'), 10, 2);
        
        // Hook into post/page save to send email notification for external links
        add_action('save_post', array($this, 'check_and_notify_external_links'), 10, 3);
        
        // Add settings page for email notifications
        add_action('admin_menu', array($this, 'add_settings_submenu'));
        add_action('admin_init', array($this, 'register_settings'));
        
        // **NEW: Add nofollow to external links when saving posts (BACKEND)**
        add_filter('content_save_pre', array($this, 'add_nofollow_on_save'), 10, 1);
        add_filter('excerpt_save_pre', array($this, 'add_nofollow_on_save'), 10, 1);
        
        // **SAFETY: Also filter on frontend display (double protection)**
        add_filter('the_content', array($this, 'add_nofollow_to_external_links'), 999);
        add_filter('the_excerpt', array($this, 'add_nofollow_to_external_links'), 999);
    }
    
    /**
     * **NEW FUNCTION: Add rel="nofollow" when saving post content (BACKEND)**
     * This modifies the actual content in the database
     */
    public function add_nofollow_on_save($content) {
        // Only process if we're actually saving a post (not during other admin actions)
        if (!isset($_POST['post_ID']) && !isset($_POST['post_id'])) {
            return $content;
        }
        
        // Process all links in the content
        $content = preg_replace_callback(
            '/<a([^>]*)href=["\']([^"\']+)["\']([^>]*)>(.*?)<\/a>/si',
            array($this, 'process_link_for_save'),
            $content
        );
        
        return $content;
    }
    
    /**
     * **NEW FUNCTION: Callback to process each link when saving**
     */
    private function process_link_for_save($matches) {
        $before_href = $matches[1];
        $url = $matches[2];
        $after_href = $matches[3];
        $link_text = $matches[4];
        
        // Check if this is an external link
        if (!$this->is_external_link($url)) {
            // Internal link - return unchanged
            return $matches[0];
        }
        
        // This is an external link - process it
        $full_attributes = $before_href . $after_href;
        
        // CHECK FOR DOFOLLOW: If it exists, return the link immediately without adding nofollow
        if (preg_match('/rel=["\']([^"\']*)["\']/', $full_attributes, $rel_matches)) {
            if (strpos(strtolower($rel_matches[1]), 'dofollow') !== false) {
                return $matches[0];
            }
        }

        // Check if rel attribute already exists
        if (preg_match('/rel=["\']([^"\']*)["\']/', $full_attributes, $rel_matches)) {
            $existing_rel = $rel_matches[1];
            $rel_values = array_map('trim', explode(' ', $existing_rel));
            
            // Add nofollow if it's not already there
            if (!in_array('nofollow', $rel_values)) {
                $rel_values[] = 'nofollow';
            }
            
            // Rebuild the rel attribute
            $new_rel = implode(' ', array_unique($rel_values));
            $full_attributes = preg_replace(
                '/rel=["\'][^"\']*["\']/',
                'rel="' . esc_attr($new_rel) . '"',
                $full_attributes
            );
        } else {
            // No rel attribute exists - add it
            $full_attributes .= ' rel="nofollow"';
        }
        
        // Rebuild the link - ensure proper spacing
        $before_href = rtrim($before_href);
        $after_href = ltrim($after_href);
        
        if (!empty($before_href)) {
            $before_href .= ' ';
        }
        if (!empty($after_href)) {
            $after_href = ' ' . $after_href;
        }
        
        return '<a' . $before_href . 'href="' . esc_url($url) . '"' . $after_href . '>' . $link_text . '</a>';
    }
    
    /**
     * **SAFETY: Add rel="nofollow" to all external links in content on frontend display**
     * This is a safety measure in case content was created before plugin activation
     */
    public function add_nofollow_to_external_links($content) {
        // Don't process in admin area
        if (is_admin()) {
            return $content;
        }
        
        // Match all anchor tags with href
        $content = preg_replace_callback(
            '/<a([^>]*)href=["\']([^"\']+)["\']([^>]*)>(.*?)<\/a>/si',
            array($this, 'process_link_callback'),
            $content
        );
        
        return $content;
    }
    
    /**
     * **SAFETY: Callback to process each link on frontend**
     */
    private function process_link_callback($matches) {
        $before_href = $matches[1];
        $url = $matches[2];
        $after_href = $matches[3];
        $link_text = $matches[4];
        
        // Check if this is an external link
        if (!$this->is_external_link($url)) {
            // Internal link - return unchanged
            return $matches[0];
        }
        
        // This is an external link - process it
        $full_attributes = $before_href . $after_href;

        // CHECK FOR DOFOLLOW: Skip adding nofollow if dofollow is present
        if (preg_match('/rel=["\']([^"\']*)["\']/', $full_attributes, $rel_matches)) {
            if (strpos(strtolower($rel_matches[1]), 'dofollow') !== false) {
                return $matches[0];
            }
        }

        // Check if rel attribute already exists
        if (preg_match('/rel=["\']([^"\']*)["\']/', $full_attributes, $rel_matches)) {
            $existing_rel = $rel_matches[1];
            $rel_values = array_map('trim', explode(' ', $existing_rel));
            
            // Add nofollow if it's not already there
            if (!in_array('nofollow', $rel_values)) {
                $rel_values[] = 'nofollow';
            }
            
            // Rebuild the rel attribute
            $new_rel = implode(' ', array_unique($rel_values));
            $full_attributes = preg_replace(
                '/rel=["\'][^"\']*["\']/',
                'rel="' . esc_attr($new_rel) . '"',
                $full_attributes
            );
        } else {
            // No rel attribute exists - add it
            $full_attributes .= ' rel="nofollow"';
        }
        
        // Rebuild the link
        return '<a' . $before_href . 'href="' . esc_url($url) . '"' . $after_href . $full_attributes . '>' . $link_text . '</a>';
    }
    
    /**
     * Add the External Links column to posts list
     */
    public function add_external_links_column($columns) {
        $new_columns = array();
        foreach ($columns as $key => $value) {
            $new_columns[$key] = $value;
            if ($key === 'title') {
                $new_columns['external_links'] = __('External Links', 'external-links-counter');
            }
        }
        return $new_columns;
    }
    
    /**
     * Display the external links count in the column
     */
    public function display_external_links_count($column, $post_id) {
        if ($column === 'external_links') {
            $count = $this->count_external_links($post_id);
            $color = $this->get_count_color($count);
            
            if ($count > 0) {
                $detail_url = admin_url('admin.php?page=external-links-detail&post_id=' . $post_id);
                echo '<a href="' . esc_url($detail_url) . '" class="elc-count" style="background-color: ' . $color . ';" title="Click to view external links">' . $count . '</a>';
            } else {
                echo '<span class="elc-count elc-zero" style="background-color: ' . $color . ';">0</span>';
            }
        }
    }
    
    /**
     * Get color based on count
     */
    private function get_count_color($count) {
        if ($count === 0) {
            return '#e0e0e0';
        } elseif ($count <= 3) {
            return '#4caf50';
        } elseif ($count <= 7) {
            return '#ff9800';
        } else {
            return '#f44336';
        }
    }
    
    /**
     * Count external links in a post
     */
    public function count_external_links($post_id) {
        $external_links = $this->get_external_links($post_id);
        return count($external_links);
    }
    /**
     * Multiple email adding
     */
    public function sanitize_multiple_emails($emails) {
    $emails = explode(',', $emails);
    $clean  = array();

    foreach ($emails as $email) {
        $email = trim($email);
        if (is_email($email)) {
            $clean[] = $email;
        }
    }

    return implode(',', $clean);
}

    /**
     * Get all external links from a post
     */
    public function get_external_links($post_id) {
        $post = get_post($post_id);
        if (!$post) {
            return array();
        }
        
        $content = $post->post_content;
        $external_links = array();
        
        // Match all anchor tags with href (capture full tag to extract rel attribute)
        preg_match_all('/<a([^>]*)href=["\']([^"\']+)["\']([^>]*)>(.*?)<\/a>/si', $content, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $match) {
            $before_href = $match[1];
            $url = $match[2];
            $after_href = $match[3];
            $anchor_text = wp_strip_all_tags($match[4]);
            $full_tag = $before_href . $after_href;
            
            if ($this->is_external_link($url)) {
                // Extract rel attribute
                $rel = '';
                if (preg_match('/rel=["\']([^"\']*)["\']/', $full_tag, $rel_match)) {
                    $rel = $rel_match[1];
                }
                
                // Determine SEO status based on rel attribute
                $seo_status = $this->get_seo_status($rel);

                // If no rel attribute exists, default to nofollow, otherwise keep what was found
                if (empty($rel)) {
                    $seo_status = 'nofollow';
                    $rel = 'nofollow';
                }
                
                $external_links[] = array(
                    'url' => $url,
                    'anchor_text' => $anchor_text,
                    'domain' => parse_url($url, PHP_URL_HOST),
                    'rel' => $rel,
                    'seo_status' => $seo_status
                );
            }
        }
        
        return $external_links;
    }
    
    /**
     * Get SEO status based on rel attribute
     * ALL EXTERNAL LINKS DEFAULT TO NOFOLLOW
     */
    private function get_seo_status($rel) {
        $rel = strtolower($rel);
        $statuses = array();
        
        // Check for dofollow first
        if (strpos($rel, 'dofollow') !== false) {
            return 'dofollow';
        }

        // Check for nofollow
        if (strpos($rel, 'nofollow') !== false) {
            $statuses[] = 'nofollow';
        }
        
        // Check for noindex (usually in robots meta, but some use it in links)
        if (strpos($rel, 'noindex') !== false) {
            $statuses[] = 'noindex';
        }
        
        // Check for sponsored
        if (strpos($rel, 'sponsored') !== false) {
            $statuses[] = 'sponsored';
        }
        
        // Check for ugc (user generated content)
        if (strpos($rel, 'ugc') !== false) {
            $statuses[] = 'ugc';
        }
        
        // If no SEO-related rel attributes found, DEFAULT TO NOFOLLOW
        if (empty($statuses)) {
            return 'nofollow';
        }
        
        return implode(', ', $statuses);
    }
    
    /**
     * Render SEO status tag with appropriate styling
     * RED for nofollow (default for all external links)
     */
    private function render_seo_status_tag($seo_status) {
        $colors = $this->get_seo_status_colors($seo_status);
        
        return '<span class="elc-seo-tag" style="display: inline-block; padding: 3px 8px; background-color: ' . esc_attr($colors['bg']) . '; color: ' . esc_attr($colors['text']) . '; border-radius: 3px; font-size: 12px; font-weight: 500;">' . esc_html($seo_status) . '</span>';
    }
    
    /**
     * Get colors for SEO status
     * RED BACKGROUND FOR NOFOLLOW (default for all external links)
     */
    private function get_seo_status_colors($seo_status) {
        $status_lower = strtolower($seo_status);
        
        // DOFOLLOW = Green (rare case)
        if ($status_lower === 'dofollow' || $status_lower === 'index, follow') {
            return array('bg' => '#4caf50', 'text' => '#ffffff');
        }

        // NOFOLLOW = RED (default for all external links)
        if (strpos($status_lower, 'nofollow') !== false) {
            return array('bg' => '#f44336', 'text' => '#ffffff'); // Red background, white text
        }
        
        // NOINDEX = Dark Red
        if (strpos($status_lower, 'noindex') !== false) {
            return array('bg' => '#d32f2f', 'text' => '#ffffff');
        }
        
        // SPONSORED = Orange
        if (strpos($status_lower, 'sponsored') !== false) {
            return array('bg' => '#ff9800', 'text' => '#ffffff');
        }
        
        // UGC = Blue
        if (strpos($status_lower, 'ugc') !== false) {
            return array('bg' => '#2196f3', 'text' => '#ffffff');
        }
        
        // Default = RED (all external links are nofollow by default)
        return array('bg' => '#f44336', 'text' => '#ffffff');
    }
    
    /**
     * Get post/page SEO status from popular SEO plugins
     */
    public function get_post_seo_status($post_id) {
        $index_status = 'index';
        $follow_status = 'follow';
        
        // Check Yoast SEO
        if (defined('WPSEO_VERSION')) {
            $noindex = get_post_meta($post_id, '_yoast_wpseo_meta-robots-noindex', true);
            $nofollow = get_post_meta($post_id, '_yoast_wpseo_meta-robots-nofollow', true);
            
            if ($noindex === '1') {
                $index_status = 'noindex';
            }
            if ($nofollow === '1') {
                $follow_status = 'nofollow';
            }
        }
        
        // Check Rank Math
        if (class_exists('RankMath')) {
            $robots = get_post_meta($post_id, 'rank_math_robots', true);
            if (is_array($robots)) {
                if (in_array('noindex', $robots)) {
                    $index_status = 'noindex';
                }
                if (in_array('nofollow', $robots)) {
                    $follow_status = 'nofollow';
                }
            }
        }
        
        // Check All in One SEO
        if (defined('AIOSEO_VERSION') || class_exists('AIOSEO\\Plugin\\AIOSEO')) {
            $aioseo_noindex = get_post_meta($post_id, '_aioseo_noindex', true);
            $aioseo_nofollow = get_post_meta($post_id, '_aioseo_nofollow', true);
            
            if ($aioseo_noindex === '1' || $aioseo_noindex === true) {
                $index_status = 'noindex';
            }
            if ($aioseo_nofollow === '1' || $aioseo_nofollow === true) {
                $follow_status = 'nofollow';
            }
        }
        
        // Check SEOPress
        if (defined('SEOPRESS_VERSION')) {
            $seopress_noindex = get_post_meta($post_id, '_seopress_robots_index', true);
            $seopress_nofollow = get_post_meta($post_id, '_seopress_robots_follow', true);
            
            if ($seopress_noindex === 'yes') {
                $index_status = 'noindex';
            }
            if ($seopress_nofollow === 'yes') {
                $follow_status = 'nofollow';
            }
        }
        
        // Check The SEO Framework
        if (defined('THE_SEO_FRAMEWORK_VERSION')) {
            $tsf_noindex = get_post_meta($post_id, '_genesis_noindex', true);
            $tsf_nofollow = get_post_meta($post_id, '_genesis_nofollow', true);
            
            if ($tsf_noindex === '1') {
                $index_status = 'noindex';
            }
            if ($tsf_nofollow === '1') {
                $follow_status = 'nofollow';
            }
        }
        
        return $index_status . ', ' . $follow_status;
    }
    
    /**
     * Check if a URL is external
     */
    private function is_external_link($url) {
        // Skip empty URLs, anchors, javascript, mailto, tel
        if (empty($url) || 
            strpos($url, '#') === 0 || 
            strpos($url, 'javascript:') === 0 ||
            strpos($url, 'mailto:') === 0 ||
            strpos($url, 'tel:') === 0) {
            return false;
        }
        
        // Relative URLs are internal
        if (strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0 && strpos($url, '//') !== 0) {
            return false;
        }
        
        // Parse the URL and check the host
        $url_host = parse_url($url, PHP_URL_HOST);
        
        if (empty($url_host)) {
            return false;
        }
        
        // Remove www. for comparison
        $url_host = preg_replace('/^www\./i', '', $url_host);
        $site_host = preg_replace('/^www\./i', '', $this->site_host);
        
        return $url_host !== $site_host;
    }
    
    /**
     * Make the column sortable
     */
    public function make_column_sortable($columns) {
        $columns['external_links'] = 'external_links';
        return $columns;
    }
    
    /**
     * Handle sorting by external links
     */
    public function sort_by_external_links($query) {
        if (!is_admin() || !$query->is_main_query()) {
            return;
        }
        
        if ($query->get('orderby') === 'external_links') {
            // We'll use a meta query approach
            // First, we need to store the count as meta
            $this->update_all_external_link_counts();
            
            $query->set('meta_key', '_external_links_count');
            $query->set('orderby', 'meta_value_num');
        }
    }
    
    /**
     * Update external link counts for all posts and pages (used for sorting)
     */
    private function update_all_external_link_counts() {
        global $wpdb;
        
        $posts = $wpdb->get_col("SELECT ID FROM {$wpdb->posts} WHERE post_type IN ('post', 'page') AND post_status IN ('publish', 'draft', 'pending')");
        
        foreach ($posts as $post_id) {
            $count = $this->count_external_links($post_id);
            update_post_meta($post_id, '_external_links_count', $count);
        }
    }
    
    /**
     * Add admin styles
     */
    public function admin_styles() {
        ?>
        <style>
            .column-external_links {
                width: 100px;
                text-align: center;
            }
            .elc-count {
                display: inline-block;
                min-width: 28px;
                padding: 4px 8px;
                border-radius: 4px;
                color: #fff;
                font-weight: bold;
                text-align: center;
                text-decoration: none;
                font-size: 13px;
            }
            .elc-count:hover {
                opacity: 0.85;
                color: #fff;
            }
            .elc-zero {
                color: #666;
            }
            .elc-detail-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                background: #fff;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }
            .elc-detail-table th,
            .elc-detail-table td {
                padding: 12px 15px;
                text-align: left;
                border-bottom: 1px solid #e0e0e0;
            }
            .elc-detail-table th {
                background: #f5f5f5;
                font-weight: 600;
            }
            .elc-detail-table tr:hover {
                background: #fafafa;
            }
            .elc-detail-table .url-cell {
                max-width: 400px;
                word-break: break-all;
            }
            .elc-back-link {
                display: inline-block;
                margin-bottom: 20px;
            }
            .elc-summary-box {
                background: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                margin-bottom: 20px;
            }
            .elc-summary-box h3 {
                margin-top: 0;
            }
            .elc-domain-tag {
                display: inline-block;
                padding: 2px 8px;
                background: #e3f2fd;
                color: #1565c0;
                border-radius: 3px;
                font-size: 12px;
            }
            .elc-type-tag {
                display: inline-block;
                padding: 2px 8px;
                border-radius: 3px;
                font-size: 11px;
                font-weight: 500;
            }
            .elc-type-post {
                background: #fff3e0;
                color: #e65100;
            }
            .elc-type-page {
                background: #e8f5e9;
                color: #2e7d32;
            }
            /* Red styling for nofollow tags */
            .elc-seo-tag {
                font-weight: 600 !important;
            }
        </style>
        <?php
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_submenu_page(
            null, // Hidden from menu
            __('External Links Detail', 'external-links-counter'),
            __('External Links Detail', 'external-links-counter'),
            'edit_posts',
            'external-links-detail',
            array($this, 'render_detail_page')
        );
        
        // Add main menu page for overview
        add_menu_page(
            __('External Links', 'external-links-counter'),
            __('External Links', 'external-links-counter'),
            'edit_posts',
            'external-links-overview',
            array($this, 'render_overview_page'),
            'dashicons-admin-links',
            30
        );
    }
    
    /**
     * Render the detail page
     */
    public function render_detail_page() {
        $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
        
        if (!$post_id) {
            echo '<div class="wrap"><h1>Invalid Post</h1></div>';
            return;
        }
        
        $post = get_post($post_id);
        if (!$post) {
            echo '<div class="wrap"><h1>Post Not Found</h1></div>';
            return;
        }
        
        $external_links = $this->get_external_links($post_id);
        $is_page = $post->post_type === 'page';
        $back_url = $is_page ? admin_url('edit.php?post_type=page') : admin_url('edit.php');
        $back_text = $is_page ? __('Back to Pages', 'external-links-counter') : __('Back to Posts', 'external-links-counter');
        
        ?>
        <div class="wrap">
            <a href="<?php echo $back_url; ?>" class="elc-back-link">&larr; <?php echo $back_text; ?></a>
            
            <h1><?php echo esc_html__('External Links in:', 'external-links-counter') . ' ' . esc_html($post->post_title); ?></h1>
            
            <div class="elc-summary-box">
                <h3><?php esc_html_e('Summary', 'external-links-counter'); ?></h3>
                <p>
                    <strong><?php esc_html_e('Total External Links:', 'external-links-counter'); ?></strong> 
                    <?php echo count($external_links); ?>
                </p>
                <p>
                    <strong><?php esc_html_e('SEO Status:', 'external-links-counter'); ?></strong> 
                    <?php 
                    $post_seo_status = $this->get_post_seo_status($post_id);
                    echo $this->render_seo_status_tag($post_seo_status);
                    ?>
                </p>
                <?php
                $domains = array_count_values(array_column($external_links, 'domain'));
                if (!empty($domains)) {
                    echo '<p><strong>' . esc_html__('Domains:', 'external-links-counter') . '</strong> ';
                    foreach ($domains as $domain => $count) {
                        echo '<span class="elc-domain-tag">' . esc_html($domain) . ' (' . $count . ')</span> ';
                    }
                    echo '</p>';
                }
                ?>
                <p>
                    <a href="<?php echo get_edit_post_link($post_id); ?>" class="button button-primary">
                        <?php esc_html_e('Edit Post', 'external-links-counter'); ?>
                    </a>
                    <a href="<?php echo get_permalink($post_id); ?>" class="button" target="_blank">
                        <?php esc_html_e('View Post', 'external-links-counter'); ?>
                    </a>
                </p>
            </div>
            
            <?php if (!empty($external_links)) : ?>
                <table class="elc-detail-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php esc_html_e('Anchor Text', 'external-links-counter'); ?></th>
                            <th><?php esc_html_e('URL', 'external-links-counter'); ?></th>
                            <th><?php esc_html_e('Domain', 'external-links-counter'); ?></th>
                            <th><?php esc_html_e('SEO Status', 'external-links-counter'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($external_links as $index => $link) : ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo esc_html($link['anchor_text'] ?: '(no anchor text)'); ?></td>
                                <td class="url-cell">
                                    <a href="<?php echo esc_url($link['url']); ?>" target="_blank" rel="noopener noreferrer">
                                        <?php echo esc_html($link['url']); ?>
                                    </a>
                                </td>
                                <td>
                                    <span class="elc-domain-tag"><?php echo esc_html($link['domain']); ?></span>
                                </td>
                                <td>
                                    <?php echo $this->render_seo_status_tag($link['seo_status']); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p><?php esc_html_e('No external links found in this post.', 'external-links-counter'); ?></p>
            <?php endif; ?>
        </div>
        <?php
    }
    
    /**
     * Render overview page
     */
    public function render_overview_page() {
        global $wpdb;
        
        // Get current filter
        $current_type = isset($_GET['content_type']) ? sanitize_text_field($_GET['content_type']) : 'all';
        
        // Get all posts and pages with external links
        $post_types = array('post', 'page');
        if ($current_type === 'post') {
            $post_types = array('post');
        } elseif ($current_type === 'page') {
            $post_types = array('page');
        }
        
        $items = get_posts(array(
            'post_type' => $post_types,
            'post_status' => array('publish', 'draft', 'pending'),
            'numberposts' => -1,
        ));
        
        $items_data = array();
        $total_links = 0;
        $all_domains = array();
        $posts_count = 0;
        $pages_count = 0;
        
        foreach ($items as $item) {
            $links = $this->get_external_links($item->ID);
            $count = count($links);
            $total_links += $count;
            
            if ($item->post_type === 'post') {
                $posts_count++;
            } else {
                $pages_count++;
            }
            
            foreach ($links as $link) {
                if (!empty($link['domain'])) {
                    $all_domains[] = $link['domain'];
                }
            }
            
            $items_data[] = array(
                'id' => $item->ID,
                'title' => $item->post_title,
                'count' => $count,
                'status' => $item->post_status,
                'type' => $item->post_type,
            );
        }
        
        // Sort by count descending
        usort($items_data, function($a, $b) {
            return $b['count'] - $a['count'];
        });
        
        $domain_counts = array_count_values($all_domains);
        arsort($domain_counts);
        
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('External Links Overview', 'external-links-counter'); ?></h1>
            
            <div class="elc-summary-box">
                <h3><?php esc_html_e('Statistics', 'external-links-counter'); ?></h3>
                <p>
                    <strong><?php esc_html_e('Total Posts:', 'external-links-counter'); ?></strong> 
                    <?php echo $posts_count; ?>
                    &nbsp;&nbsp;|&nbsp;&nbsp;
                    <strong><?php esc_html_e('Total Pages:', 'external-links-counter'); ?></strong> 
                    <?php echo $pages_count; ?>
                </p>
                <p>
                    <strong><?php esc_html_e('Total External Links:', 'external-links-counter'); ?></strong> 
                    <?php echo $total_links; ?>
                </p>
                <p>
                    <strong><?php esc_html_e('Content with External Links:', 'external-links-counter'); ?></strong> 
                    <?php echo count(array_filter($items_data, function($p) { return $p['count'] > 0; })); ?>
                </p>
            </div>
            
            <?php if (!empty($domain_counts)) : ?>
            <div class="elc-summary-box">
                <h3><?php esc_html_e('Top Linked Domains', 'external-links-counter'); ?></h3>
                <p>
                    <?php 
                    $top_domains = array_slice($domain_counts, 0, 10, true);
                    foreach ($top_domains as $domain => $count) {
                        echo '<span class="elc-domain-tag">' . esc_html($domain) . ' (' . $count . ')</span> ';
                    }
                    ?>
                </p>
            </div>
            <?php endif; ?>
            
            <h2><?php esc_html_e('Posts & Pages by External Link Count', 'external-links-counter'); ?></h2>
            
            <!-- Filter tabs -->
            <ul class="subsubsub" style="margin-bottom: 15px;">
                <li>
                    <a href="<?php echo admin_url('admin.php?page=external-links-overview&content_type=all'); ?>" 
                       class="<?php echo $current_type === 'all' ? 'current' : ''; ?>">
                        <?php esc_html_e('All', 'external-links-counter'); ?>
                    </a> |
                </li>
                <li>
                    <a href="<?php echo admin_url('admin.php?page=external-links-overview&content_type=post'); ?>"
                       class="<?php echo $current_type === 'post' ? 'current' : ''; ?>">
                        <?php esc_html_e('Posts', 'external-links-counter'); ?>
                    </a> |
                </li>
                <li>
                    <a href="<?php echo admin_url('admin.php?page=external-links-overview&content_type=page'); ?>"
                       class="<?php echo $current_type === 'page' ? 'current' : ''; ?>">
                        <?php esc_html_e('Pages', 'external-links-counter'); ?>
                    </a>
                </li>
            </ul>
            
            <table class="elc-detail-table">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Title', 'external-links-counter'); ?></th>
                        <th><?php esc_html_e('Type', 'external-links-counter'); ?></th>
                        <th><?php esc_html_e('Status', 'external-links-counter'); ?></th>
                        <th><?php esc_html_e('External Links', 'external-links-counter'); ?></th>
                        <th><?php esc_html_e('Actions', 'external-links-counter'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items_data as $item) : ?>
                        <tr>
                            <td><?php echo esc_html($item['title']); ?></td>
                            <td>
                                <span class="elc-type-tag elc-type-<?php echo esc_attr($item['type']); ?>">
                                    <?php echo esc_html(ucfirst($item['type'])); ?>
                                </span>
                            </td>
                            <td><?php echo esc_html(ucfirst($item['status'])); ?></td>
                            <td>
                                <?php 
                                $color = $this->get_count_color($item['count']);
                                echo '<span class="elc-count" style="background-color: ' . $color . ';">' . $item['count'] . '</span>';
                                ?>
                            </td>
                            <td>
                                <?php if ($item['count'] > 0) : ?>
                                    <a href="<?php echo admin_url('admin.php?page=external-links-detail&post_id=' . $item['id']); ?>">
                                        <?php esc_html_e('View Links', 'external-links-counter'); ?>
                                    </a> |
                                <?php endif; ?>
                                <a href="<?php echo get_edit_post_link($item['id']); ?>">
                                    <?php esc_html_e('Edit', 'external-links-counter'); ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
    
    /**
     * Add row action to view external links
     */
    public function add_row_action($actions, $post) {
        $count = $this->count_external_links($post->ID);
        if ($count > 0) {
            $detail_url = admin_url('admin.php?page=external-links-detail&post_id=' . $post->ID);
            $actions['view_external_links'] = '<a href="' . esc_url($detail_url) . '">' . 
                sprintf(__('View %d External Links', 'external-links-counter'), $count) . '</a>';
        }
        return $actions;
    }
    
    /**
     * Add settings submenu
     */
    public function add_settings_submenu() {
        add_submenu_page(
            'external-links-overview',
            __('Email Settings', 'external-links-counter'),
            __('Email Settings', 'external-links-counter'),
            'manage_options',
            'external-links-settings',
            array($this, 'render_settings_page')
        );
    }
    
    /**
     * Register plugin settings
     */
    public function register_settings() {
        register_setting('elc_settings_group', 'elc_enable_email_notification', array(
            'type' => 'boolean',
            'default' => true,
            'sanitize_callback' => 'rest_sanitize_boolean'
        ));
        
        register_setting('elc_settings_group', 'elc_notification_email', array(
        'type' => 'string',
        'default' => get_option('admin_email'),
        'sanitize_callback' => array($this, 'sanitize_multiple_emails')
    ));

        
        register_setting('elc_settings_group', 'elc_notify_on_update', array(
            'type' => 'boolean',
            'default' => false,
            'sanitize_callback' => 'rest_sanitize_boolean'
        ));
        
        register_setting('elc_settings_group', 'elc_min_links_to_notify', array(
            'type' => 'integer',
            'default' => 1,
            'sanitize_callback' => 'absint'
        ));
    }
    
    /**
     * Render settings page
     */
    public function render_settings_page() {
        $enable_notification = get_option('elc_enable_email_notification', true);
        $notification_email = get_option('elc_notification_email', get_option('admin_email'));
        $notify_on_update = get_option('elc_notify_on_update', false);
        $min_links = get_option('elc_min_links_to_notify', 1);
        
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('External Links - Email Notification Settings', 'external-links-counter'); ?></h1>
            
            <form method="post" action="options.php">
                <?php settings_fields('elc_settings_group'); ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e('Enable Email Notifications', 'external-links-counter'); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="elc_enable_email_notification" value="1" <?php checked($enable_notification, true); ?>>
                                <?php esc_html_e('Send email notification when posts/pages with external links are created or published', 'external-links-counter'); ?>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Notification Email', 'external-links-counter'); ?></th>
                        <td>
                            <input type="text" name="elc_notification_email" value="<?php echo esc_attr($notification_email); ?>" class="regular-text">
                            <p class="description"><?php esc_html_e('Email address to receive notifications. Separate multiple emails with commas. Default is admin email.', 'external-links-counter'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Notify on Update', 'external-links-counter'); ?></th>
                        <td>
                            <label>
                                <input type="checkbox" name="elc_notify_on_update" value="1" <?php checked($notify_on_update, true); ?>>
                                <?php esc_html_e('Also send notification when existing posts/pages are updated with new external links', 'external-links-counter'); ?>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Minimum Links to Notify', 'external-links-counter'); ?></th>
                        <td>
                            <input type="number" name="elc_min_links_to_notify" value="<?php echo esc_attr($min_links); ?>" min="1" max="100" class="small-text">
                            <p class="description"><?php esc_html_e('Minimum number of external links required to trigger email notification.', 'external-links-counter'); ?></p>
                        </td>
                    </tr>
                </table>
                
                <?php submit_button(); ?>
            </form>
            
            <hr>
            
            <h2><?php esc_html_e('Test Email Notification', 'external-links-counter'); ?></h2>
            <p><?php esc_html_e('Click the button below to send a test email notification.', 'external-links-counter'); ?></p>
            <form method="post" action="">
                <?php wp_nonce_field('elc_test_email', 'elc_test_email_nonce'); ?>
                <input type="submit" name="elc_send_test_email" class="button button-secondary" value="<?php esc_attr_e('Send Test Email', 'external-links-counter'); ?>">
            </form>
            
            <?php
            // Handle test email
            if (isset($_POST['elc_send_test_email']) && wp_verify_nonce($_POST['elc_test_email_nonce'], 'elc_test_email')) {
                $test_result = $this->send_test_email();
                if ($test_result) {
                    echo '<div class="notice notice-success"><p>' . esc_html__('Test email sent successfully!', 'external-links-counter') . '</p></div>';
                } else {
                    echo '<div class="notice notice-error"><p>' . esc_html__('Failed to send test email. Please check your WordPress email configuration.', 'external-links-counter') . '</p></div>';
                }
            }
            ?>
        </div>
        <?php
    }
    
    /**
     * Send test email
     */
    private function send_test_email() {
        $notification_email = get_option('elc_notification_email', get_option('admin_email'));
        $site_name = get_bloginfo('name');
        
        $subject = sprintf(__('[%s] Test - External Links Notification', 'external-links-counter'), $site_name);
        
        $message = $this->get_email_template(array(
            'post_title' => 'Test Post Title',
            'post_type' => 'post',
            'post_status' => 'publish',
            'post_seo_status' => 'noindex, nofollow',
            'post_url' => home_url(),
            'edit_url' => admin_url(),
            'author_name' => 'Test Author',
            'external_links' => array(
                array('url' => 'https://example.com/page1', 'anchor_text' => 'Example Link 1', 'domain' => 'example.com', 'rel' => 'nofollow', 'seo_status' => 'nofollow'),
                array('url' => 'https://test.org/article', 'anchor_text' => 'Test Link', 'domain' => 'test.org', 'rel' => 'nofollow', 'seo_status' => 'nofollow'),
                array('url' => 'https://another-site.com', 'anchor_text' => '', 'domain' => 'another-site.com', 'rel' => 'nofollow', 'seo_status' => 'nofollow'),
            ),
            'is_test' => true
        ));
        
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        return wp_mail($notification_email, $subject, $message, $headers);
    }
    
    /**
     * Check for external links and send notification when post is saved
     */
    public function check_and_notify_external_links($post_id, $post, $update) {
        // Check if email notifications are enabled
        if (!get_option('elc_enable_email_notification', true)) {
            return;
        }
        
        // Skip autosaves
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        // Skip revisions
        if (wp_is_post_revision($post_id)) {
            return;
        }
        
        // Only process posts and pages
        if (!in_array($post->post_type, array('post', 'page'))) {
            return;
        }
        
        // Skip REST API batch requests (often used by duplicate plugins)
        if (defined('REST_REQUEST') && REST_REQUEST) {
            // Only allow if this is a publish action
            if ($post->post_status !== 'publish') {
                return;
            }
        }
        
        // Check if this is a duplicated post (from various duplicate plugins)
        if ($this->is_duplicated_post($post_id)) {
            // For duplicated posts, only notify when published for the first time
            $was_notified_on_publish = get_post_meta($post_id, '_elc_notified_on_publish', true);
            if ($was_notified_on_publish || $post->post_status !== 'publish') {
                // Update status tracking but don't send email
                update_post_meta($post_id, '_elc_previous_status', $post->post_status);
                return;
            }
        }
        
        // IMPORTANT: Only send notifications when post is PUBLISHED
        // Never send for draft, pending, or any other non-published status
        if ($post->post_status !== 'publish') {
            // Just track the status, don't send email for non-published posts
            update_post_meta($post_id, '_elc_previous_status', $post->post_status);
            return;
        }
        
        // Check if we should notify on updates
        $notify_on_update = get_option('elc_notify_on_update', false);
        
        // Get the previous status
        $old_status = get_post_meta($post_id, '_elc_previous_status', true);
        
        // Determine if this is a first-time publish
        $is_first_publish = empty($old_status) || $old_status !== 'publish';
        
        // Skip if this is an update to an already published post and update notifications are disabled
        if (!$is_first_publish && !$notify_on_update) {
            update_post_meta($post_id, '_elc_previous_status', $post->post_status);
            return;
        }
        
        // Get external links
        $external_links = $this->get_external_links($post_id);
        $link_count = count($external_links);
        
        // Check minimum links threshold
        $min_links = get_option('elc_min_links_to_notify', 1);
        if ($link_count < $min_links) {
            update_post_meta($post_id, '_elc_previous_status', $post->post_status);
            return;
        }
        
        // Check if we already sent notification for these links (to avoid duplicate emails)
        $previous_links_hash = get_post_meta($post_id, '_elc_links_hash', true);
        $current_links_hash = md5(serialize($external_links));
        
        if ($previous_links_hash === $current_links_hash) {
            return;
        }
        
        // Send the notification email
        $this->send_external_links_notification($post, $external_links, !$is_first_publish);
        
        // Store the hash to prevent duplicate emails
        update_post_meta($post_id, '_elc_links_hash', $current_links_hash);
        update_post_meta($post_id, '_elc_previous_status', $post->post_status);
        
        // Mark that we've notified for this post on publish (for duplicated posts tracking)
        update_post_meta($post_id, '_elc_notified_on_publish', true);
    }
    
    /**
     * Check if a post was created by a duplicate plugin
     * Supports: Yoast Duplicate Post, Duplicate Page, Post Duplicator, and others
     */
    private function is_duplicated_post($post_id) {
        // Yoast Duplicate Post / Duplicate Post plugin
        if (get_post_meta($post_id, '_dp_original', true)) {
            return true;
        }
        
        // Duplicate Page plugin
        if (get_post_meta($post_id, '_dp_is_rewrite_republish_copy', true)) {
            return true;
        }
        
        // Post Duplicator plugin
        if (get_post_meta($post_id, '_post_duplicator_original', true)) {
            return true;
        }
        
        // Clone Posts plugin
        if (get_post_meta($post_id, '_clone_post_original_id', true)) {
            return true;
        }
        
        // WP Starter / Starter Templates duplicate
        if (get_post_meta($post_id, '_starter_templates_imported', true)) {
            return true;
        }
        
        // Check for common duplicate action in URL (covers many plugins)
        if (isset($_REQUEST['action'])) {
            $action = sanitize_text_field($_REQUEST['action']);
            $duplicate_actions = array(
                'duplicate_post',
                'duplicate_post_as_draft',
                'duplicate_page',
                'clone_post',
                'copy_post',
                'dt_duplicate_post',
                'duplicate-post',
                'duplicate_post_save_as_new_post_draft',
            );
            if (in_array($action, $duplicate_actions, true)) {
                return true;
            }
        }
        
        // Check if post was created via duplicate REST endpoint
        if (isset($_REQUEST['meta']) && is_array($_REQUEST['meta'])) {
            foreach ($_REQUEST['meta'] as $meta) {
                if (isset($meta['key']) && strpos($meta['key'], 'duplicate') !== false) {
                    return true;
                }
            }
        }
        
        return false;
    }
    
    /**
     * Send external links notification email
     */
    private function send_external_links_notification($post, $external_links, $is_update) {
        $notification_emails = get_option('elc_notification_email', get_option('admin_email'));
        $emails_array = array_map('trim', explode(',', $notification_emails));
        
        $site_name = get_bloginfo('name');
        $author = get_userdata($post->post_author);
        
        $action_text = $is_update ? __('Updated', 'external-links-counter') : __('Created', 'external-links-counter');
        $type_text = $post->post_type === 'page' ? __('Page', 'external-links-counter') : __('Post', 'external-links-counter');
        
        // Get SEO status from SEO plugin
        $post_seo_status = $this->get_post_seo_status($post->ID);
        
        $subject = sprintf(
            __('[%s] External Links Alert: %s %s - "%s" contains %d external link(s)', 'external-links-counter'),
            $site_name,
            $type_text,
            $action_text,
            $post->post_title,
            count($external_links)
        );
        
        $message = $this->get_email_template(array(
            'post_title' => $post->post_title,
            'post_type' => $type_text,
            'post_status' => $post->post_status,
            'post_seo_status' => $post_seo_status,
            'post_url' => get_permalink($post->ID),
            'edit_url' => get_edit_post_link($post->ID, 'raw'),
            'detail_url' => admin_url('admin.php?page=external-links-detail&post_id=' . $post->ID),
            'author_name' => $author ? $author->display_name : __('Unknown', 'external-links-counter'),
            'external_links' => $external_links,
            'is_update' => $is_update,
            'is_test' => false
        ));
        
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        // Send to all email addresses
        foreach ($emails_array as $email) {
            if (is_email($email)) {
                wp_mail($email, $subject, $message, $headers);
            }
        }
    }
    
    /**
     * Get email template
     * ALL EXTERNAL LINKS SHOWN AS RED/NOFOLLOW
     */
    private function get_email_template($data) {
        $site_name = get_bloginfo('name');
        $link_count = count($data['external_links']);
        
        // Group links by domain
        $domains = array();
        foreach ($data['external_links'] as $link) {
            $domain = $link['domain'];
            if (!isset($domains[$domain])) {
                $domains[$domain] = array();
            }
            $domains[$domain][] = $link;
        }
        
        $status_text = isset($data['post_status']) ? ucfirst($data['post_status']) : 'Published';
        $action_text = !empty($data['is_test']) ? __('Test Notification', 'external-links-counter') : 
                       (!empty($data['is_update']) ? __('Updated', 'external-links-counter') : __('New', 'external-links-counter'));
        
        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif; background-color: #f5f5f5;">
            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 20px 0;">
                <tr>
                    <td align="center">
                        <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            <!-- Header -->
                            <tr>
                                <td style="background-color: #2271b1; color: #ffffff; padding: 30px; border-radius: 8px 8px 0 0;">
                                    <h1 style="margin: 0; font-size: 24px; font-weight: 600;">
                                        🔗 <?php esc_html_e('External Links Alert', 'external-links-counter'); ?>
                                    </h1>
                                    <p style="margin: 10px 0 0; opacity: 0.9; font-size: 14px;">
                                        <?php echo esc_html($site_name); ?>
                                    </p>
                                </td>
                            </tr>
                            
                            <!-- Alert Banner -->
                            <tr>
                                <td style="background-color: #fff3cd; border-left:4px solid #ffc107;padding:15px 30px">
                                    <p style="margin:0; color: #856404; font-size:14px">
                                        <strong>⚠️ <?php echo esc_html($action_text); ?> <?php echo esc_html($data['post_type']); ?>:</strong>
                                        <?php printf(
                                            esc_html__('This content contains %d external link(s) - ALL MODIFIED TO INCLUDE NOFOLLOW', 'external-links-counter'),
                                            $link_count
                                        ); ?>
                                    </p>
                                </td>
                            </tr>
                            
                            <!-- Post Details -->
                            <tr>
                                <td style="padding: 30px;">
                                    <h2 style="margin: 0 0 20px; font-size: 18px; color: #1d2327; border-bottom: 2px solid #2271b1; padding-bottom: 10px;">
                                        <?php esc_html_e('Content Details', 'external-links-counter'); ?>
                                    </h2>
                                    
                                    <?php 
                                    // Get SEO status and colors
                                    $post_seo_status = isset($data['post_seo_status']) ? $data['post_seo_status'] : 'index, follow';
                                    $seo_colors = $this->get_seo_status_colors($post_seo_status);
                                    ?>
                                    <table width="100%" cellpadding="8" cellspacing="0" style="margin-bottom: 20px;">
                                        <tr>
                                            <td width="120" style="color: #646970; font-weight: 600;"><?php esc_html_e('Title:', 'external-links-counter'); ?></td>
                                            <td style="color: #1d2327;"><?php echo esc_html($data['post_title']); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="color: #646970; font-weight: 600;"><?php esc_html_e('Type:', 'external-links-counter'); ?></td>
                                            <td style="color: #1d2327;"><?php echo esc_html($data['post_type']); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="color: #646970; font-weight: 600;"><?php esc_html_e('Status:', 'external-links-counter'); ?></td>
                                            <td>
                                                <span style="display: inline-block; padding: 2px 8px; background-color: <?php echo $status_text === 'Publish' ? '#d4edda' : '#ffc107'; ?>; color: <?php echo $status_text === 'Publish' ? '#155724' : '#856404'; ?>; border-radius: 3px; font-size: 12px;">
                                                    <?php echo esc_html($status_text); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="color: #646970; font-weight: 600;"><?php esc_html_e('Author:', 'external-links-counter'); ?></td>
                                            <td style="color: #1d2327;"><?php echo esc_html($data['author_name']); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="color: #646970; font-weight: 600;"><?php esc_html_e('External Links:', 'external-links-counter'); ?></td>
                                            <td>
                                                <span style="display: inline-block; padding: 4px 12px; background-color: <?php echo $link_count > 5 ? '#f44336' : ($link_count > 2 ? '#ff9800' : '#4caf50'); ?>; color: #ffffff; border-radius: 4px; font-weight: bold;">
                                                    <?php echo esc_html($link_count); ?>
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    <!-- Action Buttons -->
                                    <?php if (empty($data['is_test'])) : ?>
                                    <p style="margin: 20px 0;">
                                        <a href="<?php echo esc_url($data['edit_url']); ?>" style="display: inline-block; padding: 10px 20px; background-color: #2271b1; color: #ffffff; text-decoration: none; border-radius: 4px; margin-right: 10px;">
                                            <?php esc_html_e('Edit Content', 'external-links-counter'); ?>
                                        </a>
                                        <a href="<?php echo esc_url($data['detail_url']); ?>" style="display: inline-block; padding: 10px 20px; background-color: #50575e; color: #ffffff; text-decoration: none; border-radius: 4px; margin-right: 10px;">
                                            <?php esc_html_e('View Links Detail', 'external-links-counter'); ?>
                                        </a>
                                        <a href="<?php echo esc_url($data['post_url']); ?>" style="display: inline-block; padding: 10px 20px; background-color: #ffffff; color: #2271b1; text-decoration: none; border-radius: 4px; border: 1px solid #2271b1;">
                                            <?php esc_html_e('View Content', 'external-links-counter'); ?>
                                        </a>
                                    </p>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            
                            <!-- External Links List -->
                            <tr>
                                <td style="padding: 0 30px 30px;">
                                    <h2 style="margin: 0 0 20px; font-size: 18px; color: #1d2327; border-bottom: 2px solid #2271b1; padding-bottom: 10px;">
                                        <?php esc_html_e('External Links Found', 'external-links-counter'); ?> (<?php echo esc_html($link_count); ?>)
                                    </h2>
                                    
                                    <!-- Summary by Domain -->
                                    <div style="background-color: #f0f6fc; border-radius: 4px; padding: 15px; margin-bottom: 20px;">
                                        <p style="margin: 0 0 10px; font-weight: 600; color: #1d2327;">
                                            <?php esc_html_e('Domains Summary:', 'external-links-counter'); ?>
                                        </p>
                                        <?php foreach ($domains as $domain => $links) : ?>
                                            <span style="display: inline-block; padding: 4px 10px; background-color: #e3f2fd; color: #1565c0; border-radius: 3px; margin: 2px 4px 2px 0; font-size: 13px;">
                                                <?php echo esc_html($domain); ?> (<?php echo count($links); ?>)
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                    <!-- Links Table -->
                                    <table width="100%" cellpadding="0" cellspacing="0" style="border: 1px solid #e0e0e0; border-radius: 4px; overflow: hidden;">
                                        <tr style="background-color: #f5f5f5;">
                                            <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #1d2327; font-size: 13px;">#</th>
                                            <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #1d2327; font-size: 13px;"><?php esc_html_e('Anchor Text', 'external-links-counter'); ?></th>
                                            <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #1d2327; font-size: 13px;"><?php esc_html_e('URL', 'external-links-counter'); ?></th>
                                            <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #1d2327; font-size: 13px;"><?php esc_html_e('Domain', 'external-links-counter'); ?></th>
                                            <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; color: #1d2327; font-size: 13px;"><?php esc_html_e('SEO Status', 'external-links-counter'); ?></th>
                                        </tr>
                                        <?php foreach ($data['external_links'] as $index => $link) : 
                                            // Use the actual status detected by the plugin
                                            $seo_status = $link['seo_status'];
                                            $seo_colors = $this->get_seo_status_colors($seo_status);
                                        ?>
                                            <tr style="<?php echo ($index % 2 === 0) ? 'background-color: #ffffff;' : 'background-color: #fafafa;'; ?>">
                                                <td style="padding: 12px; border-bottom: 1px solid #e0e0e0; font-size: 13px; color: #646970;">
                                                    <?php echo esc_html($index + 1); ?>
                                                </td>
                                                <td style="padding: 12px; border-bottom: 1px solid #e0e0e0; font-size: 13px; color: #1d2327;">
                                                    <?php echo esc_html($link['anchor_text'] ?: __('(no anchor text)', 'external-links-counter')); ?>
                                                </td>
                                                <td style="padding: 12px; border-bottom: 1px solid #e0e0e0; font-size: 13px; word-break: break-all;">
                                                    <a href="<?php echo esc_url($link['url']); ?>" style="color: #2271b1; text-decoration: none;" target="_blank">
                                                        <?php echo esc_html($link['url']); ?>
                                                    </a>
                                                </td>
                                                <td style="padding: 12px; border-bottom: 1px solid #e0e0e0; font-size: 13px;">
                                                    <span style="display: inline-block; padding: 2px 8px; background-color: #e3f2fd; color: #1565c0; border-radius: 3px; font-size: 12px;">
                                                        <?php echo esc_html($link['domain']); ?>
                                                    </span>
                                                </td>
                                                <td style="padding: 12px; border-bottom: 1px solid #e0e0e0; font-size: 13px;">
                                                    <span style="display: inline-block; padding: 4px 10px; background-color: <?php echo esc_attr($seo_colors['bg']); ?>; color: <?php echo esc_attr($seo_colors['text']); ?>; border-radius: 3px; font-size: 12px; font-weight: 600;">
                                                        <?php echo esc_html($seo_status); ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </td>
                            </tr>
                            
                            <!-- Footer -->
                            <tr>
                                <td style="background-color: #f0f0f1; padding: 20px 30px; border-radius: 0 0 8px 8px; text-align: center;">
                                    <p style="margin: 0; color: #646970; font-size: 12px;">
                                        <?php printf(
                                            esc_html__('This email was sent by the External Links Counter plugin on %s.', 'external-links-counter'),
                                            esc_html($site_name)
                                        ); ?>
                                    </p>
                                    <p style="margin: 10px 0 0; color: #646970; font-size: 12px;">
                                        <a href="<?php echo esc_url(admin_url('admin.php?page=external-links-settings')); ?>" style="color: #2271b1; text-decoration: none;">
                                            <?php esc_html_e('Manage notification settings', 'external-links-counter'); ?>
                                        </a>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}

// Initialize the plugin
new External_Links_Counter();
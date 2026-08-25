<?php
/**
 * Plugin Name: Contact Form 7 and WeekMate CRM Integration
 * Description: Create WeekMate CRM Leads
 * Version: 1.1
 * Author: WeekMate
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('wpcf7_before_send_mail', 'cf7_custom_after_submission_action');
function cf7_custom_after_submission_action($contact_form) {

    $excluded_forms = array( 3316 );
    if ( in_array( $contact_form->id(), $excluded_forms, true ) ) {
        return;
    }

    $submission = WPCF7_Submission::get_instance();
    if ($submission) {
        $posted_data = $submission->get_posted_data();

        $posted_data['form_id']         = $contact_form->id();
        $posted_data['source_site']     = str_replace('www.', '', $_SERVER['HTTP_HOST']);
        $posted_data['source']          = cf7_get_lead_source();
        $posted_data['user_ip_address'] = cf7_get_client_ip();

        $url = 'https://partners.weekmate.in/api/public/leads?apiKey=fqHnqj9OwKp0olGlSp7d25gMO2hBa0JE';

        $args = array(
            'timeout' => 5,
            'headers' => array(
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode($posted_data)
        );

        $response = wp_remote_post($url, $args);
    }
}

/**
 * Work out where this lead came from.
 * Priority: explicit utm_source (captured at entry) > referrer domain > Google (default)
 */
function cf7_get_lead_source() {
    if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
        session_start();
    }

    // 1. Session-based utm_source (works when session persists correctly)
    if (!empty($_SESSION['utm_source'])) {
        return sanitize_text_field($_SESSION['utm_source']);
    }

    $referrer = isset($_SESSION['referrer_url']) ? $_SESSION['referrer_url'] : '';

    if (!empty($referrer) && $referrer !== 'Direct Entry (No Referrer)') {
        // 2. Try pulling utm_source out of the referrer's own query string
        $query = parse_url($referrer, PHP_URL_QUERY);
        if ($query) {
            parse_str($query, $params);
            if (!empty($params['utm_source'])) {
                return sanitize_text_field($params['utm_source']);
            }
        }

        // 3. Fall back to referrer host (only if it's a different domain)
        $host = parse_url($referrer, PHP_URL_HOST);
        $current_host = str_replace('www.', '', $_SERVER['HTTP_HOST'] ?? '');
        if ($host && strtolower(str_replace('www.', '', $host)) !== strtolower($current_host)) {
            return strtolower(str_replace('www.', '', $host));
        }
    }

    return 'Google';
}

/**
 * Get real client IP, accounting for common proxy/CDN headers.
 */
function cf7_get_client_ip() {
    $headers = array(
        'HTTP_CF_CONNECTING_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_REAL_IP',
        'REMOTE_ADDR',
    );

    foreach ($headers as $header) {
        if (!empty($_SERVER[$header])) {
            $ip_list = explode(',', $_SERVER[$header]);
            $ip = trim($ip_list[0]);
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }

    return 'Unknown';
}
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
		
		$error = '';

		// Timeout / DNS / SSL / Connection errors
		if (is_wp_error($response)) {

			$error = $response->get_error_message();

		} else {

			$http_code = wp_remote_retrieve_response_code($response);
			$body       = wp_remote_retrieve_body($response);

			// HTTP error
			if ($http_code != 200 && $http_code != 201) {

				$error = "HTTP {$http_code}\n\nResponse:\n{$body}";

			} else {

				$result = json_decode($body, true);

				// Invalid JSON
				if (!is_array($result)) {

					$error = "Invalid API response:\n{$body}";

				}
				// API returned failure
				elseif ($result['status'] == 0) {

					$error = $result['message'] ?? 'Unknown API error';
				}
			}
		}

		// Send email only if there was an error
		if (!empty($error)) {

			$message  = "CRM Lead API Error.\n\n";
			$message .= "Website: " . home_url() . "\n";
			$message .= "Form ID: " . $contact_form->id() . "\n";
			$message .= "Error: " . $error . "\n\n";
			$message .= "Submitted Data:\n";
			$message .= print_r($posted_data, true);

			wp_mail(
				'pankaj@elsner.com, tarun@elsner.com, sales@weekmate.in',
				'CRM Lead API Failed - ' . home_url(),
				$message
			);
		}
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

    $entry_url = isset($_SESSION['entry_url']) ? $_SESSION['entry_url'] : '';

    if (!empty($entry_url)) {
        // 1. Try pulling utm_source out of the entry_url's query string
        $query = parse_url($entry_url, PHP_URL_QUERY);
        if ($query) {
            parse_str($query, $params);
            if (!empty($params['utm_source'])) {
                return sanitize_text_field($params['utm_source']);
            }
            if (!empty($params['gclid'])) {
                return 'google_ads';
            }
        }

        // 2. Fall back to entry_url's own host (only if it's a different domain)
        $host = parse_url($entry_url, PHP_URL_HOST);
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
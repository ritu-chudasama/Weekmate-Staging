<?php

// Declare a global variable to store tracking data
global $tracking_data;
$tracking_data = array();

// Initialize tracking data on every page load
add_action('init', 'initialize_tracking_data');
function initialize_tracking_data()
{
    global $tracking_data;

    // Start the session if not started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Capture Entry URL (only set on first visit)
    if (!isset($_SESSION['entry_url'])) {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
        $current_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $_SESSION['entry_url'] = $current_url;
    }

    // Capture Referrer URL
    // if (!isset($_SESSION['referrer_url'])) {
    //     $_SESSION['referrer_url'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'Direct Entry (No Referrer)';
    // }

    // Load data into the global variable
    $tracking_data['entry_url'] = $_SESSION['entry_url'];
    // $tracking_data['referrer_url'] = $_SESSION['referrer_url'];
    $tracking_data['exit_url'] = isset($_SESSION['exit_url']) ? $_SESSION['exit_url'] : 'https://weekmate.in/thank-you/';
    $tracking_data['user_ip_address'] = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'Unknown';
}

// Add tracking data to form submissions
add_filter('cfdb7_before_save_data', 'add_tracking_data_to_form', 10, 1);
function add_tracking_data_to_form($form_data)
{
    global $tracking_data;

    // Merge global tracking data into form data
    $form_data = array_merge($form_data, $tracking_data);

    // Clear session data after saving
    clear_tracking_session();

    return $form_data;
}

// Clear tracking session data after saving
function clear_tracking_session()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    unset($_SESSION['entry_url']);
    // unset($_SESSION['referrer_url']);
    unset($_SESSION['exit_url']);
}

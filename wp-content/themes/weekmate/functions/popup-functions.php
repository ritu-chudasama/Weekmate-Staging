<?php

// Popup form on multiple pages with custom text
add_action('wp_footer', 'weekmate_popup_form');
function weekmate_popup_form() {

    // Define multiple pages and popup data
    $pages = [
        'front-page' => [
            'condition' => is_front_page(),
            'heading' => "One Platform. Every Workplace Solution.",
            'subheading' => "Get a free trial.",
            'form' => '[contact-form-7 id="0fc7aef" title="Home Page Popup Form"]',
            'image' => get_theme_file_uri('/images/popup-form/weekmate-popup-formimage.png')
        ],
        'hrms' => [
            'condition' => is_page('hrms'),
            'heading' => "Smart HRMS for Hassle-Free Payroll",
            'subheading' => "Get a free trial.",
            'form' => '[contact-form-7 id="b28709b" title="HRMS Page Popup Form"]',
            'image' => get_theme_file_uri('/images/popup-form/weekmate-popup-formimage.png')
        ],
        'taskhub' => [
            'condition' => is_page('taskhub'),
            'heading' => "Simplify Project Management Effortlessly",
            'subheading' => "Get a free trial.",
            'form' => '[contact-form-7 id="049fd59" title="Taskhub Page Popup Form"]',
            'image' => get_theme_file_uri('/images/popup-form/weekmate-popup-formimage.png')
        ],
        'e-crm' => [
            'condition' => is_page('e-crm'),
            'heading' => "Boost Customer Relationships with Smarter e-CRM ",
            'subheading' => "Get a free trial.",
            'form' => '[contact-form-7 id="8e4152a" title="ECRM Page Popup Form"]',
            'image' => get_theme_file_uri('/images/popup-form/weekmate-popup-formimage.png')
        ],
        'e-connect' => [
            'condition' => is_page('e-connect'),
            'heading' => "Bring Your Team Together in One Click",
            'subheading' => "Get a free trial.",
            'form' => '[contact-form-7 id="daf8025" title="E-Connect Page Popup Form"]',
            'image' => get_theme_file_uri('/images/popup-form/weekmate-popup-formimage.png')
        ],
        'email-marketing-tool' => [
            'condition' => is_page('email-marketing-tool'),
            'heading' => "Send Smarter Emails. Get Better Results. 📧",
            'subheading' => "Get a free trial.",
            'form' => '[contact-form-7 id="f05fcca" title="Email Marketing Tool Page Popup Form"]',
            'image' => get_theme_file_uri('/images/popup-form/weekmate-popup-formimage.png')
        ],
        // 'cpt-single' => [
        //     'condition' => is_singular('freetools') || is_post_type_archive('freetools'),
        //     'heading' => "Get a Free Trial",
        //     'subheading' => "Talk to our experts today.",
        //     'form' => '[contact-form-7 id="bc7d83b" title="Freetools Popup Form"]',
        //     'image' => get_theme_file_uri('/images/popup-form/weekmate-popup-formimage.png')
        // ],

        
    ];

    $data = null;

    // Check which page we are on
    foreach ($pages as $key => $page) {
    if ($page['condition']) {
        $data = $page;
        $popup_id = $key; // store key
        break;
    }
}

    if (!$data) return; // no matching page → no popup
    ?>

    <div id="weekmate-popup-overlay" data-popup-id="<?php echo esc_attr($popup_id); ?>">
        <div id="weekmate-popup">
            <div class="wk-left">
                <img src=<?php echo esc_url($data['image'])?> alt="Phone Mockup">
            </div>
            <div class="wk-right">
            <div class="wk-content">
            <h3>
                <?php echo esc_html($data['heading']); ?>
            </h3>
                <p class="subtitle"><?php echo esc_html($data['subheading']); ?></p>
                <?php echo do_shortcode($data['form']); ?>
            </div>
            </div>

            
        </div>
    </div>

    <?php
}

add_filter('wpcf7_validate_phonetext*', 'custom_phonetext_validation', 20, 2);
add_filter('wpcf7_validate_phonetext', 'custom_phonetext_validation', 20, 2);

function custom_phonetext_validation($result, $tag) {

    $name = $tag->name;

    // match CF7 field name
    if ($name === 'phonetext') {

        $phone = isset($_POST[$name]) ? sanitize_text_field($_POST[$name]) : '';

        // 1️⃣ Must contain only numbers
        if (!ctype_digit($phone)) {
            $result->invalidate($tag, "Phone number must contain digits only");
            return $result;
        }

        // Minimum validation check
        if ( empty($phone) || strlen($phone) < 10 || strlen($phone) > 15) {
            $result->invalidate($tag, "Please enter a valid phone number");
        }
    }

    return $result;
}

add_filter('wpcf7_validate_email', 'custom_email_validation', 20, 2);
add_filter('wpcf7_validate_email*', 'custom_email_validation', 20, 2);

function custom_email_validation($result, $tag) {

    $name = $tag->name;

    if ($name === 'your-email') { // Change this to your field name

        $email = isset($_POST[$name]) ? sanitize_email($_POST[$name]) : '';

        // First: check normal email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $result->invalidate($tag, "Please enter a valid email address");
            return $result;
        }

        // Extract TLD (.com /.in /.org etc.)
        $tld = strtolower(pathinfo($email, PATHINFO_EXTENSION));

        // Allowed valid TLDs
        $allowed_tlds = array(
            'com', 'in', 'org', 'net', 'edu', 'info', 
            'gov', 'co.in', 'us', 'uk', 'io'
        );

        // Additional check for multi-part TLDs (.co.in)
        if (!in_array($tld, $allowed_tlds)) {

            // Special handling for ".co.in"
            if (!preg_match('/\.co\.in$/', $email)) {
                $result->invalidate($tag, "Please enter a valid email address");
                return $result;
            }
        }
    }

    return $result;
}




